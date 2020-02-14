<section id="home_results">
	<div class="wrap">
		<header>
			<h3>View Floorplans</h3>
		</header>
		<article id="home_results_list">
			
			<?php
				$args = array(
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'post_type' => 'homes',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'key' => 'builder',
							'value' => $post->ID,
							'compare' => '='
						),
					),
					'meta_key' => 'square_footage',
					'orderby'=> 'meta_value_num',
					'order' => 'ASC'
				);
								
				$builder_query = new WP_Query($args);

				if ( $builder_query->have_posts() ) :

					while ( $builder_query->have_posts() ) : $builder_query->the_post();
					
						get_template_part( 'template-parts/homes/content', 'home-result' );

					endwhile;

				else: ?>
				<div class="no-results">
					<header>
						<h4>Sorry, this builder does not currently have any floorplans available to view.</h4>
					</header>

					<div class="textarea">
						<p>Please check back soon, as we are always adding new homes as soon as they are available.</p>
						<p>&nbsp;</p>
						<p>&nbsp;</p>
					</div>
				</div>
			<?php 
				endif; 
				wp_reset_query();
			?>
		</article>
	</div>
</section>