<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label for="search-field">
        <span <?php if ( is_404() ) { echo 'style="display: none;" hidden'; } ?> class="screen-reader-text">
          <?php echo _x( 'Modify your search: ', 'label' ) ?>
        </span>
    </label>
    <div id="search-input-container">
      <input id="search-field" type="search" class="search-field"
        name="s"
        placeholder="<?php echo esc_attr_x( 'Search Lawyerist.com …', 'placeholder' ) ?>"
        title="<?php echo esc_attr_x( 'Search Lawyerist.com', 'label' ) ?>"
        value="<?php echo get_search_query() ?>"
      />
    </div>
    <input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>" />
</form>
