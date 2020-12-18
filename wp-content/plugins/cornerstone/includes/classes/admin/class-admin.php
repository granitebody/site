<?php
/**
 * This class manages all Dashboard related activity.
 * It handles the Options page, and adds the "Edit with Cornerstone"
 * links to the list table screens, and the toolbar.
 */

class Cornerstone_Admin extends Cornerstone_Plugin_Component {

  /**
   * Cache settings locally
   * @var array
   */
  public $settings;

  /**
   * Shortcut to our folder
   * @var string
   */
  public $path = 'includes/admin/';

  /**
   * Store script data potentially used by multiple modules
   * @var array
   */
  public $script_data = array();


  protected $front_end_toolbar_items = [];

  /**
   * Initialize, and add hooks
   */
  public function setup() {

    add_action( 'cs_late_template_redirect', [ $this, 'populate_admin_toolbar' ], 100 );
    add_action( 'admin_bar_menu', array( $this, 'addToolbarLinks' ), 999 );
    add_action( 'admin_bar_init', array( $this, 'admin_bar_css' ) );

    if ( ! is_admin() ) {
      return;
    }



    add_action( 'admin_menu',            array( $this, 'dashboard_menu' ) );
    add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
    add_filter( 'page_row_actions',      array( $this, 'addRowActions' ), 10, 2 );
    add_filter( 'post_row_actions',      array( $this, 'addRowActions' ), 10, 2 );
    add_action( 'admin_notices',         array( $this, 'notices' ), 20 );
    add_action( 'admin_print_scripts',   array( $this, 'admin_print_scripts' ), 9999);

    add_filter( 'cs_admin_app_data', array( $this, 'settings_page_enqueue' ), 10, 2 );

  }

  public function ajax_override() {

    if ( isset( $_POST['post_id'] ) && current_user_can( $this->plugin->common()->get_post_capability( $_POST['post_id'], 'edit_post' ), $_POST['post_id'] ) ) {
      update_post_meta( $_POST['post_id'], '_cornerstone_override', true );
    }

    return cs_send_json_success();

  }

  public function ajax_dismiss_validation_notice() {
    update_option( 'cornerstone_dismiss_validation_notice', true );
    return cs_send_json_success();
  }

  public function add_script_data( $handle, $callback ) {
    $this->script_data[$handle] = $callback;
  }

  public function get_script_data() {

    $modules = array();

    foreach ($this->script_data as $handle => $callback ) {
      if ( is_callable( $callback ) ) {
        $modules[$handle] = call_user_func( $callback );
      }
    }

    $notices = array();
    if ( isset( $_REQUEST['notice'] ) ) {
      $notices = explode( '|', sanitize_text_field( $_REQUEST['notice'] ) );
    }

    return array(
      'modules' => $modules,
      'notices' => $notices
    );

  }

