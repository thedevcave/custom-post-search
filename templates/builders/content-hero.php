<?php 
	$builder_page = get_page_by_path( 'meet-our-builders' );
	if(is_post_type_archive( 'builders' )):
		$hero_image = get_field( 'hero_image', $builder_page->ID );
	else:
		$hero_image = get_field( 'builder_hero_image', $post->ID );
	endif;
?>
<section id="page_hero">
	<?php
		if($hero_image):
			echo "<div class='hero-image'><img src='{$hero_image['url']}' alt='".get_the_title()."' /></div>";
		endif;
	?>
	<div class="hero-circle <?php the_field( 'hero_circle_color', $builder_page->ID ); ?>">
		<div class="hero-outer-circle"></div>		
		<h1 class="hero-tagline">
			<span><?php the_field( 'hero_title_1', $builder_page->ID ); ?></span>
			<?php the_field( 'hero_title_2', $builder_page->ID ); ?>
			<span><?php the_field( 'hero_title_3', $builder_page->ID ); ?></span>
		</h1>
	</div>
</section>
