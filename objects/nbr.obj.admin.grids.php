<?
class nbrAdminGrid{

  /* propriedades */
  public $wheres;
  public $orders;
  public $formFile;
  public $macroFile;
  public $securityNew = true;
  public $securityEdit = true;
  public $securityDelete = true;
  public $filters = array();

  function __construct($tableName, $title = null){
    global $hub;

    $this->tableName = $tableName;

    if(empty($title))
      $this->title = $tableName;
    else
      $this->title = $title;

    //Pega "Número de Registros por Página" do Cookie
    if(isset($_COOKIE['nbr_grid_LimitFromPage']))
    $this->recordsLimitFromPage = $_COOKIE['nbr_grid_LimitFromPage'];

    //Verifica se tem setado o "Número da Página Atual" na URL
    if($hub->ExistParam('grid_page'))
    $this->recordsPage = $hub->GetParam('grid_page');

    //Carrega Informações do Módulo
    $this->module = nbrModule::LoadModule($hub->GetParam('_moduleID'));

    //Se for um registro de uma coleção, adiciona parametro de campo oculto para o formulário..
    if($hub->ExistParam('_fieldHidden')){
      $this->AddParam('_fieldHidden', $hub->GetParam('_fieldHidden'));
    }
    
    //Adiciona primeira coluna o ID..
    $this->AddColumnInteger('ID', 'ID', 20);
    
  }

  /* Funções Privadas */

  private function mark($value){
    global $hub;
    
    //Verifica se tem que colocar marcação de pesquisa..
    if($hub->ExistParam('filterSearch')){
      $cons = $hub->GetParam('filterSearch');
      $value = preg_replace('%' . $cons . '%i', '<span class="marcacao">$0</span>', $value);

      return $value;
    } else 
      return $value;
  }

  private function addColumn($fieldName, $legend, $width, $align, $type, $lst_options = null, $tab_tableName = null, $tab_tableField = null, $bol_controlOn = false, $height = 0){
    
    $field = array();
    $field['fieldName']       = $fieldName;
    $field['legend']          = $legend;
    $field['length']          = $width;
    $field['align']           = $align;
    $field['type']            = $type;
    $field['lst_options']     = $lst_options;
    $field['tab_tableName']   = $tab_tableName;
    $field['tab_tableField']  = $tab_tableField;
    $field['bol_controlOn']   = $bol_controlOn;    
    $field['height']          = $height;
    $this->fields[]           = $field;

    //adiciona primeira coluna como titulo do HUB (sem contar o ID)
    if(empty($this->fieldTitle) && $type != 'HID' && $fieldName != 'ID')
    $this->fieldTitle = $fieldName;
  }

  private function getValue($field, $record){
    global $cms, $hub, $ADMIN_PAGES_PATH, $ADMIN_UPLOAD_PATH, $ADMIN_UPLOAD_URL;

    switch ($field['type']) {
      case 'STR':
        $value = $record->$field['fieldName'];
        $value = $this->mark($value);
        break;
        
      case 'IMG':
        if(!empty($record->$field['fieldName'])){
          $imgFile = $ADMIN_UPLOAD_PATH . $record->$field['fieldName'];
          $value  = '<a href="' . ($ADMIN_UPLOAD_URL . $record->$field['fieldName']) . '" title="Clique aqui para ampliar a foto"  class="fancybox">';
          $value .= '<img src="' . nbrMagicImage::CreateThumbBackgroundCenter($imgFile, $field['length'], $field['height'], '#FFFFFF') . '">';
          $value .= '</a>';
        } else 
          $value = '';
        break;

      case 'NUM':
        $value = number_format($record->$field['fieldName'], 2, ',', '.');
        break;

      case 'INT':
        $value = intval($record->$field['fieldName']);
        break;

      case 'BOL':
        $img = ($record->$field['fieldName'] == 'Y')?'grid_bool_check.gif':'grid_bool_uncheck.gif';
        $title = ($record->$field['fieldName'] == 'Y')?'Sim (ativo)':'Não (inativo)';
        
        $html = null;
        
        if($field['bol_controlOn']){
          
          $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'grid.boolean.php');
          $hub->SetParam('table', $this->tableName);
          $hub->SetParam('field', $field['fieldName']);
          $hub->SetParam('value', (($record->$field['fieldName'] == 'Y')?'N':'Y') );
          $hub->SetParam('id', $record->ID);

          if($this->macroFile != null)
    		$hub->SetParam('fileMacro', $this->module->folderPath . $this->macroFile);
          
          
          $html .= '<a title="Clique aqui para alterar o valor deste campo" href="' . $hub->GetUrl() . '">';
        }
        $html .= '<img src="' . $cms->GetAdminImageUrl() . $img . '" width="21" height="16" />';

        if($field['bol_controlOn'])
          $html .= '</a>';
                
        $value = $html;
        break;

      case 'DTT':
        $value = $record->$field['fieldName'];
        
        if(!empty($value)){
          $date = new nbrDate($value, ENUM_DATE_FORMAT::YYYY_MM_DD_HH_II_SS);
          $value = $date->GetDayOfWeekShorten() . ', ' . $date->GetFullDateForShorten() . ' ' . $date->GetDate('H:i');
        } else 
          $value = null;
        break;

      case 'DTA':
        $value = $record->$field['fieldName'];

        if(!empty($value)){
          $date = new nbrDate($value, ENUM_DATE_FORMAT::YYYY_MM_DD_HH_II_SS);
          $value = $date->GetDayOfWeekShorten() . ', ' . $date->GetFullDateForShorten();
        }
        break;

      case 'LST':
        $options = explode('|',$field['lst_options']);
        foreach ($options as $values) {
          $a_value = explode('=', $values);
          if($record->$field['fieldName'] == $a_value[0])
          $value = $a_value[1];

        }
        break;

      case 'TAB':
        $value = $record->$field['fieldName'];
        $value = $this->mark($value);
        break;

      case 'CUS':
        $value = $field['fieldName'];
        break;
    }

