# Security quote landings — local implementation, 2026-11-24

Shared template: `page-security-quote.php`; service content: `quote-content.php` (distribution copy; canonical source is the marketing workspace `content_factory/linkedin_posts/2026-12/landings/`). Local pages: venue-security-quote (274), hotel-security-quote (275). These IDs are local only.

Receiver: `quote-request.php`, shared `a1_contact_deliver()` transport. New durable ledger and inbox under Tools → Security quote requests (manage_options). Legacy behavior remains transient-based. Test requests are clearly identified LOCAL QA and never counted as leads.

Checks: PHP validation/regression suites, real local HTTP and concurrency tests, Edge 390/1440 and actual local browser submissions. Detailed evidence, screenshots, references and launch dependencies are in the marketing workspace `campaigns/linkedin-ads/2026-12/qa-landings.md`.

HubSpot browser collection is excluded on this template; an authenticated CRM sync has NOT been implemented or verified. Only the shared email transport and durable WordPress inbox are implemented. No LinkedIn conversion ID was invented.

Do not launch without the published privacy policy and external receipt/CRM acceptance. Public privacy-policy currently returns 404; local page 3 is draft. Local mail/tracking are blocked. `wp_mail(true)` is not proof of inbox delivery. Record retention needs agreement before launch.

Deployment follows main → origin/main → existing FTP workflow. Preserve unrelated header/style edits. Theme deployment does not create the WordPress pages: create each slug and assign this template only after verifying collisions. Exclude both routes from page caching and verify the public HTML, policy link and identified receipt.

If a durable record has `in_flight`, or a request mutex remains after a worker crash, reconcile the email reference with the recipients before clearing it. Do not blindly delete ledger state and retry. The durable record keys are `a1_quote_record_*`, mutexes `a1_quote_lock_*`; values contain private request data. Keep them out of public logs and exports.
