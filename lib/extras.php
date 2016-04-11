<?php

namespace Stringable\DataDash\Extras;

/**
 * Utility function to test if page has children
 */
 function has_children($type = 'page') {
   global $post;

   $children = get_pages(['child_of' => $post->ID, 'post_type' => $type]);
   if( count( $children ) == 0 ) {
     return false;
   } else {
     return true;
   }
}

/**
 * Add CartoDB oembed support
 */
add_action('init', function() {
  wp_oembed_add_provider( '#https?://(?:www\.)?[^/^\.]+\.cartodb\.com/\S+#i', 'https://services.cartodb.com/oembed', true );
});