  /**
   * Enqueue Admin Scripts and Styles
   */
  public function enqueue( $hook ) {

    $asset = $this->plugin->css( 'admin/dashboard' );
    wp_enqueue_style( 'cornerstone-admin-css', $asset['url'], array( cs_tco()->handle( 'admin-css' ) ), $asset['version'] );

    $post = $this->plugin->common()->locate_post();
    $post_id = ( $post ) ? $post->ID : 'new';
    $commonData = array(
      'homeURL'   => preg_replace('/\?lang=.*/' , '', home_url()),
      'post_id'   => $post_id,
      '_cs_nonce' => wp_create_nonce( 'cornerstone_nonce' ),
      'strings'   => $this->plugin->i18n_group( 'admin', false ),
    );

    if ( false !== strpos( $hook, 'cornerstone-home' ) ) {

      $dashboard_home_script_asset = $this->plugin->js( 'admin/dashboard-home' );
      wp_register_script( 'cs-dashboard-home-js', $dashboard_home_script_asset['url'] , array( 'react', 'react-dom', cs_tco()->handle( 'admin-js' ) ), $dashboard_home_script_asset['version'], true );
      wp_localize_script( 'cs-dashboard-home-js', 'csDashboardHomeData', array_merge( $commonData, $this->get_script_data() ) );
      wp_enqueue_script( 'cs-dashboard-home-js' );

    }

    if ( false !== strpos( $hook, csi18n('admin.dashboard-settings-path') ) ) {

      $app_permissions = $this->plugin->component('App_Permissions');

      $dashboard_settings_script_asset = $this->plugin->js( 'admin/dashboard-settings' );
      wp_register_script( 'cs-dashboard-setting-js', $dashboard_settings_script_asset['url'], array( 'wp-api-fetch', 'wp-element', 'jquery', 'lodash', 'moment', 'react', 'react-dom', 'wp-polyfill', 'wp-polyfill-fetch', cs_tco()->handle( 'admin-js' ) ), $dashboard_settings_script_asset['version'], true );
      wp_localize_script( 'cs-dashboard-setting-js', 'csDashboardSettingsData', array_merge( $commonData, array(
        'modules' => array(
          'cs-settings' => array(
            'update'   => csi18n('admin.dashboard-settings-save-update'),
            'updating' => csi18n('admin.dashboard-settings-save-updating'),
            'updated'  => csi18n('admin.dashboard-settings-save-updated'),
            'error'    => csi18n('admin.dashboard-settings-save-error')
          ),
          'cs-role-manager' => $this->plugin->component('App_Permissions')->get_app_data()
        )
      ) ) );
      wp_enqueue_script( 'cs-dashboard-setting-js' );

    }

    if ( $this->isPostEditor( $hook ) ) {

      $enqueue_dashboard = true;

      if ( $post ) {
        $skip = array();
        $skip[] = (int) get_option( 'page_for_posts' );

        if ( function_exists('wc_get_page_id') ) {
          $skip[] = (int) wc_get_page_id( 'shop' );
        }

        $enqueue_dashboard = ! in_array( (int) $post->ID, $skip, true );

      }

      if ( $enqueue_dashboard ) {
        $dashboard_post_editor_script_asset = $this->plugin->js( 'admin/dashboard-post-editor' );
        wp_register_script( 'cs-dashboard-post-editor-js', $dashboard_post_editor_script_asset['url'], array( cs_tco()->handle( 'admin-js' )  ), $dashboard_post_editor_script_asset['version'], true );

        wp_localize_script( 'cs-dashboard-post-editor-js', 'csDashboardPostEditorData', array_merge( $commonData, array(
          'editUrl' => CS()->component('Common')->get_app_route_url( 'content', '{{post_id}}'),
          'usesCornerstone' => ( $this->plugin->common()->uses_cornerstone( $post ) ) ? 'true' : 'false',
          'editorTabMarkup' => $this->view( 'admin/editor-tab', false ),
          'editorTabContentMarkup' => $this->view( 'admin/editor-tab-content', false ),
        ) ) );

        wp_enqueue_script( 'cs-dashboard-post-editor-js' );

      }


    }

    $admin_js_data = apply_filters( 'cs_admin_app_data', array(), $hook );
    if ( ! empty( $admin_js_data ) ) {

      $load_react = false;

      foreach ($admin_js_data as $app => $app_data ) {
        $load_react = $load_react || ( isset( $app_data['react'] ) && $app_data['react'] );
      }

      $admin_script_asset = $this->plugin->js( 'admin' );
      $deps = apply_filters( 'cs_admin_app_dependencies', $load_react ? array( 'wp-element', 'react', 'react-dom',  'wp-polyfill', 'wp-polyfill-fetch'  ) : array() );
      wp_register_script( 'cs-admin-js', $admin_script_asset['url'], $deps, $admin_script_asset['version'], true );
      wp_localize_script( 'cs-admin-js', 'csAdminData', $admin_js_data );
      wp_enqueue_script( 'cs-admin-js' );
    }

    if ( apply_filters( 'cornerstone_enqueue_admin_styles', true ) ) {
      wp_add_inline_style( 'admin-menu', $this->get_admin_menu_css() );
    }


  }


