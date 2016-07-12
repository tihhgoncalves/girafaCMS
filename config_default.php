<?

$GLOBALS["ROOT_PATH"] =   "/dados/http/ochefia.com/www/";
$GLOBALS["ROOT_URL"] =    "http://www.ochefia.com/";
$GLOBALS["ADMIN_URL"] =   $ROOT_URL . "cms/admin/";

$GLOBALS["LANG"]                   = "pt-br";
$GLOBALS["SITEKEY"]                = "LS6kXs0t";

$GLOBALS["LINK_PREFIX"]            = ""; //index.php?url=


/** Configurações de Administração **/
$GLOBALS["MODULES_PATH"]           = $ROOT_PATH . "cms/modules/";
$GLOBALS["MODULES_URL"]            = $ROOT_URL  . "cms/modules/";
$GLOBALS["PLUGINS_PATH"]           = $ROOT_PATH . "cms/plugins/";
$GLOBALS["PLUGINS_URL"]            = $ROOT_URL  . "cms/plugins/";
$GLOBALS["OBJECTS_PATH"]           = $ROOT_PATH . "cms/objects/";
$GLOBALS["FUNCTIONS_PATH"]         = $ROOT_PATH . "cms/functions/";
$GLOBALS["TEMP_PATH"]              = $ROOT_PATH . "cms/temp/";


$GLOBALS["CACHE_PATH"]             = $ROOT_PATH . "cms/cache/";
$GLOBALS["CACHE_URL"]              = $ROOT_URL . "cms/cache/";
$GLOBALS["COOKIE_EXPIRE"]          = mktime(0, 0, 0,date("m"), date("d") + 7, date("Y")); //1 semana


/** Configurações de Roteador (de links) **/
$GLOBALS["ROUTER_LINKMASK"]        = "index.php?url=";


/** Arquivos de utilizados para compor o HTML do Front **/
$GLOBALS["FRONT_THEME_PATH"]       = $ROOT_PATH   . "site/theme/";
$GLOBALS["FRONT_THEME_URL"]        = $ROOT_URL    . "site/theme/";
$GLOBALS["FRONT_THEMEMOBILE_PATH"] = $ROOT_PATH   . "site/theme/";
$GLOBALS["FRONT_THEMEMOBILE_URL"]  = $ROOT_URL    . "site/theme/";
$GLOBALS["FRONT_PAGES_PATH"]       = $ROOT_PATH   . "site/pages/";
$GLOBALS["FRONT_PAGES_URL"]        = $ROOT_URL    . "site/pages/";
$GLOBALS["FRONT_SCRIPTS_PATH"]     = $ROOT_PATH   . "site/scripts/";
$GLOBALS["FRONT_SCRIPTS_URL"]      = $ROOT_URL    . "site/scripts/";


/** Arquivos de utilizados para compor o HTML do Admin **/
$GLOBALS["ADMIN_PATH"]             = $ROOT_PATH   . "cms/admin/";
$GLOBALS["ADMIN_PAGES_PATH"]       = $ADMIN_PATH  . "pages/";
$GLOBALS["ADMIN_PAGES_URL"]        = $ADMIN_URL   . "pages/";
$GLOBALS["ADMIN_STYLESHEET_PATH"]  = $ADMIN_PATH . "stylesheets/";
$GLOBALS["ADMIN_STYLESHEET_URL"]   = $ADMIN_URL   . "stylesheets/";
$GLOBALS["ADMIN_JAVASCRIPT_URL"]   = $ADMIN_URL   . "javascripts/";
$GLOBALS["ADMIN_JAVASCRIPT_PATH"]  = $ADMIN_PATH . "javascripts/";
$GLOBALS["ADMIN_IMAGES_PATH"]      = $ADMIN_PATH  . "images/";
$GLOBALS["ADMIN_IMAGES_URL"]       = $ADMIN_URL   . "images/";
$GLOBALS["ADMIN_FUNCTIONS_PATH"]   = $ADMIN_PATH  . "functions/";
$GLOBALS["ADMIN_UPLOAD_PATH"]      = $ROOT_PATH  . "site/uploads/";
$GLOBALS["ADMIN_UPLOAD_URL"]       = $ROOT_URL   . "site/uploads/";
$GLOBALS["ADMIN_LANGS_PATH"]      = $ROOT_PATH   . "site/langs/";


/** Configurações de Banco de dados **/
$GLOBALS["DB_TYPE"]                = "mysql";
if( $_SERVER['HTTP_HOST'] == 'localhost') {
    $GLOBALS["DB_HOST"] = "nbz.net.br";
} else {
    $GLOBALS["DB_HOST"] = "localhost";
}
$GLOBALS["DB_USER"]                = "root";
$GLOBALS["DB_PASS"]                = "nwtiago";
$GLOBALS["DB_PORT"]                = "";
$GLOBALS["DB_DATABASE"]            = "ochefia_com_pec";
$GLOBALS["DB_PERSISTENT"]          = true;


$GLOBALS["SITE_TITLE"]             = "O Chefia";
$GLOBALS["SITE_DESCRIPTION"]       = "Peça seu lanche pela internet sem sair de casa";
$GLOBALS["SITE_PAGEINDEX"]         = "home";

/** Configurações de e-mail **/
$email                             = array();
$email["FROMNAME"]                 = "O Chefia";
$email["FROM"]                     = "contato@zbraestudio.com.br";
$email["SENDTYPE"]                 = "smtp";
$email["CC"]                       = "";
$email["CCO"]                      = "";
$email["SMTPHOST"]                 = "smtp.gmail.com";
$email["SMTPUSER"]                 = "envia@novabrazil.art.br";
$email["SMTPPASS"]                 = "nbrazil123";
$email["SMTPSECURE"]               = "ssl";    //ssl tls (ou deixe em branco)
$email["SMTPPORT"]                 = "465";
$GLOBALS["EMAIL_CONFIG"]           = $email;



/** Configurações de idiomas **/
$idiomas                           = array();
$idiomas["activated"]              = array("pt-br");
$idiomas["default"]                = "pt-br";
$GLOBALS["LANGS_ADMIN"]            = $idiomas;

$idiomas                           = array();
$idiomas["activated"]              = array("pt-br");
$idiomas["default"]                = "pt-br";
$GLOBALS["LANGS_FRONT"]            = $idiomas;


?>
