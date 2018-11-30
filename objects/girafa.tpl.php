<?


class girafaTpl{

  private $htmlOriginal;
  private $html;

  function __construct($reportFile){
    $this->html = file_get_contents(get_config('TPL_PATH') . $reportFile);
    $this->htmlOriginal = $this->html;

  }

  public function setValue($key, $value){
    $this->html = str_replace("%%$key%%", $value, $this->html);
  }


  public function GetHtml(){
    return $this->html;
  }

}


?>