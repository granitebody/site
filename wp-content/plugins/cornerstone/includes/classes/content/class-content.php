<?php

class Cornerstone_Content {

  protected $id = null;
  protected $title;
  protected $post_type = 'post';
  protected $post_status = 'post';
  protected $post_name = '';
  protected $permalink = '';
  protected $data = array();
  protected $depths = array();

  public function __construct( $post ) {

    if ( is_array( $post ) ) {
      if ( isset( $post['id'] ) ) {
        $post = $post['id'];
      } else {
        $this->create_new( $post );
      }
    } else {
      $this->load_from_post( $post );
    }

  }

  protected function create_new( $data ) {


    $this->set_title( isset( $data['title'] ) ? $data['title'] : '' );
    $this->set_post_type( isset( $data['post_type'] ) ? $data['post_type'] : 'page' );
    $this->set_post_status( isset( $data['post_status'] ) ? $data['post_status'] : 'draft' );
    $this->set_post_name( isset( $data['post_name'] ) ? $data['post_name'] : '' );


    $this->set_elements( isset( $data['elements'] ) ? $data['elements'] : array( 'data' => '') );
    $this->set_settings( isset( $data['settings'] ) ? $data['settings'] : array() );


  }

  protected function load_from_post( $post ) {

    if ( is_int( $post ) ) {
      $post = get_post( $post );
    }

    $this->post = $post;

    if ( ! is_a( $post, 'WP_POST' ) ) {
      throw new Exception( 'Unable to load content from post.' );
    }

    $this->id = $post->ID;
    $this->set_title( $post->post_title ? $post->post_title : '' );
    $this->post_type = $post->post_type;
    $this->post_status = $post->post_status;

    $wpml = CS()->component('Wpml');

    if ( $wpml->is_active() ) {

      $wpml->before_get_permalink();
      $this->permalink = apply_filters( 'wpml_permalink', get_permalink( $post ), apply_filters('cs_locate_wpml_language', null, $post ) );
      $wpml->after_get_permalink();

    } else { /* prevent conflict with Polylang's wpml_permalink filter */

      $this->permalink = get_permalink( $post );

    }

    $elements = cs_get_serialized_post_meta( $this->id, '_cornerstone_data', true, 'cs_content_load_serialized_content' );

    if ( ! is_array( $elements ) ) {
      $elements = array( 'data' => '' );
    }

    $this->set_elements( $elements );
    $this->set_settings( $this->load_settings_from_post( $post ) );

  }

  protected function normalize_elements( $elements ) {

    if ( ! isset( $elements['data'] ) ) {

      $migrations = CS()->component('Element_Migrations');
      $elements = array(
        'data' => $migrations->migrate_classic( $elements )
      );

    }

    return $elements;
  }

  protected function normalize_settings( $settings ) {
    return array_merge( $this->get_settings(), $settings );
  }

  protected function generate_additional_content( $settings ) {

    $content = '';

    if (isset($settings['responsive_text']) && count($settings['responsive_text']) > 0) {
      foreach ($settings['responsive_text'] as $element ) {
        $content .= cs_build_shortcode('cs_responsive_text', $element );
      }
    }

    return $content;

  }


