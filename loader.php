<?php

/**
 * Carrega CONFIG
 */

//config_default
require_once('loader_config.php');

/**
 * Faz Include de Bibliotecas de terceiros
 */

/** Faz includes de projetos meus, mas independentes */
include(get_config('BOWER_COMPONENTS_PATH') . 'tihh.php.obj.db.mysql/load.php');
include(get_config('BOWER_COMPONENTS_PATH') . 'tihh.php.fnc.getTags/load.php');

/**
 * Faz includes dos objetos
 */  
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
  include($OBJECTS_PATH . 'nbr.obj.report.pdf.php');  
  include($OBJECTS_PATH . 'nbr.obj.msg.php');
  include($OBJECTS_PATH . 'nbr.obj.langs.php');
//include($OBJECTS_PATH . 'nbr.obj.linkThumb.php'); // Esse objeto será excluído do CMS
  include($OBJECTS_PATH . 'nbr.obj.cache.php'); 
  include($OBJECTS_PATH . 'nbr.obj.events.php'); 
  include($OBJECTS_PATH . 'nbr.obj.params.php'); 
  include($OBJECTS_PATH . 'nbr.obj.tableManager.php');
  include($OBJECTS_PATH . 'nbz.obj.boxes.php');
  include($OBJECTS_PATH . 'girafa.tpl.php');

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
  $db       = new tihh_db_mysql($DB_HOST, $DB_USER, $DB_PASS, $DB_DATABASE, $DB_PERSISTENT);
  $cms      = new nbrCMS();
  $security = new nbrAdminSecurity();
  $msg      = new nbrMSG();
  $cache    = new nbrCache();  
  $events   = new nbrEvents();
  $params   = new nbrParams();
  $boxes    = new nbrBoxes();


?>