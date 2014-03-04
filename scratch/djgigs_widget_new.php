add_action( 'widgets_init', 'register_accolades_widget' );
function register_accolades_widget() {
	register_widget( 'Accolades_Widget' );
}
class Accolades_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'accolades-widget', 'description' => __( 'Choose and display a single accolade' ) );
		$control_ops = array(  );
		parent::WP_Widget( 'accoladeswidget', __( 'Accolade' ), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args, EXTR_SKIP );
		echo $before_widget;

		$accolade_id = $instance['accolade'];
		$accolade = get_post( $accolade_id );

		echo $before_title . $accolade->post_title . $after_title;
		echo "<div class='accolade-{$accolade_id}'>{$accolade->post_content}</div>";

		echo $after_widget;
	} //end widget()

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;
		$instance['accolade'] = (int) $new_instance['accolade'];
		$instance['title'] = get_the_title( $instance['accolade'] );
		return $instance;

	} //end update()

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'accolade' => 0 ) );
		extract( $instance );
		?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="hidden" value="<?php echo $title; ?>" />
		<p>
			<label for="<?php echo $this->get_field_id('accolade'); ?>"><?php _e( 'Select an Accolade:' );?>
			<?php
				$accolades = get_posts( 'post_type=accolade&post_status=publish&numberposts=-1' );
				if ( count( $accolades ) > 0 ) {
					?><select class="widefat" id="<?php echo $this->get_field_id('accolade'); ?>" name="<?php echo $this->get_field_name('accolade'); ?>"><?php
					foreach( $accolades as $acc ) {
						$selected = selected( $acc->ID, $accolade, false );
						echo "<option value='{$acc->ID}'{$selected}>{$acc->post_title}</option>";
					}
					?></select><?php
				} else {
					echo '<em>'. __( 'No accolades were found' ) .'</em>';
				}
			?>
			</label>
		</p>
		<?php		
	} //end form()
}