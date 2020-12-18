<?php

// =============================================================================
// TCO.PHP
// -----------------------------------------------------------------------------
// Code commonly used across Themeco products.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Class Definition
//       a. Version
//       b. Boilerplate
// =============================================================================

// Class Definition
// =============================================================================

if ( ! class_exists( 'TCO_1_0' ) ) :

  class TCO_1_0 {

    // Version
    // -------

    const VERSION = '1.0';


    // Boilerplate
    // -----------

    private static $instance;
    protected $path = '';
    protected $url = '';

    public function __construct( $file ) {
      $this->path = plugin_dir_path( $file );
      add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), -999 );
      require_once( $this->path( 'class-tco-updates.php' ) );
      require_once( $this->path( 'class-tco-validator.php' ) );
      TCO_Updates::$tco = $this;
      TCO_Validator::$tco = $this;
    }

    public function init( $options ) {
      if ( isset( $options['url'] ) ) {
        $this->url = trailingslashit( $options['url'] );
      }
    }

    public static function instance() {
      if ( ! isset( self::$instance ) ) {
        self::$instance = new self( __FILE__ );
      }
      return self::$instance;
    }


    // Script & Style Registration
    // ---------------------------
    // 01. Admin styles.
    // 02. Admin scripts.

    public function admin_enqueue_scripts() {

      wp_register_style( $this->handle( 'admin-css' ), $this->url( 'dist/css/tco.css' ), array(), self::VERSION ); // 01

      $handle = $this->handle( 'admin-js' );

      wp_register_script( $handle, $this->url( 'dist/js/tco.js' ), array( 'jquery', 'wp-util' ), self::VERSION, true ); // 02

      // Localization will be handled by products, but this will setup fallbacks.
      wp_localize_script( $handle, 'tcoCommon', array(
        'debug' => ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ),
        'logo'  => $this->get_themeco_logo(),
        '_tco_nonce' => wp_create_nonce( 'tco-common' ),
        'strings' => apply_filters( 'tco_localize_' . $handle, array() )
      ) );

    }


    // Helpers
    // -------
    // 01. Get a versioned handle that can be used to specify dependencies.
    // 02. Get the path to the /tco-common/ folder (optionally add to the path).
    // 03. Get the URL to the /tco-common/ folder (optionally add to the URL).
    // 04. Get the update module.
    // 05. Get current admin color scheme.
    // 06. Return admin image.
    // 07. Echo admin image.
    // 08. Return admin icon.
    // 09. Echo admin icon.
    // 10. Return Themeco logo.
    // 11. Echo Themeco logo.
    // 12. Return X logo.
    // 13. Echo X logo.
    // 14. Return Pro logo.
    // 15. Echo Pro logo.
    // 16. Return Header Builder logo.
    // 17. Echo Header Builder logo.
    // 18. Return Content Builder logo.
    // 19. Echo Content Builder logo.
    // 20. Return Footer Builder logo.
    // 21. Echo Footer Builder logo.
    // 22. Return Cornerstone logo.
    // 23. Echo Cornerstone logo.
    // 24. Return product logo.
    // 25. Echo product logo.
    // 26. Output styled admin notice.
    // 27. Get site URL.
    // 28. Check AJAX referrer.

    public function handle( $handle = 'admin-js' ) { // 01
      return 'tco-common-' . $handle . '-' . str_replace( '.', '-', self::VERSION );
    }

    public function path( $more = '' ) { // 02
      return $this->path . $more;
    }

    public function url( $more = '' ) { // 03
      return $this->url . $more;
    }

    public function updates() { // 04
    	return TCO_Updates::instance();
    }

    function get_current_admin_color_scheme( $type = 'colors' ) { // 05
      GLOBAL $_wp_admin_css_colors;
      $current_color_scheme = get_user_option( 'admin_color' );
      $admin_colors         = $_wp_admin_css_colors;
      $user_colors          = (array) $admin_colors[$current_color_scheme];
      return ( $type == 'icons' ) ? $user_colors['icon_colors'] : $user_colors['colors'];
    }

    public function get_admin_image( $image ) { // 06
      $image = $this->url( 'img/admin/' . $image );
      return $image;
    }

    public function admin_image( $image ) { // 07
      echo $this->get_admin_image( $image );
    }

    public function get_admin_icon( $icon, $class = '', $style = '' ) { // 08
      $href   = $this->url( 'img/admin/icons.svg#' . $icon );
      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';
      $output = '<svg' . $class . $style . '><use xlink:href="' . $href . '"></use></svg>';
      return $output;
    }

    public function admin_icon( $icon, $class = '', $style = '' ) { // 09
      echo $this->get_admin_icon( $icon, $class, $style );
    }

    public function get_themeco_logo( $class = '', $style = '' ) { // 10

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 4320 504" style="enable-background:new 0 0 4320 504;" xml:space="preserve">
                 <polygon points="198,0 0,0 0,108 198,108 198,504 306,504 306,108 504,108 504,0 306,0     "/>
                 <polygon points="1008,198 720,198 720,0 612,0 612,198 612,306 612,504 720,504 720,306 1008,306 1008,504 1116,504 1116,306 1116,198 1116,0 1008,0    "/>
                 <rect x="1224" width="504" height="108"/>
                 <rect x="1224" y="198" width="504" height="108"/>
                 <rect x="1224" y="396" width="504" height="108"/>
                 <polygon points="2214,0 2106,0 1944,0 1836,0 1836,108 1836,504 1944,504 1944,108 2106,108 2106,504 2214,504 2214,108 2376,108 2376,504 2484,504 2484,108 2484,0 2376,0    "/>
                 <rect x="2592" width="504" height="108"/>
                 <rect x="2592" y="198" width="504" height="108"/>
                 <rect x="2592" y="396" width="288" height="108"/>
                 <rect x="2988" y="396" width="108" height="108"/>
                 <polygon points="3204,0 3204,108 3204,396 3204,504 3312,504 3708,504 3708,396 3312,396 3312,108 3708,108 3708,0 3312,0     "/>
                 <path d="M4212,0h-288h-108v108v288v108h108h288h108V396V108V0H4212z M4212,396h-288V108h288V396z"/>
               </svg>';

      return $logo;

    }

    public function themeco_logo( $class = '', $style = '' ) { // 11
      echo $this->get_themeco_logo( $class, $style );
    }

    public function get_x_logo( $class = '', $style = '' ) { // 12

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' viewBox="0 0 400 400" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                 <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                   <g transform="translate(-600.000000, 0.000000)" fill="currentColor">
                     <path d="M800,0 C910.45695,0 1000,89.54305 1000,200 C1000,310.45695 910.45695,400 800,400 C689.54305,400 600,310.45695 600,200 C600,89.54305 689.54305,0 800,0 Z M800,32 C707.216162,32 632,107.216162 632,200 C632,292.783838 707.216162,368 800,368 C892.783838,368 968,292.783838 968,200 C968,107.216162 892.783838,32 800,32 Z M870.574841,129.167358 L870.607003,129.199519 L870.607003,129.199519 C877.193924,135.80404 877.194105,146.493373 870.607409,153.098118 L823.866082,199.967082 L870.800075,246.772902 C877.381792,253.336633 877.396373,263.993124 870.832642,270.574841 L870.800481,270.607003 L870.800481,270.607003 C864.19596,277.193924 853.506627,277.194105 846.901882,270.607409 L800.032082,223.866082 L753.227098,270.800075 C746.663367,277.381792 736.006876,277.396373 729.425159,270.832642 C729.414424,270.821936 729.403703,270.811216 729.392997,270.800481 C722.806076,264.19596 722.805895,253.506627 729.392591,246.901882 L776.133082,200.032082 L729.199925,153.227098 C722.618208,146.663367 722.603627,136.006876 729.167358,129.425159 C729.178064,129.414424 729.188784,129.403703 729.199519,129.392997 C735.80404,122.806076 746.493373,122.805895 753.098118,129.392591 L799.967082,176.133082 L846.772902,129.199925 C853.336633,122.618208 863.993124,122.603627 870.574841,129.167358 Z" id="X-(Outlined)"></path>
                   </g>
                 </g>
               </svg>';

      return $logo;

    }

    public function x_logo( $class = '', $style = '' ) { // 13
      echo $this->get_x_logo( $class, $style );
    }

    public function get_pro_logo( $class = '', $style = '' ) { // 14

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? 'fill: currentColor;' : $style;

      $logo = '<svg' . $class . ' style="' . $style . '" viewBox="0 0 400 450" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
          <g transform="translate(-10.000000, -600.000000)" fill="currentColor">
            <path d="M230.016931,605.368943 L308.738808,650.870363 L390.016931,697.849298 C402.383432,704.997163 410,718.196895 410,732.480534 L410,917.519466 C410,931.803105 402.383432,945.002837 390.016931,952.150702 L230.016931,1044.63106 C217.632285,1051.78941 202.367715,1051.78941 189.983069,1044.63106 L29.983069,952.150702 C17.616568,945.002837 10,931.803105 10,917.519466 L10,732.480534 C10,718.196895 17.616568,704.997163 29.983069,697.849298 L189.983069,605.368943 C202.367715,598.21059 217.632285,598.21059 230.016931,605.368943 Z M214,881.001863 L139,881.001863 C134.029437,881.001863 130,885.0313 130,890.001863 L130,890.001863 L130.003837,890.267824 C130.144209,895.115648 134.118197,899.002462 139,899.002462 L139,899.002462 L214,899.002462 C218.970563,899.002462 223,894.973024 223,890.002462 L223,890.002462 L222.996163,889.736501 C222.855791,884.888676 218.881803,881.001863 214,881.001863 L214,881.001863 Z M214,848.000765 L139,848.000765 C134.029437,848.000765 130,852.030202 130,857.000765 L130,857.000765 L130.003837,857.266726 C130.144209,862.11455 134.118197,866.001364 139,866.001364 L139,866.001364 L214,866.001364 C218.970563,866.001364 223,861.971927 223,857.001364 L223,857.001364 L222.996163,856.735403 C222.855791,851.887579 218.881803,848.000765 214,848.000765 L214,848.000765 Z M274,815.999701 L139,815.999701 C134.029437,815.999701 130,820.029138 130,824.999701 L130,824.999701 L130.003837,825.265662 C130.144209,830.113486 134.118197,834.000299 139,834.000299 L139,834.000299 L274,834.000299 C278.970563,834.000299 283,829.970862 283,825.000299 L283,825.000299 L282.996163,824.734338 C282.855791,819.886514 278.881803,815.999701 274,815.999701 L274,815.999701 Z M298,783.998636 L139,783.998636 C134.029437,783.998636 130,788.028073 130,792.998636 L130,792.998636 L130.003837,793.264597 C130.144209,798.112421 134.118197,801.999235 139,801.999235 L139,801.999235 L298,801.999235 C302.970563,801.999235 307,797.969798 307,792.999235 L307,792.999235 L306.996163,792.733274 C306.855791,787.88545 302.881803,783.998636 298,783.998636 L298,783.998636 Z M274,750.997538 L139,750.997538 C134.029437,750.997538 130,755.026976 130,759.997538 L130,759.997538 L130.003837,760.263499 C130.144209,765.111324 134.118197,768.998137 139,768.998137 L139,768.998137 L274,768.998137 C278.970563,768.998137 283,764.9687 283,759.998137 L283,759.998137 L282.996163,759.732176 C282.855791,754.884352 278.881803,750.997538 274,750.997538 L274,750.997538 Z"></path>
          </g>
        </g>
      </svg>';

      return $logo;

    }

    public function pro_logo( $class = '', $style = '' ) { // 15
      echo $this->get_pro_logo( $class, $style );
    }

    public function get_header_builder_logo( $class = '', $style = '' ) { // 16

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' viewBox="0 0 340 232" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                 <g transform="matrix(1,0,0,1,-2456.75,-5251.97)">
                   <g transform="matrix(1.40625,-8.09101e-17,-5.21329e-17,1,843.357,4613.58)">
                     <g transform="matrix(0.711111,8.55019e-18,-6.47074e-18,1,320.729,57.1198)">
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M166.277,480L471.118,304L581.969,368L277.128,544L166.277,480Z" style="fill:rgb(198,135,223);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M581.969,432L277.128,608L277.128,544L581.969,368L581.969,432Z" style="fill:rgb(157,118,189);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M166.277,480L166.277,544L277.128,608L277.128,544L166.277,480Z" style="fill:rgb(141,96,179);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1054.18,420.664)">
                         <path d="M692.82,592L803.672,528L803.672,464L692.82,528L692.82,592Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1054.18,420.664)">
                         <path d="M637.395,368L526.543,432L692.82,528L803.672,464L637.395,368Z" style="fill:rgb(23,207,243);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1054.18,420.664)">
                         <path d="M692.82,592L526.543,496L526.543,432L692.82,528L692.82,592Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M304.841,624L304.841,560L471.118,656L471.118,720L304.841,624Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M637.395,624L637.395,560L471.118,656L471.118,720L637.395,624Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1069.64,411.741)">
                         <path d="M471.118,464L304.841,560L471.118,656L637.395,560L471.118,464Z" style="fill:rgb(23,207,243);"/>
                       </g>
                     </g>
                   </g>
                 </g>
               </svg>';

      return $logo;

    }

    public function header_builder_logo( $class = '', $style = '' ) { // 17
      echo $this->get_header_builder_logo( $class, $style );
    }

    public function get_content_builder_logo( $class = '', $style = '' ) { // 18

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' viewBox="0 0 345 232" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                 <g transform="matrix(1,0,0,1,-3343.72,-5251.96)">
                   <g transform="matrix(1.40625,-8.09101e-17,-5.21329e-17,1,843.357,4613.58)">
                     <g transform="matrix(1,0,1.2326e-32,1,-153.994,13.4452)">
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M237.029,152.955L237.029,185.144L223.104,177.092L223.104,161.005L223.086,161.005L181.258,136.851L181.258,120.746L237.029,152.955Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M181.258,120.746L237.029,152.955L334.629,96.607L278.858,64.399L181.258,120.746Z" style="fill:rgb(23,207,243);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M237.029,152.955L237.029,185.144L334.629,128.798L334.629,96.607L237.029,152.955Z" style="fill:rgb(0,188,225);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M223.086,161.004L167.315,193.197L167.315,225.404L223.086,193.197L223.105,177.093L223.105,161.004L223.086,161.004Z" style="fill:rgb(157,118,189);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M111.56,193.214L167.315,225.404L167.315,193.197L111.56,161.004L111.56,193.214Z" style="fill:rgb(141,96,179);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M223.086,161.005L167.314,193.197L111.561,161.005L153.371,136.851L167.314,128.798L181.258,136.851L223.086,161.005Z" style="fill:rgb(198,135,223);"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M223.086,177.093L223.105,177.093L223.086,177.093Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M98.804,153.65L98.804,152.955L98.804,153.65Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M167.315,0L0,96.607L97.619,152.955L153.371,120.746L139.447,112.711L111.543,96.607L223.105,32.209L167.315,0Z" style="fill:rgb(23,207,243);"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M0,128.798L97.898,185.318L98.804,184.812L98.804,153.65L97.619,152.955L0,96.607L0,128.798Z" style="fill:rgb(0,172,207);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M223.104,32.209L223.104,64.399L139.447,112.693L139.447,112.711L111.543,96.607L223.104,32.209Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M98.804,185.841L97.899,185.318L98.804,185.841Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M97.619,185.493L97.898,185.318L97.619,185.493Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M98.804,185.841L98.804,184.812L98.804,185.841Z" style="fill:rgb(254,120,100);fill-rule:nonzero;"/>
                       </g>
                       <g transform="matrix(0.73192,5.92197e-17,3.81571e-17,1.02926,1932.03,624.936)">
                         <path d="M153.371,120.746L153.371,136.851L111.561,161.005L111.561,177.441L111.543,177.441L98.804,184.812L98.804,153.65L97.619,152.955L153.371,120.746Z" style="fill:rgb(0,188,225);fill-rule:nonzero;"/>
                       </g>
                     </g>
                   </g>
                 </g>
               </svg>';

      return $logo;

    }

    public function content_builder_logo( $class = '', $style = '' ) { // 19
      echo $this->get_content_builder_logo( $class, $style );
    }

    public function get_footer_builder_logo( $class = '', $style = '' ) { // 20

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' viewBox="0 0 340 232" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:1.41421;">
                 <g transform="matrix(1,0,0,1,-2900.24,-5251.97)">
                   <g transform="matrix(1.40625,-8.09101e-17,-5.21329e-17,1,843.357,4613.58)">
                     <g transform="matrix(0.711111,8.55019e-18,-6.47074e-18,1,299.899,57.1198)">
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1449.69,376.05)">
                         <path d="M692.82,592L803.672,528L803.672,464L692.82,528L692.82,592Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1449.69,376.05)">
                         <path d="M637.395,368L526.543,432L692.82,528L803.672,464L637.395,368Z" style="fill:rgb(23,207,243);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1449.69,376.05)">
                         <path d="M692.82,592L526.543,496L526.543,432L692.82,528L692.82,592Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1465.15,367.128)">
                         <path d="M304.841,624L304.841,560L471.118,656L471.118,720L304.841,624Z" style="fill:rgb(0,172,207);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1465.15,367.128)">
                         <path d="M637.395,624L637.395,560L471.118,656L471.118,720L637.395,624Z" style="fill:rgb(0,188,225);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1465.15,367.128)">
                         <path d="M471.118,464L304.841,560L471.118,656L637.395,560L471.118,464Z" style="fill:rgb(23,207,243);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1650.6,474.2)">
                         <path d="M166.277,480L471.118,304L581.969,368L277.128,544L166.277,480Z" style="fill:rgb(198,135,223);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1650.6,474.2)">
                         <path d="M581.969,432L277.128,608L277.128,544L581.969,368L581.969,432Z" style="fill:rgb(157,118,189);"/>
                       </g>
                       <g transform="matrix(0.557668,2.73178e-17,3.41473e-17,0.557668,1650.6,474.2)">
                         <path d="M166.277,480L166.277,544L277.128,608L277.128,544L166.277,480Z" style="fill:rgb(141,96,179);"/>
                       </g>
                     </g>
                   </g>
                 </g>
               </svg>';

      return $logo;

    }

    public function footer_builder_logo( $class = '', $style = '' ) { // 21
      echo $this->get_footer_builder_logo( $class, $style );
    }

    public function get_cornerstone_logo( $class = '', $style = '' ) { // 22

      $class  = ( $class == '' ) ? '' : ' class="' . $class . '"';
      $style  = ( $style == '' ) ? '' : ' style="' . $style . '"';

      $logo = '<svg' . $class . $style . ' version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="-137 283 336 227" enable-background="new -137 283 336 227" xml:space="preserve">
                 <path fill="#26CABC" d="M86.8,444.8C52.6,464.5,65.3,457.2,31,477c-5.9-3.4-49.9-28.8-55.8-32.2c61.8-35.7,25.9-15,55.8-32.2C49.9,423.5,33.8,414.2,86.8,444.8z"/>
                 <path fill="#22B3A6" d="M86.8,444.8V477c-34.2,19.7-21.5,12.4-55.8,32.2V477C65.2,457.3,52.5,464.6,86.8,444.8z"/>
                 <path fill="#1D968D" d="M31,477v32.2c-5.9-3.4-49.9-28.8-55.8-32.2v-32.2C-18.9,448.2,25.1,473.6,31,477z"/>
                 <path fill="#DF5540" d="M-38.7,436.7L-38.7,436.7v32.2c-54.9-31.7-13.2-7.6-97.6-56.4v-32.1C-135.9,380.7-67.1,420.3-38.7,436.7z"/>
                 <path fill="#FA5745" d="M86.8,316v32.2c-74.9,43.3-33.5,19.4-83.7,48.3l-27.9-16.1C73,324,24.8,351.8,86.8,316z"/>
                 <path fill="#FE7864" d="M31,283.8l-167.3,96.6c0.5,0.3,69.2,40,97.6,56.3l55.8-32.2c-17.7-10.2-8.7-5-41.8-24.1C73,324,24.8,351.8,86.8,316L31,283.8z"/>
                 <path fill="#FE7864" d="M142.5,348.2c-13.4,7.7-83.9,48.4-97.6,56.3l55.8,32.2c29-16.7,94.9-54.8,97.6-56.4C164.1,360.7,176.8,368,142.5,348.2z"/>
                 <path fill="#FA5745" d="M198.3,380.4v32.2c0,0-97.6,56.3-97.6,56.4v-32.2C129.7,420,195.6,382,198.3,380.4z"/>
                 <path fill="#FA5745" d="M17,404.5v16.1c-17.8,10.3-8.8,5.1-41.8,24.1v16.4l-13.6,7.9l-0.3-0.2v-32.2l0,0L17,404.5z"/>
                 <path fill="#DF5540" d="M100.7,436.8V469l-13.9-8.1l0,0v-16.1C59,428.7,59.4,429,45,420.6v-16.1l0,0L100.7,436.8z"/>
               </svg>';

      return $logo;

    }

    public function cornerstone_logo( $class = '', $style = '' ) { // 23
      echo $this->get_cornerstone_logo( $class, $style );
    }

    public function get_product_logo( $product, $class = '', $style = '' ) { // 24
      $function = array( $this, "get_{$product}_logo" );
      if ( is_callable( $function ) ) {
        return call_user_func( $function, $class, $style );
      }
      return '';
    }

    public function product_logo( $product, $class = '', $style = '' ) { // 25
      echo $this->get_product_logo( $product, $class, $style );
    }

    public function admin_notice( $msg = '', $args = array() ) { // 26

      if ( is_array( $msg ) ) {
        $args = $msg;
      }

      $args = wp_parse_args( $args, array(
        'message'     => is_string( $msg ) ? $msg : '',
        'handle'      => false,
        'echo'        => true,
        'class'       => '',
        'dismissible'  => false,
        'ajax_dismiss' => false
      ) );

      extract( $args );

      $script = '';

      if ( is_string( $ajax_dismiss ) ) {

        if ( ! $handle ) {
          $handle = 'tco_' . uniqid();
        }

        ob_start(); ?>

        <script type="text/javascript">
        jQuery( function( $ ) {
          $('[data-tco-notice="<?php echo $handle; ?>"]').on( 'click', '.notice-dismiss', function(){
            $.post('<?php echo admin_url('admin-ajax.php?action=' . esc_attr( $ajax_dismiss ) ); ?>');
          });
        } );
        </script>
        <?php

        $script = ob_get_clean();

      }

      $class = ( $dismissible ) ? ' ' . $class . ' is-dismissible' : ' ' . $class;

      $logo_svg = $this->get_themeco_logo();
      $logo = "<a class=\"tco-notice-logo\" href=\"https://theme.co/\" target=\"_blank\">{$logo_svg}</a>";

      if ( $handle ) {
      $handle = "data-tco-notice=\"$handle\"";
      }

      $notice = "<div class=\"tco-notice notice {$class}\" {$handle}>{$logo}<p>{$message}</p></div>{$script}";

      if ( $echo ) {
        echo $notice;
      }

      return $notice;

    }

    public function get_site_url() { // 27
      return esc_attr( trailingslashit( network_home_url() ) );
    }

    public function check_ajax_referer( $die = true ) { // 28

      if ( ! isset( $_REQUEST['_tco_nonce'] ) ) {
        wp_send_json_error();
      }

      $check = ( false !== wp_verify_nonce( $_REQUEST['_tco_nonce'], 'tco-common' ) );

      if ( ! $check && $die ) {
        wp_send_json_error();
      }

      return $check;

    }

  }

endif;
