<?

class nbrDB
{
    const version = '2.0';

    private $_persistent;

    public $user;
    public $host;
    public $pass;
    public $database;
    public $port;
    public $errorNumber;
    public $errorMsg;

    private $connection;

    private function _setErrorMsg()
    {
        $this->errorMsg = mysql_error($this->connection);
        $this->errorNumber = mysql_errno($this->connection);
    }

    private function _connect(){

        //Verifica se é persistente e gerencia conexão (no caso verifica se tem uma semelhante já aberta)
        if($this->_persistent) {
            global $nbrDB_conns;

            foreach ($nbrDB_conns as $conn){
                if($conn->host == $this->host
                    && $conn->pass == $this->pass
                    && $conn ->user == $this->user
                    && $conn->database == $this->database) {
                    $this->connection = $conn->connection;
                    return;
                }
            }
        }

        //Verifica se extensão está habilitada no PHP
        if(!function_exists('mysql_connect'))
            throw new Exception('nbrDB: A extensão mysql de conexão com o banco de dados não está habilitada no seu servidor.');

        $this->connection = mysqli_connect($this->host, $this->user, $this->pass);

        if($this->connection === false){
            $this->_setErrorMsg();
            throw new Exception('nbrDB: Ocorreu um erro ao tentar conectar a seu banco de dados MySql.');
        }

        $selectionDb = mysqli_select_db($this->connection, $this->database);

        //força o resultado em UTF8
        mysqli_query($this->connection, "SET NAMES 'utf8'");

        if($selectionDb === false){
            $this->_setErrorMsg();
            throw new Exception('nbrDB: Ocorreu um erro ao tentar selecionar um database ao seu banco de dados.');
        }

        //Se for conexão persistente joga conexao no cache
        if($this->_persistent)
            array_push($nbrDB_conns, $this);
    }

    public function _read($sql){

        //Verifica se é um sql de SELECT
        if((strpos(strtolower($sql), 'select') === false) && (strpos(strtolower($sql), 'call') === false))
            throw new Exception('nbrDB: Você só pode fazer uma consulta ao banco dados utilizando um sql de SELECT');

        return mysqli_query($this->connection, $sql);

    }

    public function __construct($host, $db, $user, $pass, $persistent = true){
        //Seta parâmetros de conexão
        $this->type        = $db;
        $this->host        = $host;
        $this->user        = $user;
        $this->pass        = $pass;
        $this->database    = $db;
        $this->_persistent = $persistent;

        //Faz conexão
        $this->_connect();
    }

    function __destruct(){
        //Se não for conexão persistente, ele força o fechamento da conexão
        if(!$this->_persistent)
            $this->Close();
    }

    public function Execute($sql)
    {

        $this->sql = $sql;

        $resource = mysqli_query($this->connection, $sql);

        if($resource === false)
        {
            $this->_setErrorMsg();
            throw new Exception('nbrDB: Não foi possível concluir a execução do comando enviado ao banco de dados:' . $sql);
        }
        return true;
    }

    public function GetLastIdInsert()
    {
        //Verifica se última ação foi um insert
        if(strpos(strtoupper($this->sql), 'INSERT') === false)
            throw new Exception('nbrDB: Você só pode solicitar o ID inserido após ter executado um comando INSERT no banco de dados.');

        return mysqli_insert_id($this->connection);
    }

    public function LoadArrays($sql)
    {
        $resource = $this->_read($sql);

        $value = array();
        while($rw = mysqli_fetch_array($resource))
        {
            array_push($value, $rw);
        }
        return $value;

    }

    public function LoadObjects($sql)
    {
        //echo('[' . $sql . ']');
        $resource = $this->_read($sql);


        $value = array();
        while($rw = mysqli_fetch_object($resource))
        {
            array_push($value, $rw);
        }
        return $value;
    }

    public function Close()
    {
        //Verifica se é persistente e verifica se na global ainda existe esta conexao
        if($this->_persistent){
            global $nbrDB_conns;

            //Re-ordena os �ndices
            sort($nbrDB_conns);

            $encontrou = false;
            for($i = 0; $i < count($nbrDB_conns); $i++){
                $conn = $nbrDB_conns[$i];

                if($conn->host == $this->host
                    && $conn->pass == $this->pass
                    && $conn ->user == $this->user
                    && $conn->database == $this->database)
                {
                    $encontrou = true;
                    //Exclui da global a conex�o
                    unset($nbrDB_conns[$i]);
                }
            }

            /**
             * Se não foi encontrado é pq possívelmente a variável já foi fechada anteriormente e ignora.
             * (no caso por ser Conexão Persistente mais de um objeto declarado utilizou a mesma conexou,
             * e um deles já fechou ela)
             */
            if(!$encontrou)
                return;
        }

        //Fecha conexão no banco 
        mysqli_close($this->connection);

        //Zera parâmetros...
        $this->connection = false;
    }

    public function LoadSqlFile($sqlFile){

        if(!file_exists($sqlFile)){
            throw new Exception('Arquivo SQL não foi encontrado.');
        }

        //Carrega arquivo...
        $arquivo = Array();
        $arquivo = file($sqlFile);
        $prepara = '';  // Cria a Variavel $prepara

        foreach($arquivo as $v){
            $prepara .= $v;
        }

        $sql = explode(';', $prepara);

        //executa comandos SQL...
        foreach($sql as $v) {

            $v = utf8_decode($v);
            $v = trim($v);

            if(!empty($v))
                $this->Execute($v);
        }
    }
}

global $nbrDB_conns;
$nbrDB_conns = array();

/**
 * Função executada quando o script de PHP chegar ao fim (irá desconectar TODAS as conexões persistentes abertas)
 *
 */
function nbrDB_shutdown(){
    global $nbrDB_conns;

    for($i = 0; $i < count($nbrDB_conns); $i++)
    {
        $conn = $nbrDB_conns[$i];
        $conn->Close();
    }
}
register_shutdown_function('nbrDB_shutdown');
?>