<?php

// =============================================================================
// VIEWS/ELEMENTS/TABS.PHP
// -----------------------------------------------------------------------------
// Tabs element.
// =============================================================================

$class       = ( isset( $class )  ) ? $class  : '';
$set_initial = ! apply_filters( 'cs_is_preview', false );


// Atts: Tabs
// ----------

$atts_tabs = array(
  'class' => x_attr_class( array( $style_id, 'x-tabs', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts_tabs['id'] = $id;
}

$atts_tabs = cs_apply_effect( $atts_tabs, $_view_data );
$tabs_js_atts = array();

if ($tabs_panels_equal_height) {
  $tabs_js_atts['equalPanelHeight'] = $tabs_panels_equal_height;
}

$atts_tabs = array_merge( $atts_tabs, cs_element_js_atts( 'tabs', $tabs_js_atts ) );




// Custom Data
// -----------

$context_id = ( isset( $_view_data['_p'] ) ) ? $_view_data['_p'] . '-' : '';

// Output
// ------
// 01. Create unique_id for tab link.
// 02. Prevent collision.
// 03. Automatic class.
// 04. Add "x-active" conditionally.
//
// 01. Create unique_id for tab link.
// 02. Prevent collision.
// 03. Automatic class.

?>

<div <?php echo x_atts( $atts_tabs, $custom_atts ); ?>>

  <div class="x-tabs-list">
    <ul role="tablist">


      <?php foreach ( $_view_data['tabs'] as $index => $tab ) : ?>

        <?php

        $tab_unique_id = $context_id . $tab['unique_id']; // 01

        if (isset($tab['id']) && !empty($tab['id'])) {
          $tab_id = $tab['id'];
        }else{
          $tab_id = $tab_unique_id; // 02
        }

        $first_open = ( $index === 0 && $set_initial );

        $tab_class  = 'e' . $tab_unique_id; // 03
        $tab_class .= $first_open ? ' x-active' : ''; // 04

        $tab_atts = array(
          'id'                  => 'tab-' . $tab_id,
          'class'               => $tab_class,
          'role'                => 'tab',
          'aria-selected'       => $first_open ? 'true' : 'false',
          'aria-controls'       => 'panel-' . $tab_id,
          'data-x-toggle'       => 'tab',
          'data-x-toggleable'   => 'tab-item-' . $tab_id,
          'data-x-toggle-group' => 'tab-group-' . $unique_id,
        );

        // if (isset($tab['id'])) {
        //   $tab_atts['id'] = $tab['id'];
        // }

        if ( ! empty( $tab['toggle_hash'] ) ) {
          $tab_atts['data-x-toggle-hash'] = $tab['toggle_hash'];
        }

        if (isset($tab['class'])) {
          $tab_atts['class'] .= ' ' . $tab['class'];
        }

        ?>

        <li role="presentation">
          <button <?php echo x_atts( $tab_atts, $tab['tab_label_custom_atts'] ); ?>>
            <span><?php echo do_shortcode( $tab['tab_label_content'] ); ?></span>
          </button>
        </li>

      <?php endforeach; ?>

    </ul>
  </div>

  <div class="x-tabs-panels">

    <?php foreach ( $_view_data['tabs'] as $index => $tab ) : ?>

      <?php

      $tab_unique_id = $context_id . $tab['unique_id']; // 01

      if (isset($tab['id']) && !empty($tab['id'])) {
        $tab_id = $tab['id'];
      }else{
        $tab_id = $tab_unique_id; // 02
      }

      $tab_class = 'e' . $tab_unique_id; // 03

      $first_open = ( $index === 0 && $set_initial );

      $panel_atts = array(
        'class'             => $tab_class . ' x-tabs-panel ',
        'role'              => 'tabpanel',
        'aria-labelledby'   => 'tab-' . $tab_id,
        'aria-hidden'       => $first_open ? 'false' : 'true',
        'data-x-toggleable' => 'tab-item-' . $tab_id
      );


      $panel_atts['id'] = 'panel-' . $tab_id;

      if ( $first_open ) {
        $panel_atts['class'] .= ' x-active';
      }

      if (isset($tab['class'])) {
        $panel_atts['class'] .= ' ' . $tab['class'];
      }

      ?>

      <div <?php echo x_atts( $panel_atts, $tab['tab_content_custom_atts'] ); ?>>
        <?php echo do_shortcode( cs_dynamic_content( $tab['tab_content'] ) ); ?>
      </div>

    <?php endforeach; ?>

  </div>

</div>
