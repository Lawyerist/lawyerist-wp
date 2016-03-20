<?php

if ( !has_tag( 'no-ads' ) ) {

	if ( has_category( 'marketing' ) ) { ?>

		<!-- Website Design Guide -->

		<div class="survival_guide_note">
			<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2015/05/website-design-guide-cover-2-300x391.png" alt="website-design-guide-cover-2" />
			<h3>Free: 10 Things the Best Law-Firm Website Designs Have in Common</h3>
			<p>For seven years, Lawyerist has published an annual list of the best law firm websites. Now, you can find out what they have in common.</p>
			<?php echo edd_get_purchase_link( array( 'download_id' => 84256 ) ); ?>
			<div class="clear"></div>
		</div>

	<?php } elseif ( has_category( 'tech' ) && !has_tag( 'microsoft' ) && !has_tag( 'windows' ) ) { ?>

		<!-- Computer Security Guide -->

		<div class="survival_guide_note">
			<img src="https://lawyerist.com/lawyerist/wp-content/uploads/2015/05/computer-security-guide-cover-2-300x391.png" alt="computer-security-guide-cover-2" />
			<h3>4-Step Computer Security Upgrade</h3>
			<p>Learn to encrypt your files, secure your computer when using public Wi-Fi, enable two-factor authentication, and use good passwords.</p>
			<?php echo edd_get_purchase_link( array( 'download_id' => 82500 ) ); ?>
			<div class="clear"></div>
		</div>

	<?php } elseif ( has_category( 'tech' ) && ( has_tag( 'microsoft' ) || has_tag( 'windows' ) ) ) { ?>

		<!-- Computer Setup Guide -->

		<div class="survival_guide_note">
			<img src="https://lawyerist.com/lawyerist/wp-content/uploads/edd/2016/02/computer-setup-guide-cover-300x391.png" alt="computer-setup-guide-cover-2" />
			<h3>How to Set Up Your New Windows Computer</h3>
			<p>A brand-new Windows PC, fully updated and unsullied by crapware, is a wonderful thing. Sadly, very few people ever get to experience it—but you can!</p>
			<?php echo edd_get_purchase_link( array( 'download_id' => 99895 ) ); ?>
			<div class="clear"></div>
		</div>

	<?php } elseif ( has_category( 'practice-management' ) ) { ?>

		<div class="survival_guide_note">
			<img src="https://lawyerist.com/lawyerist/wp-content/uploads/edd/2016/03/productivity-guide-cover-300x391.png" alt="productivity-guide-cover" />
			<h3>Personal Productivity for Lawyers</h3>
			<p>This quick-start guide to Getting Things Done and Inbox Zero also includes two shortcuts for those who want the benefits of GTD without having to learn the system.</p>
			<?php echo edd_get_purchase_link( array( 'download_id' => 103618 ) ); ?>
			<div class="clear"></div>
		</div>
		<a href="https://lawyerist.com/downloads/personal-productivity-lawyers/" rel="attachment wp-att-103620"></a>

	<?php }

}
