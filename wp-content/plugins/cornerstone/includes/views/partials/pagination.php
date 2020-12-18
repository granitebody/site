<?php

// =============================================================================
// VIEWS/PARTIALS/PAGINATION.PHP
// -----------------------------------------------------------------------------
// Pagination partial.
// =============================================================================

$style_id = ( isset( $style_id ) ) ? $style_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Attr Values
// -------------------

$atts = array(
  'class' => x_attr_class( array( $style_id, 'x-paginate', $class ) ),
  'role'  => 'navigation',
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = cs_apply_effect( $atts, $_view_data );


// Previous / Next
// ---------------

$prev_output = $pagination_items_prev_text;
$next_output = $pagination_items_next_text;

if ( $pagination_items_prev_next_type === 'icon' ) {
  $prev_output = cs_get_partial_view( 'icon', array_merge( $_view_data, array( 'icon' => $pagination_items_prev_icon ) ) );
  $next_output = cs_get_partial_view( 'icon', array_merge( $_view_data, array( 'icon' => $pagination_items_next_icon ) ) );
}


// Args (Base)
// -----------

$args = null;

if ( $pagination_type !== 'post-nav' ) {
  $args = array(
    'type'         => 'plain',
    'aria_current' => 'page',
    'prev_next'    => true,
    'prev_text'    => $prev_output,
    'next_text'    => $next_output,
    'end_size'     => $pagination_numbered_end_size, // either side of '...'
    'mid_size'     => $pagination_numbered_mid_size, // either side of 'current'
    'show_all'     => false,
  );
}


// Args (Products)
// ---------------

if ( $pagination_type === 'product' ) {
  // $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
  // $format  = isset( $format ) ? $format : '';
  // $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
  // $total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );

  $base    = esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
  $format  = '';
  $current = wc_get_loop_prop( 'current_page' );
  $total   = wc_get_loop_prop( 'total_pages' );

  $args['base']     = $base;
  $args['format']   = $format;
  $args['add_args'] = false;
  $args['current']  = max( 1, $current );
  $args['total']    = $total;

  $args = apply_filters( 'woocommerce_pagination_args', $args );
}


// Output
// ------

?>

<nav <?php echo x_atts( $atts, $custom_atts ); ?>>
  <div class="x-paginate-inner">
    <?php

    if ( $pagination_type === 'comment' && ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) ) {
      if ( $pagination_numbered_hide === 'xl' ) {
        previous_comments_link( $prev_output );
        next_comments_link( $next_output );
      } else {
        echo paginate_comments_links( $args );
      }
    }

    if ( $pagination_type === 'post' || $pagination_type === 'product' ) {
      if ( $pagination_numbered_hide === 'xl' ) {
        echo get_posts_nav_link( array( 'sep' => '', 'prelabel' => $prev_output, 'nxtlabel' => $next_output ) );
      } else {
        echo paginate_links( $args );
      }
    }

    if ( $pagination_type === 'post-nav' ) {
      $prev = get_adjacent_post( false, '', true );
      $next = get_adjacent_post( false, '', false );

      if ( gettype( $prev ) === 'object' ) {
        echo '<a href="' . get_permalink( $prev ) . '" rel="prev">' . $prev_output . '</a>';
      }

      if ( gettype( $next ) === 'object' ) {
        echo '<a href="' . get_permalink( $next ) . '" rel="next">' . $next_output . '</a>';
      }
    }

    ?>
  </div>
</nav>
