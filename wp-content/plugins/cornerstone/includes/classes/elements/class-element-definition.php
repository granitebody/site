<?php

class Cornerstone_Element_Definition {

  protected $type;
  public $def = array();
  protected $style = null;
  protected $ready_for_builder = false;
  protected $sanitize_html_safe_keys;
  protected $escape_html_safe_keys;

  public function __construct( $type, $definition ) {
    $this->type = $type;
    $this->update( $definition );
  }

  public function update( $update ) {

    $defaults = array(

      'title'               => '',
      'values'              => array(),
      'style'               => null, // callback to define style template
      'builder'             => null, // callback to populate builder data (not called on front end)
      'children'            => null, // can be a hook used to manage children (e.g. x_section)
      'tag_key'             => '',

      'options'             => array(),

      'controls_std'        => array(),
      'controls'            => array(),
      'control_nav'         => array(),

      'icon'                => null,
      'active'              => true,
      'group'               => null,
      'render'              => null,
      'preprocess_css_data' => null,

      '_upgrade_data' => array()
    );

    $controls_std = array();
    if ( isset( $update['controls_std_content'] ) ) {
      $controls_std = array_merge( $controls_std, $update['controls_std_content'] );
    }

    if ( isset( $update['controls_std_design_setup'] ) ) {
      $controls_std = array_merge( $controls_std, $update['controls_std_design_setup'] );
    }

    if ( isset( $update['controls_std_design_colors'] ) ) {
      $controls_std = array_merge( $controls_std, $update['controls_std_design_colors'] );
    }

    if ( isset( $update['controls_std_customize'] ) ) {
      $controls_std = array_merge( $controls_std, $update['controls_std_customize'] );
    }

    if ( count( $controls_std ) > 0 ) {
      $update['controls_std'] = $controls_std;
    }

    if ( isset( $update['options'] ) ) {
      $current_options = isset( $this->def['options'] ) ? $this->def['options'] : array();
      $update['options'] = array_merge( $current_options, $update['options'] );
    }

    $this->def = array_merge( $defaults, $this->def, array_intersect_key( $update, $defaults ) );

    if ( $this->is_child() ) {
      $this->def['options']['private'] = true;
    }

  }

  public function get_defaults() {
    $defaults = array();

    foreach ($this->def['values'] as $key => $value) {
      $defaults[$key] = $value['default'];
    }

    return $defaults;
  }

  public function get_protected_keys() {
    $protected = array();

    foreach ($this->def['values'] as $key => $value) {
      if ( isset( $value['protected'] ) && $value['protected'] ) {
        $protected[] = $key;
      }
    }

    return $protected;
  }

  public function apply_defaults( $data ) {

    $defaults = $this->get_defaults();
    $designations = $this->get_designations();

    foreach ($defaults as $key => $value) {
      if ( ! isset( $data[$key] ) || (isset( $designations[$key] ) && 'all:readonly' === $designations[$key] ) ) {
        $data[$key] = $value;
      }
    }

    return $data;

  }

  public function get_designations() {
    $designations = array();

    foreach ($this->def['values'] as $key => $value) {
      $designations[$key] = $value['designation'];
    }

    return $designations;
  }

  public function get_designated_keys() {

    $args = func_get_args();

    $designations = $this->get_designations();

    $keys = array();

    foreach ($args as $group) {

      $top_level = false === strpos( $group, ':' );
      $wild      = 0 === strpos( $group, '*' );

      foreach ($designations as $key => $value) {

        $check = $value;
        $parts = explode(':', $value);
        $primary = array_shift($parts);

        if ( $top_level ) {
          $check = $primary;
        }

        if ( $wild ) {
          $check = str_replace($primary,'*', $check);
        }

        if ( $check === $group ) {
          $keys[] = $key;
        }

      }
    }

    return array_unique( $keys );
  }

  public function get_style_template() {

    if ( is_null( $this->style ) ) {

      if ( ! isset( $this->def['style'] ) ) {
        return '';
      }

      $this->style = trim( is_callable( $this->def['style'] ) ? call_user_func( $this->def['style'], $this->type ) : $this->def['style'] );

    }

    return $this->style;
  }


  public function get_compiled_style() {

    if ( ! apply_filters('cs_compile_element_style_templates', true ) ) {
      return '[]';
    }

    $template = CS()->component( 'Coalescence' )->create_template( $this->get_style_template() );
    return $template->serialize();

  }

