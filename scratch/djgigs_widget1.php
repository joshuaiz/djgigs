/* DJ Gigs Widget */

add_action( 'widgets_init', 'djgigs_register_widgets' );

function djgigs_register_widgets() {

	register_widget( 'DJGigsWidget' );

}


class DJGigsWidget extends WP_Widget
{
  function DJGigsWidget()
  {
    $widget_ops = array('classname' => 'djgigs-widget', 'description' => 'Show the latest Gigs' );
    $this->WP_Widget('djgigs-widget', 'Featured DJ Gigs', $widget_ops);
  }

  function form($instance)
  {
  	$defaults = array(
				'title' => 'DJ Gigs' );
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
 
?>
  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>

  
<?php
  }

  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }

  function widget($args, $instance)
  {
    extract($args, EXTR_SKIP);

    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

    if (!empty($title))
      echo $before_title . $title . $after_title;;

    // WIDGET CODE GOES HERE
    ?>
      <ul class="featured-djgigs">
      <?php	// Set up our djgig Loop using WP_Query
	
	$args = array (
		'post_type'              => 'djgig',
		'post_status'            => 'publish',
		'orderby' 				 => 'meta_value_num',
		'meta_key' 				 => 'djgigs_event_start_date', // order djgigs by date
		'order' 				 => 'ASC',
		'posts_per_page'         => '8',
	);
	
	// The Query
	$djgigsquery = new WP_Query( $args );
	
	// The Loop
	if ( $djgigsquery->have_posts() ) { 
		while ( $djgigsquery->have_posts() ) { 
			$djgigsquery->the_post(); ?>
        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
      <?php }
  }
   wp_reset_postdata(); ?>

      <li class="see-all-djgigs"><a href="<?php echo get_post_type_archive_link( 'djgig' ); ?>">See All</a></li>
      </ul>
  	
    <?php echo $after_widget;
  }

}