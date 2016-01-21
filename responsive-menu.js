jQuery(function( $ ){

  $("#main-menu").before('<div class="mobile-menu-icon"></div>');

  $(".mobile-menu-icon").click(function(){
		$(this).next("#main-menu").slideToggle();
	});


  $(".sub-menu").before('<div class="mobile-sub-menu-icon"></div>');
  $(".mobile-sub-menu-icon").prev("a").addClass("has-sub-menu");

  $(".mobile-sub-menu-icon").click(function(){
    $(this).prev("a").toggleClass("open-menu");
		$(this).next(".sub-menu").slideToggle();
	});

});
