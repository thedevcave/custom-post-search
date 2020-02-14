<?php 
$logo = get_field( 'builder_logo' ); 

$builder_args = array(
	'post_type' => 'homes',
	'posts_per_page' => -1,
	'meta_query' => array(
		array(
			'key' => 'builder',
			'value' => $post->ID,
			'compare' => '='
		)
	)
);

$builder_homes = get_posts( $builder_args );
$homes_array = array();

foreach($builder_homes as $home){
	$homes_array[] = $home->ID;
}

$homes_query = array(
	'key' => 'floorplan',
	'value' => $homes_array,
	'compare' => 'IN'
);

$args = array(
	'posts_per_page' => -1,
	'post_status' => array('publish'),
	'post_type' => 'qmi',
	'meta_query' => array(
		$homes_query
	)
);

$qmi_loop = new WP_Query($args);
?>

<section id="builder_details">
	<header>
		<a href="/builders/"><i class="icon-left-big"></i> View all builders</a>
	</header>
	<article>
		
		<?php if(get_field( 'builder_website' )):
			echo "<a class='logo-block ".get_field( 'builder_color' )."' href='".get_field( 'builder_website' )."' target='_blank' rel='nofollow noopenner'>";
		else:
			echo "<div class='logo-block ".get_field( 'builder_color' )."'>";
		endif; ?>
			<img src="<?php echo $logo['url'] ?>" alt="<?php the_title(); ?>" />
		<?php if(get_field( 'builder_website' )):
			echo "</a>";
		else:
			echo "</div>";
		endif; ?>
		<div class="builder-info">
			<div class="builder-content">
				<?php the_field( 'builder_content' ); ?>
				<div class="builder-links">
					<a href="<?php the_field( 'builder_website' ); ?>" target="_blank" rel="nofollow noopenner">Visit <?php the_title(); ?> Website<i class="icon-right-big"></i></a><br>
					<?php if ( $qmi_loop->have_posts() ):
						echo "<a href='/quick-move-in-homes/?builder=".$post->ID."'>Quick Move-In Homes<i class='icon-right-big'></i></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					endif; ?>
				</div>
			</div>
			<div class="location">
				<?php while(have_rows( 'builder_contact' )): the_row(); ?>
					<address>
						<h4>Contact</h4>
						<?php echo get_sub_field( 'street_address' ) ? get_sub_field( 'street_address' )."<br />" : ""; ?>
						<?php echo get_sub_field( 'city' ) ? get_sub_field( 'city' )."," : ""; ?> <?php echo get_sub_field( 'state' ) ? get_sub_field( 'state' ) : ""; ?> <?php echo get_sub_field( 'zipcode' ) ? get_sub_field( 'zipcode' ) : ""; ?><?php echo get_sub_field( 'city' ) || get_sub_field( 'state' ) || get_sub_field( 'zipcode' ) ? "<br />" : ""; ?>
						<?php echo get_sub_field( 'phone' ) ? "<a class='btn btn-teal-outline' href='tel:".get_sub_field( 'phone' )."'>".get_sub_field( 'phone' )."</a><br />" : ""; ?>
						<?php
							$builder_map_type = get_field( 'builder_map_type' );
							switch($builder_map_type){
								case 'address':
									echo "<a href=\"https://www.google.com/maps/search/?api=1&query=".urlencode(get_sub_field( 'street_address' )).",+".urlencode(get_sub_field( 'city' )).",+".urlencode(get_sub_field( 'state' ))."+".urlencode(get_sub_field( 'zipcode' ))."\" target=\"_blank\" rel=\"nofollow noopenner\">Map It<i class=\"icon-location\"></i></a>";
									break;
									
								case 'custom':
									echo "<a href=\"".get_field( 'custom_map_it_link' )."\" target=\"_blank\" rel=\"nofollow noopenner\">Get Directions<i class=\"icon-location\"></i></a>";
									break;
									
								case 'disable':
									break;
							}
						?>
					</address>
					<?php $builder_email = get_sub_field( 'email' ); ?>
				<?php endwhile; ?>
				
				<?php if(have_rows( 'builder_hours' )): ?>
				<div class="hours">
					<h4>Hours</h4>
					<ul>
					<?php while(have_rows( 'builder_hours' )): the_row(); ?>
						<li class="label"><?php the_sub_field( 'days' ); ?></li>
						<li class="value"><?php the_sub_field( 'hours' ); ?></li>
					<?php endwhile; ?>
					</ul>
				</div>
				<?php endif; ?>
				
				<a href="javascript:void(0);" class="btn btn-teal sendinfo">Request More Info</a>
			</div>
		</div>
		
	</article>
</section>

<div id="send_info_overlay" data-builder="<?php the_title(); ?>" data-builderemail="<?php echo $builder_email; ?>">
	<div class="overlay-bg"></div>
	<div class="overlay-content">
		<article>
			<h4>Send me info about <?php the_title(); ?> at Union Park in Norterra</h4>
			<?php echo do_shortcode( '[contact-form-7 id="546" title="Send Me Info"]' ); ?>
			
			<a href="javascript:void(0);" class="close"><i class="icon-cancel"></i></a>
		</article>
	</div>
</div>
