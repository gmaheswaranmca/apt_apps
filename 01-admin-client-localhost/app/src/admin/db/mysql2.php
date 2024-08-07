<?php
function escape($value) {
    $return = '';
    for($i = 0; $i < strlen($value); ++$i) {
        $char = $value[$i];
        $ord = ord($char);
        if($char !== "'" && $char !== "\"" && $char !== '\\' && $ord >= 32 && $ord <= 126)
            $return .= $char;
        else
            $return .= '\\x' . dechex($ord);
    }
    return $return;
}
class db
{
    var $link;
    

    public function connect()
    {
       $this->link=mysqli_connect(SQL_IP,SQL_USER,SQL_PWD,SQL_DATABASE) or die(db::error($this->link));
       //return mysqli_select_db(SQL_DATABASE, $this->link) or die(db::error());
    }

    public function begin()
    {
        $query = "SET AUTOCOMMIT=0";
        mysqli_query($this->link,$query) or die(db::error($this->link));
        $query = "BEGIN";
        mysqli_query($this->link,$query) or die(db::error($this->link));

    }

    public function query($query)
    {
        if(DEBUG_SQL=="yes") debug::AddSQL ($query);
        $results = mysqli_query($this->link,$query) ;
        if(!$results) throw new Exception(db::myerror($this->link,$query));
        return $results;
    }

    public function insert_query($query)
    {
        //echo $query."<br>";
        if(DEBUG_SQL=="yes") debug::AddSQL ($query);
        mysqli_query($this->link,$query) ;        
        $results = mysqli_insert_id($this->link);
        if(!$results) throw new Exception(db::myerror($this->link,$query));
        return $results;
    }

    public function free($result)
    {
        mysqli_free_result($result);
    }

    public function multi_query($query)
    {
        if(DEBUG_SQL=="yes") debug::AddSQL ($query);
        $results = mysqli_multi_query($query,$this->link) ;
        if(!$results) throw new Exception(db::myerror($this->link,$query));
        return $results;
    }

    public function rollback()
    {
        mysqli_query($this->link,"ROLLBACK");
    }

    public function commit()
    {
        mysqli_query($this->link,"COMMIT");
    }

    public function last_id()
    {
        return mysqli_insert_id($this->link);
    }

    public static function exec_sql($query)
    {
        //echo $query."<br>";
        //exit;
	$link=mysqli_connect(SQL_IP, SQL_USER, SQL_PWD,SQL_DATABASE) or die(db::error($link));
        if(DEBUG_SQL=="yes") debug::AddSQL ($query);
	$results=mysqli_query($link,$query) or die(db::myerror($link,$query));
	mysqli_close($link);
	return $results;
    }

    public static function exec_insert($query)
    {
	$link=mysqli_connect(SQL_IP, SQL_USER, SQL_PWD,SQL_DATABASE) or die(db::error($link));
        if(DEBUG_SQL=="yes") debug::AddSQL ($query);
	mysqli_query($link,$query) or die(db::myerror($link,$query));
        $results = mysqli_insert_id($link);
	mysqli_close($link);
	return $results;
    }

    public static function GetResultsAsArray($query)
    {
        $res=array();
	$results=db::exec_sql($query);

	while($rows=mysqli_fetch_array($results))
	{
		$res[]=$rows;
	}
	return $res;
    }

    public static function GetResultsAsArrayByColumn($query, $column)
    {
        $res=array();
	$results=db::exec_sql($query);
        $i=0;
	while($rows=mysqli_fetch_array($results))
	{
		$res[$i]=$rows[$column];
                $i++;
	}
	return $res;
    }

    public static function exec_multi_sql($query)
    {
	$link=mysqli_connect(SQL_IP, SQL_USER, SQL_PWD,SQL_DATABASE) or die(db::error($link));
        if(DEBUG_SQL=="yes") debug::AddSQL ($query);
	$results=mysqli_multi_query($link,$query) or die(db::myerror($link,$query));
	mysqli_close($link);
	return $results;
    }

    public static function error($lnk)
    {
        die (mysqli_error($lnk));
    }

    public static function myerror($lnk,$query)
    {
        $msg=mysqli_error($lnk);
        if(DEBUG_SQL=="yes")
        {
            $msg.=" - ".$query;
        }
        die ($msg);
    }
 

    public static function clear($str)
    {
        //return mysql_escape_string($str);
        //return escape($str);
        return $str;
        //return mysqli_real_escape_string($str);
    }

    public static function fetch($results)
    {
       $row=mysqli_fetch_array($results);
       return $row;
    }

    public static function num_fields($results)
    {
        return mysqli_num_fields($results);
    }

     public static function num_rows($results)
    {
        return mysqli_num_rows($results);
    }

    public static function esp($str)
    {
        //return mysql_escape_string($str);
        /*
            https://stackoverflow.com/questions/1162491/alternative-to-mysql-real-escape-string-without-connecting-to-db
        */
        //return escape($str);
        return $str;
        //return mysqli_real_escape_string($this->link, $str);
    }

    public function close_connection()
    {
       mysqli_close($this->link);
    }
}

class debug
{
    public static function AddSQL($sql)
    {
        $file = basename($_SERVER["SCRIPT_NAME"]);
        if($file=="login.php") return;

        if(!isset($_SESSION['sql']))
        {
            $_SESSION['sql'] = array();
            $_SESSION['sql_i'] = 0;
        }

        $queries = $_SESSION['sql'];
        $i = intval($_SESSION['sql_i']);

        $queries[$i] = $sql;
        $i++ ;

        $_SESSION['sql']= $queries;
        $_SESSION['sql_i'] = $i;
    }
    
    public static function GetSQLs()
    {
        if(!isset($_SESSION['sql']))
        {
            $_SESSION['sql'] = array();
            $_SESSION['sql_i'] = 0;
        }
        $queries = $_SESSION['sql'];
        //$_SESSION['sql'] = array();
        //$_SESSION['sql_i'] =0;
        return $queries;
    }
}

?>