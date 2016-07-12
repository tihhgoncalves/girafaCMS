<?
include('../../../../config.php');
include('../../../../cms/nbr.loader.php');

if($_FILES["file"]["error"] > 0){
  
	die("Error: " . $_FILES["upload"]["error"] . "<br />");
	
} else {
  
  $arquivoNome = date('Y-m-d') . '_' . nbrString::RemoveAccents($_FILES["upload"]["name"]); 
  
	$address	= $GLOBALS['ROOT_URL'] . 'site/uploads/ckeditor/' . $arquivoNome;
	$original	= $_FILES["upload"]["tmp_name"];
	$filename	= $GLOBALS['ROOT_PATH'] . 'site/uploads/ckeditor/' . $arquivoNome;

	if(move_uploaded_file($original,$filename)){
		print("
		<script type='text/javascript'>
			window.parent.CKEDITOR.tools.callFunction({$_GET['CKEditorFuncNum']},'$address');
		</script>");
	} else {
		die('Erro ao armazenar o arquivo');
	}
}
?>