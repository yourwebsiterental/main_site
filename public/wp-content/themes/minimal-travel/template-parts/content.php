<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Minimal Travel
 */

global $wp_query;

$layout         = get_theme_mod( 'homepage_layout', 'nine' );
$post_arr       = array( 'one', 'nine' );
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); echo ' itemscope itemtype="https://schema.org/Blog"'; ?>>
    
	<?php   

    /**
     * @hooked vilva_entry_first_header - 10
     * @hooked vilva_post_thumbnail - 20
    */
    do_action( 'vilva_before_post_entry_content' );     

    if ( ( is_home() && in_array( $layout, $post_arr ) ) ) echo '<div class="content-wrap">';

    /**
     * @hooked vilva_entry_header   - 10
     * @hooked vilva_entry_content  - 15
     * @hooked vilva_entry_footer   - 20
    */
    do_action( 'vilva_post_entry_content' );

    if ( ( is_home() && in_array( $layout, $post_arr ) ) ) echo '</div>';
    ?>
</article><!-- #post-<?php the_ID(); ?> -->
