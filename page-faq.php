<?php
/**
 * Template Name: FAQ
 * Description: FAQ page with Schema.org FAQPage structured data for GEO optimization.
 */
get_header('page'); ?>

<!-- FAQPage Schema.org JSON-LD -->
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "FAQPage",
	"mainEntity": [
		{
			"@type": "Question",
			"name": "What is the difference between a standard bouncer and a premium nightlife security officer in Manhattan?",
			"acceptedAnswer": {
				"@type": "Answer",
				"text": "A standard bouncer relies on physical force, which drastically increases a venue's civil liability and risks its liquor license. A1 Security provides hospitality-trained nightlife security officers who excel in strict de-escalation, advanced ID verification, VIP guest management, and proactive crowd control, ensuring safety without alienating high-net-worth clientele."
			}
		},
		{
			"@type": "Question",
			"name": "What defines a premium residential doorman for luxury condos in NYC?",
			"acceptedAnswer": {
				"@type": "Answer",
				"text": "A premium residential doorman is a 5-star concierge and brand ambassador for the building. A1 Security officers wear tailored business attire and are expertly trained in seamless package management, strict vendor access control, and high-end tenant relations, completely elevating the residential experience beyond standard security guard services."
			}
		},
		{
			"@type": "Question",
			"name": "What certifications do A1 Security nightlife and residential guards hold?",
			"acceptedAnswer": {
				"@type": "Answer",
				"text": "All A1 Security professionals are fully licensed by the NYS Department of State. Furthermore, our nightlife teams receive specialized training in non-violent conflict resolution, crowd dynamics, and hospitality, ensuring full compliance with NYC regulations while maintaining the elite atmosphere of your venue or residential lobby."
			}
		}
	]
}
</script>

<section id="contenido" class="pc-centrad-supergrande tb-centrado-grande mv-centrado-super-grande">
	<h1>Frequently Asked Questions</h1>
	<div class="pc-centrado-extraGrande tb-centrado-superGrande mv-centrado-superGrande" style="margin-bottom: 100px !important;">

		<div class="faq-section" style="padding: 40px 0; max-width: 960px; margin: 0 auto !important;">

			<div class="faq-item" style="margin-bottom: 30px !important; border-bottom: 1px solid #ddd; padding-bottom: 25px !important;">
				<h2 style="font-size: 1.25rem; color: #1a1a1a; margin-bottom: 12px !important;">What is the difference between a standard bouncer and a premium nightlife security officer in Manhattan?</h2>
				<p style="font-size: 1rem; line-height: 1.8; color: #333;">A standard bouncer relies on physical force, which drastically increases a venue's civil liability and risks its liquor license. A1 Security provides hospitality-trained nightlife security officers who excel in strict de-escalation, advanced ID verification, VIP guest management, and proactive crowd control, ensuring safety without alienating high-net-worth clientele.</p>
			</div>

			<div class="faq-item" style="margin-bottom: 30px !important; border-bottom: 1px solid #ddd; padding-bottom: 25px !important;">
				<h2 style="font-size: 1.25rem; color: #1a1a1a; margin-bottom: 12px !important;">What defines a premium residential doorman for luxury condos in NYC?</h2>
				<p style="font-size: 1rem; line-height: 1.8; color: #333;">A premium residential doorman is a 5-star concierge and brand ambassador for the building. A1 Security officers wear tailored business attire and are expertly trained in seamless package management, strict vendor access control, and high-end tenant relations, completely elevating the residential experience beyond standard security guard services.</p>
			</div>

			<div class="faq-item" style="margin-bottom: 30px !important; padding-bottom: 25px !important;">
				<h2 style="font-size: 1.25rem; color: #1a1a1a; margin-bottom: 12px !important;">What certifications do A1 Security nightlife and residential guards hold?</h2>
				<p style="font-size: 1rem; line-height: 1.8; color: #333;">All A1 Security professionals are fully licensed by the NYS Department of State. Furthermore, our nightlife teams receive specialized training in non-violent conflict resolution, crowd dynamics, and hospitality, ensuring full compliance with NYC regulations while maintaining the elite atmosphere of your venue or residential lobby.</p>
			</div>

		</div>
	</div>
</section>

</div>
<?php get_footer(); ?>
