<?

//exclue diretório mesmo que não estive vazio
function rmdir_recursiva($dir) 
{ 
 //Lista o conteúdo do diretório em uma tabela 
 $dir_content = scandir($dir); 
 //Este é realmente um diretóírio? 
 if($dir_content !== FALSE){ 
  //Para cada entrada do diretório 
  foreach ($dir_content as $entry) 
  { 
   //Atalhos simbólicos no Unix, passemos 
   if(!in_array($entry, array('.','..'))){ 
    //Encontramos o caminho em relação ao início 
    $entry = $dir . '/' . $entry; 
    //Esta entrada não é uma pasta: vamos removê-la 
    if(!is_dir($entry)){ 
     unlink($entry); 
    } 
    //Esta entrada é uma pasta, vamos recomeçar nesta pasta 
    else{ 
     rmdir_recursiva($entry); 
    } 
   } 
  } 
 } 
 //Removemos todas as entradas da pasta, agora podemos excluí-la 
 rmdir($dir); 
} 


//Copia diretório inteiro..
function CopiaDir($DirFont, $DirDest){
    
    mkdir($DirDest);
    if ($dd = opendir($DirFont)) {
        while (false !== ($Arq = readdir($dd))) {
            if($Arq != "." && $Arq != ".."){
                $PathIn = "$DirFont/$Arq";
                $PathOut = "$DirDest/$Arq";
                if(is_dir($PathIn)){
                    CopiaDir($PathIn, $PathOut);
                }elseif(is_file($PathIn)){
                    copy($PathIn, $PathOut);
                }
            }
        }
        closedir($dd);
    }
}

function TamanhoArquivo($arquivo) {
    $tamanhoarquivo = filesize($arquivo);
 
    /* Medidas */
    $medidas = array('kb', 'mb', 'gb', 'tb');
 
    /* Se for menor que 1KB arredonda para 1KB */
    if($tamanhoarquivo < 999){
        $tamanhoarquivo = 1000;
    }
 
    for ($i = 0; $tamanhoarquivo > 999; $i++){
        $tamanhoarquivo /= 1024;
    }
 
    return number_format($tamanhoarquivo, 1, ',', '.') . $medidas[$i - 1];
}
?>