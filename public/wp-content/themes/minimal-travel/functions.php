<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * After setup theme hook
 */
function minimal_travel_theme_setup(){

    /**Image size for slider */
    add_image_size( 'vilva-slider', 1920, 760, true );
    add_image_size( 'vilva-featured-five', 420, 586, true );

    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain( 'minimal-travel', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'minimal_travel_theme_setup', 100 );

/**
 * Load assets.
 */
function minimal_travel_enqueue_styles() {
    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];

    if( vilva_is_woocommerce_activated() ){
        $dependencies = array( 'vilva-woocommerce', 'owl-carousel', 'vilva-google-fonts' );  
    }else{
        $dependencies = array( 'owl-carousel', 'vilva-google-fonts' );
    }
    
    wp_enqueue_style( 'vilva', get_template_directory_uri() . '/style.css', $dependencies );
    wp_enqueue_style( 'minimal-travel', get_stylesheet_directory_uri() . '/style.css', array( 'vilva' ), $version );
    wp_enqueue_script( 'minimal-travel', get_stylesheet_directory_uri() . '/js/custom.js', array( 'jquery', 'owl-carousel' ), $version, true );
    
    $array = array( 
        'rtl'           => is_rtl(),
        'auto'          => (bool) get_theme_mod( 'slider_auto', true ),
        'loop'          => (bool) get_theme_mod( 'slider_loop', true ),
    );
    
    wp_localize_script( 'minimal-travel', 'minimal_travel_data', $array );
}
add_action( 'wp_enqueue_scripts', 'minimal_travel_enqueue_styles', 10 );

function minimal_travel_remove_parent_filters(){
    remove_action( 'customize_register', 'vilva_customize_register_appearance' );
    remove_action( 'wp_head', 'vilva_dynamic_css', 99 );
}
add_action( 'init', 'minimal_travel_remove_parent_filters' );

/**
 * Customizer Settings
 */
