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
* References: https://codex.wordpress.org/
*/

/**
* Shortcode
* Reference: https://www.smashingmagazine.com/2012/05/wordpress-shortcodes-complete-guide/
*/
//Enque Shortcode Styles Sheet
function plugin_shortcodes_styles(){
	wp_enqueue_style('plugin-style', plugins_url('/css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'plugin_shortcodes_styles');

//Self-Closing Shortcode for Displaying List of Old Post First
function old_posts_shortcode($atts){
	extract(shortcode_atts(array(
		'listitle' => 'Old Post List Title', //heading
		'posts' => 4, //number of post to display
	), $atts
	));
	$return_list = '<ul class=oldpostlist>';
	query_posts(array(
		'ignore_sticky_posts' => true, //hide sticky posts
		'orderby' => 'date', //order by date
		'order' => 'ASC', //ascending order - old to new
		'showposts' => $posts //grab post to display
	));
	if (have_posts()) :
		while (have_posts()) : the_post();
			$return_list .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
		endwhile;
	endif;
	$return_list .= '</ul>';
	wp_reset_query();
	return '<div class="shortcode"><h2>'. $listitle . '</h2>' . $return_list . '</div>';
}
add_shortcode('old-posts', 'old_posts_shortcode');

//Enclosing Shortcode for PDF
function pdf_shortcode($atts, $url){
	extract(shortcode_atts(array(
		'title' => 'The Title', //heading
		'link' => 'https://www.google.com', //hyperlink text url
		'linktxt' => 'PDF Link', //hyperlink text
		'width' => '39em', //width of the iframe
		'height' => '50em' //height of the iframe
	), $atts));
	return '<div class="shortcode"><h2>' . $title . '</h2><p><a href="' . $link . '"class="the-link">' . $linktxt . '</a></p><iframe src="https://docs.google.com/viewer?url=' . $url . '&embedded=true" style="width:' . $width . '; height:' . $height . ';">Your browser does not support iframes</iframe></div>';
}
add_shortcode('pdf', 'pdf_shortcode');
