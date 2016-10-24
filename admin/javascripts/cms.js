/**
Mensagens de Erro
**/

$(document).ready(function(){
  /*$('div#msg_erro img#detail').tooltip({
      delay: 0, 
      showURL: false, 
      showBody: " - "
      
  });
  */

  $('div#msg_erro img#detail').tooltipster();
});


$(document).ready(function(){
  /*
  $('*.tooltip').tooltip({
      delay: 0, 
      showURL: false, 
      showBody: " - "
  });
  */
  $('*.tooltip').tooltipster();
});



var alertOpened = false;

function OpenStatus(msg){
  
  if(alertOpened){
    CloseStatus(msg)
  } else {
    alertOpened = true;
    $('div#status').text(msg);
    $('div#status').fadeIn('slow');
  }
}
function CloseStatus(msg){
  $('div#status').fadeOut('slow', function(){
    alertOpened = false;   
    
      if(typeof msg == "undefined"){
        $('div#status').text('');    
        
      } else {
        OpenStatus(msg);
      }
     
    
  });
}


$(document).ready(function(){

	$("a.fancybox").fancybox({
		'transitionIn'	:	'elastic',
		'transitionOut'	:	'elastic',
		'speedIn'		:	600, 
		'speedOut'		:	200, 
		'titleShow'		:	false
	});

});
