<div class="my_meta_control">
	<?php	
	$options = get_option('post_association_options');
	$post_type = $options['has_many'];
	?>
	
	<p>Choose which of the <?php echo $post_type ?> this belongs to.</p>
	
	<?php
	
	$mb->the_field('related_to_cpt');
	$string.= '<select name="'.$mb->get_the_name().'"><option value="">Select...</option>';
	$args = array(
		'post_type' => $post_type,
		'posts_per_page' => -1
	);
	$items = get_posts($args);
		
	foreach($items as $item) {
		$string.= '<option value="'.$item->ID.'" '.$mb->get_the_select_state($item->ID) .'>'.$item->post_title.'</option>';	
	}
		
	$string.= '</select>';

	echo $string;
	?>
	
</div>