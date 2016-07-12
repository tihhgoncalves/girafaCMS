<?
//COOKIES...
$cookie_save_name = $SITEKEY . '_nbrSave';

//se não tiver setado...
if(!isset($_COOKIE[$cookie_save_name])){
  setcookie($cookie_save_name, 'S');  
  $_COOKIE[$cookie_save_name] = 'S';
}

?>