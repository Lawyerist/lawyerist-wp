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