  // Redundant. Could be removed if all style template processing was done client side in the builder.
  public function preprocess_style( $data ) {

    $data = $this->apply_defaults($data);

    $unique_id = $data['_id'];

    if ( isset( $data['_p'] ) ) {
      $unique_id = $data['_p'] . '-' . $unique_id;
    }

    $data['_el'] = 'e' . $unique_id;

    if ( is_callable( $this->def['preprocess_css_data'] ) ) {
      $data = call_user_func( $this->def['preprocess_css_data'], $data );
    }

    $style_keys = $this->get_designations();

    $post_process_keys = array();
    foreach ($style_keys as $data_key => $style_key) {

      if ( 'all:readonly' === $style_key ) {
        continue;
      }

      $pos = strpos($style_key, ':' );

      if ( false === $pos ) {
        continue;
      }

      $post_process_keys[$data_key] = substr($style_key, $pos + 1);

    }

    if ( ! empty( $post_process_keys ) ) {
      foreach ($data as $key => $value) {
        if ( isset($post_process_keys[$key]) && $value && is_scalar($value) ) {
          $data[$key] = '%%post ' . $post_process_keys[$key] . '%%' . $value .'%%/post%%';
        }
      }
    }

    return $data;

  }

  public function get_title() {
    return $this->def['title'];
  }

  public function is_child() {
    return ( isset( $this->def['options']['child'] ) && $this->def['options']['child'] );
  }

  public function is_classic() {
    return 0 === strpos($this->type, 'classic:');
  }

  public function in_library() {
    $is_classic_child = ( isset( $this->def['options']['classic'] ) && isset( $this->def['options']['classic']['child'] ) && $this->def['options']['classic']['child'] );
    return ( !isset( $this->def['options']['library'] ) || false !== $this->def['options']['library'] ) && ! $is_classic_child && 'classic:undefined' !== $this->type;
  }

  public function render_children() {
    return ( isset( $this->def['options']['render_children'] ) && $this->def['options']['render_children'] );
  }

  public function get_type() {
    return $this->type;
  }

  public function get_children_hook() {
    return $this->def['children'];
  }

  public function serialize() {

    $this->update_for_builder();

    $data = array(
      'id'           => $this->type,
      'title'        => $this->def['title'],
      'options'      => $this->def['options'],
      'values'       => $this->def['values'],
      'style'        => $this->get_style_template(),
      'controls-std' => $this->def['controls_std'],
      'controls'     => $this->def['controls'],
      'control-nav'  => $this->def['control_nav'],
      'active'       => $this->def['active'],
      'group'        => $this->def['group']
    );

    if ( is_string( $this->def['icon'] ) ) {
      $data['icon'] = $this->def['icon'];
    }

    return $data;
  }

  public function update_for_builder() {

    if ( $this->ready_for_builder || ! is_callable( $this->def['builder'] ) ) {
      return;
    }

    CS()->component('Element_Manager')->load_builder_files();
    $this->update( call_user_func( $this->def['builder'], $this->type ) );
    $this->ready_for_builder = true;

  }

  public function condition_check() {
    return true;
  }

  public function sanitize( $data ) {

    $sanitized = array();
    if ( ! isset( $this->sanitize_html_safe_keys ) ) {
      $this->sanitize_html_safe_keys = $this->get_designated_keys('*:html', '*:raw' );
    }

    $internal_keys = array( '_id', '_p', '_type', '_region', '_label', '_modules' );

    foreach ( $data as $key => $value ) {

      // Pass through internal data
      if ( in_array($key, $internal_keys, true ) ) {
        $sanitized[ $key ] = $value;
        continue;
      }

      // Strip undesignated values
      if ( ! isset( $this->def['values'][$key] ) ) {
        continue;
      }

      $sanitized[ $key ] = $value;

      //$sanitized[ $key ] = CS()->common()->sanitize_value( $value, in_array($key, $this->sanitize_html_safe_keys, true ) );

    }

    return $sanitized;
  }

  public function escape( $data ) {

    $escaped = array();
    $designated_keys = array_keys( $this->def['values'] );

    if ( ! isset( $this->escape_html_safe_keys ) ) {
      $this->escape_html_safe_keys = $this->get_designated_keys('*:html', '*:raw');
    }

    $html_safe_keys = $this->escape_html_safe_keys;

    $internal_keys = array( '_id', '_p', '_type', '_region', '_label', '_modules', 'p_style_id', 'p_unique_id' );

    foreach ( $data as $key => $value ) {

      // Pass through internal data
      if ( in_array($key, $internal_keys, true ) ) {
        $escaped[ $key ] = $value;
        continue;
      }

      // Strip undesignated values
      if ( ! in_array($key, $designated_keys, true ) ) {
        continue;
      }

      $escaped[ $key ] = CS()->common()->escape_value( $value, in_array($key, $html_safe_keys, true ) );

    }

    return $escaped;
  }

