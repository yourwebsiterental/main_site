<?php
/**
 * Header Fourteen
 *
 * @package Minimal Travel
 */

?>
<header id="masthead" class="site-header style-fourteen" itemscope itemtype="http://schema.org/WPHeader" >
	<div class="header-t">
		<div class="container">
			<div class="header-social">
				<?php vilva_social_links(); ?>
			</div><!-- .header-social -->			
			<?php vilva_primary_nagivation(); ?>
			<div class="right">
				<?php minimal_travel_search_cart(); ?>
			</div><!-- .right -->
		</div>
	</div><!-- .header-t -->
	<div class="header-mid">
		<div class="container">
			<?php vilva_site_branding(); ?>
		</div>
	</div><!-- .header-mid -->
</header><!-- .site-header -->