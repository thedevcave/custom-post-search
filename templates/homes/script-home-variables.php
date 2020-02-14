<?php 

global $qmi_floorplans;

if(empty($qmi_floorplans)):
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
endif;
	
$builder = get_field('builder');
$builder_email = get_post_meta( $builder->ID, 'builder_contact_0_email', true );
$images = get_field('model_images');
$floorplan_images = get_field('floorplan_images');
$floorplan_file = get_field('floorplan_file');

// Assign Custom Fields values to variables
$minBeds = min(get_field('bedrooms'));
$maxBeds = max(get_field('bedrooms'));
if($minBeds == $maxBeds):
	$totalBeds = $maxBeds;
else:
	$totalBeds = $minBeds . '-' . $maxBeds;
endif;
$minBaths = min(get_field('bathrooms'));
$maxBaths = max(get_field('bathrooms'));
if($minBaths == $maxBaths):
	$totalBaths = $maxBaths;
else:
	$totalBaths = $minBaths . '-' . $maxBaths;
endif;

$minStories = min(get_field('stories'));
$maxStories = max(get_field('stories'));
if($minStories == $maxStories):
	$totalStories = $maxStories;
else:
	$totalStories = $minStories . '-' . $maxStories;
endif;

$minCarGarage = min(get_field('car_garage'));
$maxCarGarage = max(get_field('car_garage'));
if($minCarGarage == $maxCarGarage):
	$totalCarGarage = $maxCarGarage;
else:
	$totalCarGarage = $minCarGarage . '-' . $maxCarGarage;
endif;

$squareFootage = number_format(intval(get_field('square_footage')));
$startingPrice = get_field('starting_price');
$priceRange = explode("-", get_field('price_range'));
$quick_movein = in_array($post->ID, $qmi_floorplans);
$model = get_field('model_available');
