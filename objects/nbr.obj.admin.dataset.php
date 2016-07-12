<?
class nbrDataSet{
  private $params = array();
  
  function __construct(){
     
    if(isset($_SESSION['nbr_dataSet']))
      $this->params = $_SESSION['nbr_dataSet'];
     
    //verifica se trouxe dados por post
    if($this->ExistParam('_post')){
      $_POST = $this->GetParam('_post');
      $this->DeleteParam('_post');
    }
  }
  
  private function updateSession(){
    $_SESSION['nbr_dataSet'] = $this->params;
  }
  
  /**
   * Adiciona (ou atualiza) parâmetro na Sessão
   *
   * @param string $name
   * @param string $value
   */
  public function SetParam($name, $value){
    $this->params[$name] = $value;
    
    $this->updateSession();
  }
  
  /**
   * Verifica se parâmetro está declarado na sessão
   *
   * @param string $name
   * @return boolean
   */
  public function ExistParam($name){
    return ( (isset($this->params[$name])) && (!empty($this->params[$name])) );
  }
  
  /**
   * Retorna parâmetro na Sessão
   *
   * @param string $name
   */
  public function GetParam($name){
    
    if($this->ExistParam($name))
      return $this->params[$name];
    else 
      return null;
  }
  
  public function DeleteParam($name){
    
    $n_params = array();
    
    foreach ($this->params as $key=>$param) {
    	if($key != $name)
    	 $n_params[$key] = $param;
    }
    
    $this->params = $n_params;
    
    $this->updateSession();
  }
}
?>