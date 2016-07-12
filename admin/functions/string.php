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
?>