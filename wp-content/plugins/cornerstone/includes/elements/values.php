<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/VARIANTS.PHP
// -----------------------------------------------------------------------------
// Search for "alt diff" in this file to see alt colors that do not use the
// empty string technique.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Icon
//   02. Image
//   03. Graphic
//   04. BG (Background)
//   05. Content Area
//   06. Dropdown
//   07. Form Integration
//   08. Frame
//   09. MEJS
//   10. Menu
//   11. Modal
//   12. Off Canvas
//   13. Particle
//   14. Search
//   15. Separator
//   16. Text
//   17. Anchor
//   18. Toggle
//   19. Cart
//   20. Rating
//   21. Pagination
//   22. Products
//   23. Effects
//   24. Omega
// =============================================================================

// Icon
// =============================================================================

cs_define_values( 'icon', array(
  'icon'                        => cs_value( 'l-hand-pointer', 'markup', true ),
  'icon_font_size'              => cs_value( '1em', 'style' ),
  'icon_width'                  => cs_value( 'auto', 'style' ),
  'icon_height'                 => cs_value( 'auto', 'style' ),
  'icon_color'                  => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'icon_color_alt'              => cs_value( '', 'style:color' ),
  'icon_bg_color'               => cs_value( 'transparent', 'style:color' ),
  'icon_bg_color_alt'           => cs_value( '', 'style:color' ),
  'icon_margin'                 => cs_value( '!0em', 'style' ),
  'icon_border_width'           => cs_value( '!0px', 'style' ),
  'icon_border_style'           => cs_value( 'solid', 'style' ),
  'icon_border_color'           => cs_value( 'transparent', 'style:color' ),
  'icon_border_color_alt'       => cs_value( '', 'style:color' ),
  'icon_border_radius'          => cs_value( '!0px', 'style' ),
  'icon_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em', 'style' ),
  'icon_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'icon_box_shadow_color_alt'   => cs_value( '', 'style:color' ),
  'icon_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
  'icon_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'icon_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
) );



// Image
// =============================================================================

cs_define_values( 'image', array(
  'image_type'                  => cs_value( 'standard', 'all' ),
  'image_display'               => cs_value( 'inline-block', 'style' ),
  'image_styled_width'          => cs_value( 'auto', 'style' ),
  'image_styled_max_width'      => cs_value( 'none', 'style' ),
  'image_styled_height'         => cs_value( 'auto', 'style' ),
  'image_styled_max_height'     => cs_value( 'none', 'style' ),
  'image_bg_color'              => cs_value( 'transparent', 'style:color' ),
  'image_bg_color_alt'          => cs_value( '', 'style:color' ),
  'image_margin'                => cs_value( '!0px', 'style' ),
  'image_padding'               => cs_value( '!0px', 'style' ),
  'image_border_width'          => cs_value( '!0px', 'style' ),
  'image_border_style'          => cs_value( 'solid', 'style' ),
  'image_border_color'          => cs_value( 'transparent', 'style:color' ),
  'image_border_color_alt'      => cs_value( '', 'style:color' ),
  'image_outer_border_radius'   => cs_value( '!0em', 'style' ),
  'image_inner_border_radius'   => cs_value( '!0em', 'style' ),
  'image_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
  'image_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'image_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
) );


cs_define_values( 'image:retina', array(
  'image_retina' => cs_value( true, 'markup', true )
) );


cs_define_values( 'image:dimensions', array(
  'image_width'  => cs_value( '', 'markup', true ),
  'image_height' => cs_value( '', 'markup', true )
) );


cs_define_values( 'image:link', array(
  'image_link'     => cs_value( false, 'markup', true ),
  'image_href'     => cs_value( '', 'markup', true ),
  'image_blank'    => cs_value( false, 'markup', true ),
  'image_nofollow' => cs_value( false, 'markup', true )
) );

cs_define_values( 'image:src', array(
  'image_src' => cs_value( '', 'markup', true )
) );

cs_define_values( 'image:alt', array(
  'image_alt' => cs_value( '', 'markup', true )
) );

cs_define_values( 'image:object', array(
  'image_object_fit'      => cs_value( 'fill', 'style', true ),
  'image_object_position' => cs_value( '50% 50%', 'style', true )
) );



// Graphic
// =============================================================================

cs_define_values( 'graphic', array(
  'graphic_has_alt'                     => cs_value( false, 'all' ),
  'graphic_has_interactions'            => cs_value( false, 'all' ),
  'graphic_has_sourced_content'         => cs_value( false, 'all' ),
  'graphic_has_toggle'                  => cs_value( false, 'all' ),

  'graphic'                             => cs_value( false, 'all' ),
  'graphic_type'                        => cs_value( 'icon', 'all', true ),

  'graphic_margin'                      => cs_value( '5px', 'style' ),

  'graphic_icon'                        => cs_value( 'l-hand-pointer', 'markup', true ),
  'graphic_icon_font_size'              => cs_value( '1.25em', 'style' ),
  'graphic_icon_width'                  => cs_value( 'auto', 'style' ),
  'graphic_icon_height'                 => cs_value( 'auto', 'style' ),
  'graphic_icon_color'                  => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'graphic_icon_bg_color'               => cs_value( 'transparent', 'style:color' ),
  'graphic_icon_border_width'           => cs_value( '!0px', 'style' ),
  'graphic_icon_border_style'           => cs_value( 'solid', 'style' ),
  'graphic_icon_border_color'           => cs_value( 'transparent', 'style:color' ),
  'graphic_icon_border_radius'          => cs_value( '!0px', 'style' ),
  'graphic_icon_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em', 'style' ),
  'graphic_icon_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'graphic_icon_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
  'graphic_icon_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  'graphic_image_src'                   => cs_value( '', 'markup', true ),
  'graphic_image_width'                 => cs_value( '', 'markup', true ),
  'graphic_image_height'                => cs_value( '', 'markup', true ),
  'graphic_image_alt'                   => cs_value( '', 'markup', true ),
  'graphic_image_max_width'             => cs_value( 'none', 'style' ),
  'graphic_image_retina'                => cs_value( true, 'markup', true ),
) );


cs_define_values( 'graphic:alt', array(
  'graphic_has_alt'                    => cs_value( true, 'all' ),
  'graphic_icon_alt_enable'            => cs_value( false, 'markup' ),
  'graphic_icon_color_alt'             => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
  'graphic_icon_bg_color_alt'          => cs_value( '', 'style:color' ),
  'graphic_icon_border_color_alt'      => cs_value( '', 'style:color' ),
  'graphic_icon_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
  'graphic_icon_text_shadow_color_alt' => cs_value( '', 'style:color' ),
  'graphic_image_alt_enable'           => cs_value( false, 'markup' ),
  'graphic_icon_alt'                   => cs_value( 'l-hand-spock', 'markup', true ),
  'graphic_image_src_alt'              => cs_value( '', 'markup', true ),
  'graphic_image_alt_alt'              => cs_value( '', 'markup', true ),
) );


cs_define_values( 'graphic:toggle', array(
  'graphic_has_toggle' => cs_value( true, 'all' )
) );


cs_define_values( 'graphic:interactions', array(
  'graphic_has_interactions' => cs_value( true, 'all' ),
  'graphic_interaction'      => cs_value( 'none', 'markup' ),
) );


cs_define_values( 'graphic:sourced-content', array(
  'graphic_has_sourced_content' => cs_value( true, 'all' ),
  'graphic_icon_alt'            => null,
  'graphic_image_src_alt'       => null,
  'graphic_image_alt_alt'       => null,
  'graphic_icon'                => null,
  'graphic_image_src'           => null,
  'graphic_image_width'         => null,
  'graphic_image_height'        => null,
  'graphic_image_alt'           => null
) );



// BG (Background)
// =============================================================================

cs_define_values( 'bg', array(
  'bg_lower_type'                => cs_value( 'none', 'markup' ),
  'bg_lower_color'               => cs_value( 'rgba(255, 255, 255, 0.5)', 'attr' ),
  'bg_lower_image'               => cs_value( '', 'markup', true ),
  'bg_lower_image_repeat'        => cs_value( 'no-repeat', 'attr', true ),
  'bg_lower_image_size'          => cs_value( 'cover', 'attr', true ),
  'bg_lower_image_position'      => cs_value( 'center', 'attr', true ),
  'bg_lower_img_src'             => cs_value( '', 'markup', true ),
  'bg_lower_img_alt'             => cs_value( '', 'attr', true ),
  'bg_lower_img_object_fit'      => cs_value( 'cover', 'attr', true ),
  'bg_lower_img_object_position' => cs_value( 'center', 'attr', true ),
  'bg_lower_video'               => cs_value( '', 'markup', true ),
  'bg_lower_video_poster'        => cs_value( '', 'markup', true ),
  'bg_lower_video_loop'          => cs_value( true, 'markup' ),
  'bg_lower_custom_content'      => cs_value( '', 'markup:html', true ),
  'bg_lower_custom_aria_hidden'  => cs_value( true, 'attr', true ),

  'bg_lower_parallax'            => cs_value( false, 'markup' ),
  'bg_lower_parallax_size'       => cs_value( '150%', 'markup' ),
  'bg_lower_parallax_direction'  => cs_value( 'v', 'markup' ),
  'bg_lower_parallax_reverse'    => cs_value( false, 'markup' ),

  'bg_upper_type'                => cs_value( 'none', 'markup' ),
  'bg_upper_color'               => cs_value( 'rgba(255, 255, 255, 0.5)', 'attr' ),
  'bg_upper_image'               => cs_value( '', 'markup', true ),
  'bg_upper_image_repeat'        => cs_value( 'no-repeat', 'attr', true ),
  'bg_upper_image_size'          => cs_value( 'cover', 'attr', true ),
  'bg_upper_image_position'      => cs_value( 'center', 'attr', true ),
  'bg_upper_img_src'             => cs_value( '', 'markup', true ),
  'bg_upper_img_alt'             => cs_value( '', 'attr', true ),
  'bg_upper_img_object_fit'      => cs_value( 'cover', 'attr', true ),
  'bg_upper_img_object_position' => cs_value( 'center', 'attr', true ),
  'bg_upper_video'               => cs_value( '', 'markup', true ),
  'bg_upper_video_poster'        => cs_value( '', 'markup', true ),
  'bg_upper_video_loop'          => cs_value( true, 'markup' ),
  'bg_upper_custom_content'      => cs_value( '', 'markup:html', true ),
  'bg_upper_custom_aria_hidden'  => cs_value( true, 'attr', true ),

  'bg_upper_parallax'            => cs_value( false, 'markup' ),
  'bg_upper_parallax_size'       => cs_value( '150%', 'markup' ),
  'bg_upper_parallax_direction'  => cs_value( 'v', 'markup' ),
  'bg_upper_parallax_reverse'    => cs_value( false, 'markup' ),

  'bg_border_radius'             => cs_value( '!inherit', 'attr' ),
) );



