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
