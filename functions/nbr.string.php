<?

/**
 * Passa todos os caracteres para maiúsculo (corrigindo problema com acentos)
 *
 * @param string $text
 * @return string
 */
function nbrStrToUpper($text){
  $text = str_replace(explode(',', 'á,é,í,ó,ú,â,ê,ô,ã,õ,à,è,ì,ò,ù,ç'),explode(',', 'Á,É,Í,Ó,Ú,Â,Ê,Ô,Ã,Õ,À,È,Ì,Ò,Ù,Ç'), $text);
  $text = strtoupper($text);
  
  return $text;
}

function createKey($size  = 8, $uppercase  = true, $numbers = true, $symbols = false){
  
  $lmin = 'abcdefghijklmnopqrstuvwxyz';
  $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $num = '1234567890';
  $simb = '!@#$%*-';
  $retorno = '';
  $caracteres = '';
   
  $caracteres .= $lmin;
  if ($uppercase) $caracteres .= $lmai;
  if ($numbers)   $caracteres .= $num;
  if ($symbols)   $caracteres .= $simb;
   
  $len = strlen($caracteres);
  
  for ($n = 1; $n <= $size; $n++) {
    $rand = mt_rand(1, $len);
    $retorno .= $caracteres[$rand-1];
    }
    return $retorno;
}

/**
 * Limita o tamanho e um texto sem cortar uma palavra no meio
 *
 * @param string $string
 * @param inteer $length
 * @param string $replacer
 * @return string
 */
function textLimit($string, $length, $replacer = '...'){
  if(strlen($string) > $length)
  return (preg_match('/^(.*)\W.*$/', substr($string, 0, $length+1), $matches) ? $matches[1] : substr($string, 0, $length)) . $replacer;
  return $string;
}


function nbrEncode($string) {
  $data = base64_encode($string);
  $data = str_replace(array('+','/','='),array('-','_',''),$data);
  return $data;
}

function nbrDecode($string) {
  $data = str_replace(array('-','_'),array('+','/'),$string);
  $mod4 = strlen($data) % 4;
  if ($mod4) {
    $data .= substr('====', $mod4);
  }
  return base64_decode($data);
}


?>