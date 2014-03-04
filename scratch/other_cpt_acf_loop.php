<?php

$posts = get_field('venue');
 
if( $posts ): ?>
    
    <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
        <?php setup_postdata($post); ?>
        <?php $vmap = get_field('venue_google_map', $post->ID); ?>
        <div class="acf-map">
			<div class="marker" data-lat="<?php echo $vmap['lat']; ?>" data-lng="<?php echo $vmap['lng']; ?>"></div>
		</div>
    <?php endforeach; ?>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
<?php endif; ?>