<?
$config_d["ROOT_PATH"]               = "/root/site/";
$config_d["ROOT_URL"]                = "http://localhost/site";

$config_d["ADMIN_URL"]               = "{ROOT_URL}admin/"; // equivalente a {ROOT_URL}bower_components/girafaCMS/admin/ - manipulado no .htaccess
$config_d["ADMIN_THEME_URL"]         = "{ROOT_URL}bower_components/girafaCMS/admin/";
$config_d["ADMIN_PATH"]              = "{ROOT_PATH}bower_components/girafaCMS/admin/";

$config_d["CMS_PATH"]                = "{ROOT_PATH}bower_components/girafaCMS/";
$config_d["CMS_URL"]                 = "{ROOT_URL}bower_components/girafaCMS/";

$config_d["LANG"]                    = "pt-br";
$config_d["SITEKEY"]                 = "13246789";

$config_d["LINK_PREFIX"]             = ""; //index.php?url=

/** Configurações de Administração **/
$config_d["MODULES_PATH"]            = "{CMS_PATH}modules/";
$config_d["MODULES_URL"]             = "{ROOT_URL}modules/";
$config_d["PLUGINS_PATH"]            = "{CMS_PATH}plugins/";
$config_d["PLUGINS_URL"]             = "{ROOT_URL}plugins/";
$config_d["OBJECTS_PATH"]            = "{CMS_PATH}objects/";
$config_d["FUNCTIONS_PATH"]          = "{CMS_PATH}functions/";

$config_d["TEMP_PATH"]               = "{ROOT_PATH}temp/";
$config_d["TEMP_URL"]                = "{ROOT_URL}temp/";

$config_d["CACHE_PATH"]              = "{TEMP_PATH}cache/";
$config_d["CACHE_URL"]               = "{TEMP_URL}cache/";
$config_d["COOKIE_EXPIRE"]           = mktime(0, 0, 0,date("m"), date("d") + 7, date("Y")); //1 semana

/** Configurações de Roteador (de links) **/
$config_d["ROUTER_LINKMASK"]         = "";//index.php?hub=

/** Arquivos de utilizados para compor o HTML do Front **/
$config_d["FRONT_THEME_PATH"]        = "{ROOT_PATH}site/theme/";
$config_d["FRONT_THEME_URL"]         = "{ROOT_URL}site/theme/";
$config_d["FRONT_PAGES_PATH"]        = "{ROOT_PATH}site/pages/";
$config_d["FRONT_PAGES_URL"]         = "{ROOT_URL}site/pages/";
$config_d["FRONT_SCRIPTS_PATH"]      = "{ROOT_PATH}site/scripts/";
$config_d["FRONT_SCRIPTS_URL"]       = "{ROOT_URL}site/scripts/";

/** Arquivos de utilizados para compor o HTML do Admin **/
$config_d["ADMIN_PAGES_PATH"]        = "{ADMIN_PATH}pages/";
$config_d["ADMIN_PAGES_URL"]         = "{ADMIN_URL}pages/";
$config_d["ADMIN_FLAGS_PATH"]        = "{ADMIN_PATH}flags/";
$config_d["ADMIN_FLAGS_URL"]         = "{ADMIN_THEME_URL}flags/";
$config_d["ADMIN_STYLESHEET_PATH"]   = "{ADMIN_PATH]stylesheets/";
$config_d["ADMIN_STYLESHEET_URL"]    = "{ADMIN_THEME_URL}stylesheets/";
$config_d["ADMIN_JAVASCRIPT_URL"]    = "{ADMIN_THEME_URL}javascripts/";
$config_d["ADMIN_JAVASCRIPT_PATH"]   = "{ADMIN_PATH}javascripts/";
$config_d["ADMIN_IMAGES_PATH"]       = "{ADMIN_PATH}images/";
$config_d["ADMIN_IMAGES_URL"]        = "{ADMIN_THEME_URL}images/";
$config_d["ADMIN_FUNCTIONS_PATH"]    = "{ADMIN_PATH}functions/";
$config_d["ADMIN_UPLOAD_PATH"]       = "{ROOT_PATH}site/uploads/";
$config_d["ADMIN_UPLOAD_URL"]        = "{ROOT_URL}site/uploads/";
$config_d["ADMIN_LANGS_PATH"]        = "{ROOT_PATH}site/langs/";

/** Configurações de Banco de dados **/
$config_d["DB_TYPE"]                 = "mysql";
$config_d["DB_HOST"]                 = "localhost";
$config_d["DB_USER"]                 = "root";
$config_d["DB_PASS"]                 = "123";
$config_d["DB_PORT"]                 = "";
$config_d["DB_DATABASE"]             = "db_name";
$config_d["DB_PERSISTENT"]           = true;

$config_d["SITE_TITLE"]              = "Seu Site";
$config_d["SITE_DESCRIPTION"]        = "Descrição do Seu Site";
$config_d["SITE_PAGEINDEX"]          = "home";

/** Configurações de e-mail **/
$email                              = array();
$email["FROMNAME"]                  = "Seu Site";
$email["FROM"]                      = "contato@dominio.com.br";
$email["SENDTYPE"]                  = "mail";
$email["CC"]                        = "";
$email["CCO"]                       = "";
$email["SMTPHOST"]                  = "";
$email["SMTPUSER"]                  = "";
$email["SMTPPASS"]                  = "";
$email["SMTPSECURE"]                = "";    //ssl tls (ou deixe em branco)
$email["SMTPPORT"]                  = "";
$config_d["EMAIL_CONFIG"]            = $email;

/** Configurações de idiomas **/
$idiomas                            = array();
$idiomas["activated"]               = array("pt-br");
$idiomas["default"]                 = "pt-br";
$config_d["LANGS_ADMIN"]             = $idiomas;

$idiomas                            = array();
$idiomas["activated"]               = array("pt-br");
$idiomas["default"]                 = "pt-br";
$config_d["LANGS_FRONT"]             = $idiomas;
?>