function minimal_travel_customizer_register( $wp_customize ){

    /** Adding theme demo info */
    $wp_customize->add_section( 'theme_info', 
        array(
            'title'    => __( 'Demo & Documentation', 'minimal-travel' ),
            'priority' => 6,
        )
    );

    /** Important Links */
    $wp_customize->add_setting( 'theme_info_theme',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $theme_info = '<p>';
    $theme_info .= sprintf( __( 'Demo Link: %1$sClick here.%2$s', 'minimal-travel' ),  '<a href="' . esc_url( 'https://blossomthemes.com/theme-demo/?theme=minimal-travel' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p><p>';
    $theme_info .= sprintf( __( 'Documentation Link: %1$sClick here.%2$s', 'minimal-travel' ),  '<a href="' . esc_url( 'https://docs.blossomthemes.com/minimal-travel/' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p>';

    $wp_customize->add_control( new Vilva_Note_Control( $wp_customize,
        'theme_info_theme', 
            array(
                'section'     => 'theme_info',
                'description' => $theme_info
            )
        )
    );

    /** Appearance Settings */
    $wp_customize->add_panel( 
        'appearance_settings',
         array(
            'priority'    => 50,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Appearance Settings', 'minimal-travel' ),
            'description' => __( 'Customize Typography, Header Image & Background Image', 'minimal-travel' ),
        ) 
    );
    /** Primary Color*/
    $wp_customize->add_setting( 
        'primary_color', 
        array(
            'default'           => '#45b29d',
            'sanitize_callback' => 'sanitize_hex_color',
        ) 
    );

    $wp_customize->add_control( 
        new WP_Customize_Color_Control( 
            $wp_customize, 
            'primary_color', 
            array(
                'label'       => __( 'Primary Color', 'minimal-travel' ),
                'description' => __( 'Primary color of the theme.', 'minimal-travel' ),
                'section'     => 'colors',
                'priority'    => 5,
            )
        )
    );

    /** Typography Settings */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'    => __( 'Typography Settings', 'minimal-travel' ),
            'priority' => 20,
            'panel'    => 'appearance_settings'
        )
    );
    
    /** Primary Font */
    $wp_customize->add_setting(
        'primary_font',
        array(
            'default'           => 'Montserrat',
            'sanitize_callback' => 'vilva_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Vilva_Select_Control(
            $wp_customize,
            'primary_font',
            array(
                'label'       => __( 'Primary Font', 'minimal-travel' ),
                'description' => __( 'Primary font of the site.', 'minimal-travel' ),
                'section'     => 'typography_settings',
                'choices'     => vilva_get_all_fonts(),   
            )
        )
    );
    
    /** Secondary Font */
    $wp_customize->add_setting(
        'secondary_font',
        array(
            'default'           => 'Karma',
            'sanitize_callback' => 'vilva_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Vilva_Select_Control(
            $wp_customize,
            'secondary_font',
            array(
                'label'       => __( 'Secondary Font', 'minimal-travel' ),
                'description' => __( 'Secondary font of the site.', 'minimal-travel' ),
                'section'     => 'typography_settings',
                'choices'     => vilva_get_all_fonts(),   
            )
        )
    );  

    /** Font Size*/
    $wp_customize->add_setting( 
        'font_size', 
        array(
            'default'           => 16,
            'sanitize_callback' => 'vilva_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Vilva_Slider_Control( 
            $wp_customize,
            'font_size',
            array(
                'section'     => 'typography_settings',
                'label'       => __( 'Font Size', 'minimal-travel' ),
                'description' => __( 'Change the font size of your site.', 'minimal-travel' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 50,
                    'step'  => 1,
                )                 
            )
        )
    );

    /** Move Background Image section to appearance panel */
    $wp_customize->get_section( 'colors' )->panel              = 'appearance_settings';
    $wp_customize->get_section( 'colors' )->priority           = 10;
    $wp_customize->get_section( 'background_image' )->panel    = 'appearance_settings';
    $wp_customize->get_section( 'background_image' )->priority = 15;

    /** Adding panel for layouts */
    $wp_customize->add_panel( 
        'layout_settings',
         array(
            'priority'    => 45,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'Layout Settings', 'minimal-travel' ),
            'description' => __( 'Customize Typography, Header Image & Background Image', 'minimal-travel' ),
        ) 
    );

    /** Move general layout section to Layout panel */
    $wp_customize->get_section( 'general_layout_settings' )->panel       = 'layout_settings';
    $wp_customize->get_section( 'general_layout_settings' )->title       = __( 'General Layout Settings', 'minimal-travel' );

    /** Header Layout Settings */
    $wp_customize->add_section(
        'header_layout_section',
        array(
            'priority'  => 5,
            'title'     => __( 'Header Layout', 'minimal-travel' ),
            'panel'     => 'layout_settings',
        )
    );

    $wp_customize->add_setting( 
        'header_menu_layout', 
        array(
            'default'           => 'fourteen',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );

    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'header_menu_layout',
            array(
                'section'     => 'header_layout_section',
                'label'       => __( 'Header Layout', 'minimal-travel' ),
                'description' => __( 'Choose the layout of the header for your site.', 'minimal-travel' ),
                'choices'     => array(
                    'one'   => get_stylesheet_directory_uri() . '/images/header/one.jpg',
                    'fourteen'  => get_stylesheet_directory_uri() . '/images/header/fourteen.jpg',
                )
            )
        )
    );

    /** Slider Layout Settings */
    $wp_customize->add_section(
        'slider_layout_section',
        array(
            'priority'  => 10,
            'title'     => __( 'Slider Layout', 'minimal-travel' ),
            'panel'     => 'layout_settings',
        )
    );

    $wp_customize->add_setting( 
        'slider_layout', 
        array(
            'default'           => 'eight',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );

    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'slider_layout',
            array(
                'section'     => 'slider_layout_section',
                'label'       => __( 'Slider Layout', 'minimal-travel' ),
                'description' => __( 'Choose the layout for the slider for your site.', 'minimal-travel' ),
                'choices'     => array(
                    'one'   => get_stylesheet_directory_uri() . '/images/slider/one.jpg',
                    'eight' => get_stylesheet_directory_uri() . '/images/slider/eight.jpg',
                )
            )
        )
    );

    /** Homepage Layout Settings */
    $wp_customize->add_section(
        'homepage_layout_section',
        array(
            'priority'  => 10,
            'title'     => __( 'Homepage Layout', 'minimal-travel' ),
            'panel'     => 'layout_settings',
        )
    );

    $wp_customize->add_setting( 
        'homepage_layout', 
        array(
            'default'           => 'nine',
            'sanitize_callback' => 'vilva_sanitize_radio'
        ) 
    );

    $wp_customize->add_control(
        new Vilva_Radio_Image_Control(
            $wp_customize,
            'homepage_layout',
            array(
                'section'     => 'homepage_layout_section',
                'label'       => __( 'Homepage Layout', 'minimal-travel' ),
                'description' => __( 'Choose the layout for the homepage of your site.', 'minimal-travel' ),
                'choices'     => array(
                    'one'    => get_stylesheet_directory_uri() . '/images/home/one.jpg',
                    'nine' => get_stylesheet_directory_uri() . '/images/home/nine.jpg',
                )
            )
        )
    );
}
add_action( 'customize_register', 'minimal_travel_customizer_register', 40 );

