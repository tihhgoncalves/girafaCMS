<?
/**
 * Função de Resposta dos Eventos
 */
function returnError($msg, $msgDetail = null){
  global $hub, $dataSet, $id;
  $hub->BackLevel(2);
  
  $dataSet->SetParam('msgError', $msg);
  
  if(!empty($msgDetail))
    $dataSet->SetParam('msgErrorDetail', 'Informação Técnica - ' . $msgDetail);
  
  if($id > 0)
    $hub->SetParam('ID', $id);
  
  if(isset($_POST))
    $dataSet->SetParam('_post', $_POST);
  
  header('Location: ' . $hub->GetUrl());
  exit;
}
?>