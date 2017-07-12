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
<title>Girafa CMS</title>
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

<!-- Plugin Font Awesome -->
<link href="<?= get_config('BOWER_COMPONENTS_URL'); ?>font-awesome/css/font-awesome.min.css" rel="stylesheet">

<!-- Plugins jQuery -->
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>jquery/dist/jquery.js" type="text/javascript"></script>

<!-- jQuery Tooltipster's -->
<link rel="stylesheet" type="text/css" href="<?= get_config('BOWER_COMPONENTS_URL'); ?>/tooltipster/dist/css/tooltipster.bundle.min.css" />
<script type="text/javascript" src="<?= get_config('BOWER_COMPONENTS_URL'); ?>/tooltipster/dist/js/tooltipster.bundle.min.js"></script>

<!-- jQuery MaskedInput -->
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>jquery.maskedinput/dist/jquery.maskedinput.min.js" type="text/javascript"></script>

<!-- jQuery Fancybox -->
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>fancybox/source/jquery.fancybox.js" type="text/javascript"></script>
<link href="<?= get_config('BOWER_COMPONENTS_URL'); ?>fancybox/source/jquery.fancybox.css" rel="stylesheet" type="text/css" />

<!-- jquery alerts -->
<link href="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.alert/nbr.jquery.alerts.css" rel="stylesheet" type="text/css" />
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.alert/jquery.alerts.js" type="text/javascript"></script>

<!-- Plugins MEDIUM Editor -->
<link href="<?= get_config('BOWER_COMPONENTS_URL'); ?>medium-editor/dist/css/medium-editor.min.css" rel="stylesheet" type="text/css" />
<link href="<?= get_config('BOWER_COMPONENTS_URL'); ?>medium-editor/dist/css/themes/default.min.css" rel="stylesheet" type="text/css" />
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>medium-editor/dist/js/medium-editor.min.js" type="text/javascript"></script>

<!-- Plugins MEDIUM Editor INSERT-->
<link rel="stylesheet" href="<?= get_config('BOWER_COMPONENTS_URL'); ?>medium-editor/dist/css/medium-editor.min.css">
<link rel="stylesheet" href="<?= get_config('BOWER_COMPONENTS_URL'); ?>medium-editor/dist/css/themes/default.css">
<link rel="stylesheet" href="<?= get_config('BOWER_COMPONENTS_URL'); ?>medium-editor-insert-plugin/dist/css/medium-editor-insert-plugin.min.css">
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>handlebars/handlebars.runtime.min.js"></script>
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>jquery-sortable/source/js/jquery-sortable-min.js"></script>
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>blueimp-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>blueimp-file-upload/js/jquery.iframe-transport.js"></script>
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>blueimp-file-upload/js/jquery.fileupload.js"></script>
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>medium-editor-insert-plugin/dist/js/medium-editor-insert-plugin.min.js"></script>

<!-- Plugins Poshytip -->
<link href="<?= get_config('BOWER_COMPONENTS_URL'); ?>poshytip/src/tip-twitter/tip-twitter.css" rel="stylesheet" type="text/css" />
<script src="<?= get_config('BOWER_COMPONENTS_URL'); ?>poshytip/src/jquery.poshytip.min.js" type="text/javascript"></script>


<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.ui/jquery-ui-1.10.3.custom.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.multiselect/ui.multiselect.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.validate/jquery.validate.js" type="text/javascript"></script>
<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.autonumeric/autoNumeric-1.5.4.js" type="text/javascript"></script>
<!--<script src="<?= $cms->GetAdminJavaScriptUrl(); ?>jquery.fileupload/jquery.fileupload.js" type="text/javascript"></script>-->


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
  var root_url              = '<?= get_config('ROOT_URL'); ?>';
  var root_path             = '<?= get_config('ROOT_PATH'); ?>';
  var admin_path            = '<?= get_config('ADMIN_PATH'); ?>';
  var admin_url             = '<?= get_config('ADMIN_URL');?>';
  var admin_page_path       = '<?= get_config('ADMIN_PAGES_PATH'); ?>';
  var admin_page_url        = '<?= get_config('ADMIN_PAGES_URL'); ?>';
  var admin_javascript_path = '<?= get_config('ADMIN_JAVASCRIPT_PATH'); ?>';
  var admin_javascript_url  = '<?= get_config('ADMIN_JAVASCRIPT_URL'); ?>';
  var bower_url             = '<?= get_config('BOWER_COMPONENTS_URL'); ?>';
  var bower_path            = '<?= get_config('BOWER_COMPONENTS_PATH'); ?>';
</script>
</head>
<body>
<div id="topo">
  <div id="logo"><a href="<?= $ADMIN_URL; ?>">

      <?
      //verifica se tem logo customizada no tema...
      $customlogo_path = get_config('ROOT_PATH') . 'site/admin/logo-cms.png';
      $customlogo_url = get_config('ROOT_URL') . 'site/admin/logo-cms.png';
      if(file_exists($customlogo_path)) {
        $logo_cms = $customlogo_url;
      } else {
        $logo_cms = $cms->GetAdminImageUrl() . 'logo-cms.png';
      }
        ?>
        <img src="<?= $logo_cms?>" height="37" alt="Girafa CMS"/>

    </a> </div>


  <div class="direita"> <a href="<?= $ROOT_URL; ?>" target="_blank" title="Ver site" id="btn_site"> <i class="fa fa-globe" aria-hidden="true"></i></a>
    <?
    $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'login.script.logout.php');
    ?>
    <a href="<?= $hub->GetUrl(); ?>" title="Sair" id="btn_sair"> <i class="fa fa-times-circle-o" aria-hidden="true"></i> </a>
  </div>

  <div id="usuario"> <span id="nome"><?= __('Olá'); ?> <?= $security->GetUserName()?></span> <a href="#"><span style="display:none;" id="editarperfil"></span></a> </div>

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
          <a title="<?= __($module->name); ?>" href="<?= $hub->GetUrl(); ?>">
            <i class="fa <?= $module->icon; ?>" aria-hidden="true"></i>

            <?
            if($module->GetNotifications() > 0){
              ?>
              <div id="contador"><?= $module->GetNotifications(); ?></div>
            <?
            }
            ?>
          </a>
        </li>
      <?
      }
      ?>
    </ul>
  </div>

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
<div id="rodape">Este é um sistema da <a href="http://www.zbraestudio.com.br" target="_blank">Z.BRA Estúdio</a>, na <b>versão <?= $cms->GetVersion(); ?></b> - PHP <?=  phpversion(); ?>
  <span style="color: darkgray;">[upload_max_filesize: <?= ini_get('upload_max_filesize'); ?>]<span></div>
<div id="status"></div>

</body>
</html>