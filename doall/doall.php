<?php
/*
	* Plugin Name: doall
	* Plugin URI: https://phoenix.sheridanc.on.ca/~ccit3678/
	* Description: Assignment 2 - a WordPress plugin that adds a custom post type, a widget that display a set number of posts in recent order and display featured image for each post, and a shortcode that displaying list of old post first and pdf.
	* Author: Hyue Lin Kang
	* Author URI: https://phoenix.sheridanc.on.ca/~ccit3678/
	* Version: 1.0
*/
//Enque Styles Sheet for Plugin
function plugin_stylesheet(){
	wp_enqueue_style('plugin-style', plugins_url('/css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'plugin_stylesheet');

/**
* Custom Post Type
*/
function doall_post_type() {
  register_post_type('custom_post',
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
      	'show_in_admin_bar' => false, //Disable appearing on WordPress admin bar.
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
	));
	wp_reset_query();
}
add_action('init', 'doall_post_type');


/**
* Widget
* References: https://codex.wordpress.org/ & https://en-ca.wordpress.org/plugins/custom-post-type-widgets/
*/
// Create the Widget
class CustomPostDisplayWidget extends WP_Widget {

	// Initialize the Widget
	public function __construct(){
		$widget_ops = array(
			'classname' => 'widget_doall',
			'description' => __( 'Display a set number of posts from the custom post type in a set order, and will also display the featured image for each post.'
		));
		// Adds a class to the widget and provides a description on the Widget page to describe what the widget does.
		parent::__construct( 'custompostype_recentposts', __('doall Widget'), $widget_ops );
		$this->alt_option_name = 'widget_custompostype_recentposts';
	}

	// Determines what will appear on the site
	public function widget($args, $instance){
		if (! isset($args['widget_id'])){
			$args['widget_id'] = $this->id;
		}
		$title = apply_filters('widget_title', empty( $instance['title']) ? __('doall Widget') : $instance['title'], $instance, $this->id_base);
		// Determines if there's a user-provided title and if not, displays a default title.
		$postype = $instance['postype'];
		if (empty( $instance['number']) || ! $number = absint($instance['number'])){
			$number = 4;
		}
		// Determines if there's a user-provided number and if not, displays a default number of posts.
		$show_featuredimage = isset($instance['show_featuredimage']) ? $instance['show_featuredimage'] : false;
		// sets a variable for whether or not the 'Featured Image' option is checked
		$show_grid = isset($instance['show_grid']) ? $instance['show_grid'] : false;
		// sets a variable for whether or not the 'Grid' option is checked
		$posttypes = get_post_types(array('public' => true), 'name');
		// Determines user choose type of post to display.
		if (array_key_exists($postype, (array) $posttypes)){
			$r = new WP_Query(apply_filters('widget_posts_args', array(
				'post_type' => $postype,
				'posts_per_page' => $number,
				'no_found_rows' => true,
				'post_status' => 'publish',
				'ignore_sticky_posts' => true,
			)));
			// Combining user-provided information to display accordingly.
			if ($r->have_posts()) : ?>
				<?php echo $args['before_widget']; ?>
				<?php if ($title){
					echo $args['before_title'] . $title . $args['after_title'];
				} ?><?php
				while ($r->have_posts()) : $r->the_post(); ?><?php
					if ($show_featuredimage) :
						if ($show_grid) : ?>
							<div class="gridimage">
								<a class="gridimage" href="<?php the_permalink() ?>"><?php echo get_the_post_thumbnail(); ?></a>
							</div><?php // User checked featured image and show grid.
						else : ?>
							<ul>
								<li>
									<a href="<?php the_permalink() ?>"><?php echo get_the_post_thumbnail() . get_the_title(); ?></a>
								</li> 
							</ul><?php // User checked featured image.
						endif; ?><?php
					elseif ($show_grid) : ?>
						<ul class="gridtitle">
							<li class="gridtitle">
								<a href="<?php the_permalink() ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</li>
						</ul><?php // User checked show grid.
					else : ?>	
						<ul>
							<li>
								<a href="<?php the_permalink() ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
							</li>
						</ul><?php // User didn't select any custom options, so display default.
					endif; ?><?php
				endwhile; ?>
				<?php echo $args['after_widget']; ?><?php
				wp_reset_postdata();
			endif;
		}
	}
	// Sets up the form for users to set their options/add content in the widget admin page.
	public function form($instance) {
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$postype = isset($instance['postype']) ? $instance['postype']: 'post';
		$number = isset($instance['number']) ? absint($instance['number']) : 4;
		$show_featuredimage = isset($instance['show_featuredimage']) ? (bool) $instance['show_featuredimage'] : false;
		$show_grid = isset($instance['show_grid']) ? (bool) $instance['show_grid'] : false; ?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php
			$posttypes = get_post_types(array(
				'public' => true 
				),
			'name'
			);

			printf(
				'<p><label for="%1$s">%2$s</label>' .
				'<select class="widefat" id="%1$s" name="%3$s">',
				$this->get_field_id('postype'),
				__('Post Type:'),
				$this->get_field_name('postype')
			);

			foreach ($posttypes as $post_type => $value){
				if ('attachment' === $post_type){
					continue;
				}

				printf(
					'<option value="%s"%s>%s</option>',
					esc_attr($post_type),
					selected($post_type, $postype, false),
					__($value->label)
				);

			}
			echo '</select></p>';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:'); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_featuredimage ); ?> id="<?php echo $this->get_field_id( 'show_featuredimage' ); ?>" name="<?php echo $this->get_field_name( 'show_featuredimage' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_featuredimage' ); ?>"><?php _e( 'Display featured image'); ?></label></p>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_grid ); ?> id="<?php echo $this->get_field_id( 'show_grid' ); ?>" name="<?php echo $this->get_field_name( 'show_grid' ); ?>" />
			<label for="<?php echo $this->get_field_id( 'show_grid' ); ?>"><?php _e( 'Display as grid'); ?></label>
		</p>
<?php }
	// Sanitizes, saves and submits the user-generated content.
	public function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['postype'] = strip_tags($new_instance['postype']);
		$instance['number'] = (int) $new_instance['number'];
		$instance['show_featuredimage'] = isset($new_instance['show_featuredimage']) ? (bool) $new_instance['show_featuredimage'] : false;
		$instance['show_grid'] = isset($new_instance['show_grid']) ? (bool) $new_instance['show_grid'] : false;
		return $instance;
	}
}
// Tells WordPress that this widget has been created and that it should display in the list of available widgets.
add_action('widgets_init', function(){
     register_widget('CustomPostDisplayWidget');
});

/**
* Shortcode
* Reference: https://www.smashingmagazine.com/2012/05/wordpress-shortcodes-complete-guide/
*/
//Self-Closing Shortcode for Displaying List of Old Post
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
// Tells WordPress that this shortcode has been created for users to use.
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
// Tells WordPress that this shortcode has been created for users to use.
add_shortcode('pdf', 'pdf_shortcode');