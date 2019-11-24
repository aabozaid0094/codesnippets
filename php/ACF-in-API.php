/*
* more related to wordpress and its plugin 'acf'
* return advanced custom fields in api response under 'ACF' attribute name
* with a check if its a post or a term or a user
*/
function create_ACF_meta_in_REST() {
  $postypes_to_exclude = ['acf-field-group','acf-field', 'wpcf7_contact_form', 'foogallery', 'mt_pp'];
  $extra_postypes_to_include = ["page", "post", "category", "user"];
  $post_types = array_diff(get_post_types(["_builtin" => false], 'names'),$postypes_to_exclude);
  array_push($post_types, $extra_postypes_to_include);
  foreach ($post_types as $post_type) {
		register_rest_field( $post_type, 'ACF', [
			'get_callback'    => 'expose_ACF_fields',
			'schema'          => null,
		]
   );
  }
}
function expose_ACF_fields( $object ){
	if ($object['type'] == 'post') {
		return post_ACF_fields($object);
	} elseif ($object['taxonomy']) {
		$field_names = ['field_1', 'field_2', 'field_3'];
		return term_ACF_fields( $field_names , $object );
	} elseif ($object['avatar_urls']) {
    $field_names = ['field_1', 'field_2', 'field_3'];
		return user_ACF_fields( $field_names , $object );
	}
}
function post_ACF_fields($post_object){
	$ID = $post_object['id'];
	return get_fields($ID);
}
function term_ACF_fields($field_names, $term_object){
	$term_id = $term_object['id'];
	$term_taxonomy = $term_object['taxonomy'];
	$term_meta = array();
	foreach ($field_names as $field_name) {
		if (get_field($field_name, $term_taxonomy.'_'.$term_id)) {
			$term_meta[$field_name] = get_field($field_name, $term_taxonomy.'_'.$term_id);
		}
	}
	return $term_meta;
}
function user_ACF_fields($field_names, $user_object){
	$user_id = $user_object['id'];
	$user_meta = array();
	foreach ($field_names as $field_name) {
		if (get_field($field_name, 'user_'.$user_id)) {
			$user_meta[$field_name] = get_field($field_name, 'user_'.$user_id);
		}
	}
	return $user_meta;
}
add_action( 'rest_api_init', 'create_ACF_meta_in_REST' );
