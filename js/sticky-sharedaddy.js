function sticky_sharedaddy( $ ) {

  var window_top          = jQuery( window ).scrollTop();
  var window_height       = jQuery( window ).height();
  var post_body_top       = jQuery( '.post_body' ).offset().top;
  var post_body_height    = jQuery( '.post_body' ).outerHeight();
  var post_body_bottom    = post_body_top+post_body_height;
  var sharedaddy_top      = jQuery( '.sd-content' ).offset().top;
  var sharedaddy_height   = jQuery( '.sd-content' ).outerHeight();
  var sharedaddy_bottom   = sharedaddy_top+sharedaddy_height;

  if ( window_top > post_body_top-(window_height/10) ) {
    jQuery( '.sharedaddy' ).addClass( 'stick' );
  } else {
    jQuery( '.sharedaddy' ).removeClass( 'stick' );
  }

  if ( sharedaddy_bottom >= post_body_bottom ) {
    jQuery( '.sharedaddy' ).addClass( 'stop' );
  }

  if ( sharedaddy_top > (window_top + window_height/10) ) {
    jQuery( '.sharedaddy' ).removeClass( 'stop' );
  }

}

jQuery(
  function( $ ) {
    jQuery( window ).scroll( sticky_sharedaddy );
    sticky_sharedaddy();
  }
);
