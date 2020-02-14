<?php 

get_header();

	prop_get_template_part( 'builders/content', 'hero' );
	
	echo "<section role='main'>";
	
	if ( have_posts() ): 
		prop_get_template_part( 'builders/content', 'archive' );
	endif;
	
	echo "</section>";

get_footer();