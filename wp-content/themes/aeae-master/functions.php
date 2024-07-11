<?php
/**
 * aeae functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package aeae
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function aeae_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on aeae, use a find and replace
		* to change 'aeae' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'aeae', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'aeae' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'aeae_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'aeae_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function aeae_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'aeae_content_width', 640 );
}
add_action( 'after_setup_theme', 'aeae_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function aeae_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'aeae' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'aeae' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'aeae_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function aeae_scripts() {
// 	wp_enqueue_style( 'aeae-style', get_stylesheet_uri(), array(), _S_VERSION );
// 	wp_style_add_data( 'aeae-style', 'rtl', 'replace' );

	wp_enqueue_script( 'aeae-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'aeae_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

///////////////////////////////7
// Allow SVG
// 
// 
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {

  global $wp_version;
  if ( $wp_version !== '4.7.1' ) {
     return $data;
  }

  $filetype = wp_check_filetype( $filename, $mimes );

  return [
      'ext'             => $filetype['ext'],
      'type'            => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );

function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );




/////////////////////////////









require_once dirname(__FILE__) . '/class-tgm-plugin-activation.php';


require_once get_template_directory() . '/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'ob_plug_register_required_plugins');

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function ob_plug_register_required_plugins()
{
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
		array(
			'name' => 'admin-site-enhancements', // The plugin name.
			'slug' => 'admin-site-enhancements', // The plugin slug (typically the folder name).
			'required' => false, // If false, the plugin is only 'recommended' instead of required.
			'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url' => '', // If set, overrides default API URL and points to an external URL.
			'is_callable' => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'name' => '1-lightbox', // The plugin name.
			'slug' => '1-lightbox', // The plugin slug (typically the folder name).
			'required' => false, // If false, the plugin is only 'recommended' instead of required.
			'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'source' => 'https://github.com/12ants/1-lightbox/archive/refs/heads/main.zip', // If set, overrides default API URL and points to an external URL.
			'is_callable' => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

		array(
			'name' => 'fastdup', // The plugin name.
			'slug' => 'fastdup', // The plugin slug (typically the folder name).
			'required' => false, // If false, the plugin is only 'recommended' instead of required.
			'version' => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'external_url' => '', // If set, overrides default API URL and points to an external URL.
			'is_callable' => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),

		// This is an example of how to include a plugin from an arbitrary external source in your theme.
		array(
			'name' => 'simple-history', // The plugin name.
			'slug' => 'simple-history', // The plugin slug (typically the folder name).
			'required' => false,
		),

		// This is an example of how to include a plugin from a GitHub repository in your theme.
		// This presumes that the plugin code is based in the root of the GitHub repository
		// and not in a subdirectory ('/src') of the repository.


		// This is an example of how to include a plugin from the WordPress Plugin Repository.

		array(
			'name' => 'bulk-image-resizer',
			'slug' => 'bulk-image-resizer',
			'required' => false,
		),
		array(
			'name' => 'white-label-cms',
			'slug' => 'white-label-cms',
			'required' => false,
		),
		array(
			'name' => 'filester',
			'slug' => 'filester',
			'required' => false,
		),

		array(
			'name' => 'litespeed-cache',
			'slug' => 'litespeed-cache',
			'required' => false,
		),

		array(
			'name' => 'simply-static',
			'slug' => 'simply-static',
			'required' => false,
		),



		array(
			'name' => 'speed-booster-pack',
			'slug' => 'speed-booster-pack',
			'required' => false,
		),


		array(
			'name' => 'wp-seopress',
			'slug' => 'wp-seopress',
			'required' => false,
		),


		array(
			'name' => 'auto-image-title-alt',
			'slug' => 'auto-image-title-alt',
			'required' => false,
		),

		array(
			'name' => 'wp-original-media-path',
			'slug' => 'wp-original-media-path',
			'required' => false,
		),	
		array(
			'name' => 'wp-asset-clean-up',
			'slug' => 'wp-asset-clean-up',
			'required' => false,
		),



	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id' => 'ob_plug', // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '', // Default absolute path to bundled plugins.
		'menu' => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug' => 'plugins.php', // Parent menu slug.
		'capability' => 'edit_theme_options', // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices' => true, // Show admin notices or not.
		'dismissable' => true, // If false, a user cannot dismiss the nag message.
		'dismiss_msg' => 'Plugins recommended:', // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true, // Automatically activate plugins after installation or not.
		'message' => '-- ONLY INSTALL ONE PLUGIN AT A TIME --', // Message to output right before the plugins table.


		'strings'      => array(
			'page_title'                      => __('Install Required Plugins', 'ob_plug'),
			'menu_title'                      => __('Recommended Plugins', 'ob_plug'),
		)
		/* translators: %s: plugin name. * /
	 'installing'                      => __( 'Installing Plugin: %s', 'ob_plug' ),
	 /* translators: %s: plugin name. * /
	 'updating'                        => __( 'Updating Plugin: %s', 'ob_plug' ),
	 'oops'                            => __( 'Something went wrong with the plugin API.', 'ob_plug' ),
	 'notice_can_install_required'     => _n_noop(
	 /* translators: 1: plugin name(s). * /
	 'This theme requires the following plugin: %1$s.',
	 'This theme requires the following plugins: %1$s.',
	 'ob_plug'
	 ),
	 'notice_can_install_recommended'  => _n_noop(
	 /* translators: 1: plugin name(s). * /
	 'This theme recommends the following plugin: %1$s.',
	 'This theme recommends the following plugins: %1$s.',
	 'ob_plug'
	 ),
	 'notice_ask_to_update'            => _n_noop(
	 /* translators: 1: plugin name(s). * /
	 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
	 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
	 'ob_plug'
	 ),
	 'notice_ask_to_update_maybe'      => _n_noop(
	 /* translators: 1: plugin name(s). * /
	 'There is an update available for: %1$s.',
	 'There are updates available for the following plugins: %1$s.',
	 'ob_plug'
	 ),
	 'notice_can_activate_required'    => _n_noop(
	 /* translators: 1: plugin name(s). * /
	 'The following required plugin is currently inactive: %1$s.',
	 'The following required plugins are currently inactive: %1$s.',
	 'ob_plug'
	 ),
	 'notice_can_activate_recommended' => _n_noop(
	 /* translators: 1: plugin name(s). * /
	 'The following recommended plugin is currently inactive: %1$s.',
	 'The following recommended plugins are currently inactive: %1$s.',
	 'ob_plug'
	 ),
	 'install_link'                    => _n_noop(
	 'Begin installing plugin',
	 'Begin installing plugins',
	 'ob_plug'
	 ),
	 'update_link' 					  => _n_noop(
	 'Begin updating plugin',
	 'Begin updating plugins',
	 'ob_plug'
	 ),
	 'activate_link'                   => _n_noop(
	 'Begin activating plugin',
	 'Begin activating plugins',
	 'ob_plug'
	 ),
	 'return'                          => __( 'Return to Required Plugins Installer', 'ob_plug' ),
	 'plugin_activated'                => __( 'Plugin activated successfully.', 'ob_plug' ),
	 'activated_successfully'          => __( 'The following plugin was activated successfully:', 'ob_plug' ),
	 /* translators: 1: plugin name. * /
	 'plugin_already_active'           => __( 'No action taken. Plugin %1$s was already active.', 'ob_plug' ),
	 /* translators: 1: plugin name. * /
	 'plugin_needs_higher_version'     => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'ob_plug' ),
	 /* translators: 1: dashboard link. * /
	 'complete'                        => __( 'All plugins installed and activated successfully. %1$s', 'ob_plug' ),
	 'dismiss'                         => __( 'Dismiss this notice', 'ob_plug' ),
	 'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'ob_plug' ),
	 'contact_admin'                   => __( 'Please contact the administrator of this site for help.', 'ob_plug' ),
	 'nag_type'                        => '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
	 ),
	 */
	);

	tgmpa($plugins, $config);
}

remove_theme_support( 'wc-product-gallery-zoom' ); 

remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
add_action('customize_controls_head', 'blank4_customize_css'); // admin_head is a hook my_custom_fonts is a function we are adding it to the hook

function blank4_customize_css() {
  echo '<style>

.CodeMirror {
    filter: invert(.98) opacity(.9);
}

.collapsed .customize-control .CodeMirror{
    position: fixed;
    top: 0px;
    left: 0px;
    width: 40%;
    resize: both;
    z-index: 9999;
}

</style>';
}
