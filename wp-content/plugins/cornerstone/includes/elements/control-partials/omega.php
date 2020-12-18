<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/OMEGA.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_omega( $settings ) {

  // Setup
  // -----

  $conditions            = ( isset( $settings['conditions'] )            ) ? $settings['conditions']            : array();
  $title                 = ( isset( $settings['title'] )                 ) ? $settings['title']                 : false;
  $add_custom_atts       = ( isset( $settings['add_custom_atts'] )       ) ? $settings['add_custom_atts']       : false;
  $add_looper_provider   = ( isset( $settings['add_looper_provider'] )   ) ? $settings['add_looper_provider']   : false;
  $add_looper_consumer   = ( isset( $settings['add_looper_consumer'] )   ) ? $settings['add_looper_consumer']   : false;
  $add_style             = ( isset( $settings['add_style'] )             ) ? $settings['add_style']             : false;
  $add_toggle_hash       = ( isset( $settings['add_toggle_hash'] )       ) ? $settings['add_toggle_hash']       : false;
  $toggle_hash_condition = ( isset( $settings['toggle_hash_condition'] ) ) ? $settings['toggle_hash_condition'] : false;


  // Groups
  // ------

  $group_omega       = 'omega';
  $group_omega_setup = $group_omega . ':setup';
  $group_omega_loop  = $group_omega . ':dynamic';


  // Control Nav
  // -----------

  $control_nav = array(
    $group_omega       => __( 'Customize', '__x__' ),
    $group_omega_setup => __( 'Setup', '__x__' ),
  );


  // Conditions
  // ----------

  $condition_omega_provider_is_json                          = array( 'looper_provider_type' => 'json' );
  $condition_omega_provider_is_terms                         = array( 'looper_provider_type' => 'terms' );
  $condition_omega_provider_is_query_string                  = array( 'looper_provider_type' => 'query-string' );
  $condition_omega_provider_is_query_builder                 = array( 'looper_provider_type' => 'query-builder' );
  $condition_omega_provider_is_query_builder_or_query_recent = array( 'key' => 'looper_provider_type', 'op' => 'IN', 'value' => array( 'query-builder', 'query-recent' ) );
  $condition_omega_provider_has_term_ids                     = array( 'key' => 'looper_provider_query_term_ids', 'op' => 'MORE THAN ONE' );


  // Options
  // -------

  $options_group_picker_label_edit = array( 'label' => 'Edit' );

  $options_omega_group_toggle_include_exclude = array(
    'toggle' => array(
      'always_show' => true,
      'on'          => true,
      'off'         => false,
      'on_label'    => __( 'Include', '__x__' ),
      'off_label'   => __( 'Exclude', '__x__' ),
    ),
  );

  $options_provider_query_term_match = array(
    'choices' => array(
      array( 'value' => 'any', 'label' => __( 'Any', '__x__' ) ),
      array( 'value' => 'all', 'label' => __( 'All', '__x__' ) ),
    ),
  );

  $options_omega_group_toggle_asc_desc = array(
    'toggle' => array(
      'always_show' => true,
      'on'          => 'ASC',
      'off'         => 'DESC',
      'on_label'    => __( 'Ascending', '__x__' ),
      'off_label'   => __( 'Descending', '__x__' ),
    ),
  );

  $options_provider_query_count = array(
    'choices' => [
      [ 'value' => '', 'label' => __('Default', '__x__') ],
      [ 'value' => '{{custom}}', 'label' => __('Custom', '__x__') ],
    ],
    'custom_value' => 4,
    'placeholder' => get_option( 'posts_per_page' ),
  );

  $options_provider_json = array(
    'mode'         => 'json',
    'button_label' => __( 'Edit', '__x__' ),
    'header_label' => __( 'JSON', '__x__' ),
  );

  $options_consumer_repeat = array(
    'choices' => array(
      array( 'value' => '-1',        'label' => __( 'All', '__x__' )  ),
      array( 'value' => '1',          'label' => __( 'One', '__x__' )  ),
      array( 'value' => '{{custom}}', 'label' => __( 'Many', '__x__' ) ),
    ),
    'custom_value' => 4,
  );


  // Data
  // ----

  $control_setup = array(
    'type'       => 'omega',
    'group'      => $group_omega_setup,
    'conditions' => $conditions,
    'options'    => array(),
    'priority'   => 0
  );

  if ( ! empty( $title ) ) {
    $control['label'] = $title;
  }


  // Keys
  // ----

  $keys = array(
    'id'             => 'id',
    'class'          => 'class',
    'css'            => 'css',
    'bp'             => 'hide_bp',
    'show_condition' => 'show_condition'
  );

  if ( $add_style ) {
    $keys['style'] = 'style';
  }

  if ( $add_toggle_hash ) {
    $keys['toggle_hash'] = 'toggle_hash';
  }

  if ( $toggle_hash_condition ) {
    $control_setup['options']['toggle_hash_condition'] = $toggle_hash_condition;
  }

  $control_setup['keys'] = $keys;

  $controls = array( $control_setup );


  // Custom Attributes
  // -----------------

  if ( $add_custom_atts ) {
    $controls[] = array(
      'key'        => 'custom_atts',
      'type'       => 'attributes',
      'label'      => __( 'Custom Attributes', '__x__' ),
      'group'      => $group_omega_setup,
      'conditions' => $conditions,
    );
  }


  // Looper Provider
  // ---------------

  if ( $add_looper_provider ) {
    $controls[] = array(
      'key'         => 'looper_provider',
      'type'        => 'group',
      'label'       => __( 'Looper Provider', '__x__' ),
      'group'       => $group_omega_loop,
      'options'     => cs_recall( 'options_group_toggle_off_on_bool' ),
      'conditions'  => $conditions,
      'description' => __( 'Begin a new dynamic content data source to loop over.' ),
      'controls'    => array(

        // Type
        // ----

        array(
          'key'     => 'looper_provider_type',
          'type'    => 'select',
          'label'   => __( 'Type', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'query-recent',  'label' => __('Recent Posts', '__x__' )       ),
              array( 'value' => 'query-builder', 'label' => __('Query Builder', '__x__' )      ),
              array( 'value' => 'query-string',  'label' => __('Query String', '__x__' )       ),
              array( 'value' => 'terms',         'label' => __('Current Post Terms', '__x__' ) ),
              // array( 'value' => 'custom',        'label' => __('Custom', '__x__' )             ),
              // array( 'value' => 'filter',        'label' => __('WordPress Filter', '__x__' )   ),
              array( 'value' => 'json',          'label' => __('JSON', '__x__' )               ),
            ),
          ),
        ),


        // Query String
        // ------------

        array(
          'key'        => 'looper_provider_query_string',
          'type'       => 'text',
          'label'      => __( 'WP Query', '__x__' ),
          'options'    => array( 'placeholder' => 'category_name=uncategorized&posts_per_page=2' ),
          'conditions' => array( $condition_omega_provider_is_query_string ),
        ),


        // Posts
        // -----

        array(
          'keys'       => array(
            'types' => 'looper_provider_query_post_types',
            'in'  => 'looper_provider_query_post_in',
            'ids' => 'looper_provider_query_post_ids'
          ),
          'type'       => 'group-picker',
          'label'      => __( 'Posts', '__x__' ),
          'options'    => array(
            'icon'  => 'database',
            'label' => '{{remote:query-builder-posts:types,in,ids}}',
          ),
          'conditions' => array( $condition_omega_provider_is_query_builder ),
          'controls'   => array(
            array(
              'key'     => 'looper_provider_query_post_types',
              'type'    => 'select-many',
              'label'   => __( 'Types', '__x__' ),
              'options' => array(
                'require_one' => true,
                'choices'     => CS()->component( 'Locator' )->get_post_type_options()
              ),
            ),
            array(
              'key'      => 'looper_provider_query_post_in',
              'type'     => 'group',
              'label'    => __( 'Specific Posts', '__x__' ),
              'options'  => $options_omega_group_toggle_include_exclude,
              'controls' => array(
                array(
                  'key'     => 'looper_provider_query_post_ids',
                  'type'    => 'select-many',
                  'options' => array( 'choices' => 'posts:all' ),
                ),
                array(
                  'keys'       => array( 'sticky' => 'looper_provider_query_include_sticky' ),
                  'type'       => 'checkbox-list',
                  'conditions' => array( $condition_omega_provider_is_query_builder ),
                  'options'    => array(
                    'list' => array(
                      array( 'key' => 'sticky', 'label' => __( 'Include sticky posts', '__x__' ), 'full' => true ),
                    ),
                  ),
                ),
              ),
            ),
          ),
        ),


        // Taxonomies
        // ----------

        array(
          'keys'       => array(
            'in'  => 'looper_provider_query_term_in',
            'ids' => 'looper_provider_query_term_ids'
          ),
          'type'       => 'group-picker',
          'label'      => __( 'Taxonomies', '__x__' ),
          'options'    => array(
            'icon'  => 'tag',
            'label' => '{{remote:query-builder-terms:in,ids}}',
          ),
          'conditions' => array( $condition_omega_provider_is_query_builder ),
          'controls'   => array(
            array(
              'key'      => 'looper_provider_query_term_in',
              'type'     => 'group',
              'label'    => __( 'Specific Terms', '__x__' ),
              'options'  => $options_omega_group_toggle_include_exclude,
              'controls' => array(
                array(
                  'key'     => 'looper_provider_query_term_ids',
                  'type'    => 'select-many',
                  'options' => array( 'choices' => 'taxonomy-terms:all' ),
                ),
                array(
                  'keys'    => array( 'require_all' => 'looper_provider_query_term_and' ),
                  'type'    => 'checkbox-list',
                  'conditions' => array( $condition_omega_provider_has_term_ids ),
                  'options' => array(
                    'list' => array(
                      array( 'key' => 'require_all', 'label' => __( 'Must have all selected terms', '__x__' ), 'full' => true ),
                    ),
                  ),
                ),
              ),
            ),
          ),
        ),


        // Authors
        // -------

        array(
          'keys'       => array(
            'in'  => 'looper_provider_query_author_in',
            'ids' => 'looper_provider_query_author_ids'
          ),
          'type'       => 'group-picker',
          'label'      => __( 'Authors', '__x__' ),
          'options'    => array(
            'icon'  => 'user',
            'label' => '{{remote:query-builder-authors:in,ids}}',
          ),
          'conditions' => array( $condition_omega_provider_is_query_builder ),
          'controls'   => array(
            array(
              'key'      => 'looper_provider_query_author_in',
              'type'     => 'group',
              'label'    => __( 'Authors', '__x__' ),
              'options'  => $options_omega_group_toggle_include_exclude,
              'controls' => array(
                array(
                  'key'     => 'looper_provider_query_author_ids',
                  'type'    => 'select-many',
                  'options' => array( 'choices' => 'user:all' ),
                ),
              ),
            ),
          ),
        ),


        // Date
        // ----

        array(
          'type'       => 'group-picker',
          'keys' => [
            'before' => 'looper_provider_query_before',
            'after' => 'looper_provider_query_after'
          ],
          'label'      => __( 'Date', '__x__' ),
          'options'    => array(
            'icon'  => 'date',
            'label' => '{{date-range:before,after}}',
          ),
          'conditions' => array( $condition_omega_provider_is_query_builder ),
          'controls'   => array(
            array(
              'key'   => 'looper_provider_query_after',
              'type'  => 'date-time',
              'label' => __( 'Published After', '__x__' ),
            ),
            array(
              'key'   => 'looper_provider_query_before',
              'type'  => 'date-time',
              'label' => __( 'Published Before', '__x__' ),
            ),
          ),
        ),


        // Order By
        // --------

        array(
          'keys' => array(
            'direction'   => 'looper_provider_query_order',
            'field' => 'looper_provider_query_orderby',
          ),
          'type'    => 'group-picker',
          'label'   => __( 'Order By', '__x__' ),
          'options' => array(
            'icon'   => 'order',
            'label'  => '{{orderby:field,direction}}',
          ),
          'conditions' => array( $condition_omega_provider_is_query_builder ),
          'controls'   => array(
            array(
              'key'      => 'looper_provider_query_order',
              'type'     => 'group',
              'label'    => __( 'Field', '__x__' ),
              'options'  => $options_omega_group_toggle_asc_desc,
              'controls' => array(
                array(
                  'key'     => 'looper_provider_query_orderby',
                  'type'    => 'select',
                  'options' => array(
                    'choices' => CS()->component( 'Locator' )->get_orderby_options()
                  )
                ),
              ),
            ),
          ),
        ),


        // Count
        // -----

        array(
          'key'        => 'looper_provider_query_count',
          'type'       => 'choose',
          'label'      => __( 'Count', '__x__' ),
          'options'    => $options_provider_query_count,
          'conditions' => array( $condition_omega_provider_is_query_builder_or_query_recent ),
        ),


        // Terms Tax
        // ---------

        array(
          'key'         => 'looper_provider_terms_tax',
          'type'        => 'select',
          'label'       => __( 'Taxonomy', '__x__' ),
          'options'     => array( 'choices' => CS()->component( 'Locator' )->get_taxonomy_options() ),
          'conditions'  => array( $condition_omega_provider_is_terms ),
          'description' => __( 'Uses get_the_terms to find terms associated with the current post.', '__x__' ),
        ),


        // JSON
        // ----

        array(
          'key'         => 'looper_provider_json',
          'type'        => 'code-editor',
          'label'       => __( 'Content', '__x__' ),
          'options'     => $options_provider_json,
          'conditions'  => array( $condition_omega_provider_is_json ),
          'description' => __( 'Content must be valid JSON with the top level being an array of objects. The object keys will be available in Dynamic Content.', '__x__' ),
        ),

      ),
    );
  }


  // Looper Consumer
  // ---------------

  if ( $add_looper_consumer ) {
    $controls[] = array(
      'key'         => 'looper_consumer',
      'type'        => 'group',
      'group'       => $group_omega_loop,
      'label'       => __( 'Looper Consumer', '__x__' ),
      'options'     => cs_recall( 'options_group_toggle_off_on_bool' ),
      'conditions'  => $conditions,
      'description' => __( 'Consume data from the closest Looper Provider, or the main query.' ),
      'controls'    => array(
        array(
          'key'     => 'looper_consumer_repeat',
          'type'    => 'choose',
          'label'   => __( 'Items', '__x__' ),
          'options' => $options_consumer_repeat,
        ),
      ),
    );
  }


  // Output
  // ------

  return array(
    'controls'               => $controls,
    'controls_std_customize' => array( $control_setup ),
    'control_nav'            => $control_nav
  );
}

cs_register_control_partial( 'omega', 'x_control_partial_omega' );
