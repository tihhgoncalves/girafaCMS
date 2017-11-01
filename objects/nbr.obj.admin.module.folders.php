<?
class nbrModuleFolders{
  private $module;
  private $folders;
  
  function __construct($module){
    global $db;
    
    $sql  = 'SELECT * FROM sis_pastas';
    $sql .= ' WHERE MODULE = ' . $module . " AND Actived = 'Y'";
    $sql .= ' ORDER BY `Order` ASC, Grouper ASC';
    $res = $db->LoadObjects($sql);
    
    $this->folders = $res;
  }
  
  /**
   * Retorna pastas do Módulo especificado
   *
   * @return array
   */
  public function GetFolders(){
    return $this->folders;
  }
}
?>