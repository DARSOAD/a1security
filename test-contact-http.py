"""Local WordPress integration checks. Local mu-plugin suppresses real mail."""
import urllib.error
import urllib.parse
import urllib.request

BASE = 'http://localhost:8080'

def request(path, fields=None):
    body = urllib.parse.urlencode(fields).encode() if fields is not None else None
    try:
        response = urllib.request.urlopen(BASE + path, data=body, timeout=40)
    except urllib.error.HTTPError as error:
        response = error
    return response.status, response.geturl(), response.read().decode(), response.headers


# New quote route must render a real form, never a success state on direct GET.
import json
import re
import uuid

for path, service in [('/venue-security-quote/', 'S02'), ('/hotel-security-quote/', 'S03')]:
    status, _, markup, headers = request(path)
    assert status == 200 and 'id="quote-form"' in markup, 'Quote landing must resolve to the shared commercial form'
    assert 'no-store' in headers['Cache-Control']
    nonce = re.search(r'name="quote_nonce" value="([^"]+)"', markup)[1]
    fields = dict(action='a1_security_quote', quote_nonce=nonce, origin_service=service, request_id=uuid.uuid4().hex,
                  firstname='LOCAL QA QUOTE HTTP', email='local-quote@example.com', phone='', company='LOCAL QA TEST ' + uuid.uuid4().hex[:8],
                  location='Manhattan, NYC', service=service, coverage_type='both', message='LOCAL QA ONLY - DO NOT COUNT AS LEAD',
                  event_start='2026-12-03T22:00', event_end='2026-12-04T02:00', utm_source='linkedin', utm_medium='paid_social',
                  utm_campaign='a1_s02_quote_202612', utm_content='n1')
    bad = fields | {'email': 'invalid'}
    status, _, result, _ = request('/wp-admin/admin-ajax.php', bad)
    assert status == 422 and 'email' in json.loads(result)['data']['errors']
    status, _, result, _ = request('/wp-admin/admin-ajax.php', fields | {'website': 'spam'})
    assert status == 422
    status, _, result, _ = request('/wp-admin/admin-ajax.php', fields | {'quote_nonce': 'invalid'})
    assert status == 403
    status, _, result, _ = request('/wp-admin/admin-ajax.php', fields)
    received = json.loads(result)
    assert status == 200 and received['success'], (status, result)
    status, _, duplicate, _ = request('/wp-admin/admin-ajax.php', fields)
    assert status == 200 and json.loads(duplicate)['data']['id'] == received['data']['id']
    status, _, duplicate, _ = request('/wp-admin/admin-ajax.php', fields | {'request_id': uuid.uuid4().hex})
    assert status == 200 and json.loads(duplicate)['data']['id'] == received['data']['id']
    status, _, conflict, _ = request('/wp-admin/admin-ajax.php', fields | {'message': 'Changed payload'})
    assert status == 409
    print('PASS: quote HTTP', path, 'validation, nonce, honeypot, optional phone, overnight, receipt and duplicates', received['data']['id'], flush=True)

from concurrent.futures import ThreadPoolExecutor
fields['company'] = 'LOCAL QA CONCURRENT ' + uuid.uuid4().hex[:8]
fields['request_id'] = uuid.uuid4().hex
with ThreadPoolExecutor(max_workers=3) as pool:
    concurrent_results = list(pool.map(lambda _: request('/wp-admin/admin-ajax.php', fields), range(3)))
assert all(item[0] in (200, 409) for item in concurrent_results)
accepted_ids = {json.loads(item[2])['data']['id'] for item in concurrent_results if item[0] == 200}
assert len(accepted_ids) == 1, concurrent_results
print('PASS: concurrent quote submissions return one stable receipt', accepted_ids.pop(), flush=True)

status, _, text, headers = request('/thanks/')
assert status == 200 and 'conversion' not in text and 'no-store' in headers['Cache-Control']
print('PASS: direct GET does not claim success or emit conversion', flush=True)
status, _, text, _ = request('/?page_id=33', {'tipo': 'registrarse', 'hs_google_click_id': 'LOCAL-QA'})
assert status == 422 and 'conversion' not in text
print('PASS: GCLID-only POST rejected with 422', flush=True)
status, url, text, _ = request('/?page_id=33', {
    'tipo': 'registrarse', 'firstname': 'LOCAL QA CONTACT', 'phone': '+1 202 555 0100',
    'email': 'local-qa@example.com', 'service': 'Executive Protection',
    'message': 'LOCAL TEST ONLY', 'hs_google_click_id': 'LOCAL-QA-NOT-AN-AD-CLICK',
})
assert status == 200 and '/thanks/?receipt=' in url and 'Your request has been submitted.' in text
print('PASS: valid POST redirects to success receipt (mail blocked locally)', flush=True)
status, _, text, _ = request(url.removeprefix(BASE))
assert status == 200 and 'Your request has been submitted.' not in text and 'conversion' not in text
print('PASS: receipt cannot be reused', flush=True)
