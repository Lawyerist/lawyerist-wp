<li id="lawyerist_sidebar_search">
	<form>
	  <input type="text" id="st-search-input" class="st-search-input" value="Search" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" />
	</form>
	<div id="st-results-container"></div>
</li>

<li class="sidebar_ads widget">
	<ul>
		<li id="ap2" class="sidebar_ad"><!-- lawyerist_ap2_sidebar1 -->
			<div id='div-gpt-ad-1356989285353-1' style='width:300px; height:250px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1356989285353-1'); });
			</script>
			</div>
		</li>
		<li id="ap3" class="sidebar_ad"><!-- lawyerist_ap3_sidebar2 -->
			<div id='div-gpt-ad-1356989285353-2' style='width:300px; height:250px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1356989285353-2'); });
			</script>
			</div>
		</li>
	</ul>
	<div class="clear"></div>
</li>


<li id="popular_posts_tabbed">
		<h3>Popular Posts</h3>
		<ul class="idTabs">
				<li><a href="#current">This Week</a></li>
				<li><a href="#all-time">All-Time</a></li>
				<li><a href="#our-picks">Our Picks</a></li>
		</ul>

		<div id="current" class="tabs_sublist">
				<?php wpp_get_mostpopular("post_type='post'&range=weekly&limit=5&stats_comments=0&thumbnail_height=60&thumbnail_width=60&post_html='<li>{thumb}<a class=\"wpp_headline\" href=\"{url}\">{text_title}</a></li>'"); ?>
		</div>

		<div id="all-time" class="tabs_sublist">
				<?php wpp_get_mostpopular("post_type='post'&range=all&limit=5&stats_comments=0&thumbnail_height=60&thumbnail_width=60&post_html='<li>{thumb}<a class=\"wpp_headline\" href=\"{url}\">{text_title}</a></li>'"); ?>
		</div>

		<div id="our-picks" class="tabs_sublist">
				<?php wpp_get_mostpopular("post_type='post'&cat='2621'&range=all&limit=5&stats_comments=0&thumbnail_height=60&thumbnail_width=60&post_html='<li>{thumb}<a class=\"wpp_headline\" href=\"{url}\">{text_title}</a></li>'"); ?>
		</div>
</li>


<?php dynamic_sidebar('sidebar_1'); ?>
