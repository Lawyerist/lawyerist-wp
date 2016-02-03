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


$computer_setup_tags = array(
	'microsoft',
	'windows'
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

	<div class="survival_guide_note" data-swiftype-index="false">
		<a href="https://lawyerist.com/downloads/4-step-computer-security-upgrade/"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/2015/05/computer-security-guide-cover-2-300x391.png" alt="computer-security-guide-cover-2" width="300" height="391" class="alignright size-medium wp-image-86178" /></a>
		<h3>Get our "4-Step Computer Security Upgrade"</h3>
		<p>This guide makes it as easy to lock the virtual door to your computer as it is to lock the physical door to your office. In less than an hour, you will learn to encrypt your files, secure your computer when using public Wi-Fi, enable two-factor authentication, and use good passwords.</p>
		<a href="https://lawyerist.com/downloads/4-step-computer-security-upgrade/" class="button">Get it Now!</a>
		<div class="clear"></div>
	</div>

<?php }


/* Computer Setup Guide */

elseif ( has_tag( $computer_setup_tags ) ) { ?>

	<div class="computer_setup_guide_note" data-swiftype-index="false">
		<a href="https://lawyerist.com/downloads/windows-computer-setup-guide/"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/edd/2016/02/computer-setup-guide-cover-300x391.png" alt="computer-setup-guide-cover-2" width="300" height="391" class="alignright size-medium wp-image-86177" /></a>
		<h3>Get our guide, "How to Set Up Your New Windows Computer"</h3>
		<p>A brand-new Windows PC, fully updated and unsullied by crapware, is a wonderful thing. Sadly, very few people ever get to experience it—but you can!</p>
		<a href="https://lawyerist.com/downloads/windows-computer-setup-guide/" class="button">Get it Now!</a>
		<div class="clear"></div>
	</div>

<?php }


/* Website Design Guide */

elseif ( has_tag( $web_design_tags ) || is_page( $web_design_pages ) ) { ?>

	<div class="survival_guide_note" data-swiftype-index="false">
		<a href="https://lawyerist.com/downloads/law-firm-website-design-guide/"><img src="https://lawyerist.com/lawyerist/wp-content/uploads/2015/05/website-design-guide-cover-2-300x391.png" alt="website-design-guide-cover-2" width="300" height="391" class="alignright size-medium wp-image-86177" /></a>
		<h3>Get our guide, "10 Things the Best Law-Firm Website Designs Have in Common"</h3>
		<p>For the past five years, Lawyerist has published an annual list of the best law firm websites. Now, you can find out what they have in common.</p>
		<a href="https://lawyerist.com/downloads/law-firm-website-design-guide/" class="button">Get it Now!</a>
		<div class="clear"></div>
	</div>

<?php }