// Content Area
// =============================================================================

cs_define_values( 'content-area', array(
  'content' => cs_value( __( '<span>This content will show up directly in its container.</span>', '__x__' ), 'markup:html', true ),
) );


cs_define_values( 'content-area-margin', array(
  'content_margin' => cs_value( '!0em', 'style' ),
) );


cs_define_values( 'content-area:dynamic', array(
  'content'                   => cs_value( __( '<div style="padding: 25px; line-height: 1.4; text-align: center;">Add any HTML or custom content here.</div>', '__x__' ), 'markup:html', true ),
  'content_dynamic_rendering' => cs_value( false, 'markup:raw', true )
) );



// Dropdown
// =============================================================================

cs_define_values( 'dropdown', array(
  'dropdown_base_font_size'        => cs_value( '16px', 'style' ),
  'dropdown_duration'              => cs_value( '500ms', 'style' ),
  'dropdown_timing_function'       => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'style' ),
  'dropdown_width'                 => cs_value( '14em', 'style' ),
  'dropdown_bg_color'              => cs_value( '#ffffff', 'style:color' ),
  'dropdown_margin'                => cs_value( '!0em', 'style' ),
  'dropdown_padding'               => cs_value( '!0em', 'style' ),
  'dropdown_border_width'          => cs_value( '!0px', 'style' ),
  'dropdown_border_style'          => cs_value( 'solid', 'style' ),
  'dropdown_border_color'          => cs_value( 'transparent', 'style:color' ),
  'dropdown_border_radius'         => cs_value( '!0px', 'style' ),
  'dropdown_box_shadow_dimensions' => cs_value( '0em 0.15em 2em 0em', 'style' ),
  'dropdown_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
) );

cs_define_values( 'dropdown:custom-atts', array(
  'dropdown_custom_atts' => cs_value( '', 'markup:raw' )
) );



// Form Integration
// =============================================================================

cs_define_values( 'form-integration', array(
  'form_integration_type'                      => cs_value( 'embed', 'markup', true ),
  'form_integration_width'                     => cs_value( 'auto', 'style' ),
  'form_integration_max_width'                 => cs_value( 'none', 'style' ),

  'form_integration_embed_content'             => cs_value( '', 'markup:html', true ),

  'form_integration_wpforms_id'                => cs_value( '', 'markup', true ),
  'form_integration_wpforms_title'             => cs_value( false, 'markup', true ),
  'form_integration_wpforms_description'       => cs_value( false, 'markup', true ),

  'form_integration_contact_form_7_id'         => cs_value( '', 'markup', true ),
  'form_integration_contact_form_7_title'      => cs_value( false, 'markup', true ),

  'form_integration_gravityforms_id'           => cs_value( '', 'markup', true ),
  'form_integration_gravityforms_title'        => cs_value( false, 'markup', true ),
  'form_integration_gravityforms_description'  => cs_value( false, 'markup', true ),
  'form_integration_gravityforms_ajax'         => cs_value( false, 'markup', true ),
  'form_integration_gravityforms_tabindex'     => cs_value( '', 'markup', true ),
  'form_integration_gravityforms_field_values' => cs_value( '', 'markup', true ),

  'form_integration_margin'                    => cs_value( '!0px', 'style' ),
) );



// Frame
// =============================================================================

cs_define_values( 'frame', array(
  'frame_content_sizing'              => cs_value( 'aspect-ratio', 'style' ),
  'frame_base_font_size'              => cs_value( '16px', 'style' ),
  'frame_width'                       => cs_value( '100%', 'style' ),
  'frame_max_width'                   => cs_value( 'none', 'style' ),
  'frame_content_aspect_ratio_width'  => cs_value( '16', 'style' ),
  'frame_content_aspect_ratio_height' => cs_value( '9', 'style' ),
  'frame_content_height'              => cs_value( '350px', 'style' ),
  'frame_bg_color'                    => cs_value( '#ffffff', 'style:color' ),
  'frame_margin'                      => cs_value( '!0em', 'style' ),
  'frame_padding'                     => cs_value( '!0em', 'style' ),
  'frame_border_width'                => cs_value( '!0px', 'style' ),
  'frame_border_style'                => cs_value( 'solid', 'style' ),
  'frame_border_color'                => cs_value( 'transparent', 'style:color' ),
  'frame_border_radius'               => cs_value( '!0px', 'style' ),
  'frame_box_shadow_dimensions'       => cs_value( '!0em 0em 0em 0em', 'style' ),
  'frame_box_shadow_color'            => cs_value( 'transparent', 'style:color' ),
) );



// MEJS
// =============================================================================

cs_define_values( 'mejs', array(
  'mejs_type'                                     => cs_value( 'audio', 'style' ),
  'mejs_preload'                                  => cs_value( 'metadata', 'markup' ),
  'mejs_advanced_controls'                        => cs_value( false, 'markup' ),
  'mejs_autoplay'                                 => cs_value( false, 'markup' ),
  'mejs_loop'                                     => cs_value( false, 'markup' ),
  'mejs_controls_button_color'                    => cs_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
  'mejs_controls_button_color_alt'                => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ), // alt diff
  'mejs_controls_time_total_bg_color'             => cs_value( 'rgba(255, 255, 255, 0.25)', 'style:color' ),
  'mejs_controls_time_loaded_bg_color'            => cs_value( 'rgba(255, 255, 255, 0.25)', 'style:color' ),
  'mejs_controls_time_current_bg_color'           => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'mejs_controls_color'                           => cs_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
  'mejs_controls_bg_color'                        => cs_value( 'rgba(0, 0, 0, 0.8)', 'style:color' ),
  'mejs_controls_padding'                         => cs_value( '!0px', 'style' ),
  'mejs_controls_border_width'                    => cs_value( '!0px', 'style' ),
  'mejs_controls_border_style'                    => cs_value( 'solid', 'style' ),
  'mejs_controls_border_color'                    => cs_value( 'transparent', 'style' ),
  'mejs_controls_border_radius'                   => cs_value( '3px', 'style' ),
  'mejs_controls_box_shadow_dimensions'           => cs_value( '!0em 0em 0em 0em', 'style' ),
  'mejs_controls_box_shadow_color'                => cs_value( 'transparent', 'style' ),
  'mejs_controls_time_rail_border_radius'         => cs_value( '2px', 'style' ),
  'mejs_controls_time_rail_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
  'mejs_controls_time_rail_box_shadow_color'      => cs_value( 'transparent', 'style' ),
) );


cs_define_values( 'mejs:video', array(
  'mejs_type'            => cs_value( 'video', 'style' ),
  'mejs_hide_controls'   => cs_value( false, 'markup' ),
  'mejs_muted'           => cs_value( false, 'markup' ),
  'mejs_controls_margin' => cs_value( 'auto 15px 15px 15px', 'style' ),
) );



// Menu
// =============================================================================

cs_define_values( 'menu:base', array(
  'menu'                                      => cs_value( 'sample:default', 'all', true ),
  'menu_active_links_highlight_current'       => cs_value( true, 'all' ),
  'menu_active_links_highlight_ancestors'     => cs_value( true, 'all' ),
  'menu_active_links_show_graphic'            => cs_value( false, 'all' ),
  'menu_active_links_show_primary_particle'   => cs_value( false, 'all' ),
  'menu_active_links_show_secondary_particle' => cs_value( false, 'all' ),
  'menu_custom_atts'                          => cs_value( '', 'markup:raw' )
) );


cs_define_values( 'menu:styles', array(
  'menu_base_font_size' => cs_value( '1em', 'style' ),
  'menu_margin'         => cs_value( '!0px', 'style' ),
) );


cs_define_values( 'menu-inline', cs_compose_values(
  'menu:base',
  'menu:styles',
  array(
    'menu_type'               => cs_value( 'inline', 'all' ),
    'menu_align_self'         => cs_value( 'stretch', 'style' ),
    'menu_flex'               => cs_value( '0 0 auto', 'style' ),
    'menu_row_flex_direction' => cs_value( 'row', 'style' ),
    'menu_row_flex_wrap'      => cs_value( false, 'style' ),
    'menu_row_flex_justify'   => cs_value( 'space-around', 'style' ),
    'menu_row_flex_align'     => cs_value( 'stretch', 'style' ),
    'menu_col_flex_direction' => cs_value( 'column', 'style' ),
    'menu_col_flex_wrap'      => cs_value( false, 'style' ),
    'menu_col_flex_justify'   => cs_value( 'space-around', 'style' ),
    'menu_col_flex_align'     => cs_value( 'stretch', 'style' ),
    'menu_items_flex'         => cs_value( '0 1 auto', 'style' ),
  )
) );


