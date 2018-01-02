function sticky_sidebar_ad( $ ) {

  var windowTop       = jQuery( window ).scrollTop();
  var sidebarAdTop    = jQuery( '#lawyerist_display_ad' ).offset().top;
  var platinumTop     = jQuery( '#custom_html-2' ).offset().top;
  var platinumHeight  = jQuery( '#custom_html-2' ).outerHeight();
  var platinumBottom  = platinumTop + platinumHeight;

  if ( windowTop > platinumBottom ) {
    jQuery( '#lawyerist_display_ad' ).addClass( 'stick' );
  }

  if ( windowTop < platinumBottom ) {
    jQuery( '#lawyerist_display_ad' ).removeClass( 'stick' );
  }

}

jQuery(
  function( $ ) {
    jQuery( window ).scroll( sticky_sidebar_ad );
    sticky_sidebar_ad();
  }
);