  public function save() {

    $post_type_object = get_post_type_object( $this->post_type );
    $caps = (array) $post_type_object->cap;

    $authorized = is_null( $this->id ) ? current_user_can( $caps['create_posts'] ) : current_user_can( $caps['edit_post'], $this->id );

    if ( ! $authorized ) {
      throw new Exception( 'Unauthorized' );
    }

    $settings = $this->get_settings();
    $elements = $this->get_elements();

    $update = array(
      'post_title' => $this->title,
      'post_type' => $this->post_type,
      'post_status' => $this->post_status
    );

    if ( $this->post_type !== 'cs_global_block' ) {
      if ( $this->post_name ) {
        $update['post_name'] = $this->post_name;
      }


      if (isset($settings['general_post_parent'])) {
        $update['post_parent'] = $settings['general_post_parent'];
      }

      if ( isset( $settings['general_allow_comments'] ) && post_type_supports( $this->post_type, 'comments' ) ) {
        $update['comment_status'] = ( true === $settings['general_allow_comments'] ) ? 'open' : 'closed';
      }

      if ( post_type_supports( $this->post_type, 'excerpt' ) && isset( $settings['general_manual_excerpt'] ) ) {
        $update['post_excerpt'] = $settings['general_manual_excerpt'];
      }

      if ($post_type_obj->hierarchical && isset($settings['general_post_parent'])) {
        $update['post_parent'] = (int) $settings['general_post_parent'];
      }

      if ( post_type_supports( $this->post_type, 'page-attributes' ) && isset($settings['general_page_template']) ) {
        $update['page_template'] = $settings['general_page_template'];
      }
    }

    $is_update = is_int( $this->id );

    if ( $is_update ) {
      $update['ID'] = $this->id;
    }

    $id = $is_update ? wp_update_post( $update ) : wp_insert_post( $update );

    if ( is_wp_error( $id ) ) {
      return $id;
    }

    if ( 0 === $id ) {
      return new WP_Error('cs-content', "Unable to save content: $id");
    }

    $this->id = $id;

    // Update meta with only custom CSS, custom JS, etc
    if (! current_user_can('unfiltered_html')) {
      unset($settings['custom_js']);
    }

    $previous_settings = $is_update ? cs_get_serialized_post_meta( $this->id, '_cornerstone_settings', true ) : [];
    if (is_null($previous_settings)) {
      $previous_settings = [];
    }
    $settings_update = cs_define_defaults( array_merge($previous_settings, $settings), $this->default_settings());

    cs_update_serialized_post_meta( $this->id, '_cornerstone_settings', $settings_update, '', false, 'cs_content_update_serialized_content' );

    $update_elements = $this->update_elements( $elements['data'], $settings_update );

    if ( is_wp_error( $update_elements ) ) {
      throw new Exception( 'Error saving content elements: ' . $update_elements->get_error_message() );
    }

    return $this->serialize();

  }

  public function get_id() {
    return $this->id;
  }

  public function get_post() {
    return get_post( $this->id );
  }

  public function get_title() {
    return $this->title;
  }

  public function get_elements() {
    if ( ! isset( $this->data['elements'] ) ) {
      $this->data['elements'] = array( 'data' => '' );
    }
    return $this->data['elements'];
  }

  public function get_settings() {
    if ( ! isset( $this->data['settings'] ) ) {
      $this->data['settings'] = array();
    }
    return array_merge( $this->get_default_settings(), $this->data['settings'] );
  }

  public function serialize() {
    if (!$this->post) {
      $this->post = get_post($id);
    }

    $post_type_obj = get_post_type_object( $this->post_type );
    return array(
      'id' => $this->id,
      'title' => $this->get_title(),
      'elements'  => $this->get_elements(),
      'settings' => $this->get_settings(),
      'builder' => array(
        'previewUrl' => $this->permalink,
        'permissionContext' => "content.{$this->post_type}",
        'libraryScope' => 'content',
        'modified' => date_i18n( get_option( 'date_format' ), strtotime( $this->post->post_modified ) ),
        'localContext' => $this->post_type,
        'localContextLabel' => isset( $post_type_obj->labels ) ? $post_type_obj->labels->singular_name : $this->post_type,
        'editUrl' => get_edit_post_link( $this->id, '' ),
        'language' => CS()->component('Wpml')->get_language_data_from_post( $this->post, true ),
        'settings' => $this->get_setting_controls(),
        'titleKey' => 'general_post_title',
        'settingKeys' => [
          'customCss' => 'custom_css',
          'customJs'  => 'custom_js',
          'responsiveText' => 'responsive_text',
        ],
      )
    );
  }

  public function set_title( $title ) {
    return $this->title = sanitize_text_field( $title, sprintf( csi18n('common.untitled-entity'), csi18n('common.content.entity') ) );
  }

  public function get_post_type() {
    return $this->post_type;
  }

  public function set_post_type( $post_type ) {
    $this->post_type = $post_type;
  }

  public function set_post_status( $post_status ) {
    $this->post_status = $post_status;
  }

  public function set_post_name( $post_name ) {
    $this->post_name = $post_name;
  }

  public function set_settings( $settings ) {
    $this->data['settings'] = $this->normalize_settings( $settings );

    if (isset($settings['general_post_title']) && (post_type_supports( $this->post_type, 'title' ) || $this->post_type === 'cs_global_block' ) ) {
      $this->set_title($settings['general_post_title']);
    }

    if ( $this->post_type === 'cs_global_block' ) {
      return;
    }

    if ( isset($settings['general_post_name'])) {
      $this->set_post_name($settings['general_post_name']);
    }

    $post_type_object = get_post_type_object( $this->post_type );

    if ( isset( $settings['general_post_status'] ) && current_user_can( $post_type_object->cap->publish_posts ) ) {
      $this->set_post_status( $settings['general_post_status'] );
    }
  }