cs_define_values( 'menu-collapsed', cs_compose_values(
  'menu:base',
  'menu:styles',
  array(
    'menu_type'                      => cs_value( 'collapsed', 'all' ),
    'menu_sub_menu_trigger_location' => cs_value( 'anchor', 'attr' ),
  )
) );


cs_define_values( 'menu-modal', cs_compose_values(
  'menu:base',
  'menu:styles',
  array(
    'menu_type'                      => cs_value( 'modal', 'all' ),
    'menu_sub_menu_trigger_location' => cs_value( 'anchor', 'attr' ),
    'menu_layered_back_label'        => cs_value( __( '← Back', '__x__' ), 'markup:raw' ),
  )
) );


cs_define_values( 'menu-layered', cs_compose_values(
  'menu:base',
  'menu:styles',
  array(
    'menu_type'                      => cs_value( 'layered', 'all' ),
    'menu_sub_menu_trigger_location' => cs_value( 'anchor', 'attr' ),
    'menu_layered_back_label'        => cs_value( __( '← Back', '__x__' ), 'markup:raw' ),
  )
) );


cs_define_values( 'menu-dropdown', cs_compose_values(
  'menu:base',
  array(
    'menu_type' => cs_value( 'dropdown', 'all' ),
  )
) );



// Modal
// =============================================================================

cs_define_values( 'modal', array(
  'modal_base_font_size'                => cs_value( '16px', 'style' ),
  'modal_content_max_width'             => cs_value( '28em', 'style' ),
  'modal_body_scroll'                   => cs_value( 'allow', 'markup' ),
  'modal_close_location'                => cs_value( 'top-right', 'markup' ),
  'modal_close_font_size'               => cs_value( '1.5em', 'style' ),
  'modal_close_dimensions'              => cs_value( '1', 'style' ),
  'modal_duration'                      => cs_value( '500ms', 'style' ),
  'modal_timing_function'               => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'style' ),
  'modal_bg_color'                      => cs_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
  'modal_close_color'                   => cs_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
  'modal_close_color_alt'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ), // alt diff
  'modal_content_bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'modal_content_padding'               => cs_value( '2em', 'style' ),
  'modal_content_border_width'          => cs_value( '!0px', 'style' ),
  'modal_content_border_style'          => cs_value( 'solid', 'style' ),
  'modal_content_border_color'          => cs_value( 'transparent', 'style:color' ),
  'modal_content_border_radius'         => cs_value( '!0px', 'style' ),
  'modal_content_box_shadow_dimensions' => cs_value( '0em 0.15em 2em 0em', 'style' ),
  'modal_content_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  'modal_custom_atts'                   => cs_value( '', 'markup:raw' )
) );



// Off Canvas
// =============================================================================

cs_define_values( 'off-canvas', array(
  'off_canvas_base_font_size'                => cs_value( '16px', 'style' ),
  'off_canvas_content_max_width'             => cs_value( '24em', 'style' ),
  'off_canvas_body_scroll'                   => cs_value( 'allow', 'markup' ),
  'off_canvas_location'                      => cs_value( 'right', 'markup' ),
  'off_canvas_close_font_size'               => cs_value( '1.5em', 'style' ),
  'off_canvas_close_dimensions'              => cs_value( '2', 'style' ),
  'off_canvas_duration'                      => cs_value( '500ms', 'style' ),
  'off_canvas_timing_function'               => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'style' ),
  'off_canvas_close_color'                   => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
  'off_canvas_close_color_alt'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ), // alt diff
  'off_canvas_content_bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'off_canvas_bg_color'                      => cs_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
  'off_canvas_content_border_width'          => cs_value( '!0px', 'style' ),
  'off_canvas_content_border_style'          => cs_value( 'solid', 'style' ),
  'off_canvas_content_border_color'          => cs_value( 'transparent', 'style:color' ),
  'off_canvas_content_box_shadow_dimensions' => cs_value( '0em 0em 2em 0em', 'style' ),
  'off_canvas_content_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  'off_canvas_custom_atts'                   => cs_value( '', 'markup:raw' )
) );



// Particle
// =============================================================================

cs_define_values( 'particle', array(
  'particle'                  => cs_value( false, 'all' ),
  'particle_location'         => cs_value( 'b_c', 'attr' ),
  'particle_placement'        => cs_value( 'inside', 'attr' ),
  'particle_scale'            => cs_value( 'scale-y', 'attr' ),
  'particle_delay'            => cs_value( '0ms', 'style' ),
  'particle_transform_origin' => cs_value( '100% 100%', 'style' ),
  'particle_width'            => cs_value( '100%', 'style' ),
  'particle_height'           => cs_value( '3px', 'style' ),
  'particle_border_radius'    => cs_value( '0px', 'style' ),
  'particle_color'            => cs_value( 'rgba(0, 0, 0, 0.75)', 'style:color' ),
  'particle_style'            => cs_value( '', 'attr' ),
) );



// Search
// =============================================================================

cs_define_values( '_search', array(

  'search_placeholder'                  => cs_value( __( 'Search', '__x__' ), 'markup', true ),
  'search_order_input'                  => cs_value( '2', 'style' ),
  'search_order_submit'                 => cs_value( '1', 'style' ),
  'search_order_clear'                  => cs_value( '3', 'style' ),

  'search_base_font_size'               => cs_value( '1em', 'style' ),
  'search_width'                        => cs_value( '100%', 'style' ),
  'search_height'                       => cs_value( 'auto', 'style' ),
  'search_max_width'                    => cs_value( 'none', 'style' ),
  'search_bg_color'                     => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'search_bg_color_alt'                 => cs_value( '', 'style:color' ),

  'search_margin'                       => cs_value( '!0em', 'style' ),
  'search_border_width'                 => cs_value( '!0px', 'style' ),
  'search_border_style'                 => cs_value( 'solid', 'style' ),
  'search_border_color'                 => cs_value( 'transparent', 'style:color' ),
  'search_border_color_alt'             => cs_value( '', 'style:color' ),
  'search_border_radius'                => cs_value( '100em', 'style' ),
  'search_box_shadow_dimensions'        => cs_value( '0em 0.15em 0.5em 0em', 'style' ),
  'search_box_shadow_color'             => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
  'search_box_shadow_color_alt'         => cs_value( '', 'style:color' ),

  'search_input_margin'                 => cs_value( '!0em', 'style' ),
  'search_input_font_family'            => cs_value( 'inherit', 'style:font-family' ),
  'search_input_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
  'search_input_font_size'              => cs_value( '1em', 'style' ),
  'search_input_letter_spacing'         => cs_value( '0em', 'style' ),
  'search_input_line_height'            => cs_value( '1.3', 'style' ),
  'search_input_font_style'             => cs_value( 'normal', 'style' ),
  'search_input_text_align'             => cs_value( 'none', 'style' ),
  'search_input_text_decoration'        => cs_value( 'none', 'style' ),
  'search_input_text_transform'         => cs_value( 'none', 'style' ),
  'search_input_text_color'             => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
  'search_input_text_color_alt'         => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ), // alt diff

  'search_submit_font_size'             => cs_value( '1em', 'style' ),
  'search_submit_stroke_width'          => cs_value( 2, 'markup' ),
  'search_submit_width'                 => cs_value( '1em', 'style' ),
  'search_submit_height'                => cs_value( '1em', 'style' ),
  'search_submit_color'                 => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'search_submit_color_alt'             => cs_value( '', 'style:color' ),
  'search_submit_bg_color'              => cs_value( 'transparent', 'style:color' ),
  'search_submit_bg_color_alt'          => cs_value( '', 'style:color' ),
  'search_submit_margin'                => cs_value( '0.5em 0.5em 0.5em 0.9em', 'style' ),
  'search_submit_border_width'          => cs_value( '!0px', 'style' ),
  'search_submit_border_style'          => cs_value( 'solid', 'style' ),
  'search_submit_border_color'          => cs_value( 'transparent', 'style:color' ),
  'search_submit_border_color_alt'      => cs_value( '', 'style:color' ),
  'search_submit_border_radius'         => cs_value( '!0px', 'style' ),
  'search_submit_box_shadow_dimensions' => cs_value( '!0em 0em 0em 0em', 'style' ),
  'search_submit_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'search_submit_box_shadow_color_alt'  => cs_value( '', 'style:color' ),

  'search_clear_font_size'              => cs_value( '0.9em', 'style' ),
  'search_clear_stroke_width'           => cs_value( 3, 'markup' ),
  'search_clear_width'                  => cs_value( '2em', 'style' ),
  'search_clear_height'                 => cs_value( '2em', 'style' ),
  'search_clear_color'                  => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'search_clear_color_alt'              => cs_value( '', 'style:color' ),
  'search_clear_bg_color'               => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
  'search_clear_bg_color_alt'           => cs_value( 'rgba(0, 0, 0, 0.3)', 'style:color' ), // alt diff
  'search_clear_margin'                 => cs_value( '0.5em', 'style' ),
  'search_clear_border_width'           => cs_value( '!0px', 'style' ),
  'search_clear_border_style'           => cs_value( 'solid', 'style' ),
  'search_clear_border_color'           => cs_value( 'transparent', 'style:color' ),
  'search_clear_border_color_alt'       => cs_value( '', 'style:color' ),
  'search_clear_border_radius'          => cs_value( '100em', 'style' ),
  'search_clear_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em', 'style' ),
  'search_clear_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'search_clear_box_shadow_color_alt'   => cs_value( '', 'style:color' ),
  'search_custom_atts'                  => cs_value( '', 'markup:raw' )
) );


