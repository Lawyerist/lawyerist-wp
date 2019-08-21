// Responsive Menu
jQuery( document ).ready( function( $ ) {

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

});
// End Responsive Menu


// Lawyerist Login/Register
jQuery( document ).ready( function( $ ) {

  $( "#lawyerist-login #register" ).hide();
  $( "#lawyerist-login.modal" ).hide();

  // Controls navigation within #lawyerist-login.
  $( "#lawyerist-login .register-link" ).click( function() {
    $( "#lawyerist-login #login" ).hide( 95 );
    $( "#lawyerist-login #register" ).show( 145 );
  });

  $( "#lawyerist-login .back-to-login-link" ).click( function() {
    $( "#lawyerist-login #login" ).show( 145 );
    $( "#lawyerist-login #register" ).hide( 95 );
  });

  // Prevents login links from activating.
  $( ".login-link, a[ href*='wp-login.php'], .register-link" ).click( function( e ) {
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

});
// End Lawyerist Login/Register

/**
* Expander
*
* Opens and closes things with the .expand-this class.
*/
jQuery( document ).ready( function( $ ) {

  if ( $( ".expandthis-hide" ).length > 0 ) {

    $( ".expandthis-hide" ).hide();

    $( ".expandthis-click" ).click( function() {
      $( this ).toggleClass( "open" ).next( ".expandthis-hide" ).slideToggle( 145 );
      $( ".open" ).not( this ).toggleClass( "open" ).next( ".expandthis-hide" ).slideToggle( 95 );
    });

  }

});


// WooCommerce Select Drop-Downs
jQuery( document ).ready( function( $ ) {

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

});
// End WooCommerce Select Drop-Downs


// Sticky Sidebar Ad
function stickySidebarAd( $ ) {

  // Checks to see if the sidebar ad is present.
  if ( jQuery( '#lawyerist_display_ad' ).length > 0 ) {

    var windowTop       = jQuery( window ).scrollTop();
    var sidebarTop      = jQuery( '#sidebar_column' ).offset().top;
    var sidebarAdHeight = jQuery( '#lawyerist_display_ad' ).outerHeight();
    var sponsorAdHeight = jQuery( '#platinum-sponsors-widget' ).outerHeight();
    var sidebarBottom   = sidebarTop + sidebarAdHeight + sponsorAdHeight;

    if ( windowTop > sidebarBottom ) {
      jQuery( '#lawyerist_display_ad' ).addClass( 'stick' );
    }

    if ( windowTop < sidebarBottom ) {
      jQuery( '#lawyerist_display_ad' ).removeClass( 'stick' );
    }

  }

}

jQuery( document ).ready( function( $ ) {
  $( window ).scroll( stickySidebarAd );
  stickySidebarAd();
});
// End Sticky Sidebar Ad


// Dismissible Call to Action
jQuery( document ).ready( function() {

    var notice, noticeId, storedNoticeId, dismissButton;

    notice = document.querySelector( '.dismissible-notice' );

    if ( !notice ) {
      return;
    }

    dismissButton   = document.querySelector( '.dismiss-button' );
    noticeId        = notice.getAttribute( 'data-id' );
    storedNoticeId  = localStorage.getItem( 'lawyeristNotices' );

    if ( noticeId !== storedNoticeId ) {
  		notice.style.display = 'block';
  	}

    dismissButton.addEventListener( 'click', function () {
  		notice.style.display = 'none';
      localStorage.setItem( 'lawyeristNotices', noticeId );
    });

});
// End Dismissible Call to Action
