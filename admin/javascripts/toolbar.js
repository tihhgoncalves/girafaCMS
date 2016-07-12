var maismodulos  = 'mais módulos';
var menosmodulos = 'menos módulos';
var opened = false;
var heightClosed = 90;
var speed = 300;

function openToolbar()
{
	$('div#toolbar').animate({ 
    height: $('div#toolbar ul').height() + 25,
  }, speed , function(){
		$('div#escondeToolbar div#painel a').text(menosmodulos);
		opened = true;
	});
}

function closeToolbar()
{
	$('div#toolbar').animate({ 
    height: heightClosed,
  }, speed , function(){
		$('div#escondeToolbar div#painel a').text(maismodulos);
		opened = false;
	});
}

function resizedToolbar(larg){
 
  verificaSeMostraPainel();
	
  if(opened){
	
		setTimeout(function(){
												
			if($('div#toolbar ul').height() == larg)
				openToolbar();	
			else
				resizedToolbar($('div#toolbar ul').height());
		}, 500);
	}
}

function verificaSeMostraPainel() {
	
//	setTimeout(function(){
   		//verifica se mostra painel..
		if(($('div#toolbar ul').height() + 25) == heightClosed) 
		{
			 $('div#escondeToolbar div#painel').fadeOut('fast');
		}
		else
		{
			 $('div#escondeToolbar div#painel').fadeIn('fast');
		}
//  }, 1000);	
	
}
verificaSeMostraPainel();

$(document).ready(function(){
	$('div#escondeToolbar div#painel a').click(function(){
	
		if(opened)
			closeToolbar();
		else
			openToolbar();
	});
});


$(window).resize(function(){

  resizedToolbar($('div#toolbar ul').height());

});
