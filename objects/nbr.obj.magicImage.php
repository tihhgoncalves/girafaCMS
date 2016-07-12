<?php
/**
 * nbrMagicImage
 * User: Tihh Gonçalves (tiago@tiago.art.br)
 * Create Date: 24/03/14
 */

class nbrMagicImage{

  /** privates */
  private $file_path;
  private $file_pathInfo;
  private $file_extension;
  private $content_type;
  private $img_obj;


  /** publics */
  public $width;
  public $height;

  function __construct(){

    $this->img_obj = ImageCreateTrueColor(1, 1);
    $this->content_type = 'image/png';
    $this->file_extension = 'png';

    $this->width = 1;
    $this->height = 1;
  }
  public function Load($file){
    if(!file_exists($file))
      throw new Exception('O objeto nbrMagicImage tentou carregar uma imagem que não foi encontrada.');

    //registra o tamanho do arquivo
    $this->file_path = $file;

    //carrega informações do arquivo
    $this->file_pathInfo = pathinfo($this->file_path);

    //Registra a extensão do arquivo
    $this->file_extension = $this->file_pathInfo['extension'];

    //Pega medidas
    $tamanho = getimagesize($this->file_path);
    $this->width = $tamanho[0];
    $this->height = $tamanho[1];

    //Carrega imagem..
    switch($this->file_extension){
      case 'jpg':
          $this->img_obj = imagecreatefromjpeg($this->file_path);
          $this->content_type = 'image/jpeg';
        break;

      case 'png':
          $this->img_obj = imagecreatefrompng($this->file_path);
          $this->content_type = 'image/png';
        break;

      default:
        //throw new Exception('Desculpe, mas a extensão ' . strtoupper($this->file_extension) . ' não foi implementada no objeto nbrMagicImage ainda.');
        echo('Desculpe, mas a extensão ' . strtoupper($this->file_extension) . ' não foi implementada no objeto nbrMagicImage ainda.');
        break;
    }

  }

  public function Resized($width = null, $height = null){

    if(empty($width) && empty($height))
      throw new Exception('Você não pode deixar o parâmetro $width e $height em branco. Preencha um dos 2 parâmetros.');

    if((intval($width) > 0) && empty($height)){
      $div = ($this->width / $width);

      $n_width = ceil($this->width / $div);
      $n_height = ceil($this->height / $div);

    } elseif((intval($height) > 0) && empty($width)){

      $div = ($this->height / $height);

      $n_width = ceil($this->width / $div);
      $n_height = ceil($this->height / $div);

    }else{
      $n_width = $width;
      $n_height = $height;
    }

    $novaFoto = ImageCreateTrueColor($n_width,$n_height);
    imagecopyresampled($novaFoto, $this->img_obj, 0, 0, 0, 0, $n_width, $n_height, $this->width, $this->height);

    //atualiza objeto oficial
    imagedestroy($this->img_obj);
    $this->img_obj = $novaFoto;
    $this->width = $n_width;
    $this->height = $n_height;
  }

  public function Crop($left, $top, $width, $height){
    $novaFoto = ImageCreateTrueColor($width,$height);
    imagecopyresampled($novaFoto, $this->img_obj, 0, 0, $left, $top, $this->width, $this->height, $this->width, $this->height);

    //atualiza objeto oficial
    imagedestroy($this->img_obj);
    $this->img_obj = $novaFoto;
    $this->width = $width;
    $this->height = $height;
  }

  public function CreateImage($width, $height, $backgroundColor = null){

    if($backgroundColor == null){

      $imgObj = ImageCreateTrueColor($width, $height);

    } else {

      $imgObj = ImageCreateTrueColor($width, $height);
      $rgb = nbrDraw_convertColor_HTML_to_RGB($backgroundColor);
      $background = imagecolorallocate($imgObj, $rgb[0], $rgb[1], $rgb[2]);
      imagefill($imgObj, 0, 0, $background);

    }

    //atualiza
    imagedestroy($this->img_obj);
    $this->width = $width;
    $this->height = $height;
    $this->img_obj = $imgObj;
  }

  public function AddImage($nbrMagicImagem, $left, $top){
    imagecopyresampled($this->img_obj, $nbrMagicImagem->img_obj, $left, $top, 0, 0, $nbrMagicImagem->width, $nbrMagicImagem->height, $nbrMagicImagem->width, $nbrMagicImagem->height);
  }

