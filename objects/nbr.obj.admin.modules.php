<?
class nbrModules{
  private $modules = array();
  
  function __construct(){
  }
  
  /**
   * Retorna array com todos os módulos (disponíveis para este usuário)
   *
   * @return array (de nbrModule)
   */
  public function GetModules(){
    
    return $this->Load();
  }
  
  /**
   * Retorna o primeiro módulo do sistema
   *
   * @return nbrModule
   */
  public static function GetFirstModule(){
    $modules = new nbrModules();
    $res = $modules->Load();
    return $res[0];
  }
  
  public function Load(){
    global $db, $security;
    
 
    
    //Grupos de Segurança...
    $sql  = 'SELECT `Group` FROM sis_usuarios_grupos';
    $sql .= ' WHERE `User` = ' . $security->GetUserID();

    $res = $db->LoadObjects($sql);
    
    $groups = array();
    foreach ($res as $reg) {
      $groups[] = $reg->Group;
    }
    
    //Módulos..
    $sql  = 'SELECT sis_modulos.* FROM sis_modulos_grupos';
    $sql .= ' JOIN sis_modulos ON(sis_modulos.ID = sis_modulos_grupos.Module)';
    $sql .= ' WHERE sis_modulos.Actived = \'Y\' AND sis_modulos_grupos.`Group` IN(' . implode(',', $groups) . ')';
    $sql .= ' GROUP BY sis_modulos_grupos.`Module`';
    $sql .= ' ORDER BY sis_modulos.Name ASC';

    $modules = $db->LoadObjects($sql);
    
    $a_modules = array();
    
    foreach ($modules as $module) {
      $a_modules[] = new nbrModule($module);
    }    
    return $a_modules;
  }
}

class nbrModule{
  public $ID;
  public $name;
  public $description;
  public $icon;
  public $path;
  public $url;
  public $file;
  public $folderID;
  public $folderName;
  public $MultiLanguages;

  function __construct($reg){
    global $MODULES_URL, $MODULES_PATH, $db, $hub, $ROOT_URL, $CMS_URL;
    
    //Seleciona a Primeira Pasta..
    $sql  = 'SELECT sis_pastas.*, sis_modulos.Path, sis_pastas.ID folderID, sis_pastas.Name folderName, sis_pastas.MultiLanguages MultiLanguages FROM sis_pastas';
    $sql .= " LEFT JOIN sis_modulos ON(sis_modulos.ID = sis_pastas.Module)";
    $sql .= " WHERE sis_pastas.Actived = 'Y' AND sis_pastas.Module = " . $reg->ID;
    $sql .= ' ORDER BY sis_pastas.`Order` ASC';
    $sql .= ' LIMIT 0,1';

    $pastas = $db->LoadObjects($sql);
    $pasta = $pastas[0];
    
    //Pega Link da Primeira paasta
    $link = $MODULES_PATH . $pasta->Path . '/' . $pasta->File;    
    
    //Carrega propriedades...
    $this->ID          			= $reg->ID;
    $this->name        			= $reg->Name;
    $this->description 			= $reg->Description;
    $this->folderPath  			= $reg->Path . '/';
    $this->file        			= $link;
    $this->path        			= $MODULES_PATH . $reg->Path . '/';
    $this->url         			= $MODULES_URL . $reg->Path . '/';
    $this->icon    			    = $reg->Icon;
    $this->folderID    			= $pasta->folderID;
    $this->folderName  			= $pasta->folderName;
    $this->MultiLanguages  	= $pasta->MultiLanguages;
  }

  /**
   * Retorna nbrModule do Módulo especificado
   *
   * @param integer $id
   * @return nbrModule
   */
  public static function LoadModule($id) {
    global $db;
    //Carrega módulos..
    
    $sql  = 'SELECT * FROM sis_modulos';
    $sql .= " WHERE ID=" . $id;
    $modules = $db->LoadObjects($sql);
    
    $module = new nbrModule($modules[0]);
    return $module;
  }
  
  public function CheckLanguage($languadeID){
    global $db;
    
    $sql  = 'SELECT COUNT(ID) TOTAL FROM sis_modulos_idiomas';
    $sql .= " WHERE Modulo =" . $this->ID . " AND Idioma =" . $languadeID;
    $res = $db->LoadObjects($sql);
    
    return ($res[0]->TOTAL > 0);
  }

  public function GetNotifications(){
    global $db;

    $sql = 'SELECT * FROM sis_pastas';
    $sql .= " WHERE Module = " . $this->ID . " AND CounterSQL IS NOT NULL AND Actived = 'Y'";
    $res = $db->LoadObjects($sql);

    $total = 0;

    foreach($res as $reg){

      $counterSQL = $reg->CounterSQL;
      $subtotal = $db->LoadObjects($counterSQL);
      $subtotal = $subtotal[0]->TOTAL;
      $total += $subtotal;
    }


    return  $total;
  }
}
?>