function vilva_body_classes( $classes ) {

    $homepage_layout        = get_theme_mod( 'homepage_layout', 'nine' );
    $editor_options         = get_option( 'classic-editor-replace' );
    $allow_users_options    = get_option( 'classic-editor-allow-users' );
    
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of custom-background-image to sites with a custom background image.
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }
    
    // Adds a class of custom-background-color to sites with a custom background color.
    if ( get_background_color() != 'ffffff' ) {
        $classes[] = 'custom-background-color';
    }   

    if ( ( is_archive() && !( vilva_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() ) ) && !( vilva_is_delicious_recipe_activated() && ( is_post_type_archive( 'recipe' ) || is_tax( 'recipe-course' ) || is_tax( 'recipe-cuisine' ) || is_tax( 'recipe-cooking-method' ) || is_tax( 'recipe-key' ) || is_tax( 'recipe-tag' ) ) ) ) || is_search() || is_home() ) {
        $classes[] = 'post-layout-' . $homepage_layout;
    }

    if ( !vilva_is_classic_editor_activated() || ( vilva_is_classic_editor_activated() && $editor_options == 'block' ) || ( vilva_is_classic_editor_activated() && $allow_users_options == 'allow' && has_blocks() ) ) {
        $classes[] = 'vilva-has-blocks';
    }

    if ( is_page() || is_single() ) {
        $classes[] = 'underline';
    }

    if( is_singular( 'post' ) ){        
        $classes[] = 'single-style-four';
    }

    $classes[] = vilva_sidebar( true );
    
    return $classes;
}

function vilva_default_image_text_image_size(){
    $return = 'vilva-featured-five';

    return $return;
}

/**
 * Header Start
*/
function vilva_header(){ 
    $header_array = array( 'one', 'fourteen' );
    $header_layout = get_theme_mod( 'header_menu_layout', 'fourteen' );
    if( in_array( $header_layout, $header_array ) ){            
        get_template_part( 'headers/' . $header_layout );
    }
}

function minimal_travel_search_cart(){ 

    $ed_search     = get_theme_mod( 'ed_header_search', true );
    $ed_cart       = get_theme_mod( 'ed_shopping_cart', true ); 

    if ( $ed_search ) { ?>
        <div class="header-search">                
        <button class="search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                <i class="fas fa-search"></i>
            </button>
            <div class="header-search-wrap search-modal cover-modal" data-modal-target-string=".search-modal">
                <div class="header-search-inner-wrap">
                    <?php get_search_form(); ?>
                    <button class="close" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false"></button>
                </div>
            </div>
        </div><!-- .header-search -->
    <?php } 
    if ( vilva_is_woocommerce_activated() && $ed_cart ) vilva_wc_cart_count(); 
}

/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function vilva_post_thumbnail() {
    global $wp_query;
    $layout         = get_theme_mod( 'homepage_layout', 'nine' );
    $image_size     = 'thumbnail';
    $sidebar        = vilva_sidebar();
    $ed_crop_single = get_theme_mod( 'ed_crop_single', false );  
    $ed_featured_image = get_theme_mod( 'ed_featured_image', true );  

    if( is_home() ){        
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';

            if( $layout == 'one' ) {
                if( $wp_query->current_post == 0 ) :                
                    $image_size = ( $sidebar ) ? 'vilva-blog-one' : 'vilva-slider-one';
                else:
                    $image_size = ( $sidebar ) ? 'vilva-blog' : 'vilva-featured-four';
                endif;
            }else{
                $image_size = ( $sidebar ) ? 'vilva-blog-one' : 'vilva-slider-one';
            }

            if( has_post_thumbnail() ){                        
                the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
            }else{
                vilva_get_fallback_svg( $image_size );//fallback
            }         
        echo '</a></figure>';

    }elseif( is_archive() || is_search() ){
        echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
        
        if( $wp_query->current_post == 0 ) :                
            $image_size = ( $sidebar ) ? 'vilva-blog-one' : 'vilva-slider-one';
        else:
            $image_size = ( $sidebar ) ? 'vilva-blog' : 'vilva-featured-four';
        endif;

        if( has_post_thumbnail() ){
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
        }else{
            vilva_get_fallback_svg( $image_size );//fallback
        }
        echo '</a></figure>';
    }elseif( is_page() ){
        
            $image_size = ( $sidebar ) ? 'vilva-sidebar' : 'vilva-slider-one';
            if( has_post_thumbnail() ){
                echo '<figure class="post-thumbnail">';
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                echo '</figure>';    
            }
        
    }elseif( is_single() ){
        if ( has_post_thumbnail() && $ed_featured_image ) {
            echo '<figure class="post-thumbnail">';
                $image_size = ( $sidebar ) ? 'vilva-sidebar' : 'vilva-slider-one';
                if( ! $ed_crop_single ){
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                }elseif( $ed_crop_single ){
                    the_post_thumbnail();    
                }
            echo '</figure>';
        }
    }
}

