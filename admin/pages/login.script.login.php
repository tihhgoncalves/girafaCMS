<?

//Pega parâmetros..
$mail = trim($_POST['mail']);
$pass = trim($_POST['password']);

$login = $security->Login($mail, $pass);

if($login === true){
  $hub->SetParam('_page',  $ADMIN_PAGES_PATH . 'admin.index.php');
  $hub->SetParam('_title', 'Bem vindo');
  $link = $hub->GetUrl();

	//seta idioma do Admin...
	$langs->SetLanguage($_POST['lang']);
  
} else {
 $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'login.pg.php');
 $hub->SetParam('mail', $mail);
 $hub->SetParam('msg', $login);
 $link = $hub->GetUrl(false);
}

//imprime script que redireciona página...
header('location: ' . $link);
?>