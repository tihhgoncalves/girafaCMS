$(document).ready(function(){
													 
	//Ativa "focus" nos Inputs (de texto)
  $('div.field:not(.readonly) input[type=text]').focus(function(){
    $(this).addClass('hover');
  }).blur(function(){
    $(this).removeClass('hover');		
	});
});


//String..

$(document).ready(function(){

  $('div#boxForm input[mask]').each(function(){

    $(this).mask($(this).attr('mask'));
    
  });
  
});

//Só Números em Input..
function onlyInteger(dom){
        dom.value=dom.value.replace(/\D/g,'');
}

//Aplica CKEditor nos Campos HTML...

$(document).ready(function(){


var config = {
    filebrowserUploadUrl : 'javascripts/ckeditor/upload.php'
    };

	$('div#boxForm div.html textarea').ckeditor(config);
});


/** VALIDAÇÃO **/
$(function($){ 	
		
//CPF
$.validator.addMethod("cpf", function(value, element) {
		
		value = value.replace('.','');
		value = value.replace('.','');
		cpf = value.replace('-','');
		
		while(cpf.length < 11) cpf = "0"+ cpf;
		
		var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
		var a = [];
		var b = new Number;
		var c = 11;
		
		for (i=0; i<11; i++){
			a[i] = cpf.charAt(i);
			if (i < 9) b += (a[i] * --c);
		}
		
		if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
		b = 0;
		c = 11;
		for (y=0; y<10; y++) b += (a[y] * c--);
		
		if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
		
		if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
		
		return true;
	}, "Informe um CPF válido.");
	
	jQuery.validator.addMethod("cnpj", function(cnpj, element) {
		   cnpj = jQuery.trim(cnpj);// retira espaços em branco
		   // DEIXA APENAS OS NÚMEROS
		   cnpj = cnpj.replace('/','');
		   cnpj = cnpj.replace('.','');
		   cnpj = cnpj.replace('.','');
		   cnpj = cnpj.replace('-','');
		 
		   var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
		   digitos_iguais = 1;
		 
		   if (cnpj.length < 14 && cnpj.length < 15){
		      return false;
		   }
		   for (i = 0; i < cnpj.length - 1; i++){
		      if (cnpj.charAt(i) != cnpj.charAt(i + 1)){
		         digitos_iguais = 0;
		         break;
		      }
		   }
		 
		   if (!digitos_iguais){
		      tamanho = cnpj.length - 2
		      numeros = cnpj.substring(0,tamanho);
		      digitos = cnpj.substring(tamanho);
		      soma = 0;
		      pos = tamanho - 7;
		 
		      for (i = tamanho; i >= 1; i--){
		         soma += numeros.charAt(tamanho - i) * pos--;
		         if (pos < 2){
		            pos = 9;
		         }
		      }
		      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		      if (resultado != digitos.charAt(0)){
		         return false;
		      }
		      tamanho = tamanho + 1;
		      numeros = cnpj.substring(0,tamanho);
		      soma = 0;
		      pos = tamanho - 7;
		      for (i = tamanho; i >= 1; i--){
		         soma += numeros.charAt(tamanho - i) * pos--;
		         if (pos < 2){
		            pos = 9;
		         }
		      }
		      resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
		      if (resultado != digitos.charAt(1)){
		         return false;
		      }
		      return true;
		   }else{
		      return false;
		   }
		}, "Informe um CNPJ válido.");

});
//Ativando validação de formulário de Contato
$(document).ready(function(){
  
    $("form#formulario").validate({
      messages: {
    		required: "Obrigatório.",
    		remote: "Please fix this field.",
    		email: "Please enter a valid email address.",
    		url: "Please enter a valid URL.",
    		date: "Please enter a valid date.",
    		dateISO: "Please enter a valid date (ISO).",
    		number: "Please enter a valid number.",
    		digits: "Please enter only digits.",
    		creditcard: "Please enter a valid credit card number.",
    		equalTo: "Please enter the same value again.",
    		accept: "Please enter a value with a valid extension.",
    		maxlength: $.validator.format("Please enter no more than {0} characters."),
    		minlength: $.validator.format("Please enter at least {0} characters."),
    		rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
    		range: $.validator.format("Please enter a value between {0} and {1}."),
    		max: $.validator.format("Please enter a value less than or equal to {0}."),
    		min: $.validator.format("Please enter a value greater than or equal to {0}.")
    	}
      
    });

});

