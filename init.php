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

if($router->getPage() == 's'){
  $script = $router->params[1];
  include($FRONT_SCRIPTS_PATH . $script . '.php');
}else{
  include($FRONT_PAGES_PATH . $router->pageFile);
}
?>