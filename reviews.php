<?php if ( have_comments() ) : ?>
	<h2 id="comments">
		<?php

			$community_rating = lawyerist_get_community_rating();

			if ( 1 == get_comments_number() ) {
				/* translators: %s: post title */
				printf( __( 'Community Rating: %s/5 (based on 1 review)' ),
					$community_rating
				);
			} else {
				/* translators: 1: number of comments, 2: post title */
				printf( _n( 'Community Rating: %1$s/5 (based on %2$s review)', 'Community Rating: %1$s/5 (based on %2$s reviews)', get_comments_number() ),
					$community_rating,
					number_format_i18n( get_comments_number() )
				);
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
	'comment_notes_after'	=> '<p class="comment-notes">' . __( 'By leaving a review you agree to abide by our <a href="https://lawyerist.com/community-standards/">community standards</a>.' ) . '</p>',
	)
);
