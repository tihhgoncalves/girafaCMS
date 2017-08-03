<?

/**
 * Parâmetros..
 */
$tableName  = $hub->GetParam('tableName');
$id         = $hub->GetParam('ID');
$action     = $hub->GetParam('action');

/** Campos.. **/
$fields = $hub->GetParam('fields');
$fields = explode(',', $fields);

/** Campos de Data **/
$fieldsDate = $hub->GetParam('fieldsDate');
$fieldsDate = explode(',', $fieldsDate);

/** Campos de Senha **/
$fieldsPassword = $hub->GetParam('fieldsPassword');
$fieldsPassword = explode(',', $fieldsPassword);

/** Campos de Imagem **/
$fieldsImage = $hub->GetParam('fieldsImage');
if(empty($fieldsImage))
  $fieldsImage = array();
else 
  $fieldsImage = explode(',', $fieldsImage);

/** Campos de Arquivo **/
$fieldsFile = $hub->GetParam('fieldsFile');
if(empty($fieldsFile))
  $fieldsFile = array();
else
  $fieldsFile = explode(',', $fieldsFile);


//Faz uma limpa nos caracteres "estranhos" dos campos..
for($i = 0; $i < count($fields); $i++){
  $antigos = array('–', '“', '”');
  $novos = array('-', '"', '"');
  $_POST[$fields[$i]] = str_replace($antigos, $novos, $_POST[$fields[$i]]);
}


//Verifica se senha não foi informada/alterada e retira o campo da lista..
//Ou criptografa e salva no banco
foreach ($fieldsPassword as $fieldPassword) {
  
  if($_POST[$fieldPassword] == '[NAOATUALIZAR]'){
    
    $n_fields = array();
    foreach ($fields as $field) {
    	
      if($field != $fieldPassword)
        $n_fields[] = $field;
    }
    //Atualiza lista de campos...
    $fields = $n_fields; 
  } else {
    $_POST[$fieldPassword] = md5($_POST[$fieldPassword]);
  }
}

//Corrige formato de campo de Data e DataHora..
foreach ($fieldsDate as $fieldName) {
  
  if(isset($_POST[$fieldName])){
    
    $str = $_POST[$fieldName];
    
    //Verifica se é no formato brasileiro..
    if(!(strpos($str, '/') === false)){
      
    	$str = explode(' ', $str);
    	
    	$data = @$str[0];
    	$hora = @$str[1];
    	
    	$str_data = explode('/', $data);
    	$data = $str_data[2] . '-' . $str_data[1] . '-' . $str_data[0];
    	
    	$_POST[$fieldName] = $data;
    	
    	if(!empty($hora))
    	   $_POST[$fieldName] .= ' ' . $hora;
    }
  }	
}

//Corrige formato de campos de Numero Decimal
$fieldsNumber = $hub->GetParam('fieldsNumber');
$fieldsNumber = explode(',', $fieldsNumber);
foreach ($fieldsNumber as $fieldName) {
  
  if(isset($_POST[$fieldName])){
    
    $str = $_POST[$fieldName];
    $str = str_replace('.', '', $str);
    $str = str_replace(',', '.', $str);
    $_POST[$fieldName] = $str;
  }	
}

/**
 * Verifica se Existe arquivo de Macro
 */
if($hub->ExistParam('fileMacro')){
  $macroPath = $MODULES_PATH . $hub->GetParam('fileMacro');
  
  //verifica se arquivo existe fisicamente..
  if(!file_exists($macroPath))
    throw new Exception('O arquivo especificado de macro não foi encontrado:' . $macroPath);
  
  //Chama arquivo de macro...
  include($macroPath);
}

