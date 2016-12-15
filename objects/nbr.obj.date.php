<?
class nbrDate
{
    # CONSTANTES
    
    /**
     * Versão da Classe
     */
    const version = '1.1.0';
    
    # VARIÁVEIS PRIVADAS
    
    private $_language;
    
    # VARIÁVEIS PÚBLICAS
    public $mktime = false;    
    
    # MÉTODOS PRIVADOS
    
    /**
     * Seta Data a variável privada $mktime
     *
     * @param integer $ano
     * @param integer $mes
     * @param integer $dia
     * @param integer $hora
     * @param integer $minuto
     * @param integer $segundo
     */
    private function _setDate($ano, $mes, $dia, $hora, $minuto, $segundo)
    {
        $ano         = intval($ano);
        $mes         = intval($mes);
        $dia         = intval($dia);
        $hora        = intval($hora);
        $minuto      = intval($minuto);
        $segundo     = intval($segundo);
        
        $this->mktime = mktime($hora, $minuto, $segundo, $mes, $dia, $ano);
        
        //Verifica se foi atribuído valor corretamente ao mktime
        if($this->mktime === false)
            throw new Exception('nbrDate::O valor especificado não pôde ser atribuído corretamente.');
    }
    
    /**
     * Verifica se já teve alguma data setada.
     * Caso tenha retorna true, caso não dá erro.
     *
     * @return boolean
     */
    private function _checkData()
    {
        if($this->mktime === false)
            throw new Exception('nbrDate::Você não pode executar esta ação sem antes setar uma data ao objeto.');
        
        return true;
    }
    
    # MÉTODOS PÚBLICOS
    
    /**
     * @param string $date
     * @param ENUM_DATE_FORMAT $format
     * @param ENUM_LANGUAGE_LANGUAGE $lang
     */
    function __construct($date, $format)
    {
        
        switch ($format)
        {
            case ENUM_DATE_FORMAT::YYYY_MM_DD:
                $date = substr($date, 0, 10);
                $date = explode('-', $date);
                $this->_setDate($date[0], $date[1], $date[2], 0, 0, 0);
                break;
                
            case ENUM_DATE_FORMAT::YYYY_MM_DD_HH_II_SS:
                $date = str_replace(' ', '-', $date);
                $date = str_replace(':', '-', $date);
                $date = explode('-', $date);
                $this->_setDate($date[0], $date[1], $date[2], $date[3], $date[4], $date[5]);
                break;
                
            case ENUM_DATE_FORMAT::DD_MM_YYYY:
                $date = str_replace('/', '-', $date);
                $date = explode('-', $date);
                $this->_setDate($date[2], $date[1], $date[0], 0, 0, 0);
                break;
                
            case ENUM_DATE_FORMAT::DD_MM_YYYY_DD_II_SS:
                $date = str_replace(' ', '-', $date);
                $date = str_replace('/', '-', $date);
                $date = str_replace(':', '-', $date);
                $date = explode('-', $date);
                $this->_setDate($date[2], $date[1], $date[0], $date[3], $date[4], $date[5]);
                break;
                                
            default:
                throw new Exception('nbrDate::Formado de data ainda não implemtado na classe.');
        }
    }
    
    /**
     * Retorna data no formato especificado
     *
     * @param string $format
     * @return string
     */
    public function GetDate($format)
    {
        //Verifica se a data foi setada
        $this->_checkData();
        
        return date($format, $this->mktime);
    }
    
    /**
     * Retorna nome do mês por extenso. (Ex: Janeiro)
     *
     * @return string
     */
    public function GetMonthNameLong()
    {
        //Verifica se a data foi setada
        $this->_checkData();
        
        $mes = intval($this->GetDate('m'));
        
        switch ($mes) 
        {
            case 1:  return 'Janeiro';
            case 2:  return 'Fevereiro';
            case 3:  return 'Março';
            case 4:  return 'Abril';
            case 5:  return 'Maio';
            case 6:  return 'Junho';
            case 7:  return 'Julho';
            case 8:  return 'Agosto';
            case 9:  return 'Setembro';
            case 10: return 'Outubro';
            case 11: return 'Novembro';
            case 12: return 'Dezembro';
        }
    }
    
    /**
     * Retorna nome do mês abreviado (Ex: jan)
     *
     * @return unknown
     */
    public function GetMonthNameShorten()
    {
        //Verifica se a data foi setada
        $this->_checkData();
        
        $mes = $this->GetMonthNameLong();
        $mes = strtolower($mes);
        $mes = substr($mes, 0, 3);
        return $mes;
    }
    
    /**
     * Retorna nome do dia da semana (Ex: Segunda-feira)
     *
     * @return string
     */
    public function GetDayOfWeekLong()
    {
        //Verifica se a data foi setada
        $this->_checkData();
        
        $dia = intval($this->GetDate('N'));
        
        switch ($dia) 
        {
            case 1:  return 'Segunda-feira';
            case 2:  return 'Terça-feira';
            case 3:  return 'Quarta-feira';
            case 4:  return 'Quinta-feira';
            case 5:  return 'Sexta-feira';
            case 6:  return 'Sábado';
            case 7:  return 'Domingo';
        }
    }
    
    /**
     * Retorna nome do dia da semana abreviado (Ex: seg)
     *
     * @return string
     */
    public function GetDayOfWeekShorten()
    {
        //Verifica se a data foi setada
        $this->_checkData();
        
        $dia = utf8_decode($this->GetDayOfWeekLong());
        $dia = strtolower($dia);
        $dia = utf8_encode(substr($dia, 0, 3));
        return $dia;        
    }
    
    /**
     * Retorna a data por extenso (Ex: 10 de Janeiro de 2008)
     *
     * @return string
     */
    public function GetFullDateForLong()
    {
        //Verifica se a data foi setada
        $this->_checkData();
        
        $dia = $this->GetDate('d');
        $mes = $this->GetMonthNameLong();
        $ano = $this->GetDate('Y');
        
        return $dia . ' de ' . $mes . ' de ' . $ano;
    }
    
    /**
     * Retorna a data por exteno abreviado (Ex: 10.jan.08)
     *
     * @return string
     */
    public function GetFullDateForShorten()
    {
        //Verifica se a data foi setada
        $this->_checkData();
        
        $dia = $this->GetDate('d');
        $mes = $this->GetMonthNameShorten();
        $ano = $this->GetDate('y');
        
        return $dia . '.' . $mes . '.' . $ano;
    }
    
}

#ENUMARADORES

/**
 * Enumerador do formato de data
 *
 */
class ENUM_DATE_FORMAT
{
    /**
     * Exemplo: 2008-12-01
     */
    const YYYY_MM_DD = 'Y-m-d';
    
    /**
     * Exemplo: 2008-12-01 23:59:59
     */
    const YYYY_MM_DD_HH_II_SS = 'Y-m-d H:i:s';
    
    /**
     * Exemplo: 01/12/2008
     */
    const DD_MM_YYYY = 'd/m/Y';
    
    /**
     * Exemplo: 01/12/2008 23:59:59
     *
     */
    const DD_MM_YYYY_DD_II_SS = 'd/m/Y H:i:s';
}
?>
