<?php 

if ( ! defined( 'WPINC' ) ) {
	die;
}

class PropRegisterCPT {

	/***********************************************
	 *** WooCommerce-related Hooks and Functions ***
	 ***********************************************/

	// Static class
	protected static $instance;

	public static function instance() {
		if ( is_null( static::$instance ) ) {
			static::$instance = new static();
		}

		return static::$instance;
	}

	// Class constructor
	public function __construct() {

		$this->registerHooks();

		do_action( 'propertiesplugin/register-cpt/init' );

	}


	private function registerHooks() {
		
		add_action( 'init', [ $this, 'prop_register_post_types' ] );
		add_action( 'save_post', [ $this, 'prop_save_min_bed_bath' ], 10, 3 );
		add_filter( 'posts_orderby', [ $this, 'prop_custom_builders_order' ] );
		add_filter( 'template_include', [ $this, 'prop_load_templates' ] );

	}
	
	// Register Custom Post Type
	public function prop_register_post_types() {
	
		$homes_labels = array(
			'name'                => 'Homes',
			'singular_name'       => 'Home',
			'menu_name'           => 'Homes',
			'parent_item_colon'   => 'Parent Home:',
			'all_items'           => 'All Homes',
			'view_item'           => 'View Home',
			'add_new_item'        => 'Add New Home',
			'add_new'             => 'Add New',
			'edit_item'           => 'Edit Home',
			'update_item'         => 'Update Home',
			'search_items'        => 'Search homes',
			'not_found'           => 'No homes found',
			'not_found_in_trash'  => 'No homes found in Trash',
		);
		$homes_rewrite = array(
			'slug'                => 'homes',
			'with_front'          => true,
			'pages'               => true,
			'feeds'               => true,
		);
		$homes_args = array(
			'label'               => 'homes',
			'description'         => 'Homes in Union Park at Norterra',
			'labels'              => $homes_labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 6,
	        'menu_icon'           => 'dashicons-admin-home',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $homes_rewrite,
			'capability_type'     => 'page',
		);
		register_post_type( 'homes', $homes_args );
		
		
		$builder_labels = array(
			'name'                  => _x( 'Builders', 'Builder General Name', 'verrado' ),
			'singular_name'         => _x( 'Builder', 'Builder Singular Name', 'verrado' ),
			'menu_name'             => __( 'Builders', 'verrado' ),
			'name_admin_bar'        => __( 'Builder', 'verrado' ),
			'archives'              => __( 'Builder Archives', 'verrado' ),
			'attributes'            => __( 'Builder Attributes', 'verrado' ),
			'parent_item_colon'     => __( 'Parent Builder:', 'verrado' ),
			'all_items'             => __( 'All Builders', 'verrado' ),
			'add_new_item'          => __( 'Add New Builder', 'verrado' ),
			'add_new'               => __( 'Add New', 'verrado' ),
			'new_item'              => __( 'New Builder', 'verrado' ),
			'edit_item'             => __( 'Edit Builder', 'verrado' ),
			'update_item'           => __( 'Update Builder', 'verrado' ),
			'view_item'             => __( 'View Builder', 'verrado' ),
			'view_items'            => __( 'View Builders', 'verrado' ),
			'search_items'          => __( 'Search Builder', 'verrado' ),
			'not_found'             => __( 'Not found', 'verrado' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'verrado' ),
			'featured_image'        => __( 'Featured Image', 'verrado' ),
			'set_featured_image'    => __( 'Set featured image', 'verrado' ),
			'remove_featured_image' => __( 'Remove featured image', 'verrado' ),
			'use_featured_image'    => __( 'Use as featured image', 'verrado' ),
			'insert_into_item'      => __( 'Insert into builder', 'verrado' ),
			'uploaded_to_this_item' => __( 'Uploaded to this builder', 'verrado' ),
			'items_list'            => __( 'Builders list', 'verrado' ),
			'items_list_navigation' => __( 'Builders list navigation', 'verrado' ),
			'filter_items_list'     => __( 'Filter builder list', 'verrado' ),
		);
		$builder_args = array(
			'label'                 => __( 'Builder', 'verrado' ),
			'description'           => __( 'Builders in Verrado', 'verrado' ),
			'labels'                => $builder_labels,
			'supports'              => array( 'title', 'editor', 'page-attributes' ),
			'hierarchical'          => true,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-admin-multisite',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		register_post_type( 'builders', $builder_args );
	
	}
	
	
	
	/**
	 * Save min bed and bath post metadata when a homes post is saved.
	 *
	 * @param int $post_id The post ID.
	 * @param post $post The post object.
	 * @param bool $update Whether this is an existing post being updated or not.
	 */
	public function prop_save_min_bed_bath( $post_id ) {
	
	    $post_type = get_post_type($post_id);
	
	    // If this isn't a 'book' post, don't update it.
	    if ( "homes" != $post_type ) return;
	
	    // - Update the post's metadata.
	
	    if ( isset( $_POST['bedrooms'] ) ) {
	        update_post_meta( $post_id, 'min_beds', sanitize_text_field( min($_POST['bedrooms']) ) );
	    }
	
	    if ( isset( $_POST['bathrooms'] ) ) {
	        update_post_meta( $post_id, 'min_baths', sanitize_text_field( min($_POST['bathrooms']) ) );
	    }
	}
	
	public function prop_custom_builders_order( $orderby ) {
		global $wpdb;
		
		// Check if the query is for an archive
		if ( is_archive() && get_query_var("post_type") == "builders" ) {
			// Query was for archive, then set order
			return "$wpdb->posts.post_title ASC";
		}
		
		return $orderby;
	}
	
	/* Filter the single_template with our custom function*/
	public function prop_load_templates( $template ) {

	  if ( is_post_type_archive('builders') ) {
	    $theme_files = array('archive-builders.php', 'properties/archive-builders.php');
	    $exists_in_theme = locate_template($theme_files, false);
	    if ( $exists_in_theme != '' ) {
	      return $exists_in_theme;
	    } else {
	      return PROP_PLUGIN_ABSPATH . '/templates/archive-builders.php';
	    }
	  }
	  if ( is_singular('builders') ) {
	    $theme_files = array('single-builders.php', 'properties/single-builders.php');
	    $exists_in_theme = locate_template($theme_files, false);
	    if ( $exists_in_theme != '' ) {
	      return $exists_in_theme;
	    } else {
	      return PROP_PLUGIN_ABSPATH . '/templates/single-builders.php';
	    }
	  }
	  
	  if ( is_post_type_archive('homes') ) {
	    $theme_files = array('archive-homes.php', 'properties/archive-homes.php');
	    $exists_in_theme = locate_template($theme_files, false);
	    if ( $exists_in_theme != '' ) {
	      return $exists_in_theme;
	    } else {
	      return PROP_PLUGIN_ABSPATH . '/templates/archive-homes.php';
	    }
	  }
	  if ( is_singular('homes') ) {
	    $theme_files = array('single-homes.php', 'properties/single-homes.php');
	    $exists_in_theme = locate_template($theme_files, false);
	    if ( $exists_in_theme != '' ) {
	      return $exists_in_theme;
	    } else {
	      return PROP_PLUGIN_ABSPATH . '/templates/single-homes.php';
	    }
	  }
	  
	  return $template;
	}
}