
jQuery(document).ready(function($){

	$('.djgigs-table-trigger').click(function(e) {

		e.preventDefault;

		// grab next instance of hidden table within WP loop (using nextInDOM function)
		var nextInst = nextInDOM('.djgigs-detail-table', $(this));
		// var nextTgInfo = nextInDOM('.tg-info', nextInst);

		// if table is visible, change plus sign to minus
		var txt = nextInst.is(':visible') ? '+' : '-';

		// if table is visible change table heading
		var th = nextInst.is(':visible') ? 'See More' : 'See Less';

		// show/hide next instance of table
		nextInst.slideToggle(300);



		// when we show a table, hide all other tables
		$('.djgigs-detail-table').not(nextInst).hide();

		// toggle trigger text
		$(this).text(txt);

		// toggle 'See More' text (a tough DOM traversal :)
		// $(this).closest('tr').prev('tr').find('th.tg-expand-heading').text(th);  // this is the one...whew!
		
		// toggle heading text; we only have one table heading now so easy peasy
		$('.djgigs-expand-heading').text(th);

		// $("#sidebar1").toggleClass("tg-main-height"); // toggleClass backup
		
		
  		if($(this).text() == "-") {

  			// toggle #sidebar1 height when we add more content; equalHeight doesn't work here
  			$("#sidebar1").animate({height:'+=500'}, 300);

  			// remove extra margin once expanded
  			$(this).closest('.djgigs-header-table').css('margin-bottom', '0');

  			// only the expanded table should have minus sign
  			$('.djgigs-table-trigger').not(this).text('+');

  			// add top border to table when table above is expanded
  			nextInst.nextAll('.djgigs-detail-table:first').css('border-top','1px solid #ddd');

  			// scroll to expanded table
  			$('body').scrollTo(this);

		} else {

			// remove extra height once collapsed
			$("#sidebar1").animate({height:'-=500'}, 300);

			// restore extra margins (maybe not needed now)
			$(this).closest('.djgigs-header-table').css('margin-bottom', '2em');

			// remove top border when no tables are expanded
			nextInst.nextAll('.djgigs-detail-table:first').css('border-top','0');

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