<?php

// =============================================================================
// VIEWS/PARTIALS/ANCHOR.PHP
// -----------------------------------------------------------------------------
// Anchor partial.
// =============================================================================

$unique_id             = ( isset( $unique_id )             ) ? $unique_id : '';
$style_id              = ( isset( $style_id )              ) ? $style_id                : '';
$atts                  = ( isset( $atts )                  ) ? $atts                  : array();
$anchor_custom_atts    = ( isset( $anchor_custom_atts )    ) ? $anchor_custom_atts    : null;
$anchor_before_content = ( isset( $anchor_before_content ) ) ? $anchor_before_content : '';
$anchor_after_content  = ( isset( $anchor_after_content )  ) ? $anchor_after_content  : '';
$anchor_is_active      = ( isset( $anchor_is_active )      ) ? $anchor_is_active      : false;

if ( !$anchor_custom_atts && isset( $custom_atts ) ) {
  $anchor_custom_atts = $custom_atts;
}


// Conditions
// ----------

$is_type_button          = $anchor_type === 'button';
$is_type_menu_item       = $anchor_type === 'menu-item';
$is_not_type_menu_item   = $anchor_type !== 'menu-item';
$is_type_toggle          = $anchor_type === 'toggle';

$has_text                = isset( $anchor_text ) && $anchor_text == true;
$has_graphic             = isset( $anchor_graphic ) && $anchor_graphic == true;
$has_sub_indicator       = $is_type_menu_item && isset( $anchor_sub_indicator ) && $anchor_sub_indicator == true;
$has_interactive_content = isset( $anchor_interactive_content ) && $anchor_interactive_content == true;

$is_in_link              = apply_filters( 'cs_in_link', false );


// Prepare Classes
// ---------------

if ( $is_type_menu_item ) {
  if ( ! $anchor_is_active ) {
    $class = '';
  }
}

$classes         = array( $style_id, 'x-anchor', 'x-anchor-' . $anchor_type, $class );
$classes_content = array( 'x-anchor-content' );


// Text
// ----

if ( $has_text ) {

  $anchor_text_content = cs_anchor_text_content( $_view_data, 'main' );

  if ( $has_interactive_content ) {
    $anchor_text_interactive_content = cs_anchor_text_content( $_view_data, 'interactive' );
  }

}


// Graphic
// -------

if ( $has_graphic ) {

  $classes[]                   = 'has-graphic';
  $data_anchor_graphic_content = array_merge( $_view_data, array( 'anchor_is_active' => $anchor_is_active ) );
  $anchor_graphic_content      = cs_anchor_graphic_content( $data_anchor_graphic_content, 'main' );

  if ( $has_interactive_content ) {
    $anchor_graphic_interactive_content = cs_anchor_graphic_content( $data_anchor_graphic_content, 'interactive' );
  }

  if ( $is_type_menu_item && isset( $anchor_graphic_menu_item_display ) && $anchor_graphic_menu_item_display === 'off' ) {
    unset( $anchor_graphic_content );

    if ( $has_interactive_content ) {
      unset( $anchor_graphic_interactive_content );
    }
  }

}


// Sub Indicator
// -------------

if ( $has_sub_indicator ) {
  if ( ! empty( $anchor_sub_indicator_icon ) ) {

    $anchor_sub_indicator_atts = array(
      'class'               => 'x-anchor-sub-indicator',
      'data-x-skip-scroll'  => 'true',
      'aria-hidden'         => 'true',
    );

    $icon_data = fa_get_attr( $anchor_sub_indicator_icon );

    $anchor_sub_indicator_atts[$icon_data['attr']] = $icon_data['entity'];

    if ( isset( $anchor_sub_menu_trigger_location ) && $anchor_sub_menu_trigger_location === 'sub-indicator' ) {
      $anchor_sub_indicator_atts['data-x-toggle-nested-trigger'] = true;
    }

    $anchor_sub_indicator_content = '<i ' . x_atts( $anchor_sub_indicator_atts ) . '></i>';

  }
}


// Particles
// ---------