cs_define_values( 'search-inline', cs_compose_values(
  '_search',
  array(
    'search_type' => cs_value( 'inline', 'all' )
  )
) );


cs_define_values( 'search-modal', cs_compose_values(
  '_search',
  array(
    'search_type' => cs_value( 'modal', 'all' )
  )
) );


cs_define_values( 'search-dropdown', cs_compose_values(
  '_search',
  array(
    'search_type' => cs_value( 'dropdown', 'all' ),
    'search_base_font_size'        => cs_value( '1.25em', 'style' ),
    'search_border_radius'         => cs_value( '0em', 'style' ),
    'search_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'search_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'search_box_shadow_color_alt'  => cs_value( '', 'style:color' ),
    'search_submit_margin'         => cs_value( '0.9em 0.65em 0.9em 0.9em', 'style' ),
    'search_clear_font_size'       => cs_value( '1em', 'style' ),
    'search_clear_width'           => cs_value( '1em', 'style' ),
    'search_clear_height'          => cs_value( '1em', 'style' ),
    'search_clear_color'           => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'search_clear_color_alt'       => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
    'search_clear_bg_color'        => cs_value( 'transparent', 'style:color' ),
    'search_clear_bg_color_alt'    => cs_value( '', 'style:color' ),
    'search_clear_stroke_width'    => cs_value( '2', 'markup' ),
    'search_clear_margin'          => cs_value( '0.9em 0.9em 0.9em 0.65em', 'style' ),
  )
) );



// Separator
// =============================================================================

cs_define_values( '_separator', array(
  'separator'             => cs_value( false, 'all' ),
  'separator_type'        => cs_value( 'angle-in', 'markup' ),
  'separator_angle_point' => cs_value( '50', 'attr' ),
  'separator_height'      => cs_value( '50px', 'attr' ),
  'separator_inset'       => cs_value( '0px', 'attr' ),
  'separator_color'       => cs_value( 'rgba(0, 0, 0, 0.75)', 'attr' ),
) );


cs_define_values( 'separator-top', cs_compose_values(
  '_separator',
  array(
    'separator_location' => cs_value( 'top', 'all' )
  )
) );


cs_define_values( 'separator-bottom', cs_compose_values(
  '_separator',
  array(
    'separator_location' => cs_value( 'bottom', 'all' )
  )
) );



// Text
// =============================================================================

cs_define_values( '_text', array(
  'text_width'                  => cs_value( 'auto', 'style' ),
  'text_max_width'              => cs_value( 'none', 'style' ),
  'text_bg_color'               => cs_value( 'transparent', 'style:color' ),
  'text_bg_color_alt'           => cs_value( '', 'style:color' ),
  'text_margin'                 => cs_value( '!0em', 'style' ),
  'text_padding'                => cs_value( '!0em', 'style' ),
  'text_border_width'           => cs_value( '!0px', 'style' ),
  'text_border_style'           => cs_value( 'solid', 'style' ),
  'text_border_color'           => cs_value( 'transparent', 'style:color' ),
  'text_border_color_alt'       => cs_value( '', 'style:color' ),
  'text_border_radius'          => cs_value( '!0px', 'style' ),
  'text_box_shadow_dimensions'  => cs_value( '!0em 0em 0em 0em', 'style' ),
  'text_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'text_box_shadow_color_alt'   => cs_value( '', 'style:color' ),
  'text_font_family'            => cs_value( 'inherit', 'style:font-family' ),
  'text_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
  'text_font_size'              => cs_value( '1em', 'style' ),
  'text_line_height'            => cs_value( '1.4', 'style' ),
  'text_letter_spacing'         => cs_value( '0em', 'style' ),
  'text_font_style'             => cs_value( 'normal', 'style' ),
  'text_text_align'             => cs_value( 'none', 'style' ),
  'text_text_decoration'        => cs_value( 'none', 'style' ),
  'text_text_transform'         => cs_value( 'none', 'style' ),
  'text_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'text_text_color_alt'         => cs_value( '', 'style:color' ),
  'text_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
  'text_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'text_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
) );


cs_define_values( '_text-link', array(
  'text_link'     => cs_value( false, 'markup', true ),
  'text_href'     => cs_value( '', 'markup', true ),
  'text_blank'    => cs_value( false, 'markup', true ),
  'text_nofollow' => cs_value( false, 'markup', true )
) );


cs_define_values( 'text-standard', cs_compose_values(
  '_text',
  array(
    'text_type'                   => cs_value( 'standard', 'all:readonly' ),
    'text_content'                => cs_value( __( 'Input your text here! The text element is intended for longform copy that could potentially include multiple paragraphs.', '__x__' ), 'markup:html', true ),
    'text_columns_break_inside'   => cs_value( 'auto', 'style' ),
    'text_columns'                => cs_value( false, 'style' ),
    'text_columns_count'          => cs_value( 2, 'style' ),
    'text_columns_width'          => cs_value( '250px', 'style' ),
    'text_columns_gap'            => cs_value( '25px', 'style' ),
    'text_columns_rule_style'     => cs_value( 'solid', 'style' ),
    'text_columns_rule_width'     => cs_value( '2px', 'style' ),
    'text_columns_rule_color'     => cs_value( 'rgba(0, 0, 0, 0.1)', 'style:color' ),
    'text_columns_rule_color_alt' => cs_value( '', 'style:color' ),
  )
) );


cs_define_values( 'text-headline', cs_compose_values(
  '_text',
  '_text-link',
  array(
    'text_type'                               => cs_value( 'headline', 'all:readonly' ),
    'text_content'                            => cs_value( __( 'Short and Sweet Headlines are Best!', '__x__' ), 'markup:html', true ),
    'text_base_font_size'                     => cs_value( '1em', 'style' ),
    'text_tag'                                => cs_value( 'h1', 'markup', true ),
    'text_overflow'                           => cs_value( false, 'style' ),
    'text_typing'                             => cs_value( false, 'markup' ),
    'text_typing_prefix'                      => cs_value( 'Short and ', 'markup:raw', true ),
    'text_typing_content'                     => cs_value( "Sweet\nClever\nImpactful", 'markup:raw', true ),
    'text_typing_suffix'                      => cs_value( ' Headlines are Best!', 'markup:raw', true ),
    'text_typing_speed'                       => cs_value( '150ms', 'markup' ),
    'text_typing_back_speed'                  => cs_value( '85ms', 'markup' ),
    'text_typing_delay'                       => cs_value( '0ms', 'markup' ),
    'text_typing_back_delay'                  => cs_value( '1800ms', 'markup' ),
    'text_typing_loop'                        => cs_value( true, 'markup' ),
    'text_typing_cursor'                      => cs_value( true, 'markup' ),
    'text_typing_cursor_content'              => cs_value( '|', 'markup' ),
    'text_typing_color'                       => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'text_typing_color_alt'                   => cs_value( '', 'style:color' ),
    'text_typing_cursor_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'text_typing_cursor_color_alt'            => cs_value( '', 'style:color' ),
    'text_flex_direction'                     => cs_value( 'row', 'style' ),
    'text_flex_wrap'                          => cs_value( false, 'style' ),
    'text_flex_justify'                       => cs_value( 'center', 'style' ),
    'text_flex_align'                         => cs_value( 'center', 'style' ),
    'text_content_margin'                     => cs_value( '!0px', 'style' ),
    'text_subheadline'                        => cs_value( false, 'all' ),
    'text_subheadline_content'                => cs_value( __( 'Subheadline space', '__x__' ), 'markup:html', true ),
    'text_subheadline_tag'                    => cs_value( 'span', 'markup', true ),
    'text_subheadline_spacing'                => cs_value( '0.35em', 'style' ),
    'text_subheadline_reverse'                => cs_value( false, 'all' ),
    'text_subheadline_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'text_subheadline_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'text_subheadline_font_size'              => cs_value( '1em', 'style' ),
    'text_subheadline_line_height'            => cs_value( '1.4', 'style' ),
    'text_subheadline_letter_spacing'         => cs_value( '0em', 'style' ),
    'text_subheadline_font_style'             => cs_value( 'normal', 'style' ),
    'text_subheadline_text_align'             => cs_value( 'none', 'style' ),
    'text_subheadline_text_decoration'        => cs_value( 'none', 'style' ),
    'text_subheadline_text_transform'         => cs_value( 'none', 'style' ),
    'text_subheadline_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'text_subheadline_text_color_alt'         => cs_value( '', 'style:color' ),
    'text_subheadline_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
    'text_subheadline_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'text_subheadline_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'graphic', 'text' ),
  cs_values( 'graphic:alt', 'text' ),
  cs_values( 'graphic:interactions', 'text' ),
  cs_values( array(
    'graphic_margin'         => cs_value( '0em 0.5em 0em 0em', 'style' ),
    'graphic_icon_color_alt' => cs_value( '', 'style:color' ),
  ), 'text' )
) );



// Anchor
// =============================================================================