//Novo ou Edição...
if(intval($hub->GetParam('ID')) > 0){
  
  //Verifica se existe evento beforePost na macro...
  if(function_exists('macroBeforePost')){
    macroBeforePost($tableName, $id);
  }
  
  $sql = 'UPDATE ' . $tableName;
  $sql .= ' SET ';
  
  /** Campos.. **/
  foreach ($fields as $x=>$field) {
    
    if($x > 0)
      $sql .= ', ';
      
    if(empty($_POST[$field]))
      $sql .= $field . "=NULL";
    else 
      $sql .= '`' . $field . "`='" .addcslashes($_POST[$field], "'") . "'";
  }
  
  //Adiciona Data de Ultima Atualização..
  $sql .= ", LastUpdate = NOW(), LastUserName = '" . $security->GetUserName() . " (" . $security->GetUserMail() . ")'";
  
  //Verifica se a pasta (folder) é Multilinguística e adiciona o idioma ao registro...
  if($hub->GetParam('_languages') == 'Y'){
  	$sql .= ", Lang = '" . $_SESSION['lang_admin'] . "'";
  }
  
  $sql .= ' WHERE ID=' . $id;
  $status = $db->Execute($sql);
  
  //Atualiza Log..
  nbrLogs::AddAction('EDT', 'Atualizou o registro ' . $id . ' da tabela ' . $tableName);     
  
  //URL de retorno...
  if($action == 'S'){
    
    $hub->BackLevel(2);
    $link = $hub->GetUrl();
    
  } elseif ($action == 'SN'){

    $hub->BackLevel(2);
    
    $hub->SetParam('_title', 'Novo Registro');
    $hub->SetParam('ID', -1);
    $hub->SetParam('_description', 'Novo Registro');    

    $link = $hub->GetUrl();    
    
  } elseif ($action == 'SV'){

    $hub->BackLevel(3);
    $link = $hub->GetUrl();
    
  }
  
  if($status){
    $dataSet->SetParam('msgSucess', '<b>Show!</b> Seu registro foi atualizado com sucesso.');
    
    //Executa campos imagem..
    executeImages();
    
    //Executa campos Arquivo..
    executeFiles();
    
    //Executa "campos" LkpMultselects
    executeLkpMultselects();
    
    
  
   //Verifica se existe evento afterPost na macro...
    if(function_exists('macroAfterPost')){
      macroAfterPost($tableName, $id);
    }    
  } else 
    $dataSet->SetParam('msgError', 'Ocorreu um erro ao tentar atualizar o registro.');

} else {
  
  //Verifica se existe evento beforePost na macro...
  if(function_exists('macroBeforePost')){
    macroBeforePost($tableName, -1);
  }
    
  $sql = 'INSERT INTO ' . $tableName;
  
  $str_fields;
  $str_values;
  foreach ($fields as $x=>$field) {
    
    if($x > 0){
      $str_fields .= ', ';
      $str_values .= ', ';
    }
    
    $str_fields .= '`' . $field . '`';
    if(empty($_POST[$field]) && ($_POST[$field] != '0'))
      $str_values .= "NULL";
    else 
      $str_values .= "'" . addcslashes($_POST[$field], "'") . "'";
  }
  
  //Adiciona Data de Ultima Atualização..
  $str_fields .= ', LastUpdate, LastUserName';
  $str_values .= ", NOW(), '" . $security->GetUserName() . " (" . $security->GetUserMail() . ")'";

  //Verifica se a pasta (folder) é Multilinguística e adiciona o idioma ao registro...
  if($hub->GetParam('_languages') == 'Y'){
  	$str_fields .= ', Lang';
  	$str_values	.= ", '" . $_SESSION['lang_admin'] . "'";
  }  
  
  $sql .= "($str_fields) VALUES($str_values)";
  
  try {
    $db->Execute($sql);  
    $id = $db->GetLastIdInsert();
  //URL de retorno...
  if($action == 'S'){

    $hub->BackLevel(2);
    $hub->SetParam('ID', $id);
    $hub->SetParam('_title', 'Editando...');
    $hub->SetParam('_description', 'Editando registro recém criado');
    $link = $hub->GetUrl();
    
  } elseif ($action == 'SN'){

    $hub->BackLevel(2);
    
    $hub->SetParam('_title', 'Novo Registro');
    $hub->SetParam('ID', -1);
    $hub->SetParam('_description', 'Novo Registro');    

    $link = $hub->GetUrl();    
    
  } elseif ($action == 'SV'){

    $hub->BackLevel(3);
    $link = $hub->GetUrl();
    
  }

     
    $dataSet->SetParam('msgSucess', 'Seu registro foi inserido com sucesso.');
      
    //Executa campos imagem..
    executeImages();
    
    //Executa campos imagem..
    executeFiles();
    
    //Executa Campos Lookup Multiselectes
    executeLkpMultselects();

    //Atualiza Log..
    nbrLogs::AddAction('NEW', 'Inseriu um novo registro na tabela ' . $tableName . ' que recebeu o ID ' . $id);   
        
    //Verifica se existe evento afterPost na macro...
    if(function_exists('macroAfterPost')){
      macroAfterPost($tableName, $id);
    }
          
  } catch (Exception $e) {
    returnError('Ocorreu um erro ao tentar inserir novo registro.', $db->errorMsg);
  }
}

