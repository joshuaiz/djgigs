<?php 

include('calendar.class.php');

$cal = new CALENDAR();
$cal->weeknumbers = 'right';
$cal->basecolor = 'cc6666';
$cal->addEvent(
	array(
		"title"=>"Single-Day Event",
		"from"=>date('Y')."-".date('n')."-7",
		"to"=>date('Y')."-".date('n')."-7",
		"color"=>"#D6FFD6"
	)
);
$cal->addEvent(
	array(
		"title"=>"Another Single-Day Event",
		"from"=>date('Y')."-".date('n')."-27",
		"to"=>date('Y')."-".date('n')."-27",
		"color"=>"#D6FFD6"
	)
);
?>