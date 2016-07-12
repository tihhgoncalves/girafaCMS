<?
class nbrCache{
  
  function ClearCache(){
    
    global $CACHE_PATH;
    
    $path = $CACHE_PATH;
    if ($dh = opendir($path)) {
      while (($file = readdir($dh)) !== false) {
        
        if($file != '.' && $file != '..' && $file != '.svn'){
          unlink($path . $file);
        }
      }
      closedir($dh);
    }    
  }
  
}
?>