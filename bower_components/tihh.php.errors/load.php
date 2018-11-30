<?
/*
 * Manipula erros do PHP
 *
 * v1.0.1
 *
 */
function tihh_errorHandler( $errno, $errstr, $errfile, $errline, $errcontext){

  if($errno != 8) { //ignora 8 = NOTICES

    $hidden = 'errno: ' . $errno . "\r\n";
    $hidden .= 'errstr: ' . $errstr . "\r\n";
    $hidden .= 'errfile: ' . $errfile . "\r\n";
    $hidden .= 'errline: ' . $errline . "\r\n";
    $hidden .= 'errcontext: ' . print_r($errcontext, true) . "\r\n";

    tihh_erros($errstr, $hidden);

  }
}
set_error_handler('tihh_errorHandler');

function tihh_exception_handler($e) {
  echo tihh_erros($e->getMessage());
}
set_exception_handler('tihh_exception_handler');


function tihh_erros($msg, $hidden = null){
  $html  = '<p class="tihh_errors" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif;font-size: 14px;">';
  $html .= '<strong>Ocorreu um erro ao tentar acessar o site.</strong>';
  $html .= '<br>';
  $html .= '<span style="color: #999;">';
  $html .= $msg;
  $html .= '<span>';
  $html .= '</p>';

  if(!empty($hidden)){
    $html .= "\r\n";
    $html .= '<!-- ';
    $html .= "\r\n";
    $html .= $hidden;
    $html .= "\r\n";
    $html .= '-->';
    $html .= "\r\n";
  }
  die($html);
}
?>
