<?
class nbrParams{
  
  public $params = array();
  
  public function __construct(){
    global $db;
    $sql  = 'SELECT * FROM sis_parametros';
    $pms = $db->LoadObjects($sql);
    
    foreach ($pms as $pm) {
      $this->params[$pm->Identificador] = $pm->Valor;
    }
    
  }
  
  /**
   * Retorna o valor do Parâmetro com o respectivo ID
   *
   * @param string $id
   * @return string
   */
  public function GetParam($id, $breakLines = false){
    if($breakLines)
      return nl2br($this->params[$id]);
    else
      return $this->params[$id];
  }
  
  
  
}
?>