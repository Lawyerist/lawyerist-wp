function stickySharedaddy( $ ) {

  // Checks to make sure we're not on a WooCommerce page.
  if ( jQuery('.woocommerce-page').length > 0 ) {

    var windowTop         = jQuery( window ).scrollTop();
    var postBodyTop       = jQuery( '.post_body' ).offset().top;
    var postBodyHeight    = jQuery( '.post_body' ).outerHeight();
    var postBodyBottom    = postBodyTop+postBodyHeight;
    var sharedaddyTop     = jQuery( '.sd-block' ).offset().top;
    var sharedaddyHeight  = jQuery( '.sd-block' ).outerHeight();
    var sharedaddyBottom  = sharedaddyTop+sharedaddyHeight;

    if ( windowTop > postBodyTop && sharedaddyBottom < postBodyBottom ) {
      jQuery( '.sd-block' ).addClass( 'stick' );
    }

    if ( sharedaddyBottom >= postBodyBottom ) {
      jQuery( '.sd-block' ).addClass( 'stop' );
    }

    // if ( ??? ) {
    //   jQuery( '.sd-block' ).removeClass( 'stop' );
    // }

  }

}

jQuery(
  function( $ ) {
    jQuery( window ).scroll( stickySharedaddy );
    stickySharedaddy();
  }
);
