<?
$security->Logout();

$hub->SetParam('_script', $ADMIN_PAGES_PATH . 'login.pg.php');
header('location:' . $hub->GetUrl());
?>