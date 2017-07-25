<?
class nbrPage{
  public $title;
  public $keywords;
  public $description;
  public $pageName;
  public $index = true;
  
  private $a_css = array();
  private $a_js = array();
  private $a_image_src = array();
  
  function __construct(){
    global $router, $cms;
    $this->pageName = $router->getPage();
    
    //verifica se existe CSS com o nome da página e adiciona automaticamente
    $fileCSS = $router->getPage() . '.css';
    if(file_exists($cms->GetFrontStyleSheetPath() . $fileCSS)){
      $this->addFileStylesheet($fileCSS);
    }

    //verifica se existe JS com o nome da página e adiciona automaticamente
    $fileJS = $router->getPage() . '.js';
    if(file_exists($cms->GetFrontJavaScriptPath() . $fileJS)){
      $this->addFileJavascript($fileJS);
    }    
  }
  
  public function PrintPage($useTemplate = true){
    global $router, $FRONT_PAGES_PATH, $cms, $page, $site, $db, $params; //Globals usados nas páginas
    
    $fileHtml = $this->pageName . '.html.php';
    
    //verifica se tem que carregar o template...
    if($useTemplate)
      include($cms->GetThemePath() . 'template.php');
    else 
    include($FRONT_PAGES_PATH . $fileHtml);
  }
  
  public function addFileStylesheet($file){
        $this->a_css[] = $file;
  }
  
  public function addFileJavascript($file){
        $this->a_js[] = $file;
  }


  public function addFileImageSrc($url){
    $this->a_image_src[] = $url;
  }
  
  private function printJS(){
    global $cms;

    foreach ($this->a_js as $js) {
      echo('<script defer src="' . $cms->GetFrontJavaScriptUrl() . $js . '"></script>' . "\r\n");
    }
  }
  
  private function printCSS(){
    global $cms;
    
    foreach ($this->a_css as $css) {
      echo('<link rel="stylesheet" type="text/css" href="' . $cms->GetFrontStyleSheetUrl() . $css . '"/>' . "\r\n");
    }
  }
  
  private function printImageSrc(){
    global $cms;
    
    foreach ($this->a_image_src as $image_src) {

      $size = getimagesize($image_src);

      $html  = '<meta property="og:image" content="' . $image_src . '">' . "\r\n";
      $html .= '<meta property="og:image:type" content="' . $size['mime'] . '">' . "\r\n";
      $html .= '<meta property="og:image:width" content="' . $size[0] . '">' . "\r\n";
      $html .= '<meta property="og:image:height" content="' . $size[1] . '">' . "\r\n";
      $html .= "\r\n";

      echo($html);
    }    
  }
  
  public function printHeader(){
    global $cms, $events;

  echo('<!-- Meta Tags -->'. "\r\n");
  echo('<meta name="author" content="Nova Brazil Agência Interativa">'. "\r\n");
  echo('<meta name="description" content="' . $this->description . '">'. "\r\n");
  echo('<meta name="keywords" content="' . $this->keywords . '">'. "\r\n");
  echo('<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">'. "\r\n");
  echo('<meta name="CMS" content="Girafa CMS ' . $cms->GetVersion() . '">'. "\r\n");

  if(!$this->index)
    echo('<meta Name=”robots” content=”noindex,nofollow”>'. "\r\n");

  echo('<!-- Estilos Especiais desta Página -->'. "\r\n");
  $this->printCSS();
  echo('<!-- Scripts Especiais desta Página -->'. "\r\n");
  $this->printJS();
  echo('<!-- Imagens para Facebook e outros Shared -->'. "\r\n");
  $this->printImageSrc();

  //Dispara evento 'front_head_include'
  $evs = $events->getEventsArray('front_head_include');
  $returns = null;
  foreach ($evs as $e) {

  	$returns .= $e();
  	$returns .= "\n\r";
  }
  
  if(!empty($returns)){
    echo('<!-- Impresso por Eventos -->' . "\r\n");
    echo($returns);  
  }
    echo('<!-- -->');
  }
}
?>