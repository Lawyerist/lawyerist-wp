<?php

// Outputs the most recent podcast episode.

$podcast_feed			= fetch_feed( 'https://lawyerist.libsyn.com/' );
$current_episode	= $podcast_feed->get_item( 0 );

$show_img_url			= array(
  '1x' => 'https://lawyerist.com/lawyerist/wp-content/uploads/2019/12/podcast-mic_1x.png',
  '2x' => 'https://lawyerist.com/lawyerist/wp-content/uploads/2019/12/podcast-mic_2x.png',
);
$ep_title					= $current_episode->get_title();
$ep_date					= $current_episode->get_date( 'F jS, Y' );

?>

<div class="card post-card podcast-card has-card-label">
  <a href="https://lawyerist.com/podcast/" title="The Lawyerist Podcast" class="post has-post-thumbnail">
    <?php echo wp_get_attachment_image( 529989, array( 100, 201 ) ); ?>
    <div class="headline-byline">
      <h2 class="headline" title="<?php echo $ep_title; ?>"><?php echo $ep_title; ?></h2>
      <div class="postmeta"><span class="date updated published"><?php echo $ep_date; ?></span></div>
    </div>
  </a>
  <p class="card-label card-bottom-label"><a href="https://lawyerist.com/podcast/" title="All episodes of The Lawyerist Podcast.">All episodes of The Lawyerist Podcast</a></p>
</div>
