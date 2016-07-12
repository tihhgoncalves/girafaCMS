<?
//Parâmetros..
$table                = $hub->GetParam('table');
$order                = $_POST['order'];
$controlOrderField    = $hub->GetParam('controlOrderField');
$controlOrderVaiation = intval($hub->GetParam('controlOrderVariation'));

if($controlOrderVaiation <= 0){
  $val = 10;
  $controlOrderVaiation = 10;
} else 
  $val = $controlOrderVaiation;
  
$orders = explode(',', $order);

foreach ($orders as $id) {
  
  $post = new nbrTablePost();
  $post->table   = $table;
  $post->id      = $id;
  $post->AddFieldInteger($controlOrderField, $val);
  $post->Execute();
	
  $val += $controlOrderVaiation;
}

//Atualiza Logs..
$msg  = 'Atualizou ordem de um ou mais registros da tabela ' . $table;
nbrLogs::AddAction('ORD', $msg);     
?>