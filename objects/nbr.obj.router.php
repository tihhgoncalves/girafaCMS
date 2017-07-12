<?
class nbrRouter{
  
  public $pageFile;
  public $params;
  
  function __construct(){
    
    global $FRONT_PAGES_PATH, $SITE_PAGEINDEX, $langs;
    
    if(!empty($_GET['url'])){
      
      $params = $_GET['url'];
      $params = explode('/', $params);
      
      $lang = array_shift($params);

      //verifica se idioma está liberado no config
      if($langs->checkLanguage($lang)){
        $langs->SetLanguage($lang);
      } else {
        $langs->language = $langs->default;
        header('Location: ' . $this->GetLink(implode($params, '/')));
      }

      
      $this->params = $params;
      
      $page = array_shift($params);
      
      if($page != 's'){
        //nome do arquivo...
        $this->pageFile = $page . '.config.php';
        
        $fileFull = $FRONT_PAGES_PATH . $this->pageFile;
        
        if(!file_exists($fileFull))
          header('Location:' . nbrRouter::GetLink('404/' . $page));
      }
    } else {

      if(empty($langs->language))
        $langs->language = $langs->default;

      header('Location:' . nbrRouter::GetLink($SITE_PAGEINDEX));
      exit;
    }
  }
  
  /**
   * Retorna Link
   *
   * @param string $page
   */
   public function GetLink($page, $lang = null){
    global $LINK_PREFIX, $ROOT_URL, $langs;
    
    $url = $ROOT_URL . $LINK_PREFIX . (empty($lang)?$langs->language:$lang) . '/' . $page;
    return $url;
  }
  
  /**
   * Retorna o link da URL anterior
   *
   * @return string
   */
  public function GetUrlReference(){
  	
  	global $_SERVER;
  	
  	return $_SERVER['HTTP_REFERER'];
  }
  
  /**
   * Retorna Link da página Index do Site
   *
   * @return string
   */
  public function GetPageIndex(){
    global $SITE_PAGEINDEX;
    
    return $this->GetLink($SITE_PAGEINDEX);
  }
  
  /**
   * Retorna Parametros da URL
   *
   * @return array
   */
  public function getParamsArray(){
    return $this->params;
  }

  public function GetParam($level){
    if(isset($this->params[$level]))
      return $this->params[$level];
    else
      return false;
  }

    /**
   * Retorna Parametros da URL
   *
   * @return string
   */
  public function getParamsString(){
    return implode('/', $this->params);
  }
  
  /**
   * Retorna Nível da Página (1° nível) do LinkAmigável
   *
   * @return string
   */
  public function getPage(){
    return $this->params[0];
  }
  
  /**
   * Retorna a URL da página atual
   *
   * @return string
   */
  public function GetUrl(){
    return $this->GetLink($this->getParamsString());
  }
  
  
}
?>