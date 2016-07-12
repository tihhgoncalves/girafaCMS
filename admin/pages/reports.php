<?
$file = $hub->GetParam('reportFile');

$hub->SetParam('_script', $ADMIN_PAGES_PATH . 'reports.execute.php');
$hub->SetParam('reportFile', $file);

$link = $hub->GetUrl();
?>

<h1><?= $hub->GetParam('reportTitle') ?></h1>
<p>Abaixo será emitido o relatório. Caso tenha problemas para visualizá-lo, <a target="_blank" href="<?= $link ?>">clique aqui</a> para visualizá-lo em uma nova janela.</p>
<iframe id="report" src ="<?= $link; ?>">