function vilva_banner(){
    if( is_front_page() || is_home() ) {
        $ed_banner      = get_theme_mod( 'ed_banner_section', 'slider_banner' );
        $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' ); 
        $slider_cat     = get_theme_mod( 'slider_cat' );
        $slider_layout  = get_theme_mod( 'slider_layout', 'eight' ); 
        $posts_per_page = get_theme_mod( 'no_of_slides', 3 );
        $ed_caption     = get_theme_mod( 'slider_caption', true );
        $banner_title   = get_theme_mod( 'banner_title', __( 'Find Your Best Holiday', 'minimal-travel' ) );
        $banner_subtitle = get_theme_mod( 'banner_subtitle' , __( 'Find great adventure holidays and activities around the planet.', 'minimal-travel' ) ) ;
        $banner_button   = get_theme_mod( 'banner_button', __( 'Read More', 'minimal-travel' ) );
        $banner_url      = get_theme_mod( 'banner_url', '#' );    
        
        if( $slider_layout == 'one' ){
            $image_size = 'vilva-slider-one';
        }elseif( $slider_layout == 'eight' ){
            $image_size = 'vilva-slider';
        }
        if( $ed_banner == 'static_banner' && has_custom_header() ){ 

            if( $ed_banner == 'static_banner' ) {
                $banner_class = ' static-cta-banner';
            }

            ?>
            <div class="site-banner<?php if( has_header_video() ) echo esc_attr( ' video-banner' ); echo $banner_class; ?>">
                <?php 
                the_custom_header_markup();

                if( $ed_banner == 'static_banner' && ( $banner_title || $banner_subtitle || ( $banner_button && $banner_url ) )){ ?>
                    <div class="banner-caption">
                        <div class="container">
                            <?php 
                            if( $banner_title ) echo '<h2 class="banner-title">' . esc_html( $banner_title ) . '</h2>';
                            if( $banner_subtitle ) echo '<div class="banner-desc">' . wp_kses_post( $banner_subtitle ) . '</div>';
                            if( $banner_button && $banner_url ) echo '<a href="' . esc_url( $banner_url ) . '" class="btn btn-green"><span>' . esc_html( $banner_button ) . '</span></a>';
                            ?>
                        </div>
                    </div> <?php 
                } ?>
            </div>
            <?php
        }elseif( $ed_banner == 'slider_banner' ){

            if( $slider_type == 'latest_posts' || $slider_type == 'cat' || ( vilva_is_delicious_recipe_activated() && $slider_type == 'latest_dr_recipe' ) ){
            
                $args = array(
                    'post_status'         => 'publish',            
                    'ignore_sticky_posts' => true
                );
                
                if( vilva_is_delicious_recipe_activated() && $slider_type == 'latest_dr_recipe' ){
                    $args['post_type']      = DELICIOUS_RECIPE_POST_TYPE;
                    $args['posts_per_page'] = $posts_per_page;
                }elseif( $slider_type === 'cat' && $slider_cat ){
                    $args['post_type']      = 'post';
                    $args['cat']            = $slider_cat; 
                    $args['posts_per_page'] = -1;  
                }else{
                    $args['post_type']      = 'post';
                    $args['posts_per_page'] = $posts_per_page;
                }
                    
                $qry = new WP_Query( $args );
            
                if( $qry->have_posts() ){ ?>

                    <div id="banner_section" class="site-banner style-<?php echo esc_attr( $slider_layout ); ?>">
                        <div class="item-wrap owl-carousel">
                            <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                                <div class="item">
                                    <?php 
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                                    }else{ 
                                        vilva_get_fallback_svg( $image_size );
                                    } 
                                    if( $ed_caption ){ ?>
                                        <div class="banner-caption">
                                            <div class="container">
                                                <div class="cat-links">
                                                    <?php if( vilva_is_delicious_recipe_activated() && DELICIOUS_RECIPE_POST_TYPE == get_post_type() ) {
                                                        vilva_recipe_category(); 
                                                    }else{
                                                        vilva_category(); 
                                                    } ?>
                                                </div>
                                                <h2 class="banner-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h2>   
                                                <?php 
                                                if ( $slider_layout !== 'one' ) { ?>
                                                    <div class="banner-meta">
                                                        <?php 
                                                        vilva_posted_by(); 
                                                        vilva_posted_on(); 
                                                        ?>
                                                    </div>
                                                <?php } ?>                                         
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>                             
                        </div>
                    </div>
                    <?php
                }
                wp_reset_postdata(); 
            }           
        } 
    }  
}