  public function set_elements( $elements ) {
    $this->data['elements'] = $this->normalize_elements( $elements );
  }

  public function delete() {

    if ( ! current_user_can( CS()->common()->get_post_type_capability( $this->post_type, 'delete_posts' ), $this->id ) ) {
      throw new Exception( 'Unauthorized' );
    }

    do_action('cornerstone_delete_content', $this->id );

    if (!wp_delete_post( $this->id, true )) {
      throw new Exception( 'Failed to delete' );
    }

    return ['deleted' => $this->id];

  }


  public function update_elements( $elements, $settings ) {

    if ( ! is_array( $elements ) ) {
      return;
    }

    CS()->component( 'Element_Orchestrator' )->load_elements();

    $output = $this->build_output( $elements );

		if ( is_wp_error( $output ) ) {
			return $output;
		}

    do_action( 'cornerstone_before_save_content', $this->id );

		$old_version = get_post_meta( $this->id, '_cornerstone_version', true );
    update_post_meta( $this->id, '_cornerstone_version', CS()->version() );

		cs_update_serialized_post_meta( $this->id, '_cornerstone_data', $output['data'], '', false, 'cs_content_update_serialized_content' );
		delete_post_meta( $this->id, '_cornerstone_override' );
    delete_post_meta( $this->id, '_cs_generated_styles');

    $post_content = apply_filters( 'cornerstone_save_post_content', $output['content'] );

    $additional_content = $this->generate_additional_content( $settings );

		$id = wp_update_post( array(
			'ID'           => $this->id,
      'post_content' => wp_slash( '[cs_content]' . $post_content . '[/cs_content]' . $additional_content ),
    ) );

    if ( is_wp_error( $id ) ) {
      return $id;
    }

    if ( 0 === $id ) {
      return new WP_Error('cs-content', "Unable to save content: $id");
    }

    do_action( 'cornerstone_after_save_content', $this->id );

    return true;
  }

  public function build_output( $elements ) {

    // Generate shortcodes
    $buffer = '';
    $sanitized = array();

    $elements = CS()->component('Element_Front_End')->populate_element_region( $this->id, $elements, 'content');

    foreach ( $elements as $element ) {
      $output = $this->build_element_output( $element );
      if ( is_wp_error( $output ) ) {
        return $output;
      }
      $buffer .= $output['content'];
      $sanitized[] = $output['data'];
    }


    return array(
      'content' => $buffer,
      'data' => $sanitized
    );
  }

  public function build_element_output( $element, $parent = null ) {

    if ( ! isset( $element['_type'] ) ) {
      return new WP_Error( 'cs-content', 'Element _type not set: ' . maybe_serialize( $element ) );
    }

    if ( 0 === strpos( $element['_type'], 'classic:' ) ) {
      return $this->build_classic_element_output( $element, $parent );
    }

    //
    // Build V2 element
    //

    $definition = CS()->component( 'Element_Manager' )->get_element( $element['_type'] );

    $buffer = '';
    $atts = array();

    if ( isset( $element['_modules'] ) ) {
      $sanitized = array();
      $this->inc_depth( $element['_type'] );

      if ( $definition->render_children() ) {
        $children = array();
        foreach ( $element['_modules'] as $child ) {
          $children[] = $child['_id'];
          $sanitized[] = $child;
        }
        $atts['_modules'] = implode(',', $children);
      } else {

        foreach ( $element['_modules'] as $child ) {
          $output = $this->build_element_output( $child, $element );
          if ( is_wp_error( $output ) ) {
            return $output;
          }
          $buffer .= $output['content'];
          $sanitized[] = $output['data'];
        }
      }

      $this->dec_depth( $element['_type'] );

      $element['_modules'] = $sanitized;
    }

    $content = '';
    if ( ! isset( $element['_active'] ) || $element['_active'] ) {
      $content = $definition->save( $element, $buffer, $atts, $this->get_depth( $element['_type'] ) );
    }

    unset($element['_id']);
    unset($element['_region']);

    return array(
      'content' => $content,
      'data' => $element
    );

  }

  public function inc_depth( $type ) {
    if ( !isset( $this->depths[$type] ) ) {
      $this->depths[$type] = 1;
    }
    $this->depths[$type]++;
  }

