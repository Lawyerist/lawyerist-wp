// Responsive Menu
jQuery(
  function( $ ){
    $( ".main-menu-item a" ).click(
      function() {
        $( this ).toggleClass( "open" ).next( ".main-menu-dropdown" ).slideToggle( 145 );
        $( ".open" ).not( this ).toggleClass( "open" ).next( ".main-menu-dropdown" ).slideToggle( 95 );
      }
    );
  }
);
//End Responsive Menu


// MailChimp Goal Tracking
var $mcGoal = {'settings':{'uuid':'a5da2382c098b6541dcd6cf8e','dc':'us2'}};
(function() {
	 var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true;
	sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s);
})();
// End MailChimp Goal Tracking
