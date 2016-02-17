	<li id="lawyerist_sidebar_search">
		<form>
		  <input type="text" id="st-search-input" class="st-search-input" value="Search" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" />
		</form>
		<div id="st-results-container"></div>
	</li>

<?php if ( !has_tag('no-ads') || !is_mobile() ) { ?>

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
			<li id="lawyerist_sidebar_signup" class="sidebar_ad"><!-- /12659965/lawyerist_sidebar_signup -->
				<div id='div-gpt-ad-1455732796230-0' style='height:400px; width:300px;'>
				<script type='text/javascript'>
				googletag.cmd.push(function() { googletag.display('div-gpt-ad-1455732796230-0'); });
				</script>
				</div>
			</li>
		</ul>
		<div class="clear"></div>
	</li>

<?php } ?>

<?php dynamic_sidebar('sidebar_1'); ?>
