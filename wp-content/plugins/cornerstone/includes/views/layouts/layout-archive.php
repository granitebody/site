<?php get_header(); ?>

<main class="x-layout x-layout-archive" role="main">

  <?php

    do_action('cs_layout_before_archive');
    do_action('cs_layout_archive');
    do_action('cs_layout_after_archive');

  ?>

</main>

<?php get_footer(); ?>
