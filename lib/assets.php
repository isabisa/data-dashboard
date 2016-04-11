<?php

namespace Stringable\DataDash\Assets;

// Enqueue admin styles
add_action( 'admin_enqueue_scripts', function($hook) {
  if( $hook != 'post.php' && $hook != 'post-new.php' )
    return;

  wp_enqueue_style( 'dd_admin_style', plugin_dir_url(dirname(__FILE__)) . 'dist/styles/admin.css' );
});

// Enqueue front-end assets
add_action('wp_enqueue_scripts', function() {
  if (is_post_type_archive('data') || is_singular('data-viz')) {
    wp_enqueue_script('google/charts', '//www.gstatic.com/charts/loader.js', [], null, false);
    wp_enqueue_script('data-viz', plugin_dir_url(dirname(__FILE__)) . 'dist/scripts/data-viz.js', ['jquery', 'google/charts'], null, false);
    wp_localize_script( 'data-viz', 'Ajax', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'security' => wp_create_nonce('data-viz-ajax-nonce')
    ));
  }
}, 100);

// // Enqueue embed assets
// remove_action( 'embed_head', 'print_emoji_detection_script' );
// remove_action( 'embed_head', 'print_emoji_styles' );
// add_action('enqueue_embed_scripts', function() {
//   wp_enqueue_style('sage/css', Assets\asset_path('styles/embed.css'), false, null);
//   wp_enqueue_script('sage/js', Assets\asset_path('scripts/main.js'), ['jquery'], null, true);
//
//   if (is_singular('data-viz')) {
//     wp_enqueue_script('google/charts', '//www.gstatic.com/charts/loader.js', [], null, false);
//     wp_enqueue_script('data-viz', Assets\asset_path('scripts/data-viz.js'), ['jquery', 'google/charts'], null, false);
//     wp_localize_script('data-viz', 'Ajax', array(
//       'ajaxurl' => admin_url('admin-ajax.php'),
//       'security' => wp_create_nonce('data-viz-ajax-nonce')
//     ));
//   }
// }, 100);
