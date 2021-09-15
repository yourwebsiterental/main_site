<?php
/**
 * Header One
 * 
 * @package Minimal Travel
 */
?>
<header id="masthead" class="site-header style-one" itemscope itemtype="http://schema.org/WPHeader">
    <div class="header-t">
        <div class="container">
            <?php vilva_secondary_navigation(); ?>
            <div class="right">
                <?php if( vilva_social_links( false ) ) : ?>
                    <div class="header-social">
                        <?php  vilva_social_links(); ?>
                    </div><!-- .header-social -->
                <?php endif; ?>
                <?php minimal_travel_search_cart(); ?>            
            </div><!-- .right -->
        </div>
    </div><!-- .header-t -->

    <div class="header-mid">
        <div class="container">
            <?php vilva_site_branding(); ?>
        </div>
    </div><!-- .header-mid -->

    <div class="header-bottom">
        <div class="container">
            <?php vilva_primary_nagivation(); ?>
        </div>
    </div><!-- .header-bottom -->
</header>