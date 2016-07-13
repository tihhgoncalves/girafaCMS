<?php

/**
 * Carrega CONFIG
 */

//config_default
require_once('config_default.php');

//config
require_once('config.php');

$configs = array_merge($config_d, $config);

//joga config pra GLOBALS
foreach($configs as $k=>$c){


  //trata valores virtuais..
  if(!is_array($c)) {

    $re = "/\\{(.+)\\}/mi";
    preg_match_all($re, $c, $out);

    if (isset($out[1][0])) {
      $val = $$out[1][0];
      $c = str_replace($out[0][0], $val, $c);
    }
  }
  $GLOBALS[$k] = $c;
}


/**
 * Faz Include de Bibliotecas de terceiros
 */


/**
 * Faz includes dos objetos
 */  
  include($OBJECTS_PATH . 'nbr.obj.db.php');  
  include($OBJECTS_PATH . 'nbr.obj.table.create.php');  
  include($OBJECTS_PATH . 'nbr.obj.admin.security.php');
  include($OBJECTS_PATH . 'nbr.obj.string.php');
  include($OBJECTS_PATH . 'nbr.obj.date.php');  
  include($OBJECTS_PATH . 'nbr.obj.site.php');
  include($OBJECTS_PATH . 'nbr.obj.images.php'); // Esse objeto será descontinuado 
  include($OBJECTS_PATH . 'nbr.obj.magicImage.php');
  include($OBJECTS_PATH . 'nbr.obj.mail.php');
  include($OBJECTS_PATH . 'nbr.obj.cms.php');
  include($OBJECTS_PATH . 'nbr.obj.router.php');
  include($OBJECTS_PATH . 'nbr.obj.page.php');
  include($OBJECTS_PATH . 'nbr.obj.tablepost.php');    
  include($OBJECTS_PATH . 'nbr.obj.admin.logs.php'); 
  include($OBJECTS_PATH . 'nbr.obj.admin.dataset.php');  
  include($OBJECTS_PATH . 'nbr.obj.report.pdf.php');  
  include($OBJECTS_PATH . 'nbr.obj.msg.php');
  include($OBJECTS_PATH . 'nbr.obj.langs.php');
//include($OBJECTS_PATH . 'nbr.obj.linkThumb.php'); // Esse objeto será excluído do CMS
  include($OBJECTS_PATH . 'nbr.obj.cache.php'); 
  include($OBJECTS_PATH . 'nbr.obj.events.php'); 
  include($OBJECTS_PATH . 'nbr.obj.params.php'); 
  include($OBJECTS_PATH . 'nbr.obj.tableManager.php');

  /** Includes de objetos de terceiros **/
  include($OBJECTS_PATH . 'instagram.php');

  /** Faz includes das Funções **/
  include($FUNCTIONS_PATH . 'nbr.application.php');
  include($FUNCTIONS_PATH . 'nbr.draw.php');
  include($FUNCTIONS_PATH . 'nbr.files.php');
  include($FUNCTIONS_PATH . 'nbr.string.php');
  
  /** Faz includes das Funções do Admin **/
  include($ADMIN_FUNCTIONS_PATH . 'pages.php');
  
  /** Carrega objetos utilizados no framework... */
  $db       = new nbrDB($DB_HOST, $DB_DATABASE, $DB_USER, $DB_PASS, $DB_PERSISTENT);
  $cms      = new nbrCMS();
  $dataSet  = new nbrDataSet();
  $security = new nbrAdminSecurity();
  $msg      = new nbrMSG();
  $cache    = new nbrCache();  
  $events   = new nbrEvents();
  $params   = new nbrParams();

  //Se no tema tiver arquivo functions.php carrega-o..
  if(file_exists($cms->GetThemePath() . 'functions.php'))
    include($cms->GetThemePath() . 'functions.php');

?>