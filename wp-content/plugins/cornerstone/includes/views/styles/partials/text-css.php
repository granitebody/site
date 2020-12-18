<?php

// =============================================================================
// _TEXT-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Standard
//   03. Headline
// =============================================================================

// Setup
// =============================================================================

$selector   = ( isset( $selector ) && $selector != ''     ) ? $selector         : '.x-text';
$key_prefix = ( isset( $key_prefix ) && $key_prefix != '' ) ? $key_prefix . '_' : '';


// Appearance
// ----------

$data_border = array(
  'width'  => $key_prefix . 'text_border_width',
  'style'  => $key_prefix . 'text_border_style',
  'base'   => $key_prefix . 'text_border_color',
  'alt'    => $key_prefix . 'text_border_color_alt',
  'radius' => $key_prefix . 'text_border_radius',
);

$data_background_color = array(
  'type' => 'background',
  'base' => $key_prefix . 'text_bg_color',
  'alt'  => $key_prefix . 'text_bg_color_alt',
);

$data_box_shadow = array(
  'type'       => 'box',
  'dimensions' => $key_prefix . 'text_box_shadow_dimensions',
  'base'       => $key_prefix . 'text_box_shadow_color',
  'alt'        => $key_prefix . 'text_box_shadow_color_alt',
);


// Content
// -------

$data_linotype = array(
  'ff'       => $key_prefix . 'text_font_family',
  'fsize'    => $key_prefix . 'text_font_size',
  'fstyle'   => $key_prefix . 'text_font_style',
  'fw'       => $key_prefix . 'text_font_weight',
  'lh'       => $key_prefix . 'text_line_height',
  'ls'       => $key_prefix . 'text_letter_spacing',
  'ta'       => $key_prefix . 'text_text_align',
  'td'       => $key_prefix . 'text_text_decoration',
  'tt'       => $key_prefix . 'text_text_transform',
  'ls_force' => true,
  'tt_force' => true,
);

$data_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'text_text_color',
  'alt'  => $key_prefix . 'text_text_color_alt',
);

$data_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'text_text_shadow_dimensions',
  'base'       => $key_prefix . 'text_text_shadow_color',
  'alt'        => $key_prefix . 'text_text_shadow_color_alt',
);

$data_subheadline_linotype = array(
  'ff'            => $key_prefix . 'text_subheadline_font_family',
  'fsize'         => $key_prefix . 'text_subheadline_font_size',
  'fstyle'        => $key_prefix . 'text_subheadline_font_style',
  'fw'            => $key_prefix . 'text_subheadline_font_weight',
  'lh'            => $key_prefix . 'text_subheadline_line_height',
  'ls'            => $key_prefix . 'text_subheadline_letter_spacing',
  'ta'            => $key_prefix . 'text_subheadline_text_align',
  'td'            => $key_prefix . 'text_subheadline_text_decoration',
  'tt'            => $key_prefix . 'text_subheadline_text_transform',
  'ls_force'      => true,
  'ls_has_offset' => true,
  'tt_force'      => true,
);

$data_subheadline_color = array(
  'type' => 'color',
  'base' => $key_prefix . 'text_subheadline_text_color',
  'alt'  => $key_prefix . 'text_subheadline_text_color_alt',
);

$data_subheadline_text_shadow = array(
  'type'       => 'text',
  'dimensions' => $key_prefix . 'text_subheadline_text_shadow_dimensions',
  'base'       => $key_prefix . 'text_subheadline_text_shadow_color',
  'alt'        => $key_prefix . 'text_subheadline_text_shadow_color_alt',
);



// Standard
// =============================================================================

?>

