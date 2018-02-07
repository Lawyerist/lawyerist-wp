// Responsive Menu
jQuery(
  function( $ ){
    $( ".menu-item-has-children > a" ).click( function() {
        $( this ).toggleClass( "open" ).next( ".sub-menu" ).slideToggle( 145 );
        $( ".open" ).not( this ).toggleClass( "open" ).next( ".sub-menu" ).slideToggle( 95 );
      }
    );
  }
);
// End Responsive Menu


// Sticky Sidebar Ad
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
// End Sticky Sidebar Ad


// LinkedIn Insight Tag
_linkedin_data_partner_id = "86294";
(function(){
  var s = document.getElementsByTagName("script")[0];
  var b = document.createElement("script");
  b.type = "text/javascript";b.async = true;
  b.src = "https://snap.licdn.com/li.lms-analytics/insight.min.js";
  s.parentNode.insertBefore(b, s);
})();
// End LinkedIn Insight Tag
