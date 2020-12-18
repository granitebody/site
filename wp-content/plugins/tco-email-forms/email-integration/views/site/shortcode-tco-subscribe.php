<?php

// =============================================================================
// EMAIL-INTEGRATION/SITE/SHORTCODE-X-SUBSCRIBE.PHP
// -----------------------------------------------------------------------------
// Shortcode output.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTSBut Wait, There's More!
// -----------------------------------------------------------------------------
//   01. Form Output
//   02. Shortcode Setup
//   03. Shortcode Output
// =============================================================================

// Form Output
// =============================================================================

//
// Confirmation data.
//

if ( $confirmation_type == 'Message' ) {
  $confirmation_data = 'data-tco-email-message="' . $confirmation_message . '"';
} else if ( $confirmation_type == 'Redirect' ) {
  $confirmation_data = 'data-tco-email-redirect="' . $confirmation_redirect . '"';
}


//
// Button style.
//

if ( $custom_styling == 'Yes' ) {
  switch ( $button_style ) {
    case '3D' :
      $style = ' x-btn x-btn-real';
      break;
    case 'Flat' :
      $style = ' x-btn x-btn-flat';
      break;
    case 'Transparent' :
      $style = ' x-btn x-btn-transparent';
      break;
  }
} else {
  $style = '';
}


//
// Button shape.
//

if ( $custom_styling == 'Yes' ) {
  switch ( $button_shape ) {
    case 'Square' :
      $shape = ' x-btn-square';
      break;
    case 'Rounded' :
      $shape = ' x-btn-rounded';
      break;
    case 'Pill' :
      $shape = ' x-btn-pill';
      break;
  }
} else {
  $shape = '';
}


//
// Button colors.
//

switch ( $button_style ) {
  case '3D' :
    $button_colors       = 'color: ' . $button_text_color . '; border-color: ' . $button_border_color . '; background-color: ' . $button_bg_color . '; box-shadow: 0 0.25em 0 0 ' . $button_bottom_color . ', 0 4px 9px rgba(0, 0, 0, 0.75);';
    $button_colors_hover = 'color: ' . $button_text_color_hover . '; border-color: ' . $button_border_color_hover . '; background-color: ' . $button_bg_color_hover . '; box-shadow: 0 0.25em 0 0 ' . $button_bottom_color_hover . ', 0 4px 9px rgba(0, 0, 0, 0.75);';
    break;
  case 'Flat' :
    $button_colors       = 'color: ' . $button_text_color . '; border-color: ' . $button_border_color . '; background-color: ' . $button_bg_color . ';';
    $button_colors_hover = 'color: ' . $button_text_color_hover . '; border-color: ' . $button_border_color_hover . '; background-color: ' . $button_bg_color_hover . ';';
    break;
  case 'Transparent' :
    $button_colors       = 'color: ' . $button_text_color . '; border-color: ' . $button_border_color . ';';
    $button_colors_hover = 'color: ' . $button_text_color_hover . '; border-color: ' . $button_border_color_hover . ';';
    break;
}



ob_start();

?>

