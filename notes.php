<?php

if ( !has_tag( 'no-ads' ) ) {

	if ( has_category( 'marketing' ) ) { ?>

		<!-- Website Design Guide -->

		<div class="survival_guide_note" data-swiftype-index="false">
			<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2015/05/website-design-guide-cover-2-300x391.png" alt="website-design-guide-cover-2" />
			<h3>Free: 10 Things the Best Law-Firm Website Designs Have in Common</h3>
			<p>For the past six years, Lawyerist has published an annual list of the best law firm websites. Now, you can find out what they have in common.</p>
			<a href="https://lawyerist.com/downloads/law-firm-website-design-guide/" class="button">Download Now</a>
			<div class="clear"></div>
		</div>

	<?php } elseif ( has_category( 'tech' ) && !has_tag( 'microsoft' ) && !has_tag( 'windows' ) ) { ?>

		<!-- Computer Security Guide -->

		<div class="survival_guide_note" data-swiftype-index="false">
			<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2015/05/computer-security-guide-cover-2-300x391.png" alt="computer-security-guide-cover-2" />
			<h3>4-Step Computer Security Upgrade</h3>
			<p>Learn to encrypt your files, secure your computer when using public Wi-Fi, enable two-factor authentication, and use good passwords.</p>
			<a href="https://lawyerist.com/downloads/4-step-computer-security-upgrade/" class="button">Get the Guide</a>
			<div class="clear"></div>
		</div>

	<?php } elseif ( has_category( 'tech' ) && ( has_tag( 'microsoft' ) || has_tag( 'windows' ) ) ) { ?>

		<!-- Computer Setup Guide -->

		<div class="survival_guide_note" data-swiftype-index="false">
			<img src="https://lawyerist.com/lawyerist/wp-content/uploads/edd/2016/02/computer-setup-guide-cover-300x391.png" alt="computer-setup-guide-cover-2" />
			<h3>How to Set Up Your New Windows Computer</h3>
			<p>A brand-new Windows PC, fully updated and unsullied by crapware, is a wonderful thing. Sadly, very few people ever get to experience it—but you can!</p>
			<a href="https://lawyerist.com/downloads/windows-computer-setup-guide/" class="button">Get the Guide</a>
			<div class="clear"></div>
		</div>

	<?php }

}
