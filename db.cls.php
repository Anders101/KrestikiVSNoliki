<?PHP

class XDB {

	private $query_count = 0;
	
	function getQueryCount()
	{
		return $this->query_count;
	}
	
	function setQueryCount($val = 0)
	{
		$this->query_count = $val;
	}
        
    private static $m_Instance = null;
        
    /**
     * Singletone
     *
     * @return XDB
     */
    static function I ()
    {
        if (self::$m_Instance == null)
        {
            self::$m_Instance = new XDB();
        }
        
        return self::$m_Instance;
    }

    // конструктор
    protected function __construct() {
        $this->Connect();
    }
        
    /** 
    * @return void
    * @param string $a_DbHost
    * @param string $a_DbUserName
    * @param string $a_DbPass
    * @param string $a_DbName
    * @desc ������������ � ���� ������. ������������ ������������� ��� �������������
    */
	function SelBase($base = "") 
    {        
		
		if($base == "")
		{
			$base = trim(DBBASE);
		}
		mysql_select_db($base);  
	}
	
	function Connect() 
    {        
        
        $host = trim(DBHOST);
        $user = trim(DBUSER);
        $pass = trim(DBPASS);
        //$base = trim(DBBASE);
        if (!mysql_connect($host, $user, $pass))
        {
            throw new XException('Невозможно соединиться с Базой Данных: ', mysql_error());
        }
        //mysql_select_db($base); 
		$this->SelBase();

        $this->SendSql("SET NAMES utf8");
    }    

    /**
    * @return array
    * @param string $a_Sql - ������ sql 
    * @param string $a_Params - ������ � �������������
    * @desc �������� ��������� ����� ������ �� �������
    */
    function FetchCollection ($a_Sql, $a_Params = array(), $a_id_as_key = false, $a_use_assoc_only = false, $primary_key = "id")
    {
		$this->query_count++;
		$fetch_options = MYSQL_BOTH;
		if($a_use_assoc_only)
		{
			$fetch_options = MYSQL_ASSOC;
		}
		$res = $this->SendSql($this->CreateSqlCode($a_Sql, $a_Params));
                
        $collection = array();
        
		if(!$a_id_as_key) 
		{
			for ($i=0; $i<mysql_num_rows($res); $i++)
			{
				$collection[$i] = mysql_fetch_array($res, $fetch_options);            
			}		
		}
		else // используем id записей в качестве ключей массива
		{
			for ($i=0; $i<mysql_num_rows($res); $i++)
			{
				
				$new_row = mysql_fetch_array($res, $fetch_options);  
				if($primary_key == 'id')
					$collection[(int)$new_row[$primary_key]] = $new_row;    
				else
					$collection[$new_row[$primary_key]] = $new_row;    
			}		
		}
        
        mysql_free_result($res);
        
        return $collection;                
    }    
    
        /**
    * @return array
    * @param string $a_Sql - ������ sql 
    * @param string $a_Params - ������ � �������������
    * @desc �������� ��������� ����� ������ �� �������
    */
    function FetchCollectionIndexedById ($a_Sql, $a_Params = array())
    {
        $res = $this->SendSql($this->CreateSqlCode($a_Sql, $a_Params));
                
        $collection = array();
        
        for ($i=0; $i<mysql_num_rows($res); $i++)
        {
            $row = mysql_fetch_array($res);
            $collection[$row['id']] = $row;
        }
        
        mysql_free_result($res);
        
        return $collection;
    }    
        
    /**
     * ��������� ������
     *
     * @param string $a_Sql
     * @return resource
     */
	private $sends_count = 0;

	public function getSendsCount()
	{
		return $this->sends_count;
	}
	 
    private function SendSql ($a_Sql)
    {
		//$this->sends_count ++;
        //echo $a_Sql."<br>";
        //$t1 = microtime();
        $res = mysql_query($a_Sql);
        //$t2 = microtime();
        //$time = $t2-$t1;
        //$h = fopen("logsql.txt", "a");
        //fwrite($h,$time." : ". $a_Sql."\n");
        //fclose($h);
        if (!$res)
        {
            //throw new Exception();
            $message = 'SQL: ' . $a_Sql . "\nComments: " . mysql_error();
           //echo $message."<br/>\n";
			throw new XException("SQL Error ($message)", $message);
        }
        
        return $res;
    }
    
