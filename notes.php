<?php

if ( has_tag('law-firm-websites') ) { ?>
	<p class="note">Need help getting a great law-firm website? We're here to help.<br />
	<a href="http://sites.lawyerist.com?utm_source=Lawyerist&utm_medium=text-link&utm_campaign=sites_note" rel="nofollow">Learn more.</a></p>
<?php }

$blogging_tags = array(
	'blogging',
	'best-law-blog-posts'
);

if ( has_tag( $blogging_tags ) && !has_tag('law-firm-websites') ) { ?>
	<p class="note">Clean, simple, responsive law blogs from Lawyerist Sites, just $20/month.<br />
	<a href="http://sites.lawyerist.com/law-blogs/?utm_source=Lawyerist&utm_medium=text-link&utm_campaign=sites_note" rel="nofollow">Learn more.</a></p>
<?php }
