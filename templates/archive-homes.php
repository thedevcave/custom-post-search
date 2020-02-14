<?php

/*
// Commented out for now, but we will need to do something like this eventually
// We might need to automatically create a Home Search/Find a Home style page on plugin activation
// Either that or maybe it would be fine to just show all results on the archive by default
if(!isset($_GET['s'])):
	header('Location: /home-search/');
endif;
*/


// We may need to just completely abandon QMIs for the initial version of the plugin
// It's very specific to UPAN and DMB, but not sure if it would make sense globally
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

session_start();

if((isset($_POST) && !empty($_POST)) || (isset($_GET) && !empty($_GET))){	
	if(isset($_REQUEST['beds-min'])){
		$_SESSION['beds-min'] = $_REQUEST['beds-min'];
	} else {
		$_SESSION['beds-min'] = 0;
	}
	if(isset($_REQUEST['baths-min'])){
		$_SESSION['baths-min'] = $_REQUEST['baths-min'];
	} else {
		$_SESSION['baths-min'] = 0;
	}
	if(isset($_REQUEST['sqft-min'])){
		$_SESSION['sqft-min'] = $_REQUEST['sqft-min'];
	} else {
		$_SESSION['sqft-min'] = 0;
	}
	if(isset($_REQUEST['price-min'])){
		$_SESSION['price-min'] = $_REQUEST['price-min'];
	} else {
		$_SESSION['price-min'] = 0;
	}
	if(isset($_REQUEST['price-max'])){
		$_SESSION['price-max'] = $_REQUEST['price-max'];
	} else {
		$_SESSION['price-max'] = 600000;
	}
	if(isset($_REQUEST['quick-move'])){
		$_SESSION['quick-move'] = $_REQUEST['quick-move'];
	} else {
		$_SESSION['quick-move'] = 'no';
	}
	if(isset($_REQUEST['builder'])){
		$_SESSION['builder'] = $_REQUEST['builder'];
	} else {
		$_SESSION['builder'] = '';
	}
	$_SESSION['wp_query'] = null;
} else {
	// resetting quick move-in in case they land directly on these results with no POST
	$_SESSION['quick-move'] = 'no';
}
// echo '$_REQUEST = '; print_r($_REQUEST);
// echo '<br />$_SESSION = '; print_r($_SESSION);

$beds_min = $_SESSION['beds-min'];
$baths_min = $_SESSION['baths-min'];
$sqft_min = $_SESSION['sqft-min'];
$price_min = $_SESSION['price-min'];
$price_max = $_SESSION['price-max'];
$quick_move = $_SESSION['quick-move'];
$builder = $_SESSION['builder'];
$quick_move_query = array();

if($quick_move == 'yes'){
	$quick_move_query['prop'] = 'post__in';
	$quick_move_query['value'] = $qmi_floorplans;
} else {
	$quick_move_query['prop'] = 'post__not_in';
	$quick_move_query['value'] = array();
}
if(!empty($builder)){
	$builder_query = array(
		'key' => 'builder',
		'value' => $builder,
		'compare' => '='
	);
} else {
	$builder_query = '';
}

get_header(); 

prop_get_template_part( 'homes/content', 'header-search' );

include(prop_locate_template( 'homes/content-results.php' ));

get_footer();