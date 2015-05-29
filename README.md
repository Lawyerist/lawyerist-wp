# A custom WordPress theme for Lawyerist.com

2015-05-29
----------

* Add audio post format.
* Style default page links.


2015-05-20
----------

* Add breadcrumbs to download pages.


2015-05-18
----------

* Fix: ignore sticky posts on front page.

2015-05-01
----------

* New issue nav footer.


2015-04-24
----------

* Make headlines smaller on index/archive lists.


2015-04-23
----------

* Rough draft of new author bio pages.
* Related changes, such as adding Twitter link to footer and pages.
* Reinstall AP4.


2015-04-14
----------

* Remove Feedburner email subscription option.
* Combine Articles and Notes into a single feed, Articles. Combine them on the front page, as well, and adjust the header nav.


2015-04-10
----------

* Fixed a bug where an author page with a Note showing would be noindexed.


2015-03-25
----------

* Post footer issue nav, take 1.


2015-03-24
----------

* Remove Topics section from front page.
* Move prev/next links to the bottom of single.php.
* Remove related posts on single.php.
* Add link to issue landing page to post footer.


2015-03-23
----------

* Remove popular posts widget from functions.php.
* Allow PHP in text widgets.
* Popular posts widget is now a regular widget so we can fix it in place with a plugin.


2015-03-19
----------

* Move author_bio_footer into the loop so it prints with Print Friendly.

2015-03-18
----------

* Add custom taxonomy for issues.
* Create landing page template for issues (identical to archive.php for now).

2015-03-05
----------

* Create automatic cache buster for stylesheet

2015-02-22
----------

* Add header to native search results.
* Add custom taxonomy for series.
* Simplify archive headers and include custom taxonomies.


2015-02-20
----------

* Show Submit for Review button on draft posts.
* Limit statuses contributors can access to draft, pending, and in-revision.


2015-02-17
----------

* Make full-width featured images the default.
* Show featured images only on the first page of multi-page posts.


2015-01-28
----------

* Un-raise the ads.

2015-01-27
----------

* Put max-width on header blocks.
* Make blockquotes better.
* Remove Material elements.
* Flatten forms.


2015-01-23
----------

* Fix heading sizes on mobile.


2015-01-22
----------

* Went crazy on Material-style elements, especially on the front page.
* Fixed a bunch of responsive things that didn't work quite right.
* Pulled some unused cruft out of style.css.


2015-01-15
----------

* Add "more" tabs to bottom of front-page sections.

2015-01-01
----------

* Move sidebar to the right.
* Hide AP4 until we have ads for it or sell out all our other ad positions.
* Add notes to page templates.


2014-12-19
----------

* Add image size for top featured post.


2014-11-19
----------

* Remove list-authors shortcode (moved to Lawyerist Shortcodes plugin).
* Style pullquotes.


2014-11-04
----------

* De-sanitize author bio field (this should be moved to a plugin).


2014-10-29
----------

* Remove top margin on paragraphs.
* Fix side padding of notes on front page on mobile.
* Fix responsiveness on Safari for iOS.
* Fix header responsiveness (hide nav menu when narrowing to single column).
* Add bottom margin to pinned post headline.
* Put comment counts back on the front page (although since the front page pulls comment counts from WordPress, not Disqus, there is frequently a delay before the count is updated after a new comment is approved).


2014-10-18
----------

* Remove resets; use normalize.css instead.
* Form styling tweaks.


2014-10-16
----------

* Footer updates.


2014-10-14
----------

* Add Landing Page template.


2014-10-03
----------

* noindex notes (in head.php)
* Lots of other little layout and style changes made over the last few weeks.


2014-09-19
----------

* Blur featured article images on front page.


2014-09-18
----------

* Add notes to the front page.
* Lots of front-page style tweaks.


2014-09-17
----------

