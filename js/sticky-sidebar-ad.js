function stickySidebarAd( $ ) {

  // Checks to see if the sidebar is present.
  if ( jQuery('#sidebar_column').length > 0 ) {

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

jQuery(
  function( $ ) {
    jQuery( window ).scroll( stickySidebarAd );
    stickySidebarAd();
  }
);
