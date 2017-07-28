<?
class nbrAdminForms {
  private $tableName;
  private $title;
  private $html_fields = array();
  private $fieldsName = array();
  private $fieldsDateName = array();
  private $fieldsImagesName = array();
  private $fieldsFileName = array();
  private $fieldsNumber = array();
  private $fieldsPassword = array();
  private $LkpMultselects = array();
  private $recordOpened = false;
  private $posts;
  private $links = array();
  
  public $record = array();
  
  function __construct($tableName){
    global $hub;
    $this->tableName = $tableName;
    $this->title = $hub->GetParam('title');
    
    //Se for um registro de uma coleção, adiciona campo oculto no formulário de ligação..
    if($hub->ExistParam('_fieldHidden')){
      $fieldHidden = explode('=', $hub->GetParam('_fieldHidden'));
      $this->AddFieldHidden($fieldHidden[0], $fieldHidden[1]);
    }
    
    //Se for edição abre registro..
    $this->_loadRecords();
  }
  
  private function getValue($fieldName, $valueDefault){
    global $dataSet;
    //verifica se tem no post valor do campo..
    if(isset($_POST[$fieldName]))
      return $_POST[$fieldName];
    
    //se não...
    if($this->recordOpened){
      $value = $this->record->$fieldName;
    } else 
      $value = $valueDefault;
          
    return $value;
  }

  private function _loadRecords(){
    global $hub, $db;

    if($hub->ExistParam('ID') && $hub->GetParam('ID') != -1) {

      $sql  = 'SELECT * FROM ';
      $sql .= $this->tableName;
      $sql .= ' WHERE ID=' . $hub->GetParam('ID');
      $res = $db->LoadObjects($sql);

      if(count($res) <= 0)
        throw new Exception('nbrAdminForms:: o registro que você tentou abrir no formulário não foi encontrado no banco de dados.' . $sql);
      else {
        $this->record = $res[0];
        $this->recordOpened = true;
      }
    }
  }

  private function eventAfterField($fieldName, $html){

    if(function_exists('macroFormAfterField')){

      if($this->Editing())
        $nHTML = macroFormAfterField($fieldName, $this->record);
      else
        $nHTML = macroFormAfterField($fieldName, null);

      if(!empty($nHTML))
        $html = $nHTML;
    }

    return $html;
  }

  public function AddGroup($title, $class = null, $id = null) {

    $html = '<div class="separator'. (!empty($class)?' ' . $class:null) . '" id="' . (!empty($id)?$id:null) . '">' . "\r\n";
    $html .= $title . "\r\n";
    $html .= '</div>' . "\r\n";
    
    $this->html_fields[] = $html;
  }
    
  public function AddDescriptionText($text, $class = nulll, $id = null){
    
    $html  = '<div class="description'. (!empty($class)?' ' . $class:null) . '" id="' . (!empty($id)?$id:null) . '">' . "\r\n";
    $html .= $text . "\r\n";
    $html .= '</div>' . "\r\n";
    
    $this->html_fields[] = $html;    
  }

  public function AddSpace($columns = 1){
    
    $html  = '<div class="spaceWhite col' . $columns . '">' . "\r\n";
    $html .= '</div>' . "\r\n";

    $this->html_fields[] = $html;
  }

  public function AddNewLine(){
    $html  = '<br>' . "\r\n";

    $this->html_fields[] = $html;
  }
  