    //Verifica se existe evento macroGridValues na macro...
    if(function_exists('macroGridValues')){
      $nValue = macroGridValues($field['fieldName'] , $value, $record);

      if((!empty($nValue)) || is_int($nValue))
        $value = $nValue;
    }

    if((!empty($value)) || is_int($value))
      return $value;
    else 
      return null;

  }

  private function LoadRecords(){
    global $db, $hub;

    $joins = null;
    $joinsTables = array();

    //Trata campos..
    $fields = array();
    $fieldsSearch = array();
    //Campos...
    foreach ($this->fields as $x=>$field) {

      if($field['type'] == 'TAB'){

        $fieldsSearch[] = $field['tab_tableName'] . '.' . $field['tab_tableField'];
        
        $fields[] = $field['tab_tableName'] . '.' . $field['tab_tableField'] . ' `' .  $field['fieldName'] . '`';
        $fields[] = $field['tab_tableName'] . '.ID `' .  $field['fieldName'] . 'ID`';

        //verifica se esta tabela já está no join..
        if(array_search($field['tab_tableName'], $joinsTables) === false){
          $joins .= ' LEFT JOIN ' . $field['tab_tableName'] . ' ON(' . $field['tab_tableName'] . '.ID = A.' . $field['fieldName'] . ')';
          $joinsTables[] = $field['tab_tableName'];
        }

      } elseif($field['type'] != 'CUS'){
        $fields[] = 'A.' . $field['fieldName'];
        $fieldsSearch[] = 'A.' . $field['fieldName'];
      }
    }
        
    
    //Trata filtros..
    if($hub->ExistParam('filterWhere')){
      
     if(!empty($this->wheres))
       $this->wheres .= ' AND ';
       
     $this->wheres .= '(' . $hub->GetParam('filterWhere')  . ')';
      
    }

    //Se tiver search...
    if($hub->ExistParam('filterSearch')){
      
     if(!empty($this->wheres))
       $this->wheres .= ' AND ';
      
      $this->wheres .= '(';
      
      foreach ($fieldsSearch as $x=>$field) {
        
        if($x > 0)
          $this->wheres .= ' OR ';
        
       $this->wheres .= '(' . $field . " LIKE '%" . $hub->GetParam('filterSearch') . "%')";	
      }
     $this->wheres .= ')';
    }
    
    //Se for uma pasta (folder) multilinguística filtra pelo idioma selecionado.
	if($hub->GetParam('_languages') == 'Y'){

		if(!empty($this->wheres))
		  $this->wheres .= ' AND ';
		
    	$this->wheres .= '(A.Lang = "' . $_SESSION['lang_admin'] . '")';
    }    
    
    //Condições..
    if(!empty($this->wheres))
    $wheres = ' WHERE (' . $this->wheres . ')';

    //verifica se tem condição da página
    if($hub->ExistParam('_where')){

      if(!isset($wheres))
      $wheres = ' WHERE (' . $hub->GetParam('_where') . ')';
      else
      $wheres .= ' AND (' . $hub->GetParam('_where') . ')';
    }


    //Ordenação..
    if($this->controlOrders != array())
      $orders = ' ORDER BY A.`' . $this->controlOrders['field'] . '` ASC';
    elseif(!empty($this->orders))
      $orders = ' ORDER BY ' . $this->orders;



    //Pega número total de registro..
    $sql  = 'SELECT COUNT(A.ID) TOTAL FROM ' . $this->tableName . ' A';
    //Joins..
    $sql .= $joins;    
    
    if(!empty($wheres))
      $sql .= $wheres;
      
    $res = $db->LoadObjects($sql);
    $totalReg = $res[0]->TOTAL;
    $this->totalRecords = $totalReg;
    
    //echo($sql);

    //Faz consulta de registros pra mostar no grid..
    $sql = 'SELECT ';

    $sql .= implode(', ', $fields);

    //Tabela..
    $sql .= ' FROM ' . $this->tableName . ' A';

    //Joins..
    $sql .= $joins;

    //Adiciona Filtros (condições)..
    if(!empty($wheres))
      $sql .= $wheres;
    
    //Adiciona Ordenadores..
    
    if(!empty($orders))
      $sql .= $orders;

    //Adiciona Limitadores (pra trazer só registro da página atual
    $regI = ($this->recordsPage - 1) * $this->recordsLimitFromPage;
    $regF = $this->recordsLimitFromPage;
    $sql .= ' LIMIT ' . $regI . ', ' . $regF;

    //echo($sql);
    
    //Carrega resistros...
    $this->records = $db->LoadObjects($sql);

    //Faz calculos de páginação..
    $this->totalPages = ceil($totalReg / $this->recordsLimitFromPage);
  }

  /* Funções Públicas */

  public function AddColumnString($fieldName, $legend, $width, $align = 'left'){
    $this->addColumn($fieldName, $legend, $width, $align, 'STR');
  }

  public function AddColumnInteger($fieldName, $legend, $width, $align = 'center'){
    $this->addColumn($fieldName, $legend, $width, $align, 'INT');
  }

  public function AddColumnNumber($fieldName, $legend, $width, $align = 'right'){
    $this->addColumn($fieldName, $legend, $width, $align, 'NUM');
  }

  public function AddColumnImage($fieldName, $legend, $width = 100, $height = 50, $align = 'center'){
    $this->addColumn($fieldName, $legend, $width, $align, 'IMG', null, null, null, false, $height);
  }

  public function AddColumnCustom($name, $legend, $width, $align = 'left'){
    $this->addColumn($name, $legend, $width, $align, 'CUS' );
  }

  public function AddColumnHidden($name){
    $this->addColumn($name, null, 0, null, 'HID');
  }

  public function AddColumnDate($fieldName, $legend, $width, $align = 'left'){
    $this->addColumn($fieldName, $legend, $width, $align, 'DTA');
  }

  public function AddColumnDateTime($fieldName, $legend, $width, $align = 'left'){
    $this->addColumn($fieldName, $legend, $width, $align, 'DTT');
  }

  public function AddColumnBoolean($fieldName, $legend, $width = 35, $align = 'center', $controlOn = true){
    $this->addColumn($fieldName, $legend, $width, $align, 'BOL', null, null, null, true);
  }

  public function AddColumnList($fieldName, $legend, $width, $options, $align = 'left'){
    $this->addColumn($fieldName, $legend, $width, $align, 'LST', $options);
  }

  public function AddColumnTable($fieldName, $legend, $width, $linkTableName, $linkTableField, $align = 'left'){
    $this->addColumn($fieldName, $legend, $width, $align, 'TAB', null, $linkTableName, $linkTableField);
  }

  public function AddParam($key, $value){
    $this->hubParams[$key] = $value;
  }
  
  public function AddControlOrder($fieldName = 'Ordem', $variation = 10){
    $this->controlOrders['field']     = $fieldName;
    $this->controlOrders['variation'] = $variation;
  }

  public function PrintHTML(){
    global $hub, $dataSet, $cms, $ADMIN_PAGES_PATH, $ADMIN_IMAGES_URL;

    //Descobre qual a coluna fluída
    $columnFluid = null;
    $columnFluidLength = 0;
    foreach ($this->fields as $field) {
      if($field['length'] > $columnFluidLength){
        $columnFluidLength = $field['length'];
        $columnFluid = $field['fieldName'];
      }
    }

    //Botão Novo...
    $formFile = $this->formFile;
    $hub->SetParam('_page', $this->module->path . $formFile);
    $hub->SetParam('_title', 'Novo Registro');
    $hub->SetParam('_moduleID', $this->module->ID);
    $hub->SetParam('_folderID', $hub->GetParam('_folderID'));
    $hub->SetParam('_languages',$hub->GetParam('_languages'));

    //Adiciona Paramêtros adicionais do hub
    foreach ($this->hubParams as $key=>$param) {
      $hub->SetParam($key, $param);
    }

    if($this->macroFile != null)
    $hub->SetParam('fileMacro', $this->module->folderPath . $this->macroFile);

    $linkNew = $hub->GetUrl();

    //Inicia $html...
    $html = null;
    
    //Variáveis de JS..
    $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'grid.ajax.updateorder.php');
    $hub->SetParam('table', $this->tableName);
    
    if(count($this->controlOrders) > 0){
      $hub->SetParam('controlOrderField', $this->controlOrders['field']);
      $hub->SetParam('controlOrderVariation', $this->controlOrders['variation']);
    }

    $html .= '<script type="text/javascript">' . "\r\n";
    $html .= '  var controlOrderAjaxURL = "' . $hub->GetUrl() . '";' . "\r\n";
    $html .= '</script>' . "\r\n";
    
    //Verifica se Existe Mensagem de Sucesso no DataSet e mostra na tela...
    if($dataSet->ExistParam('msgSucess')){
      $msg = $dataSet->GetParam('msgSucess');
      $html .= '<div id="msg_sucesso">' . $msg . "\r\n";
      $html .= '<img src="' . $cms->GetAdminImageUrl() . 'msg_sucesso_close.png" width="12" heigth="12" id="msg_sucesso_close" class="alphaOut">' . "\r\n";
      $html .= '</div>' . "\r\n";
      $dataSet->DeleteParam('msgSucess');
    }

    //Verifica se Existe Mensagem de Erro no DataSet e mostra na tela...
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

    //Título do Grid..
    $html .= '<h1>' . $this->title . '</h1>';

    //Pilha..
    $html .= '<span id="stack">' . $hub->GetStackString() . '</span>';

    $html .= '<div id="bar">' . "\r\n";
    
    //Filtros..
    $html .= '<div id="filters">' . "\r\n";
    $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'grid.filters.php');
    $html .= '<form action="' . $hub->GetUrl() .'" method="post" name="pesquisa" id="pesquisa">' . "\r\n";
    $html .= '<label>Pesquisa</label>' . "\r\n";
    
    //$html .= '<div id="search">' . "\r\n";
    $html .= '<input type="text" name="search" id="search" value="' . $hub->GetParam('filterSearch') . '">' . "\r\n";
    //$html .= '</div>' . "\r\n";

    if(count($this->filters) > 0){
      $html .= '<div id="filter">' . "\r\n";
      $html .= '<i class="fa fa-filter" aria-hidden="true"></i>' . "\r\n";
      $html .= '<select name="filter" id="filter">' . "\r\n";
      $html .= '  <option value="-1">' . __('Filtrar por...') . '</option>' . "\r\n";
      
      //filtros..
      foreach ($this->filters as $filter) {
        
        //where...
        
        if(!$hub->ExistParam('filterWhere')){
          
          
          if(($filter[2])){
           $selected = 'selected'; 

            if(empty($this->wheres))
              $this->wheres = $filter[0];
            else 
              $this->wheres .= ' AND (' . $filter[0] . ')';
           
          } else {
           $selected = null;  
          }

        } else {
          $selected = (($hub->GetParam('filterWhere') == $filter[0])?'selected':null);
        }
        $html .= '  <option ' . $selected . ' value="' . $filter[0] .'">' . $filter[1] . '</option>' . "\r\n";	
      }
      $html .= '</select>' . "\r\n";
      $html .= '</div>' . "\r\n";
    }
        
    $html .= '<button class="btn btn-warning btn-mini" text="false"><i class="fa fa-search" aria-hidden="true"></i></button>' . "\r\n";
    
    if($hub->ExistParam('filterWhere') || $hub->ExistParam('filterSearch'))
      $html .= '<a href="javascript: void(0);" id="limpar" title="Clique aqui para Limpar os filtros desta pesquisa"><i class="fa fa-times" aria-hidden="true"></i></a>' . "\r\n";
    
    $html .= '</form>' . "\r\n";
    $html .= '</div>' . "\r\n";
    
    //Barra de Tarefas..
    $toolbar = '<ul id="toolbar">' . "\r\n";
    
    //Imprime Botão Novo (do topo)
    if($this->securityNew)
      $toolbar .= '<li class="new"><button class="btn green new" icon="ui-icon-document" onclick="document.location.href=\'' . $linkNew . '\'" title="Novo registro (ctrl + seta acima)" text="false">Novo</button></li>' . "\r\n";
      
    $toolbar .= '</ul>' . "\r\n";
    
    $html .= $toolbar;
    
    //Comandos..
    if(count($this->commands) > 0){
      
      $html .= '<ul id="commandsBar">' . "\r\n";
      
      foreach ($this->commands as $command) {  
        $html .= '<li><a href="javascript:void(0);" question="' . $command[3] . '" link="' . $command[1] . '" title="' . $command[2] . '"> <i class="fa fa-link" aria-hidden="true"></i>' . $command[0] . '</a></li>' . "\r\n";
      }
      
      $html .= '</ul>' . "\r\n";
    }
    
    
    $html .= '</div>' . "\r\n";

    $html .= '<div class="grid">';

    $html .= '  <table cellpadding="0" cellspacing="0" class="grid">' . "\r\n";
    $html .= '    <thead>' . "\r\n";
    $html .= '      <tr class="legend">' . "\r\n";

    //Legenda do Campo Ordem...
    if(!empty($this->controlOrders))
      $html .= '<td class="order"></td>' . "\r\n";

    //Legendas...
    foreach ($this->fields as $field) {

      if($field['type'] != 'HID'){
        $styles = array();

        //É largura fluida?
        if($field['fieldName'] != $columnFluid)
        $styles[] = ('width: ' . $field['length'] . 'px');

        //Define alinhamento..
        $styles[] = ('text-align: ' . $field['align']);

        $html .= '        <td style="' . implode('; ', $styles) . '">' . $field['legend'] . '</td>' . "\r\n";
      }
    }

    $html .= '        <td style="width: 65px;" class="icons"></td>' . "\r\n";
    $html .= '      </tr>' . "\r\n";
    $html .= '    </thead>' . "\r\n";

    $html .= '    <tbody>' . "\r\n";

    //Registros...
    $this->LoadRecords();

    if(count($this->records) > 0){

      foreach ($this->records as $x=>$record) {
        $classContrast = ($x % 2)?' contrast':null;
        $html .= '      <tr id="' . $record->ID . '" class="records' . $classContrast . '">' . "\r\n";

        //Ordem...
        if(!empty($this->controlOrders))
          $html .= '<td class="order tooltip" title="Ordene os Registros - Para escolher a ordem do seu registro <br>clique sobre a linha desejada e arraste<br> para cima ou para baixo."></td>' . "\r\n";

        foreach ($this->fields as $field) {

          if($field['type'] != 'HID'){
            $styles = array();
            $styles[] = ('text-align: ' . $field['align']);

            //É largura fluida?
            if($field['fieldName'] != $columnFluid)
            $styles[] = ('width: ' . $field['length'] . 'px');

            $html .= '<td style="' . implode($styles, '; ') . '">' . "\r\n";
            $html .= '  <span class="normal" style="' . implode($styles, '; ') . '">' . "\r\n";
            $html .= $this->getValue($field, $record) . "\r\n";
            $html .= '  </span>' . "\r\n";
            $html .= '</td>' . "\r\n";
          }
        }

        //Botão Edit..
        if($this->securityEdit){
          $formFile = $this->module->path . $this->formFile;
          $fieldTitle = $this->fieldTitle;
          $hub->SetParam('_page', $formFile);
          $hub->SetParam('_title', $record->$fieldTitle);
          $hub->SetParam('_description', 'Editando registro ' . $record->$fieldTitle . ' da pasta ' . $this->title);
          $hub->SetParam('ID', $record->ID);
          $hub->SetParam('title', $this->title);
          $hub->SetParam('_moduleID', $this->module->ID);
          $hub->SetParam('_folderID', $hub->GetParam('_folderID'));
          $hub->SetParam('_languages',$hub->GetParam('_languages'));

          if($this->macroFile != null)
          $hub->SetParam('fileMacro', $this->module->folderPath . $this->macroFile);

          //Adiciona Paramêtros adicionais do hub
          foreach ($this->hubParams as $key=>$param) {
            $hub->SetParam($key, $param);
          }

          $html .= '<td class="icons">' . "\r\n";
          $html .= '<a href="' . $hub->GetUrl() . '">' . "\r\n";
          $html .= '<i class="fa fa-pencil" aria-hidden="true"></i>' . "\r\n";
          $html .= '</a>' . "\r\n";
        }

        //Botão Excluir
        if($this->securityDelete){
          $hub->SetParam('_script', $ADMIN_PAGES_PATH . 'grid.delete.php');
          $hub->SetParam('table', $this->tableName);
          $hub->SetParam('ID', $record->ID);

          if($this->macroFile != null)
          $hub->SetParam('fileMacro', $this->module->folderPath . $this->macroFile);
          $html .= '<a title="Clique aqui para excluir este registro" href="javascript:void(0);" onclick="deleteReg(\'' . $this->tableName . '\', \'' . $record->ID . '\', \'' . $hub->GetUrl() . '\');">';
          $html .= '<i class="fa fa-trash" aria-hidden="true"></i>';
          $html .= '</a></td>' . "\r\n";
        }

        $html .= '      </tr>' . "\r\n";
      }
    } else {
      $html .= '<tr><td class="noRegister" colspan="' . (count($this->fields) + 1) . '">Ops! Nenhum registro encontrado!</td></tr>';
    }

    $html .= '    </tbody>' . "\r\n";
    $html .= '  </table>' . "\r\n";


    $html .= '  <div class="flright">' . "\r\n";

    //Imprime novamente toolbar..
    $html .= $toolbar;

    $html .= '  </div>' . "\r\n";

    /**
     * Rodapé do GRID
     */
    $html .= '  <div class="grid_footer">' . "\r\n";

    //Páginas...
    if($this->totalPages > 1){

      //Traz o nível (de link) atual
      $html .= '    <div class="grid_footer_item">' . "\r\n";
      $html .= '      <strong>Página: </strong>' . "\r\n";

      for ($i = 1; $i <= $this->totalPages; $i++){

        if($i > 1)
        $html .= ' . ';

        $hub->BackLevel();
        $hub->SetParam('grid_page', $i);
        $link = $hub->GetUrl();

        //Verifica se é página atual (ai não põe o link)
        if($i == $this->recordsPage)
        $html .= $i . "\r\n";
        else {
          $title = 'Ir paga a página ' . $i;
          $html .= '        <a alt="' . $title . '" title="' . $title . '" href="' . $link . '">' . $i .'</a>' . "\r\n";
        }
      }
      $html .= '    </div>' . "\r\n";
    }
    $html .= '    <div class="grid_footer_item">' . "\r\n";
    $html .= '      <strong>Registros por Página:</strong> ' . "\r\n";

    //Quantidade de Registros por página
    $options  = array(5, 10, 20, 50, 100);
    foreach ($options as $x=>$option) {

      if($x > 0)
      $html .= ' . ';

      $hub->BackLevel();
      $hub->SetParam('grid_limitPage', $option);
      $link = $hub->GetUrl();

      if($this->recordsLimitFromPage == $option){
        $html .= $option;
      } else {
        $title = 'Carregar ' . $option . ' registros por página';
        $html .= '<a alt="' . $title . '" title="' . $title . '" href="' . $link . '">' . $option . '</a>';
      }
    }
    $html .= '    </div>' . "\r\n";

    $html .= '    <div class="grid_footer_item">' . "\r\n";
    $html .= '      <strong>Total de Registros consultados:</strong> ' . $this->totalRecords . "\r\n";
    $html .= '    </div>' . "\r\n";


    $html .= '  </div>' . "\r\n";


    $html .= '</div>' . "\r\n";
    echo($html);
  }

  public function AddCommand($legend, $link, $description = null, $question = null){
    $array = array();
    $array[0] = $legend;
    $array[1] = $link;
    $array[2] = $description;
    $array[3] = $question;

    $this->commands[] = $array;
  }
  
  public function AddFilter($where, $title, $selected = false){
    $x = array($where, $title, $selected);
    $this->filters[] = $x;
  }
}
?>