$primary_is_always_active   = $anchor_is_active && isset( $anchor_primary_particle_always_active ) && $anchor_primary_particle_always_active === true;
$secondary_is_always_active = $anchor_is_active && isset( $anchor_secondary_particle_always_active ) && $anchor_secondary_particle_always_active === true;
$anchor_particle_content    = cs_make_particles( $_view_data, 'anchor', $primary_is_always_active, $secondary_is_always_active );

if ( ! empty( $anchor_particle_content ) ) {
  $classes[] = 'has-particle';
}


// Interactive Content
// -------------------

if ( $has_interactive_content ) {

  $classes[]                          = 'has-int-content';
  $classes_content[]                  = $anchor_interactive_content_interaction;
  $classes_interactive_content        = array_merge( $classes_content, array( 'is-int' ) );
  $anchor_graphic_interactive_content = ( isset( $anchor_graphic_interactive_content ) ) ? $anchor_graphic_interactive_content : '';
  $anchor_text_interactive_content    = ( isset( $anchor_text_interactive_content )    ) ? $anchor_text_interactive_content    : '';

  $anchor_interactive_content_content = '<div class="' . x_attr_class( $classes_interactive_content ) . '">'
                                        . $anchor_graphic_interactive_content
                                        . $anchor_text_interactive_content
                                      . '</div>';

}


// Atts - Foundation
// -----------------

$atts = array_merge( array(
  'class'    => x_attr_class( $classes ),
  'tabindex' => 0
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  if ( $is_type_button ) {
    $atts['id'] = $id;
  } else if ( $is_type_toggle ) {
    $atts['id'] = $id . '-anchor-' . $anchor_type;
  }
}


// Atts - Sharing / Linking
// ------------------------

if ( ! $is_in_link ) {
  if ( isset( $anchor_share_enabled ) && isset( $anchor_share_type ) && isset( $anchor_share_title ) && $anchor_share_enabled ) {
    $atts = cs_atts_for_social_sharing( $atts, $anchor_share_type, $anchor_share_title );
  } else {
    $atts = cs_apply_link( $atts, $_view_data, 'anchor' );
  }
}


// Atts - Toggle
// -------------

if ( $is_type_toggle ) {
  $atts['data-x-toggle']     = true;
  $atts['data-x-toggleable'] = $unique_id;
  if ( ! empty( $toggle_hash ) ) {
    $atts['data-x-toggle-hash'] = $toggle_hash;
  }
  if ( isset( $anchor_aria_controls ) && ! strpos( $anchor_aria_controls, 'dropdown' ) ) {
    $atts['data-x-toggle-overlay'] = true;
  }
}


// Atts - Effect
// -------------

if ( $is_not_type_menu_item ) {
  $atts = cs_apply_effect( $atts, $_view_data );
}


// Atts - Accessibility
// --------------------

if ( isset( $anchor_aria_controls ) ) { $atts['aria-controls'] = $anchor_aria_controls; }
if ( isset( $anchor_aria_expanded ) ) { $atts['aria-expanded'] = $anchor_aria_expanded; }
if ( isset( $anchor_aria_haspopup ) ) { $atts['aria-haspopup'] = $anchor_aria_haspopup; }
if ( isset( $anchor_aria_label )    ) { $atts['aria-label']    = $anchor_aria_label;    }
if ( isset( $anchor_aria_selected ) ) { $atts['aria-selected'] = $anchor_aria_selected; }


// Output
// ------

$output_tag = $is_in_link ? 'div' : 'a';

?>

<<?php echo $output_tag; ?> <?php echo x_atts( $atts, $anchor_custom_atts ); ?>>

  <?php echo $anchor_before_content; ?>

    <div class="<?php echo x_attr_class( $classes_content ); ?>">
      <?php if ( isset( $anchor_graphic_content )       ) : echo $anchor_graphic_content;       endif; ?>
      <?php if ( isset( $anchor_text_content )          ) : echo $anchor_text_content;          endif; ?>
      <?php if ( isset( $anchor_sub_indicator_content ) ) : echo $anchor_sub_indicator_content; endif; ?>
    </div>

    <?php if ( isset( $anchor_interactive_content_content ) ) : echo $anchor_interactive_content_content; endif; ?>
    <?php if ( ! empty( $anchor_particle_content )          ) : echo $anchor_particle_content;            endif; ?>

  <?php echo $anchor_after_content; ?>

</<?php echo $output_tag; ?>>