<form method="post" id="tco-subscribe-form-<?php echo $form_id; ?>" class="tco-subscribe-form tco-subscribe-form-<?php echo $form_id; ?> center-block mvn" data-tco-email-confirm="<?php echo $confirmation_type; ?>" <?php echo $confirmation_data; ?> style="max-width: <?php echo $max_width; ?>; font-size: <?php echo $font_size; ?>;">

  <?php if ( $custom_styling == 'Yes' ) { ?>

    <style scoped>
      <?php if ( $show_title ) : ?>
        .tco-subscribe-form-<?php echo $form_id; ?> h1 {
          color: <?php echo $title_color; ?>;
        }
      <?php endif; ?>

      <?php if ( $show_labels ) : ?>
        .tco-subscribe-form-<?php echo $form_id; ?> label {
          color: <?php echo $label_color; ?>;
        }
      <?php endif; ?>

      .tco-subscribe-form-<?php echo $form_id; ?> .submit {
        <?php echo $button_colors; ?>
      }

      .tco-subscribe-form-<?php echo $form_id; ?> .submit:hover {
        <?php echo $button_colors_hover; ?>
      }
    </style>

  <?php } ?>

  <input type="hidden" name="tco_subscribe_form[id]" value="<?php echo $form_id; ?>">

  <?php if ( $show_title == 'Yes' ) : ?>
    <h1><?php echo $title; ?></h1>
  <?php endif; ?>

  <?php if ( strpos( $name_display, 'first' ) !== false ) : ?>
    <fieldset>
      <?php if ( $show_labels ) : ?>
        <label for="tco_subscribe_form_first_name">
          <span>
            <?php echo $first_name_label; ?>
            <?php echo ( $name_required ) ? '<span class="required">*</span>' : ''; ?>
          </span>
        </label>
      <?php endif; ?>
      <input type="text" name="tco_subscribe_form[first-name]" id="tco_subscribe_form_first_name" placeholder="<?php echo $first_name_placeholder; ?>"<?php echo ( $name_required ) ? ' required' : ''; ?>>
    </fieldset>
  <?php endif; ?>

  <?php if ( strpos( $name_display, 'last' ) !== false ) : ?>
    <fieldset>
      <?php if ( $show_labels ) : ?>
        <label for="tco_subscribe_form_last_name">
          <span>
            <?php echo $last_name_label; ?>
            <?php echo ( $name_required ) ? '<span class="required">*</span>' : ''; ?>
          </span>
        </label>
      <?php endif; ?>
      <input type="text" name="tco_subscribe_form[last-name]" id="tco_subscribe_form_last_name" placeholder="<?php echo $last_name_placeholder; ?>"<?php echo ( $name_required ) ? ' required' : ''; ?>>
    </fieldset>
  <?php endif; ?>

  <?php if ( strpos( $name_display, 'full' ) !== false ) : ?>
    <fieldset>
      <?php if ( $show_labels ) : ?>
        <label for="tco_subscribe_form_full_name">
          <span>
            <?php echo $full_name_label; ?>
            <?php echo ( $name_required ) ? '<span class="required">*</span>' : ''; ?>
          </span>
        </label>
      <?php endif; ?>
      <input type="text" name="tco_subscribe_form[full-name]" id="tco_subscribe_form_full_name" placeholder="<?php echo $full_name_placeholder; ?>"<?php echo ( $name_required ) ? ' required' : ''; ?>>
    </fieldset>
  <?php endif; ?>

  <fieldset>
    <?php if ( $show_labels ) : ?>
      <label for="tco_subscribe_form_email">
        <span>
          <?php echo $email_label; ?>
          <span class="required">*</span>
        </span>
      </label>
    <?php endif; ?>
    <input type="email" name="tco_subscribe_form[email]" id="tco_subscribe_form_email" placeholder="<?php echo $email_placeholder; ?>" required>
  </fieldset>

  <?php
  //
  // Custom fields (mostly Mailchimp)
  //
  if (isset($custom_fields)) :
    foreach ($custom_fields as $field ) : 

      if(!is_array($field)) continue;
      ?>
      <fieldset>
        <?php if ( $show_labels && isset($field['label']) ) : ?>
          <label for="tco_subscribe_form_email">
            <span><?php echo $field['label']; ?> <?php if ( isset($field['required']) && $field['required'] ) : ?><span class="required">*</span><?php endif; ?></span>
          </label>
        <?php endif; ?>
        <?php
        $type = isset($field['type']) ? $field['type'] : 'text';

        switch ( $type ) :

          case 'radio':
            $choices = explode( '|', $field['choices']);
            foreach ( $choices as $choice ) : ?>
            <input type="radio" name="tco_subscribe_form[<?php echo $field['name']; ?>]" id="tco_subscribe_form_<?php echo $choice; ?>" value="<?php echo $choice; ?>" <?php echo isset($field['required']) && $field['required'] ? 'required' : '' ?>> <?php echo $choice; ?><br/>
          <?php
            endforeach;
            break;

          case 'select':
          case 'dropdown': // Mailchimp
          case 'single_select': // GetResponse
          $states = explode( '|', $field['choices']);
          ?>
          <select name="tco_subscribe_form[<?php echo $field['name']; ?>]" id="tco_subscribe_form_<?php echo $field['name']; ?>_country" <?php echo isset($field['required']) && $field['required'] ? 'required' : '' ?>>
            <option value=">"><?php echo sprintf( __( '-- Select %s --', '__tco__' ), $field['label'] ); ?></option>
            <?php
            foreach ( $states as $value => $optionlabel) : ?>
            <option value="<?php echo $optionlabel; ?>"><?php echo $optionlabel; ?></option>
            <?php endforeach; ?>
          </select>
          <?php
            break;

          // Mailchimp Address
          case 'address':
            $subfields = array(
              'addr1' => __( 'Street Address', '__tco__' ),
              'addr2' => __( 'Address Line 2 (optional)', '__tco__' ),
              'city'  => __( 'City', '__tco__' ),
              'state' => __( 'State/Prov/Region', '__tco__' ),
              'zip'   => __( 'Postal/Zip', '__tco__' ),
            );
            foreach ( $subfields as $subfield => $sublabel) : ?>
            <input type="text" name="tco_subscribe_form[<?php echo $field['name']; ?>][<?php echo $subfield; ?>]" id="tco_subscribe_form_<?php echo $field['name']; ?>_<?php echo $subfield; ?>" <?php echo isset($field['required']) && $field['required'] ? 'required' : '' ?> placeholder="<?php echo $sublabel ?>">
            <?php endforeach; ?>
            <select  name="tco_subscribe_form[<?php echo $field['name']; ?>][country]" id="tco_subscribe_form_<?php echo $field['name']; ?>_country" <?php echo isset($field['required']) && $field['required'] ? 'required' : '' ?>>
              <option value=">"><?php _e( '-- Select a country --', '__tco__' ); ?></option>
              <?php
              $states = require(EMAIL_FORMS_ROOT_PATH . '/email-mailchimp/functions/includes/country-list.php');
              foreach ( $states as $value => $optionlabel) : ?>
              <option value="<?php echo $value; ?>"><?php echo $optionlabel; ?></option>
              <?php endforeach; ?>
            </select>
            <?php
            break;

          case 'date':
          case 'birthday':
        ?>
        <input type="text" name="tco_subscribe_form[<?php echo $field['name']; ?>]" id="tco_subscribe_form_<?php echo $field['name']; ?>" placeholder="<?php echo $field['label']; ?>"  <?php echo isset($field['required']) && $field['required'] ? 'required' : '' ?>>
        <?php
            break;

          case 'url':
        ?>
        <input type="text" name="tco_subscribe_form[<?php echo $field['name']; ?>]" id="tco_subscribe_form_<?php echo $field['name']; ?>" placeholder="<?php echo $field['label']; ?>"  <?php echo isset($field['required']) && $field['required'] ? 'required' : '' ?>>
        <?php
            break;

          case 'text':
          default:
            if ( isset( $field['name'] ) ) :
        ?>
        <input type="text" name="tco_subscribe_form[<?php echo $field['name']; ?>]" id="tco_subscribe_form_<?php echo $field['name']; ?>" placeholder="<?php echo $field['label']; ?>"  <?php echo isset($field['required']) && $field['required'] ? 'required' : '' ?>>
        <?php
            endif;
            break;

        endswitch; ?>
      </fieldset>
    <?php endforeach;
  endif; ?>

  <?php
  //
  // Mailchimp Groups
  //
  if ( isset( $mailchimp_groups )) :
    foreach ($mailchimp_groups as $group ) :

      if(!is_array($group)) continue;
      
      if ( isset($group['default']) && $group['default'] !== 'display-on-form') {
        ?>
          <input type="hidden" name="tco_subscribe_form[groups][<?php echo $group['id']; ?>]" id="tco_subscribe_form_group_<?php echo $group['default']; ?>" value="<?php echo $group['default']; ?>">
        <?php
        continue;
      }

      ?>
    <fieldset>
      <?php if ( $show_labels && isset($group['title']) ) : ?>
        <label for="tco_subscribe_form_email">
          <span><?php echo $group['title']; ?></span>
        </label>
      <?php endif; ?>
      <?php
      $group_type = isset($group['type']) ? $group['type'] : 'text';
      switch ( $group_type ) :
        case 'radio':
          echo ( ! $show_labels ) ? $group['title'] . '<br/>' : '';
          foreach ( $group['interests'] as $interest ) :
            ?>
              <input type="radio" name="tco_subscribe_form[groups][<?php echo $group['id']; ?>]" id="tco_subscribe_form_group_<?php echo $interest['id']; ?>" value="<?php echo $interest['id']; ?>"> <?php echo $interest['name']; ?><br/>
            <?php
          endforeach;
          break;

        case 'checkboxes':
          echo ( ! $show_labels ) ? $group['title'] . '<br/>' : '';
          foreach ( $group['interests'] as $interest ) :
            ?>
              <input type="checkbox" name="tco_subscribe_form[groups][<?php echo $group['id']; ?>][]" id="tco_subscribe_form_group_<?php echo $interest['id']; ?>" value="<?php echo $interest['id']; ?>"> <?php echo $interest['name']; ?><br/>
            <?php
          endforeach;
          break;

        case 'dropdown':
          echo ( ! $show_labels ) ? $group['title'] . '<br/>' : '';
          ?>
          <select name="tco_subscribe_form[groups][<?php echo $group['id']; ?>]" id="tco_subscribe_form_group_<?php echo $group['id']; ?>">
            <option value=""></option>
          <?php foreach ( $group['interests'] as $interest ) :
            ?>
              <option value="<?php echo $interest['id']; ?>"> <?php echo $interest['name']; ?></option>
            <?php
          endforeach;
          ?>
        </select>
          <?php
          break;

        default:
          break;

      endswitch; ?>
    </fieldset>

    <?php
    endforeach;
  endif;
  ?>

  <fieldset>
    <input type="submit" name="tco_subscribe_form[submit]" class="submit<?php echo $style . $shape; ?>" value="<?php echo $submit_label; ?>">
  </fieldset>

