<div id="praise-cards">

	<?php

	wp_enqueue_style( 'praise-cards-css', get_template_directory_uri() . '/css/praise-cards.css' );

	comment_form( array(
		'title_reply'						=> __( 'Praise.' ),
		'comment_notes_before'	=> null,
		'comment_field'					=> '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><textarea placeholder="Write something …" id="comment" name="comment" cols="45" rows="5" aria-required="true">' . '</textarea></p>',
		'must_log_in'						=> '<p class="must-log-in">' .  sprintf( __( 'You must be <a rel="nofollow" href="%s">logged in</a>.' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'label_submit'					=> 'Post',
		)
	);

	if ( have_comments() ) {

		?>

		<ul id="praise-card-list">

			<?php

			wp_list_comments( array(
				'max_depth'					=> 1,
				'per_page'					=> -1,
				'reverse_top_level'	=> true,
			) );

			?>

		</ul>

		<script type='text/javascript'>

			let praiseCardList	= document.getElementById( 'praise-card-list' );
			let praiseCards			= praiseCardList.getElementsByClassName( 'comment' );

			Array.prototype.forEach.call( praiseCards, function( card ) {

				let rotation = Math.random() * ( 2 - -2) + -2;
				card.style.transform = 'rotate( ' + rotation + 'deg )';

			});

		</script>

		<?php

	}

	?>

</div>

<?php wp_reset_query(); ?>
