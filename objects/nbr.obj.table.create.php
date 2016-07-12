<?
class nbrTableCreate {
  
  private $fields;
  private $tableName;
  private $comments;
  private $isSystem;
  private $order = 10;
  
  
  function __construct($tablename){
    $this->tableName = $tablename;
  }
  
  private function addField($name, $type, $length = 0, $tableLink = null, $listValues = null){
    $field = array( 'name'        => $name,
                    'type'        => $type,
                    'length'      => $length,
                    'tablelink'   => $tableLink,
                    'listValues'  => $listValues
                  );
    $this->fields[] = $field;
  }

  public function AddFieldString($name, $length){
    $this->addField($name, 'STR', $length);
  }
  
  public function AddFieldInteger($name){
    $this->addField($name, 'INT');
  }
  
  public function AddFieldText($name){
    $this->addField($name, 'TXT');
  }

  public function Execute($comments = null, $isSystem = false){
    global $db;

    //SQL...
    $sql  = 'CREATE TABLE `' . $this->tableName . '` (';
    $sql .= '  `ID` int(11) NOT NULL AUTO_INCREMENT,';
    
    foreach ($this->fields as $field) {
      
      switch ($field['type']) {
      	case 'STR':
      		$sql .= ' `' . $field['name'] . '` varchar(' . $field['length'] . ') DEFAULT NULL,';
      		break;

        case 'INT':
      		$sql .= ' `' . $field['name'] . '` int(11) DEFAULT NULL,';
      		break;
      		
      	case 'TXT':
      	  $sql .= ' `' . $field['name'] . '` TEXT NULL,';
      	  break;
      }
    }
    
    $sql .= '  `LastUpdate` datetime DEFAULT NULL,';
    $sql .= '  `LastUserName` varchar(50) DEFAULT NULL,';
    $sql .= '  PRIMARY KEY (`ID`)';
    $sql .= ") ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='" . $comments . "';";
    
    $db->Execute($sql);
    
    //Registra tabelas no CMS...
    
    //Tabela...
    $table = new nbrTablePost();
    $table->table = 'sysTables';
    $table->AddFieldString('Name', $this->tableName);
    $table->AddFieldString('Comment', $comments);
    $table->AddFieldBoolean('IsSystem', (($isSystem)?true:false));
    $table->Execute();
    
    $tableID = $table->id;
    
    //Campos...
    foreach ($this->fields as $f) {
      
      switch ($f['type']) {
        
      	case 'STR':
      		$field = new nbrTablePost();
      		$field->table = 'sysTableFields';
      		$field->AddFieldInteger('Table', $tableID);
      		$field->AddFieldString('Type', 'STR');
      		$field->AddFieldString('Name', $f['name']);
      		$field->AddFieldString('Length', $f['length']);
      		$field->Execute();
      		break;

      	case 'TXT':
      		$field = new nbrTablePost();
      		$field->table = 'sysTableFields';
      		$field->AddFieldInteger('Table', $tableID);
      		$field->AddFieldString('Name', $f['name']);      		
      		$field->AddFieldString('Type', 'TXT');
      		$field->Execute();
      		break;      		

      	case 'INT':
      		$field = new nbrTablePost();
      		$field->table = 'sysTableFields';
      		$field->AddFieldInteger('Table', $tableID);
      		$field->AddFieldString('Name', $f['name']);      		
      		$field->AddFieldString('Type', 'INT');
      		$field->Execute();
      		break;      		
      }
    }
  }
  
  public static function DeleteTable($tablename){
    global $db;
    
    $sql = "SELECT * FROM  sysTables WHERE Name = '$tablename'";
    $tables = $db->LoadObjects($sql);
    $table = $tables[0];
    
    $sql = "DELETE FROM  sysTableFields WHERE `Table` = " . $table->ID;
    $db->Execute($sql);
    
    $sql = "DELETE FROM  sysTables WHERE ID = " . $table->ID;
    $db->Execute($sql);
    
    $sql = "DROP TABLE `" . $tablename . "`";
    $db->Execute($sql);
  }
}
?>