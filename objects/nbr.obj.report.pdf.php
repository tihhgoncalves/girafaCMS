<?

//Carrega biblioteca...
include($OBJECTS_PATH . 'fpdf/fpdf.php');  
define('FPDF_FONTPATH', $OBJECTS_PATH . 'fpdf/font/');

class nbrPDF extends FPDF
{
  public $objImp        = null;
  public $autoBreakLine = false;
  public $title;
  public $code;
  public $designer = false;
  public $areaW;
  
  /**
   * Contrutor da classe
   */
   /**
    * Contrutor da classe
    */
   public function __construct($title, $orientacao = 'P', $papel = 'A4')
   {
     $this->title = $title;
     
     parent::__construct($orientacao, 'pt', $papel);
   }
  
  
  /**
   * Renderizar em formato PDF
   */
  public function PreparePDF()
  {
    $this->SetDisplayMode(100);
  
    // Margens
    $this->lMargin = 10;
    $this->rMargin = 10;
    $this->tMargin = 10;
    $this->bMargin = 10;
    $this->cMargin = 1;
  
    $this->areaW = ($this->w - $this->lMargin - $this->rMargin);
    
    $this->SetAutoPageBreak(true, 30);
  
    $this->AddPage();
  }
  
  /**
   * Fechar relatório
   */
  public function RenderPDF($fileName = false, $dest = '')
  {
    if ($fileName === false)
      $this->Output();
    else
      $this->Output($fileName, $dest);
  }
  
  /**
   * Cabeçalho
   */
  public function Header()
  {
    global $cms;
    
    $height = 60;
    $this->SetXY($this->lMargin, $this->tMargin);
  
    // Logo
    $logo_w = 120;
    $this->RenderImage($cms->GetAdminImagePath() . 'logoPDF.jpg', $logo_w);
    $logo_w_sp = $logo_w + 8;
  
    // Parâmetros
    $this->SetXY($this->lMargin + $logo_w_sp, $this->tMargin);
  
    $info_w  = 96;
    $param_w = ($this->w - $this->lMargin - $this->rMargin - $logo_w_sp - $info_w);
    
    // Linha 1
    //$this->RenderText('ABC' . $this->title, $param_w, 'left', 'Arial, 18, B,#000000');
    $this->SpaceW($param_w + 2);
    $this->RenderText('Pagina:',                    40, 'right', 'Arial,8,B,#000000');
    $this->SpaceW(2);
    $this->RenderText($this->PageNo(),              52, 'right');
    $this->NewLine(0, $logo_w_sp);
  
    // Linha 2
    //$this->RenderText('$this->rep->GetFilterText(1)', $param_w, 'left');
    $this->SpaceW($param_w + 2);
    $this->RenderText('Data:',                      40, 'right', 'Arial,8,B,#000000');
    $this->SpaceW(2);
    $this->RenderText(date('d/m/Y'),       52, 'right');
    $this->NewLine(0, $logo_w_sp);
  
    // Linha 3
    //$this->RenderText('$this->rep->GetFilterText(2)', $param_w, 'left');
    $this->SpaceW($param_w + 2);
    $this->RenderText('Hora:',                      40, 'right', 'Arial,8,B,#000000');
    $this->SpaceW(2);
    $this->RenderText(date('H:i:s'),       52, 'right');
    $this->NewLine(0, $logo_w_sp);
  
    // Linha 4
    //$this->RenderText('$this->rep->GetFilterText(3)', $param_w, 'left');
    $this->SpaceW($param_w + 2);
    $this->RenderText('Doc:',                       40, 'right', 'Arial,8,B,#000000');
    $this->SpaceW(2);
    $this->RenderText($this->code,             52, 'right');
    $this->NewLine(20, 0);
    
    // Título
    $this->RenderText($this->title,         ($this->w - $this->lMargin - $this->rMargin), 'center', 'Arial,14,B,#000000');
  
  
    // Linha
    $top = ($this->tMargin + $height);
    $this->Line($this->lMargin, $top, ($this->w - $this->rMargin), $top);
  
    // Inicio dorelatorio
    $this->SetXY($this->lMargin, $top + 5);
  
    // Verificar se objeto implementa Header
    if ($this->objImp != null)
    {
      if (method_exists($this->objImp, 'Header'))
        $this->objImp->Header();
    }
  }
  
  /**
   * Rodapé
   */
  public function Footer()
  {
    global $_security;

    if(empty($_security)){
      $userName = '(anônimo)';
    } else {
      $userName = $_security->userName;
    }

    $top = $this->PageBreakTrigger;
    $this->Line($this->lMargin, $top, ($this->w - $this->rMargin), $top);
    $this->SetXY($this->lMargin, $top + 1);
  
    $col_w = (($this->w - $this->lMargin - $this->rMargin) / 2);
  
    $cols    = array();
    $cols[1] = $this->title;
    $cols[2] = $userName;
  
    $this->RenderText($cols[1],  $col_w, 'left');
    $this->RenderText($cols[2],  $col_w, 'right');
  }
  
