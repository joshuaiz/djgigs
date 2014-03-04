jQuery(document).ready(function($){
	//TODO: make this text better.
	$('<p>Enter the event description here. You can include other djs/performers, presented by or add additional flyer images or photos. Don\'t add venue information here — you\'ll be entering that below. HTML is allowed.</p>').prependTo('#event-info .inside');


	$(".djgigsdate").datepicker({
	    dateFormat: 'D, M d, yy',
	    showOn: 'button',
	    buttonImage: 'images/gigpress-icon-32.png',
	    buttonImageOnly: true,
	    numberOfMonths: 3
	 
	    });
	});
	

});
