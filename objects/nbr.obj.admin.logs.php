<?
class nbrLogs{
  
  public static function AddAction($action, $description){
    global $security;
    
    $ua = $_SERVER["HTTP_USER_AGENT"];


    //Detecta Browser...
    if(strpos($ua, 'Android')){
      $os = 'AND';
      
    } elseif (strpos($ua, 'BlackBerry')){
      $os = 'BKB';
      
    } elseif(strpos($ua, 'iPhone')){
      $os = 'IPH';
      
    } elseif(strpos($ua, 'Palm')){
      $os = 'PLM';
      
    } elseif(strpos($ua, 'Linux')){
      $os = 'LNX';
      
    } elseif(strpos($ua, 'Macintosh')){
      $os = 'MCT';
      
    } elseif(strpos($ua, 'Windows')){
      $os = 'WIN';
      
    } else {
      $os = '000';
      $browser = '000';
      $description .= "\r\n";
      $description .= "-----------------------";
      $description .= 'Sistema não identificado:' . $ua;
    }
    
    //Detecta Browser...
    if(strpos($ua, 'Chrome')){
      $browser = 'CHR';
      
    } elseif(strpos($ua, 'Firefox')){
      $browser = 'FFX';
      
    } elseif(strpos($ua, 'MSIE 6')){
      $browser = 'IE6';

    } elseif(strpos($ua, 'MSIE 7.0')){
      $browser = 'IE7';

    } elseif(strpos($ua, 'MSIE 8.0')){
      $browser = 'IE8';
      
    } elseif(preg_match("/\bOpera\b/i", $ua)){
      $browser = 'OPR';
      
    } elseif(strpos($ua, 'Safari')){
      $browser = 'SAF';
      
    } else {
      $browser = '000';
      $description .= "\r\n";
      $description .= "-----------------------";
      $description .= 'Browser não identificado:' . $ua;
      
    }
     
    $post = new nbrTablePost();
    $post->table = 'sysLogs';
    $post->AddFieldString('UserName',    $security->GetUserID() . ' - ' . $security->GetUserName());
    $post->AddFieldString('UserMail',    $security->GetUserMail());
    $post->AddFieldString('IP',          $_SERVER["REMOTE_ADDR"]);
    $post->AddFieldString('Browser',     $browser);
    $post->AddFieldString('OS',          $os);
    $post->AddFieldString('Action',      $action);
    $post->AddFieldString('Description', $description);
    $post->AddFieldDateTime('DateTime',  date('Y-m-d H:i:s'));
    $post->Execute();
  }
  
}
?>