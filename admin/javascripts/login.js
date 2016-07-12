$(document).ready(function(){
	
	$('ul#flags li').click(function(){
		
		$('ul#flags li').removeClass('selected');
		$(this).addClass('selected');
		
		$('input#lang').val($(this).attr('lang'));
		
	});
	
});