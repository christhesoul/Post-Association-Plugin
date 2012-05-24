<div class="my_meta_control">
	<?php
	
	$options = get_option('post_association_options');
	$post_type = $options['belongs_to'];
	$number_of = $options['number_of'];
	
	?>
	
	<p>Choose <?php echo $number_of ?> related pages to appear in the sidebar on the right of a page.</p>
	
	<?php
	
	
	for($i = 1; $i <= $number_of; $i++) {
		
		$mb->the_field('related_page_'.$i);
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
	}
	echo $string;
	?>
	
</div>