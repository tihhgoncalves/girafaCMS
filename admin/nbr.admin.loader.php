<?php
/**
 * Faz includes dos objetos (do Admin)
 */
  include($OBJECTS_PATH . 'nbr.obj.admin.logs.php');
  include($OBJECTS_PATH . 'nbr.obj.admin.dataset.php');
  include($OBJECTS_PATH . 'nbr.obj.admin.hub.php');
  include($OBJECTS_PATH . 'nbr.obj.admin.grids.php');  
  include($OBJECTS_PATH . 'nbr.obj.admin.forms.php');  
  include($OBJECTS_PATH . 'nbr.obj.admin.modules.php');  
  include($OBJECTS_PATH . 'nbr.obj.admin.module.folders.php');


/**
 * Funções
 */
 include($ADMIN_FUNCTIONS_PATH . 'application.php');
 
  $hub      = new nbrAdminHub();
  $dataSet  = new nbrDataSet();
?>