  public function ThumbCropCenter($width, $height){

    $divisorX = ($this->width / $width);
    $divisorY = ($this->height / $height);

    $divisor = ($divisorX < $divisorY ? $divisorX : $divisorY);

    $this->Resized(ceil($this->width / $divisor), ceil($this->height / $divisor));

    $left = (($this->width - $width) / 2);
    $top = (($this->height - $height) / 2);

    $this->Crop($left, $top, $width, $height);
  }

  public function ThumbBackgroundCenter($width, $height, $color = 'transparent'){

    $divisorX = ($this->width / $width);
    $divisorY = ($this->height / $height);

    $divisor = ($divisorX > $divisorY ? $divisorX : $divisorY);

    $n_w = ceil($this->width / $divisor);
    $n_h = ceil($this->height / $divisor);

    $this->Resized($n_w, $n_h);

    $left = (($width - $this->width) / 2);
    $top = (($height - $this->height) / 2);

    if($color == 'transparent'){

      if($this->file_extension != 'png'){
        $this->file_extension = 'png';
        $this->content_type = 'image/png';
      }

      $imgObj = ImageCreateTrueColor($width, $height);
      $background = imagecolorallocate($imgObj, 0, 0, 0);
      imagecolortransparent($imgObj, $background);
      imagealphablending($imgObj, false);

    } else {

      $imgObj = ImageCreateTrueColor($width, $height);
      $rgb = nbrDraw_convertColor_HTML_to_RGB($color);
      $background = imagecolorallocate($imgObj, $rgb[0], $rgb[1], $rgb[2]);
      imagefill($imgObj, 0, 0, $background);
    }

    ImageCopyResampled($imgObj, $this->img_obj, $left, $top ,0 , 0 , $this->width, $this->height, $this->width,  $this->height);

    //atualiza..
    imagedestroy($this->img_obj);
    $this->img_obj = $imgObj;

  }
  public function DestroyImg(){
    imagedestroy($this->img_obj);
  }
  public function GetImage(){

    //imprime cabeçalho..
    header('Content-Type: ' . $this->content_type);

    //chama a imagem na tela
    switch($this->file_extension){

      case 'jpg':
        imagejpeg($this->img_obj);
        imagedestroy($this->img_obj);
        break;

      case 'png':
        imagepng($this->img_obj);
        imagedestroy($this->img_obj);
        break;
    }
  }

  public function SaveFile($path){
    //chama a imagem na tela
    switch($this->file_extension){

      case 'jpg':
        imagejpeg($this->img_obj, $path);
        imagedestroy($this->img_obj);
        break;

      case 'png':
        imagepng($this->img_obj, $path);
        imagedestroy($this->img_obj);
        break;
    }

  }
  public static function CreateThumbCropCenter($imgPath, $width, $height){
    global $CACHE_PATH, $CACHE_URL;

    $file_infos =  pathinfo($imgPath);
    $file_lastmod = filemtime($imgPath);

    $n_file = $file_infos['filename'] . '_tcc_' . $width . 'x' . $height . '_' . date('YmdHis', $file_lastmod) . '.' . $file_infos['extension'];

    if(!file_exists($CACHE_PATH . $n_file)){
      $img = new nbrMagicImage();
      $img->Load($imgPath);
      $img->ThumbCropCenter($width, $height);

      $img->SaveFile($CACHE_PATH . $n_file);
    }

    return $CACHE_URL . $n_file;
  }

  public static function CreateThumbBackgroundCenter($imgPath, $width, $height, $bgColor = '#FFFFFF'){
    global $CACHE_PATH, $CACHE_URL;

    $file_infos =  pathinfo($imgPath);
    $file_lastmod = filemtime($imgPath);



    $n_file = $file_infos['filename'] . '_tbgc_' . str_replace('#', '', $bgColor) . '_' . $width . 'x' . $height . '_' . date('YmdHis', $file_lastmod) . '.' . $file_infos['extension'];

    if(!file_exists($CACHE_PATH . $n_file)){
      $img = new nbrMagicImage();
      $img->Load($imgPath);
      $img->ThumbBackgroundCenter($width, $height, $bgColor);

      $img->SaveFile($CACHE_PATH . $n_file);
    }

    return $CACHE_URL . $n_file;
  }

}