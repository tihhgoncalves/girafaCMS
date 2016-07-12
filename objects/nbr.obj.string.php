<?
class nbrString
{
  
  /**
   * Função que repassa as iniciais das palavras para maiúscula
   * Ex: tiago GONÇALVES
   * Ficaria: Tiago Gonçalves
   *
   * @param string $text
   * @return string
   */
  public static function FirstShift($text)
  {
    $artigos = array('da', 'das', 'do', 'dos', 'e', 'na', 'no', 'de', 'para', 'as', 'os', 'ao');
    
    $text = ucwords($text);
    foreach ($artigos as $artigo)
    {
      $artigoMaiusc = ucfirst($artigo);
      $text = str_replace(' ' . $artigoMaiusc . ' ', ' ' . $artigo . ' ', $text);
    }
    
    $text = ucfirst($text);
    return  $text;

  }
  
  /**
   * Retira Acentos
   * Ex.: África -> Africa
   *
   * @param unknown_type $text
   * @return unknown
   */
  public static function RemoveAccents($text)
  {
    //Tira acentos
    $comAcento  = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ');
    $semAcento = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y');
    $text = str_replace($comAcento, $semAcento, $text);
    return $text;
  }
}
?>