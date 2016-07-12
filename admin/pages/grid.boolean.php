<?

$table = $hub->GetParam('table');
$field = $hub->GetParam('field');
$id    = $hub->GetParam('id');
$value = ($hub->GetParam('value') == 'Y');

//carrega macro...
if($hub->ExistParam('fileMacro')){
  $macroPath = $MODULES_PATH . $hub->GetParam('fileMacro');
  
  //verifica se arquivo existe fisicamente..
  if(!file_exists($macroPath))
    throw new Exception('O arquivo especificado de macro não foi encontrado:' . $macroPath);
  
  //Chama arquivo de macro...
  include($macroPath);
}

//Verifica se existe evento macroBeforeBoolean na macro...
if(function_exists('macroBeforeBoolean')){
	macroBeforeBoolean($field, $id, $value);
}

//Altera no banco valor do boolean..
$post = new nbrTablePost();
$post->table = $table;
$post->id = $id;
$post->AddFieldBoolean($field, $value);
$post->Execute();

//Verifica se existe evento macroAfterBoolean na macro...
if(function_exists('macroAfterBoolean')){
	macroAfterBoolean($field, $id, $value);
}

$hub->BackLevel(2);
header('location: ' . $hub->GetUrl());

?>