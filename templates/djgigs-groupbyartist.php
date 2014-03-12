<?php
/* 
*	Set up our table header row. Make it a separate table so it is outside of The Loop.
*  	This places a single header row at the top.
*   If you want this row repeated for each event, copy this table and paste it just after the custom Loop call before table.djgigs-info-table.
*   
*/
?>



<?php	// Set up our djgig_artist Loop using WP_Query
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

		
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header>
 
			<table class="djgigs-table djgigs-header-table">
	<tbody>
	  <tr class="djgigs-header-row">
	    <th class="djgigs-date">Date</th>
	    <th class="djgigs-event-image-header">Image</th>
	    <th class="djgigs-title">Event Title</th>
	    <th class="djgigs-venue">Venue</th>
	    <th class="djgigs-city">City</th>
	    <th class="djgigs-country">Country</th>
	    <th class="djgigs-expand-heading">See More</th>
	  </tr>
	</tbody>
</table>


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
								
			<?php $startDate = get_field( 'djgigs_event_start_date', $djgig->ID ); // Get event start date + time ?>
	<?php if ( $startDate >= strtotime('-1 day', $time ) ) : // If events are in the past 24 hours or in the future, then show. ?>

	<table class="djgigs-table djgigs-summary-table">
		<tbody>
			<tr class="djgigs-summary-row">
				<?php if( get_field('djgigs_event_start_date', $djgig->ID) ): ?>
				<td class="djgigs-date-time djgigs-date">
					<?php $start = get_field('djgigs_event_start_date', $djgig->ID); echo date_i18n('Y-m-d', $start);  ?>
				</td>
				<?php endif; ?>
				<td class="djgigs-event-image-header djgigs-event-image-1">
					<a href="<?php the_field('djgigs_event_image_1', $djgig->ID); ?>" rel="lightbox"><img class="djgigs-event-image-img" src="<?php the_field('djgigs_event_image_1', $djgig->ID); ?>" height="48px" width="48px"/></a>
				</td>

				<td class="djgigs-title">
					<strong><a href="<?php echo get_permalink( $djgig->ID ); ?>"><?php echo get_the_title( $djgig->ID ); ?></a></strong>
				</td>
				<?php $venues = get_field( 'djgigs_venue', $djgig->ID ); 
					if( $venues ): ?>
				<td class="djgigs-title">
					
    					<?php foreach( $venues as $v):  ?>
					<strong><a href="<?php echo get_permalink( $v->ID ); ?>"><?php echo get_the_title( $v->ID ); ?></a></strong>
					
				</td>

				<td class="djgigs-venue-city-state djgigs-city">
					<?php the_field('djgigs_venue_city', $v->ID); ?><?php if( get_field('djgigs_venue_state', $v->ID) ): ?>, <?php the_field('djgigs_venue_state', $v->ID); ?><?php endif; ?>
				</td>
				<td class="djgigs-venue-country djgigs-country">
					<?php the_field('djgigs_venue_country', $v->ID); ?>
				</td>

				<td class="djgigs-expand">
					<a class="djgigs-table-trigger" href="#"><span>+</span></a> <?php // trigger to show/hide more info table below ?>
				</td>

	
				<?php endforeach; ?>		
 					<?php endif; ?>	
			<?php endif; ?>	
				
				
			</tr>
		</tbody>
	</table>

	<table id="post-<?php the_ID(); ?>" class="djgigs-table gig-table djgigs-detail-table">
		<tbody>
			<tr class="djgigs-event-image-info">
			
				<td class="djgigs-event-image-1 djgigs-event-image" colspan="1">
					<div>
						<a href="<?php the_field('djgigs_event_image_1', $djgig->ID); ?>" rel="lightbox"><img class="djgigs-event-image-img" src="<?php the_field('djgigs_event_image_1', $djgig->ID); ?>" /></a>
					</div>
				</td>
				<td class="djgigs-event-info" colspan="4" rowspan="1">
					<?php the_field('djgigs_event_info', $djgig->ID); ?>
				</td>
			</tr>
			<?php if( get_field('djgigs_event_image_2', $djgig->ID) ): ?>
			<tr>
				<td class="djgigs-event-image-2 djgigs-event-image" colspan="1">
					<div>
						<img class="djgigs-event-image-img" src="<?php the_field('djgigs_event_image_2', $djgig->ID); ?>" />
					</div>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
			<?php if( get_field('djgigs_event_start_date', $djgig->ID) ): ?>
				<td class="djgigs-event-date-time" colspan="5">
					<?php $startdate = get_field('djgigs_event_start_date', $djgig->ID); ?>
					<?php $enddate = get_field('djgigs_event_end_date', $djgig->ID); ?>
					<span class="djgigs-event-date"><?php echo date_i18n('l, F j, Y', $startdate);  ?></span> <span class="separator">|</span> <span class="djgigs-event-start-time"><?php echo date_i18n('g:ia', $startdate); ?> <?php if( get_field('djgigs_event_end_date') ): ?>- <?php echo date_i18n('g:ia', $enddate ); ?><?php endif; ?></span> <?php if( get_field('djgigs_event_price', $djgig->ID) ): ?><span class="separator">|</span> <span class="djgigs-event-price"><?php the_field('djgigs_event_price', $djgig->ID); ?></span><?php endif; ?>
				</td>
			<?php endif; ?>
			</tr>
			<tr>
			<?php $posts = get_field('djgigs_venue', $djgig->ID); // Relationship field
 					if( $posts ): ?>
 					<td class="djgigs-google-map" colspan="6">
    				<?php foreach( $posts as $p):  ?>
    				<?php $vmap = get_field('djgigs_venue_google_map', $p->ID); ?>
        				<div class="acf-map">
							<div class="marker" data-lat="<?php echo $vmap['lat']; ?>" data-lng="<?php echo $vmap['lng']; ?>"></div>
						</div>
					<?php endforeach; ?>
					</td>
					<?php endif; // end our custom Loop within the loop ?>
									   
			</tr>
			<tr>
			<?php // Get Venue post object so we can grab elements from it in a custom Loop ?>
				<?php 
					$posts = get_field('djgigs_venue', $djgig->ID); // Relationship field
 					if( $posts ): ?>
    					<?php foreach( $posts as $p):  ?>
				<td class="djgigs-venue-name djgigs-table-border">
					<a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a>
				</td>
				<td class="djgigs-venue-info djgigs-table-border">
					<?php the_field('djgigs_venue_address', $p->ID); ?> <?php the_field('djgigs_venue_city', $p->ID); ?><?php if( get_field('djgigs_venue_state', $p->ID )): ?>, <?php the_field('djgigs_venue_state', $p->ID); ?><?php endif; ?> <?php the_field('djgigs_venue_postcode', $p->ID); ?> <?php the_field('djgigs_venue_country', $p->ID); ?>
				</td>
						<?php endforeach; ?>
					<?php endif; // end our custom Loop within the loop ?>
			</tr>									  
			<tr>
			<?php if( get_field('djgigs_event_price') ): ?>
				<td class="djgigs-event-price">
					Price: <?php the_field('djgigs_event_price', $djgig->ID); ?>
				</td>
			<?php endif; ?>
			
				<td class="djgigs-ticket-url" colspan="4">
				<?php if( get_field('djgigs_ticket_url', $djgig->ID) ): ?>
					Buy Tickets: <a href="<?php the_field('djgigs_ticket_url', $djgig->ID); ?>"><?php the_field('djgigs_ticket_url', $djgig->ID); ?></a>
				<?php endif; ?>
				</td>
			</tr>		
			<tr>
			<?php if( get_field('djgigs_event_url_1', $djgig->ID) ): ?>
				<td class="djgigs-event-url-label">
					Event URL:
				</td>
				<td class="djgigs-event-url-1 djgigs-event-url" colspan="4">
					<a href="<?php the_field('djgigs_event_url_1', $djgig->ID); ?>"><?php the_field('djgigs_event_url_1', $djgig->ID); ?></a>
				</td>
			<?php endif; ?>
			</tr>	
		  	<tr>
		  	<?php if( get_field('djgigs_event_url_2', $djgig->ID) ): ?>
		    	<td class="djgigs-event-url-label">
		    		Event URL:
		    	</td>
		    	<td class="djgigs-event-url-2 djgigs-event-url" colspan="4">
		    		<a href="<?php the_field('djgigs_event_url_2', $djgig->ID); ?>"><?php the_field('djgigs_event_url_2', $djgig->ID); ?></a>
		    	</td>
		    <?php endif; ?>
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
