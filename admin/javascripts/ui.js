  $(function() {
    $("button.btn").each(function(){
      
      var legend = $(this).attr('')
      
      $(this).button();
      
      //icon-primary
      if($(this).attr('icon'))
        $(this).button("option", "icons", { primary: $(this).attr('icon') });

      //text
      if($(this).attr('text') == 'false'){
        $(this).button("option", "text", false);        
      }
      
    });
  });