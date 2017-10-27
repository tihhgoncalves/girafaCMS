<?

include(get_config('BOWER_COMPONENTS_PATH') . 'PHPMailer/src/Exception.php');
include(get_config('BOWER_COMPONENTS_PATH') . 'PHPMailer/src/PHPMailer.php');
include(get_config('BOWER_COMPONENTS_PATH') . 'PHPMailer/src/SMTP.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class nbrMail
{
  private $phpMailerObj;
  public $_fromName = null;
  public $_fromMail = null;
  
  public $_SMTPHost = null;
  public $_SMTPUser = null;
  public $_SMTPPass = null;
  public $_SMTPPort = null;
  public $_SMTPSecure = null;
  public $_sendType = null;
  public $ErrorInfo;
  
  function __construct()
  {
    global $EMAIL_CONFIG;

    //Carrega Objeto...
    $this->phpMailerObj = new PHPMailer(); 
    $this->phpMailerObj->SetLanguage('br');
    
    //Carrega Parâmetros de Config..
    $this->_fromName   = $EMAIL_CONFIG['FROMNAME'];
    $this->_fromMail   = $EMAIL_CONFIG['FROM'];
    $this->_SMTPHost   = $EMAIL_CONFIG['SMTPHOST'];
    $this->_SMTPUser   = $EMAIL_CONFIG['SMTPUSER'];
    $this->_SMTPPass   = $EMAIL_CONFIG['SMTPPASS'];     
    $this->_SMTPSecure = $EMAIL_CONFIG['SMTPSECURE'];     
    $this->_SMTPPort   = $EMAIL_CONFIG['SMTPPORT'];     
    $this->_sendType   = $EMAIL_CONFIG['SENDTYPE'];  

    if($this->_sendType == 'smtp'){
      $this->phpMailerObj->IsSMTP();
      $this->phpMailerObj->SMTPDebug    = false; // ativa informações de depuração do SMTP (para teste) // 1 = erros e mensagens // 2 = somente mensagens    
      $this->phpMailerObj->SMTPAuth     = true;
      $this->phpMailerObj->Host         = $this->_SMTPHost;      
      $this->phpMailerObj->Username     = $this->_SMTPUser;
      $this->phpMailerObj->Password     = $this->_SMTPPass;
      $this->phpMailerObj->SMTPSecure   = $this->_SMTPSecure;
      $this->phpMailerObj->Port         = $this->_SMTPPort;      
    
    } elseif($this->_sendType == 'mail') {
      $this->phpMailerObj->IsMail();
    }
    
   
  }
  
  public function Send($html, $assunto, $para, $fromMail = null, $fromName = null, $cc = null, $cco = null, $replyToMail = null)
  {
    
    $this->phpMailerObj->CharSet	=	'UTF-8';

    $this->phpMailerObj->IsHTML(true); 
    
    $this->phpMailerObj->SetFrom((($fromMail != null)?$fromMail : $this->_fromMail), (($fromName != null)?$fromName : $this->_fromName));
    
    $para = str_replace(',',';', $para);
    $para = explode(';', $para);

    //Envie um a um os e-mails
    foreach ($para as $um) {
    	$this->phpMailerObj->AddAddress($um);
    }

   
    if(!empty($cc)){      
      
      $cc = explode(';', $cc);
      
      foreach ($cc as $x)
        $this->phpMailerObj->AddCC($x);
    }      
    
    if(!empty($cco)){      
      
      $cco = explode(';', $cco);
      
      foreach ($cco as $x)
        $this->phpMailerObj->AddBCC($x);
    }
    
    if(!empty($replyToMail))
      $this->phpMailerObj->AddReplyTo($replyToMail);
    
    $this->phpMailerObj->Subject = $assunto;
    $this->phpMailerObj->Body = $html;

    $this->ErrorInfo = $this->phpMailerObj->ErrorInfo;
    
    return $this->phpMailerObj->Send();
  }
  
  /**
   * Anexa arquivo ao e-mail
   *
   * @param string $path
   * @param string $name
   */
  public function AddAttachment($path, $name)
  {
    $this->phpMailerObj->AddAttachment($path, $name);
  }
  
  /**
   * Anexa uma imagem a mensagem, que poderá ser utilizada no corpo do e-mail
   *
   * @param string $path
   * @param string $cid
   * @param string $name
   */
  public function AddEmbeddedImage($path, $cid, $name)
  {
    $this->phpMailerObj->AddEmbeddedImage($path, $cid, $name);
  }  
  
  public function SendTemplate($html, $assunto, $para, $fromMail = null, $fromName = null, $cc = null, $cco = null, $replyToMail = null)
  {
    global $cms;
    
    $tmp  = '<html>' . "\n";
    $tmp .= '<head>' . "\n";
    $tmp .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
    $tmp .= '<style type="text/css">' . "\n";
    $tmp .= '<!--' . "\n";
    $tmp .= 'body ' . "\n";
    $tmp .= '{' . "\n";
    $tmp .= '	font-family: Tahoma;' . "\n";
    $tmp .= '	font-size: 12px;' . "\n";
    $tmp .= '}' . "\n";
    $tmp .= 'h1' . "\n";
    $tmp .= '{' . "\n";
    $tmp .= '	font-size: 13px;' . "\n";
    $tmp .= '}' . "\n";
    $tmp .= '-->' . "\n";
    $tmp .= '</style>' . "\n";
    $tmp .= '</head>' . "\n";
    
    $tmp .= '<body>' . "\n";
    $tmp .= '<img src="cid:cabecalho">' . "\n";
    $tmp .= $html;
    $tmp .= '<img src="cid:meioambiente">' . "\n";
    $tmp .= '<p>Você está recebendo este e-mail do <strong>Sistema Automático de Envio de E-mail.</strong>.' . "\n";
    $tmp .= '</p>' . "\n";
    $tmp .= '<p>Esta mensagem foi enviada em ' . date('d/m/Y') . ' às ' . date('H:i:s') . 'hrs.<br />' . "\n";
    $tmp .= 'Foi enviado por uma pessoa com IP: ' . $_SERVER['REMOTE_ADDR'] . '.</p>' . "\n";
    $tmp .= '</body>' . "\n";
    $tmp .= '</html>' . "\n";
    
    $mail = new nbrMail();
    $mail->AddEmbeddedImage($cms->GetAdminImagePath()  . 'email_cabecalho.gif', 'cabecalho', 'Cabeçalho');
    $mail->AddEmbeddedImage($cms->GetAdminImagePath()  . 'meioembiente.gif', 'meioambiente', 'Meio Ambiente');    

    if($mail->Send($tmp, $assunto, $para, $fromMail, $fromName, $cc, $cco, $replyToMail))
      return true;
    else{
      $this->ErrorInfo = $mail->ErrorInfo;
      return false;
    }
  }

}
?>