function executeImages(){
  global $tableName, $fieldsImage, $id, $_POST, $_FILES, $ADMIN_UPLOAD_PATH;

  //Copia imagens dos Campos Imagem...
  foreach ($fieldsImage as $fieldName) {
    
    //pega extensao..
    $nome_original = $_FILES[$fieldName]["name"];
    $nome_original = strtolower($nome_original);

    $extensao = substr($nome_original, -3);
    $extensao = strtolower($extensao); //força minúsculo
    $extensao = ($extensao == 'peg'?'jpg':$extensao); //se o nome do arquivo estava .jpeg ele corrige a extensão pra .jpg

    $fileName = strtolower($tableName) . '_' . strtolower($fieldName) . '_' . $id . '.' . $extensao;  
    $fileNameFull = $ADMIN_UPLOAD_PATH . $fileName;

    if($_POST[$fieldName . '_status'] == 'Y') {
      
      //verifica se está na extensão correta..
      if (!(($_FILES[$fieldName]["type"] == "image/jpeg")
        || ($_FILES[$fieldName]["type"] == "image/pjpeg")
        || ($_FILES[$fieldName]["type"] == "image/png")))
          returnError("O campo $fieldName do tipo Imagem deve ser preenchido com um arquivo de extensão jpg ou png.");
          
      if(($_FILES[$fieldName]["size"] > 5242880))
        returnError("O campo $fieldName do tipo Imagem deve conter um arquivo com menos de 5mb de tamanho.");
        
      //Verifica se já existe arquivo neste campo e o exclue
      if(file_exists($fileNameFull))
        deleteImage($fileName);
        
      //Copia novo arquivo..
      move_uploaded_file($_FILES[$fieldName]["tmp_name"], $fileNameFull);
      
      //Atualiza registro com nome da imagem..
      $post = new nbrTablePost();
      $post->table = $tableName;
      $post->id = $id;
      $post->AddFieldString($fieldName, $fileName);
      $post->Execute();
      
    } elseif($_POST[$fieldName . '_status'] != 'N') {
      //limpa campo..
  
      //Verifica se ainda existe arquivo neste campo e o exclue
      if(file_exists($fileNameFull))
        deleteImage($fileName);

      //Atualiza registro com nome da imagem..
      $post = new nbrTablePost();
      $post->table = $tableName;
      $post->id = $id;
      $post->AddFieldString($fieldName, null);
      $post->Execute();
    }
  }
}

function deleteImage($fileName){
  global $ADMIN_UPLOAD_PATH;
  
  //deleta imagem.
  unlink($ADMIN_UPLOAD_PATH . $fileName);
  
  $fileCru = substr($fileName, 0, strlen($fileName) -4);

  /* TIHH - será excluida essa parte...
  //Exclue versões no cache
  $dir = opendir($CACHE_PATH);
  while ($nome_itens = readdir($dir)) {
  
    if (ereg($fileCru . '.+(.jpg)', $nome_itens)) {
      unlink($ADMIN_UPLOAD_PATH . 'cache/' . $nome_itens);
    }
  }
  **/
}
function GetFileExtension($path){
  $re = '/^.*(\.[^\.]*)$/';
  preg_match_all($re, $path, $matches);

  return $matches[1][0];
}


