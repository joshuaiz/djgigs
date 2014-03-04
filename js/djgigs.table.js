jQuery(document).ready(function($){

	$('.djgigs-table-trigger').click(function() {

		// e.preventDefault;

		var $detail = $(this).closest('table').nextAll('.djgigs-detail-table:first');
		var	$heading = $('.djgigs-expand-heading');

		// Show/hide detail table
		$detail.addClass('djgigs-table-active').slideToggle(300);

		// Toggle trigger text
		$(this).html($(this).html() == '-' ? '+' : '-' );

		// When we show a detail table, hide all other tables
		$('.djgigs-detail-table').not($detail).removeClass('djgigs-table-active').hide();

		$('html, body').animate({
        	scrollTop: $(this).offset().top
    	}, 300);

		
		if($(this).text() == '-') {

			// Reset other triggers
			$('.djgigs-table-trigger').not(this).text('+');

			// Toggle header row text
			$heading.text('See Less');

			
		
		} else {

			$heading.text('See More');

			// $detail.removeClass('djgigs-table-active');
			
		}
	
	return false; // prevent scroll to top on click; e.preventDefault didn't work here

	});

});

// add default image if our event doesn't have one
jQuery(document).ready(function($){

	$(".djgigs-event-image-img[src='']").attr('src','http://joshuaiz:8888/images/calendar_blue.png').show();

});

// add alternating background to table rows. Can't use pure css for this because of discrete/nested tables
jQuery(document).ready(function($){
	$('.djgigs-summary-row').filter(':odd').css('background', '#f5f5f5');
});