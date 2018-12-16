// Responsive Menu
jQuery( function( $ ) {

  $( "#menu-main-menu .sub-menu" ).hide();

  $( "#menu-main-menu > .menu-item-has-children > a" ).click( function() {
    $( this ).toggleClass( "open" ).next( ".sub-menu" ).slideToggle( 145 );
    $( ".open" ).not( this ).toggleClass( "open" ).next( ".sub-menu" ).slideToggle( 95 );
  });

  $( "#menu-main-menu > .menu-item-has-children .menu-item-has-children > a" ).click( function() {
    $( this ).toggleClass( "open" ).next( ".sub-menu" ).slideToggle( 145 );
  });

});
// End Responsive Menu


// WooCommerce Select Drop-Downs
jQuery( function( $ ) {

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

    var windowTop      = jQuery( window ).scrollTop();
    var sidebarAdTop   = jQuery( '#lawyerist_display_ad' ).offset().top;
    var sidebarTop     = jQuery( '#sidebar_column' ).offset().top;
    var sidebarHeight  = jQuery( '#sidebar_column' ).outerHeight();
    var sidebarBottom  = sidebarTop + sidebarHeight;

    if ( windowTop > sidebarBottom ) {
      jQuery( '#lawyerist_display_ad' ).addClass( 'stick' );
    }

    if ( windowTop < sidebarBottom ) {
      jQuery( '#lawyerist_display_ad' ).removeClass( 'stick' );
    }

  }

}

jQuery( function( $ ) {
  $( window ).scroll( stickySidebarAd );
  stickySidebarAd();
});
// End Sticky Sidebar Ad
