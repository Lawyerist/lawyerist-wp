// Signup Wall
( function( $ ) {

  notice = document.querySelector( '#article-counter' );

  if ( !notice ) {
    return;
  }

  let date, thisMonth, thisArticle, articlesRead, articlesCount, articleCounter;

  articleCounter  = $( '#article-counter' );

  date          = new Date();
  thisMonth     = date.getMonth();
  thisArticle   = articleCounter.data( 'post_id' );

  articlesRead = JSON.parse( localStorage.getItem( 'lawyeristArticlesRead' ) );

  if ( articlesRead == null || articlesRead[ 'month' ] != thisMonth ) {
    articlesRead = {
      'month': thisMonth,
      'articles': [],
    };
    articleCount = 0;
  } else {
    articleCount = articlesRead[ 'articles' ].length;
  }

  // Adds the current page ID to the array of articles if there are fewer than 6.
  if ( articleCount < 6 && articlesRead[ 'articles' ].indexOf( thisArticle ) == -1 ) {
    articlesRead[ 'articles' ].push( thisArticle );
  }

  // Reset the article count.
  articleCount = articlesRead[ 'articles' ].length;

  // Output the current article count, a notice that the viewer has read all
  // their alotted articles, or block the page by replacing the post content.
  if ( articleCount == 1 ) {

    articleCounter.html( 'This is your first of five free articles this month! We\'d love to unlock more for free. All you have to do is <a class="login-link" href="/account/">log in or register</a>.' );

  } else if ( articleCount < 5 ) {

    articleCounter.html( 'You have viewed ' + articleCount + ' of 5 free articles this month. We\'d love to unlock more for free. All you have to do is <a class="login-link" href="/account/">log in or register</a>.' );

  } else if ( articleCount == 5 ) {

    articleCounter.html( 'This is the last of your five free articles this month. To keep reading, <a class="login-link" href="/account/">log in or register</a>.' );

  } else {

    $( '.post_body' ).html( '<p class="article-counter-login-notice">You have read all five of your free articles this month. To read this article, <a class="login-link" href="/account/">log in or register</a>.</p>' );
    articleCounter.hide();
    $( '#lawyerist-login' ).show( 145 );
    $( '#lawyerist-login-screen' ).show();

  }

  localStorage.setItem( 'lawyeristArticlesRead', JSON.stringify( articlesRead ) );

})( jQuery );
// End Signup Wall


// Product Filters
( function( $ ) {

  if ( $( '.product-filters' ).length > 0 ) {

    let filter        = $( '.product-filters .filter' );
    let filterLabels  = [];
    let featureClass  = [];
    let noResults     = $( '#no-results-placeholder' );
    let productList   = $( '.product-pages-list li' );

    $( '.product-filters .show-all' ).click( function() {
      filter.removeClass( 'on' );
      productList.removeClass( 'show' ).show();
      noResults.hide();
      filterLabels = [];
    });

    filter.click( function() {

      featureClass = $( this ).data( 'acf_label' );

      if ( $( this ).hasClass( 'on' ) ) {

        $( this ).removeClass( 'on' );

        var index = filterLabels.indexOf( featureClass );
        if ( index > -1 ) {
          filterLabels.splice( index, 1 );
        }

      } else {

        $( this ).addClass( 'on' );

        filterLabels.push( featureClass );

      }

      products = document.getElementsByClassName( 'product-card' );
      let productCount = products.length;

      Array.prototype.forEach.call( products, function( product ) {

        let classList = product.className.split( ' ' );
        let match = true;

        filterLabels.forEach( function( label ) {

          if ( classList.indexOf( label ) == -1 ) {
            match = false;
          }

        });

        if ( match == false ) {
          $( product ).removeClass( 'show' ).hide();
          productCount--;
        } else {
          $( product ).addClass( 'show' ).show();
        }

        if ( productCount == 0 ) {
          noResults.show();
        } else {
          noResults.hide();
        }

      });

    });

  }

})( jQuery );
// End Product Filters


// Responsive Menu
( function( $ ) {

  $( '#menu-main-menu .sub-menu' ).hide();

  // Opens and closes top-level sub-menus.
  $( '#menu-main-menu > .menu-item-has-children > a' ).click( function() {
    $( this ).toggleClass( 'open' ).next( '.sub-menu' ).slideToggle( 95 );
    $( '.open' ).not( this ).toggleClass( 'open' ).next( '.sub-menu' ).slideToggle( 95 );
  });

  // Opens and closes second-level+ sub-menus.
  // The .not in this function excludes the Products & Services and
  // Join the Lawyerist Community sub menus.
  $( '#menu-main-menu > .menu-item-has-children .menu-item-has-children > a' ).not( '#menu-item-305888 > a, #menu-item-270912 > a' ).click( function() {
    $( this ).toggleClass( 'open' ).next( '.sub-menu' ).slideToggle( 95 );
  });

  // Closes all menus when anything outside the menu is clicked.
  $( document ).on( 'click', function() {
    $( '#menu-main-menu .menu-item-has-children > a' ).removeClass( 'open' ).next( '.sub-menu' ).slideUp( 95 );
  });

  $( '#menu-main-menu *' ).on( 'click', function( e ) {
      e.stopPropagation();
  });

})( jQuery );
// End Responsive Menu


