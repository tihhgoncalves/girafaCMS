<?

//Carrega Template...

function loadTemplate(){
  global $FRONT_TEMPLATES_PATH, $page, $cms;

  include($FRONT_TEMPLATES_PATH . $page->templateFile) ;
}

function printPageStyleSheet(){
  global $page, $cms;
  
  $styles = str_replace(',', ';', $page->fileStyleSheet);
  $styles = explode(';', $styles);
  
  foreach ($styles as $styles) {
    $file = $cms->GetFrontStyleSheetUrl() . trim($styles);
    print('<link rel="stylesheet" type="text/css" href="' . $file . '" />' . "\r\n");
  }
    
}

function printPageJavaScript(){
  global $page, $cms;

  $scripts = str_replace(',', ';', $page->fileJavaScript);
  $scripts = explode(';', $scripts);
  
  foreach ($scripts as $script) {
    $file = $cms->GetFrontJavaScriptUrl() . trim($script);
    print('<script src="' . $file . '" type="text/javascript"></script>' . "\r\n");
  }
    
}

function printWidgets($placeHolders){
  global $db, $cms, $page, $hub, $site, $MODULES_URL, $MODULES_PATH, $router;

  $sql  = 'SELECT cmsPageContents.Parameters, cmsWidgets.File WidgetFile FROM cmsPageContents';
  $sql .= ' LEFT JOIN cmsPlaceHolders ON(cmsPlaceHolders.ID = cmsPageContents.PlaceHolder)';
  $sql .= ' LEFT JOIN cmsWidgets ON(cmsWidgets.ID = cmsPageContents.Widget)';
  $sql .= " WHERE Page = " . $page->id . " AND cmsPlaceHolders.Name = '$placeHolders'";
  $sql .= " ORDER BY `Order` ASC";

  $widgets = $db->LoadObjects($sql);

  foreach ($widgets as $widget) {

    $x = $widget->Parameters;
    $x = explode("\n", $x);

    $params = array();
    foreach ($x as $values) {
      $value = explode('=', $values);
    	$params[trim(utf8_encode($value[0]))] = trim(utf8_encode($value[1]));
    }

  	include($MODULES_PATH . $widget->WidgetFile);
  }
}



/**
 * Retorna Registro
 */
function LoadRecord($tableName, $value, $field = 'ID'){
  global $db;
  
  $sql = 'SELECT * FROM `' . $tableName . '` WHERE `' . $field . "` = '" . $value . "'";
  //echo($sql);
  $res = $db->LoadObjects($sql);
  
  return $res[0];
}

function is_localhost(){
  return ( $_SERVER['HTTP_HOST'] == 'localhost');
}

?>