  public function dec_depth( $type ) {
    if ( !isset( $this->depths[$type] ) ) {
      $this->depths[$type] = 1;
    }
    $this->depths[$type]--;
  }

  public function get_depth( $type ) {
    return isset( $this->depths[$type] ) ? $this->depths[$type] : 1;
  }

  public function build_classic_element_output( $element, $parent = null ) {

    $element['_type'] = str_replace('classic:', '', $element['_type'] );
    $definition = CS()->component( 'Element_Orchestrator' )->get( $element['_type'] );
    $element = $definition->sanitize( $element );

    if ( 'mk1' === $definition->version() ) {
      return CS()->component( 'Legacy_Renderer' )->save_element( $element );
    }

    $flags = $definition->flags();

    if ( ! isset( $flags['child'] ) || ! $flags['child'] ) {
      $parent = null;
    }

    $buffer = '';

    if ( isset( $element['_modules'] ) ) {
      $sanitized = array();
      foreach ( $element['_modules'] as $child ) {
        $output = $this->build_element_output( $child, $definition->compose( $element ) );
        if ( is_wp_error( $output ) ) {
          return $output;
        }
        $buffer .= $output['content'];
        $sanitized[] = $output['data'];
      }
      $element['_modules'] = $sanitized;
    }


    $content = '';
    if ( ! isset( $element['_active']) || $element['_active'] ) {
      if ( isset($element['_modules'] ) ) {
        $element['elements'] = $element['_modules'];
      }
      $content = $definition->build_shortcode( $element, $buffer, $parent );

      // <!--nextpage--> support for classic sections
      if ( 'section' === $element['_type'] ) {
        // Move all <!--nextpage--> directives to outside their section.
        $content = preg_replace( '#(?:<!--nextpage-->.*?)(\[\/cs_section\])#', '$0<!--nextpage-->', $content );

        //Strip all <!--nextpage--> directives still within sections
        $content = preg_replace( '#(?<!\[\/cs_section\])<!--nextpage-->#', '', $content );

        $content = str_replace( '<!--more-->', '', $content );
      }

      unset($element['elements']);
    }

    $element['_type'] = 'classic:' . $element['_type'];
    unset($element['_id']);
    unset($element['_region']);

    return array(
      'content' => $content,
      'data' => $element
    );

  }


  public function default_settings() {

    $defaults = array (
      'custom_css' => '',
      'custom_js' => ''
    );

    if ($this->post_type !== 'cs_global_block') {
      $defaults['responsive_text'] = array();
    }

    return $defaults;
  }

  public function get_default_settings() {
    return apply_filters('cs_content_default_settings', array_merge( $this->default_settings(), array(
      'general_post_title'     => $this->get_title(),
      'general_post_status'    => $this->post_status,
      'general_allow_comments' => false,
      'general_post_parent'    => '0',
      'general_page_template'  => 'default',
      'general_manual_excerpt' => '',
      'responsive_text' => [],
    ) ), $this->post_type );
  }

  public function load_settings_from_post($post) {

    $post_type_obj = get_post_type_object( $post->post_type );
    $settings = cs_get_serialized_post_meta( $post->ID, '_cornerstone_settings', true );

    $data = is_array( $settings ) ? $settings : array();

    if (post_type_supports( $post->post_type, 'title' ) || $this->post_type === 'cs_global_block' )  {
      $data['general_post_title'] = $post->post_title;
    }

    if ($this->post_type == 'cs_global_block') {
      return $data;
    }

    $data['general_post_name'] = $post->post_name;

    $data['general_post_status'] = $post->post_status;

    if (post_type_supports($post->post_type, 'comments')) {
      $data['general_allow_comments'] = $post->comment_status === 'open';
    }

    if (post_type_supports($post->post_type, 'excerpt')) {
      $data['general_manual_excerpt'] = $post->post_excerpt;
    }

    if ($post_type_obj->hierarchical) {
      $data['general_post_parent'] = $post->post_parent;
    }

    if (post_type_supports( $post->post_type, 'page-attributes' )) {
      $selected = get_post_meta($post->ID, '_wp_page_template', true);
      $data['general_page_template'] = $selected ? $selected : 'default';
    }

    return apply_filters('cs_content_load_settings', $data, $post );
  }

  public function get_setting_controls() {
    if (!isset($this->post)) {
      return array();
    }
    require_once( CS()->path('includes/settings/content-builder.php') );
    return cornerstone_content_builder_settings_controls($this->post);
  }
}
