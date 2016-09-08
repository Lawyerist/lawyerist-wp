<li id="lawyerist_sidebar_search">
	<form role="search" method="get" class="search-form" action="<?php echo home_url( '/' ); ?>">
	    <label>
	        <span hidden class="screen-reader-text"><?php echo _x( 'Search Lawyerist.com: ', 'label' ) ?></span>
	        <input type="search" class="search-field"
	          name="s"
	          placeholder="<?php echo esc_attr_x( 'Search Lawyerist.com …', 'placeholder' ) ?>"
	          title="<?php echo esc_attr_x( 'Search Lawyerist.com', 'label' ) ?>"
	        />
	    </label>
	    <input hidden type="submit" class="search-submit"
	      value="<?php echo esc_attr_x( 'Search', 'submit button' ) ?>"
	    />
	</form>
</li>

<?php if ( !has_tag('no-ads') && !is_mobile() ) { ?>

	<li class="sidebar_ads widget">
		<ul>
			<li id="ap2" class="sidebar_ad"><!-- /12659965/lawyerist_ap2_sidebar1 -->
				<div id='div-gpt-ad-1429843825352-1' style='height:250px; width:300px;'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1429843825352-1'); });
				</script>
				</div>
			</li>
			<li id="ap3" class="sidebar_ad"><!-- /12659965/lawyerist_ap3_sidebar2 -->
				<div id='div-gpt-ad-1429843825352-2' style='height:250px; width:300px;'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1429843825352-2'); });
				</script>
				</div>
			</li>
		</ul>
		<div class="clear"></div>
	</li>

<?php } ?>

<?php dynamic_sidebar('sidebar_1'); ?>