  /**
   * Determine if the post editor is being viewed, and Cornerstone is available
   * @param  string  $hook passed through from admin_enqueue_scripts hook
   * @return boolean
   */
  public function isPostEditor( $hook ) {

    if ( 'post.php' === $hook && isset( $_GET['action'] ) && 'edit' === $_GET['action'] ) {
      return $this->plugin->component('App_Permissions')->user_can_access_post_type();
    }

    if ( 'post-new.php' === $hook && isset( $_GET['post_type'] ) ) {
      return in_array( $_GET['post_type'], $this->plugin->component('App_Permissions')->get_user_post_types(), true );
    }

    if ( 'post-new.php' === $hook && ! isset( $_GET['post_type'] ) ) {
      return in_array( 'post', $this->plugin->component('App_Permissions')->get_user_post_types(), true );
    }

    return false;
  }

  /**
   * Register the Dashboard Menu items
   */
  public function dashboard_menu() {


    $title = csi18n('admin.dashboard-title');

    $settings_location = apply_filters('cornerstone_menu_item_root', 'cornerstone-home' );

    if ( 'cornerstone-home' === $settings_location ) {
      add_menu_page( $title, $title, 'manage_options', 'cornerstone-home', array( $this, 'render_home_page' ), $this->make_menu_icon() );
      add_submenu_page( 'cornerstone-home', $title, csi18n('admin.dashboard-menu-title'), 'manage_options', 'cornerstone-home', array( $this, 'render_home_page' ) );
    }

    $custom_items = $this->get_custom_menu_items();

    $settings_path = csi18n('admin.dashboard-settings-path');
    $settings_title = csi18n('admin.dashboard-settings-title');
    $divider = ( count($custom_items) > 1 ) ? 'data-tco-admin-menu-divider' : '';
    $settings_title = "<span $divider>$settings_title</span>";

    add_submenu_page( $settings_location, $title, $settings_title, 'manage_options', $settings_path, array( $this, 'render_settings_page' ) );


    global $submenu;

    $previous = null;
    $prev_index;
    $permitted_items = array();

    $show_launch = false;

    $menu_parent = apply_filters('cornerstone_menu_item_root', 'cornerstone-home' );

    foreach ($custom_items as $key => $value) {

      $item = array(
        'parent' => $menu_parent,
        'divider' => '',
        'class' => $key,
        'title' => $value['title'],
        'capability' => isset( $value['capability'] ) ? $value['capability'] : 'read',
        'url' => $value['url'],
      );

      if ( ! is_null($previous) && $custom_items[$previous]['group'] !== $value['group'] ) {
        $permitted_items[$prev_index]['divider'] = 'data-tco-admin-menu-divider';
      }

      $permitted_items[] = $item;

      $previous = $key;
      $prev_index = count($permitted_items) - 1;

      $show_launch = $show_launch || current_user_can($item['capability']);
    }

    $end = count($permitted_items) - 1;
    if ( isset( $permitted_items[$end] ) ) {
      $permitted_items[$end]['divider'] = 'data-tco-admin-menu-divider';
    }

    foreach ($permitted_items as $item) {
      $title = '<span ' . $item['divider'] . ' class="' . $item['class'] .'">' . $item['title'] .'</span>';
      $submenu[$item['parent']][] = array( $title, $item['capability'], $item['url'] );
    }

    // if ( $show_launch ) {
    //   $submenu[$menu_parent][] = array( __('Launch', 'cornerstone'), 'read', $this->plugin->common()->get_app_route_url('launch') );
    // }


  }

