
jQuery(document).ready(function($){

	$('.djgigs-table-trigger').click(function(e) {

		e.preventDefault;

		var $detail = $(this).closest('table').nextAll('.djgigs-detail-table:first');
		var	$heading = $('.djgigs-expand-heading');

		// $(this).parents('.djgigs-summary-table').nextAll('.djgigs-detail-table').first().slideToggle(300);

		$detail.slideToggle(300);


		// if table is visible change table heading
		// var th = $detail.is(':visible') ? 'See More' : 'See Less';


		// when we show a table, hide all other tables
		$('.djgigs-detail-table').not($detail).hide();

		// toggle trigger text
		$(this).html($(this).html()=="-"?"+":"-");

		// toggle 'See More' text (a tough DOM traversal :)
		// $(this).closest('tr').prev('tr').find('th.tg-expand-heading').text(th);  // this is the one...whew!
		
		// toggle heading text; we only have one table heading now so easy peasy
		// $heading.html($heading.html()=="See Less"?"See More":"See Less");

		// $("#sidebar1").toggleClass("tg-main-height"); // toggleClass backup
		// 
		if($(this).text() == "-") {

			$('.djgigs-table-trigger').not(this).text('+');

			$heading.text('See Less');
		
		} else {

			$heading.text('See More');
			
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