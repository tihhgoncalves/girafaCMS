<?
$lang = $hub->GetParam('lang');
$_SESSION['lang_admin'] = $lang;

$hub->BackLevel(2);
$hub->RemoveParam('_setLanguage');
header('LOCATION:' . $hub->GetUrl());

?>