  public function AddFieldString($fieldName, $legend, $length, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required', $mask = null){

    $val = $this->getValue($fieldName, $valueDefault);

    $tpl = new girafaTpl('forms/field-string.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('COLUMNS',     'col' . $columns);
    $tpl->setValue('MASK',        $mask);
    $tpl->setValue('READONLY',    ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('MAX',         $length);
    $tpl->setValue('VAL',         htmlspecialchars($val));
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;
  }

  public function AddFieldList($fieldName, $legend, $options, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required', $alphabeticalOrder = true){

    $value = $this->getValue($fieldName, $valueDefault);

    //Ordenar em Ordem Alfabética..
    if($alphabeticalOrder){
      $a = array();
      $b = array();
      $variaveis = explode('|', $options);
      foreach ($variaveis as $variavel) {
        $item = explode('=', $variavel);

        $a[$item[1]] = $item[0];
        $b[] = $item[1];
      }
      sort($b);

      $novaLista = array();
      foreach ($b as $n_b) {
        $chave = $a[$n_b];
        $novaLista[] = $chave . '=' . $n_b;
      }
      $options = implode('|', $novaLista);
    }


    $option_html = null;
    $options_array = explode('|', $options);
    foreach ($options_array as $option_array){
      $option = explode('=', $option_array);
      $option_html .= '<option '. ($value == $option[0]?'selected':null) . ' value="' . $option[0] . '">' . $option[1] . '</option>' . "\r\n";
    }

    $tpl = new girafaTpl('forms/field-list.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('COLUMNS',     'col' . $columns);
    $tpl->setValue('READONLY',    ($readOnly?'disabled':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('OPTIONS',     $option_html);
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;
  }

  public function AddFieldText($fieldName, $legend, $columns, $height, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){

    $val = $this->getValue($fieldName, $valueDefault);

    $tpl = new girafaTpl('forms/field-text.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('COLUMNS',     'col' . $columns);
    $tpl->setValue('READONLY',    ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('HEIGHT',      $height);
    $tpl->setValue('VAL',         htmlspecialchars($val));
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;
  }

  public function AddLkpMultselect($name, $title, $description, $tableName, $fieldPrimary, $tableSecondary, $fieldSecondary, $fieldSecondatyLegend, $wheres = null, $order = null, $columns = 2, $required = true, $readOnly = false, $fieldSecondatyOrder = null, $orderValueVariation = 10, $nroOrder = false){

    global $db;

    $this->AddGroup($title);
    $this->AddDescriptionText($description);

    /* OPTIONS */
    $options_html = null;
    //Seleciona já selecionados..

    if($this->Editing()){
      $sql  = "SELECT `$tableSecondary`.* FROM `$tableName` ";
      $sql .= " JOIN `$tableSecondary` ON(`$tableSecondary`.ID = `$tableName`.`$fieldSecondary`)";
      $sql .= " WHERE `$tableName`.`$fieldPrimary` = " . $this->record->ID;

      //where do parametro
      if(!empty($wheres))
        $sql .= " AND (" . $wheres . ")";

      //order
      if(!empty($order))
        $sql .= " ORDER BY $order";

      $res = $db->LoadObjects($sql);

      $selectedsIds = array();

      foreach ($res as $reg) {
        $item = array(
          'reg' =>   $reg,
          'selected' => true
        );
        $regs[] = $item;

        $selectedsIds[] = $reg->ID;
      }
    } else
      $selectedsIds = array();

    //Traz demais itens..
    $sql  = "SELECT * FROM `$tableSecondary`";


    if(count($selectedsIds) > 0)
      $a_wheres[] = "ID NOT IN(" . implode(',', $selectedsIds) . ")";


    //where do parametro
    if(!empty($wheres))
      $a_wheres[] = "(" . $wheres . ")";

    if(count($a_wheres) > 0){
      $sql .= ' WHERE ';
      $sql .= implode($a_wheres, ' AND ');
    }

    if(empty($fieldSecondatyOrder))
      $fieldSecondatyOrder = $fieldSecondatyLegend;

    $sql .= " ORDER BY `$fieldSecondatyOrder` ASC";

    $res = $db->LoadObjects($sql);

    foreach ($res as $reg) {
      $item = array(
                              'reg' =>   $reg,
                              'selected' => false
      );
      $regs[] = $item;
    }

    foreach ($regs as $x=>$reg) {

      $selected = $reg['selected'];
      $rg = $reg['reg'];

      if(!$nroOrder)
        $legend = $rg->$fieldSecondatyLegend;
      else {
        $legend = ($x + 1) . ' - ' . $rg->$fieldSecondatyLegend;
      }
      $options_html .= '<option ' . (($selected)?'selected':null) . ' value="' . $rg->ID . '">' . $legend . '</option>' . "\r\n";
    }

    $tpl = new girafaTpl('forms/field-lkpMultselect.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $name);
    $tpl->setValue('COLUMNS',     'col' . $columns);
    $tpl->setValue('READONLY',    ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('OPTIONS',     $options_html);
    $tpl->setValue('ORDER',       ($nroOrder)?'true':'false');
    $html = $tpl->GetHtml();

    //Cadastro LkpMultselect no array..
    $this->LkpMultselects[] = ($name . '|' . $tableName . '|' . $fieldPrimary . '|' . $tableSecondary . '|' . $fieldSecondary . '|' . $fieldOrder . '|' . $orderValueVariation);

    $html = $this->eventAfterField($name, $html);
    $this->html_fields[] = $html;
    //$this->fieldsName[] = $name;
  }

  public function AddFieldPassword($fieldName, $legend, $length, $required = true, $readOnly = false, $validType = 'required'){
    global $ADMIN_PAGES_PATH, $ADMIN_IMAGES_URL, $hub;
    if($this->Editing()){
      if(isset($_POST[$fieldName]))
        $val = null;
      else
        $val = '[NAOATUALIZAR]';
    } else
      $val = null;

    //Botao gerador
    $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'form.password.generator.php');
    $hub->SetParam('fieldName', $fieldName);
    $btn_gerar_url = $hub->GetUrl();



    $tpl = new girafaTpl('forms/field-password.tpl');
    $tpl->setValue('LEGEND',          $legend);
    $tpl->setValue('NAME',            $fieldName);
    $tpl->setValue('COLUMNS',         'col4');
    $tpl->setValue('READONLY',        ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',        ($required?'required':null));
    $tpl->setValue('MAX',             $length);
    $tpl->setValue('VAL',             htmlspecialchars($val));
    $tpl->setValue('BTN_GERAR_URL',   $btn_gerar_url);
    $tpl->setValue('ADMIN_IMAGES_URL',$ADMIN_IMAGES_URL);
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;
    $this->fieldsPassword[] = $fieldName;
  }

  public function AddFieldInteger($fieldName, $legend, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){

    $val = $this->getValue($fieldName, $valueDefault);

    $tpl = new girafaTpl('forms/field-integer.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('COLUMNS',     'col' . $columns);
    $tpl->setValue('READONLY',    ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('VAL',         htmlspecialchars($val));
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;
  }

  public function AddFieldHidden($fieldName, $value){

    $tpl = new girafaTpl('forms/field-hidden.tpl');
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('VAL',         htmlspecialchars($value));
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;
  }

  public function AddFieldNumber($fieldName, $legend, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){

    $value = $this->getValue($fieldName, $valueDefault);

    if(!empty($value)) {
      $value = (!is_numeric($value)) ? 0 : $value;
      $value = number_format($value, 2, ',', '');
    }

    $tpl = new girafaTpl('forms/field-number.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('COLUMNS',     'col' . $columns);
    $tpl->setValue('READONLY',    ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('VAL',         htmlspecialchars($value));
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;
    $this->fieldsNumber[] = $fieldName;

  }

  public function AddFieldImage($fieldName, $legend, $required = true, $readOnly = false){
    global $ADMIN_IMAGES_URL, $ADMIN_UPLOAD_PATH, $ADMIN_UPLOAD_URL;

    $isBlank = true;

    $img = $this->getValue($fieldName, null);

    if(empty($img)){
      $img = $ADMIN_IMAGES_URL . 'form_image_noimage.jpg';
      $isBlank = true;
      $txt_status = '';
      $link_zoom = null;
    } else {

      $imgFile = $ADMIN_UPLOAD_PATH . $img;
      $imgUrl = $ADMIN_UPLOAD_URL . $img;

      $img = nbrMagicImage::CreateThumbBackgroundCenter($imgFile, 600, 145);

      $isBlank = false;

      //Pega Tamanho do Arquivo..
      $bytes = filesize($imgFile);
      $bytes = number_format(($bytes / 1024 /1024), 2, ',', '.');

      //Pega dimensão da imagem..
      $imagesize = getimagesize($imgFile); // Pega os dados
      $x = $imagesize[0]; // 0 será a largura.
      $y = $imagesize[1]; // 1 será a altura.

      $txt_status = '<b>Tamanho:</b> ' . $bytes . 'mb. <b>Dimensão:</b> ' . $x . 'x' . $y . ' pixels.';

      $link_zoom  = '<a href="' . $imgUrl . '" title="Clique aqui para ampliar a imagem" class="fancybox">';
      $link_zoom .= '<img src="' . $ADMIN_IMAGES_URL . 'icon_form_zomm.png" class="img_zoom">';
      $link_zoom .= '</a>';
    }

    $tpl = new girafaTpl('forms/field-image.tpl');
    $tpl->setValue('LEGEND',            $legend);
    $tpl->setValue('NAME',              $fieldName);
    $tpl->setValue('COLUMNS',           'col4');
    $tpl->setValue('READONLY',          ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',          ($required?'required':null));
    $tpl->setValue('IMG',               $img);
    $tpl->setValue('ISBLANK',           ((!$isBlank)?null:'display: none;'));
    $tpl->setValue('ADMIN_IMAGES_URL',  $ADMIN_IMAGES_URL);
    $tpl->setValue('TXT_STATUS',        $txt_status);
    $tpl->setValue('ISBLANK_VALUE',     (($isBlank)?null:'N'));
    $tpl->setValue('LINK_ZOOM',         $link_zoom);
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->fieldsImagesName[] = $fieldName;
    $this->html_fields[] = $html;

  }

  public function AddFieldFile($fieldName, $legend, $required = true, $readOnly = false, $typesFile = '*.*', $typesFileDescription = 'Todos os Arquivos'){

    global $ADMIN_IMAGES_URL, $ADMIN_UPLOAD_PATH, $ADMIN_PAGES_PATH, $hub;

    $file = $this->getValue($fieldName, null);

    if(!empty($file)){
      $fileFull = $ADMIN_UPLOAD_PATH . $file;

      //Pega Tamanho do Arquivo..
      $bytes = filesize($fileFull);
      $bytes = number_format(($bytes / 1024 /1024), 2, ',', '.');

      $txt_status = '<b>Tamanho:</b> ' . $bytes . 'mb.';

    }

    //Download Link
    $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'form.down.php');
    $hub->SetParam('file', $file);
    $download_link = $hub->GetUrl();

    $tpl = new girafaTpl('forms/field-file.tpl');
    $tpl->setValue('LEGEND',            $legend);
    $tpl->setValue('NAME',              $fieldName);
    $tpl->setValue('COLUMNS',           'col4');
    $tpl->setValue('READONLY',          ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',          ($required?'required':null));
    $tpl->setValue('ADMIN_IMAGES_URL',  $ADMIN_IMAGES_URL);
    $tpl->setValue('TXT_STATUS',        $txt_status);
    $tpl->setValue('TXT_STATUS',        $txt_status);
    $tpl->setValue('DOWNLOAD_LINK',     $download_link);
    $tpl->setValue('TEM_ARQUIVO',       (empty($file))?'display:none':null);
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsFileName[] = $fieldName;

  }

  public function AddFieldHtml($fieldName, $legend, $height, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){

    $val = $this->getValue($fieldName, $valueDefault);

    $tpl = new girafaTpl('forms/field-html.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('COLUMNS',     'col4');
    $tpl->setValue('HEIGHT',      $height);
    $tpl->setValue('READONLY',    ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('VAL',         htmlspecialchars($val));
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;

  }

  public function AddFieldBoolean($fieldName, $legend, $columns = 1, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){
    $this->AddFieldList($fieldName, $legend, 'Y=Sim|N=Não', $columns, $valueDefault, $required, $readOnly, $validateType);
  }

  public function AddFieldDate($fieldName, $legend, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){

    if($valueDefault == 'NOW' || $valueDefault == 'TODAY'){
      $valueDefault = date('Y-m-d');
    }

    $dateValue = $this->getValue($fieldName, $valueDefault);

    if(!empty($dateValue)){
      $data = new nbrDate($dateValue, ENUM_DATE_FORMAT::YYYY_MM_DD);
      $dateValue = $data->GetDate('d/m/Y');
    } else
      $dateValue = '';

    $tpl = new girafaTpl('forms/field-date.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('COLUMNS',     'col1');
    $tpl->setValue('READONLY',    ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('VAL',         $dateValue);
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsDateName[] = $fieldName;
    $this->fieldsName[] = $fieldName;

  }

  public function AddFieldDateTime($fieldName, $legend, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){

    if($valueDefault == 'NOW' || $valueDefault == 'TODAY'){
      $valueDefault = date('Y-m-d H:i');
    }

    $dateValue = $this->getValue($fieldName, $valueDefault);

    if(!empty($dateValue)){
      $data = new nbrDate($dateValue, ENUM_DATE_FORMAT::YYYY_MM_DD_HH_II_SS);
      $dateValue = $data->GetDate('d/m/Y H:i');
    } else
      $dateValue = null;

    $tpl = new girafaTpl('forms/field-datetime.tpl');
    $tpl->setValue('LEGEND',      $legend);
    $tpl->setValue('NAME',        $fieldName);
    $tpl->setValue('COLUMNS',     'col1');
    $tpl->setValue('READONLY',    ($readOnly?'readonly':null));
    $tpl->setValue('REQUIRED',    ($required?'required':null));
    $tpl->setValue('VAL',         $dateValue);
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsDateName[] = $fieldName;
    $this->fieldsName[] = $fieldName;
  }

  public function AddFieldCustom($fieldName){

    $tpl = new girafaTpl('forms/field-custom.tpl');
    $tpl->setValue('NAME', $fieldName);
    $html = $tpl->GetHtml();

    $html = $this->eventAfterField($fieldName, $html);
    $this->html_fields[] = $html;
    $this->fieldsName[] = $fieldName;

  }

  public function AddFieldLkpList($fieldName, $legend, $linkTableName, $linkTableField, $linkWhere, $columns, $required = true, $readOnly = false, $linkTableField2 = null, $valueDefault = null){
    global $db;

    $sql = 'SELECT A.ID, A.' . $linkTableField . (($linkTableField2 != null)?', A.' . $linkTableField2:null) . ' FROM ' . $linkTableName . ' A';

    if($linkWhere != null)
      $sql .= ' WHERE ' . $linkWhere;

    $sql .= ' ORDER BY A.' . $linkTableField . ' ASC';

    //echo($sql);
    $res = $db->LoadObjects($sql);

    $options = null;

    foreach ($res as $x=>$reg) {

      if($x > 0)
        $options .= '|';

      $options .= $reg->ID . '=' . $reg->$linkTableField . (($linkTableField2 != null)?' - ' . $reg->$linkTableField2:null);
    }

    $this->AddFieldList($fieldName, $legend, $options, $columns, $valueDefault, $required, $readOnly);
  }

  public function AddCollections($title, $fileGrid, $linkTableName, $linkTableField, $showCount = true){
    global $hub, $db, $moduleObj;
    
    //Só exibe Coleções quando for edição..
    if($this->Editing()){
      
      if($showCount){
        $sql = 'SELECT COUNT(ID) TOTAL FROM ' . $linkTableName . ' WHERE `' . $linkTableField . '` = ' . $hub->GetParam('ID');
        $res = $db->LoadObjects($sql);
        $titleLink = $title . ' <sup>' . $res[0]->TOTAL . '</sup>';
      }
      else 
        $titleLink = $title;
      
      //Adiciona Link..
      $hub->SetParam('_page', $moduleObj->path . $fileGrid);
      $hub->SetParam('_title', $title);
      $hub->SetParam('_description', 'Coleção de ' . $title . ' do registro ' . $hub->GetParam('_title'));
      $hub->SetParam('_moduleID', $moduleObj->ID);
      $hub->SetParam('_folderID', $hub->GetParam('_folderID'));
      $hub->SetParam('_where', '`' . $linkTableField . '` = ' . $hub->GetParam('ID'));
      $hub->SetParam('_fieldHidden', $linkTableField . '=' . $hub->GetParam('ID'));
      $this->AddLink($titleLink, $hub->GetUrl());
    }
  }

  public function AddLink($title, $url, $target = '_self') {
    global $ADMIN_IMAGES_URL;
    
    $html  = '<img src="' . $ADMIN_IMAGES_URL . 'form_icon_link.gif" width="13" height="14" />';
    $html .= '<a href="' . $url . '" target="' . $target . '">' . $title . '</a>';
    $this->links[] = $html;
  }

  public function PrintHTML(){
    global $hub, $dataSet, $cms, $ADMIN_IMAGES_URL, $ADMIN_PAGES_PATH, $SITEKEY, $cookie_save_name, $MODULES_URL, $MODULES_PATH;
    
    $html  = null;
    
    /** Verifica se existe JS ou CSS com o mesmo nome **/
    $url_array = explode('/', $hub->GetParam('_page'));
    $url_array = array_slice($url_array, -2);
    
    $url_modulo = $MODULES_URL . $url_array[0] . '/'; 
    $path_modulo = $MODULES_PATH . $url_array[0] . '/';
    
   
    $css = substr($url_array[1] , 0, -4) . '.css';
    if(file_exists($path_modulo . $css)){
    	echo('<link href="' . $url_modulo . $css . '" rel="stylesheet" type="text/css" />' . "\r\n");
    }

    $js = substr($url_array[1] , 0, -4) . '.js';
    if(file_exists($path_modulo . $js)){
    	echo('<script src="' . $url_modulo . $js . '" type="text/javascript"></script>' . "\r\n");
    }    
    
    if($dataSet->ExistParam('msgSucess')){
      $msg = $dataSet->GetParam('msgSucess');
      $html .= '<div id="msg_sucesso">' . $msg . "\r\n";
      $html .= '<img src="' . $cms->GetAdminImageUrl() . 'msg_sucesso_close.png" width="12" heigth="12" id="msg_sucesso_close" class="alphaOut">' . "\r\n";
      $html .= '</div>' . "\r\n";
      $dataSet->DeleteParam('msgSucess');
    }
    
    if($dataSet->ExistParam('msgError')){
      $msg = $dataSet->GetParam('msgError');
      $html .= '<div id="msg_erro">';
      $html .= $dataSet->GetParam('msgError');
      $html .= '<img src="' . $cms->GetAdminImageUrl() . 'msg_erro_close.png" width="12" heigth="12" id="msg_erro_close" class="alphaOut">' . "\r\n";
      
      if($dataSet->ExistParam('msgErrorDetail')) {
        $msgDetail = $dataSet->GetParam('msgErrorDetail');
        $dataSet->DeleteParam('msgErrorDetail');
        $html .= '<i class="fa fa-info" aria-hidden="true" title="' . $msgDetail . '"id="detail"></i>' . "\r\n";
      }
      
      
      $html .= '</div>' . "\r\n";
      $dataSet->DeleteParam('msgError');
    }
    
    //Variáveis para Usar no form.js
    $html .= '<script type="text/javascript">' . "\r\n";
    $html .= 'var imgSending = "' . $ADMIN_IMAGES_URL  . 'form_image_sending.jpg";' . "\r\n";
    $html .= 'var imgNo = "' . $ADMIN_IMAGES_URL . 'form_image_noimage.jpg";' . "\r\n";
    
    $html .= '</script>' . "\r\n";
    
    $html .= '<h1>' . $this->title . '</h1>' . "\r\n";
    $html .= '<span id="stack">' . $hub->GetStackString() . '</span>';    
    $html .= '<div id="boxForm">' . "\r\n";
    
    $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'form.post.php');
    $hub->SetParam('fields', implode(',', $this->fieldsName));
    $hub->SetParam('fieldsDate', implode(',', $this->fieldsDateName));
    $hub->SetParam('fieldsPassword', implode(',', $this->fieldsPassword));
    $hub->SetParam('fieldsImage', implode(',', $this->fieldsImagesName));
    $hub->SetParam('fieldsFile', implode(',', $this->fieldsFileName));
    $hub->SetParam('fieldsNumber', implode(',', $this->fieldsNumber));
    $hub->SetParam('tableName', $this->tableName);
    $hub->SetParam('ID', $hub->GetParam('ID'));
    $hub->SetParam('_modulePath', $hub->GetParam('_modulePath'));
    $hub->SetParam('fileMacro', $hub->GetParam('fileMacro'));
    $hub->SetParam('LkpMultselects', implode(',', $this->LkpMultselects));
    $hub->SetParam('_languages',$hub->GetParam('_languages'));
    
    //urls de submissão de fomrulário...
    $html .= '<script type="text/javascript">' . "\r\n";
    
    $hub->SetParam('action', 'S'); //salvar
    $urlFormS = $hub->GetUrl(false);
    $html .= 'var submitS = "' . $urlFormS . '";' . "\r\n";

    $hub->SetParam('action', 'SN'); //salvar e novo
    $urlFormSN = $hub->GetUrl(false);
    $html .= 'var submitSN = "' . $urlFormSN . '";' . "\r\n";

    $hub->SetParam('action', 'SV'); //salvar e voltar
    $urlFormSV = $hub->GetUrl(false);
    $html .= 'var submitSV = "' . $urlFormSV . '";' . "\r\n";

    $html .= '</script>' . "\r\n";
    
    //verifica qual o padrão..
    switch ($_COOKIE[$cookie_save_name]) {
      case 'S':  $formURL =  $urlFormS;  break;
      case 'SN': $formURL =  $urlFormSN; break;
      case 'SV': $formURL =  $urlFormSV; break;
    }
    
    
    $html .= '<form method="post" enctype="multipart/form-data" name="formulario" id="formulario" action="' . $formURL . '">' . "\r\n";
    
    /** Lista Campos **/
    $html .= implode("\r\n", $this->html_fields);
    
    //Links..
    if(count($this->links) > 0){
      $html .= '<ul id="link">' . "\r\n";
      
      foreach ($this->links as $link) {
      	$html .= '<li>' . $link . '</li>';
      }
      
      $html .= '</ul>' . "\r\n";
    }
    
    //Fecha Formulário...
        
    //Barra de Tarefas..
    $html .= '<div id="formToolbar">' . "\r\n";
    $html .= '<ul>' . "\r\n";

    /** Botão VOLTAR **/
    $hub->BackLevel(2);
    $html .= '<li><button class="btn red back" id="back" type="button" icon="ui-icon-arrowreturnthick-1-w" link="' . $hub->GetUrl() . '" title="Ctrl + Seta Esquerda">Voltar</button></li>' . "\r\n";    
    
    /** Botão SALVAR **/
   
   
    switch ($_COOKIE[$cookie_save_name]) {
      case 'S':  
        $save_btn_1_title = 'Salvar';
        $save_btn_1_name  = 'btnSave';
        $save_btn_1_alt   = '(ctrl + s)';
        $save_btn_2_title = 'Salvar e Voltar';
        $save_btn_2_url   = 'submitSV';
        $save_btn_2_name  = 'btnSaveBack';        
        $save_btn_2_alt   = '(ctrl + shift + seta esquerda)';        
        $save_btn_3_title = 'Salvar e Novo';
        $save_btn_3_url   = 'submitSN';
        $save_btn_3_name  = 'btnSaveNew';      
        $save_btn_3_alt   = '(ctrl + shift + seta acima)';        
        break;

      case 'SV':  
        $save_btn_1_title = 'Salvar e Voltar';
        $save_btn_1_name  = 'btnSaveBack';
        $save_btn_1_alt   = '(ctrl + shift + seta esquerda)';        
        $save_btn_2_title = 'Salvar';
        $save_btn_2_url   = 'submitS';
        $save_btn_2_name  = 'btnSave';
        $save_btn_2_alt   = '(ctrl + s)';
        $save_btn_3_title = 'Salvar e Novo';
        $save_btn_3_url   = 'submitSN';
        $save_btn_3_name  = 'btnSaveNew';
        $save_btn_3_alt   = '(ctrl + shift + seta acima)';
        break;
                
      case 'SN':  
        $save_btn_1_title = 'Salvar e Novo';
        $save_btn_1_name  = 'btnSaveNew';
        $save_btn_1_alt   = '(ctrl + shift + seta acima)';
        $save_btn_2_title = 'Salvar';
        $save_btn_2_url   = 'submitS';
        $save_btn_2_name  = 'btnSave';
        $save_btn_2_alt   = '(ctrl + s)';
        $save_btn_3_title = 'Salvar e Voltar';
        $save_btn_3_url   = 'submitSV';
        $save_btn_3_name  = 'btnSaveBack';
        $save_btn_3_alt   = '(ctrl + shift + seta esquerda)';
        break;        
    }
    
    $html .= '<li><div><button type="submit" id="save" class="btn green ' . $save_btn_1_name . '" title="' . $save_btn_1_alt . '">' . $save_btn_1_title . '</button>' . "\r\n";
    $html .= '  <button id="save2" class="btn green" type="button">.</button></div>' . "\r\n";
    $html .= '  <ul id="saveMenu">' . "\r\n";
    $html .= '    <li><a onclick="formURLSubmit(' . $save_btn_2_url . ');" href="javascript:void(0)" class="' . $save_btn_2_name . '" title="' . $save_btn_2_alt . '">' . $save_btn_2_title . '</a></li>' . "\r\n";
    $html .= '    <li><a onclick="formURLSubmit(' . $save_btn_3_url . ');" href="javascript:void(0)" class="' . $save_btn_3_name . '" title="' . $save_btn_3_alt . '">' . $save_btn_3_title . '</a></li>' . "\r\n";
    $html .= '  </ul>' . "\r\n";
    $html .= '</li>' . "\r\n";
    
    $html .= '</ul>' . "\r\n";
    $html .= '</div>' . "\r\n";

    /*
    $html .= "<script type='text/javascript'>" . "\r\n";
    $html .= "$(document).ready(function() {" . "\r\n";
    $html .= "   $('#arquivo').fileUpload({" . "\r\n";
    $html .= "      'uploader': 'javascripts/jquery.fileupload/uploader.swf'," . "\r\n";
    $html .= "      'cancelImg': 'javascripts/jquery.fileupload/cancel.png'," . "\r\n";
    $html .= "      'folder': 'temp'," . "\r\n";
    $html .= "      'script': 'upload.php'," . "\r\n";
    $html .= "      'fileDesc': 'Image Files'," . "\r\n";
    $html .= "      'fileExt': '*.*'," . "\r\n";
    $html .= "      'multi': true," . "\r\n";
    $html .= "      'auto': true," . "\r\n";
    $html .= "      'scriptData' : {'variavel':'alguma-variavel-de-controle'}" . "\r\n";
    $html .= "   });" . "\r\n";
    $html .= "});" . "\r\n";
    $html .= "</script>" . "\r\n";
    $html .= "<style>" . "\r\n";

    $html .= "</style>" . "\r\n";
 
 
    $html .= "<h1>JQuery FileUpload - Exemplo</h1>" . "\r\n";
 
    $html .= "<h2>Envio multiplo, autostart e apenas imagens</h2>" . "\r\n";
    $html .= "<p><input name='arquivo' id='arquivo' type='file' /></p>" . "\r\n";
*/
    $html .= '</form>' . "\r\n";
    $html .= '</div>' . "\r\n"; //Fecha boxForm
    
    /**
     * Dados para Desenvolvedores..
     */
    if($this->recordOpened){
      $lastUpdate = new nbrDate($this->record->LastUpdate, ENUM_DATE_FORMAT::YYYY_MM_DD_HH_II_SS);
      $html .= '<span id="devenv">' . sprintf(__('Você está editando o registro <u>%s</u> da tabela <u>%s</u>.'), $this->record->ID, $this->tableName) . '</span>' . "\r\n";
      $html .= '<span id="devenv">Este registro foi atualizado pela última vez em <u>' . $lastUpdate->GetFullDateForShorten() . '</u> às <u>' . $lastUpdate->GetDate('H:i') . '</u> por <u>' . $this->record->LastUserName . '</u>.</span>' . "\r\n";
    } else
      $html .= '<span id="devenv">' . sprintf(__('Você está inserindo um novo registro na tabela %s.'), $this->tableName). '</span>' . "\r\n";

    echo($html);
  }
  
  public function Editing(){
    return $this->recordOpened;
  }

}
?>