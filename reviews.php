<?php if ( have_comments() ) : ?>
	<h2 id="comments">
		<?php
			if ( 1 == get_comments_number() ) {
				printf( __( '1 Community Review' )	);
			} else {
				/* Translator: %s: number of reviews */
				printf( _n( '%s Community Review', '%s Community Reviews', get_comments_number() ), number_format_i18n( get_comments_number() ) );
			}
		?>
	</h2>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments( array(
		'avatar_size'	=> 48, 'max_depth' => 1,
	) ); ?>
	</ol>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.'); ?></p>

	<?php endif; ?>
<?php endif; ?>

<?php

wp_reset_query();

comment_form( array(
	'title_reply'						=> __( 'Leave a Review' ),
	'comment_notes_before'	=> '<p class="comment-notes">' . __( 'Your email address will not be published. All fields are required.' ) . '</p>',
	'comment_notes_after'		=> '<p class="comment-notes">' . __( 'By leaving a review you agree to abide by our <a href="https://lawyerist.com/community-standards/">community standards</a>.' ) . '</p>',
	'must_log_in'						=> '<p class="must-log-in">' .  sprintf( __( 'You must be <a rel="nofollow" href="%s">logged in</a> to post a review.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
	)
);
