<?php

/**
 * Manage all the front end code for Cornerstone
 * including shortcode styling and scripts
 */

class Cornerstone_Front_End extends Cornerstone_Plugin_Component {

	public $dependencies = array( 'Inline_Scripts' );

	/**
	 * Setup hooks
	 */
	public function setup() {

		add_filter('template_include', array( $this, 'setup_after_template_include' ), 99998 );

		// Enqueue Scripts & Styles

		add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ), 5 );
		add_action( 'wp_enqueue_scripts', array( $this, 'styles' ), 5 );
		add_action( 'cs_late_template_redirect', array( $this, 'postLoaded' ), 9998, 0 );

		// Excerpt related functions
		add_filter( 'strip_shortcodes_tagnames', array($this, 'preserve_excerpt'), 999999 );

		// Add Body Class
		add_filter( 'body_class', array( $this, 'addBodyClass' ), 10002 );

		add_filter( 'the_content', array( $this, 'maybe_noemptyp' ), 10 );

		add_shortcode( 'cs_content_seo', array( $this, 'cs_content_seo' ) );

    add_action( 'wp_head', array( $this, 'cs_head_late'), 10000 );
    add_action( 'wp_head', array( $this, 'cs_head_late_after'), 10001 );

    add_action( 'wp_footer', array( $this, 'output_late_styles') );

    add_action( 'cs_element_rendering', array( $this, 'register_scripts') );
    add_action( 'wp_footer', array( $this, 'shim_x_zones') ); // Needed for preview

    add_filter( 'script_loader_tag', array( $this, 'fix_script_tags'), 0, 3 );

	}

	/**
	 * A late template_redirect hook allows plugins like Custom 404 and Under Construction
	 * to modify the query before we assume we can query info like the current ID
	 */
	public function setup_after_template_include( $template ) {
		do_action('cs_late_template_redirect');
		return $template;
	}

	/**
	 * Enqueue Styles
	 */
	public function styles() {

		if ( apply_filters( 'cornerstone_enqueue_styles', true ) ) {
			$style_asset = $this->plugin->css( 'site/style' );
			wp_enqueue_style( 'cornerstone-shortcodes', $style_asset['url'], array(), $style_asset['version'] );
		}

		if ( apply_filters( 'cornerstone_legacy_font_classes', false ) ) {
			$fa_icons_asset = $this->plugin->css( 'site/fa-icon-classes' );
			wp_enqueue_style( 'x-fa-icon-classes', $fa_icons_asset['url'], array(), $fa_icons_asset['version'] );
		}

	}

	/**
	 * Enqueue Scripts
	 */
	public function scripts() {
  	$this->register_scripts();
  	wp_enqueue_script( 'cornerstone-site-body' );
	}

  public function register_scripts() {
		$script_asset = CS()->js( 'site/cs' );
		wp_register_script( 'cornerstone-site-body', $script_asset['url'], array( 'jquery' ), $script_asset['version'], true );
  	wp_register_script( 'vendor-ilightbox', $this->url( 'assets/dist/js/site/ilightbox.js' ), array( 'jquery' ), $this->plugin->version(), true );
  }

	public function postLoaded() {

		if ( apply_filters( '_cornerstone_front_end', true ) ) {
			add_action( 'wp_head', array( $this,  'inlineStyles' ), 9998, 0 );
			add_action( 'wp_footer', array( $this, 'inlineScripts' ) );
		}

		add_action( 'cornerstone_head_css', array( $this, 'output_generated_styles') );
		add_action( 'x_head_css', array( $this, 'output_generated_styles') );
    $inline_scripts = $this->plugin->component('Inline_Scripts');
		add_action( 'wp_footer', array( $inline_scripts, 'output_scripts' ), 9998, 0 );


		$this->postSettings = $this->plugin->common()->get_post_settings( get_the_ID() );

	}

  public function output_generated_styles() {
		echo $this->get_fa_styles();
		echo $this->plugin->component('Styling')->get_generated_styles();
  }

  /**
	 * Add Body class from Cornerstone Version number
	 */
	public function addBodyClass( $classes ) {
		$classes[] = 'cornerstone-v' . str_replace( '.', '_', $this->plugin->version() );
	  return $classes;
	}

	public function get_fa_styles() {
		return $this->plugin->component('Styling')->post_process( array(
			'css' => $this->view( 'frontend/font-awesome', false, $this->plugin->common()->get_fa_config(), true),
			'minify' => true
		) );
	}

	/**
	 * Load generated CSS output and place style tag in wp_head
	 */
	public function inlineStyles() {

		ob_start();

		$styling = $this->plugin->component('Styling');
		if ( apply_filters( 'cornerstone_customizer_output', true ) ) {

			echo '<style id="cornerstone-generated-css">';

			$data = array_merge( $this->plugin->settings(), $this->plugin->common()->theme_integration_options() );
			$this->view( 'frontend/styles', true, $data, true );

    	do_action( 'cornerstone_head_css' );

	  	echo '</style>';

			$custom_css = $styling->post_process( get_option( 'cs_v1_custom_css', '' ) );
			if ( $custom_css ) {
				echo "<style id=\"cornerstone-custom-css\">$custom_css</style>";
			}

		}

		if ( is_singular() && apply_filters( '_cornerstone_custom_css', isset( $this->postSettings['custom_css'] ) ) ) {
			ob_start();
			echo $styling->post_process( $this->postSettings['custom_css'] );
			do_action( 'cornerstone_custom_page_css' );
			$page_style = ob_get_clean();
			if ( $page_style ) {
				echo "<style id=\"cornerstone-custom-page-css\">$page_style</style>";
			}
		}

	  $css = ob_get_contents(); ob_end_clean();

	  //
	  // 1. Remove comments.
	  // 2. Remove whitespace.
	  // 3. Remove starting whitespace.
	  //

	  $output = preg_replace( '#/\*.*?\*/#s', '', $css );            // 1
	  $output = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $output ); // 2
	  $output = preg_replace( '/\s\s+(.*)/', '$1', $output );        // 3

	  echo $output;
	}

	public function inlineScripts() {

    $inline_scripts = $this->plugin->component('Inline_Scripts');

		if ( apply_filters( 'cornerstone_customizer_output', true ) ) {
			$custom_js = get_option( 'cs_v1_custom_js', '' );
      if ( $custom_js ) {
        $inline_scripts->add_script('cornerstone-custom-js', $custom_js );
      }
		}

		if ( is_singular() && isset( $this->postSettings['custom_js'] ) && $this->postSettings['custom_js'] ) {
      $inline_scripts->add_script('cornerstone-custom-content-js', $this->postSettings['custom_js'] );
		}

	}

	/**
	 * Preserve content of [cs_content_seo][/cs_content_seo] making it visible for excerpt generation.
	 */
	public function preserve_excerpt ( $tags ) {
		return array_diff ($tags, array('cs_content_seo'));
	}

	/**
	 * Cornerstone adds a wrapping [cs_content] shortcode.Run the content through
	 * cs_noemptyp if we know it was originally generated by Cornerstone.
	 * This cleans up any empty <p> tags.
	 * @param  string $content Early the_content. Before do_shortcode
	 * @return string          the_content with empty <p> tags removed and wrapping div
	 */
	public function maybe_noemptyp( $content ) {

		if ( false !== strpos( $content, '[cs_content]' ) && false !== strpos( $content, '[/cs_content]' ) ) {
			$content = cs_noemptyp( $content );
		}

		return $content;

	}

	public function cs_content_seo ($atts, $content) {

		extract( shortcode_atts( array(
			'output'      => false
		), $atts, 'cs_content_seo' ) );

		if ( $output || doing_filter ('get_the_excerpt') ) return $content;

		return '';

	}

	public function shim_x_zones() {

		$zones = array( 'x_before_site_end' );

		foreach ($zones as $action) {
			if ( ! did_action( $action ) ) {
				do_action( $action );
			}
		}

	}

	public function output_layout_content( $content ) {
    if ( is_scalar( $content ) ) {
      echo $content;
    }
	}

  public function cs_head_late() {
    do_action( 'cs_head_late' );
  }

  public function cs_head_late_after() {
    do_action( 'cs_head_late_after' );
  }

  public function output_late_styles() {
    $styling = $this->plugin->component('Styling');
    $styling->output_late_style( 'cs-late-element-css', $styling->get_generated_late_styles() );
  }

  public function fix_script_tags( $tag, $handle, $src ) {
    return $this->plugin->component('Common')->fix_script_tags( $handle, $tag );
	}

}