/** Campos Data **/
$(document).ready(function(){
  
  $('div#boxForm div.datetime input').mask('99/99/9999 99:99');
  $('div#boxForm div.date input').mask('99/99/9999');

  var datapickerParams = {
    dateFormat: 'dd/mm/yy',
    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
    nextText: 'Próximo',
    prevText: 'Anterior'
  }

  $('div#boxForm div.date input').datepicker(datapickerParams);

});

/** Campos Imagem **/
$(document).ready(function(){
  
  //Seleciona arquivo...
  $('div#boxForm div.image div.painel input[type=file]').change(function(){
    //Atualiza Legenda..
    $(this).parent().find('span.status').html($(this).val() + '<span class="warning">(será enviado ao site quando salvar este registro)</span>');
    
    //Mostra botão Excluir..
    $(this).parent().parent().find('img.delete').show();
    
    //Atualiza Campo de Status..
    $(this).parent().find('input._status').val('Y');
    
    //Muda fundo avisando que img só vai subir quando salvar o registro..
    $(this).parent().parent().find('div.img').css('background-image', 'url(' + imgSending + ')');
  });
  
  //Limpa Campo..
  $('div#boxForm div.image div.img img.delete').click(function(){
    
    var status = $(this).parent().parent().find('span.status');
    var _status = $(this).parent().parent().find('input._status');
    var _btnDelete = $(this);
    var img = $(this).parent().parent().find('div.img');

    //Limpa legenda..
    jConfirm('Você tem certeza de deseja limpar este campo?<br>Se responder sim, quando salvar este registro a imagem será excluída do sistema.', 'Tem certeza?', function(r){
      
      if(r){
        status.text('Sem imagem');
        _status.val('');
        _btnDelete.hide();
        img.css('background-image', 'url(' + imgNo + ')');
      }
      
    });
    
  });
});
	


/** Campos Numero Decimais **/
$(document).ready(function(){
  
  $.fn.autoNumeric.defaults = {// plugin defaults
		aNum: '0123456789', //allowed  numeric values
		aNeg: '-', // allowed negative sign / character
		aSep: '.', // allowed thousand separator character
		aDec: ',', // allowed decimal separator character
		aSign: '', // allowed currency symbol
		pSign: 'p', // placement of currency sign prefix or suffix
		mNum: 10, // max number of numerical characters to the left of the decimal
		mDec: 2, // max number of decimal places
		dGroup: 3, // digital grouping for the thousand separator used in Format
		mRound: 'S', //  method used for rounding
		aPad: true //true= always Pad decimals with zeros, false=does not pad with zeros. If the value is 1000, mDec=2 and aPad=true, the output will be 1000.00, if aPad=false the output will be 1000 (no decimals added) Special Thanks to Jonas Johansson
	};
  
  $('div#boxForm div.number  input').autoNumeric();
  
  
});


/** Campos Senha **/

//Ativa confirmação qdo "Senha" for digitada
$(document).ready(function(){
  
  $('div#boxForm div.password input.senha1').blur(function(){
    
    var senha1 = $(this);
    
    $(this).parent().find('input.senha2').removeAttr('disabled');
    $(this).parent().find('input.senha2').focus();
    $(this).parent().find('input.senha2').removeClass('disabled');
    $(this).parent().find('input.senha2').val('');
    
    $(this).parent().find('input.senha2').blur(function(){
      
      var senha2 = $(this);
      
      if(senha1.val() != $(this).val()){
        var msg;
        msg  = 'As duas senhas digitadas são senhas diferentes.';
        msg += "\n";
        msg += 'Digita a senha 2 vezes iguais para ser validada.';
        jAlert(msg, 'Senha Inválida', function(){
          senha2.val('');
          senha1.select();
        });
      }
      
      senha2.attr('disabled', 'disabled');
      senha2.addClass('disabled');      
      
    });
    
  });
});

