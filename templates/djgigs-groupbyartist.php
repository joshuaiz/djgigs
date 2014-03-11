<?php

// WP_Query arguments
$args = array (
	'post_type'              => 'djgig_artist',
	'post_status'            => 'publish',
	'pagination'             => true,
	'posts_per_page'         => '10',
	'posts_per_archive_page' => '10',
);

// The Query
$artists = new WP_Query( $args );

// The Loop
if ( $artists->have_posts() ) {
	while ( $artists->have_posts() ) {
		$artists->the_post(); ?>

		<article>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>
 
			


						<?php 
 
						/*
						*  Query posts for a relationship value.
						*  This method uses the meta_query LIKE to match the string "123" to the database value a:1:{i:0;s:3:"123";} (serialized array)
						*/
 						$time = current_time( 'timestamp' ); // Get localised unix timestamp

						$djgigs = get_posts(array(
							'post_type' => 'djgig',
							'meta_query' => array(
								array(
									'key' => 'djgigs_artist', // name of custom field
									'value' => '"' . get_the_ID() . '"', // matches exaclty "123", not just 123. This prevents a match for "1234"
									'compare' => 'LIKE'
								)
							)
						));
 
						?>
						<?php if( $djgigs ): ?>
							
							<?php foreach( $djgigs as $djgig ): ?>
								
 
			

	<table class="djgigs-table djgigs-summary-table">
		<tbody>
			<tr class="djgigs-summary-row">
			

				<td class="djgigs-title">
					<strong><a href="<?php echo get_permalink( $djgig->ID ); ?>"><?php echo get_the_title( $djgig->ID ); ?></a></strong>
				</td>
	
				
				
				
			</tr>
		</tbody>
	</table>

<?php endforeach; ?>		
 <?php endif; ?>	
<?php
	}
} else {
	// no posts found
}

// Restore original Post Data
wp_reset_postdata(); ?>
