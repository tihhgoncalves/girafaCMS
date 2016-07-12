/* $(document).ready(function(){
	$("a.iframe").fancybox({
		'width'				    : 400,
		'height'			    : 300,
		'type'				    : 'iframe'
	});

	$("a.imagebox").fancybox({
		'width'				    : 400,
		'height'			    : 300,
		'type'				    : 'image'
	});
});

Tiago - Não achei onde isso é usado, mas desabilitei o fancybox.
*/



//Confirma link...

function confirmLink(titulo, msg, link){
  jConfirm(titulo, msg, function(r){
    
    if(r){
      document.location.href = link;
    }
    
  });
}