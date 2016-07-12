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