cs_define_values( '_anchor-base', array(
  'anchor_type'                           => cs_value( 'button', 'all' ),
  'anchor_has_template'                   => cs_value( true, 'all' ),
  'anchor_has_link_control'               => cs_value( false, 'all' ),

  'anchor_base_font_size'                 => cs_value( '1em', 'style' ),
  'anchor_width'                          => cs_value( 'auto', 'style' ),
  'anchor_height'                         => cs_value( 'auto', 'style' ),
  'anchor_min_width'                      => cs_value( '0px', 'style' ),
  'anchor_min_height'                     => cs_value( '0px', 'style' ),
  'anchor_max_width'                      => cs_value( 'none', 'style' ),
  'anchor_max_height'                     => cs_value( 'none', 'style' ),
  'anchor_bg_color'                       => cs_value( 'transparent', 'style:color' ),
  'anchor_bg_color_alt'                   => cs_value( '', 'style:color' ),

  'anchor_margin'                         => cs_value( '!0em', 'style' ),
  'anchor_padding'                        => cs_value( '0.575em 0.85em 0.575em 0.85em', 'style' ),
  'anchor_border_width'                   => cs_value( '!0px', 'style' ),
  'anchor_border_style'                   => cs_value( 'solid', 'style' ),
  'anchor_border_color'                   => cs_value( 'transparent', 'style:color' ),
  'anchor_border_color_alt'               => cs_value( '', 'style:color' ),
  'anchor_border_radius'                  => cs_value( '!0em', 'style' ),

  'anchor_box_shadow_dimensions'          => cs_value( '!0em 0em 0em 0em', 'style' ),
  'anchor_box_shadow_color'               => cs_value( 'transparent', 'style:color' ),
  'anchor_box_shadow_color_alt'           => cs_value( '', 'style:color' ),

  'anchor_text'                           => cs_value( true, 'all' ),
  'anchor_text_margin'                    => cs_value( '5px', 'style' ),

  'anchor_primary_font_family'            => cs_value( 'inherit', 'style:font-family' ),
  'anchor_primary_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
  'anchor_primary_font_size'              => cs_value( '1em', 'style' ),
  'anchor_primary_letter_spacing'         => cs_value( '0em', 'style' ),
  'anchor_primary_line_height'            => cs_value( '1', 'style' ),
  'anchor_primary_font_style'             => cs_value( 'normal', 'style' ),
  'anchor_primary_text_align'             => cs_value( 'none', 'style' ),
  'anchor_primary_text_decoration'        => cs_value( 'none', 'style' ),
  'anchor_primary_text_transform'         => cs_value( 'none', 'style' ),
  'anchor_primary_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'anchor_primary_text_color_alt'         => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
  'anchor_primary_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
  'anchor_primary_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  'anchor_primary_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
) );


cs_define_values( '_anchor-template', cs_compose_values(
  array(
    'anchor_flex_direction'                   => cs_value( 'row', 'style' ),
    'anchor_flex_wrap'                        => cs_value( false, 'style' ),
    'anchor_flex_justify'                     => cs_value( 'center', 'style' ),
    'anchor_flex_align'                       => cs_value( 'center', 'style' ),

    'anchor_text_overflow'                    => cs_value( false, 'style' ),
    'anchor_text_interaction'                 => cs_value( 'none', 'markup' ),

    'anchor_text_reverse'                     => cs_value( false, 'all' ),
    'anchor_text_spacing'                     => cs_value( '0.35em', 'style' ),

    'anchor_text_primary_content'             => cs_value( __( 'Learn More', '__x__' ), 'all:html', true ),
    'anchor_text_secondary_content'           => cs_value( '', 'all:html', true ),

    'anchor_secondary_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'anchor_secondary_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'anchor_secondary_font_size'              => cs_value( '0.75em', 'style' ),
    'anchor_secondary_letter_spacing'         => cs_value( '0em', 'style' ),
    'anchor_secondary_line_height'            => cs_value( '1', 'style' ),
    'anchor_secondary_font_style'             => cs_value( 'normal', 'style' ),
    'anchor_secondary_text_align'             => cs_value( 'none', 'style' ),
    'anchor_secondary_text_decoration'        => cs_value( 'none', 'style' ),
    'anchor_secondary_text_transform'         => cs_value( 'none', 'style' ),
    'anchor_secondary_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_secondary_text_color_alt'         => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
    'anchor_secondary_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
    'anchor_secondary_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'anchor_secondary_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'particle', 'anchor_primary' ),
  cs_values( 'particle', 'anchor_secondary' ),
  cs_values( 'graphic', 'anchor' ),
  cs_values( 'graphic:alt', 'anchor' ),
  cs_values( 'graphic:interactions', 'anchor' )
) );


cs_define_values( '_anchor', cs_compose_values(
  '_anchor-base',
  '_anchor-template'
) );


cs_define_values( '_anchor-no-template', cs_compose_values(
  '_anchor-base',
  array(
    'anchor_has_template' => cs_value( false, 'all' ),
  )
) );


cs_define_values( 'anchor:link', array(
  'anchor_has_link_control' => cs_value( true, 'all' ), // 01
  'anchor_href'             => cs_value( '#', 'markup', true ),
  'anchor_info'             => cs_value( false, 'markup', true ),
  'anchor_blank'            => cs_value( false, 'markup', true ),
  'anchor_nofollow'         => cs_value( false, 'markup', true ),
) );


cs_define_values( 'anchor:share', array(
  'anchor_share_enabled' => cs_value( false, 'markup', true ),
  'anchor_share_type'    => cs_value( CS()->component( 'Social' )->get_default_share_type(), 'markup', true ),
  'anchor_share_title'   => cs_value( '', 'markup', true )
) );


cs_define_values( 'anchor:interactive-content', array(
  'anchor_interactive_content'                        => cs_value( true, 'all' ),
  'anchor_interactive_content_text_primary_content'   => cs_value( __( 'Discover Now', '__x__' ), 'all:html', true ),
  'anchor_interactive_content_text_secondary_content' => cs_value( __( 'We Have Answers', '__x__' ), 'all:html', true ),
  'anchor_interactive_content_interaction'            => cs_value( 'x-anchor-content-out-slide-top-in-scale-up', 'markup' ),
  'anchor_interactive_content_graphic_icon'           => cs_value( 'l-lightbulb-on', 'markup', true ),
  'anchor_interactive_content_graphic_icon_alt'       => cs_value( 'l-lightbulb-on', 'markup', true ),
  'anchor_interactive_content_graphic_image_src'      => cs_value( '', 'markup', true ),
  'anchor_interactive_content_graphic_image_alt'      => cs_value( '', 'markup', true ),
  'anchor_interactive_content_graphic_image_src_alt'  => cs_value( '', 'markup', true ),
  'anchor_interactive_content_graphic_image_alt_alt'  => cs_value( '', 'markup', true ),
) );


// Anchor: Button
// --------------

cs_define_values( 'anchor-button', cs_compose_values(
  '_anchor',
  'anchor:link',
  array(
    'anchor_bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'          => cs_value( '', 'style:color' ),
    'anchor_border_radius'         => cs_value( '0.35em', 'style' ),
    'anchor_box_shadow_dimensions' => cs_value( '0em 0.15em 0.65em 0em', 'style' ),
    'anchor_box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'  => cs_value( '', 'style:color' )
  )
) );


// Anchor: Menu Item
// -----------------

cs_define_values( 'menu-item', cs_compose_values(
  '_anchor',
  array(
    'anchor_type'                                 => cs_value( 'menu-item', 'all' ),
    'anchor_text_primary_content'                 => cs_value( 'on', 'all', true ),
    'anchor_text_secondary_content'               => cs_value( '', 'all', true ),
    'anchor_duration'                             => cs_value( '300ms', 'style' ),
    // 'anchor_delay'                                => cs_value( '0ms', 'style' ),
    'anchor_timing_function'                      => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'style' ),
    'anchor_sub_indicator'                        => cs_value( true, 'all' ),
    'anchor_sub_indicator_font_size'              => cs_value( '1em', 'style' ),
    'anchor_sub_indicator_width'                  => cs_value( 'auto', 'style' ),
    'anchor_sub_indicator_height'                 => cs_value( 'auto', 'style' ),
    'anchor_sub_indicator_icon'                   => cs_value( 'angle-down', 'markup' ),
    'anchor_sub_indicator_color'                  => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_sub_indicator_color_alt'              => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
    'anchor_sub_indicator_margin'                 => cs_value( '5px', 'style' ),
    'anchor_sub_indicator_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
    'anchor_sub_indicator_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'anchor_sub_indicator_text_shadow_color_alt'  => cs_value( '', 'style:color' ),
  ),
  cs_values( 'graphic:sourced-content', 'anchor' )
) );



// Toggle
// =============================================================================

cs_define_values( 'toggle', cs_compose_values(
  array(
    'toggle_type'           => cs_value( 'burger-1', 'all' ),
    'toggle_burger_size'    => cs_value( '0.1em', 'style' ),
    'toggle_burger_spacing' => cs_value( '3.25em', 'style' ),
    'toggle_burger_width'   => cs_value( '12em', 'style' ),
    'toggle_grid_size'      => cs_value( '0.25em', 'style' ),
    'toggle_grid_spacing'   => cs_value( '1.75em', 'style' ),
    'toggle_more_size'      => cs_value( '0.35em', 'style' ),
    'toggle_more_spacing'   => cs_value( '1.75em', 'style' ),
    'toggle_color'          => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'toggle_color_alt'      => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
  ),
  cs_values( '_anchor', 'toggle' ),
  cs_values( array(
    'anchor_type'                   => cs_value( 'toggle', 'all' ),
    'anchor_width'                  => cs_value( '2.75em', 'style' ),
    'anchor_height'                 => cs_value( '2.75em', 'style' ),
    'anchor_bg_color'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'anchor_bg_color_alt'           => cs_value( '', 'style:color' ),
    'anchor_padding'                => cs_value( '!0em', 'style' ),
    'anchor_border_radius'          => cs_value( '100em', 'style' ),
    'anchor_box_shadow_dimensions'  => cs_value( '0em 0.15em 0.65em 0em', 'style' ),
    'anchor_box_shadow_color'       => cs_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'anchor_box_shadow_color_alt'   => cs_value( '', 'style:color' ),
    'anchor_text'                   => cs_value( false, 'all' ),
    'anchor_graphic'                => cs_value( true, 'all' ),
    'anchor_graphic_has_toggle'     => cs_value( true, 'all' ),
    'anchor_graphic_type'           => cs_value( 'toggle', 'all' ),
    'anchor_text_primary_content'   => cs_value( '', 'all', true ),
    'anchor_text_secondary_content' => cs_value( '', 'all', true ),
    'anchor_custom_atts'            => cs_value( '', 'markup:raw' )
  ), 'toggle' )
) );