  public function get_custom_menu_items() {

    $permissions = $this->plugin->component('App_Permissions');
    $items = array();

    $is_pro = 'pro' === csi18n('app.integration-mode');

    if ( $is_pro && $permissions->user_can('headers') ) {
      $items['tco-headers'] = array(
        'title' => csi18n( "common.title.headers" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/headers'),
        'group' => 'builders'
      );
    }

    $user_post_types = $permissions->get_user_post_types();

    if ( ! empty( $user_post_types ) ) {
      $items['tco-content'] = array(
        'title' => ( $is_pro ) ? csi18n( "common.title.content" ) : csi18n( "common.title.cornerstone" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/content'),
        'group' => 'builders'
      );
    }

    if ( $is_pro && $permissions->user_can('footers') ) {
      $items['tco-footers'] = array(
        'title' => csi18n( "common.title.footers" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/footers'),
        'group' => 'builders'
      );
    }

    if ( $is_pro && $permissions->user_can('layouts') ) {
      $items['tco-layouts'] = array(
        'title' => csi18n( "common.title.layouts" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/layouts'),
        'group' => 'builders'
      );
    }

    $theme_options_url = $this->plugin->common()->get_app_route_url('theme-options');

    global $wp;

    if( ! is_admin() && $wp->request) {
      $theme_options_url .= '?url=' . esc_url( home_url( $wp->request ));
    }

    if ( $permissions->user_can('theme_options') ) {
      $items['tco-options'] = array(
        'title' => csi18n( "common.title.options-theme" ),
        'url' => $theme_options_url,
        'group' => 'theme-options'
      );
    }


    if ( $permissions->user_can('templates') ) {
      $items['tco-templates'] = array(
        'title' => csi18n( "common.title.template-manager" ),
        'url' => $this->plugin->common()->get_app_route_url('template-manager'),
        'group' => 'manage'
      );
    }

    if ( $permissions->user_can('content.cs_global_block') ) {
      $items['tco-global-blocks'] = array(
        'title' => csi18n( "common.title.global-blocks" ),
        'url' => $this->plugin->common()->get_app_route_url('launch/global-blocks'),
        'group' => 'manage'
      );
    }

    if ( $permissions->user_can('templates.design_cloud') ) {
      $items['tco-design-cloud'] = array(
        'title' => csi18n( "common.title.design-cloud" ),
        'url' => $this->plugin->common()->get_app_route_url('design-cloud'),
        'group' => 'manage'
      );
    }

    return $items;
  }

  public function render_home_page() {

    if ( ! has_action( '_cornerstone_home_not_validated' ) ) {
      add_action( '_cornerstone_home_not_validated', array( $this, 'render_not_validated' ) );
    }

    do_action( '_cornerstone_home_before' );

    $is_validated             = $this->plugin->common()->is_validated();
    $status_icon_dynamic      = ( $is_validated ) ? '<div class="tco-box-status tco-box-status-validated">' . cs_tco()->get_admin_icon( 'unlocked' ) . '</div>' : '<div class="tco-box-status tco-box-status-unvalidated">' . cs_tco()->get_admin_icon( 'locked' ) . '</div>';

    include( $this->locate_view( 'admin/home' ) );

    do_action( '_cornerstone_home_after' );

  }

  public function render_not_validated() {
    $this->view( 'admin/home-validation' );
  }

  /**
   * Callback to render the settings page.
   */
  public function render_settings_page() {

    $this->settings_handler = $this->plugin->component( 'Settings_Handler' );
    $this->settings_handler->setup_controls();
    include( $this->plugin->locate_view( 'admin/settings' ) );

  }

  public function render_status_page() {

    $this->status = $this->plugin->component( 'Status' );
    $this->status->setup();
    $this->status->render_page();

  }

  /**
   * Add "Edit With Cornerstone" links to the WP List tables
   * Filter applied to page_row_actions and post_row_actions
   * @param array $actions
   * @param object $post
   */
  public function addRowActions( $actions, $post ) {

    $skip = array();
    $skip[] = (int) get_option( 'page_for_posts' );

    if ( function_exists('wc_get_page_id') ) {
      $skip[] = (int) wc_get_page_id( 'shop' );
    }

    if ( ! in_array( (int) $post->ID, $skip, true ) && $this->plugin->component('App_Permissions')->user_can_access_post_type( $post ) ) {
      // $url = $this->plugin->common()->get_edit_url( $post );
      $url = preg_replace('/\?lang=.*\/\#/' , '#', $this->plugin->common()->get_edit_url( $post ));
      $label = csi18n('admin.edit-with-cornerstone');
      $actions['edit_cornerstone'] = "<a href=\"$url\">$label</a>";
    }

    return $actions;
  }


  public function populate_admin_toolbar() {

    if ( ! is_user_logged_in() ) {
      return;
    }

    $permissions = $this->plugin->component('App_Permissions');

    $items = array();

    /**
     * Add "Edit with Cornerstone" button on the toolbar
     * This is only added on singlular views, and if the post type is supported
     */

    if ( is_singular() ) {

      $post = $this->plugin->common()->locate_post();

      if ( $post && $permissions->user_can_access_post_type( $post->post_type ) && $this->plugin->common()->uses_cornerstone( $post ) ) {

        $post_type_obj = get_post_type_object( $post->post_type );

        $items['tco-edit-link'] = array(
          'title' => sprintf( csi18n('common.toolbar-edit-link'), $post_type_obj->labels->singular_name ),
          'url' => preg_replace('/\?lang=.*\/\#/' , '#', $this->plugin->common()->get_edit_url( $post )),
          'group' => 'contextual'
        );

      }
    }

    $assignments = CS()->component('Assignments');

    $header = $assignments->get_last_active_header();
    $footer = $assignments->get_last_active_footer();
    $layout = $assignments->get_last_active_layout();

    if ( ! is_null( $header ) && $permissions->user_can('headers') ) {
      $items['tco-edit-header-link'] = array(
        'title' => sprintf( csi18n('common.toolbar-edit-link'), __('Header', '__x__') ),
        'url' => $this->plugin->common()->get_app_route_url( 'headers', $header->get_id(), 'header' ),
        'group' => 'contextual'
      );
    }

    if ( ! is_null( $footer ) && $permissions->user_can('footers')) {
      $items['tco-edit-footer-link'] = array(
        'title' => sprintf( csi18n('common.toolbar-edit-link'), __('Footer', '__x__') ),
        'url' => $this->plugin->common()->get_app_route_url( 'footers', $footer->get_id(), 'footer' ),
        'group' => 'contextual'
      );
    }

    if ( ! is_null( $layout ) && $permissions->user_can('layouts')) {
      $items['tco-edit-layout-link'] = array(
        'title' => sprintf( csi18n('common.toolbar-edit-link'), __('Layout', '__x__') ),
        'url' => $this->plugin->common()->get_app_route_url( 'layouts', $layout->get_id(), 'layout' ),
        'group' => 'contextual'
      );
    }

    $this->front_end_toolbar_items = $items;

  }

  public function addToolbarLinks() {

    global $wp_admin_bar;

    $permitted_items = array();

    $custom_items = $this->get_custom_menu_items();
    $items = array_merge($this->front_end_toolbar_items, $custom_items);

    $previous = null;

    foreach ($items as $key => $value) {

      if ( isset( $value['capability'] ) && ! current_user_can( $value['capability'] ) ) {
        continue;
      }

      $item = array(
        'id'     => $key,
        'parent' => 'tco-main',
        'title'  => $value['title'],
        'href'   => $value['url'],
      );

      if ( ! is_null( $previous ) && $items[$previous]['group'] !== $value['group'] ) {
        if ( ! isset( $permitted_items[$prev_index]['meta'] ) ) {
          $permitted_items[$prev_index]['meta'] = array();
        }
        if ( ! isset( $permitted_items[$prev_index]['meta']['class'] ) ) {
          $permitted_items[$prev_index]['meta']['class'] = '';
        }
        $permitted_items[$prev_index]['meta']['class'] .= 'tco-ab-item-divider';
      }

      $previous = $key;

      $permitted_items[] = $item;
      $prev_index = count($permitted_items) - 1;

    }

    $logo = apply_filters( '_cornerstone_toolbar_menu_logo', '' );
    $logo = $logo ? "<span class=\"tco-admin-bar-logo\">$logo</span>" : '';
    $title = apply_filters('_cornerstone_toolbar_menu_title', csi18n('common.toolbar-title') );

    $wp_admin_bar->add_menu( array(
      'id'    => 'tco-main',
      'title' => $logo . $title,
      'href'  => $this->plugin->common()->get_app_route_url('launch')
    ) );

    if ( ! empty( $permitted_items ) ) {
      foreach ($permitted_items as $permitted_item) {
        $wp_admin_bar->add_menu( $permitted_item );
      }
    }

  }



  /**
   * Load View files
   */

  public function notices() {

    $show_cornerstone_validation_notice = ( false === get_option( 'cornerstone_dismiss_validation_notice', false ) && ! $this->plugin->common()->is_validated() && ! in_array( get_current_screen()->parent_base, apply_filters( 'cornerstone_validation_notice_blocked_screens', array( 'cornerstone-home' ) ) ) );

    if ( $show_cornerstone_validation_notice && ! apply_filters( '_cornerstone_integration_remove_global_validation_notice', false ) && ! defined( 'X_VERSION') ) {

      cs_tco()->admin_notice( array(
        'message' => sprintf( csi18n('admin.validation-global-notice'), admin_url( 'admin.php?page=cornerstone-home' ) ),
        'dismissible' => true,
        'ajax_dismiss' => 'cs_dismiss_validation_notice'
      ) );

    }

  }

  public function make_menu_icon() {
    return 'data:image/svg+xml;utf8,' . str_replace('"', "'", $this->view( 'svg/logo-dashboard-icon', false ) );
  }

  //
  // Style admin menu items (Dashboard only)
  //

  public function get_admin_menu_css() {
    ob_start();
    ?>
      #adminmenu li.toplevel_page_cornerstone-home .wp-menu-image img {
        width: 22px;
        height: auto;
        padding: 10px 0 0 0;
        opacity: 1;
      }
    <?php

    return ob_get_clean();
  }

  //
  // Style admin bar items (Dashboard / Front End + Logged In)
  //

  public function admin_bar_css() {

    ob_start();
    ?>

      .tco-ab-item-divider:not(:last-child) {
        margin-bottom: 5px !important;
        border-bottom: 1px solid rgba(0,0,0,0.1);
        padding-bottom: 5px !important;
        box-shadow: 0 1px 0 rgba(255,255,255,0.05)
      }
      #adminmenu li.menu-top > .wp-submenu > li.tco-menu-divider:not(:last-child) {
        position: relative;
        margin-bottom: 5px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        padding-bottom: 6px;
        box-shadow: 0 1px 0 rgba(255, 255, 255, 0.05);
      }
      #wpadminbar .tco-admin-bar-logo svg {
        width: 19px;
        height: 19px;
        transform: translateY(4px);
      }

    <?php

    wp_add_inline_style( 'admin-bar', ob_get_clean() );

  }



  public function admin_print_scripts() { ?>

    <script>
    jQuery(function($){

      // Add menu dividers
      $('[data-tco-admin-menu-divider]').closest('li').addClass('tco-menu-divider');

      // Fix WordPress "Theme Options" button
      var themeOptionsUrl = '<?php echo $this->plugin->common()->get_app_route_url('theme-options'); ?>';

      $('body').on('click', '.button[href="themes.php?page=' + themeOptionsUrl + '"]', function( e ) {
        e.preventDefault();
        window.location.href = themeOptionsUrl;
      });

    });
    </script>

  <?php

  }

  public function settings_page_enqueue( $data, $hook ) {

    if ( false !== strpos( $hook, csi18n('admin.dashboard-settings-path') ) ) {
      $data['settings'] = array(
        'react'     => true,
        'ajax_url'  => admin_url( 'admin-ajax.php' ),
        'i18n'      => $this->i18n_group('admin', false, 'status'),
        '_cs_nonce' => wp_create_nonce( 'cornerstone_nonce' ),
      );
    }

    return $data;
  }

}
