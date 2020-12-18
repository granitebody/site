<?php get_header(); ?>

<main class="x-layout x-layout-single" role="main">

  <?php while ( have_posts() ) : the_post();

    do_action('cs_layout_before_single');
    do_action('cs_layout_single');
    do_action('cs_layout_after_single');

  endwhile; ?>

  <?php if (is_404()) :
    do_action('cs_layout_single');
  endif; ?>

</main>

<?php get_footer(); ?>