// Toggle: Cart
// ------------

cs_define_values( 'toggle-cart', cs_compose_values(
  'toggle',
  array(
    'toggle_anchor_graphic_type'            => cs_value( 'icon', 'all' ),
    'toggle_anchor_graphic_icon_alt_enable' => cs_value( false, 'markup' ),
    'toggle_anchor_graphic_icon_font_size'  => cs_value( '1em', 'style' ),
    'toggle_anchor_graphic_icon'            => cs_value( 'shopping-cart', 'markup' ),
    'toggle_anchor_graphic_icon_alt'        => cs_value( 'shopping-cart', 'markup' ),
  )
) );



// Cart
// =============================================================================

cs_define_values( 'cart', array(
  'cart_title'                           => cs_value( __( 'Your Items', '__x__' ), 'all', true ),
  'cart_order_items'                     => cs_value( '1', 'style' ),
  'cart_order_total'                     => cs_value( '2', 'style' ),
  'cart_order_buttons'                   => cs_value( '3', 'style' ),

  'cart_title_font_family'               => cs_value( 'inherit', 'style:font-family' ),
  'cart_title_font_weight'               => cs_value( 'inherit:400', 'style:font-weight' ),
  'cart_title_font_size'                 => cs_value( '2em', 'style' ),
  'cart_title_letter_spacing'            => cs_value( '-0.035em', 'style' ),
  'cart_title_line_height'               => cs_value( '1.1', 'style' ),
  'cart_title_font_style'                => cs_value( 'normal', 'style' ),
  'cart_title_text_align'                => cs_value( 'none', 'style' ),
  'cart_title_text_decoration'           => cs_value( 'none', 'style' ),
  'cart_title_text_transform'            => cs_value( 'none', 'style' ),
  'cart_title_text_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'cart_title_text_shadow_dimensions'    => cs_value( '!0px 0px 0px', 'style' ),
  'cart_title_text_shadow_color'         => cs_value( 'transparent', 'style:color' ),
  'cart_title_margin'                    => cs_value( '0px 0px 15px 0px', 'style' ),

  'cart_items_display_remove'            => cs_value( true, 'style' ),
  'cart_items_content_spacing'           => cs_value( '15px', 'style' ),
  'cart_items_bg'                        => cs_value( 'transparent', 'style:color' ),
  'cart_items_bg_alt'                    => cs_value( '', 'style:color' ),
  'cart_items_margin'                    => cs_value( '!0px', 'style' ),
  'cart_items_padding'                   => cs_value( '15px 0px 15px 0px', 'style' ),
  'cart_items_border_width'              => cs_value( '1px 0px 0px 0px', 'style' ),
  'cart_items_border_style'              => cs_value( 'solid', 'style' ),
  'cart_items_border_color'              => cs_value( 'rgba(0, 0, 0, 0.065) transparent transparent transparent', 'style:color' ),
  'cart_items_border_color_alt'          => cs_value( '', 'style:color' ),
  'cart_items_border_radius'             => cs_value( '!0px', 'style' ),
  'cart_items_box_shadow_dimensions'     => cs_value( '!0em 0em 0em 0em', 'style' ),
  'cart_items_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),
  'cart_items_box_shadow_color_alt'      => cs_value( '', 'style:color' ),

  'cart_thumbs_width'                    => cs_value( '70px', 'style' ),
  'cart_thumbs_border_radius'            => cs_value( '5px', 'style' ),
  'cart_thumbs_box_shadow_dimensions'    => cs_value( '0em 0.15em 1em 0em', 'style' ),
  'cart_thumbs_box_shadow_color'         => cs_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),

  'cart_links_font_family'               => cs_value( 'inherit', 'style:font-family' ),
  'cart_links_font_weight'               => cs_value( 'inherit:400', 'style:font-weight' ),
  'cart_links_font_size'                 => cs_value( '1em', 'style' ),
  'cart_links_letter_spacing'            => cs_value( '0em', 'style' ),
  'cart_links_line_height'               => cs_value( '1.4', 'style' ),
  'cart_links_font_style'                => cs_value( 'normal', 'style' ),
  'cart_links_text_align'                => cs_value( 'none', 'style' ),
  'cart_links_text_decoration'           => cs_value( 'none', 'style' ),
  'cart_links_text_transform'            => cs_value( 'none', 'style' ),
  'cart_links_text_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'cart_links_text_color_alt'            => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
  'cart_links_text_shadow_dimensions'    => cs_value( '!0px 0px 0px', 'style' ),
  'cart_links_text_shadow_color'         => cs_value( 'transparent', 'style:color' ),
  'cart_links_text_shadow_color_alt'     => cs_value( '', 'style:color' ),

  'cart_quantity_font_family'            => cs_value( 'inherit', 'style:font-family' ),
  'cart_quantity_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
  'cart_quantity_font_size'              => cs_value( '0.85em', 'style' ),
  'cart_quantity_letter_spacing'         => cs_value( '0em', 'style' ),
  'cart_quantity_line_height'            => cs_value( '1.9', 'style' ),
  'cart_quantity_font_style'             => cs_value( 'normal', 'style' ),
  'cart_quantity_text_align'             => cs_value( 'none', 'style' ),
  'cart_quantity_text_decoration'        => cs_value( 'none', 'style' ),
  'cart_quantity_text_transform'         => cs_value( 'none', 'style' ),
  'cart_quantity_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'cart_quantity_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
  'cart_quantity_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  'cart_total_bg'                        => cs_value( 'transparent', 'style:color' ),
  'cart_total_font_family'               => cs_value( 'inherit', 'style:font-family' ),
  'cart_total_font_weight'               => cs_value( 'inherit:400', 'style:font-weight' ),
  'cart_total_font_size'                 => cs_value( '1em', 'style' ),
  'cart_total_letter_spacing'            => cs_value( '0em', 'style' ),
  'cart_total_line_height'               => cs_value( '1', 'style' ),
  'cart_total_font_style'                => cs_value( 'normal', 'style' ),
  'cart_total_text_align'                => cs_value( 'center', 'style' ),
  'cart_total_text_decoration'           => cs_value( 'none', 'style' ),
  'cart_total_text_transform'            => cs_value( 'none', 'style' ),
  'cart_total_text_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'cart_total_text_shadow_dimensions'    => cs_value( '!0px 0px 0px', 'style' ),
  'cart_total_text_shadow_color'         => cs_value( 'transparent', 'style:color' ),
  'cart_total_margin'                    => cs_value( '!0px', 'style' ),
  'cart_total_padding'                   => cs_value( '10px 0px 10px 0px', 'style' ),
  'cart_total_border_width'              => cs_value( '1px 0px 1px 0px', 'style' ),
  'cart_total_border_style'              => cs_value( 'solid', 'style' ),
  'cart_total_border_color'              => cs_value( 'rgba(0, 0, 0, 0.065) transparent rgba(0, 0, 0, 0.065) transparent', 'style:color' ),
  'cart_total_border_radius'             => cs_value( '!0px', 'style' ),
  'cart_total_box_shadow_dimensions'     => cs_value( '!0em 0em 0em 0em', 'style' ),
  'cart_total_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),

  'cart_buttons_justify_content'         => cs_value( 'space-between', 'style' ),
  'cart_buttons_bg'                      => cs_value( 'transparent', 'style:color' ),
  'cart_buttons_margin'                  => cs_value( '15px 0px 0px 0px', 'style' ),
  'cart_buttons_padding'                 => cs_value( '!0px', 'style' ),
  'cart_buttons_border_width'            => cs_value( '!0px', 'style' ),
  'cart_buttons_border_style'            => cs_value( 'solid', 'style' ),
  'cart_buttons_border_color'            => cs_value( 'transparent', 'style:color' ),
  'cart_buttons_border_radius'           => cs_value( '!0px', 'style' ),
  'cart_buttons_box_shadow_dimensions'   => cs_value( '!0em 0em 0em 0em', 'style' ),
  'cart_buttons_box_shadow_color'        => cs_value( 'transparent', 'style:color' ),

  'cart_custom_atts'                     => cs_value( '', 'markup:raw' )
) );


