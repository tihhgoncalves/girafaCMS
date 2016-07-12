<?

/**
 * Parâmetros..
 */
$tableName  = $hub->GetParam('table');
$id         = $hub->GetParam('ID');


/**
 * Verifica se Existe arquuivo de Macro
 */
if($hub->ExistParam('fileMacro')){
  $macroPath = $MODULES_PATH . $hub->GetParam('fileMacro');
  
  //verifica se arquivo existe fisicamente..
  if(!file_exists($macroPath))
    throw new Exception('O arquivo especificado de macro não foi encontrado:' . $macroPath);
  
  //Chama arquivo de macro...
  include($macroPath);
}

//Seleciona Registro no Banco de Dados..
$sql = 'SELECT * FROM ' . $tableName . ' WHERE ID = ' . $id;
$res = $db->LoadObjects($sql);
$reg = $res[0];


//Verifica se existe evento beforeDelete na macro...
if(function_exists('macroBeforeDelete')){
  macroBeforeDelete($tableName, $reg);
}

//Se der tudo ok na macro, tenta excluir e volta..
$sql  = 'DELETE FROM ' . $tableName;
$sql .= ' WHERE ID = ' . $id;

try {
  $db->Execute($sql);
  
  //Atualiza Log..
  nbrLogs::AddAction('DEL', 'Excluiu o registro ' . $id . ' da tabela ' . $tableName);     
  
} catch (Exception $e){
  if($db->errorNumber = 1451)
    returnError('Existem outros registros que utilizam este registro a qual você deseja excluir.', $db->errorMsg);
  else 
    returnError('Ocorreu um erro ao tentar excluir registro.', $db->errorMsg);
}

if($res){
  $dataSet->SetParam('msgSucess', 'O registro foi excluído com sucesso.');
  
  //Se excluiu, verifica se existe evento beforeDelete na macro...
  if(function_exists('macroAfterDelete')){
    macroAfterDelete($tableName, $id, $reg);
  }
  
}else
  $dataSet->SetParam('msgError', 'Ocorreu um erro ao tentar excluir este registro.');

$hub->BackLevel(2);

header('location:' . $hub->GetUrl());
?>
