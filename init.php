<?php
//Inicia sessão..
session_start();

//Seta no Cabeçalho codificação do fonte..
header('Content-type: text/html; charset=utf-8');

// Acerta o horário caso seu servidor
date_default_timezone_set('America/Sao_Paulo');

//Carrega framework
include('./bower_components/girafaCMS/loader.php');

//Carrega objeto de Idioma..
$langs	= new nbrLangs('FRONT');

//Carrega Eventos de Plugins...
$events->includeFilesEventsPlugins();

//Carrega Roteador...
$router   = new nbrRouter();

//Carrega Site (de acordo com a URL)..
$site = new nbrSite();


//Se no tema tiver arquivo functions.php carrega-o..
$isFront = true;
if(file_exists($cms->GetThemePath() . 'functions.php'))
  include($cms->GetThemePath() . 'functions.php');


if($router->getPage() == 's'){
  $script = $router->params[1];

  $script_file = $FRONT_SCRIPTS_PATH . $script;

  if(file_exists($script_file . '.php')) {
    include($script_file . '.php');
  } elseif(file_exists($script_file)){
    include($script_file);
  } else {
    die('[Erro ao carregar script do Girafa CMS]');
  }
}else{
  include($FRONT_PAGES_PATH . $router->pageFile);
}
?>