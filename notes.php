<?php

$websites_tags = array(
	'blogging',
	'best-law-blog-posts',
	'law-firm-websites'
);

$websites_pages = array(
	'best-law-firm-websites-contest'
);

if ( has_tag( $websites_tags ) || is_page( $websites_pages ) ) { ?>
	<div class="white_paper_note raised_block">
		<a href="https://lawyerist.com/law-firm-website-design-white-paper/"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/2014/10/10ThingstheBestLawFirmWebsiteDesignsHaveinCommon_Page_01-300x388.png" alt="Law Firm Website Design Guide (cover)" width="300" height="387" class="alignright size-medium wp-image-77734" /></a>
		<h3>Get our white paper, "10 Things the Best Law-Firm Website Designs Have in Common"</h3>
		<p>For the past five years, Lawyerist has published an annual list of the best law firm websites. Now, you can find out what they have in common.</p>
		<a href="https://lawyerist.com/law-firm-website-design-white-paper/" class="button">Get it Now!</a>
		<div class="clear"></div>
	</div>
<?php }
