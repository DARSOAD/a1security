# Contact form repair — 2026-10-26

## Change

- Shared WordPress receiver validates name, phone and real email, and accepts legacy Spanish field names.
- Notifications use `wp_mail` independently for `a1securenyc@gmail.com` and `diegoanrora@gmail.com`. Reply-To is the visitor email. No automatic visitor email is sent.
- VIP requests a real email, uses `service` instead of overwriting company, and retains HubSpot portal 51992513.
- The three landing pages use standard submit inputs with no custom submit listeners, compatible with HubSpot collected forms. The existing WordPress HubSpot plugin remains responsible for collection on the landing pages.
- Successful email handoff redirects to a random, short-lived, single-use receipt. GET visits, invalid submissions and failed email handoffs do not emit Ads conversions. Google Ads receives a transaction ID to deduplicate retries.
- The receipt page explicitly loads HubSpot and identifies the visitor with their real email and nonempty GCLID. This supplements collected forms, which does not collect hidden fields. It is not an authenticated server-side HubSpot Forms API integration.
- Receipts use no-store/private headers. Raw contact values are not put in URLs. Retries within ten minutes reuse the delivery ID and skip successful recipients.

## Checks completed locally

- PHP syntax checks for all changed production files.
- `php test-contact-delivery.php`: legacy mapping, invalid payloads, exact recipients, partial delivery/retry, duplicate requests, one-use receipt, conditional tracking.
- `php test-executive-protection.php`: layout isolation and updated four-field form contract.
- `python test-contact-http.py`: real local WordPress GET/POST, 422 rejection, redirect to receipt, refresh without repeat success.
- Playwright: VIP rendered at 390px and 1440px; document widths match viewport, four required inputs and expected submit control.
- Local WordPress blocks outbound mail and tracking; these tests do not send real messages or create real CRM contacts.

## Production acceptance still required

1. Deploy only the contact changes on top of current production; preserve unrelated work.
2. Purge the affected cached landing/thank-you pages. Ensure caching excludes `/thanks/` and `/gracias/` including receipt query strings. PHP cache headers alone do not override an upstream cached response.
3. Confirm direct GET to `/thanks/`, `/?page_id=33` and `/gracias/` emits no conversion.
4. Submit a clearly marked, authorized test from VIP with a real controlled email, without a real Google Ads click ID. Confirm both Gmail inboxes, a HubSpot contact and the service submission details. Separately verify GCLID mapping with a clearly identified QA value.
5. Confirm the conversion fires only on successful submit and not reload/direct navigation. Remove/exclude test data in reporting as appropriate; do not call tests real leads.

`wp_mail(true)` means the mail transport accepted the message, not inbox delivery. HubSpot collection still depends on the visitor browser and tracking consent/blockers; actual CRM receipt cannot be verified from local tests. Historical empty emails cannot be recovered by changing the receiver, and their campaign attribution remains unproven.
