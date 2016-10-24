<?

/**
 * Carrega CONFIG
 */

//config_default
require_once('config_default.php');

//config
require_once(dirname(__FILE__) . '/../../config.php');

$configs = array_merge($config_d, $config);

//joga config pra GLOBALS
foreach($configs as $k=>$c){


  //trata valores virtuais..
  if(!is_array($c)) {

    $re = "/\\{(.+)\\}/mi";
    preg_match_all($re, $c, $out);

    if (isset($out[1][0])) {
      $val = $$out[1][0];
      $c = str_replace($out[0][0], $val, $c);
    }
  }
  $GLOBALS[$k] = $c;
}

//carrega registro do config
function get_config($key){
  return $GLOBALS[$key];
}
?>