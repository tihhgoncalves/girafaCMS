<?

class nbrLinkThumb{
  private $link;
  private $html;
  private $img;
  private $title;
  private $description;
  
  function __construct($link){
    $link = strip_tags($link);
    
    $this->link = $link;
    
    //Carrega HTML...
    $this->html = file_get_contents($link);
    $html = $this->html;
    
    //Pega titulo da pagina
    if (preg_match('%<title>([^"]+)</title>%', $html, $regs)) {
    	$title = $regs[1];
    	
    	$caracteres = 60;
    	if(strlen($title) > $caracteres)
    	  $title = substr($title, 0, $caracteres) . '...';
    	
    	$this->title = $title;
    } else {
    	$this->title = '';
    }
    
    //Pega descrição da página...
    if (preg_match('/<meta(?=[^>]*?name="description")[^>]*?content="([^"]+)"/', $html, $regs)) {
    	$description = $regs[1];
    	
    	$caracteres = 150;
    	if(strlen($description) > $caracteres)
    	  $title = substr($description, 0, $caracteres) . '...';
    	
    	$this->description = $description;
    } else {
    	$this->description = '';
    }
    

    
    //Verifica se tem imagem no metatags
    if (preg_match('/<link(?=[^>]*?rel="image_src")[^>]*?href="([^"]+)"/', $html, $regs)) {
    	$result = $regs[1];
    } else {
    	$result = "";
    }

    if(!empty($result)){
      $this->img = $result;
    }
  }
  
  public function GetHtml(){
    
    global $cms;
    
    
    //Monta box...
    $link = $this->link;
    $link = str_replace('http://', '', $link);
    $link = str_replace('https://', '', $link);
    
    $html  = '<div class="linkThumb">';
    $html .= '<a href="' . $this->link . '" target="_blank">';

    if(!empty($this->img)){
      $img = new nbrImages($this->img);
      $html .= '<img src="' . $img->GeraThumb(100, 100) . '" width="100" height="100">';
    }    
    
    
    $html .= '<span class="titulo">' . $this->title . '</span>';
    $html .= '<span class="descricao">' . $this->description . '</span>';
    $html .= '<span class="link">' . $link . '</span>';

    $html .= '</a>';
    $html .= '</div>';
    
    return $html;
    
  }
  
}
?>