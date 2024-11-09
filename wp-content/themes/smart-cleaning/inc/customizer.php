<?php
/**
 * Smart Cleaning Theme Customizer
 *
 * @link: https://developer.wordpress.org/themes/customize-api/customizer-objects/
 *
 * @package Smart Cleaning
 */

if ( ! defined( 'SMART_CLEANING_URL' ) ) {
    define( 'SMART_CLEANING_URL', esc_url( 'https://www.themagnifico.net/themes/cleaning-wordpress-theme/', 'smart-cleaning') );
}
if ( ! defined( 'SMART_CLEANING_TEXT' ) ) {
    define( 'SMART_CLEANING_TEXT', __( 'Smart Cleaning Pro','smart-cleaning' ));
}
if ( ! defined( 'SMART_CLEANING_BUY_TEXT' ) ) {
    define( 'SMART_CLEANING_BUY_TEXT', __( 'Buy Smart Cleaning Pro','smart-cleaning' ));
}

use WPTRT\Customize\Section\Smart_Cleaning_Button;

add_action( 'customize_register', function( $manager ) {

    $manager->register_section_type( Smart_Cleaning_Button::class );

    $manager->add_section(
        new Smart_Cleaning_Button( $manager, 'smart_cleaning_pro', [
            'title'       => esc_html( SMART_CLEANING_TEXT,'smart-cleaning' ),
            'priority'    => 0,
            'button_text' => __( 'GET PREMIUM', 'smart-cleaning' ),
            'button_url'  => esc_url( SMART_CLEANING_URL )
        ] )
    );

} );

// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

    $version = wp_get_theme()->get( 'Version' );

    wp_enqueue_script(
        'smart-cleaning-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/js/customize-controls.js' ),
        [ 'customize-controls' ],
        $version,
        true
    );

    wp_enqueue_style(
        'smart-cleaning-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/css/customize-controls.css' ),
        [ 'customize-controls' ],
        $version
    );

} );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function smart_cleaning_customize_register($wp_customize){

     // Pro Version
    class Smart_Cleaning_Customize_Pro_Version extends WP_Customize_Control {
        public $type = 'pro_options';

        public function render_content() {
            echo '<span>For More <strong>'. esc_html( $this->label ) .'</strong>?</span>';
            echo '<a href="'. esc_url($this->description) .'" target="_blank">';
                echo '<span class="dashicons dashicons-info"></span>';
                echo '<strong> '. esc_html( SMART_CLEANING_BUY_TEXT,'smart-cleaning' ) .'<strong></a>';
            echo '</a>';
        }
    }

    // Custom Controls
    function Smart_Cleaning_sanitize_custom_control( $input ) {
        return $input;
    }

    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';

    $wp_customize->add_setting('smart_cleaning_logo_title', array(
        'default' => true,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_logo_title',array(
        'label'          => __( 'Enable Disable Title', 'smart-cleaning' ),
        'section'        => 'title_tagline',
        'settings'       => 'smart_cleaning_logo_title',
        'type'           => 'checkbox',
    )));

    //Logo
    $wp_customize->add_setting('smart_cleaning_logo_max_height',array(
        'default'   => '24',
        'sanitize_callback' => 'smart_cleaning_sanitize_number_absint'
    ));
    $wp_customize->add_control('smart_cleaning_logo_max_height',array(
        'label' => esc_html__('Logo Width','smart-cleaning'),
        'section'   => 'title_tagline',
        'type'      => 'number'
    ));

    $wp_customize->add_setting('smart_cleaning_theme_description', array(
        'default' => false,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_theme_description',array(
        'label'          => __( 'Enable Disable Tagline', 'smart-cleaning' ),
        'section'        => 'title_tagline',
        'settings'       => 'smart_cleaning_theme_description',
        'type'           => 'checkbox',
    )));

    // Theme Color
    $wp_customize->add_section('smart_cleaning_color_option',array(
        'title' => esc_html__('Theme Color','smart-cleaning'),
        'priority'   => 10,
    ));

    $wp_customize->add_setting( 'smart_cleaning_theme_color_one', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'smart_cleaning_theme_color_one', array(
        'label' => esc_html__('First Color Option','smart-cleaning'),
        'section' => 'smart_cleaning_color_option',
        'settings' => 'smart_cleaning_theme_color_one'
    )));

    $wp_customize->add_setting( 'smart_cleaning_theme_color_two', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'smart_cleaning_theme_color_two', array(
        'label' => esc_html__('Second Color Option','smart-cleaning'),
        'section' => 'smart_cleaning_color_option',
        'settings' => 'smart_cleaning_theme_color_two'
    )));

     // Pro Version
    $wp_customize->add_setting( 'pro_version_theme_color', array(
        'sanitize_callback' => 'Smart_Cleaning_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Smart_Cleaning_Customize_Pro_Version ( $wp_customize,'pro_version_theme_color', array(
        'section'     => 'smart_cleaning_color_option',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'smart-cleaning' ),
        'description' => esc_url( SMART_CLEANING_URL ),
        'priority'    => 100
    )));

    // Header
    $wp_customize->add_section('smart_cleaning_header_top',array(
        'title' => esc_html__('Header','smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_blog_topbar_setting', array(
        'default' => 0,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_blog_topbar_setting',array(
        'label'          => __( 'Enable Disable Header', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_header_top',
        'settings'       => 'smart_cleaning_blog_topbar_setting',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('smart_cleaning_topbar_email_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_topbar_email_icon',array(
        'label' => esc_html__('Add Email Address Icon','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_topbar_email_icon',
        'type'  => 'text',
        'default' => 'fas fa-envelope',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fas fa-envelope','smart-cleaning')
    ));

    $wp_customize->add_setting('smart_cleaning_topbar_email',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_email'
    ));
    $wp_customize->add_control('smart_cleaning_topbar_email',array(
        'label' => esc_html__('Email Address','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_topbar_email',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('smart_cleaning_topbar_text1',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_topbar_text1',array(
        'label' => esc_html__('Text 1','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_topbar_text1',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('smart_cleaning_topbar_link1',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('smart_cleaning_topbar_link1',array(
        'label' => esc_html__('Link 1','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_topbar_link1',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('smart_cleaning_topbar_text2',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_topbar_text2',array(
        'label' => esc_html__('Text 2','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_topbar_text2',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('smart_cleaning_topbar_link2',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('smart_cleaning_topbar_link2',array(
        'label' => esc_html__('Link 2','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_topbar_link2',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('smart_cleaning_topbar_text3',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_topbar_text3',array(
        'label' => esc_html__('Text 3','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_topbar_text3',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('smart_cleaning_topbar_link3',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('smart_cleaning_topbar_link3',array(
        'label' => esc_html__('Link 3','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_topbar_link3',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('smart_cleaning_header_location_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_header_location_icon',array(
        'label' => esc_html__('Add Location Icon','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_header_location_icon',
        'type'  => 'text',
        'default' => 'fas fa-map-marker-alt',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fas fa-map-marker-alt','smart-cleaning')
    ));

    $wp_customize->add_setting('smart_cleaning_header_location',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_header_location',array(
        'label' => esc_html__('Location','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_header_location',
        'type'  => 'text'
    ));

     $wp_customize->add_setting('smart_cleaning_header_phone_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_header_phone_icon',array(
        'label' => esc_html__('Add Phone Number Icon','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_header_phone_icon',
        'type'  => 'text',
        'default' => 'fas fa-phone',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fas fa-phone','smart-cleaning')
    ));

    $wp_customize->add_setting('smart_cleaning_header_phone',array(
        'default' => '',
        'sanitize_callback' => 'smart_cleaning_sanitize_phone_number'
    ));
    $wp_customize->add_control('smart_cleaning_header_phone',array(
        'label' => esc_html__('Phone Number','smart-cleaning'),
        'section' => 'smart_cleaning_header_top',
        'setting' => 'smart_cleaning_header_phone',
        'type'  => 'text'
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_header_setting', array(
        'sanitize_callback' => 'Smart_Cleaning_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Smart_Cleaning_Customize_Pro_Version ( $wp_customize,'pro_version_header_setting', array(
        'section'     => 'smart_cleaning_header_top',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'smart-cleaning' ),
        'description' => esc_url( SMART_CLEANING_URL ),
        'priority'    => 100
    )));

    // General Settings
     $wp_customize->add_section('smart_cleaning_general_settings',array(
        'title' => esc_html__('General Settings','smart-cleaning'),
        'priority'   => 10,
    ));

    $wp_customize->add_setting('smart_cleaning_preloader_hide', array(
        'default' => false,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_preloader_hide',array(
        'label'          => __( 'Show Theme Preloader', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_general_settings',
        'settings'       => 'smart_cleaning_preloader_hide',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting( 'smart_cleaning_preloader_bg_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'smart_cleaning_preloader_bg_color', array(
        'label' => esc_html__('Preloader Background Color','smart-cleaning'),
        'section' => 'smart_cleaning_general_settings',
        'settings' => 'smart_cleaning_preloader_bg_color'
    )));

    $wp_customize->add_setting( 'smart_cleaning_preloader_dot_1_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'smart_cleaning_preloader_dot_1_color', array(
        'label' => esc_html__('Preloader First Dot Color','smart-cleaning'),
        'section' => 'smart_cleaning_general_settings',
        'settings' => 'smart_cleaning_preloader_dot_1_color'
    )));

    $wp_customize->add_setting( 'smart_cleaning_preloader_dot_2_color', array(
        'default' => '',
        'sanitize_callback' => 'sanitize_hex_color'
    ));
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'smart_cleaning_preloader_dot_2_color', array(
        'label' => esc_html__('Preloader Second Dot Color','smart-cleaning'),
        'section' => 'smart_cleaning_general_settings',
        'settings' => 'smart_cleaning_preloader_dot_2_color'
    )));

    $wp_customize->add_setting('smart_cleaning_sticky_header', array(
        'default' => false,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_sticky_header',array(
        'label'          => __( 'Show Sticky Header', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_general_settings',
        'settings'       => 'smart_cleaning_sticky_header',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('smart_cleaning_scroll_hide', array(
        'default' => false,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_scroll_hide',array(
        'label'          => __( 'Show Theme Scroll To Top', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_general_settings',
        'settings'       => 'smart_cleaning_scroll_hide',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('smart_cleaning_scroll_top_position',array(
        'default' => 'Right',
        'sanitize_callback' => 'smart_cleaning_sanitize_choices'
    ));
    $wp_customize->add_control('smart_cleaning_scroll_top_position',array(
        'type' => 'radio',
        'section' => 'smart_cleaning_general_settings',
        'choices' => array(
            'Right' => __('Right','smart-cleaning'),
            'Left' => __('Left','smart-cleaning'),
            'Center' => __('Center','smart-cleaning')
        ),
    ) );

    // Product Columns
    $wp_customize->add_setting( 'smart_cleaning_products_per_row' , array(
        'default'           => '3',
        'transport'         => 'refresh',
        'sanitize_callback' => 'smart_cleaning_sanitize_select',
    ) );

    $wp_customize->add_control('smart_cleaning_products_per_row', array(
        'label' => __( 'Product per row', 'smart-cleaning' ),
        'section'  => 'smart_cleaning_general_settings',
        'type'     => 'select',
        'choices'  => array(
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ),
    ) );

    $wp_customize->add_setting('smart_cleaning_product_per_page',array(
        'default'   => '9',
        'sanitize_callback' => 'smart_cleaning_sanitize_float'
    ));
    $wp_customize->add_control('smart_cleaning_product_per_page',array(
        'label' => __('Product per page','smart-cleaning'),
        'section'   => 'smart_cleaning_general_settings',
        'type'      => 'number'
    ));

    //Woocommerce shop page Sidebar
    $wp_customize->add_setting('smart_cleaning_woocommerce_shop_page_sidebar', array(
        'default' => true,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_woocommerce_shop_page_sidebar',array(
        'label'          => __( 'Hide Shop Page Sidebar', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_general_settings',
        'settings'       => 'smart_cleaning_woocommerce_shop_page_sidebar',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('smart_cleaning_shop_page_sidebar_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'smart_cleaning_sanitize_choices'
    ));
    $wp_customize->add_control('smart_cleaning_shop_page_sidebar_layout',array(
        'type' => 'select',
        'label' => __('Woocommerce Shop Page Sidebar','smart-cleaning'),
        'section' => 'smart_cleaning_general_settings',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','smart-cleaning'),
            'Right Sidebar' => __('Right Sidebar','smart-cleaning'),
        ),
    ) );

    //Woocommerce Single Product page Sidebar
    $wp_customize->add_setting('smart_cleaning_woocommerce_single_product_page_sidebar', array(
        'default' => true,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_woocommerce_single_product_page_sidebar',array(
        'label'          => __( 'Hide Single Product Page Sidebar', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_general_settings',
        'settings'       => 'smart_cleaning_woocommerce_single_product_page_sidebar',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('smart_cleaning_single_product_sidebar_layout',array(
        'default' => 'Right Sidebar',
        'sanitize_callback' => 'smart_cleaning_sanitize_choices'
    ));
    $wp_customize->add_control('smart_cleaning_single_product_sidebar_layout',array(
        'type' => 'select',
        'label' => __('Woocommerce Single Product Page Sidebar','smart-cleaning'),
        'section' => 'smart_cleaning_general_settings',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','smart-cleaning'),
            'Right Sidebar' => __('Right Sidebar','smart-cleaning'),
        ),
    ) );

     // Pro Version
    $wp_customize->add_setting( 'pro_version_general_setting', array(
        'sanitize_callback' => 'Smart_Cleaning_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Smart_Cleaning_Customize_Pro_Version ( $wp_customize,'pro_version_general_setting', array(
        'section'     => 'smart_cleaning_general_settings',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'smart-cleaning' ),
        'description' => esc_url( SMART_CLEANING_URL ),
        'priority'    => 100
    )));

    // Post Settings
     $wp_customize->add_section('smart_cleaning_post_settings',array(
        'title' => esc_html__('Post Settings','smart-cleaning'),
        'priority'   =>20,
    ));

     $wp_customize->add_setting('smart_cleaning_post_page_title',array(
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('smart_cleaning_post_page_title',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Post Page Title', 'smart-cleaning'),
        'section'     => 'smart_cleaning_post_settings',
        'description' => esc_html__('Check this box to enable title on post page.', 'smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_post_page_thumb',array(
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('smart_cleaning_post_page_thumb',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Post Page Thumbnail', 'smart-cleaning'),
        'section'     => 'smart_cleaning_post_settings',
        'description' => esc_html__('Check this box to enable thumbnail on post page.', 'smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_post_page_cat',array(
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('smart_cleaning_post_page_cat',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Post Page Category and Tags', 'smart-cleaning'),
        'section'     => 'smart_cleaning_post_settings',
        'description' => esc_html__('Check this box to enable category and tags on post page.', 'smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_single_post_thumb',array(
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('smart_cleaning_single_post_thumb',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Single Post Thumbnail', 'smart-cleaning'),
        'section'     => 'smart_cleaning_post_settings',
        'description' => esc_html__('Check this box to enable post thumbnail on single post.', 'smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_single_post_title',array(
            'sanitize_callback' => 'smart_cleaning_sanitize_checkbox',
            'default'           => 1,
    ));
    $wp_customize->add_control('smart_cleaning_single_post_title',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Single Post Title', 'smart-cleaning'),
        'section'     => 'smart_cleaning_post_settings',
        'description' => esc_html__('Check this box to enable title on single post.', 'smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_single_post_cat',array(
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('smart_cleaning_single_post_cat',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Single Post Category and Tags', 'smart-cleaning'),
        'section'     => 'smart_cleaning_post_settings',
        'description' => esc_html__('Check this box to enable post category and tags on single post.', 'smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_single_post_comment_title',array(
        'default'=> 'Leave a Reply',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('smart_cleaning_single_post_comment_title',array(
        'label' => __('Add Comment Title','smart-cleaning'),
        'input_attrs' => array(
        'placeholder' => __( 'Leave a Reply', 'smart-cleaning' ),
        ),
        'section'=> 'smart_cleaning_post_settings',
        'type'=> 'text'
    ));

    $wp_customize->add_setting('smart_cleaning_single_post_comment_btn_text',array(
        'default'=> 'Post Comment',
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control('smart_cleaning_single_post_comment_btn_text',array(
        'label' => __('Add Comment Button Text','smart-cleaning'),
        'input_attrs' => array(
            'placeholder' => __( 'Post Comment', 'smart-cleaning' ),
        ),
        'section'=> 'smart_cleaning_post_settings',
        'type'=> 'text'
    ));

     // Page Settings
    $wp_customize->add_section('smart_cleaning_page_settings',array(
        'title' => esc_html__('Page Settings','smart-cleaning'),
        'priority'   =>50,
    ));

    $wp_customize->add_setting('smart_cleaning_single_page_title',array(
            'sanitize_callback' => 'smart_cleaning_sanitize_checkbox',
            'default'           => 1,
    ));
    $wp_customize->add_control('smart_cleaning_single_page_title',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Single Page Title', 'smart-cleaning'),
        'section'     => 'smart_cleaning_page_settings',
        'description' => esc_html__('Check this box to enable title on single page.', 'smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_single_page_thumb',array(
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox',
        'default'           => 1,
    ));
    $wp_customize->add_control('smart_cleaning_single_page_thumb',array(
        'type'        => 'checkbox',
        'label'       => esc_html__('Enable Single Page Thumbnail', 'smart-cleaning'),
        'section'     => 'smart_cleaning_page_settings',
        'description' => esc_html__('Check this box to enable page thumbnail on single page.', 'smart-cleaning'),
    ));

    // Social Link
    $wp_customize->add_section('smart_cleaning_social_link',array(
        'title' => esc_html__('Social Links','smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_blog_social_icon_setting', array(
        'default' => 0,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_blog_social_icon_setting',array(
        'label'          => __( 'Enable Disable Social', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_social_link',
        'settings'       => 'smart_cleaning_blog_social_icon_setting',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('smart_cleaning_facebook_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_facebook_icon',array(
        'label' => esc_html__('Add Facebook Icon','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_facebook_icon',
        'type'  => 'text',
        'default' => 'fab fa-facebook-f',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-facebook-f','smart-cleaning')
    ));

    $wp_customize->add_setting('smart_cleaning_facebook_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('smart_cleaning_facebook_url',array(
        'label' => esc_html__('Facebook Link','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_facebook_url',
        'type'  => 'url'
    ));

    $wp_customize->add_setting('smart_cleaning_twitter_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_twitter_icon',array(
        'label' => esc_html__('Add Twitter Icon','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_twitter_icon',
        'type'  => 'text',
        'default' => 'fab fa-twitter',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-twitter','smart-cleaning')
    ));

    $wp_customize->add_setting('smart_cleaning_twitter_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('smart_cleaning_twitter_url',array(
        'label' => esc_html__('Twitter Link','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_twitter_url',
        'type'  => 'url'
    ));
    $wp_customize->add_setting('smart_cleaning_intagram_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_intagram_icon',array(
        'label' => esc_html__('Add Intagram Icon','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_intagram_icon',
        'type'  => 'text',
        'default' => 'fab fa-instagram',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-instagram','smart-cleaning')
    ));

    $wp_customize->add_setting('smart_cleaning_intagram_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('smart_cleaning_intagram_url',array(
        'label' => esc_html__('Intagram Link','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_intagram_url',
        'type'  => 'url'
    ));

     $wp_customize->add_setting('smart_cleaning_linkedin_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_linkedin_icon',array(
        'label' => esc_html__('Add Linkedin Icon','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_linkedin_icon',
        'type'  => 'text',
        'default' => 'fab fa-linkedin-in',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-linkedin-in','smart-cleaning')
    ));

    $wp_customize->add_setting('smart_cleaning_linkedin_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('smart_cleaning_linkedin_url',array(
        'label' => esc_html__('Linkedin Link','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_linkedin_url',
        'type'  => 'url'
    ));
    $wp_customize->add_setting('smart_cleaning_pintrest_icon',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_pintrest_icon',array(
        'label' => esc_html__('Add Intagram Icon','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_pintrest_icon',
        'type'  => 'text',
        'default' => 'fab fa-pinterest-p',
        'description' =>  __('Select font awesome icons <a target="_blank" href="https://fontawesome.com/v5/search?m=free">Click Here</a> for select icon. for eg:-fab fa-pinterest-p','smart-cleaning')
    ));

    $wp_customize->add_setting('smart_cleaning_pintrest_url',array(
        'default' => '',
        'sanitize_callback' => 'esc_url_raw'
    ));
    $wp_customize->add_control('smart_cleaning_pintrest_url',array(
        'label' => esc_html__('Pinterest Link','smart-cleaning'),
        'section' => 'smart_cleaning_social_link',
        'setting' => 'smart_cleaning_pintrest_url',
        'type'  => 'url'
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_social_setting', array(
        'sanitize_callback' => 'Smart_Cleaning_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Smart_Cleaning_Customize_Pro_Version ( $wp_customize,'pro_version_social_setting', array(
        'section'     => 'smart_cleaning_social_link',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'smart-cleaning' ),
        'description' => esc_url( SMART_CLEANING_URL ),
        'priority'    => 100
    )));

    //Slider
    $wp_customize->add_section('smart_cleaning_top_slider',array(
        'title' => esc_html__('Slider Option','smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_blog_slider_setting', array(
        'default' => 0,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_blog_slider_setting',array(
        'label'          => __( 'Enable Disable Slider', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_top_slider',
        'settings'       => 'smart_cleaning_blog_slider_setting',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('smart_cleaning_slider_loop', array(
        'default' => 1,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_slider_loop',array(
        'label'          => __( 'Enable Disable Slider Loop', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_top_slider',
        'settings'       => 'smart_cleaning_slider_loop',
        'type'           => 'checkbox',
    )));

    for ( $smart_cleaning_count = 1; $smart_cleaning_count <= 3; $smart_cleaning_count++ ) {
        $wp_customize->add_setting( 'smart_cleaning_top_slider_page' . $smart_cleaning_count, array(
            'default'           => '',
            'sanitize_callback' => 'smart_cleaning_sanitize_dropdown_pages'
        ) );
        $wp_customize->add_control( 'smart_cleaning_top_slider_page' . $smart_cleaning_count, array(
            'label'    => __( 'Select Slide Page', 'smart-cleaning' ),
            'section'  => 'smart_cleaning_top_slider',
            'type'     => 'dropdown-pages'
        ) );
    }

    $wp_customize->add_setting('smart_cleaning_slide_day',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_slide_day',array(
        'label' => esc_html__('Days','smart-cleaning'),
        'description' => esc_html__('Ex: Friday - Sunday','smart-cleaning'),
        'section' => 'smart_cleaning_top_slider',
        'setting' => 'smart_cleaning_slide_day',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('smart_cleaning_slide_time',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    ));
    $wp_customize->add_control('smart_cleaning_slide_time',array(
        'label' => esc_html__('Time','smart-cleaning'),
        'description' => esc_html__('Ex: 9:00am to 9:00pm','smart-cleaning'),
        'section' => 'smart_cleaning_top_slider',
        'setting' => 'smart_cleaning_slide_time',
        'type'  => 'text'
    ));

    //Slider Image Opacity
    $wp_customize->add_setting('smart_cleaning_slider_opacity_color',array(
      'default' => '',
      'sanitize_callback' => 'smart_cleaning_sanitize_choices'
    ));

    $wp_customize->add_control( 'smart_cleaning_slider_opacity_color', array(
    'label'       => esc_html__( 'Slider Image Opacity','smart-cleaning' ),
    'section'     => 'smart_cleaning_top_slider',
    'type'        => 'select',
    'choices' => array(
      '0' =>  esc_attr('0','smart-cleaning'),
      '0.1' =>  esc_attr('0.1','smart-cleaning'),
      '0.2' =>  esc_attr('0.2','smart-cleaning'),
      '0.3' =>  esc_attr('0.3','smart-cleaning'),
      '0.4' =>  esc_attr('0.4','smart-cleaning'),
      '0.5' =>  esc_attr('0.5','smart-cleaning'),
      '0.6' =>  esc_attr('0.6','smart-cleaning'),
      '0.7' =>  esc_attr('0.7','smart-cleaning'),
      '0.8' =>  esc_attr('0.8','smart-cleaning'),
      '0.9' =>  esc_attr('0.9','smart-cleaning')
    ),
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_slider_setting', array(
        'sanitize_callback' => 'Smart_Cleaning_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Smart_Cleaning_Customize_Pro_Version ( $wp_customize,'pro_version_slider_setting', array(
        'section'     => 'smart_cleaning_top_slider',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'smart-cleaning' ),
        'description' => esc_url( SMART_CLEANING_URL ),
        'priority'    => 100
    )));

    // Special Services
    $wp_customize->add_section('smart_cleaning_featured_category',array(
        'title' => esc_html__('Our Services','smart-cleaning'),
    ));

     $wp_customize->add_setting('smart_cleaning_blog_service_setting', array(
        'default' => 0,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control( new WP_Customize_Control($wp_customize,'smart_cleaning_blog_service_setting',array(
        'label'          => __( 'Enable Disable Services', 'smart-cleaning' ),
        'section'        => 'smart_cleaning_featured_category',
        'settings'       => 'smart_cleaning_blog_service_setting',
        'type'           => 'checkbox',
    )));

    $wp_customize->add_setting('smart_cleaning_featured_category_title', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('smart_cleaning_featured_category_title', array(
        'label' => __('Section Title', 'smart-cleaning'),
        'section' => 'smart_cleaning_featured_category',
        'type' => 'text',
    ));

    $categories = get_categories();
    $cat_post = array();
    $cat_post[]= 'select';
    $i = 0;
    foreach($categories as $category){
        if($i==0){
            $default = $category->slug;
            $i++;
        }
        $cat_post[$category->slug] = $category->name;
    }

    $wp_customize->add_setting('smart_cleaning_featured_category_1',array(
        'default'   => 'select',
        'sanitize_callback' => 'smart_cleaning_sanitize_choices',
    ));
    $wp_customize->add_control('smart_cleaning_featured_category_1',array(
        'type'    => 'select',
        'choices' => $cat_post,
        'label' => __('Select Category to display box post','smart-cleaning'),
        'section' => 'smart_cleaning_featured_category',
    ));

     // Pro Version
    $wp_customize->add_setting( 'pro_version_featured_setting', array(
        'sanitize_callback' => 'Smart_Cleaning_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Smart_Cleaning_Customize_Pro_Version ( $wp_customize,'pro_version_featured_setting', array(
        'section'     => 'smart_cleaning_featured_category',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'smart-cleaning' ),
        'description' => esc_url( SMART_CLEANING_URL ),
        'priority'    => 100
    )));

    // Footer
    $wp_customize->add_section('smart_cleaning_site_footer_section', array(
        'title' => esc_html__('Footer', 'smart-cleaning'),
    ));

    $wp_customize->add_setting('smart_cleaning_footer_text_setting', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('smart_cleaning_footer_text_setting', array(
        'label' => __('Replace the footer text', 'smart-cleaning'),
        'section' => 'smart_cleaning_site_footer_section',
        'type' => 'text',
    ));

    $wp_customize->add_setting('smart_cleaning_show_hide_copyright',array(
        'default' => true,
        'sanitize_callback' => 'smart_cleaning_sanitize_checkbox'
    ));
    $wp_customize->add_control('smart_cleaning_show_hide_copyright',array(
        'type' => 'checkbox',
        'label' => __('Show / Hide Copyright','smart-cleaning'),
        'section' => 'smart_cleaning_site_footer_section',
    ));

    // Pro Version
    $wp_customize->add_setting( 'pro_version_footer_setting', array(
        'sanitize_callback' => 'Smart_Cleaning_sanitize_custom_control'
    ));
    $wp_customize->add_control( new Smart_Cleaning_Customize_Pro_Version ( $wp_customize,'pro_version_footer_setting', array(
        'section'     => 'smart_cleaning_site_footer_section',
        'type'        => 'pro_options',
        'label'       => esc_html__( 'Customizer Options', 'smart-cleaning' ),
        'description' => esc_url( SMART_CLEANING_URL ),
        'priority'    => 100
    )));
}
add_action('customize_register', 'smart_cleaning_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function smart_cleaning_customize_partial_blogname(){
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function smart_cleaning_customize_partial_blogdescription(){
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function smart_cleaning_customize_preview_js(){
    wp_enqueue_script('smart-cleaning-customizer', esc_url(get_template_directory_uri()) . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'smart_cleaning_customize_preview_js');


/*
** Load dynamic logic for the customizer controls area.
*/
function smart_cleaning_panels_js() {
    wp_enqueue_style( 'smart-cleaning-customizer-layout-css', get_theme_file_uri( '/assets/css/customizer-layout.css' ) );
    wp_enqueue_script( 'smart-cleaning-customize-layout', get_theme_file_uri( '/assets/js/customize-layout.js' ), array(), '1.2', true );
}
add_action( 'customize_controls_enqueue_scripts', 'smart_cleaning_panels_js' );
