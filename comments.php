<?php if ( have_comments() ) : ?>
	<h3 id="comments">
		<?php
			if ( 1 == get_comments_number() ) {
				printf( __( '1 Comment' ) );
			} else {
				/* Translator: %s: number of comments */
				printf( _n( '%s Comment', '%s Comments', get_comments_number() ), number_format_i18n( get_comments_number() ) );
			}
		?>
	</h3>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>

	<ol class="commentlist">
	<?php wp_list_comments( array(
		'avatar_size'	=> 48,
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
	'title_reply'						=> __( 'Leave a Reply' ),
	'comment_notes_before'	=> '<p class="comment-notes">' . __( 'Your email address will not be published. All fields are required.' ) . '</p>',
	'comment_notes_after'		=> '<p class="comment-notes">' . __( 'By commenting you agree to abide by our <a href="https://lawyerist.com/community-standards/">community standards</a>.' ) . '</p>',
	'must_log_in'						=> '<p class="must-log-in">' .  sprintf( __( 'You must be <a rel="nofollow" href="%s">logged in</a> to post a comment.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
	)
);
