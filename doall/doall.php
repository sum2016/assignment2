<?php
/*
	* Plugin Name: doall
	* Plugin URI: https://phoenix.sheridanc.on.ca/~ccit3678/
	* Description: Assignment 2 - a WordPress plugin that adds a custom post type, a widget, and a shortcode
	* Author: Hyue Lin Kang
	* Author URI: https://phoenix.sheridanc.on.ca/~ccit3678/
	* Version: 1.0
*/

/**
* Custom Post Type
*/
function doall_post_type() {
  register_post_type( 'custom_post',
    array(
    	'labels' => array( //customize label texts
    		'name' => 'Custom Post',
    		'singular_name' => 'Custom Post',
    		'add_new' => 'Add Custom Post',
    		'add_new_item' => 'Add New Custom Post',
      		'edit_item' => 'Edit Custom Post',
      		'new_item' => 'New Custom Post',
      		'view_item' => 'View Custom Post',
      		'search_items' => 'Search Custom Post',
      		'not_found' => 'No Custom Post Found',
      		'not_found_in_trash' => 'No Custom Post has been trashed',
      		'parent_item_colon' => 'Parent Custom Post',
      		'all_items' => 'All Custom Post'
      	),
      	'public' => true, //controls visibility
      	'menu_position' => 5, //menu position - 5 sets it below posts
      	'menu_icon' => 'dashicons-admin-post', //change menu icon to home icon & Reference: https://developer.wordpress.org/resource/dashicons/#portfolio
      	'hierarchical' => true, // Enables hierarchial structure
      	'supports' => array( //Enables listed features while creating post
      		'title',
      		'editor',
      		'author',
      		'thumbnail',
      		'excerpt'
      	),
      	'taxonomies' => array( //Enables category and tags
      		'category',
      		'post_tag'
      	),
      	'has_archive' => true, //Enables post type archives
      	'can_export' => false //Disable post export
	)  
  );

	
}
add_action( 'init', 'doall_post_type' );

/**
* Widget
*/

/**
* Shortcode
*/