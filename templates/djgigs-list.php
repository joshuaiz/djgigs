<?php
/* 
*	Set up our table header row. Make it a separate table so it is outside of The Loop.
*  	This places a single header row at the top.
*   If you want this row repeated for each event, copy this table and paste it just after the custom Loop call before table.djgigs-info-table.
*   
*/
?>


<table class="djgigs-table djgigs-header-table">
	<tbody>
	  <tr class="djgigs-header-row">
	    <th class="djgigs-date">Date</th>
	    <th class="djgigs-event-image-header">Image</th>
	    <th class="djgigs-title">Event Title</th>
	    <th class="djgigs-artist">Artist</th>
	    <th class="djgigs-venue">Venue</th>
	    <th class="djgigs-city">City</th>
	    <th class="djgigs-country">Country</th>
	    <th class="djgigs-expand-heading">See More</th>
	  </tr>
	</tbody>
</table>

<?php	// Set up our djgig Loop using WP_Query
	
	$time = current_time( 'timestamp' ); // Get localised unix timestamp

	// Set up custom query with meta_query to compare event start date with today's date
		$args = array (
		'post_type'              => 'djgig',
		'post_status'            => 'publish',
		'orderby' 				 => 'meta_value_num',
		'meta_key' 				 => 'djgigs_event_start_date', // order djgigs by date
		'meta_value_num'    	 => $time,
		'meta_compare'      	 => '>=',
		'order' 				 => 'ASC',
		'posts_per_page'         => 'number',
		);
	
	// The Query
	$djgigsquery = new WP_Query( $args );
	
	// The Loop
	if ( $djgigsquery->have_posts() ) { 
		while ( $djgigsquery->have_posts() ) { 
			$djgigsquery->the_post(); ?>
	
	<?php $startDate = get_field( 'djgigs_event_start_date' ); // Get event start date + time ?>
	<?php if ( $startDate >= strtotime('-1 day', $time ) ) : // If events are in the past 24 hours or in the future, then show. ?>

	<?php // If you want a header row for each djgig, copy the header table above and place it here so it's inside The Loop. ?>

	<table class="djgigs-table djgigs-summary-table">
		<tbody>
			<tr class="djgigs-summary-row">
				<?php if( get_field('djgigs_event_start_date') ): ?>
				<td class="djgigs-date-time djgigs-date">
					<?php $start = get_field('djgigs_event_start_date'); echo date_i18n('Y-m-d', $start);  ?>
				</td>
				<?php endif; ?>
				<td class="djgigs-event-image-header djgigs-event-image-1">
					<a href="<?php the_field('djgigs_event_image_1'); ?>" rel="lightbox"><img class="djgigs-event-image-img" src="<?php the_field('djgigs_event_image_1'); ?>" height="48px" width="48px"/></a>
				</td>

				<td class="djgigs-title">
					<strong><?php the_title(); ?></strong>
				</td>
				<td class="djgigs-artist">
					<?php $posts = get_field('djgigs_artist'); // Relationship field
 					if( $posts ): ?>
    				<?php foreach( $posts as $p):  ?>
    					<a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a>	
					<?php endforeach; ?>
					<?php endif; // end our custom Loop within the loop ?>
				<?php // Get Venue post object so we can grab elements from it in a custom Loop ?>
				<?php 
					$posts = get_field('djgigs_venue'); // Relationship field
 					if( $posts ): ?>
    					<?php foreach( $posts as $p):  ?>
				<td class="djgigs-venue-name djgigs-venue">
					<a href="<?php echo get_permalink( $p->ID ); ?>"><?php echo get_the_title( $p->ID ); ?></a>			
				</td>
				<td class="djgigs-venue-city-state djgigs-city">
					<?php the_field('djgigs_venue_city', $p->ID); ?><?php if( get_field('djgigs_venue_state', $p->ID) ): ?>, <?php the_field('djgigs_venue_state', $p->ID); ?><?php endif; ?>
				</td>
				<td class="djgigs-venue-country djgigs-country">
					<?php the_field('djgigs_venue_country', $p->ID); ?>
				</td>
						<?php endforeach; ?>
					<?php endif; // end our custom Loop within the loop ?>
				<td class="djgigs-expand">
					<a class="djgigs-table-trigger" href="#"><span>+</span></a> <?php // trigger to show/hide more info table below ?>
				</td>
			</tr>
		</tbody>
	</table>

	<table id="post-<?php the_ID(); ?>" class="djgigs-table gig-table djgigs-detail-table">
		<tbody>
			<tr class="djgigs-event-image-info">
			
				<td class="djgigs-event-image-1 djgigs-event-image" colspan="1">
					<div>
						<a href="<?php the_field('djgigs_event_image_1'); ?>" rel="lightbox"><img class="djgigs-event-image-img" src="<?php the_field('djgigs_event_image_1'); ?>" /></a>
					</div>
				</td>
				<td class="djgigs-event-info" colspan="4" rowspan="1">
					<?php the_field('djgigs_event_info'); ?>
				</td>
			</tr>
			<?php if( get_field('djgigs_event_image_2') ): ?>
			<tr>
				<td class="djgigs-event-image-2 djgigs-event-image" colspan="1">
					<div>
						<img class="djgigs-event-image-img" src="<?php the_field('djgigs_event_image_2'); ?>" />
					</div>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
			<?php if( get_field('djgigs_event_start_date') ): ?>
				<td class="djgigs-event-date-time" colspan="5">
					<?php $startdate = get_field('djgigs_event_start_date'); ?>
					<?php $enddate = get_field('djgigs_event_end_date'); ?>
					<span class="djgigs-event-date"><?php echo date_i18n('l, F j, Y', $startdate);  ?></span> <span class="separator">|</span> <span class="djgigs-event-start-time"><?php echo date_i18n('g:ia', $startdate); ?> <?php if( get_field('djgigs_event_end_date') ): ?>- <?php echo date_i18n('g:ia', $enddate ); ?><?php endif; ?></span> <?php if( get_field('djgigs_event_price') ): ?><span class="separator">|</span> <span class="djgigs-event-price"><?php the_field('djgigs_event_price'); ?></span><?php endif; ?>
				</td>
			<?php endif; ?>
			</tr>
			<tr>
			<?php $posts = get_field('djgigs_venue'); // Relationship field
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
					$posts = get_field('djgigs_venue'); // Relationship field
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
					Price: <?php the_field('djgigs_event_price'); ?>
				</td>
			<?php endif; ?>
			
				<td class="djgigs-ticket-url" colspan="4">
				<?php if( get_field('djgigs_ticket_url') ): ?>
					Buy Tickets: <a href="<?php the_field('djgigs_ticket_url'); ?>"><?php the_field('djgigs_ticket_url'); ?></a>
				<?php endif; ?>
				</td>
			</tr>		
			<tr>
			<?php if( get_field('djgigs_event_url_1') ): ?>
				<td class="djgigs-event-url-label">
					Event URL:
				</td>
				<td class="djgigs-event-url-1 djgigs-event-url" colspan="4">
					<a href="<?php the_field('djgigs_event_url_1'); ?>"><?php the_field('djgigs_event_url_1'); ?></a>
				</td>
			<?php endif; ?>
			</tr>	
		  	<tr>
		  	<?php if( get_field('djgigs_event_url_2') ): ?>
		    	<td class="djgigs-event-url-label">
		    		Event URL:
		    	</td>
		    	<td class="djgigs-event-url-2 djgigs-event-url" colspan="4">
		    		<a href="<?php the_field('djgigs_event_url_2'); ?>"><?php the_field('djgigs_event_url_2'); ?></a>
		    	</td>
		    <?php endif; ?>
		  	</tr>
		</tbody>
	</table>
	<?php endif; // Ends time comparison ?>
	<?php }

	} else { ?>

		<h3>Sorry, no gigs to show right now.</h3>

	<?php }

		// Restore original Post Data
		wp_reset_postdata();

?>