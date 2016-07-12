<?
class nbrSite{

  public $title;
  public $description;
  public $pageIndex;
  
  function __construct(){
    global $db, $SITE_TITLE, $SITE_DESCRIPTION, $SITE_PAGEINDEX;
    
    //Carrega Propriedades...
    $this->title          = $SITE_TITLE;
    $this->description    = $SITE_DESCRIPTION;
    $this->pageIndex      = $SITE_PAGEINDEX;
  }
}
?>