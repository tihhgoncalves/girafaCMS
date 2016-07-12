<?
class nbrTableManager{

  public $table;
  public $comments;
  public $fields = array();
  public $autoDelete;

  private $tableID;


  function nbrTableManager($table, $comments, $autoDelete = true){
    $this->table = $table;
    $this->comments = $comments;
    $this->autoDelete = $autoDelete;
  }

  private function addField($name, $type, $length = 0, $tableLink = null, $listValues = null){
    $field = array(
      'name'        => $name,
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


  public function CreateTable(){
    global $db;

    //se a tabela não for $autoDelete, verifica se já está instalada e ignora..
    if(!$this->autoDelete){
      $sql = "SELECT * FROM `sysTables` WHERE `Name` = '" . $this->table . "'";
      $res = $db->LoadObjects($sql);
      if(count($res) > 0){
        return;
      }
    }

    $table = new nbrTableCreate($this->table);

    foreach($this->fields as $field){

      switch($field['type']){

        case 'STR':
          $table->AddFieldString($field['name'], $field['length']);
          break;

        case 'INT':
          $table->AddFieldInteger($field['name'], $field['length']);
          break;

        case 'TXT':
          $table->AddFieldText($field['name']);
          break;

      }
    }

    $table->Execute($this->comments, false);

  }

  public function DropTable(){

    //se não for $autoDelete, ignora..
    if(!$this->autoDelete){
      return;
    }

    //limpa tabela..
    $this->CleanTable();

    //exclue campos...
    $this->DeleteFields();

    //exclue tabela...
    $this->DeleteTable();

  }


  public function GetTableID(){
    global $db;

    if(!empty($this->tableID))
      return $this->tableID;

    //Decobre ID no CMS da tabela
    $sql  = "SELECT ID FROM `sysTables` WHERE Name = 'TesteDeTabela'";
    $res = $db->LoadObjects($sql);

    if(count($res) > 0){
      $this->tableID = $res[0]->ID;
      return $res[0]->ID;
    } else {
      throw new Exception("A tabela '" . $this->table . "' não foi encontrada no CMS.");
    }
  }

  public function CleanTable(){
    global $db;

    $sql = 'DELETE FROM ' . $this->table;
    $db->Execute($sql);
  }

  public function DeleteFields(){
    global $db;
    $tableID = $this->GetTableID();


    //consulta todos os campos..
    $sql = 'SELECT * FROM `sysTableFields` WHERE `Table` = ' . $tableID;
    $res = $db->LoadObjects($sql);

    foreach($res as $reg){
      $sql = 'ALTER TABLE `' . $this->table . '` DROP `' . $reg->Name . '`';
      $db->Execute($sql);
    }

    //exclue todos os campos no CMS..
    $sql = 'DELETE FROM `sysTableFields` WHERE `Table` = ' . $tableID;
    $db->Execute($sql);

  }

  public function DeleteTable(){
    global $db;

    //exclue tabela no CMS...
    $sql = 'DELETE FROM `sysTables` WHERE ID = ' . $this->GetTableID();
    $db->Execute($sql);

    //exclue fisicamente
    $sql = 'DROP TABLE ' . $this->table;
    $db->Execute($sql);
  }



}
?>