<?
/**
 * Objeto que controla o CMS.
 * @version 1.0.0
 *
 */
class nbrCMS
{
  
  private $_lang;
  private $themePath;
  private $themeURL;    
  public $isMobile = false;
  private $version = '4.0.2';

  
  function __construct($lang = 'pt-br'){
    global $FRONT_THEME_PATH, $FRONT_THEME_URL;

    $this->themePath = $FRONT_THEME_PATH;
    $this->themeURL  = $FRONT_THEME_URL;
   
    $this->_lang = $lang;
  }
  
  /**
   * Retorna URL (root) do site
   *
   * @return string
   */
  public function GetRootUrl(){
    global $ROOT_URL;
    
    //Verifica se variável está correta...
    if(empty($ROOT_URL))
      throw new Exception('nbrCMS:: Variável $ROOT_URL do arquivo de configuração não pode ser branco ou nulo.');
      
    return $ROOT_URL;
  }
  
  /**
   * Retorna caminho físico (root) do site
   *
   * @return string
   */
  public function GetRootPath(){
    global $ROOT_PATH;
    
    //Verifica se variável está correta...
    if(empty($ROOT_PATH))
      throw new Exception('nbrCMS:: Variável $ROOT_PATH do arquivo de configuração não pode ser branco ou nulo.');
      
    return $ROOT_PATH;
  }
  
  /**
   * Retorna caminho físico do diretório de Tema
   *
   * @return string
   */
  public function GetThemePath(){
    return $this->themePath;
  }
  
  /**
   * Retorna URL do diretório de Tema
   *
   * @return string
   */
  public function GetThemeUrl(){
    return $this->themeURL;
  }
  
  /**
   * Retorna URL dos StyleSheets (arquivos de css) do Front
   *
   * @return string
   */
  public function GetFrontStyleSheetUrl(){
    return $this->themeURL . 'css/';
  }
  
  /**
   * Retorna URL dos Scripts de JavaScript do Front
   *
   * @return string
   */
  public function GetFrontJavaScriptUrl(){
    return $this->themeURL . 'js/';
  }

  /**
   * Retorna Caminho físico dos StyleSheets (arquivos de css) do Front
   *
   * @return string
   */
  public function GetFrontStyleSheetPath(){
    return $this->themePath . 'css/';
  }
  
  /**
   * Retorna Caminho físico dos Scripts de JavaScript do Front
   *
   * @return string
   */
  public function GetFrontJavaScriptPath(){
    return $this->themePath . 'js/';
  }  
  
  /**
   * Retorna URL do diretório de Imagens do Front
   *
   * @return string
   */
  public function GetFrontImageUrl(){
    return $this->themeURL . 'images/';
  }

  /**
   * Retorna Caminho físico de Imagens do Front
   *
   * @return string
   */
  public function GetFrontImagePath(){
    return $this->themePath . 'images/';
  }
  
  /**
   * Retorna URL dos StyleSheets (arquivos de css) do Admin
   *
   * @return string
   */
  public function GetAdminStyleSheetUrl(){
    global $ADMIN_STYLESHEET_URL;
    
    //Verifica se variável está correta...
    if(empty($ADMIN_STYLESHEET_URL))
      throw new Exception('nbrCMS:: Variável $ADMIN_STYLESHEET_URL do arquivo de configuração não pode ser branco ou nulo.');
      
    return $ADMIN_STYLESHEET_URL;
  }
  
  /**
   * Retorna URL dos Scripts de JavaScript do Admin
   *
   * @return string
   */
  public function GetAdminJavaScriptUrl(){
    global $ADMIN_JAVASCRIPT_URL;
    
    //Verifica se variável está correta...
    if(empty($ADMIN_JAVASCRIPT_URL))
      throw new Exception('nbrCMS:: Variável $ADMIN_JAVASCRIPT_URL do arquivo de configuração não pode ser branco ou nulo.');
      
    return $ADMIN_JAVASCRIPT_URL;
  }  
  
  /**
   * Retorna URL do diretório de Imagens do Admin
   *
   * @return string
   */
  public function GetAdminImageUrl(){
    global $ADMIN_IMAGES_URL;
    
    //Verifica se variável está correta...
    if(empty($ADMIN_IMAGES_URL))
      throw new Exception('nbrCMS:: Variável $ADMIN_IMAGES_URL do arquivo de configuração não pode ser branco ou nulo.');
      
    return $ADMIN_IMAGES_URL;
  }
  
  /**
   * Retorna caminho físico do diretório onde contém os arquivos de imagem do Admin
   *
   * @return string
   */
  public function GetAdminImagePath(){
    global $ADMIN_IMAGES_PATH;
    
    //Verifica se variável está correta...
    if(empty($ADMIN_IMAGES_PATH))
      throw new Exception('nbrCMS:: Variável $ADMIN_IMAGES_PATH do arquivo de configuração não pode ser branco ou nulo.');
      
    return $ADMIN_IMAGES_PATH;
  }
  
  /**
   * Retorna URL do diretório onde contém os arquivos de upload do CMS.
   *
   * @return string
   */  
  public function GetImageUploadUrl(){
    global $ADMIN_UPLOAD_URL;
    
    return $ADMIN_UPLOAD_URL;
  }

  /**
   * Retorna caminho físico do diretório onde contém os arquivos de upload do CMS.
   *
   * @return string
   */    
  public function GetImageUploadPath(){
    global $ADMIN_UPLOAD_PATH;
    
    return $ADMIN_UPLOAD_PATH;
  }
  
  
  /**
   * Retorna URL do diretório onde contém os arquivos de upload do CMS.
   *
   * @return string
   */  
  public function GetFileUploadUrl(){
    global $ADMIN_UPLOAD_URL;
    
    return $ADMIN_UPLOAD_URL;
  }

  /**
   * Retorna caminho físico do diretório onde contém os arquivos de upload do CMS.
   *
   * @return string
   */    
  public function GetFileUploadPath(){
    global $ADMIN_UPLOAD_PATH;
    
    return $ADMIN_UPLOAD_PATH;
  }  
  
  /**
   * Retorna caminho (físico) do Diretório Temporário
   *
   * @return string
   */
  public function GetTempPath(){
    global $TEMP_PATH;
    
    return $TEMP_PATH;
  }

  /**
   * Retorna caminho (físico) do Diretório bkps
   *
   * @return string
   */
  public function GetBkpsPath(){
    global $BKPS_PATH;

    return $BKPS_PATH;
  }
  /**
   * Retorna caminho (virtual) do Diretório bkps
   *
   * @return string
   */
  public function GetBkpsURL(){
    global $BKPS_URL;

    return $BKPS_URL;
  }
  
  /**
   * Retorna Idioma (atual) do Site
   *
   * @return string
   */
  public function GetLanguage(){
    return $this->_lang;
  }
  
  /**
   * Retorna versão do CMS
   *
   * @return string
   */
  public function GetVersion(){
    return $this->version;
  }
  
    
}
?>