</form>

<?php

$form = ob_get_contents(); ob_end_clean();



// Shortcode Setup
// =============================================================================

//
// Class output.
//

if ( $class != '' ) {
  $class = 'class="' . $class . '"';
} else {
  $class = '';
}


//
// If "Custom Styling" is set to "No," then simply output the form in an
// "invisible" [tco_section] shortcode, which simply acts as a container.
// Otherwise, allow users to tap into [tco_section] options via the plugin.
//

if ( $custom_styling == 'No' ) {

  $shortcode = do_shortcode( '[tco_section ' . $class . ' padding_top="0" padding_bottom="0"][tco_row][tco_column type="1/1"]' . $form . '[/tco_column][/tco_row][/tco_section]' );

} else if ( $custom_styling == 'Yes' ) {

  //
  // Margin.
  //

  if ( $remove_margin == 'Yes' ) {
    $margin = 'margin: 0;';
  } else {
    $margin = '';
  }


  //
  // Border.
  //

  switch ( $border ) {
    case 'None' :
      $border = '';
      break;
    case 'Top' :
      $border = ' border-top: 1px solid rgba(0, 0, 0, 0.075);';
      break;
    case 'Left' :
      $border = ' border-left: 1px solid rgba(0, 0, 0, 0.075);';
      break;
    case 'Right' :
      $border = ' border-right: 1px solid rgba(0, 0, 0, 0.075);';
      break;
    case 'Bottom' :
      $border = ' border-bottom: 1px solid rgba(0, 0, 0, 0.075);';
      break;
    case 'Vertical' :
      $border = ' border-top: 1px solid rgba(0, 0, 0, 0.075); border-bottom: 1px solid rgba(0, 0, 0, 0.075);';
      break;
    case 'Horizontal' :
      $border = ' border-left: 1px solid rgba(0, 0, 0, 0.075); border-right: 1px solid rgba(0, 0, 0, 0.075);';
      break;
    case 'All' :
      $border = ' border: 1px solid rgba(0, 0, 0, 0.075);';
      break;
  }


  //
  // Padding.
  //

  $padding = ' padding: ' . $padding . ';';


  //
  // Background.
  //

  switch ( $bg_option ) {
    case 'Transparent' :
      $bg = ' bg_color="transparent"';
      break;
    case 'Color' :
      $bg = ' bg_color="' . $bg_color . '"';
      break;
    case 'Pattern' :
      $parallax = ( $bg_parallax == 'Yes' ) ? ' parallax="true"' : '';
      $bg       = ' bg_pattern="' . $bg_pattern . '"' . $parallax;
      break;
    case 'Image' :
      $parallax = ( $bg_parallax == 'Yes' ) ? ' parallax="true"' : '';
      $bg       = ' bg_image="' . $bg_image . '"' . $parallax;
      break;
    case 'Video' :
      $bg = ' bg_video="' . $bg_video . '" bg_video_poster="' . $bg_video_poster . '"';
      break;
  }


  //
  // Inner container.
  //

  if ( $inner_container == 'Yes' ) {
    $inner = ' inner_container="true"';
  } else {
    $inner = '';
  }

  $shortcode = do_shortcode( '[tco_section ' . $class . ' style="' . $margin . $border . $padding . '"' . $bg . '][tco_row ' . $inner . '][tco_column type="1/1"]' . $form . '[/tco_column][/tco_row][/tco_section]' );

}



// Shortcode Output
// =============================================================================

echo $shortcode;
