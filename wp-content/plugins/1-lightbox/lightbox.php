<?php
/**
 * Plugin Name: 1-Lightbox
 * Description: Auto add a lightbox script (using <a href="https://fancyapps.com/fancybox/3/" target="_blank">Fancybox</ * a>).
 * Author:      osmik
 * Author URI:  https://osmik.se
 *
 * @package 1-lightbox
 */

/**
 * Load Plugin CLass
 */
new Tailored_Lightbox();

/**
 * Plugin class
 */
class Tailored_Lightbox {
	/**
	 * Fancybox Version
	 *
	 * @var string
	 */
 	public $version = '4.0.2';


	/**
	 *  Constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 *  Enqueue script
	 */
	public function enqueue_scripts() {
		$script_url = plugins_url( 'fancybox' . '/', __FILE__ );

		wp_enqueue_script( 'fancybox', $script_url . 'jquery.fancybox.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_style( 'fancybox', $script_url . 'jquery.fancybox.min.css', array(), $this->version, 'screen' );

		$inline = $this->get_inline_script();
		$inline = str_replace( array( '<script>', '</script>' ), '', $inline ); // tags really only there for source formatting in my code.
		wp_add_inline_script( 'fancybox', $inline );
	}

	/**
	 *  Inline script to prepare the loader
	 */
	public function get_inline_script() {
		ob_start();
		?>
<script>
// Loader added for Fancybox

jQuery(document).ready(function($) {
	// Apply to links to images.
	 $('a[href$=".webp"], a[href$=".jpeg"], a[href$=".png"], a[href$=".jpg"]').attr('rel','fancybox');
	// Captions.
	$('a[rel="fancybox"]').each(function(i) {
		var caption = false;
		caption_text = $(this).closest('.gallery-item').find('.wp-caption-text').text();
		if (!caption && caption_text) caption = caption_text;
		if (!caption)	caption = $(this).attr('title');
		if (!caption)	caption = $(this).children('img:first').attr('title');
		if (!caption)	caption = $(this).children('img:first').attr('alt');
		if (caption)	$(this).attr('data-caption', caption);
	});
	// Group them so you can look prev/next.
	$('a[rel="fancybox"]').attr('data-fancybox', '-0');
	$("[data-fancybox]").fancybox({ loop: true });
});
</script>


	

		<?php
		return ob_get_clean();
	}


}