    /**
    * @return array
    * @param XDB $a_Sql - ������ sql
    * @param string $a_Params - ������ � �������������
    * @desc �������� ������ ������ ������ �� �������.
    */
    function FetchDataRow ($a_Sql, $a_Params = array())
    {          
		$this->query_count++;
        $res = $this->SendSql($this->CreateSqlCode($a_Sql, $a_Params));
        $dataRow = mysql_fetch_array($res);
        if (mysql_num_rows($res) > 1)
        {
            $message = '� ���������� ������� ���������� ����� ����� ������. 
������: ' . $a_Sql . '
���������: ' . print_r($a_Params, true);
            
            throw new XInnerSecurityException($message);
        }
        
        mysql_free_result($res);        
        
        return $dataRow;            
    }
    
    
    /**
    * @return int
    * @param string $a_Sql - ������ sql 
    * @param string $a_Params - ������ � �������������
    * @desc ��������� ������������� ������
    */
    function Sql ($a_Sql, $a_Params = array())
    {
        $res = $this->SendSql($this->CreateSqlCode($a_Sql, $a_Params));
    }    
    
    /**
    * @return bool
    * @param string $a_Sql
    * @param string $a_Params - ������ � �������������
    * @desc �������� �� ������� ���������� �������.
    */
    function getNumRows ($a_Sql, $a_Params = array())
    {
        $res = $this->SendSql($this->CreateSqlCode($a_Sql, $a_Params));
        return (int) mysql_num_rows($res);        
    }    
    
    /**
     * �������� ��������� ��������������� id
     *
     * @return int 
     */
    function LastInsertId ()
    {
        return mysql_insert_id();        
    }
    
    /**
     * ��������� ����������� ���������� � �������
     *
     * @param string $a_SqlPattern ������ � �����������
     * @param arrar() $a_Params ��������� �������
     * @return string
     */
    function CreateSqlCode ($a_SqlPattern, $a_Params)
    {
        if ($a_Params === null)
        {
            return $a_SqlPattern;
        }
        
        $res = $a_SqlPattern;
        
        foreach ($a_Params as $key => $value)
        {
            $res = str_replace('@' . $key, $this->PrepareParam($value), $res);    
            
        }        
        return $res;
    }
    
    private function PrepareArray ($a_Array)
    {
        if (count($a_Array) == 0)
        {
            return array();
        }
        
        if (@!is_array($a_Array[0]))
        {
            return $a_Array;
        }
        
        $resArray = array();
        
        list($key) = array_keys($a_Array[0]);
        
        foreach ($a_Array as $record)
        {
            $resArray[] = $record[$key];
        }
        
        return $resArray;        
    }
    
    /**
     * ���������� �������� ���������� ��������. ��������, �������� ��������� ������� 
     * �� \'
     *
     * @param unknown_type $a_ParamValue
     * @return unknown
     */
    public function PrepareParam ($a_ParamValue)
    {
        if (is_int($a_ParamValue) || is_float($a_ParamValue)){
            return $a_ParamValue;
        }
        
        if ($a_ParamValue == '')
        {
            return "''";
        }
        
        if (is_array($a_ParamValue))
        {
            if (count($a_ParamValue) == 0)
            {
                return '(0)';
            }
            
            $safeArray = array();
            
            foreach ($this->PrepareArray($a_ParamValue) as $value)
            {
                $safeArray [] = $this->PrepareParam($value);                
            }
            
            return '(' . implode(',', $safeArray) . ')';    
        }
        
        if ($a_ParamValue[0] == '@')
        {
            return substr($a_ParamValue, 1);
        }
        
        //echo mysql_escape_string$a_ParamValue);
        return '\'' . $this->EscapeString($a_ParamValue) . '\'';     
    }    
    
    private function EscapeString ($a_String){
         return mysql_real_escape_string($a_String);
     }
    
    function Insert ($a_TableName, $a_Values)
    {
		$this->query_count++;
        $safeParams = array();
        $fields = array();
        foreach ($a_Values as $key => $value)
        {
            $safeParams[] = $this->PrepareParam($value);                    
            $fields[] = $key;
        }

        $this->Sql('INSERT INTO ' . $a_TableName . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $safeParams) . ')');        
    }
    
    function Delete ($a_TableName, $a_Id)
    {
		$this->query_count++;
        $this->Sql('DELETE FROM ' . $a_TableName . ' WHERE ID IN @id', array('id' => is_array($a_Id) ? $a_Id : array(0 => $a_Id)));        
    }
    
    function Update ($a_TableName, $a_Id, $a_Values, $pr_key = "id")
    {
		$this->query_count++;
        $statements = array();
        
        foreach ($a_Values as $key => $value)
        {
            $statements[] = $key . '=' . $this->PrepareParam($value);                        
        }
        
        $this->Sql('UPDATE ' . $a_TableName . ' SET ' . implode(',', $statements) . ' WHERE '.$pr_key.' IN @id', array('id' => is_array($a_Id) ? $a_Id : array(0 => $a_Id)));                    
    }
}