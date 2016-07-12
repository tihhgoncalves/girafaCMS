<?
/**
 * Executando este arquivo o cache do site será "resetado" (limpo)
 */

//Faz inclue no Arquivo de Configuração
include('./config.php');

//Carrega framework
include('./cms/nbr.loader.php');


$cache->ClearCache();

echo('O cache foi limpo com sucesso.');
?>