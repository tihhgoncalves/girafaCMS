<?
$hub->BackLevel(2);

$hub->SetParam('filterWhere', $_POST['filter']);
$hub->SetParam('filterSearch', $_POST['search']);

header('Location:' . $hub->GetUrl());
?>