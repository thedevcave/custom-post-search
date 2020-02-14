<?php include(prop_locate_template( 'homes/script-home-variables.php' )); ?>

<div class="home-result">

	<?php if( $images ): ?>
		<a class="model-image" href="<?php the_permalink(); ?>" class="image" style="background: url(<?php echo $images[0]['sizes']['floorplan-thumbnail']; ?>) center center no-repeat; background-size: cover;">
			<?php echo $quick_movein ? "<div class='quick-move'><i class='icon-star'></i> Quick Move In</div>" : ""; ?>
			<?php echo $model ? "<div class='model'><i class='icon-home'></i> Model</div>" : ""; ?>
			<div class="hover"><div class="btn btn-white-outline">View Home Details</div></div>
		</a>
	<?php endif; ?>

	<div class="model-details">
		<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br /><span>// <a href="<?php get_the_permalink($builder->ID); ?>"><?php echo $builder->post_title; ?></a></span></h4>
		
		<?php echo $squareFootage; ?> Sq Ft // <?php echo $totalBeds; ?> Beds // <?php echo $totalBaths; ?> Baths<br />
		<?php
			if($priceRange[0] == "tbd"):
				echo 'Price TBD'; 
			elseif(!empty($priceRange[1])):
				echo 'Priced from '.$priceRange[0].' $' . $priceRange[1] . '\'s'; 
			endif; 
		?>
	</div>

</div>