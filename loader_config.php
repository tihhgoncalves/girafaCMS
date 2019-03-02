<?

/**
 * Carrega CONFIG
 */
include(dirname(dirname(__FILE__)) . '/tihh.site.uri.php/load.php');
$uri = new tihh_URI();

function is_localhost(){
	return (in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1']));
}


//config_default
require_once('config_default.php');

//config
require_once(dirname(__FILE__) . '/../../config.php');

$configs = array_merge($config_d, $config);


//se nao for forçado, pegar URL padrão
if(empty($configs['ROOT_URL'])){
  $configs['ROOT_URL'] = $uri->base();
}

//se nao for forçado, pegar PATH padrão
if(empty($configs['ROOT_PATH'])){
  $configs['ROOT_PATH'] = dirname(dirname(__DIR__)) . '/';
}

//joga config pra GLOBALS
foreach($configs as $k=>$c){


  //trata valores virtuais..
  if(!is_array($c)) {

    $re = "/\\{(.+)\\}/mi";
    preg_match_all($re, $c, $out);

    if (isset($out[1][0])) {
      $val = $out[1][0];
      $val = $$val;
      $c = str_replace($out[0][0], $val, $c);
    }
  }
  $GLOBALS[$k] = $c;
}

//carrega registro do config
function get_config($key){
  return $GLOBALS[$key];
}

//carrega registro do config
function get_link($link){

  $langs = get_config('LANGS_ADMIN');
  return get_config('ROOT_URL') . get_config('LINK_PREFIX') . $langs['default'] . '/' .$link;
}
?>