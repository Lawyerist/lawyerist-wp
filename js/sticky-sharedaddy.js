function stickySharedaddy( $ ) {

  var windowTop          = jQuery( window ).scrollTop();
  var postBodyTop       = jQuery( '.post_body' ).offset().top;
  var postBodyHeight    = jQuery( '.post_body' ).outerHeight();
  var postBodyBottom    = postBodyTop+postBodyHeight;
  var sharedaddyTop      = jQuery( '.sd-content' ).offset().top;
  var sharedaddyHeight   = jQuery( '.sd-content' ).outerHeight();
  var sharedaddyBottom   = sharedaddyTop+sharedaddyHeight;

  if ( windowTop > postBodyTop && sharedaddyBottom < postBodyBottom ) {
    jQuery( '.sharedaddy' ).addClass( 'stick' );
  }

  if ( sharedaddyBottom >= postBodyBottom ) {
    jQuery( '.sharedaddy' ).addClass( 'stop' );
  }

  if ( windowTop < postBodyBottom - sharedaddyHeight ) {
    jQuery( '.sharedaddy' ).removeClass( 'stop' );
  }

}

jQuery(
  function( $ ) {
    jQuery( window ).scroll( stickySharedaddy );
    stickySharedaddy();
  }
);
