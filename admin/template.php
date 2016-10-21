<?
//Módulo e Pasta aberta..
if($hub->ExistParam('_moduleID')){
  $moduleObj = nbrModule::LoadModule($hub->GetParam('_moduleID'));
  $folderObj = LoadRecord('sysModuleFolders', $hub->GetParam('_folderID'));
}
//Verifica segurança..
$security->SecurityCheck();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Ministrar2 CMS</title>
<meta name="author" content="Nova Brazil Agência Interativa">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
<link REL="SHORTCUT icon" HREF="<?= $cms->GetRootUrl()?>favicon.ico">

<!-- Estilos -->
<link href="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.multiselect/common.css" rel="stylesheet" type="text/css" />
<link href="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.multiselect/ui.multiselect.css" rel="stylesheet" type="text/css" />
<link href="<?= $cms->GetAdminStyleSheetUrl(); ?>animations.css" rel="stylesheet" type="text/css" />
<link href="<?= $cms->GetAdminStyleSheetUrl(); ?>master.css" rel="stylesheet" type="text/css" />
<link href="<?= $cms->GetAdminStyleSheetUrl(); ?>ui.css" rel="stylesheet" type="text/css" />
<link href="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.ui/blitzer/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<link href="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.alert/nbr.jquery.alerts.css" rel="stylesheet" type="text/css" />
<link href="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery-tooltip/jquery.tooltip.css" rel="stylesheet" type="text/css" />
<link href="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.fancybox/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />

<!-- Plugins Jquery -->
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>jquery/dist/jquery.js" type="text/javascript"></script>
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>jquery-migrate-1.0.0/index.js" type="text/javascript"></script>

  <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>ckeditor/adapters/jquery.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.ui/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.multiselect/ui.multiselect.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.alert/jquery.alerts.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery-tooltip/jquery.tooltip.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.maskedinput/jquery.maskedinput-1.2.2.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.autonumeric/autoNumeric-1.5.4.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.fileupload/jquery.fileupload.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.fancybox/jquery.fancybox-1.3.4.js" type="text/javascript"></script>

<!-- Scripts -->
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>cms.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>box.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>toolbar.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>grid.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>form.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>site.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>mousetrap.js" type="text/javascript"></script>

<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>ui.js" type="text/javascript"></script>

<script type="text/javascript">
  /** Variáries JavaScript usadas no Administrador **/
  var root_url              = '<?= $GLOBALS['ROOT_URL'] ?>';
  var root_path             = '<?= $GLOBALS['ROOT_PATH'] ?>';
  var admin_path            = '<?= $GLOBALS['ADMIN_PATH'] ?>';
  var admin_url             = '<?= $GLOBALS['ADMIN_URL'] ?>';
  var admin_page_path       = '<?= $GLOBALS['ADMIN_PAGES_PATH'] ?>';
  var admin_page_url        = '<?= $GLOBALS['ADMIN_PAGES_URL'] ?>';
  var admin_javascript_path = '<?= $GLOBALS['ADMIN_JAVASCRIPT_PATH'] ?>';
  var admin_javascript_url  = '<?= $GLOBALS['ADMIN_JAVASCRIPT_URL'] ?>';
</script>
</head>
<body>
<div id="topo">
  <div id="logo"><a href="<?= $ADMIN_URL; ?>"><img src="<?= $cms->GetAdminImageUrl(); ?>logo-cms.png" width="140" height="37" alt="CMS Ministrar2" /> </a> </div>

  <div class="direita"> <a href="<?= $ROOT_URL; ?>" target="_blank" title="Ver site"> <span id="btn_site"></span> </a> 
  <?
    $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'login.script.logout.php');
  ?>
  <a href="<?= $hub->GetUrl(); ?>" title="Sair"> <span id="btn_sair"></span> </a> 
  </div>
  
  <div id="usuario"> <span id="nome"><?= __('Olá'); ?> <?= $security->GetUserName()?></span> <a href="#"><span style="display:none;" id="editarperfil"></span></a> </div>
</div>


<div id="toolbar">

<ul>
<?
//Pega todos os módulos da Aplicação...
$obj_modules = new nbrModules();
$modules = $obj_modules->GetModules();

foreach ($modules as $module) {

  //Verifica se este é o Módulo selecionado e insere a classe.
  $class = ($hub->GetParam('_moduleID') == $module->ID)?' class="selected"':null;
  
  //Limpa Níveis do Hub..
  $hub->ClearHistory();

  //Seta parametros do Módulo... 
  $hub->SetParam('_page', $module->file);
  $hub->SetParam('_moduleID', $module->ID);
  $hub->SetParam('_folderID', $module->folderID);
  $hub->SetParam('_languages', ($module->MultiLanguages != 'N'?'Y':'N'));
  $hub->SetParam('_setLanguage', 'Y');  
  $hub->SetParam('_title'   , $module->name);
  $hub->SetParam('_description', 'Módulo ' . $module->name);
  $hub->SetParam('_languages', ($module->MultiLanguages != 'N'?'Y':'N'));
  
  //Duplica o último nível no Hub para mais um nível para o link da Pasta..
  $hub->levels[] = $hub->levels[count($hub->levels) -1];
  
  $hub->SetParam('_title', $module->folderName);  
  $hub->SetParam('_description', 'Pasta ' . $module->folderName);  
?>
  <li <?= $class; ?>>
    <a title="<?= $module->description; ?>" href="<?= $hub->GetUrl(); ?>">
      <div class="name" style="background-image:url(<?= $module->iconPath; ?>); ">
        <span><?= __($module->name); ?></span>

        <?
        if($module->GetNotifications() > 0){
        ?>
        <div id="contador"><?= $module->GetNotifications(); ?></div>
        <?
        }
        ?>
      </div>
    </a>
  </li>
<?
}
?>  
</ul>
</div>
<div id="escondeToolbar">
  <div id="painel"><a href="javascript:void(0);"><?= __('mais módulos'); ?></a></div>