function vilva_entry_header(){ 
    global $wp_query;
    $layout         = get_theme_mod( 'homepage_layout', 'nine' );

    if( ( $layout == 'one' && $wp_query->current_post == 0 ) || ( $layout == 'nine' ) ) return false;
    
    ?>
    <header class="entry-header">
        <?php                  
        if( 'post' === get_post_type() || 'blossom-portfolio' === get_post_type() ){

            echo '<div class="entry-meta">';
                vilva_posted_on(); 

                vilva_category();

            echo '</div>';
        }   

        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); 
        ?>
    </header> 
    <?php  
}

function vilva_entry_header_first(){
    global $wp_query ;

    $layout         = get_theme_mod( 'homepage_layout', 'nine' );

    if ( ! is_single() && ! is_page() && $layout == 'one' && $wp_query->current_post == 0 || ( $layout == 'nine' ) ) { ?>
        <header class="entry-header">
            <?php      
                if( 'post' === get_post_type() || 'blossom-portfolio' === get_post_type() ){
                    echo '<div class="entry-meta">';
                        vilva_posted_on(); 
                        vilva_category(); 
                    echo '</div>';
                }   

                if ( is_singular() ) :
                    the_title( '<h1 class="entry-title">', '</h1>' );
                else :
                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                endif; ?>
        </header>
    <?php }

    if ( is_single() && $layout == 'one' ) { ?>
        <header class="entry-header">
            <div class="container">
                <div class="entry-meta">
                    <?php
                    vilva_posted_on();
                    vilva_category();
                    ?>
                </div>

                <h1 class="entry-title"><?php the_title(); ?></h1>     

            </div>
        </header> 
    <?php
    }elseif ( is_page() && $layout == 'one' ) {
        ?>
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header> 
        <?php
    }
}

function vilva_entry_content(){ 
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true );  
    $layout     = get_theme_mod( 'homepage_layout', 'nine' );
    $post_arr   = array( 'one' );
    $arr        = array( 'one', 'nine' );
    
    if ( ( is_home() && in_array( $layout, $arr ) ) || is_singular() || is_archive() || is_search() ) {
    
        if ( ( is_home() && in_array( $layout, $post_arr ) ) || is_archive() || is_search() ) echo '<div class="content-wrap">';

            if ( is_single() ) vilva_author_desc(); 

            echo '<div class="entry-content" itemprop="text">';
                if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
                    the_content();    
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'minimal-travel' ),
                        'after'  => '</div>',
                    ) );
                }else{
                    the_excerpt();
                }
            echo '</div>';            

        if ( ( is_home() && in_array( $layout, $post_arr ) ) || ( ( is_archive() || is_search() ) ) ) echo '</div>';
    }
}

