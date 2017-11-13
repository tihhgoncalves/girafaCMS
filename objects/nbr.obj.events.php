<?
/**
 * Objeto que controle registro e disparo de eventos das macros.
 * @version 1.0.0
 */
class nbrEvents{

  private $events = array();
  
  public function addEvent($start, $function){
    
    $event = array($start, $function);
    $this->events[] = $event;
    
  }
  
  /**
   * Retorna array com functions de determinado gatilho
   *
   * @param string $start
   * @return array
   */
  public function getEventsArray($start){
    
    $fncs = array();
    
    foreach ($this->events as $event) {
    	
      if($event[0] == $start)
        $fncs[] = $event[1];
    }
    
    return $fncs;
  }
  
  
  /**
   * Dá include nos arquivo events.php de cada plugin
   *
   */
  public function includeFilesEventsPlugins(){
    global $PLUGINS_PATH, $PLUGINS_URL, $db;

    $sql  = 'SELECT * FROM sis_plugins';
    $sql .= " WHERE Actived = 'Y'";
    
    $plugins = $db->LoadObjects($sql);
    
    $files = array();
    foreach ($plugins as $plugin) {
    	$file = $PLUGINS_PATH . $plugin->Path . '/events.php';
    	
    	if(file_exists($file)){
    	  //variáveis (globais) que podem ser usadas dentro das Events.php de cada plugin...
        $plugin_path     = $PLUGINS_PATH . $plugin->Path;
        $plugin_url      = $PLUGINS_URL . $plugin->Path;
        $plugin_version  = $plugin->Version;
        
       	include($file);
     	}
    }

  }
}
?>