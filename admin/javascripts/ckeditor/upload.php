<?
include('../../../loader.php');

if($_FILES["file"]["error"] > 0){
  
	die("Error: " . $_FILES["upload"]["error"] . "<br />");
	
} else {
  
  $arquivoNome = date('Y-m-d') . '_' . RemoveAccents($_FILES["upload"]["name"]);
  
	$address	= $GLOBALS['ADMIN_UPLOAD_URL'] . 'ckeditor/' . $arquivoNome;
	$original	= $_FILES["upload"]["tmp_name"];
	$filename	= $GLOBALS['ADMIN_UPLOAD_PATH'] . 'ckeditor/' . $arquivoNome;

	if(move_uploaded_file($original,$filename)){
		print("
		<script type='text/javascript'>
			window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']},'$address');
		</script>");
	} else {
		die('Erro ao armazenar o arquivo');
	}
}



function RemoveAccents($text)
{
	//Tira acentos
	$comAcento  = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ');
	$semAcento = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y');
	$text = str_replace($comAcento, $semAcento, $text);
	return $text;
}
?>