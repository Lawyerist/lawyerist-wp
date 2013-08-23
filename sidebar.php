<li id="lawyerist_sidebar_search">
	<form>
	  <input type="text" id="st-search-input" class="st-search-input" value="Search" onblur="if (this.value == '') {this.value = 'Search';}" onfocus="if (this.value == 'Search') {this.value = '';}" />
	</form>
	<div id="st-results-container"></div>
	<script type="text/javascript">
	  var Swiftype = window.Swiftype || {};
	  (function() {
		Swiftype.key = 'Y6pVA25sVzapo465JPtR';
		Swiftype.inputElement = '#st-search-input';
		Swiftype.resultContainingElement = '#st-results-container';
		Swiftype.attachElement = '#st-search-input';
		Swiftype.renderStyle = "overlay";

		var script = document.createElement('script');
		script.type = 'text/javascript';
		script.async = true;
		script.src = "//swiftype.com/embed.js";
		var entry = document.getElementsByTagName('script')[0];
		entry.parentNode.insertBefore(script, entry);
	  }());
	</script>
</li>

<li class="sidebar_ads">
	<ul>
		<li>
			<!-- lawyerist_ap2_sidebar1 -->
			<div id='div-gpt-ad-1356989285353-1' style='width:300px; height:250px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1356989285353-1'); });
			</script>
			</div>
		</li>
		<li>
			<!-- lawyerist_ap3_sidebar2 -->
			<div id='div-gpt-ad-1356989285353-2' style='width:300px; height:250px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1356989285353-2'); });
			</script>
			</div>
		</li>
		<li>
			<!-- lawyerist_ap4_halfpage -->
			<div id='div-gpt-ad-1356989285353-3' style='width:300px; height:600px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1356989285353-3'); });
			</script>
			</div>
		</li>
	</ul>
</li>

<li id="popular_posts_tabbed">
	<h3>Popular Posts</h3>	
	<ul class="idTabs"> 
		<li><a href="#current">This Week</a></li> 
		<li><a href="#all-time">All-Time</a></li> 
		<li><a href="#our-picks">Our Picks</a></li>
	</ul>

	<div id="current" class="tabs_sublist">
			<?php wpp_get_mostpopular("range=weekly&limit=5&stats_comments=0&thumbnail_height=90&thumbnail_width=90"); ?>
	</div> 

	<div id="all-time" class="tabs_sublist">
		<?php wpp_get_mostpopular("range=all&limit=5&stats_comments=0&thumbnail_height=90&thumbnail_width=90"); ?>
	</div>

	<div id="our-picks" class="tabs_sublist">
		<?php wpp_get_mostpopular("cat='2621'&range=all&limit=5&stats_comments=0&thumbnail_height=90&thumbnail_width=90"); ?>
	</div>
</li>

<?php dynamic_sidebar('sidebar_1'); ?>