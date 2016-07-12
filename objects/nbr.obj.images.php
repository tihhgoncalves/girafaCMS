<?

class nbrImages
{
  private $_img;
  private $_imgX;
  private $_imgY;
  private $_fileName;
  private $_completionName;
  
  private $extensao;
  
  function __construct($file)
  {

    $this->extensao = strtolower(substr($file, -3)); //Pega extensão do arquivo..
    
    //Lá a imagem obtém suas dimensões
    switch ($this->extensao) {
    	case 'png': $this->_img = imagecreatefrompng($file); break;
    	case 'jpg': $this->_img = imagecreatefromjpeg($file); break;
    	default: new Exception('Extensão não permitida!');
    }
    
    #$this->_imgX = ImagesX($this->_img); 
    #$this->_imgY = ImagesY($this->_img);

    list($width, $height) = getimagesize($file);
    $this->_imgX = $width;
    $this->_imgY = $height;
    
    $this->_fileName = $file;
  }
  
  public function AdicionaFiltro($gd_filter)
  {
    imagefilter($this->_img, $gd_filter);
    
    //complementa o nome do arquivo do cache
    switch ($gd_filter) {
    	case IMG_FILTER_NEGATE:       $this->_completionName .= '_negative'; break;
    	case IMG_FILTER_MEAN_REMOVAL: $this->_completionName .= '_meanremoval'; break;
    	default:                      $this->_completionName .= IMG_FILTER_NEGATE; break;
    }
  }
  
  /**
   * Gera nova imagem (thumb)
   *
   * @param integer $width
   * @param integer $height
   * @param string $hAlign
   * @param string $vAlign
   * @param boolean $crop
   * @param boolean/string $bgForced ('false' caso não queira manter a proporção com fundo colorido. Ou a cor)
   * @return string
   */
  public function GeraThumb($width, $height, $hAlign = 'center', $vAlign = 'middle', $crop = true, $bgForced = false){
    global $cms, $LINK_IMGT, $ADMIN_UPLOAD_PATH, $ADMIN_UPLOAD_URL, $CACHE_PATH, $CACHE_URL;
    

    /**
     * Trata nome do arquivo e verifica se já tem no cache
     */
    
    //Deixa nome sem extensão
    $nome = $this->_fileName;
    $nome = substr($nome, 0, -4);
    
    $nome = str_replace('.jpg', '', $nome);
    $nome = str_replace('/', '\\', $nome);
    $nome = explode('\\', $nome);
    
    $novoNome = array_pop($nome);
    $novoNome  = $novoNome . '_' . $width . 'x' . $height . ($crop?'_crop':null) . (($bgForced != false)?'_bgForced':null);
    $novoNome .= (!empty($this->_completionName))?'_' . $this->_completionName:null;
    $novoNome .= '.' . $this->extensao;
    
    $nameWrite = $CACHE_PATH . $novoNome;
    $nameRead  = $CACHE_URL . $novoNome;
    $nameReturn = $nameRead;
    
    //Quando o valor não interessa (e for setado como zero) ele controla por aqui..
    $width = (intval($width) == 0?99999:$width);
    $height = (intval($height) == 0?99999:$height);
    
    //verifica se imagem já está no cache..
    if(!file_exists($nameWrite)){
      
      //verifica se o tamanho da thumb é igual o tamanho da original..
      if($this->_imgX == $width && $this->_imgY == $height){
        
        //salva no cache uma cópia da original..
        switch ($this->extensao) {
        	case 'png': imagepng($this->_img, $nameWrite, 100); break;
        	case 'jpg': imagejpeg($this->_img, $nameWrite, 100); break;
        }
      
      } else {
      
        /**
         * Calcula novo tamanho da imagem
         */
        
        //procura qual o menor lado da imagem
        $divisorX = ($this->_imgX / $width);
        $divisorY = ($this->_imgY / $height);      
        
        if($crop)
          $divisor = ($divisorX < $divisorY?$divisorX:$divisorY);
        else 
          $divisor = ($divisorX > $divisorY?$divisorX:$divisorY);
          
        $n_width  = ceil($this->_imgX / $divisor);
        $n_height = ceil($this->_imgY / $divisor);
      
        //Cria thumb
    
          //calcula alinhamento horizontal
          switch ($hAlign)
          {
            case 'center':
              $left = (($n_width - $width) / 2) * (-1);
              break;
              
            case 'left':
              $left = 0;
              break;
              
            case 'right':
              $left = ($n_width - $width) * (-1);
              break;
          }
          
          //calcula alinhamento vertical
          switch ($vAlign)
          {
            case 'middle':
              $top = (($height - $n_height) / 2);
              break;
              
            case 'top':
              $top = 0;
              break;
              
            case 'bottom':
              $top = ($height - $n_height);
              break;
          }
        
         //Verifica se tem que "cropar" ou manter proporção
         if($crop){
          $img_final = ImageCreateTrueColor($width, $height);

                 
         } else {

          $left = 0;
          $top = 0;    
          if($bgForced == false){
            $img_final = ImageCreateTrueColor($n_width, $n_height);
          } else {
            $img_final = ImageCreateTrueColor($width, $height);
            $rgb = nbrDraw_convertColor_HTML_to_RGB($bgForced);
            $background = imagecolorallocate($img_final, $rgb[0], $rgb[1], $rgb[2]);
            imagefill($img_final, 0, 0, $background);
          }
         }
      
        //Se for PNG preserva transparência
        if($this->extensao == 'png'){
          imagecolortransparent($img_final, imagecolorallocatealpha($img_final, 0, 0, 0, 127));
          imagealphablending($img_final, false);
          imagesavealpha($img_final, true);
        }   
                     
        //Copia a imagem original redimensionada para dentro da imagem final
        ImageCopyResampled($img_final, $this->_img, $left, $top , 0, 0, $n_width + 1, $n_height + 1, $this->_imgX , $this->_imgY);   
        
        //Grava no cache
        switch ($this->extensao) {
        	case 'png': imagepng($img_final, $nameWrite, 9); break;
        	case 'jpg': ImageJPEG($img_final, $nameWrite, 100); break;
        }        
      }
      ImageDestroy($img_final);
    }
    ImageDestroy($this->_img);

    return $nameReturn;
  }
}
?>