function executeFiles(){
  global $tableName, $fieldsFile, $id, $_POST, $_FILES, $ADMIN_UPLOAD_PATH, $db, $cms, $TEMP_PATH;



  //Varre todos os campos de arquivos
  foreach ($fieldsFile as $fieldName) {


    if($_POST[$fieldName . '_status'] == 'Y') {

    $field_file = $_FILES[$fieldName];

    $file_name = $field_file['name'];
    $file_tmp = $field_file['tmp_name'];
    $fileName = strtolower($tableName) . '_' . strtolower($fieldName) . '_' . $id . GetFileExtension($file_name);
    $fileNameFull = $ADMIN_UPLOAD_PATH . $fileName;

      //Verifica se já existe arquivo neste campo e o exclue
      $sql = "SELECT `$fieldName` FROM `$tableName` WHERE Id = $id";
      $rs = $db->LoadObjects($sql);
      $rg = $rs[0];

      if (!empty($rg->$fieldName))
        deleteFile($rg->$fieldName);

      //Copia novo arquivo..
      copy($file_tmp, $fileNameFull);

      //Apaga de temp..
      unlink($file_tmp);

      //Atualiza registro com nome do arquivo...
      $post = new nbrTablePost();
      $post->table = $tableName;
      $post->id = $id;
      $post->AddFieldString($fieldName, $fileName);
      $post->Execute();

    } else if ($_POST[$fieldName . '_status'] != 'N') {

      //Verifica se já existe arquivo neste campo e o exclue
      $sql = "SELECT `$fieldName` FROM `$tableName` WHERE Id = $id";
      $rs = $db->LoadObjects($sql);
      $rg = $rs[0];

      if (!empty($rg->$fieldName))
        deleteFile($rg->$fieldName);

      //Atualiza registro com nome do arquivo...
      $post = new nbrTablePost();
      $post->table = $tableName;
      $post->id = $id;
      $post->AddFieldString($fieldName, null);
      $post->Execute();

    }




    /*

      //Atualiza registro com nome da imagem..
      $post = new nbrTablePost();
      $post->table = $tableName;
      $post->id = $id;
      $post->AddFieldString($fieldName, null);
      $post->Execute();


          
      $tmp = explode('/', $file);
      $fileName = array_pop($tmp);
      
      
      $tmp = explode('.', $fileName);
      $ext = array_pop($tmp);
      
      $fileName = strtolower($tableName) . '_' . strtolower($fieldName) . '_' . $id . '.' . $ext;  
      $fileNameFull = $ADMIN_UPLOAD_PATH . $fileName;


      //Verifica se já existe arquivo neste campo e o exclue
      $sql = "SELECT `$fieldName` FROM `$tableName` WHERE Id = $id";
      $rs = $db->LoadObjects($sql);
      $rg = $rs[0];
      
      if(!empty($rg->$fieldName))
        deleteFile($rg->$fieldName);
        
      //Copia novo arquivo..
      copy($file, $fileNameFull);
      
      //Apaga de temp..
      unlink($file);
      
      //Atualiza registro com nome da imagem..
      $post = new nbrTablePost();
      $post->table = $tableName;
      $post->id = $id;
      $post->AddFieldString($fieldName, $fileName);
      $post->Execute();
      */
    }
}

function deleteFile($fileName){
  global $ADMIN_UPLOAD_PATH;
  
  //deleta imagem.
  unlink($ADMIN_UPLOAD_PATH . $fileName);
  
  $fileCru = substr($fileName, 0, strlen($fileName) -4);
}


function executeLkpMultselects(){
  global $hub, $id, $db;
  
  if($hub->ExistParam('LkpMultselects')){
    
    //Pega Parmêtros do Hub..
    $fields = $hub->GetParam('LkpMultselects');
    
    //Se só tiver 1 campo (e não vir em array) joga em um array...
    $fields = explode(',', $fields);  
    
    foreach ($fields as $field) {
  
      $vals = explode('|', $field);
      
      //Parametros..
      $name                = $vals[0];
      $tableName           = $vals[1];
      $fieldPrimary        = $vals[2];
      $tableSecondary      = $vals[3];
      $fieldSecondary      = $vals[4];
      $fieldOrder          = $vals[5];
      $orderValueVariation = $vals[6];

      $ids = array();

            
          	
      //Registros selecionados..
      if(isset($_POST[$name])){
        $regs = $_POST[$name];
        
        $order = 0;
        
        if(!is_array($regs))
          $regs = array();
        
        foreach ($regs as $val) {
          
          $order += $orderValueVariation;
        	
          $sql  = "SELECT ID FROM `$tableName`";
          $sql .= " WHERE `$fieldPrimary` = $id AND `$fieldSecondary` = $val";
          $res = $db->LoadObjects($sql);

          $post = new nbrTablePost();
          $post->table = $tableName;
          $post->AddFieldInteger($fieldPrimary, $id);
          $post->AddFieldInteger($fieldSecondary, $val);
          
          if(!empty($fieldOrder))
            $post->AddFieldInteger($fieldOrder, $order);
            
          
          if(count($res) == 0){  
            $post->Execute();
            $ids[] = $post->id;
          } else {
            $ids[] = $res[0]->ID;
            $post->id = $res[0]->ID;
            $post->Execute();
          }
        }
      } else 
        $ids = array('0');
        
      //Exclue os que não fazem mais parte da lista..
      $sql  = "DELETE FROM `$tableName`";
      $sql .= " WHERE `$fieldPrimary` = $id AND ID NOT IN(" . implode(',',$ids) . ")";
      $db->Execute($sql);
    }
    
  }
}

//Seta cookie do "Salvar"...
$cookie_name = $SITEKEY . '_nbrSave';
setcookie($cookie_name, $action);  

//Chama link...
header('location:' . $link);
?>
