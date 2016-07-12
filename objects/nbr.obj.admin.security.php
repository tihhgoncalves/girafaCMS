<?

class nbrAdminSecurity{
  
  private function _getKeySession(){
    global $SITEKEY;
    
    return base64_encode($SITEKEY . 'admin');
  }
  
  public function checkLogin(){
    return (isset($_SESSION[$this->_getKeySession()]['ID']));
  }

  /**
   * Verifica permissões do usuário logado
   * @return boolean;
   */
  public function SecurityCheck() {
    global $moduleObj, $db, $hub, $ADMIN_PAGES_PATH;
    
    //Verifica sessão...
    if(!isset($_SESSION[$this->_getKeySession()]['ID'])){
      
      //Faz Logout..
      $this->Logout();

      //Encaminha pro Login com Mensagem de erro.
      $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'login.pg.php');
      $hub->SetParam('mail', $mail);
      $hub->SetParam('msg', 'Você não está logado ou a sessão expirou.');
      $link = $hub->GetUrl();
      header('location:' . $link);      
      exit;
    }
    
    //Verifica se Usuário está Ativo..
    $sql = 'SELECT ID FROM sysAdminUsers WHERE ID = ' . $this->GetUserID() . ' AND Actived = "Y"';
    $res = $db->LoadObjects($sql);

    if(count($res) == 0){
      //Faz Logout..
      $this->Logout();
  
      //Encaminha pro Login com Mensagem de erro.
      $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'login.pg.php');
      $hub->SetParam('mail', $mail);
      $hub->SetParam('msg', 'Seu Usuário ficou inativo.');
      $link = $hub->GetUrl();
      header('location:' . $link);      
      exit;
    }    

    //Verifica se tem permissão pra módulo
    if($hub->ExistParam('_moduleID')){
      $sql  = 'SELECT sysAdminUsersGroups.ID FROM sysAdminUsersGroups';
      $sql .= ' LEFT JOIN sysModuleSecurityGroups ON(sysModuleSecurityGroups.`Group` = sysAdminUsersGroups.`Group`)';
      $sql .= ' WHERE sysAdminUsersGroups.`User` = ' . $this->GetUserID() . ' AND sysModuleSecurityGroups.Module = ' . $moduleObj->ID;
      $res = $db->LoadObjects($sql);
      
      if(count($res) == 0)
        die('Seu usuário ou o(s) Grupo(s) de Segurança a qual ele pertence não têm permissão de acessar este Módulo e suas Pastas.');
    }
  }
  
  /**
   * Efetua login no Administrador e retorna se login foi feito com êxito;
   *
   * @param string $user
   * @param string $pass
   * @return boolean
   */
  public function Login($user, $pass) {
    global $db;
    
    //Proteje de SQL inject
    $user = addslashes($user);
    $pass = md5(addslashes($pass));
    
    $sql = 'SELECT * FROM sysAdminUsers';
    $sql .= " WHERE (`Mail` = '$user' AND `Password` = '$pass')";
    $res = $db->LoadObjects($sql);
    
    if(count($res) > 0){
      
      if($res[0]->Actived != 'Y')
        return 'O usuário está inativo no momento.';
      
      //Grava informações na Sessão..
      $_SESSION[$this->_getKeySession()]['ID']   =      $res[0]->ID;
      $_SESSION[$this->_getKeySession()]['name'] =      $res[0]->Name;
      $_SESSION[$this->_getKeySession()]['mail'] =      $res[0]->Mail;
      $_SESSION[$this->_getKeySession()]['developer'] = $res[0]->Developer;

      //Atualiza data do Último Login..
      $sql = 'UPDATE sysAdminUsers SET LastAccess = NOW() WHERE ID = ' . $res[0]->ID;
      $db->Execute($sql);
      
      //Registra o Log..
      nbrLogs::AddAction('LOG', 'Usuário fez login no CMS');
      
      return true;
    }else 
      return 'O usuário ou senha estão incorretos.';
  }
  
  /**
   * Faz logout do Admin (destroi a sessão)
   *
   */
  public function Logout(){
    unset($_SESSION[$this->_getKeySession()]);
    session_destroy();
  }
  
  /**
   * Retorna ID do Usuário Logado
   *
   * @return integer
   */
  public function GetUserID(){
    return $_SESSION[$this->_getKeySession()]['ID'];
  }
  
  /**
   * Retorna Nome do Usuário Logado
   *
   * @return string
   */
  public function GetUserName(){
    
    if(isset($_SESSION[$this->_getKeySession()]['name']))
      return $_SESSION[$this->_getKeySession()]['name'];
    else 
      return 'Anônimo';
  }
  
  /**
   * Retorna E-mail do Usuário Logado
   *
   * @return string
   */
  public function GetUserMail(){
    
    if(isset($_SESSION[$this->_getKeySession()]['mail']))
      return $_SESSION[$this->_getKeySession()]['mail'];
    else 
      return 'usuario@anonimo.com';
  }
  
  /**
   * Retorna se o Usuário pertence a equipe de Desenvolvimento ou não
   *
   * @return boolean
   */
  public function GetDeveloper(){
    return ($_SESSION[$this->_getKeySession()]['developer'] == 'Y');
  }
}
?>