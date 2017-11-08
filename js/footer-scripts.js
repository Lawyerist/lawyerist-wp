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


// MailChimp Goal Tracking
var $mcGoal = {'settings':{'uuid':'a5da2382c098b6541dcd6cf8e','dc':'us2'}};
(function() {
	var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true;
	sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s);
})();
// End MailChimp Goal Tracking


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
