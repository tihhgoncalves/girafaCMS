<?
class nbrLangs{
	
	public $default;
	public $language;
	public $languages = array();
	public $words = array();
	public $prefixo;
  	public $opened = false;
	
	private $file_contents;
	private $file_handle;
	private $language_id = -1;
	
	function __construct($prefixo){
		
		$LANGS = $GLOBALS['LANGS_' . $prefixo];
		
		//carrega informações do config
		$this->default = $LANGS['default'];
		$this->prefixo = $prefixo;
		
		$this->languages = $LANGS['activated'];
		/*
		//verifica se já existe um idioma setado na sessão, se não seta a padrão (default)
		if(!isset($_SESSION['nbr_lang_' . $prefixo])){
			$this->SetLanguage($this->default);
		} else {
			$this->SetLanguage($_SESSION['nbr_lang_' . $prefixo]);
		}
		//carrega arquivo...
		$this->LoadFile();
		*/
	}
	
	function __destruct(){
		if(isset($this->file_handle))
			fclose($this->file_handle);
	}
	
	public function SetLanguage($lang){
		
		$_SESSION['nbr_lang_' . $this->prefixo] = $lang;				
		$this->language = $lang;
		
		$this->LoadFile();
	}
	
	public function LoadFile(){
		global $ADMIN_LANGS_PATH;
		
		
		//arquivo..
		$file = $ADMIN_LANGS_PATH . $this->language . '_' . strtolower($this->prefixo) . '.php';
		
		//verifica se é novo...
		$new = (!file_exists($file));
		
		
		$this->file_handle = fopen($file, "a+");
		
		// Escreve no arquivo de texto
		if($new){

			$txt  = '/**' . "\r\n";
			$txt .= ' * Este arquivo do idioma ' . $this->language . ' foi criado automaticamente.' . "\r\n";
			$txt .= ' * Data: ' . date('d-m-Y H:i') . '.' . "\r\n";
			$txt .= ' * ' . "\r\n";
			$txt .= ' */' . "\r\n";
			$txt .= "\r\n";
			$txt .= '$l = array();' . "\r\n";

			fwrite($this->file_handle, $txt);	
		} else {

			$this->file_contents = null;
					
			while (!feof($this->file_handle)) {
			  $this->file_contents .= fread($this->file_handle, 8192);
			}
			
			//carrega array do idioma...
			eval($this->file_contents);
			$this->words = $l;
		}

    $this->opened = true;
	}
	
	public function getText($id){

    //se o arquivo não foi carregado, ignora...
    if(!$this->opened)
      return $id;

		if(!array_key_exists($id, $this->words)){
			
			$txt = '$l["'  . $id . '"] = "' . $id .'";' . "\r\n";
			//excreve no arquivo
			fwrite($this->file_handle, $txt);	
			$this->words[$id] = $id;
			return $id;
			
		} else {
			return $this->words[$id];
		}
	}
	
	public function getID(){
		global $db;
		
		if($this->language_id > 0)
			return $this->language_id;
		else {
			
			$sql  = 'SELECT ID FROM sysLanguages';
			$sql .= " WHERE Identificador = '" . $this->language . "'";
			$ids  = $db->LoadObjects($sql);
			$id   = $ids[0]->ID;
			return $id;
			
		}
	}

  public function checkLanguage($language){

    foreach($this->languages as $lang){
      if($lang == $language)
        return true;
    }
    return false;
  }
}


function __($id){
	global $langs;
	
	return $langs->getText($id);
}
?>