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



// WooCommerce select drop-downs.
jQuery( document ).ready( function( $ ) {

	// Frontend Chosen selects
	if ( $().select2 ) {
		$( 'select.checkout_chosen_select:not(.old_chosen), .form-row .select:not(.old_chosen)' ).filter( ':not(.enhanced)' ).each( function() {
			$( this ).select2( {
				minimumResultsForSearch: 10,
				allowClear:  true,
				placeholder: $( this ).data( 'placeholder' )
			} ).addClass( 'enhanced' );
		});
	}

});


// Sticky Sidebar Ad
function stickySidebarAd( $ ) {

  // Checks to see if the sidebar ad is present.
  if ( jQuery('#lawyerist_display_ad').length > 0 ) {

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


// LawyeristBot
<link href="https://lawdroid.com/ld-assets/webchat.css?ver=1.1.7" rel="stylesheet" type="text/css">
<script src="https://lawdroid.com/ld-assets/webchat.js?ver=1.1.7"></script>
<script>LD_Widget_Init('botid=91944&color=c00&color_bot=dadada&token=aa0f6263eb13149dfe6d9fcc25cda6fc&display_avatars=true&avatar_bot=https://lawdroid.com/wp-content/uploads/2018/08/Lawyerist-Logo.png&avatar_human=https://lawdroid.com/wp-content/uploads/2018/08/user-avatar-shadowed.jpg&sendBtn=Send&inputBox=Type%20something...&bottom_margin=10&user_input_bg_color=000000&user_input_field_focus_color=c00&chatbot_id=1727',true, '600px','100%','https://lawdroid.com/wp-content/uploads/2018/08/Lawyerist-Logo.png','https://lawdroid.com/privacy_policy',0,false,true,'Hi%20there%21%20%uD83D%uDC4B%20Thanks%20for%20visiting%20Lawyerist.%20Would%20you%20like%20me%20to%20show%20you%20around%3F%20Try%20me.','250','90','LawyeristBot', 'c00');
</script>
//End LawyeristBot
