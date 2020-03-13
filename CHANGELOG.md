# Changelog for Lawyerist.com

All notable changes to this project will be documented in this file. The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [In Development]
- Vendor recommender for product portals.


## [Unreleased]
- Remove partner dashboard page from signup wall.
- Don't show call to action on WooCommerce pages.
- Un-echo HTML in template parts.
- Fix sponsored posts not displaying.
- Fix bug that was displaying the sticky post container when there weren't any.
- Add LabCon Materials template and praise cards.


## [5.2.1] - 2020-02-14

### [Changed]
- Revert platinum sidebar code so it pulls from product pages, not Partners.


## [5.2.0] - 2020-02-11

### [Changed]
- Sponsored posts are now associated with Partners rather than the (removed) Sponsors custom taxonomy.

### [Removed]
- Removed Sponsors custom taxonomy (replaced by Partners custom post type).


## [5.1.0] - 2020-02-11

### [Added]
- Configure premium product page details for new partner dashboards.

### [Changed]
- Update the platinum sidebar code so it pulls from Partners instead of product pages.


## [5.0.1] - 2020-01-30

### [Added]
- Add a .hidden class consistent accessibility best practices.

### [Changed]
- Updates to product rating functions so they work better with a plugin in development.
- Allow .greybutton to be spelled .graybutton so I don't have to check the spelling in the stylesheet every time I want to make a grey/gray button.

### [Fixed]
- Define $classes in header.php before using it.
- Update thumbnail size function on product pages.
- Fix select field padding so there is enough room for the down arrow.


## [5.0.0] - 2020-01-21

### [Changed]
- Changelog added.
- style.css updated with current version number.
- Lab Workshop posts removed from Yoast SEO–generated sitemap.

I have no idea what version we're on, so I'm arbitrarily starting at 5. Before now, the only record of changes is in the commit logs and diffs.
