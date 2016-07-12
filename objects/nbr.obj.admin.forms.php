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
  private function addField($type, $fieldName, $legend, $length, $columns, $valueDefault, $required, $readOnly, $height = -1, $options = null, $required_str = 'required', $fileType = null, $fileTypesDescription = null, $mask = null){
    global $ADMIN_IMAGES_URL, $ADMIN_UPLOAD_PATH, $hub,$ADMIN_PAGES_PATH, $ADMIN_UPLOAD_URL;
    
    //Traduz colunas...
    switch ($columns) {
    	case 1: $columnsStr = 'oneColumn'; break;
    	case 2: $columnsStr = 'twoColumn'; break;
    	case 3: $columnsStr = 'threeColumn'; break;
    }
    
    switch ($type) {

      case 'STR':
        $val = $this->getValue($fieldName, $valueDefault);
        $html  = '<div id="' . $fieldName . '" class="field string ' . $columnsStr . ' ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
        $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
        $html .= '<input ' . ($readOnly?'readonly':null) . ' class="' . ($required?$required_str:null) . '" ' . ($readOnly?' title="' . $val . '" ':null) . ' type="text" name="' . $fieldName. ($readOnly?'_disabled':null) . '" id="' . $fieldName. '" value="' . htmlspecialchars($val) . '" maxlength="' . $length. '" ' . (!empty($mask)?'mask="' . $mask . '"':null) . ' />' . "\r\n";
        $html .= '</div>' . "\r\n";   
        $this->fieldsName[] = $fieldName; 		
    		break;
    		
    	case 'PSW':
    	  
    	  if($this->Editing()){
      	  if(isset($_POST[$fieldName]))
      	    $val = null;
      	  else
      	    $val = '[NAOATUALIZAR]';
    	  } else 
    	    $val = null;

        $html  = '<div  id="' . $fieldName . '" class="field password ' . $columnsStr . ' ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
        $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
        
        $html .= '<input ' . ($readOnly?'disabled':null) . ' class="' . ($required?$required_str:null) . ' senha1" type="password" name="' . $fieldName. ($readOnly?'_disabled':null) . '" id="' . $fieldName. '" value="' . $val . '" maxlength="' . $length. '"></input>' . "\r\n";
        
        //Confirmar Senha..
        $html .= '<input disabled class="' . ($required?$required_str:null) . ' senha2 disabled" type="password" name="' . $fieldName. ($readOnly?'_disabled':null) . '_confirmacao" id="' . $fieldName. '" value="' . $val . '" maxlength="' . $length. '"></input>' . "\r\n";
        
        //Botao gerador
        $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'form.password.generator.php');
        $hub->SetParam('fieldName', $fieldName);
        //
        $html .= '<a href="' . $hub->GetUrl()  . '" class="geradorSenha iframe"><img title="Clique aqui para abrir o gerador de senha" src="' . $ADMIN_IMAGES_URL . 'form_field_password_generator.gif" width="48" height="31"></a>' . "\r\n";
        
        $html .= '</div>' . "\r\n";
        $this->fieldsName[] = $fieldName; 
        $this->fieldsPassword[] = $fieldName;
    		break;    		

    	case 'FIL':
    	  $file = $this->getValue($fieldName, null);
    	  
        $isBlank = empty($file);
        
        if(!$isBlank){
          $fileFull = $ADMIN_UPLOAD_PATH . $file;
          
          //Pega Tamanho do Arquivo..
          $bytes = filesize($fileFull);
          $bytes = number_format(($bytes / 1024 /1024), 2, ',', '.');
  
          $txt_status = '<b>Tamanho:</b> ' . $bytes . 'mb.';
        }
            	  
    	  $html  = '<div  id="campo_' . $fieldName . '" class="field file ' . $columnsStr . ' ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
        $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";

        $html .= '<div class="esquerda">' . "\r\n";

    	  //Streaming..
        $html .= '<div class="boxFileStreaming">' . "\r\n";
        $html .= '<input   table="' . $this->tableName . '" fieldName="' . $fieldName . '" fileTypes="' . $fileType . '" fileTypesDescription="' . $fileTypesDescription . '" class="arquivo" ' . ($readOnly?'disabled':null) . ' type="file" name="' . $fieldName . '" id="' . $fieldName. '"  />' . "\r\n";
        $html .= '<input type="hidden" name="' . $fieldName. '_status" id="' . $fieldName. '_status" value="Y">';
        $html .= '<div id="barra" ' . ((!$isBlank)?'class="file"':null) . '>' . ((!$isBlank)?$file:null) . '</div>';
        $html .= '</div>' . "\r\n";

        //Painel Editar...
        if(!$isBlank){
          $html .= '<div class="painel">' . "\r\n";
      	  $html .= '<span class="status">' . "\r\n";
          $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'form.down.php');
      	  $hub->SetParam('file', $file);
      	  $html .= '<a href="' . $hub->GetUrl() . '" title="Clique aqui para baixar este arquivo"><img style="' . ((!$isBlank)?null:'display: none;')  . '" class="down" src="' . $ADMIN_IMAGES_URL . 'botao_input_down.gif" title="Clique aqui para baixar este arquivo"></a>' . "\r\n";
      	  $html .= '<img style="' . ((!$isBlank)?null:'display: none;')  . '" class="delete" src="' . $ADMIN_IMAGES_URL . 'icon_form_image_delete.png" title="Limpar este campo">' . "\r\n";
      	  $html .= '<span class="txt">' . $txt_status . '</span>' . "\r\n";        
      	  $html .= '</span>' . "\r\n";            	  
      	  $html .= '</div>' . "\r\n";            	  
        }
    	  
        $html .= '</div>' . "\r\n";
        
        
        /*
    	  $html .= '<div class="painel">' . "\r\n";
    	  $html .= '<span class="status">' . "\r\n";
    	  
    	  $hub->SetParam('_page', $moduleObj->path . 'form.down.php');
    	  $hub->SetParam('file', $img);
    	  $html .= '<a href="' . $hub->GetUrl() . '" title="Clique aqui para baixar este arquivo"><img style="' . ((!$isBlank)?null:'display: none;')  . '" class="down" src="' . $ADMIN_IMAGES_URL . 'botao_input_down.gif" title="Clique aqui para baixar este arquivo"></a>' . "\r\n";
    	  $html .= '<img style="' . ((!$isBlank)?null:'display: none;')  . '" class="delete" src="' . $ADMIN_IMAGES_URL . 'icon_form_image_delete.png" title="Limpar este campo">' . "\r\n";
    	  $html .= '<span class="txt">' . $txt_status . '</span>' . "\r\n";        
    	  $html .= '</span>' . "\r\n";        
        $html .= '<img class="btn_upload" src="' . $ADMIN_IMAGES_URL . 'form_file_upload.gif">' . "\r\n";        
        $html .= '<input class="arquivo" ' . ($readOnly?'disabled':null) . ' type="file" name="' . $fieldName . '" id="' . $fieldName. '"></input>' . "\r\n";
        $html .= '<input ' . ($readOnly?'disabled':null) . ' class="_status ' . ($required?$required_str:null) . '" type="hidden" name="' . $fieldName . '_status" id="' . $fieldName. '_status" value="' . (($isBlank)?null:'N') . '" ></input>' . "\r\n";
        $html .= '</div>' . "\r\n";    
        */
        $html .= '</div>' . "\r\n";    
        $this->fieldsFileName[] = $fieldName;	
    		break;
    		
      case 'IMG':
        $isBlank = true;
        $img = $this->getValue($fieldName, null);
        
        if(empty($img)){
          $img = $ADMIN_IMAGES_URL . 'form_image_noimage.jpg';
          $isBlank = true;
          $txt_status = 'Sem Imagem';
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

        $html  = '<div  id="' . $fieldName . '" class="field image ' . $columnsStr . ' ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
        $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
        $html .= '<div class="img" style="background-image:url(' . $img . ');">' . "\r\n";
        $html .= $link_zoom;
        
        $html .= '<img style="' . ((!$isBlank)?null:'display: none;')  . '" class="delete" src="' . $ADMIN_IMAGES_URL . 'icon_form_image_delete.png" title="Limpar este campo">' . "\r\n";
        
        $html .= '</div>' . "\r\n";
        $html .= '<div class="painel">' . "\r\n";

        $html .= '<span class="status">' . $txt_status . '</span>' . "\r\n";        
        $html .= '<img class="btn_upload" src="' . $ADMIN_IMAGES_URL . 'form_image_upload.gif">' . "\r\n";        
        $html .= '<input ' . ($readOnly?'disabled':null) . ' type="file" name="' . $fieldName . '" id="' . $fieldName. '"></input>' . "\r\n";
        $html .= '<input ' . ($readOnly?'disabled':null) . ' class="_status ' . ($required?$required_str:null) . '" type="hidden" name="' . $fieldName . '_status" id="' . $fieldName. '_status" value="' . (($isBlank)?null:'N') . '" ></input>' . "\r\n";

        $html .= '</div>' . "\r\n";        
        $html .= '</div>' . "\r\n";    	
        
        $this->fieldsImagesName[] = $fieldName;	
    		break;
    		
    	case 'INT':
    	    $html  = '<div  id="' . $fieldName . '" class="field ' . $columnsStr . ' integer ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
          $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
          $html .= '<input ' . ($readOnly?'disabled':null) . ' onkeyup="onlyInteger(this);" type="text" name="' . $fieldName. ($readOnly?'_disabled':null) . '" id="' . $fieldName. '" value="' . $this->getValue($fieldName, $valueDefault) . '"  maxlength="' . $length. '"></input>' . "\r\n";
          $html .= '</div>' . "\r\n";
          $this->fieldsName[] = $fieldName;
    	  break;
    	  
    	case 'TXT':
          $html  = '<div class="field ' . $columnsStr . ' textarea ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '" id="' . $fieldName. '" >' . "\r\n";
          $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
          $html .= '<textarea class="' . ($required?'required':null) . '" ' . ($readOnly?'disabled':null) . ' id="texto" id="' . $fieldName. '" name="' . $fieldName. ($readOnly?'_disabled':null) . '" style="height:' . $height . 'px">' . $this->getValue($fieldName, $valueDefault) . '</textarea>' . "\r\n";
          $html .= '<div class="clearBoth"></div>';
          $html .= '</div>' . "\r\n";   
          $this->fieldsName[] = $fieldName;       
    	  break;    	  
    	
    	case 'HTM':
          $html  = '<div  id="' . $fieldName . '" class="field ' . $columnsStr . ' html ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
          $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
          $html .= '<textarea class="' . ($required?'required':null) . '" ' . ($readOnly?'disabled':null) . ' id="' . $fieldName. '" name="' . $fieldName. ($readOnly?'_disabled':null) . '" style="height:' . $height . 'px">' . $this->getValue($fieldName, $valueDefault) . '</textarea>' . "\r\n";
          $html .= '<div class="clearBoth"></div>';
          $html .= '</div>' . "\r\n";      
          $this->fieldsName[] = $fieldName;    
    	  break;
    	  
    	case 'LST':
    	    $value = $this->getValue($fieldName, $valueDefault);
          $html  = '<div  id="' . $fieldName . '" class="field ' . $columnsStr . ' list ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
          $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
          $html .= '<select ' . ($readOnly?'disabled':null) . ' class="' . ($required?$required_str:null) . '" name="' . $fieldName . ($readOnly?'_disabled':null) . '">' . "\r\n";
          $html .= '<option value=""></option>' . "\r\n";
          
          $options_array = explode('|', $options);
          foreach ($options_array as $option_array){
            $option = explode('=', $option_array);
            $html .= '<option '. ($value == $option[0]?'selected':null) . ' value="' . $option[0] . '">' . $option[1] . '</option>' . "\r\n";
          }
          $html .= '</select>' . "\r\n";
          $html .= '</div>' . "\r\n";    
          $this->fieldsName[] = $fieldName;      
          break;
      
    	case 'HID':
    	  $html = '<input type="hidden"  class="' . ($required?$required_str:null) . '" name="' . $fieldName . '" value="' . $valueDefault . '">';  
    	  $this->fieldsName[] = $fieldName;
    	  break;    
    	  
    	case 'DTT' :
    	  $dateValue = $this->getValue($fieldName, $valueDefault);
    	  
    	  if(!empty($dateValue)){
    	    $data = new nbrDate($dateValue, ENUM_DATE_FORMAT::YYYY_MM_DD_HH_II_SS);
    	    $dateValue = $data->GetDate('d/m/Y H:i');
    	  } else 
    	    $dateValue = null;
    	    
        $html  = '<div  id="dv_' . $fieldName . '" class="field datetime ' . $columnsStr . ' ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
        $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
        $html .= '<input ' . ($readOnly?'disabled':null) . ' class="" ' . ($required?$required_str:null) . ' type="text" name="' . $fieldName. ($readOnly?'_disabled':null) . '" id="' . $fieldName. '" value="' . $dateValue . '" maxlength="' . $length. '"></input>' . "\r\n";
        $html .= '</div>' . "\r\n";   
        
        $this->fieldsDateName[] = $fieldName;
        $this->fieldsName[] = $fieldName;

    	  break;
    	  
    	case 'DAT' :
    	  $dateValue = $this->getValue($fieldName, $valueDefault);
    	  
    	  if(!empty($dateValue)){
    	    $data = new nbrDate($dateValue, ENUM_DATE_FORMAT::YYYY_MM_DD);
    	    $dateValue = $data->GetDate('d/m/Y');
    	  } else 
    	    $dateValue = '';
    	    
        $html  = '<div  id="dv_' . $fieldName . '" class="field date ' . $columnsStr . ' ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
        $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
        $html .= '<input ' . ($readOnly?'disabled':null) . ' class="" ' . ($required?$required_str:null) . ' type="text" name="' . $fieldName. ($readOnly?'_disabled':null) . '" id="' . $fieldName. '" value="' . $dateValue . '" maxlength="' . $length. '"></input>' . "\r\n";
        $html .= '</div>' . "\r\n";    		
        
        $this->fieldsDateName[] = $fieldName;
        $this->fieldsName[] = $fieldName;

    	  break;
    	  
    	case 'NUM':
    	  $value = $this->getValue($fieldName, $valueDefault);
    	  $value = (!is_numeric($value))?0:$value;
    	  $value = number_format($value, 2, ',', '');
    	  
        $html  = '<div  id="' . $fieldName . '" class="field number ' . $columnsStr . ' ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
        $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
        $html .= '<input ' . ($readOnly?'disabled':null) . ' class="' . ($required?$required_str:null) . '" type="text" name="' . $fieldName. ($readOnly?'_disabled':null) . '" id="  ' . $fieldName. '" value="' . $value . '"></input>' . "\r\n";
        $html .= '</div>' . "\r\n";
        $this->fieldsName[] = $fieldName;
        $this->fieldsNumber[] = $fieldName;
    		break;

    	case 'CUS':
        $val = $this->getValue($fieldName, $valueDefault);
        /*$html  = '<div class="field string ' . $columnsStr . ' ' . ($required?'required':null) . ' ' . ($readOnly?'disabled':null) . '">' . "\r\n";
        $html .= '<label class="legend">' . $legend . '</label>' . "\r\n";
        $html .= '<input ' . ($readOnly?'readonly':null) . ' class="' . ($required?$required_str:null) . '" ' . ($readOnly?' title="' . $val . '" ':null) . ' type="text" name="' . $fieldName. ($readOnly?'_disabled':null) . '" id="' . $fieldName. '" value="' . $val . '" maxlength="' . $length. '"></input>' . "\r\n";
        $html .= '</div>' . "\r\n";   */
        
        $html = '<div>Aqui ficará o campo Customizado - ' . $fieldName . '</div>';
        
        $this->fieldsName[] = $fieldName; 		    	  
    		break;    		
    	  
    	default:
    		break;
    }
    
    //se for "Somente Leitutra" adiciona hidden com o valor
    if($readOnly)
      $html .= '<input type="hidden"  class="' . ($required?$required_str:null) . '" name="' . $fieldName . '" value="' . $this->getValue($fieldName, $valueDefault) . '">';
    
      
    //Verifica se existe evento macroFromFields na macro...
    if(function_exists('macroFromFields')){

      $nHTML = macroFromFields($fieldName, $this->record, $legend, $length, $columns, $valueDefault, $required, $readOnly, $height, $options, $required_str, $fileType, $fileTypesDescription);

      if(!empty($nHTML))
      $html = $nHTML;
    }
      
    $this->html_fields[] = $html;
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
  
  /**
   * Adiciona Agrupador ao formulário
   *
   * @param string $title
   */
  public function AddGroup($title, $class = null, $id = null) {
    
    $html  = '<div class="separator'. (!empty($class)?' ' . $class:null) . '" id="' . (!empty($id)?$id:null) . '">' . "\r\n";
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
  
  /**
   * Adiciona Espaços em branco
   *
   * @param integer $columns
   */
  public function AddSpace($columns = 1){
    
    switch ($columns) {
    	case 1: $columnsStr = 'oneColumn';break;
    	case 2: $columnsStr = 'twoColumn';break;
    	case 3: $columnsStr = 'threeColumn';break;
    }
    
    $html  = '<div class="spaceWhite ' . $columnsStr . '">' . "\r\n";
    $html .= '</div>' . "\r\n";

    $this->html_fields[] = $html;
  }
  
  /**
   * Adiciona Campos do tipo String no formulário
   *
   * @param string $fieldName
   * @param string $legend
   * @param integer $length
   * @param string $valueDefault
   * @param string $columns
   * @param boolean $required
   * @param boolean $readOnly
   */
  public function AddFieldString($fieldName, $legend, $length, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required', $mask = null){
    $this->addField('STR', $fieldName, $legend, $length, $columns, $valueDefault, $required, $readOnly, -1, null, $validateType, null, null, $mask);
  }
  
  public function AddFieldPassword($fieldName, $legend, $length, $columns = 2, $required = true, $readOnly = false, $validType = 'required'){
    $this->addField('PSW', $fieldName, $legend, $length, $columns, '', $required, $readOnly, -1, null, $validType);
  }
  
  public function AddFieldNumber($fieldName, $legend, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){
    $this->addField('NUM', $fieldName, $legend, -1, $columns, $valueDefault, $required, $readOnly, -1, null, $validateType);
  }
  
  public function AddFieldImage($fieldName, $legend, $required = true, $readOnly = false){
    $this->addField('IMG', $fieldName, $legend, -1, 3, null, $required, $readOnly, -1, null, 'required');
  }
  
  
  public function AddFieldFile($fieldName, $legend, $required = true, $readOnly = false, $typesFile = '*.*', $typesFileDescription = 'Todos os Arquivos'){
    $this->addField('FIL', $fieldName, $legend, -1, 3, null, $required, $readOnly, -1, null, 'required', $typesFile, $typesFileDescription);
  }
  
  
  public function AddFieldInteger($fieldName, $legend, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){
    $this->addField('INT', $fieldName, $legend, 11, $columns, $valueDefault, $required, $readOnly, -1, null, $validateType);
  }
  
  public function AddFieldText($fieldName, $legend, $columns, $height, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){
    $this->addField('TXT', $fieldName, $legend, 0, $columns, $valueDefault, $required,$readOnly, $height, null,$validateType);
  }
  
  /**
   * Adiciona Coleções a este registro..
   *
   * @param string $title
   * @param string $fileGrid
   * @param string $linkTableName
   * @param string $linkTableField
   */
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
  
  public function AddFieldHtml($fieldName, $legend, $columns, $height, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){
    $this->addField('HTM', $fieldName, $legend, 0, $columns, $valueDefault, $required, $readOnly, $height, null, $validateType);
  }
  
  public function AddFieldList($fieldName, $legend, $options, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required', $alphabeticalOrder = true){
    
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
    
    $this->addField('LST', $fieldName, $legend, 0, $columns, $valueDefault, $required, $readOnly, -1, $options, $validateType);
  }
  
  public function AddFieldBoolean($fieldName, $legend, $columns = 1, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){
    $this->AddFieldList($fieldName, $legend, 'Y=Sim|N=Não', $columns, $valueDefault, $required, $readOnly, $validateType);
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
  
  public function AddFieldDateTime($fieldName, $legend, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){
    if($valueDefault == 'NOW'){
      $valueDefault = date('Y-m-d H:i');
    }
    $this->addField('DTT', $fieldName, $legend, 16,$columns, $valueDefault, $required, $readOnly, -1, null, $validateType);
  }
  
  public function AddFieldDate($fieldName, $legend, $columns, $valueDefault = null, $required = true, $readOnly = false, $validateType = 'required'){
    if($valueDefault == 'NOW'){
      $valueDefault = date('Y-m-d');
    }
    $this->addField('DAT', $fieldName, $legend, 16,$columns, $valueDefault, $required, $readOnly, -1, null, $validateType);
  }  
  
  public function AddFieldHidden($fieldName, $value){
    $this->addField('HID', $fieldName, null, 0, 0, $value, true, false);
  }
  
  public function AddLink($title, $url, $target = '_self') {
    global $ADMIN_IMAGES_URL;
    
    $html  = '<img src="' . $ADMIN_IMAGES_URL . 'form_icon_link.gif" width="13" height="14" />';
    $html .= '<a href="' . $url . '" target="' . $target . '">' . $title . '</a>';
    $this->links[] = $html;
  }
  
  public function AddLkpMultselect($name, $title, $description, $tableName, $fieldPrimary, $tableSecondary, $fieldSecondary, $fieldSecondatyLegend, $wheres = null, $order = null, $columns = 2, $required = true, $readOnly = false, $fieldOrder = null, $orderValueVariation = 10){
    
    global $db;
    
    //Traduz colunas...
    switch ($columns) {
    	case 1: $columnsStr = 'oneColumn'; break;
    	case 2: $columnsStr = 'twoColumn'; break;
    	case 3: $columnsStr = 'threeColumn'; break;
    }    
    
    //monta html...
    $this->AddGroup($title);
    $this->AddDescriptionText($description);
    
    $html  = '<div class="lkp_multselect">' . "\r\n";
    
    $html .= '<select sortable="' . (empty($fieldOrder)?'false':'true') . '"  multiple="multiple" name="' . $name . '[]" class="multiselect " ' . ($required?'required':null) . ' id="' . $name. '" >' . "\r\n";
    
    //Seleciona já selecionados..
    
    if($this->Editing()){
      $sql  = "SELECT `$tableSecondary`.* FROM `$tableName` ";
      $sql .= " JOIN `$tableSecondary` ON(`$tableSecondary`.ID = `$tableName`.`$fieldSecondary`)";
      $sql .= " WHERE `$tableName`.`$fieldPrimary` = " . $this->record->ID;

      //where do parametro
      if(!empty($wheres))
        $sql .= " AND (" . $wheres . ")";      

      //order
      if(!empty($fieldOrder))
        $sql .= " ORDER BY `$tableName`.`$fieldOrder` ASC";
        
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
      
    $sql .= " ORDER BY `$fieldSecondatyLegend` ASC";
    $res = $db->LoadObjects($sql);
    
    foreach ($res as $reg) {
      $item = array(
        'reg' =>   $reg,
        'selected' => false
      );
      $regs[] = $item;
    }
      
    foreach ($regs as $reg) {
      
      $selected = $reg['selected'];
      $rg = $reg['reg'];
      
      $html .= '  <option ' . (($selected)?'selected':null) . ' value="' . $rg->ID . '">' . $rg->$fieldSecondatyLegend . '</option>' . "\r\n";
    }
    $html .= '</select>' . "\r\n";       
    $html .= '</div>' . "\r\n";       
    
    //Cadastro LkpMultselect no array..
    $this->LkpMultselects[] = ($name . '|' . $tableName . '|' . $fieldPrimary . '|' . $tableSecondary . '|' . $fieldSecondary . '|' . $fieldOrder . '|' . $orderValueVariation);

    $this->html_fields[] = $html;
  }

  public function AddFieldCustom($fieldName, $legend, $columns, $valueDefault = null, $required = true, $readOnly = false){
    $this->addField('CUS', $fieldName, $legend, 0, $columns, $valueDefault, $required, $readOnly, -1, null, 'required');
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
        $html .= '<img title="' . $msgDetail . '" src="' . $cms->GetAdminImageUrl() . 'msg_erro_info.png" id="detail" width="24" height="24"/>' . "\r\n";
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
    $html .= '  <button id="save2" class="btn green">.</button></div>' . "\r\n";
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
  
  /**
   * Retorna se é uma Edição ou um Formulário em Branco
   *
   * @return boolean
   */
  public function Editing(){
    return $this->recordOpened;
  }

}
?>