  public function save( $data, $content, $atts = array(), $depth = 0 ) {

    $type = str_replace('-', '_', $data['_type'] );
    $tag = "cs_element_$type";

    // WordPress does not support nesting shortcodes of the same type
    // We append a number to indicate an element's depth and handle each shortcode separately
    if ( $depth > 1 && in_array( $data['_type'], apply_filters( 'cs_nested_element_types', array( 'row', 'column', 'layout-row', 'layout-column', 'layout-grid', 'layout-cell', 'layout-div' ) ), true ) ) {
      $tag .= "_$depth";
    }

    $atts = array_merge( $atts, array( '_id' => $data['_id'] ) );
    $atts = cs_atts( $atts );
    $shortcode = "[$tag $atts]";

    if ( ! $content && isset( $this->def['options']['fallback_content'] ) ) {
      $content = $this->def['options']['fallback_content'];
    }

    if ( $content || $this->type_is_layout( $type ) ) {
      $shortcode .= $content . "[/$tag]";
    }

    $shortcode = apply_filters("cs_save_element_output_$type", $shortcode, $data, $content );

    $shortcode .= $this->generate_seo_data( $data );

    return apply_filters('cs_save_element_output', $shortcode, $data, $content );
  }

  public function generate_seo_data( $data ) {

    $buffer = '';

    $keys = $this->get_designated_keys('*:html' );

    foreach( $keys as $key ) {
      if ( isset( $data[$key] ) && $data[$key] && is_string($data[$key]) ) {
        $buffer .= $data[$key] . '\\n\\n';
      }
    }

    return $this->format_seo_shortcode( $buffer );
  }

  protected function format_seo_shortcode( $content ) {

    $images = array();

    if ( strpos($content, 'img' ) !== false ) {
        preg_match_all('/<img .*>/U', $content, $images);
    }

    //Optional change, but should clean all the spaces
    $result = count( $images ) > 0 ?  trim( strip_tags($content) ).implode('', $images[0]) : trim ( strip_tags( $content ) );

    return $result ? '[cs_content_seo]'.$result.'[/cs_content_seo]' : $result;
  }

  public function render( $data ) {

    $looper = CS()->component('Looper_Manager');

    $in_preview = apply_filters( 'cs_is_element_preview', false );


    if ( $this->should_hide( $data ) ) {
      return $in_preview ? '%%HIDDEN%%' : '';
    }

    $loop = $looper->maybe_start_element( $data );

    if ( $loop === 'consumer' ) {

      $buffer = '';

      $did_iterate = $looper->iterate();

      $currently_is_initial = apply_filters( 'cs_render_looper_is_virtual', false );


      if ( $did_iterate || $in_preview ) { // always render at least one in the preview
        $buffer .= $this->render_one( $data );
      }

      if ( ! $currently_is_initial ) {
        add_filter( 'cs_render_looper_is_virtual', '__return_true' );
      }

      if ($did_iterate) {

        do_action('cs_preview_the_content_begin');

        $repeat_data = apply_filters( 'cs_render_repeat', $data );

        while($looper->iterate()) {
          $buffer .= $this->render_one( $repeat_data );
        }

        do_action('cs_preview_the_content_end');

      }

      if ( ! $currently_is_initial ) {
        remove_filter( 'cs_render_looper_is_virtual', '__return_true' );
      }

      $looper->end_element();
      return $buffer;

    }

    $buffer = $this->render_one( $data );

    if ($loop === 'provider') {
      $looper->end_element();
    }

    return $buffer;

  }

  public function render_one( $data ) {

    ob_start();

    if ( is_callable( $this->def['render'] ) ) {
      $data = apply_filters('cs_render_element_data', $data );
      echo apply_filters('cs_render_element', apply_filters('cs_dynamic_content', call_user_func( $this->def['render'], $data ) ), $data );
    }

    return ob_get_clean();

  }

  public function should_hide( $data ) {

    // Classic Columns
    if ( isset( $data['_active'] ) && $data['_active'] === false) {
      return true;
    }

    if ( ! isset($data['show_condition']) || ! $data['show_condition'] ) {
      return false;
    }

    // Disable element conditions in the preview
    if ( apply_filters( 'cs_preview_disable_element_conditions', false ) ) {
      return false;
    }

    return ! CS()->component('Condition_Matcher')->match_rule_set( $data['show_condition'] );
  }

  public function type_is_layout( $type ) {
    return in_array(
      str_replace( 'classic:', '', $type ),
      array( 'bar', 'container', 'section', 'row', 'column', 'layout-row', 'layout-column', 'layout-grid', 'layout-cell' )
    );
  }

  public function will_render_link( $atts ) {
    return $this->def['tag_key'] && isset( $atts[$this->def['tag_key']] ) && $atts[$this->def['tag_key']] === 'a';
  }

}