  /**
   * Escrever Texto
   *
   * @param unknown_type $param1
   */
  public function RenderText($text, $width = false, $align = 'left', $fonte = 'Arial,8,,#000000', $borda = false, $fundo = false)
  {
    // Fonte
    $this->SetFonte($fonte);
  
    // Alinhamento
    $n_align = array('left' => 'L', 'center' => 'C', 'right' => 'R');
    $align   = $n_align[$align];
  
    // Height
    $height = $this->FontSize + (2 * $this->cMargin);
  
    // Bordas e cor da borda
    $border = $this->GetBorda($borda);
  
    // Cor de fundo
    $fundo = ($this->designer ? '#FFDDDD' : $fundo);
    $this->SetFundo($fundo);
  
    // Link
    $link = '';
  
    // Descobrir largura
    if (($width === false) && ($text != ''))
      $width = ($this->GetStringWidth($text) + 2);
  
    // Tratar largura da string
    while (($this->GetStringWidth($text) > $width) && ($text != ''))
      $text = substr($text, 0, -1);
  
    // Quebra de linha automotica
    if (($this->autoBreakLine) && (($this->x + $width) > ($this->w - $this->rMargin)))
      $this->NewLine();
  
    // Escrever
    $this->Cell($width, $height, utf8_decode($text), $border, 0, $align, ($fundo !== false), $link);
  
    // Retorno
    $info           = array();
    $info['width']  = $width;
    $info['height'] = $height;
    $info['x']      = $this->x;
    $info['y']      = $this->y;
    return $info;
  }
  
  /**
   * Adicionar espa�o horizontal
   *
   * @param integer $val
   */
  public function SpaceW($val)
  {
    $this->SetXY($this->x + $val, $this->y);
  }
  
  /**
   * Adicionar espa�o vertical
   *
   * @param integer $val
   */
  public function SpaceH($val)
  {
    $this->SetXY($this->x, $this->y + $val);
  }
  
  /**
   * Nova linha
   *
   * @param integer $spTop
   * @param integer $spLeft
   */
  public function NewLine($spTop = 0, $spLeft = 0)
  {
    $this->y += ($this->lasth + $spTop);
    $this->x = ($this->lMargin + $spLeft);
  }
  
  /**
   * RenderImage
   *
   * @param unknown_type $param1
   * @return unknown
   */
  public function RenderImage($file, $img_w = 0, $img_h = 0)
  {
    $this->Image($file, null, null, $img_w, $img_h);
  }
  
  /**
   * Setar fonte
   *
   * @param string $fonte
   */
  protected function SetFonte($fonte)
  {
    // Ex.: Arial,8,BIU,#000000
    if ($fonte === false)
      return;
  
    $info = explode(',', $fonte);
    $this->SetFont($info[0], trim($info[2]), intval($info[1]));
  
    // Cor
    $c = $this->HexColor($info[3]);
    $this->SetTextColor($c['r'], $c['g'], $c['b']);
  }
  
  /**
   * Setar borda
   *
   * @param string $borda
   */
  protected function GetBorda($borda)
  {
    // Ex.: S,S,S,S,#000000,1
    if ($borda === false)
      return '';
  
    $info = $this->GetBordaInfo($borda);
  
    $borda  = ($info['left']   ? 'L' : '');
    $borda .= ($info['right']  ? 'R' : '');
    $borda .= ($info['top']    ? 'T' : '');
    $borda .= ($info['bottom'] ? 'B' : '');
  
    // Setar API de Borda
    $this->SetBordaApi($info);
  
    return $borda;
  }
  
  /**
   * Retorna informa��es da Borda
   *
   * @param string $borda
   */
  public function GetBordaInfo($borda)
  {
    // Ex.: S,S,S,S,#000000,1
    if ($borda === false)
      $borda = 'N,N,N,N,#000000,1';
  
    $info = explode(',', $borda);
    $res  = array();
  
    $res['left']   = ($info[0] == 'S');
    $res['right']  = ($info[1] == 'S');
    $res['top']    = ($info[2] == 'S');
    $res['bottom'] = ($info[3] == 'S');
    $res['color']  = $info[4];
    $res['width']  = intval($info[5]);
  
    return $res;
  }
  
  /**
   * Setar informa��es de Borda
   *
   * @param Array $info
   */
  public function SetBordaApi($info)
  {
    // Cor
    $c = $this->HexColor($info['color']);
    $this->SetDrawColor($c['r'], $c['g'], $c['b']);
  
    // Largura
    //...
  }
  
  /**
   * Seta cor de fundo
   *
   * @param string $cor
   */
  public function SetFundo($cor)
  {
    // Ex.: #000000
    if ($cor === false)
      return;
  
    $c = $this->HexColor($cor);
    $this->SetFillColor($c['r'], $c['g'], $c['b']);
  }
  
  /**
   * Retorna o RGB de uma cor
   *
   * @param string $hexcor
   * @return Array
   */
  public function HexColor($hexcolor)
  {
    if (strlen($hexcolor) != 7)
    {
      if ($hexcolor[0] != '#')
        $hexcolor = '#' . $hexcolor;
    }
    while (strlen($hexcolor) < 7)
      $hexcolor .= '0';
  
    $res      = array();
    $res['r'] = hexdec(substr($hexcolor, 1, 2));
    $res['g'] = hexdec(substr($hexcolor, 3, 2));
    $res['b'] = hexdec(substr($hexcolor, 5, 2));
  
    return $res;
  }

  public function SetCode($code){
    $this->code = $code;
  }
}
?>