/**
  Mult Select 
**/
$(document).ready(function(){

    $("select.multiselect").each(function(){

      var control_ordem = $(this).attr('sortable');

      $(this).multiselect({
        sortable: (control_ordem == 'true'?true:false)
      });

    });

});

/** Campos Arquivo **/

$(document).ready(function(){
  
  //Seleciona arquivo...
  $('div#boxForm div.file div.painel input[type=file]').change(function(){
    
    //Atualiza Legenda..
    $(this).parent().parent().find('span.status span.txt').html($(this).val() + '<span class="warning">(será enviado ao site quando salvar este registro)</span>');
      
    //Esconde botão "Download"
    $(this).parent().parent().find('img.down').hide();
    
    //Mostra botão Excluir..
    $(this).parent().parent().find('img.delete').show();
    
    //Atualiza Campo de Status..
    $(this).parent().parent().find('input._status').val('Y');

  });
  
  //Limpa Campo..
  $('div#boxForm div.file div.painel img.delete').click(function(){
    
    var status = $(this).parent().parent().parent().parent().find('span.status span.txt');
    var _status = $(this).parent().parent().parent().find('input._status');
    var _btnDown = $(this).parent().parent().parent().find('img.down');
    var _btnDelete = $(this);

    //Limpa legenda..
    jConfirm('Você tem certeza de deseja limpar este campo?<br>Se responder sim, quando salvar este registro o arquivo será excluído do sistema.', 'Tem certeza?', function(r){
      
      if(r){
        
        if(_status.val() != 'Y')
          status.html('Arquivo exclúdo!' + '<span class="warning">(somente será excluído fisicamente quando salvar este registro)</span>');
        else
          status.html('Sem arquivo');
        
        _status.val('');
        _btnDown.hide();
        _btnDelete.hide();
      }
      
    });
    
  });
});

/**
Arquivo
**/
$(document).ready(function() {
  
  
   $("input.arquivo").each(function(){
     var id = $(this).attr('id');
     var status = $('#' + id + '_status');
     var tabela = $(this).attr('table');
     var campo = $(this).attr('fieldName');
     var barra = $(this).parent().parent().find('#barra');

     $(this).fileUpload({
        'uploader'    : 'javascripts/jquery.fileupload/uploader.swf',
        'width'       : 114,
        'height'      : 25,
        'cancelImg'   : 'javascripts/jquery.fileupload/cancel.png',
        'folder'      : root_path + 'cms/temp',
        'script'      : 'javascripts/jquery.fileupload/upload.php',
        'fileDesc'    : $(this).attr('fileTypesDescription'),
        'fileExt'     : $(this).attr('fileTypes'),
        'multi'       : false,
        'auto'        : true,
        'scriptData'  : {'tabela':tabela, 'campo':campo },
        'onProgress'  : function (event, queueID, fileObj, data){
                          var x = (data.percentage * 485); //485px é a largura máxima da barra.
                          x =  (x / 100);
                           
                          barra.css('width', x + 'px');
                          barra.text(data.percentage + '%');
        },
        'onSelect'    : function(){
                          barra.removeClass('file');
                          barra.text('');
                          saveDisabled();
                          backDisabled();
                        },
        'onComplete'  : function(event, ID, fileObj, response, data){
                          saveEnabled();
                          backEnabled();
                          status.val(fileObj.name);
                          barra.text('Seu arquivo foi enviado com sucesso.');
                        },
        'onCancel'    : function(){
                          saveEnabled();
                          backEnabled();
                          
                          barra.css('width', '0px');
                          barra.text('');                          
                        }
     });       
     
     $(this).parent().parent().find('img.delete').click(function(){
       status.val('N');
       $(this).hide();
       $(this).parent().parent().find('img.down').hide();
       $(this).parent().parent().find('span.txt').text('Assim que você salvar este registro este campo ficará em branco.')
     })
   });
   
});


