<?php  

get_header(); 

$args = array(
	'posts_per_page' => -1,
	'post_status' => array('publish'),
	'post_type' => 'qmi',
);

$qmi_loop = new WP_Query($args);
$qmi_floorplans = array();

while($qmi_loop->have_posts()): $qmi_loop->the_post();
	$floorplan = get_field( 'floorplan' );
	$qmi_floorplans[] = $floorplan->ID;
endwhile;

wp_reset_query();
$qmi_floorplans = array_unique($qmi_floorplans);

if ( have_posts() ):
	while ( have_posts() ) : the_post();
					
		prop_get_template_part( 'builders/content', 'hero' );
		
		echo "<section role='main'>";
		
		prop_get_template_part( 'builders/content', 'builder-details' );
				
		prop_get_template_part( 'builders/content', 'floorplans' );
		
		echo "</section>";
					
	endwhile;
endif; 
	
get_footer();