// Lawyerist Login/Register
( function( $ ) {

  let allLoginRegisterLinks = $( '.login-link, a[ href*="wp-login.php" ], .register-link' );
  let loginModal            = $( '#lawyerist-login' );
  let loginScreen           = $( '#lawyerist-login-screen' );
  let loginLinks            = $( '.login-link, a[ href*="wp-login.php" ]' );
  let loginForm             = $( '#lawyerist-login #login' );
  let registerLinks         = $( '.register-link' );
  let registerForm          = $( '#lawyerist-login #register' );
  let dismissButton         = $( '#lawyerist-login .dismiss-button' );

  // Prevents login links from activating.
  allLoginRegisterLinks.click( function( e ) {
    e.preventDefault();
  });

  // Switches to the correct form (even while hidden) for the link.
  loginLinks.click( function() {
    loginForm.show();
    registerForm.hide();
  });

  registerLinks.click( function() {
    loginForm.hide();
    registerForm.show();
  });


  // Controls the modal pop-up and close actions.
  allLoginRegisterLinks.click( function() {
    loginModal.show( 145 );
    loginScreen.show();
  });

  dismissButton.click( function() {
    loginModal.hide( 95 );
    loginScreen.hide();
  });


  // Controls navigation within #lawyerist-login.
  $( '#lawyerist-login .link-to-register' ).click( function() {
    loginForm.hide( 95 );
    registerForm.show( 145 );
  });

  $( '#lawyerist-login .back-to-login' ).click( function() {
    loginForm.show( 145 );
    registerForm.hide( 95 );
  });


  // Changes/removes stuff when the confirmation wrapper is visible.
  $( document ).on( 'gform_confirmation_loaded', function() {
    dismissButton.hide();
    $( '#lawyerist-login #register h2' ).html( 'Welcome to the Lawyerist Insider Community!' );
    $( '#lawyerist-login #register p.remove_bottom' ).hide();
  });

})( jQuery );
// End Lawyerist Login/Register

/**
* Expander
*
* Opens and closes things with the .expand-this class.
*/
( function( $ ) {

  let hideStuff = $( '.expandthis-hide' );
  let showStuff = $( '.expandthis-click' );

  if ( hideStuff.length > 0 ) {

    hideStuff.hide();

    showStuff.click( function() {
      $( this ).toggleClass( 'open' ).next( '.expandthis-hide' ).slideToggle( 145 );
      $( '.open' ).not( this ).toggleClass( 'open' ).next( '.expandthis-hide' ).slideToggle( 95 );
    });

  }

})( jQuery );


// WooCommerce Select Drop-Downs
( function( $ ) {

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

})( jQuery );
// End WooCommerce Select Drop-Downs


// Sticky Platinum Sponsors Widget
( function( $ ) {

  function stickySidebar() {

    // Checks to see if the sidebar ad is present.
    if ( $( '#platinum-sponsors-widget' ).length > 0 ) {

      var windowTop     = $( window ).scrollTop() + $( '#wpadminbar' ).outerHeight();
      var contentTop    = $( '#column_container' ).offset().top - 30;

      if ( windowTop > contentTop ) {
        $( '#platinum-sponsors-widget' ).addClass( 'stick' );
      }

      if ( windowTop < contentTop ) {
        $( '#platinum-sponsors-widget' ).removeClass( 'stick' );
      }

    }

  }

  $( window ).scroll( stickySidebar );
  stickySidebar();

})( jQuery );
// End Sticky Platinum Sponsors Widget


// Dismissible Call to Action
( function() {

    var notice, noticeId, storedNoticeId, dismissButton;

    notice = document.querySelector( '.dismissible-notice' );

    if ( !notice ) {
      return;
    }

    dismissButton   = document.querySelector( '#book_cta .dismiss-button' );
    noticeId        = notice.getAttribute( 'data-id' );
    storedNoticeId  = localStorage.getItem( 'lawyeristNotices' );

    if ( noticeId !== storedNoticeId ) {
  		notice.style.display = 'block';
  	}

    dismissButton.addEventListener( 'click', function() {
  		notice.style.display = 'none';
      localStorage.setItem( 'lawyeristNotices', noticeId );
    });

})( jQuery );
// End Dismissible Call to Action
