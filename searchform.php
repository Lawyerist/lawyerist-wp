<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
    <label>
        <span <?php if ( is_404() ) { echo 'style="display: none;" hidden'; } ?> class="screen-reader-text">
          <?php echo _x( 'Modify your search: ', 'label' ) ?>
        </span>
        <input type="search" class="search-field"
          name="s"
          placeholder="<?php echo esc_attr_x( 'Search Lawyerist.com …', 'placeholder' ) ?>"
          title="<?php echo esc_attr_x( 'Search Lawyerist.com', 'label' ) ?>"
          value="<?php echo get_search_query() ?>"
        />
    </label>
    <input hidden type="submit" class="search-submit"
      value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>"
    />
</form>
