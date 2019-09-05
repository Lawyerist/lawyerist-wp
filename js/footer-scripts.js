// Responsive Menu
( function( $ ) {

  $( "#menu-main-menu .sub-menu" ).hide();

  // Expands top-level sub-menus.
  $( "#menu-main-menu > .menu-item-has-children > a" ).click( function() {
    $( this ).toggleClass( "open" ).next( ".sub-menu" ).slideToggle( 145 );
    $( ".open" ).not( this ).toggleClass( "open" ).next( ".sub-menu" ).slideToggle( 95 );
  });

  // Expands second-level+ sub-menus.
  // The .not in this function excludes the Join the Lawyerist Community sub menu.
  $( "#menu-main-menu > .menu-item-has-children .menu-item-has-children > a" ).not( "#menu-item-270912 > a" ).click( function() {
    $( this ).toggleClass( "open" ).next( ".sub-menu" ).slideToggle( 145 );
  });

})( jQuery );
// End Responsive Menu


// Lawyerist Login/Register
( function( $ ) {

  $( "#lawyerist-login #register" ).hide();
  $( "#lawyerist-login.modal" ).hide();

  // Controls navigation within #lawyerist-login.
  $( "#lawyerist-login .link-to-register" ).click( function() {
    $( "#lawyerist-login #login" ).hide( 95 );
    $( "#lawyerist-login #register" ).show( 145 );
  });

  $( "#lawyerist-login .back-to-login" ).click( function() {
    $( "#lawyerist-login #login" ).show( 145 );
    $( "#lawyerist-login #register" ).hide( 95 );
  });

  // Prevents login links from activating.
  $( ".login-link, a[ href*='wp-login.php' ], .register-link" ).click( function( e ) {
    e.preventDefault();
  });

  // Controls the modal pop-up and close actions.
  $( ".login-link, a[ href*='wp-login.php']" ).click( function() {
    $( "#lawyerist-login.modal" ).show( 145 );
    $( "#lawyerist-login-screen" ).show();
  });

  // Switches to the registration form for .register-link links.
  $( ".register-link" ).click( function() {
    $( "#lawyerist-login.modal #login" ).hide();
    $( "#lawyerist-login.modal #register" ).show();
    $( "#lawyerist-login.modal" ).show( 145 );
    $( "#lawyerist-login-screen" ).show();
  });

  $( "#lawyerist-login.modal .dismiss-button" ).click( function() {
    $( "#lawyerist-login.modal" ).hide( 95 );
    $( "#lawyerist-login-screen" ).hide();
  });

  // Changes/removes stuff when the confirmation wrapper is visible.
  jQuery( document ).on( 'gform_confirmation_loaded', function() {
    $( "#lawyerist-login.modal .dismiss-button" ).hide();
    $( "#lawyerist-login.modal #register h2" ).html( "Welcome to the Lawyerist Insider Community!" );
    $( "#lawyerist-login.modal #register p.remove_bottom" ).hide();
  });

})( jQuery );
// End Lawyerist Login/Register

/**
* Expander
*
* Opens and closes things with the .expand-this class.
*/
( function( $ ) {

  if ( $( ".expandthis-hide" ).length > 0 ) {

    $( ".expandthis-hide" ).hide();

    $( ".expandthis-click" ).click( function() {
      $( this ).toggleClass( "open" ).next( ".expandthis-hide" ).slideToggle( 145 );
      $( ".open" ).not( this ).toggleClass( "open" ).next( ".expandthis-hide" ).slideToggle( 95 );
    });

  }

})( jQuery );


// WooCommerce Select Drop-Downs
( function( $ ) {

	// Frontend Chosen selects
	if ( $().select2 ) {
		$( 'select.checkout_chosen_select:not(.old_chosen), .form-row .select:not(.old_chosen)' ).filter( ':not(.enhanced)' ).each( function() {
			$( this ).select2( {
				minimumResultsForSearch: 10,
				allowClear:  true,
				placeholder: $( this ).data( 'placeholder' )
			} ).addClass( 'enhanced' );
		});
	}

})( jQuery );
// End WooCommerce Select Drop-Downs


// Sticky Sidebar Ad
( function( $ ) {

  function stickySidebarAd() {

    // Checks to see if the sidebar ad is present.
    if ( $( '#lawyerist_display_ad' ).length > 0 ) {

      var windowTop       = $( window ).scrollTop();
      var sidebarTop      = $( '#sidebar_column' ).offset().top;
      var sidebarAdHeight = $( '#lawyerist_display_ad' ).outerHeight();
      var sponsorAdHeight = $( '#platinum-sponsors-widget' ).outerHeight();
      var sidebarBottom   = sidebarTop + sidebarAdHeight + sponsorAdHeight;

      if ( windowTop > sidebarBottom ) {
        $( '#lawyerist_display_ad' ).addClass( 'stick' );
      }

      if ( windowTop < sidebarBottom ) {
        $( '#lawyerist_display_ad' ).removeClass( 'stick' );
      }

    }

  }

  $( window ).scroll( stickySidebarAd );
  stickySidebarAd();

})( jQuery );
// End Sticky Sidebar Ad


// Dismissible Call to Action
( function() {

    var notice, noticeId, storedNoticeId, dismissButton;

    notice = document.querySelector( '.dismissible-notice' );

    if ( !notice ) {
      return;
    }

    dismissButton   = document.querySelector( '#big_hero_cta .dismiss-button' );
    noticeId        = notice.getAttribute( 'data-id' );
    storedNoticeId  = localStorage.getItem( 'lawyeristNotices' );

    if ( noticeId !== storedNoticeId ) {
  		notice.style.display = 'block';
  	}

    dismissButton.addEventListener( 'click', function () {
  		notice.style.display = 'none';
      localStorage.setItem( 'lawyeristNotices', noticeId );
    });

})( jQuery );
// End Dismissible Call to Action