//Toolbar
var formStatus = true;
function saveDisabled(){
  $('div#boxForm button#save').button({ disabled: true });
  $('div#boxForm button#save2').button({ disabled: true });
  formStatus = false;
}
function saveEnabled(){
  $('div#boxForm button#save').button({ disabled: false });
  $('div#boxForm button#save2').button({ disabled: false });

  formStatus = true;
}

function backDisabled(){
  $('div#boxForm button#back').button({ disabled: true });
  formStatus = false;
}

function backEnabled(){
  $('div#boxForm button#back').button({ disabled: false });
  formStatus = true;
}

function formURLSubmit(url){
  $('#formulario').attr('action', url);
  $('#formulario button[type=submit]').click();
  //$('#formulario').submit(); não tava indo na verificação dos campos obrigatórios
}

// Salvar e Voltar...
$(document).ready(function(){
    
   $( "div#boxForm button#save")
      .button()
      .click(function() {
        //alert( "Running the last action" );
      })
      .next()
        .button({
          text: false,
          icons: {
            primary: "ui-icon-triangle-1-s"
          }
        })
        .click(function() {
          var menu = $( this ).parent().next().show().position({
            my: "left top",
            at: "left bottom",
            of: this
          });
          $(document).one( "click", function() {
            menu.hide();
          });
          return false;
        })
        .parent()
          .buttonset()
          .next()
            .hide()
            .menu();


  //click back..
  $('div#boxForm button#back').click(function(){
    document.location.href = $(this).attr('link');
  });
  
});

/**
* TECLAS DE ATALHOS
**/
$(document).ready(function(){
  
  //adiciona class em todos os campos..
  $('#formulario input').addClass('mousetrap');
  $('#formulario textarea').addClass('mousetrap');
  $('#formulario select').addClass('mousetrap');
  
  //Ctrl + S - Salvar..
  if ($('.btnSave').length > 0) {
  
    Mousetrap.bind(["ctrl+s","command+s"], function() {
      $('.btnSave').click();
      return false;
    });
    
  }

  //Ctrl + S - Salvar e Volta..
  if ($('.btnSaveBack').length > 0) {
  
    Mousetrap.bind("ctrl+shift+left", function() {
      $('.btnSaveBack').click();
      return false;
    });
    
  }

  //Ctrl + S - Salvar e Novo..
  if ($('.btnSaveNew').length > 0) {
  
    Mousetrap.bind("ctrl+shift+up", function() {
      $('.btnSaveNew').click();
      return false;
    });
    
  }  
  
  //Ctrl + left - Voltar..
  if ($('button.back').length > 0) {
  
    Mousetrap.bind("ctrl+left", function() {
      $('button.back').click();
      return false;
    });
    
  }

  //Ctrl + N - Novo..
  if ($('button.new').length > 0) {
  
    Mousetrap.bind("ctrl+up", function() {
      $('.new').click();
      return false;
    });
    
  }
  
    Mousetrap.bind("b r u n o", function() {
      alert('Há! Tudo bom Bruno Gonçalves? :)');
      return false;
    });

  
})

//Seleciona (focus) primeiro campo do formulário
$(document).ready(function(){

  $('form#formulario .field input:first, form#formulario .field textarea:first, form#formulario .field select:first').each(function() {
      if($(this).is(':visible') && !$(this).attr('disabled') && !$(this).attr('readonly')) {
          $(this).focus();
          return false;
      }
  });  
  
});


//Botão que abre o gerador de senha..
$(document).ready(function(){
  $('.geradorSenha').fancybox({
    width: 500,
    height: 350
  });
});