cs_define_values( 'cart-button', cs_compose_values(
  cs_values( '_anchor-no-template', 'cart' ),
  cs_values( array(

    'anchor_base_font_size'                 => cs_value( '0.75em', 'style' ),
    'anchor_width'                          => cs_value( '47.5%', 'style' ),
    'anchor_max_width'                      => cs_value( 'none', 'style' ),
    'anchor_height'                         => cs_value( 'auto', 'style' ),
    'anchor_max_height'                     => cs_value( 'none', 'style' ),
    'anchor_bg_color'                       => cs_value( '#f5f5f5', 'style:color' ),
    'anchor_bg_color_alt'                   => cs_value( '', 'style:color' ),

    'anchor_primary_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'anchor_primary_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'anchor_primary_font_size'              => cs_value( '1em', 'style' ),
    'anchor_primary_letter_spacing'         => cs_value( '0.15em', 'style' ),
    'anchor_primary_line_height'            => cs_value( '1', 'style' ),
    'anchor_primary_font_style'             => cs_value( 'normal', 'style' ),
    'anchor_primary_text_align'             => cs_value( 'center', 'style' ),
    'anchor_primary_text_decoration'        => cs_value( 'none', 'style' ),
    'anchor_primary_text_transform'         => cs_value( 'uppercase', 'style' ),
    'anchor_primary_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_primary_text_color_alt'         => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ), // alt diff
    'anchor_primary_text_shadow_dimensions' => cs_value( '!0px 0px 0px', 'style' ),
    'anchor_primary_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),
    'anchor_primary_text_shadow_color_alt'  => cs_value( '', 'style:color' ),

    'anchor_margin'                         => cs_value( '!0em', 'style' ),
    'anchor_padding'                        => cs_value( '0.75em 1.25em 0.75em 1.25em', 'style' ),
    'anchor_border_width'                   => cs_value( '1px', 'style' ),
    'anchor_border_style'                   => cs_value( 'solid', 'style' ),
    'anchor_border_color'                   => cs_value( 'rgba(0, 0, 0, 0.065)', 'style:color' ),
    'anchor_border_color_alt'               => cs_value( '', 'style:color' ),
    'anchor_border_radius'                  => cs_value( '0.5em', 'style' ),

    'anchor_box_shadow_dimensions'          => cs_value( '0em 0.15em 0.5em 0em', 'style' ),
    'anchor_box_shadow_color'               => cs_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),
    'anchor_box_shadow_color_alt'           => cs_value( '', 'style:color' ),
  ), 'cart' )
) );



// Rating
// =============================================================================
// 'rating_empty' => cs_value( true, 'markup:html' ),

cs_define_values( 'rating', array(
  'rating'                               => cs_value( true, 'all' ),
  'rating_base_font_size'                => cs_value( '1em', 'style' ),
  'rating_value_content'                 => cs_value( 3.5, 'markup', true ),
  'rating_scale_min_content'             => cs_value( 0, 'markup', true ),
  'rating_scale_max_content'             => cs_value( 5, 'markup', true ),
  'rating_width'                         => cs_value( 'auto', 'style' ),
  'rating_max_width'                     => cs_value( 'none', 'style' ),
  'rating_bg_color'                      => cs_value( 'transparent', 'style:color' ),
  'rating_text'                          => cs_value( false, 'markup' ),
  'rating_schema'                        => cs_value( false, 'markup' ),
  'rating_empty'                         => cs_value( true, 'markup' ),
  'rating_round'                         => cs_value( false, 'markup' ),
  'rating_text_content'                  => cs_value( '{{rating}} / {{max}}', 'markup:raw', true ),

  'rating_schema_item_reviewed_type'     => cs_value( '', 'markup:raw', true ),
  'rating_schema_item_name_content'      => cs_value( '', 'markup:raw', true ),
  'rating_schema_item_telephone_content' => cs_value( '', 'markup:raw', true ),
  'rating_schema_item_address_content'   => cs_value( '', 'markup:raw', true ),
  'rating_schema_item_image_src'         => cs_value( '', 'markup:raw', true ),
  'rating_schema_author_content'         => cs_value( '', 'markup:raw', true ),
  'rating_schema_review_body_content'    => cs_value( '', 'markup:raw', true ),

  'rating_graphic_type'                  => cs_value( 'icon', 'all', true ),
  'rating_graphic_spacing'               => cs_value( '2px', 'style' ),
  'rating_graphic_full_icon'             => cs_value( 'star', 'markup', true ),
  'rating_graphic_half_icon'             => cs_value( 'star-half-alt', 'markup', true ),
  'rating_graphic_empty_icon'            => cs_value( 'o-star', 'markup', true ),
  'rating_graphic_icon_color'            => cs_value( '#f39c12', 'style:color' ),
  'rating_graphic_full_image_src'        => cs_value( '', 'markup', true ),
  'rating_graphic_half_image_src'        => cs_value( '', 'markup', true ),
  'rating_graphic_empty_image_src'       => cs_value( '', 'markup', true ),
  'rating_graphic_image_max_width'       => cs_value( '32px', 'style' ),

  'rating_flex_direction'                => cs_value( 'row', 'style' ),
  'rating_flex_wrap'                     => cs_value( false, 'style' ),
  'rating_flex_justify'                  => cs_value( 'flex-start', 'style' ),
  'rating_flex_align'                    => cs_value( 'center', 'style' ),

  'rating_margin'                        => cs_value( '!0em', 'style' ),
  'rating_border_width'                  => cs_value( '!0px', 'style' ),
  'rating_border_style'                  => cs_value( 'solid', 'style' ),
  'rating_border_color'                  => cs_value( 'transparent', 'style:color' ),
  'rating_border_radius'                 => cs_value( '!0px', 'style' ),
  'rating_padding'                       => cs_value( '!0em', 'style' ),
  'rating_box_shadow_dimensions'         => cs_value( '!0em 0em 0em 0em', 'style' ),
  'rating_box_shadow_color'              => cs_value( 'transparent', 'style:color' ),

  'rating_text_margin'                   => cs_value( '0em 0em 0em 0.35em', 'style' ),
  'rating_font_family'                   => cs_value( 'inherit', 'style:font-family' ),
  'rating_font_weight'                   => cs_value( 'inherit:400', 'style:font-weight' ),
  'rating_font_size'                     => cs_value( '1em', 'style' ),
  'rating_letter_spacing'                => cs_value( '0em', 'style' ),
  'rating_line_height'                   => cs_value( '1.6', 'style' ),
  'rating_font_style'                    => cs_value( 'normal', 'style' ),
  'rating_text_align'                    => cs_value( 'none', 'style' ),
  'rating_text_decoration'               => cs_value( 'none', 'style' ),
  'rating_text_transform'                => cs_value( 'none', 'style' ),
  'rating_text_color'                    => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'rating_text_shadow_dimensions'        => cs_value( '!0px 0px 0px', 'style' ),
  'rating_text_shadow_color'             => cs_value( 'transparent', 'style:color' ),
  'rating_text_shadow_color_alt'         => cs_value( '', 'style:color' ),
) );



// Pagination
// =============================================================================

cs_define_values( '_pagination-numbered', array(
  'pagination_numbered_hide'     => cs_value( 'md', 'all' ),
  'pagination_numbered_end_size' => cs_value( 1, 'markup' ),
  'pagination_numbered_mid_size' => cs_value( 2, 'markup' ),
) );

cs_define_values( '_pagination-base', array(
  'pagination_base_font_size'                 => cs_value( '1em', 'style' ),
  'pagination_width'                          => cs_value( 'auto', 'style' ),
  'pagination_max_width'                      => cs_value( 'none', 'style' ),
  'pagination_bg_color'                       => cs_value( 'transparent', 'style:color' ),

  'pagination_flex_justify'                   => cs_value( 'flex-start', 'style' ),
  'pagination_reverse'                        => cs_value( false, 'style' ),

  'pagination_margin'                         => cs_value( '!0em', 'style' ),
  'pagination_padding'                        => cs_value( '!0em', 'style' ),
  'pagination_border_width'                   => cs_value( '!0px', 'style' ),
  'pagination_border_style'                   => cs_value( 'solid', 'style' ),
  'pagination_border_color'                   => cs_value( 'transparent', 'style:color' ),
  'pagination_border_radius'                  => cs_value( '!0px', 'style' ),
  'pagination_box_shadow_dimensions'          => cs_value( '!0em 0em 0em 0em', 'style' ),
  'pagination_box_shadow_color'               => cs_value( 'transparent', 'style:color' ),

  'pagination_items_prev_next_type'           => cs_value( 'icon', 'markup' ),
  'pagination_items_prev_text'                => cs_value( 'Prev', 'markup' ),
  'pagination_items_next_text'                => cs_value( 'Next', 'markup' ),
  'pagination_items_prev_icon'                => cs_value( 'o-arrow-left', 'markup' ),
  'pagination_items_next_icon'                => cs_value( 'o-arrow-right', 'markup' ),
  'pagination_items_min_width'                => cs_value( '3em', 'style' ),
  'pagination_items_min_height'               => cs_value( '3em', 'style' ),
  'pagination_items_gap'                      => cs_value( '6px', 'style' ),
  'pagination_items_grow'                     => cs_value( false, 'style' ),
  'pagination_items_bg_color'                 => cs_value( 'rgba(0, 0, 0, 0.075)', 'style:color' ),
  'pagination_items_bg_color_alt'             => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ), // alt diff
  'pagination_items_padding'                  => cs_value( '0.8em 1em 0.8em 1em', 'style' ),
  'pagination_items_border_width'             => cs_value( '!0px', 'style' ),
  'pagination_items_border_style'             => cs_value( 'solid', 'style' ),
  'pagination_items_border_color'             => cs_value( 'transparent', 'style:color' ),
  'pagination_items_border_color_alt'         => cs_value( '', 'style:color' ),
  'pagination_items_border_radius'            => cs_value( '100em', 'style' ),
  'pagination_items_box_shadow_dimensions'    => cs_value( '0px 0px 0px 2px', 'style' ),
  'pagination_items_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),
  'pagination_items_box_shadow_color_alt'     => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ), // alt diff
  'pagination_items_font_family'              => cs_value( 'inherit', 'style:font-family' ),
  'pagination_items_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
  'pagination_items_font_size'                => cs_value( '1em', 'style' ),
  'pagination_items_font_style'               => cs_value( 'normal', 'style' ),
  'pagination_items_text_color'               => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'pagination_items_text_color_alt'           => cs_value( '', 'style:color' ),

  'pagination_current_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'pagination_current_border_color'           => cs_value( 'transparent', 'style:color' ),
  'pagination_current_box_shadow_color'       => cs_value( 'transparent', 'style:color' ),
  'pagination_current_bg_color'               => cs_value( 'rgba(0, 0, 0, 0.3)', 'style:color' ),

  'pagination_dots'                           => cs_value( false, 'style' ),
  'pagination_dots_text_color'                => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  'pagination_dots_border_color'              => cs_value( 'transparent', 'style:color' ),
  'pagination_dots_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),
  'pagination_dots_bg_color'                  => cs_value( 'transparent', 'style:color' ),

  'pagination_prev_next'                      => cs_value( false, 'style' ),
  'pagination_prev_next_text_color'           => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'pagination_prev_next_text_color_alt'       => cs_value( '', 'style:color' ),
  'pagination_prev_next_border_color'         => cs_value( 'transparent', 'style:color' ),
  'pagination_prev_next_border_color_alt'     => cs_value( '', 'style:color' ),
  'pagination_prev_next_box_shadow_color'     => cs_value( 'transparent', 'style:color' ),
  'pagination_prev_next_box_shadow_color_alt' => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ), // alt diff
  'pagination_prev_next_bg_color'             => cs_value( 'rgba(0, 0, 0, 0.85)', 'style:color' ),
  'pagination_prev_next_bg_color_alt'         => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ), // alt diff
) );

