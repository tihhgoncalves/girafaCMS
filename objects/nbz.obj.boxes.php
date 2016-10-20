<?
class nbrBoxes{

  public function load($box, $params = array()){
    global $BOX_PATH;

    $arquivo = 'box.' . $box . '.php';
    $arquivofull = $BOX_PATH . $arquivo;
    if(!file_exists($arquivofull))
      echo("[Não foi encontrado o arquivo $arquivo]");
    else {
      include($arquivofull);
    }
  }

}
?>