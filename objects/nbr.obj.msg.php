<?
class nbrMSG{
  private $title;
  private $message;
  
  public function SetMessage($message, $title = 'Mensagem'){
    $this->title   = $title;
    $this->message = $message;  
  }
  
  public function RedirectPage(){
    global $router;
    
    $msg_str = $this->title . '||' . $this->message;
    $msg_str = base64_encode($msg_str);
    
    header('location:' . $router->GetLink('msg/' . $msg_str));
  }
}
?>