cs_define_values( 'pagination:comment', cs_compose_values(
  array(
    'pagination_type' => cs_value( 'comment', 'all' ),
  ),
  '_pagination-numbered',
  '_pagination-base'
) );

cs_define_values( 'pagination:post', cs_compose_values(
  array(
    'pagination_type' => cs_value( 'post', 'all' ),
  ),
  '_pagination-numbered',
  '_pagination-base'
) );

cs_define_values( 'pagination:product', cs_compose_values(
  array(
    'pagination_type' => cs_value( 'product', 'all' ),
  ),
  '_pagination-numbered',
  '_pagination-base'
) );

cs_define_values( 'pagination:post-nav', cs_compose_values(
  array(
    'pagination_type' => cs_value( 'post-nav', 'all' ),
  ),
  '_pagination-base'
) );



// Products
// =============================================================================

cs_define_values( '_products-base', array(
  'products_count'   => cs_value( 2, 'markup' ),
  'products_columns' => cs_value( 2, 'markup' ),
  'products_orderby' => cs_value( 'rand', 'markup' ),
  'products_order'   => cs_value( 'desc', 'markup' ),
  'products_margin'  => cs_value( '!0em', 'style' ),
) );

cs_define_values( 'products:main-loop', cs_compose_values(
  array(
    'products_type' => cs_value( 'main-loop', 'all' ),
  ),
  '_products-base'
) );

cs_define_values( 'products:cross-sells', cs_compose_values(
  array(
    'products_type' => cs_value( 'cross-sells', 'all' ),
  ),
  '_products-base'
) );

cs_define_values( 'products:related-products', cs_compose_values(
  array(
    'products_type' => cs_value( 'related', 'all' ),
  ),
  '_products-base'
) );

cs_define_values( 'products:upsells', cs_compose_values(
  array(
    'products_type' => cs_value( 'upsells', 'all' ),
  ),
  '_products-base'
) );



// Effects
// =============================================================================

cs_define_values( 'effects', array(
  'effects_opacity'            => cs_value( '1', 'style' ),
  'effects_filter'             => cs_value( '', 'style' ),
  'effects_transform'          => cs_value( '', 'style' ),
  'effects_transform_origin'   => cs_value( '50% 50%', 'style' ),
  // 'effects_perspective'        => cs_value( '0px', 'style' ),
  // 'effects_perspective_origin' => cs_value( 'center', 'style' ),
  'effects_duration'           => cs_value( '300ms', 'style' ),
  // 'effects_delay'              => cs_value( '0ms', 'style' ),
  'effects_mix_blend_mode'     => cs_value( 'normal', 'style' ),
  'effects_backdrop_filter'    => cs_value( '', 'style' ),
  'effects_timing_function'    => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'style' ),
) );


cs_define_values( 'effects:provider', array(
  'effects_provider'         => cs_value( false, 'all' ),
  'effects_provider_targets' => cs_value( 'colors particles effects', 'all' ),
) );


cs_define_values( 'effects:alt', array(
  'effects_alt'                           => cs_value( false, 'all' ),

  'effects_type_alt'                      => cs_value( 'transform', 'all' ),
  'effects_opacity_alt'                   => cs_value( '1', 'style' ),
  'effects_filter_alt'                    => cs_value( '', 'style' ),
  'effects_animation_alt'                 => cs_value( 'tada', 'all' ),
  'effects_transform_alt'                 => cs_value( '', 'style' ),

  'effects_duration_animation_alt'        => cs_value( '1000ms', 'style' ),
  // 'effects_delay_animation_alt'           => cs_value( '0ms', 'style' ),
  'effects_timing_function_animation_alt' => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'style' ),
) );


cs_define_values( 'effects:scroll', array(
  'effects_scroll'                 => cs_value( false, 'all' ),
  'effects_type_scroll'            => cs_value( 'transform', 'all' ),

  'effects_opacity_enter'          => cs_value( '1', 'style' ),
  'effects_filter_enter'           => cs_value( '', 'style' ),
  'effects_animation_enter'        => cs_value( 'rollIn', 'all' ),
  'effects_transform_enter'        => cs_value( 'translate(0px, 0px)', 'style' ),

  'effects_opacity_exit'           => cs_value( '0', 'style' ),
  'effects_filter_exit'            => cs_value( '', 'style' ),
  'effects_animation_exit'         => cs_value( 'rollOut', 'all' ),
  'effects_transform_exit'         => cs_value( 'translate(0px, 1rem)', 'style' ),

  'effects_offset_top'             => cs_value( '10%', 'all' ),
  'effects_offset_bottom'          => cs_value( '10%', 'all' ),

  'effects_behavior_scroll'        => cs_value( 'fire-once', 'all' ), // in-n-out, reset, fire-once

  'effects_duration_scroll'        => cs_value( '1000ms', 'style' ),
  'effects_delay_scroll'           => cs_value( '0ms', 'style' ),
  'effects_timing_function_scroll' => cs_value( 'cubic-bezier(0.400, 0.000, 0.200, 1.000)', 'style' ),
) );



// Omega
// =============================================================================
// 01. Element CSS.
// 02. Hide by breakpoint. The core decorator will automatically update the
//     class value for you.
// 03. Inline style attribute.

cs_define_values( 'omega', array(
  'id'             => cs_value( '', 'markup' ),
  'class'          => cs_value( '', 'markup' ),
  'css'            => cs_value( '', 'css' ), // 01
  'hide_bp'        => cs_value( '', 'markup' ), // 02
  'show_condition' => cs_value( '', 'markup:raw' )
) );

cs_define_values( 'omega:style', array(
  'style' => cs_value( '', 'attr' ) // 03
) );

cs_define_values( 'omega:toggle-hash', array(
  'toggle_hash' => cs_value( '', 'attr' )
) );

cs_define_values( 'omega:custom-atts', array(
  'custom_atts' => cs_value( '', 'markup:raw' )
) );

cs_define_values( 'omega:looper-provider', array(
  'looper_provider'                      => cs_value( false, 'markup:raw' ),
  'looper_provider_type'                 => cs_value( 'query-recent', 'markup:raw' ),

  'looper_provider_query_string'         => cs_value( '', 'markup:raw' ),
  'looper_provider_query_mode'           => cs_value( 'types', 'markup:raw' ),
  'looper_provider_query_post_types'     => cs_value( ['post'], 'markup:raw' ),
  'looper_provider_query_post_in'        => cs_value( true, 'markup:raw' ),
  'looper_provider_query_post_ids'       => cs_value( '', 'markup:raw' ),

  'looper_provider_query_term_and'       => cs_value( false, 'markup:raw' ),
  'looper_provider_query_term_in'        => cs_value( true, 'markup:raw' ),
  'looper_provider_query_term_ids'       => cs_value( '', 'markup:raw' ),

  'looper_provider_query_author_in'      => cs_value( true, 'markup:raw' ),
  'looper_provider_query_author_ids'     => cs_value( '', 'markup:raw' ),

  'looper_provider_query_before'         => cs_value( '', 'markup:raw' ),
  'looper_provider_query_after'          => cs_value( '', 'markup:raw' ),
  'looper_provider_query_count'          => cs_value( '', 'markup:raw' ),
  'looper_provider_query_order'          => cs_value( 'DESC', 'markup:raw' ),
  'looper_provider_query_orderby'        => cs_value( 'date', 'markup:raw' ),
  'looper_provider_query_include_sticky' => cs_value( false, 'markup:raw' ),

  'looper_provider_terms_tax'            => cs_value( 'category', 'markup:raw' ),
  'looper_provider_custom_schema'        => cs_value( '', 'markup:raw' ),
  'looper_provider_custom_values'        => cs_value( '', 'markup:raw' ),
  'looper_provider_json'                 => cs_value( '', 'markup:raw' ),
  'looper_provider_filter'               => cs_value( '', 'markup:raw' )
) );

cs_define_values( 'omega:looper-consumer', array(
  'looper_consumer'              => cs_value( false, 'markup:raw' ),
  'looper_consumer_repeat'       => cs_value( '-1', 'markup:raw' ), // -1 for all
) );