@if $text_type === 'standard' {

  <?php

  // Base
  // ----

  ?>

  .$_el<?php echo $selector; ?> {
    @if $<?php echo $key_prefix; ?>text_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>text_width;
    }
    @unless $<?php echo $key_prefix; ?>text_max_width?? {
      max-width: $<?php echo $key_prefix; ?>text_max_width;
    }
    @unless $<?php echo $key_prefix; ?>text_margin?? {
      margin: $<?php echo $key_prefix; ?>text_margin;
    }
    <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
    @unless $<?php echo $key_prefix; ?>text_padding?? {
      padding: $<?php echo $key_prefix; ?>text_padding;
    }
    <?php
    echo cs_get_partial_style( '_linotype', $data_linotype );
    echo cs_get_partial_style( '_shadow-base', $data_text_shadow );
    echo cs_get_partial_style( '_color-base', $data_color );
    echo cs_get_partial_style( '_color-base', $data_background_color );
    echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
    ?>
    @if $<?php echo $key_prefix; ?>text_columns === true {
      -webkit-columns: $<?php echo $key_prefix; ?>text_columns_width $<?php echo $key_prefix; ?>text_columns_count;
              columns: $<?php echo $key_prefix; ?>text_columns_width $<?php echo $key_prefix; ?>text_columns_count;
      -webkit-column-gap: $<?php echo $key_prefix; ?>text_columns_gap;
              column-gap: $<?php echo $key_prefix; ?>text_columns_gap;
      -webkit-column-rule: $<?php echo $key_prefix; ?>text_columns_rule_width $<?php echo $key_prefix; ?>text_columns_rule_style $<?php echo $key_prefix; ?>text_columns_rule_color;
              column-rule: $<?php echo $key_prefix; ?>text_columns_rule_width $<?php echo $key_prefix; ?>text_columns_rule_style $<?php echo $key_prefix; ?>text_columns_rule_color;
    }
  }

  .$_el<?php echo $selector; ?> > :first-child { margin-top: 0;    }
  .$_el<?php echo $selector; ?> > :last-child  { margin-bottom: 0; }


  <?php

  // Column Content Breaking
  // -----------------------
  // Prevents direct children of the text element from breaking in half when
  // using column layouts.

  ?>

  @if $<?php echo $key_prefix; ?>text_columns === true && $<?php echo $key_prefix; ?>text_columns_break_inside === 'avoid' {
    .$_el<?php echo $selector; ?> > * {
      -webkit-column-break-inside: avoid;
                page-break-inside: avoid;
                     break-inside: avoid;
    }
  }


  <?php

  // :hover
  // ------

  ?>

  .$_el<?php echo $selector; ?>:hover,
  .$_el<?php echo $selector; ?>[class*="active"],
  [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> {
    <?php
    echo cs_get_partial_style( '_color-alt', $data_color );
    echo cs_get_partial_style( '_border-alt', $data_border );
    echo cs_get_partial_style( '_color-alt', $data_background_color );
    echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
    echo cs_get_partial_style( '_shadow-alt', $data_text_shadow );
    ?>
    @if $<?php echo $key_prefix; ?>text_columns === true {
      @unless $<?php echo $key_prefix; ?>text_columns_rule_color_alt LIKE '%transparent%' || $<?php echo $key_prefix; ?>text_columns_rule_color_alt === '' && $<?php echo $key_prefix; ?>text_columns_rule_color_alt !== $<?php echo $key_prefix; ?>text_columns_rule_color {
        -webkit-column-rule: $<?php echo $key_prefix; ?>text_columns_rule_width $<?php echo $key_prefix; ?>text_columns_rule_style $<?php echo $key_prefix; ?>text_columns_rule_color_alt;
                column-rule: $<?php echo $key_prefix; ?>text_columns_rule_width $<?php echo $key_prefix; ?>text_columns_rule_style $<?php echo $key_prefix; ?>text_columns_rule_color_alt;
      }
    }
  }

}



<?php

// Headline
// =============================================================================

?>

