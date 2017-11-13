<?
class nbrTablePost{
  private $fields = array();
  private $files = array();
  
  public $table;
  public $id = -1;
  
  public function getSql(){
    
    //Inserção ou Atualização..
    if($this->id > 0){
      
      $sql   = 'UPDATE ' . $this->table . ' SET ';
      
      foreach ($this->fields as $x=>$field) {
        
        if($x > 0)
          $sql .= ', ';
        
      	$sql .= '`' . $field[0] . '` = ' . $field[1];
      }
      
      $sql .= ' WHERE ID = ' . $this->id;
      
    } else {
      
      $sql  = 'INSERT INTO ' . $this->table;
      
      $fields = array();
      $values = array();
      foreach ($this->fields as $field) {
      	$fields[]  = '`' . $field[0] . '`';
      	$values[] = $field[1];
      }
      
      $sql .= '(' . implode(', ', $fields) . ')';
      $sql .= ' VALUES(' . implode(', ', $values) . ')';
    }
    
    return $sql;
  }
   /**
    * Verifica se o campo já foi setado e retorna resposta.
    * Se $delete for igual a true, ele exclue o campo.
    *
    * @param string $fieldName
    * @param string $delete
    * @return boolean
    */
  private function verifyField($fieldName, $delete = true){
	
  	foreach ($this->fields as $x=>$field) {
  		
  		if($field[0] == $fieldName)	{
  			if($delete){
  				//exclue
  				unset($this->fields[$x]);
  			}
  			return true;
  		}
  	}
  	return false;
  }
  
  public function AddFieldString($fieldName, $value){
    
  	//verifica se já foi setado este campo...
  	$this->verifyField($fieldName);
  	
    if($value == null)
      $field = array($fieldName, "NULL");
    else 
      $field = array($fieldName, "'" . $value . "'");
    
    $this->fields[] = $field;
  }

  public function AddFieldDateTimeNow($fieldName){
    $field = array($fieldName, "NOW()");
    $this->fields[] = $field;
  }

  public function AddFieldDateToday($fieldName){
    $field = array($fieldName, "TODAY()");
    $this->fields[] = $field;
  }


  public function AddFieldNumber($fieldName, $value){
    
    if($value == null)
      $field = array($fieldName, "NULL");
    else 
      $field = array($fieldName, number_format($value, 2, '.', ''));
    
    $this->fields[] = $field;    

  }
  
  public function AddFieldInteger($fieldName, $value){
  	
  	//verifica se já foi setado este campo...
  	$this->verifyField($fieldName);
  	
    $field = array($fieldName, intval($value));
    $this->fields[] = $field;
  }
  
  public function AddFieldBoolean($fieldName, $value){
  	
  	//verifica se já foi setado este campo...
  	$this->verifyField($fieldName);
  	
    $field = array($fieldName, ($value)?"'Y'":"'N'");
    $this->fields[] = $field;
  }
  
  public function AddFieldDateTime($fieldName, $value){
  	
  	//verifica se já foi setado este campo...
  	$this->verifyField($fieldName);
  	
    $this->AddFieldString($fieldName, $value);
  }

  /**
   * Cadastro o campo no campo e já o cadastra...
   *
   * @param string $fieldName
   * @param string $valuePost ($_FILES['campo'])
   */
  public function AddFieldFilePostFiles($fieldName, $valuePost){
  	
  	//verifica se já foi setado este campo...
  	$this->verifyField($fieldName);
  	
  	//variaveis..
  	$nome 		= $valuePost['name'];
  	$nomeTMP 	= $valuePost['tmp_name'];

  	//adicionar no array...
  	$this->files[] = array( 'name'		=>	$nome,
  							'nameTMP' 	=> 	$nomeTMP,
  							'fieldname' =>  $fieldName
  							);
  }
    
  public function Execute(){
    global $db, $security, $ADMIN_UPLOAD_PATH;
    
    $sql = $this->getSql();
    
    $res = $db->Execute($sql);
    
    if(intval($this->id) <= 0)
      $this->id = $db->GetLastIdInsert();
      
    //copia e atualiza arquivos...
    if(count($this->files) > 0){
		$npost = new nbrTablePost();
		$npost->table = $this->table;    
		$npost->id = $this->id;
    }
    
    foreach ($this->files as $file) {

	    //pega extensao..
	    $nome_original = $file['name'];
	    $nome_original = strtolower($nome_original);
	    $extensao = substr($nome_original, -3); 

	    //Nome do arquivo
	    $fileName = strtolower($this->table) . '_' . strtolower($file['fieldname']) . '_' . $this->id . '.' . $extensao;  
	    $fileNameFull = $ADMIN_UPLOAD_PATH . $fileName;
	    
	    //copia pro servidor
    	move_uploaded_file($file['nameTMP'], $fileNameFull);
		
    	//atualiza banco...
		$npost->AddFieldString($file['fieldname'], $fileName);
    }
    
    if(count($this->files) > 0){
    	$npost->Execute();    	
    }
    
    return $res;
  } 
}
?>