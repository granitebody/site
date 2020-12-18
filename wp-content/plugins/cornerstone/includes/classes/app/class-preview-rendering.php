<?php

class Cornerstone_Preview_Rendering extends Cornerstone_Plugin_Component {

  protected $elements = [];
  protected $portals = [];
  protected $inline_styling_handles = [];
  protected $is_element_preview = false;
  protected $the_content_stack = [];

  public function render( $data ) {

    if ( ! isset( $data['elements'] ) ) {
      throw new Exception('render elements not specified');
    }

    if ( ! isset( $data['config'] ) || ! isset( $data['config']['regions'] ) ) {
      throw new Exception('invalid config not specified');
    }

    if (is_singular() && have_posts()) {
      the_post();
    }

    if (isset( $data['config']['type']) && strpos($data['config']['type'], 'layout-archive') === 0 ){
      do_action('cs_preview_archive_setup');
    }


    $enqueue_extractor = $this->plugin->component( 'Enqueue_Extractor' );
    $enqueue_extractor->start();

    $this->element_manager = $this->plugin->component( 'Element_Manager' );
    $this->resume_preview();

    add_action( 'cs_preview_the_content_begin', array( $this, 'pause_preview' ) );
    add_action( 'cs_preview_the_content_end',   array( $this, 'resume_preview' ) );

    add_action( 'cs_styling_add_styles', array( $this, 'track_inline_styling_handles' ) );

    add_filter('cs_is_element_preview', [ $this, 'is_element_preview'] );
    add_filter('cs_render_repeat', [$this, 'render_repeat']);

    add_filter( 'cs_defer_view', [ $this, 'capture_views'], 99999, 2);
    do_action( 'cs_element_rendering' );

    $flags = array_merge(
      [
        'elementConditions'  => 'allow',
        'forceScrollEffects' => 'none'
      ],
      isset( $data['flags'] ) ? $data['flags'] : []
    );

    if ( $flags['elementConditions'] === 'ignore' ) {
      add_filter( 'cs_preview_disable_element_conditions', '__return_true' );
    }

    if ( $flags['forceScrollEffects'] !== 'none' ) {
      add_filter( 'cs_preview_force_scroll_effects', function($force = '') use ($flags) {
        return $flags['forceScrollEffects'];
      } );
    }

    $this->render_element( $data['elements'] );

    $enqueue_extractor->extract();

    return array_merge(
      $this->finalize_elements( $flags ),
      [
        'scripts'  => $enqueue_extractor->get_scripts(),
        'styles'   => $enqueue_extractor->get_styles()
      ]
    );
  }

  public function finalize_elements( $flags ) {

    $elements = [];
    $markup = [];

    foreach ($this->elements as $id => $element) {

      $hidden = false;

      list( $type, $content, $inline_css ) = $element;

      if ( isset($this->portals[$id]) ) {
        $content .= $this->portals[$id];
      }

      if ($content === '%%HIDDEN%%') {
        $content = '';
        $hidden = true;
      }

      $hash = md5($type . $content . json_encode( $flags ));
      $elements[$id] = [$type, $hash, $inline_css, $hidden];
      $markup[$hash] = $content;

    }

    return [
      'elements' => $elements,
      'markup' => $markup
    ];
  }

  public function prepare_element( $data, $definition ) {

    $attr_keys = array_merge(
      $definition->get_designated_keys( 'attr' ),
      $definition->get_designated_keys( 'attr:html' )
    );

    foreach ($attr_keys as $key) {
      $data[$key] = "{%%{data.$key}%%}";
    }

    $data['_id'] = '{%%{_id}%%}';

    return $data;

  }

  public function render_element( $data, $parent = null ) {

    $definition = $this->element_manager->get_element( $data['_type'] );

    if ( in_array( $data['_type'], ['region', 'root'] ) ) {
      if (isset($data['_modules'])) {
        foreach( $data['_modules'] as $element ) {
          $this->render_element( $element, $data );
        }
      }
      return;
    }

    $response = '';
    $this->inline_styling_handles = [];
    $this->target = $data['_id'];

    $should_render_children = $definition->render_children();

    if ( $should_render_children ) {
      $this->teardown_preview_containers();
    }

    $response = $definition->render( x_element_decorate( $this->prepare_element( $data, $definition ), $parent ) );

    $this->elements[$data['_id']] = [$data['_type'], $response, $this->get_inline_css()];

    if ( $should_render_children ) {
      $this->setup_preview_containers();
    }

  }

  public function get_inline_css() {

    $inline_css = '';
    $styling = $this->plugin->component('Styling');

    add_filter('cs_css_post_processing', '__return_false');

    foreach ($this->inline_styling_handles as $handle) {
      $inline_css .= $styling->get_generated_styles_by_handle( $handle ) . ' ';
    }

    remove_filter('cs_css_post_processing', '__return_false');

    return $inline_css;

  }

  public function is_element_preview() {
    return $this->is_element_preview;
  }

  public function pause_preview() {
    if ( empty( $this->the_content_stack ) ) {
      remove_filter( 'cs_is_preview', '__return_true' );
      $this->teardown_preview_containers();
    }
    array_push($this->the_content_stack, true);
  }

  public function resume_preview() {
    array_pop($this->the_content_stack);
    if ( empty( $this->the_content_stack ) ) {
      add_filter( 'cs_is_preview', '__return_true' );
      $this->setup_preview_containers();
    }
  }

  public function setup_preview_containers() {
    if (!$this->is_element_preview) {
      $this->is_element_preview = true;
      add_filter( 'x_breadcrumbs_data', 'x_bars_sample_breadcrumbs', 10, 2 );
      $this->element_manager->teardown_children_rendering( 'x_render_elements' );
      $this->element_manager->setup_children_rendering( [ $this, 'preview_container_output' ] );
    }
  }

  public function teardown_preview_containers() {
    if ($this->is_element_preview) {
      $this->is_element_preview = false;
      remove_filter( 'x_breadcrumbs_data', 'x_bars_sample_breadcrumbs', 10, 2 );
      $this->element_manager->teardown_children_rendering( [ $this, 'preview_container_output' ] );
      $this->element_manager->setup_children_rendering( 'x_render_elements' );
    }
  }

  public function preview_container_output( $children, $parent ) {
    echo '{%%{children}%%}';

    $in_link = cs_setup_in_link( $parent );

    foreach( $children as $element ) {
      $this->render_element( $element, $parent );
    }

    $this->target = $parent['_id'];

    cs_teardown_in_link( $in_link );
  }


  public function track_inline_styling_handles( $handle ) {
    $this->inline_styling_handles[] = $handle;
  }

  public function render_repeat( $data ) {
    if (!isset($data['class'])) $data['class'] = '';
    $data['class'] .= ' tco-element-preview-repeat';
    return $data;
  }

  public function capture_portal( $content, $action ) {

    if (!isset($this->portals[$this->target])) {
      $this->portals[$this->target] = '';
    }

    $this->portals[$this->target] .= "<div tco-html-portal=\"$action\">$content</div>";

  }

  public function capture_views($content, $action) {
    $this->capture_portal( $content, $action);
    return $content;
  }
}
