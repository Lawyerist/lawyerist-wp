<?php

if ( has_tag('law-firm-websites') ) { ?>
	<p class="note">Solo and small firm lawyers need nice websites.<br />
	Learn how to get a <a href="http://sites.lawyerist.com?utm_source=Lawyerist&utm_medium=text-link&utm_campaign=sites_note" rel="nofollow">great law-firm website</a>.</p>
<?php }

$blogging_tags = array(
	'blogging',
	'best-law-blog-posts'
);

if ( has_tag( $blogging_tags ) && !has_tag('law-firm-websites') ) { ?>
	<p class="note">Clean, simple, responsive law blogs from Lawyerist Sites, just $20/month.<br />
	Get a <a href="http://sites.lawyerist.com/law-blogs/?utm_source=Lawyerist&utm_medium=text-link&utm_campaign=sites_note" rel="nofollow">law blog</a> for your practice.</p>
<?php }
