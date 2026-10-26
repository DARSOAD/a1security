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