* Fix pagination on articles and notes pages.
* Add gallery post format.
* Style 3-column gallery layout.
* Add bottom margins for embed and iframe.
* Update Genericons.
* Remove articles and notes page templates because they aren't necessary.
* Make articles and notes pages work, in general.
* Move discussions above topics on front page.


2014-09-16
----------

* Change FORUM link in header to Q&A.
* Add NEWSLETTER to header.
* Simplify the "more ways to connect" icon in the header.
* Add support for post formats.
* Lots of small tweaks to the front page.
* Fix pagenav.


2014-09-09
----------

* Remove bookstore from front page.


2014-09-03
----------

* Remove "books" link from header.

2014-08-25
----------

* Fixed UTM codes on topics.
* Added UTM codes on pinned, featured, most-discussed, and bookstore posts.
* Add screenshot.png


2014-08-22
----------

* Add smaller thumbnail sizes.


2014-08-19
----------

* Gravity Forms style tweaks.
* Change settings for HTTPS.
* Updates Sites note.


2014-08-18
----------

* Make Google happy with our schema.

2014-08-15
----------

* Fix Swiftype search box in the content column.
* Add category to single post pages.


2014-08-08
----------

* Switch to Jetpack/Sharedaddy social sharing icons.


2014-08-06
----------

* Promote _humor_ tag to _Legal Humor_ category.


2014-08-02
----------

* Re-fix buttons on iOS.


2014-07-31
----------

* Fix responsiveness for size-full images.
* Add categories section to front page.


2014-07-29
----------

* Adjust leaderboard and sidebar for visitors with ad blockers enabled.


2014-07-18
----------

* Move navigation to below the post body.


2014-07-17
----------

* Fix button appearance on iOS.
* Fix Swiftype search on 404 page and move Swiftype script to the footer for faster page rendering.


2014-07-01
----------

* Fix radio button and checkbox styling on MailChimp forms.


2014-06-30
----------

* Update 404 page newsletter signup form.


2014-06-24
----------

* Chance "Store" to "Books" in header.
* Remove Insider signup from header.
* Add email subscription icon to header.
* Add submenus to navigation.
* Style *Insider* signup form for the sidebar.
* Add author list shortcode and style author list on "About" page.


2014-05-27
----------

* Make author avatars round.
* Move popular post image to left, make them circular.


2014-05-22
----------

* Add bookstore to front page.
* Also fixed responsiveness for discussions and sidebar.


2014-05-20
----------

* Make form label font sizes consistent (they were showing up larger on Gravity Forms forms).
* Make input field font sizes consistent.
* Make sidebar form buttons the same font-size as all buttons.


2014-05-19
----------

* Add newsletter signup form to 404 page.


2014-05-14
----------

* Clean up form styles.


2014-05-10
----------

* Remove Sites Network box from front page.
* Increase number of featured posts shown.
* Add Sites note to blog roundup tag.


2014-05-09
----------

* Align tags list on posts.
* Adjust PrintFriendly button positioning.


2014-05-08
----------

