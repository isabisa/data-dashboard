<?php

use Stringable\DataDash\Nav;
use Stringable\DataDash\Extras;

$prefix = '_dd_';
?>
<div class="dashboard-header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1 class="entry-title">Community Development Data Tracker</h1>
      </div>
    </div>
  </div>
</div>

<div class="container data-dashboard">
  <div class="row archive">
    <div class="col-md-3 hidden-xs hidden-sm">
      <div class="well callout" id="data-dash-nav">
        <ul class="nav nav-stacked">
          <?php
          wp_list_pages([
            'post_type' => 'data',
            'depth' => 2,
            'title_li' => '',
            'walker' => new Nav\Walker_Data_Nav
          ])
          ?>
        </ul>

        <div class="append-on-affix">
          <a href="#">Back to top</a>
        </div>
      </div>
    </div>

    <div class="col-md-9">
      <?php
      $sections = new WP_Query([
        'post_type' => 'data',
        'posts_per_page' => -1,
        'orderby' => 'menu_order',
        'order' => 'ASC'
      ]);

      if ($sections->have_posts()) : ?>

        <?php while ($sections->have_posts()) : $sections->the_post();

          if (Extras\has_children('data')) :

            echo '<a name="' . $post->post_name . '"></a>';

          else :
            ?>
            <div id="<?php echo $post->post_name; ?>" class="dashboard-section">
              <h2>
                <?php
                if (!empty($parent = $post->post_parent)) {
                  echo get_the_title($parent);
                  echo ' <span>&gt;</span> ';
                }
                the_title();
                ?>
              </h2>

              <?php
              $intro = get_post_meta( get_the_ID(), $prefix . 'intro', true );
              if (!empty($intro)) {
                ?>
                <div class="row intro-section panel panel-default">
                  <div class="col-lg-11">
                    <?php echo $intro; ?>
                  </div>
                </div>
                <?php
              }

              $data = get_post_meta( get_the_ID(), $prefix . 'data_visualizations', true );
              if (!empty($data)) {
                foreach ($data as $d) {
                  $original_post = $post;

                  $post = get_post($d);
                  setup_postdata($post);

                  include('content-embed-data-viz.php');

                  $post = $original_post;
                  wp_reset_postdata();
                }
              }
              ?>
            </div>
          <?php endif;
        endwhile;
      endif; ?>
    </div>
  </div>
</div>
