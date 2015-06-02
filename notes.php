<?php

/*------------------------------
Specify terms up top, not within
the if-elseif loops. Put loops
in order of priority. Higher
loops take priority over lower
loops if a post has more than 
one.
------------------------------*/

$security_tags = array(
	'security',
	'data-security'
);


$web_design_tags = array(
	'blogging',
	'best-law-blog-posts',
	'law-firm-websites'
);

$web_design_pages = array(
	'best-law-firm-websites-contest'
);

/* Computer Security Guide */

if ( has_tag( $security_tags ) ) { ?>

	<div class="white_paper_note">
		<a href="https://lawyerist.com/downloads/4-step-computer-security-upgrade/"><img class="alignright size-medium wp-image-82487" style="border: 1px solid #ddd;" src="https://lawyerist.com/lawyerist/wp-content/uploads/2015/05/computer-security-upgrade-cover-shop-300x388.png" alt="computer-security-upgrade-cover-shop" width="300" height="388" /></a>
		<h3>Get our "4-Step Computer Security Upgrade"</h3>
		<p>This guide makes it as easy to lock the virtual door to your computer as it is to lock the physical door to your office. In less than an hour, you will learn to encrypt your files, secure your computer when using public Wi-Fi, enable two-factor authentication, and use good passwords.</p>
		<a href="https://lawyerist.com/downloads/4-step-computer-security-upgrade/" class="button">Get it Now!</a>
		<div class="clear"></div>
	</div>

<?php }


/* Website Design Guide */

elseif ( has_tag( $web_design_tags ) || is_page( $web_design_pages ) ) { ?>

	<div class="white_paper_note">
		<a href="https://lawyerist.com/law-firm-website-design-white-paper/"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/2014/10/10ThingstheBestLawFirmWebsiteDesignsHaveinCommon_Page_01-300x388.png" alt="Law Firm Website Design Guide (cover)" width="300" height="387" class="alignright size-medium wp-image-77734" /></a>
		<h3>Get our White Paper, "10 Things the Best Law-Firm Website Designs Have in Common"</h3>
		<p>For the past five years, Lawyerist has published an annual list of the best law firm websites. Now, you can find out what they have in common.</p>
		<a href="https://lawyerist.com/law-firm-website-design-white-paper/" class="button">Get it Now!</a>
		<div class="clear"></div>
	</div>

<?php }
