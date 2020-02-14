
<section class="content-section">
	<div class="wrap">
		<article id="builders_list">
			<?php while ( have_posts() ) : the_post(); ?>
			
				<?php
/*
				$args = array(
					'post_type' => 'homes',
					'meta_query' => array(
						array(
							'key' => 'builder',
							'value' => $post->ID,
						),
					)
				);
				$builder_query = new WP_Query($args);
				
				if($builder_query->have_posts()):
					$coming_soon = false;
				else:
					$coming_soon = true;
				endif;
*/
				
				$coming_soon = get_field( 'coming_soon' );
				
				wp_reset_query();
				
				$logo = get_field( 'builder_logo' );
				$preview_image = get_field( 'builder_hero_image' );
				?>
			
				<a href="<?php the_permalink(); ?>" class="builder <?php the_field( 'builder_color' ); ?> active">
					<div class="logo-block">
						<img src="<?php echo $logo['url'] ?>" alt="<?php the_title(); ?>" />
					</div>
					<div class="preview" style="background: url(<?php echo $preview_image['sizes']['large'] ?>) center center no-repeat; background-size: cover;">
						<div class="hover">
						<?php if($coming_soon): ?>
							<div class="btn large">Coming Soon</div>
						<?php else: ?>
							<div class="btn large">View Builder Details</div>
						<?php endif; ?>
						</div>
					</div>
				</a>
			<?php endwhile; ?>
		</article>
	</div>
</section>