function vilva_fonts_url(){
    $fonts_url = '';
    
    $primary_font       = get_theme_mod( 'primary_font', 'Montserrat' );
    $is_primary_font    = vilva_is_google_font( $primary_font );    
    $secondary_font     = get_theme_mod( 'secondary_font', 'Karma' );
    $is_secondary_font  = vilva_is_google_font( $secondary_font );    
    $site_title_font    = get_theme_mod( 'site_title_font', array( 'font-family'=>'EB Garamond', 'variant'=>'regular' ) );
    $is_site_title_font = vilva_is_google_font( $site_title_font['font-family'] );
            
    /* Translators: If there are characters in your language that are not
    * supported by respective fonts, translate this to 'off'. Do not translate
    * into your own language.
    */
    $primary    = _x( 'on', 'Primary Font: on or off', 'minimal-travel' );
    $secondary  = _x( 'on', 'Secondary Font: on or off', 'minimal-travel' );
    $site_title = _x( 'on', 'Site Title Font: on or off', 'minimal-travel' );
        
    if ( 'off' !== $primary || 'off' !== $secondary || 'off' !== $site_title ) {
        
        $font_families = array();
     
        if ( 'off' !== $primary && $is_primary_font ) {
            $primary_variant = vilva_check_varient( $primary_font, 'regular', true );
            if( $primary_variant ){
                $primary_var = ':' . $primary_variant;
            }else{
                $primary_var = '';    
            }            
            $font_families[] = $primary_font . $primary_var;
        }
         
        if ( 'off' !== $secondary && $is_secondary_font ) {
            $secondary_variant = vilva_check_varient( $secondary_font, 'regular', true );
            if( $secondary_variant ){
                $secondary_var = ':' . $secondary_variant;    
            }else{
                $secondary_var = '';
            }
            $font_families[] = $secondary_font . $secondary_var;
        }
        
        if ( 'off' !== $site_title && $is_site_title_font ) {
            
            if( ! empty( $site_title_font['variant'] ) ){
                $site_title_var = ':' . vilva_check_varient( $site_title_font['font-family'], $site_title_font['variant'] );    
            }else{
                $site_title_var = '';
            }
            $font_families[] = $site_title_font['font-family'] . $site_title_var;
        }
        
        $font_families = array_diff( array_unique( $font_families ), array('') );
        
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),            
        );
        
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
     
    return esc_url_raw( $fonts_url );
}

/*
Dynamic CSS
*/
function minimal_travel_dynamic_css(){
    
    $primary_font    = get_theme_mod( 'primary_font', 'Montserrat' );
    $primary_fonts   = vilva_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Karma' );
    $secondary_fonts = vilva_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 16 );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'EB Garamond', 'variant'=>'regular' ) );
    $site_title_fonts     = vilva_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 30 );
    $site_logo_size       = get_theme_mod( 'site_logo_size', 70 );
        
    $primary_color    = get_theme_mod( 'primary_color', '#45b29d' );
    $site_title_color = get_theme_mod( 'site_title_color', '#121212' ); 
    
    $rgb = vilva_hex2rgb( vilva_sanitize_hex_color( $primary_color ) );    
     
    echo "<style type='text/css' media='all'>"; ?>
     
    .content-newsletter .blossomthemes-email-newsletter-wrapper.bg-img:after,
    .widget_blossomthemes_email_newsletter_widget .blossomthemes-email-newsletter-wrapper:after{
        <?php echo 'background: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.8);'; ?>
    }
    
    /*Typography*/

    body,
    button,
    input,
    select,
    optgroup,
    textarea{
        font-family : <?php echo esc_html( $primary_fonts['font'] ); ?>;
        font-size   : <?php echo absint( $font_size ); ?>px;        
    }

    :root {
        --primary-font: <?php echo esc_html( $primary_fonts['font'] ); ?>;
        --secondary-font: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
        --primary-color: <?php echo vilva_sanitize_hex_color( $primary_color ); ?>;
        --primary-color-rgb: <?php printf('%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ); ?>;
    }
    
    .site-branding .site-title-wrap .site-title{
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo esc_html( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_html( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_html( $site_title_fonts['style'] ); ?>;
    }
    
    .site-branding .site-title-wrap .site-title a{
        color: <?php echo vilva_sanitize_hex_color( $site_title_color ); ?>;
    }
    
    .custom-logo-link img{
        width: <?php echo absint( $site_logo_size ); ?>px;
        max-width: 100%;
    }

    .comment-body .reply .comment-reply-link:hover:before {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15"><path d="M934,147.2a11.941,11.941,0,0,1,7.5,3.7,16.063,16.063,0,0,1,3.5,7.3c-2.4-3.4-6.1-5.1-11-5.1v4.1l-7-7,7-7Z" transform="translate(-927 -143.2)" fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>"/></svg>');
    }

    .site-header.style-five .header-mid .search-form .search-submit:hover {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    }

    .site-header.style-seven .header-bottom .search-form .search-submit:hover {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    }

    .site-header.style-fourteen .search-form .search-submit:hover {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    }

    .search-results .content-area > .page-header .search-submit:hover {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo vilva_hash_to_percent23( vilva_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
    }
           
    <?php echo "</style>";
}
add_action( 'wp_head', 'minimal_travel_dynamic_css', 99 );