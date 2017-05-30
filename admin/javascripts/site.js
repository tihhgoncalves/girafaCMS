function autoResizeFrame(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
//-->

$(document).ready(function(){
  
  $('div#msg_erro #msg_erro_close').click(function(){
    
    $('div#msg_erro').fadeOut('slow');
    
  });  
  $('div#msg_sucesso #msg_sucesso_close').click(function(){
    
    $('div#msg_sucesso').fadeOut('slow');
    
  });
  
});


/* Tootips*/
$(document).ready(function(){

  //Módulos...
  $('div#toolbar ul li a').poshytip({
    className: 'tip-twitter',
    showTimeout: 1,
    alignTo: 'target',
    alignX: 'center',
    offsetY: 5,
    allowTipHover: false,
    fade: false,
    slide: true
  });


  //Mensagem de Erro no grid...
  $('div#msg_erro i#detail').poshytip({
    className: 'tip-twitter errodetail',
    showTimeout: 1,
    alignTo: 'target',
    alignX: 'center',
    offsetY: 5,
    allowTipHover: false,
    fade: false,
    slide: true
  });


});