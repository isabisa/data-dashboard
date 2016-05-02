<?php

namespace Stringable\DataDash\Assets;

// Enqueue admin styles
add_action( 'admin_enqueue_scripts', function($hook) {
  if( $hook != 'post.php' && $hook != 'post-new.php' )
    return;

  wp_enqueue_style( 'dd_admin_style', plugin_dir_url(dirname(__FILE__)) . 'dist/styles/admin.css' );
});

// Enqueue assets
function enqueue_scripts() {
  if (is_post_type_archive('data') || is_singular('data-viz')) {
    wp_enqueue_style( 'dd_main_style', plugin_dir_url(dirname(__FILE__)) . 'dist/styles/main.css' );
    wp_enqueue_script('dd_google_charts', '//www.gstatic.com/charts/loader.js', [], null, false);
    wp_enqueue_script('dd_main_scripts', plugin_dir_url(dirname(__FILE__)) . 'dist/scripts/main.js', ['jquery', 'dd_google_charts'], null, true);
    wp_localize_script( 'dd_main_scripts', 'dd_ajax', array(
      'ajaxurl' => admin_url('admin-ajax.php'),
      'security' => wp_create_nonce('data-viz-ajax-nonce')
    ));
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_scripts', 100);
add_action('enqueue_embed_scripts', __NAMESPACE__ . '\\enqueue_scripts', 100);
remove_action( 'embed_head', 'print_emoji_detection_script' );
remove_action( 'embed_head', 'print_emoji_styles' );
remove_action( 'embed_head', 'print_embed_styles' );

// Enqueue Bootstrap Modal if it's not already defined
function bootstrap_modal() {
  if (is_post_type_archive('data') || is_singular('data-viz')) {
    ?>
    <script>
    jQuery(document).ready(function($) {if(typeof(jQuery.fn.modal) === 'undefined') {$('body').append($('<script src="<?php echo plugin_dir_url(dirname(__FILE__)); ?>dist/scripts/boostrap.modal.js"><\/script>'))}});</script>
    <?php
  }
}
add_action('wp_footer', __NAMESPACE__ . '\\bootstrap_modal');
add_action('embed_footer', __NAMESPACE__ . '\\bootstrap_modal');

/**
 * Replace default inline embed scripts to remove default share fn code and allow links to open in new tabs
 */
remove_action( 'embed_footer', 'print_embed_scripts' );
add_action( 'embed_footer', function() {
	?>
	<script type="text/javascript">
	 <?php readfile( plugin_dir_url(dirname(__FILE__)) . 'dist/scripts/wp-embed-template.js' ); ?>
	</script>
	<?php
} );