* Use featured_thumb_2 for top post on front page (speeds things up since it's a smaller image, and improves rendering on mobile).
* Make top post headline the same size as all the headlines on mobile.
* Make prev/next links full-width on mobile.
* Fix screwy widths for discussion boxes on mobile.
* Fix footer on mobile.


2014-05-05
----------

* Style sidebar Submit a Link form.


2014-04-29
----------

* Reorganize front page.
* Add shadows to discussion thumbnails.


2014-04-22
----------

* Remove editor-styles (added to lawyerist-admin-plugin).


2014-04-21
----------

* Simplify tag intro on archive pages.
* Update archive title tags.


2014-04-18
----------

* Fix Juiz sharing icons alignment & responsiveness.


2014-04-17
----------

* Remove bottom margin on author pages.


2014-04-16
----------

* Fix category and tag description display on archive pages.
* Remove top border on notes, alerts, and pullouts.
* Add tag list to single post pages.


2014-04-15
----------

* Add Pinterest coloring to Juiz sharing icons.
* Get rid of ugly 3D button effect.
* Style .post_index.


2014-04-14
----------

* Put popular posts widget back on front page.


2014-04-08
----------

* Remove need for "no image" tag on slideshows.


2014-04-03
----------

* Fix monospace fonts for `code` and `pre` tags.


2014-03-29
----------

* Turn off pagination in the RSS feed.


2014-03-21
----------

* Fix sticky post style for index and archive pages.
* Add sticky-post loop to front page.


2014-03-17
----------

* Adjust #archive_header padding.
* Clean up functions.php a bit.
* Remove dashboard RSS widget.


2014-03-10
----------

* Added pullout for related links within a post.
* Improve p.note and p.alert styles.


2014-03-07
----------

* Better buttons.


2014-03-06
----------

* Update header nav.


2014-03-04
----------

* Adjust spacing in header.
* Remove .custom from stylesheet.
* Make buttons a little better (they still need work).


2014-02-28
----------

* Remove shadow from .menu-default-container (I have no idea why I gave it a shadow).
* Fix nav menu height.


2014-02-26
----------

* Consolidate stylesheets.
* Remove IE 6 stylesheet.
* Clean up stylesheet a bit.
* Make 404 page funnier (I hope).


2014-02-25
----------

* Un-italicize prev/next links.


2014-02-14
----------

* Fix z-index layering on front page.
* Remove Source Code Pro (Google Font).

2014-02-11
----------

* Update front page tabs.
* Updates Sites color on front page.
* Change "From the Archives" tag colors.


2014-02-06
----------

* Changes to blog-forum-sites nav.


2014-01-21
----------

* Front page tabs.


2014-01-18
----------

* Switch back to Google Fonts API.
* Tweak styles.


2014-01-17
----------

* Include Roboto Slab regular and bold font faces.
* Include Source Sans Pro regular, bold, and italic font faces.
* Start replacing font styles with the above.
* Add featured posts and most-discussed headers to front page.


2014-01-17
----------

* Add "From the Archives" tag to featured  posts.
* Adjust title tags.


2014-01-16
----------

* Update "Read the latest posts ->" link on front page.


2014-01-15
----------

* Change front page title tag to "Featured Posts."


2014-01-14
----------

* Fix sidebar ads on responsive layouts.
* Fix footer width on non-responsive layout.
* Configure front-page to show only featured posts (other posts will show up on lawyerist.com/articles).
* Fix total shares box on Juiz sharing buttons.
* Fix bottom margin on "see all articles" link on front page.


2014-01-07
----------

* Wrap \<code> and \<pre> tags.


2013-12-02
----------

* Remove #header bottom border on mobile.


2013-12-26
----------

* Remove REM-unit-polyfill script (wasn't working).
* Go back to manual IE 8 stylesheet (ugh).


2013-12-23
----------

* Fix line-height property on related posts.
* Fix images with captions.

2013-12-22
----------

* Mobile/responsive makeover.


2013-12-19
----------

* Add body_class and post_class functions to templates.
* Reorganize style.css and remove unnecessary styles, to prepare to re-jigger the site's responsiveness.


2013-12-13
----------

* Fix RSS feeds displayed on Buyer's Guide pages.
* Update custom contributor permissions.
* Copy loop from index.php to archive.php, and remove the $post_num variable.
* Fix excerpt right padding (to keep text from flowing under thumbnails) on index and archive lists.
* Add UTM codes to sidebar popular posts widget.
* Update footer.
* Add top border and padding to Theia post slider footer.


2013-12-10
----------

* Streamline comment bubbles.


2013-12-09
----------

* Add no-image tag (works better with Theia post slider posts).


2013-11-22
----------

* Make social network names white in Juiz sharing buttons.


2013-11-21
----------

* Re-installed Juiz sharing buttons.


2013-11-15
----------

* Switch to locally-hosted fonts, and fix font weights.
* Add in-depth article schema (I think).
* Tweak .note and .alert padding.


2013-11-11
----------

* Add "smaller title" tag support.


2013-11-05
----------

* Embiggen most-discussed post thumbnails.


2013-11-04
----------

* Add sidebar ads back in on mobile.


2013-11-03
----------

* Update blockquote in editor-style.css.
* Rename changelog.md to README.md. I hope Github is happy with that.


2013-11-01
----------

* Remove Zombie Scalia.


2013-10-30
----------

* Zombie Scalia attacks!
* Remove edit page link.


2013-10-21 through 10-24 Major update
-------------------------------------

* Front page is now a static page featuring this week's posts, most-discussed posts, LAB posts, and Sites network posts. Older posts start on page 2.
* Lots of tweaks went into this. Really need to figure out a better way to organize style.css.


2013-10-15
----------

* Fix editing permissions.


2013-10-14
----------

* Drastically improve mobile site. It's still far from perfect, but it will do for now.


2013-10-10
----------

* Increased font size for featured post headlines and popular post headlines in the sidebar widget.


2013-10-07
----------

* Fix sharing icon position.
* Fix clear issues and excerpts not showing up where they ought to.


2013-10-05
----------

* Convert to relative units.
* Add edit_posts capability to Contributor role.
* Stop featured posts from displaying on archive pages.


2013-10-04
----------

* Implement new social sharing plugin.


2013-10-03
----------

* Fix featured_thumb_2 size
* Eliminate 15px padding on desktop layout.
* Eliminate multiple loops and consolidate the loop.
* Style popular posts in the sidebar the same as the featured posts and related posts footer.
* Fix width of excerpt when the post has a thumbnail.
* Bold headlines in featured posts, popular posts, and related posts.
* __Enable Onswipe__ and remove most responsive elements.


2013-10-02
----------

* Make magazine-y theme way better.
* Update related posts footer.


2013-10-01
----------

* Added editor-style.css.
* Set up multiple loops and do some basic styling for magazine-ified layout.
* Minor tweaks to index.php styles.


2013-09-30
----------

* Fix checkboxes on MailChimp signup forms.


2013-09-27
----------

* Add upload_files capability to Contributor role.


2013-09-24
----------

* Fix list styling in single.php.


2013-09-23
----------

* Fix pullquote styling.
* Style image captions.


2013-09-20
----------

* Fix Jetpack sharing footer width.
* Tweaks to responsive elements.


2013-09-12
----------

* Increase content font size on single posts and pages.


2013-09-06
----------

* Modify p.pullquote
* Fix homepage meta description.


2013-08-16
----------

* Added notes.php
* Added G+ share button script to footer.php
* Added excerpt as meta description for single posts and pages


2013-07-30
----------

* Remove leaderboard house ad


2013-07-29
----------

* Un-hide sidebar search when single-column
* Change navigation in header from "forum" to "lab"


2013-07-17
----------

* Re-styled email form on http://lawyerist.com/lawyerist-insider-newsletter/


2013-07-05
----------

I am dropping version numbers because they are meaningless. From here on out, I will just use dates.

* Re-add remove_bottom class to headlines in index.php
* Lawyerist + LAB Google Analytics tracking code added to footer
* Bold blog-forum-sites nav
* Fix byline for posts without featured images


2013-06-18, v1.03
-----------------

* Un-italicized blockquotes
* Move idTabs to footer
* Fixed img.aligncenter
* Added author bylines to index.php
* Left-align Jetpack sharing icons
* Hide excerpts on phones
* Fix li line-height in Buyer's Guide
* Other minor fixes


2013-06-13, v1.02
-----------------

* Hide Sharebar & show Jetpack sharing properly
* Remove pagenum styles
* Style buyer's guide (not perfect, but it looks decent, at least)


2013-06-13, v1.01
-----------------

Of course it didn't work right. Here's a quick fix to the nav menu.


2013-06-13, v1.0
----------------

This is basically version 1.0 of a new, custom theme for Lawyerist.com. Here's hoping it works without any major hitches.
