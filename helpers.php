<?php

function get_related_posts(){
	$options = get_option('post_association_options');
	$number_of = $options['number_of'];
	$related_array['post_type'] = $options['belongs_to'];
	for($i = 1; $i <= $number_of ; $i++) {
		$id = get_post_meta(get_the_id(),'_my_related_page_'.$i);
		if(!empty($id)){
			$related_array['ids'][] = $id[0];
		}
	}
	return $related_array;
}

function print_list_of_related_posts(){
	$related_array = get_related_posts();
	$args = array(
		'include' => $related_array['ids'],
		'post_type' => $related_array['post_type']
	);
	$related_posts = get_posts($args);
	$string = '<ul>';
	foreach($related_posts as $p) {
		$string.= '<li>'.$p->post_title.'</li>';
	}
	$string.= '</ul>';
	echo $string;
}

function this_belongs_to($link = true) {
	$id = get_post_meta(get_the_id(),'_my_related_to_cpt');
	$post_title = get_the_title($id[0]);
	$url = get_permalink($id[0]);
	$string.= $link == true ? '<a href="'.$url.'">'.$post_title.'</a>' : $post_title;
	echo $string;
}

?>