@if $<?php echo $key_prefix; ?>text_type === 'headline' {

  <?php

  // Base
  // ----

  ?>

  .$_el<?php echo $selector; ?> {
    @if $<?php echo $key_prefix; ?>text_width !== 'auto' {
      width: $<?php echo $key_prefix; ?>text_width;
    }
    @unless $<?php echo $key_prefix; ?>text_max_width?? {
      max-width: $<?php echo $key_prefix; ?>text_max_width;
    }
    @unless $<?php echo $key_prefix; ?>text_margin?? {
      margin: $<?php echo $key_prefix; ?>text_margin;
    }
    <?php echo cs_get_partial_style( '_border-base', $data_border ); ?>
    @unless $<?php echo $key_prefix; ?>text_padding?? {
      padding: $<?php echo $key_prefix; ?>text_padding;
    }
    font-size: $<?php echo $key_prefix; ?>text_base_font_size;
    <?php
    echo cs_get_partial_style( '_color-base', $data_background_color );
    echo cs_get_partial_style( '_shadow-base', $data_box_shadow );
    ?>
  }

  .$_el<?php echo $selector; ?>:hover,
  .$_el<?php echo $selector; ?>[class*="active"],
  [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> {
    <?php
    echo cs_get_partial_style( '_color-alt', $data_border );
    echo cs_get_partial_style( '_color-alt', $data_background_color );
    echo cs_get_partial_style( '_shadow-alt', $data_box_shadow );
    ?>
  }


  <?php

  // Content
  // -------
  // Contains the optional graphic as well as text content (which will always
  // have the main headline, along with an optional subheadline).

  ?>

  .$_el<?php echo $selector; ?> .x-text-content {
    @if $<?php echo $key_prefix; ?>text_graphic === true {
      flex-direction: $<?php echo $key_prefix; ?>text_flex_direction;
      justify-content: $<?php echo $key_prefix; ?>text_flex_justify;
      align-items: $<?php echo $key_prefix; ?>text_flex_align;
      @if $<?php echo $key_prefix; ?>text_flex_wrap === true {
        flex-wrap: wrap;
        align-content: $<?php echo $key_prefix; ?>text_flex_align;
      }
    }
  }


  <?php

  // Text Content
  // ------------
  // The container for the headline's text content (the main text along with
  // the optional subheadline).

  ?>

  .$_el<?php echo $selector; ?> .x-text-content-text {
    @if $<?php echo $key_prefix; ?>text_graphic === true && $<?php echo $key_prefix; ?>text_overflow === true && $<?php echo $key_prefix; ?>text_flex_direction === 'column' {
      width: 100%;
    }
    @unless $<?php echo $key_prefix; ?>text_content_margin?? {
      margin: $<?php echo $key_prefix; ?>text_content_margin;
    }
  }


  <?php

  // Headline Text
  // -------------
  // The primary headline text.

  ?>

  .$_el<?php echo $selector; ?> .x-text-content-text-primary {
    <?php
    echo cs_get_partial_style( '_linotype', array_merge( $data_linotype, array( 'ls_has_offset' => true ) ) );
    echo cs_get_partial_style( '_color-base', $data_color );
    echo cs_get_partial_style( '_shadow-base', $data_text_shadow );
    ?>
    @if $<?php echo $key_prefix; ?>text_overflow === true {
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }
  }

  .$_el<?php echo $selector; ?>:hover .x-text-content-text-primary,
  .$_el<?php echo $selector; ?>[class*="active"] .x-text-content-text-primary,
  [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> .x-text-content-text-primary {
    <?php
    echo cs_get_partial_style( '_color-alt', $data_color );
    echo cs_get_partial_style( '_shadow-alt', $data_text_shadow );
    ?>
  }


  <?php

  // Text Typing
  // -----------
  // The text typing effect.

  ?>

  @if $<?php echo $key_prefix; ?>text_typing === true {
    @unless $<?php echo $key_prefix; ?>text_typing_color === 'inherit' {
      .$_el<?php echo $selector; ?> .x-text-typing {
        color: $<?php echo $key_prefix; ?>text_typing_color;
      }
    }

    @unless $<?php echo $key_prefix; ?>text_typing_color_alt?? || $<?php echo $key_prefix; ?>text_typing_color_alt === $<?php echo $key_prefix; ?>text_typing_color {
      [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> .x-text-typing,
      .$_el<?php echo $selector; ?>:hover .x-text-typing {
        color: $<?php echo $key_prefix; ?>text_typing_color_alt;
      }
    }

    @if $<?php echo $key_prefix; ?>text_typing_cursor === true {
      @unless $<?php echo $key_prefix; ?>text_typing_cursor_color === 'inherit' {
        .$_el<?php echo $selector; ?> .typed-cursor {
          color: $<?php echo $key_prefix; ?>text_typing_cursor_color;
        }
      }

      @unless $<?php echo $key_prefix; ?>text_typing_cursor_color_alt?? || $<?php echo $key_prefix; ?>text_typing_cursor_color_alt === $<?php echo $key_prefix; ?>text_typing_cursor_color {
        .$_el<?php echo $selector; ?>:hover .typed-cursor,
        .$_el<?php echo $selector; ?>:focus .typed-cursor,
        .$_el<?php echo $selector; ?>[class*="active"] .typed-cursor,
        [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> .typed-cursor,
        [data-x-effect-provider*="colors"]:focus .$_el<?php echo $selector; ?> .typed-cursor {
          color: $<?php echo $key_prefix; ?>text_typing_cursor_color_alt;
        }
      }
    }
  }


  <?php

  // Subheadline Text
  // ----------------
  // The subheadline headline text.

  ?>

  @if $<?php echo $key_prefix; ?>text_subheadline === true {
    .$_el<?php echo $selector; ?> .x-text-content-text-subheadline {
      @if $<?php echo $key_prefix; ?>text_subheadline_reverse === false {
        margin-top: $<?php echo $key_prefix; ?>text_subheadline_spacing;
      }
      @if $<?php echo $key_prefix; ?>text_subheadline_reverse === true {
        margin-bottom: $<?php echo $key_prefix; ?>text_subheadline_spacing;
      }
      <?php
      echo cs_get_partial_style( '_linotype', $data_subheadline_linotype );
      echo cs_get_partial_style( '_shadow-base', $data_subheadline_text_shadow );
      echo cs_get_partial_style( '_color-base', $data_subheadline_color );
      ?>
      @if $<?php echo $key_prefix; ?>text_overflow === true {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
      }
    }

    .$_el<?php echo $selector; ?>:hover .x-text-content-text-subheadline,
    .$_el<?php echo $selector; ?>[class*="active"] .x-text-content-text-subheadline,
    [data-x-effect-provider*="colors"]:hover .$_el<?php echo $selector; ?> .x-text-content-text-subheadline {
      <?php echo cs_get_partial_style( '_color-alt', $data_subheadline_color ); ?>
      <?php echo cs_get_partial_style( '_shadow-alt', $data_subheadline_text_shadow ); ?>
    }
  }


  <?php

  // Graphic
  // -------
  // The optional graphic output.

  ?>

  @if $<?php echo $key_prefix; ?>text_graphic === true {

    <?php

    echo cs_get_partial_style( 'graphic', array(
      'no_base'    => false,
      'selector'   => $selector,
      'key_prefix' => $key_prefix . 'text'
    ) );

    ?>

  }

}
