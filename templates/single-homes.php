<?php  

get_header(); 

if ( have_posts() ):
	while ( have_posts() ) : the_post();
					
		prop_get_template_part( 'homes/content', 'home-details' );
					
	endwhile;
endif; 
	
get_footer();