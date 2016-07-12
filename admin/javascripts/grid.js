// Efeito em grids
$(document).ready(function(){

	$('div#content div.main div.grid table tr').not('tr.legend').hover(function(){
    $(this).addClass('hover');
  }, function(){
	  $(this).removeClass('hover');
	});

});


/** Configura Alertas **/
$.alerts.overlayOpacity = 0.5;
$.alerts.overlayColor   = '#666666';
$.alerts.okButton   = '&nbsp;Ok&nbsp;';
$.alerts.cancelButton   = '&nbsp;Cancelar&nbsp;';

/**Exclui Registro **/
function deleteReg(tableName, ID, link){
  jConfirm('Você tem certeza que deseja excluir este registro?', 'Confirmar Exclusão', function(r){
    if(r){
      document.location.href = link;
    }
    
  })
}


/**
  Drop Drag do CampoOrdem
**/

$(document).ready(function(){ 
  
  $('div#content div.main div.grid table.grid tbody').sortable({
      axis: 'y',
      opacity: 0.6, 
      cursor: 'move',
      handle: 'td.order',
      update: function(){
        
        OpenStatus('Atualizando ordem do Grid...');
        //Atualiza Ordem no Banco..
        var order = $(this).sortable('toArray');

        $.ajax({
          type: 'POST',
          url: controlOrderAjaxURL,
          data: 'order=' + order,
          success: function(msg){
            OpenStatus('Ordem do Grid atualizado!')
            setTimeout(function(){
              CloseStatus();
            }, 3000);
          }
        });			  
        
        //Re organiza cores das linhas..
        var par = false;
        $('div#content div.main div.grid table.grid tbody tr').each(function(){
          
          if(par){
            $(this).addClass('contrast');
            par = false;
          } else {
            $(this).removeClass('contrast');
            par = true;
          }
        })
      },
      start: function(){
        $('#tooltip').hide();
      }
  });

});	

//Comandos..
$(document).ready(function(){
  
  $('ul#commandsBar li a').each(function(){
    
    $(this).click(function(){
        
      var link = $(this).attr('link');
      var question = $(this).attr('question');
      
      if($(this).attr('question').length > 0){
        
        jConfirm(question, 'Confirmação', function(r){
          
          if(r){
            document.location.href = link;
          }
        });
        
      } else {
        document.location.href = link;
      }
    });
    
  });
  
});


//Filtros..
var inputSearch = 'Pesquise pela palavra...';
$(document).ready(function(){
  
  $('div#bar div#filters form input#search').focus(function(){
    
    if (($(this).val() == inputSearch)){
      $(this).val('');
      $(this).removeClass('branco');
    }
    
  }).blur(function(){
    if($(this).val() == ''){
      $(this).addClass('branco');
      $(this).val(inputSearch);

    }
    
  });
  
  //Primeira vez..
  if($('div#bar div#filters form input#search').val() == ''){
      $('div#bar div#filters form input#search').addClass('branco');
      $('div#bar div#filters form input#search').val(inputSearch);  
  }
  
  //Se clicar no ícone..
  $('div#bar div#filters form div#search').click(function(){
    $(this).find('input').focus();
  });
  $('div#bar div#filters form div#filter').click(function(){
    $(this).find('select').focus();
  });

  //Submit..
  $('div#bar div#filters form a#submit').click(function(){

    if (($('div#bar div#filters form input#search').val() == inputSearch)){
      $('div#bar div#filters form input#search').val('');
    }    
    $('form#pesquisa').submit();
    
  });
  
  
  //Limpar filtros..
  $('div#bar div#filters form a#limpar').click(function(){
    
    $('div#bar div#filters form input#search').val('');
    $('div#bar div#filters form select#filter').val('');
    $('form#pesquisa').submit();
    
  });
  
  //Selecionou filtro...
  $('div#bar div#filters select#filter').change(function(){
    
    if($(this).val() != -1){
      $('div#bar div#filters form input#search').val('');
      $('form#pesquisa').submit();
    }
  });
  
});