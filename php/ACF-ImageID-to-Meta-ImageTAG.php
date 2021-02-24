add_action('acf/save_post', 'image_to_image_tag');
function image_to_image_tag($post_id) {
  // get unformatted image field value, ensures that image ID is returned
  $image_id = intval(get_field('post_grid_featured_image', $post_id, false));
  // a variable to build the image tag
  $image_tag = '';
  // a different custom field name to store our tag
  $meta_key = 'post_grid_featued_image_converted';
  if ($image_id) {
    // if image id is not empty create the image tag
    // first get the image see function at WP for more information
    // change image size to desired image size
    $size = 'medium';
    $image = wp_get_attachment_image_src($image_id, $size);
    if (!empty($image)) {
      // only do this if the image exists
      // get image alt text if it exists
      $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
      $image_tag = '<img src="'.$image[0].'" width="'.$image[1].
                   '" height="'.$image[2].'" alt=" '.$image_alt.
                   ' " title="'.$image_alt. '" class="size-'.$size.
                   ' wp-image-'.$image_id.'" />';
      // bonus - make image responsive, this is why the class was added above
      if (function_exists('wp_filter_content_tags')) {
        $image_tag = wp_filter_content_tags($image_tag);
      } else {
        $image_tag = wp_make_content_images_responsive($image_tag);
      }
    }
  }
  // at this point $image_tag will contain the image tag
  // or it will be empty because there is no image
  // save the value in a new meta_key
  $meta_key = 'post_grid_featured_image_converted';
  update_post_meta($post_id, $meta_key, $image_tag); 
}
