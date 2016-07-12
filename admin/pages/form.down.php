<?php 
$arquivoName = $hub->GetParam('file');
$arquivo = $ADMIN_UPLOAD_PATH . $arquivoName;

$temp = explode('.', $arquivoName);
$ext = array_pop($temp);

header('Content-Disposition: attachment; filename=arquivo.' . $ext);   
header('Content-Type: application/force-download');
header('Content-Type: application/octet-stream');
header('Content-Type: application/download');
header('Content-Description: File Transfer');            
header('Content-Length: ' . filesize($arquivo));
echo file_get_contents($arquivo);
?> 