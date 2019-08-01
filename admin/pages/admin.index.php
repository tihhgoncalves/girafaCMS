<?
//verifica de site tem dashboard personalizado...

$dash_template = get_config('ROOT_PATH') . 'site/admin/dashboard.php';

if(file_exists($dash_template)){
  include($dash_template);
} else {
  ?>
  <p>...</p>
  <?
}
  ?>