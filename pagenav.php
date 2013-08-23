/* PAGENUM */

#pagenum {
	display:block;
	margin:0 auto;
	text-align:center;
	width:640px;
}

.page-number a,
.current-page-number {
	display:inline-block;
	float:left;
	font-size:18px;
	margin-right:5px;
	padding:10px;
}

.page-number.pagenum_first a,
.page-number.pagenum_last a {
	padding:10px 15px;
	text-decoration:none;
}

.page-number a {
	background-color:#ddd;
	border-radius:19px;
	-moz-border-radius:19px;
	-webkit-border-radius:19px;
	min-width:18px;
	text-decoration:none;
}

.page-number a:hover {
	background-color:#bbb;
}

.current-page-number {
	color:#111;
	font-weight:normal;
}

<!-- Nest within pagenav -->
<div id="pagenum">
	<?php $pages_to_show = 4;
	
	global $request, $posts_per_page, $wpdb, $paged;

	$custom_range = round($pages_to_show/2);
	if (!is_single()) {
		if(!is_archive() || is_author()) {
			preg_match('#FROM\s(.*)\sORDER BY#siU', $request, $matches);
		}
		else {
			preg_match('#FROM\s(.*)\sGROUP BY#siU', $request, $matches);
		}
		$blog_post_count = $matches[1];
		$numposts = $wpdb->get_var("SELECT COUNT(DISTINCT ID) FROM $blog_post_count");
		$max_page = ceil($numposts /$posts_per_page);
		if(empty($paged)) {
			$paged = 1;
		}
		if($max_page > 1 || $always_show) {
			if ($paged >= ($custom_range+2)) {
				echo '<div class="page-number pagenum_first"><a href="'.get_pagenum_link(1).'">first page</a></div>';
			}
			for($i = $paged - $custom_range; $i <= $paged + $custom_range; $i++) {
				if ($i >= 1 && $i <= $max_page) {
					if($i == $paged) {
						echo "<div class='current-page-number' title='$paged of $max_page'>$i</div>";
					}
					else {
						echo '<div class="page-number"><a href="'.get_pagenum_link($i).'">'.$i.'</a></div>';
					}
				}
			}
			if (($paged+$custom_range) < ($max_page)) {
				echo '<div class="page-number pagenum_last"><a href="'.get_pagenum_link($max_page).'">last page</a></div>';
			}
		}
	} ?>
	<div class="clear"></div>
</div>