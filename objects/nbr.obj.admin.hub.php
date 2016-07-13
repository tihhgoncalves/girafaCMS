<?
class nbrAdminHub{
  
  public $levels;
  private $fileCache;
  
  function __construct(){
    
    //Pega chave..
    if(isset($_GET['hub'])){
      $key = $_GET['hub'];
      $fileCache = $this->getFilePath($key);
      
      if(file_exists($fileCache))
        $this->fileCache = $fileCache;
    }
    //Carrega novo nível..
    $this->starts();
  }

  private function starts(){
    //Se estiver tudo ok com arquivo de cache, carrega parâmetros...
    if(!empty($this->fileCache)){
      $this->LoadCache();
    }
        
    //abre novo nível em branco...
    $this->levels[] = array();    
  }  

  private function getFilePath($key){
    global $CACHE_PATH;
    
    return $CACHE_PATH . $key . '.hub';
  }
  
  private function crypt($str){
    //$str = utf8_decode($str);
    $str = base64_encode($str);
    return $str;
  }
  
  private function decrypt($str){
    $str = base64_decode($str);
    $str = $str;
    return $str;
  }
  
  private function LoadCache(){
    //abre arquivo...
    $fp = fopen($this->fileCache, "r");
    $str = fread($fp, filesize($this->fileCache));
    $str = $this->decrypt($str);
    fclose($fp);
    
    $this->levels = $this->strToArray($str);
  }
  
  /**
   * Adiciona (ouo atualiza) parâmetro do últim nível
   *
   * @param string $name
   * @param string $value
   */
  public function SetParam($name, $value){
    $lastLevel = count($this->levels) - 1;
    
    //Tira caracters conflitantes no Valor..
    $value = str_replace(',', '[vg]', $value);
    $value = str_replace('|', '[pi]', $value);
    $value = str_replace('=', '[eq]', $value);
      
    //adiciona parâmetro..
    $this->levels[$lastLevel][$name] = $value;
  }
  
  private function strToArray($str){
    $levels = explode('|', $str);
    
    $n_level = array();
    foreach ($levels as $x=>$level) {
    	
      $params = explode(',', $level);
      
      foreach ($params as $param) {
        $param = explode('=', $param);
        $n_level[$x][$param[0]] = $param[1];
      }
    }
    return $n_level;
  }
  private function arrayToStr($array){
    
    $str = null;
    //Níveis..
    foreach ($array as $x=>$params) {
    	
      if($x > 0)
        $str .= '|';
      
      $i = 0;
      foreach ($params as $key=>$param) {
        
        if($i > 0)
          $str .= ',';
          
        $str .= $key . '=' . $param;
      	
        $i++;
      }
    }
    return $str;
  }
  
  /**
   * Retorna Parâmetro d
   *
   * @param unknown_type $name
   * @return unknown
   */
  public function GetParam($name){
    if(count($this->levels) > 1){
      $penultimateLevel =  count($this->levels) - 2;
      
      if(!isset($this->levels[$penultimateLevel][$name]))
        return  null;
        
      $value = $this->levels[$penultimateLevel][$name];
      //Traduz caracters conflitantes no Valor..
      $value = str_replace('[vg]', ',', $value);
      $value = str_replace('[pi]', '|', $value);
      $value = str_replace('[eq]', '=', $value);
      
      return utf8_encode($value);
    }
    return null;
  }
  
  public function RemoveParam($name){

    if(count($this->levels) > 1){
      $level =  count($this->levels) - 1;    
    
      unset($this->levels[$level][$name]);
    }
  }
  
  /**
   * Verifica se existe parâmetro na Pilha..
   *
   * @param string $name
   * @return boolean
   */
  public function ExistParam($name){
    if(count($this->levels) > 1){
      $penultimateLevel =  count($this->levels) - 2;
      
      return ( isset($this->levels[$penultimateLevel][$name]) && (!empty($this->levels[$penultimateLevel][$name])) );
    }
    return false;    
  }
  
  public function GetUrl($clearLevel = true){
    global $ADMIN_URL, $ROUTER_LINKMASK;

    $str = $this->arrayToStr($this->levels);
    $str = $this->crypt($str);
    
    $key = md5($str);
    
    //salva Cache..
    $file = fopen($this->getFilePath($key), 'w');
    fwrite($file, $str);
    fclose($file); 
    
    if($clearLevel){
      //Carrega HUB inicial...
      $this->starts();      
    }
    
    return $ADMIN_URL . $ROUTER_LINKMASK . $key;
  }
  
  /**
   * Carrega Parâmetros da Url para o nível atual
   *
   */
  public function LoadParamsBack(){
    $penultimateLevel =  count($this->levels) - 2;
    $lasLevel =  count($this->levels) - 1;
    
    $this->levels[$lasLevel] = $this->levels[$penultimateLevel];
  }
  
  /**
   * Exclui o último nível da Pilha (levanto o ponteiro ao penúltimo
   *
   */
  public function BackLevel($loop = 1){
    for ($i = 0; $i < $loop; $i++)
      array_pop($this->levels);
  }
   
  /**
   * Retorna Link da página com o Path correspondente
   *
   * @return unknown
   */
  public function GetFilePage(){
    global $ADMIN_PAGES_PATH, $MODULES_PATH;
      return $this->GetParam('_page');
  }

  /**
   * Imprime (print_r) pilha de parametros na tela
   *
   */
  public function PrintUrlParameters(){
    print_r($this->levels);
  }
  
  /**
   * Reseta níveis (preservando o número de níveis indicados)
   * @param integer $keepUp
   */
  public function ClearHistory($keepUp = 0){
    $level = array_slice($this->levels, 0, $keepUp);
    $this->levels = $level;
    $this->levels[] = array();
  }
  
  /**
   * Retorna o número total de níveis
   *
   * @return integer
   */
  public function CountLevels(){
    return count($this->levels) - 1;
  }
  
  public function GetStackString(){
    
    $stack = array();
    
    $levels = $this->levels;
    $stack = array();
    
    for($i = 0; $i < count($levels); $i++){
      $nlevels = array_slice($levels, 0, $i+1);
      $lastLevel = $nlevels[count($nlevels) -1];
      $this->levels = $nlevels;
      
      if(isset($lastLevel['_title']) && !empty($lastLevel['_title'])){
        $title = $lastLevel['_title'];
        
        if(isset($lastLevel['_title'])){
          $title = $lastLevel['_title'];
        } else {
          $title = null;
        }
        
        if(isset($lastLevel['_description']))
          $description = $lastLevel['_description'];
        else 
          $description = null;
          
         
          
        $link = $this->GetUrl();
        
        //se for ultimo (penultimo, pq o ultimo está em branco) nivel..
        if($i == count($levels) -2)
          $stack[] = '<span class="lastLevel">' . $title . '</span>';
        else
          $stack[] = '<a href="' . $link . '" title="' . $description . '">' . $title . '</a>';
      }
    }
    return implode(' &raquo; ', $stack);
  }
  
}
?>