</div>
<!-- CONTEUDO - INICIO -->
<div id="content">
  <div id="left">
  
<?

//se não tiver Módulo selecionado, não mostra pasta nem relatórios..

if($hub->ExistParam('_moduleID')){

  //Seleciona Pastas..
  $obj_folders = new nbrModuleFolders($hub->GetParam('_moduleID'));
  $folders = $obj_folders->GetFolders();
?>
<ul class="menu">
<?
  $grouper = null;
  foreach ($folders as $folder) {
    
    if($grouper != $folder->Grouper){
      $grouper =  $folder->Grouper;
      echo('</ul>');
      echo('<h1>' . $grouper . '</h1>');
      echo('<ul class="menu">');
    }
  
    $hub->ClearHistory(1);
  
    $file = $moduleObj->path . $folder->File;
    $hub->SetParam('_page', $file);
    $hub->SetParam('_title', $folder->Name);
    $hub->SetParam('_languages', ($folder->MultiLanguages != 'N'?'Y':'N'));
    $hub->SetParam('_description', 'Pasta ' . $folder->Name);
    $hub->SetParam('_moduleID', $moduleObj->ID);
    $hub->SetParam('_folderID', $folder->ID);
    $link = $hub->GetUrl();
    
    echo('<li ' . (($hub->GetParam('_folderID') == $folder->ID)?'class="selected"':null) . '>');


    if(!empty($folder->CounterSQL)){

      $total = 'erro';
      $sql  = $folder->CounterSQL;
      $resultado = $db->LoadObjects($sql);

      if(count($resultado) > 0){
        $total = intval($resultado[0]->TOTAL);
      }

      echo('<span class="contador">' . $total . '</span>');
    }



    echo('<a href="' . $link . '"><span>' . __($folder->Name) . '</span></a>');



    echo('</li>');
    
  }
?>  
</ul>

<?
  $sql = 'SELECT * FROM sysModuleReports';
  $sql .= " WHERE Published = 'Y' AND Module = $moduleObj->ID";
  $sql .= ' ORDER BY Title ASC';
  $relatorios = $db->LoadObjects($sql);
  
  if(count($relatorios) > 0){
?>

<h1 style="margin-top: 20px;">Relatórios</h1>
<ul class="reports">

<?
    foreach ($relatorios as $relatorio) {
      
      $hub->SetParam('_page', $ADMIN_PAGES_PATH . 'reports.php');
      $hub->SetParam('_title', $relatorio->Title);
      $hub->SetParam('_description', 'Emitindo relatório ' . $relatorio->Title);
      $hub->SetParam('_moduleID', $hub->GetParam('_moduleID'));
      $hub->SetParam('_folderID', $hub->GetParam('_folderID'));
      
      $hub->SetParam('reportID', $relatorio->ID);
      $hub->SetParam('reportFile', $moduleObj->path . $relatorio->File);
      $hub->SetParam('reportTitle', $relatorio->Title);
?>
<li><a href="<?= $hub->GetUrl();?>"><?= $relatorio->Title; ?></a></li>
<?
    }
?>
</ul>
<?
  }
}
?>


</div>
  <div class="<?= (($hub->ExistParam('_moduleID'))?'main':'mainFull'); ?>">
  
  <?
  
  /**
   * Bandeiras (idiomas)
   */
  
  //verifica se pasta é controlada por idioma...
  if($hub->GetParam('_languages') == 'Y'){
  ?>
  <div id="flags">
  	<span><?= __('Selecione o idioma que deseja visualizar/salvar os registros:'); ?></span>
  <ul>
  <?  
  $primeiro = true;
	  foreach ($langs_front['activated'] as $x=>$flag) {
	    
	  	$sql  = 'SELECT * FROM sysLanguages';
	  	$sql .= " WHERE Identificador = '$flag'";
	  	
	  	$db_flags = $db->LoadObjects($sql);
	  	$dv_flag = $db_flags[0];
	  	
	  	if($moduleObj->CheckLanguage($dv_flag->ID)){
	  	  
	  	  //Se é um click em Modulo seta o primeiro idioma
  	    if($primeiro){
  	      if($hub->GetParam('_setLanguage') == 'Y'){
  	        
  	        $_SESSION['lang_admin'] = $flag;
  	        $primeiro = false;
  	      }
  	    }	  	  
	  	
  	  	$hub->SetParam('_page', $ADMIN_PAGES_PATH . 'langs.php');
  	  	$hub->SetParam('lang', $flag);
  ?>
  <li <?= ($flag == $_SESSION['lang_admin'])?'class="selected"':null; ?>>
  	<a href="<?= $hub->GetUrl(); ?>" title="<?= sprintf(__('Alterar idioma dos cadastros para: %s'), $dv_flag->Nome); ?>">
  		<img src="<?= $ADMIN_URL . 'flags/' . $flag ?>.gif" width="18" height="12">
  	</a>
  </li>
  <?	
	  	}
	  }
  ?>
  </ul>
  </div>
  <?
  }
  ?>
  
    <? include($page); ?>
    <div class="clearcontent"></div>
    </div>
  </div>
  <div style="clear:left"></div>
</div>
<!-- CONTEUDO - FIM -->
<div id="rodape">Este é um sistema da <a href="http://www.zbraestudio.com.br" target="_blank">Z.BRA Estúdio</a>, na <b>versão <?= $cms->GetVersion(); ?></b> - PHP <?=  phpversion(); ?></div>
<div id="status"></div>

</body>
</html>