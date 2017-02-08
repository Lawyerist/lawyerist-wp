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


// Facebook Pixel
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,'script','https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '254894638282349', {
em: 'insert_email_variable,'
});
fbq('track', 'PageView');

// Insider confirmation page.
if ( footer_script_vars.page_slug == thanks-for-confirming-subscription ) {
  fbq('track', 'CompleteRegistration');
}

// TBD Law application.
if ( footer_script_vars.page_slug == thanks-for-applying ) {
  fbq('track', 'Lead');
}

// Paid download.
if ( footer_script_vars.page_slug == purchase-confirmation ) {
  fbq('track', 'Purchase', {value: '10.00', currency: 'USD'});
}

// Free download.
if ( footer_script_vars.page_slug == free-download-confirmation ) {
  fbq('track', 'Purchase', {value: '0.00', currency: 'USD'});
}

// Media kit request.
if ( footer_script_vars.page_slug == thanks-for-requesting-media-kit ) {
  fbq('track', 'Lead');
}

// Website assessments.
if ( footer_script_vars.page_slug == thanks-website-needs-assessment ) {
  fbq('track', 'Lead');
}
// End Facebook Pixel


// MailChimp Goal Tracking
var $mcGoal = {'settings':{'uuid':'a5da2382c098b6541dcd6cf8e','dc':'us2'}};
(function() {
	 var sp = document.createElement('script'); sp.type = 'text/javascript'; sp.async = true; sp.defer = true;
	sp.src = ('https:' == document.location.protocol ? 'https://s3.amazonaws.com/downloads.mailchimp.com' : 'http://downloads.mailchimp.com') + '/js/goal.min.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sp, s);
})();
// End MailChimp Goal Tracking
