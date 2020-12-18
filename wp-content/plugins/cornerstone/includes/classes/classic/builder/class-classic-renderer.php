<?php
class Cornerstone_Classic_Renderer extends Cornerstone_Plugin_Component {

	public $dependencies = array( 'Front_End' );
  protected $ready = false;

  public function before_render() {

    if ( $this->ready ) {
      return;
    }

    $this->ready = true;

		Cornerstone_Shortcode_Preserver::init();
		Cornerstone_Shortcode_Preserver::sandbox( 'cs_render_the_content' );

		add_filter('cs_preserve_shortcodes_no_wrap', '__return_true' );

    $this->orchestrator = $this->plugin->component( 'Element_Orchestrator' );
		$this->orchestrator->load_elements();

  }


	public function render_classic_element( $element, $content = '' ) {

    $this->before_render();

    $is_preview = apply_filters( 'cs_is_preview', false );
		$definition = $this->orchestrator->get( $element['_type'] );
    $flags = $definition->flags();

    if ( $definition->is_active() ) {
      $markup = $definition->preview(
        $element,
        $this->orchestrator,
        ( isset( $element['_parent_data'] ) ) ? $element['_parent_data'] : null,
        [],
        $content
      );
    } else {
      if ( $is_preview ) {
        $message = ( $flags['undefined_message']) ? $flags['undefined_message'] : csi18n('app.elements-undefined-preview');
        $markup = "<div class=\"tco-empty-element cs-undefined-element\"><p class=\"tco-empty-element-message\">$message</p></div>";
      } else {
        $markup = '';
      }
    }


    if ( ! $is_preview ) {
      return $markup;
    }

		$markup = apply_filters( 'cs_render_the_content', cs_noemptyp($markup) );


		if ( ! is_string( $markup ) ) {
      $markup = '';
    }

    if ( ! $is_preview ) {
      return $markup;
    }

    if ( ( ! isset( $flags['safe_container']) || ! $flags['safe_container'] ) &&
         ( ! isset( $flags['dynamic_child'])  || ! $flags['dynamic_child'] ) &&
         ( ! isset( $flags['attr_keys'] )     || empty( $flags['attr_keys'] ) ) ) {
      $markup = '{%%{base64content ' . base64_encode( $markup ) . ' }%%}';
    }

    if (
      ( isset( $flags['safe_container'] ) && $flags['safe_container'] )
      || (isset( $flags['context'] ) && $flags['context'] === '_layout' )
      ) {
      return $markup;
    }

    $tag = 'div';

    if ( isset( $flags['wrapping_tag'] ) && $flags['wrapping_tag'] ) {
      $tag = $flags['wrapping_tag'];
    }

    return "<$tag class=\"tco-element-preview-classic\">$markup</$tag>";

	}

}
