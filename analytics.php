<?
session_start();

if(isset($_COOKIE['girafa_sessaoID'])){

  session_id($_COOKIE['girafa_sessaoID']);
  $sessaoID = $_COOKIE['girafa_sessaoID'];

} else {

  $sessaoID = session_id();
  setcookie('girafa_sessaoID', $sessaoID, time()+3600*24*365); //dura 1 ano

}



//Carrega framework
include('./loader.php');

$post = new nbrTablePost();
$post->table = 'chtVisitantes';
$post->AddFieldString('IP',               $_SERVER["REMOTE_ADDR"]);
$post->AddFieldDateTimeNow('DataHora');
$post->AddFieldString('SessaoID',         $sessaoID);
$post->AddFieldString('URL',              @$_POST['URL']);
$post->AddFieldString('URLReferencia',    @$_POST['URLReferencia']);
$post->AddFieldString('Plataforma',       @$_POST['Plataforma']);
$post->AddFieldString('Navegador',        @$_POST['Navegador']);
$post->AddFieldString('Sistema',          @$_POST['Sistema']);
$post->AddFieldString('Touch',            @$_POST['Touch']);
$post->AddFieldString('Resolucao',        @$_POST['Resolucao']);


if($post->Execute())
  die('Girafa Analytics // Registrado com sucesso!');
else
  die('Girafa Analytics // Ocorreu um ERRO ao tentar registrar!');

?>