<?php
	$RUN=TRUE;
	if(!isset($RUN))  exit(); 

	if (!defined('ROOTBASEDB')) define('ROOTBASEDB', __DIR__.'/');
	include_once (realpath(ROOTBASEDB.'../config.php'));

	define('DB_HOST', SQL_IP);
	define('DB_NAME', SQL_DATABASE);
	define('DB_USER', SQL_USER);
	define('DB_PASS', SQL_PWD);

function phpReqField($name, $default=''){
	$v_f = $default;
	if (isset($_GET[$name])) 	$v_f = $_GET[$name];
	elseif (isset($_POST[$name])) $v_f = $_POST[$name];	
	return $v_f;
}
	
class DBBkupRestore{
	private $conn = NULL;
	private $ext = NULL;
	public function __construct($host, $username, $password, $database_name){
		$this->conn = mysqli_connect($host, $username, $password, $database_name);	
		$this->conn->set_charset("utf8");
		$this->ext = new DBBkupRestoreExt();
	}	
	public function backupScriptGet(){
		$tables = $this->tablesGet();
		$sqlScript = $this->tablesScriptGet($tables);
		return $sqlScript;
	}
	public function bkupScriptRes($sqlScript){
		echo("<pre><xmp>".$sqlScript."</xmp></pre>");
	}
	private function tablesGet(){
		$conn = $this->conn;
	/**/$tables = array();
		$sql = "SHOW TABLES";
		$result = mysqli_query($conn, $sql);		
		while ($row = mysqli_fetch_row($result)) $tables[] = $row[0];				
		return $tables;
	}
	private function tablesScriptGet($tables){
		$conn = $this->conn;
		
		$sqlScript = "";
		foreach ($tables as $table) {    
			$sqlScript .= $this->tableCreateScriptGet($table, $sqlScript);
			$sqlScript .= $this->tableInsertScriptGet($table, $sqlScript);			
		}
		return $sqlScript;
	}
	private function tableCreateScriptGet($table){
		$conn = $this->conn;
		
		$query = "SHOW CREATE TABLE $table";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_row($result);
		
		$sqlScript = "";
		$sqlScript .= "\n\n" . $row[1] . ";\n\n";
		return $sqlScript;
	}
	private function tableInsertScriptGet($table){		
		$conn = $this->conn;
		$query = "SELECT * FROM $table";
		$result = mysqli_query($conn, $query);			
		$columnCount = mysqli_num_fields($result);		
		
		$sqlScript = "";		
		while ($row = mysqli_fetch_row($result)){
			if($sqlScript!=="") $sqlScript .=  ",";
			$sqlScript .= $this->tableInsertRowScriptGet($row, $columnCount);
		}
		
		if($sqlScript!=="")$sqlScript = "INSERT INTO $table VALUES" . $sqlScript . ";" . "\n";
		return $sqlScript;
	}
	private function tableInsertRowScriptGet($row,$columnCount){
		$sqlScript = "";
		for ($j = 0; $j < $columnCount; $j ++) {		
			$sqlScript .= "'" . mysql_real_escape_string($row[$j]) . "'";
			if(($j + 1) < $columnCount) $sqlScript .= ",";
		}
		$sqlScript = "(" . $sqlScript . ")";
		return $sqlScript;
	}	
	public function ScriptQuizTestGet($quiz_ids){  
		return $this->ScriptMakeGet($quiz_ids,$this->ext->sqlListQuizTest);
	}public function ScriptTestResultGet($quiz_ids){
		return $this->ScriptMakeGet($quiz_ids,$this->ext->sqlListTestResult);
	}private function ScriptMakeGet($quiz_ids, $sqlList){				
		$sqlScript="";
		foreach($sqlList as $mdSql){
			$table = $mdSql['table'];
			$sql = sprintf($mdSql['sql'],$quiz_ids);
			$resSql = $this->tableInsertScriptBySqlGet($table, $sql);
			$sqlScript .= $resSql['delete'];
			$sqlScript .= $resSql['insert'];			
		}					
		return $sqlScript;
	}private function tableInsertScriptBySqlGet($table,$sql){		
		$conn = $this->conn;
		$query = $sql;
		$result = mysqli_query($conn, $query);			
		$columnCount = mysqli_num_fields($result);		
		
		$sqlScript = "";		
		$sqlDelScript = "";	
		while ($row = mysqli_fetch_row($result)){
			if($sqlScript!=="") $sqlScript .=  ",";			
			$sqlScript .= $this->tableInsertRowScriptGet($row, $columnCount);
			if($sqlDelScript!=="") $sqlDelScript .=  ",";
			$sqlDelScript .= $row[0];
		}
		
		if($sqlScript!=="")$sqlScript = "INSERT INTO $table VALUES" . $sqlScript . ";
";
		if($sqlDelScript!=="")$sqlDelScript = "DELETE FROM $table WHERE id IN(" . $sqlDelScript . ");
";
		return array('insert'=>$sqlScript,'delete'=>$sqlDelScript);
	}
}

class DBBkupRestoreExt{
	public $sqlListQuizTest = array(
		array('table'=>'quizzes','sql'=>'SELECT a.* FROM quizzes a WHERE a.id in(%s);'),
		array('table'=>'questions','sql'=>'SELECT b.* FROM questions b WHERE b.quiz_id in(%s);'),
		array('table'=>'question_groups','sql'=>'SELECT c.* FROM questions b INNER JOIN question_groups c ON(b.id=c.question_id) WHERE b.quiz_id in(%s);'),
		array('table'=>'answers','sql'=>'SELECT d.* FROM questions b INNER JOIN question_groups c ON(b.id=c.question_id) INNER JOIN answers d ON(c.id=d.group_id) WHERE b.quiz_id in(%s);'),
		array('table'=>'assignments','sql'=>'SELECT b.* FROM assignments b WHERE b.quiz_id in(%s);'),
		array('table'=>'assignment_users','sql'=>'SELECT c.* FROM assignments b INNER JOIN assignment_users c ON(b.id=c.assignment_id) WHERE b.quiz_id in(%s);')
	);
	public $sqlListTestResult = array(
		array('table'=>'user_quizzes','sql'=>'SELECT d.* FROM assignments b INNER JOIN user_quizzes d ON(b.id=d.assignment_id) WHERE b.quiz_id in(%s);'),
		array('table'=>'user_answers','sql'=>'SELECT f.* FROM assignments b INNER JOIN user_quizzes d ON(d.assignment_id=b.id)  INNER JOIN user_answers f ON(d.id=f.user_quiz_id) WHERE b.quiz_id in(%s);')
	);
}
$query=phpReqField('query');
if($query=='dbbkup'){
	$dbutilBkup = new DBBkupRestore(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$dbutilBkup->bkupScriptRes($dbutilBkup->backupScriptGet());
}elseif($query=='test'){	
	$quizids=phpReqField('quizids');
	$dbutilBkup = new DBBkupRestore(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$dbutilBkup->bkupScriptRes($dbutilBkup->ScriptQuizTestGet($quizids));	
}elseif($query=='result'){
	$quizids=phpReqField('quizids');
	$dbutilBkup = new DBBkupRestore(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	$dbutilBkup->bkupScriptRes($dbutilBkup->ScriptTestResultGet($quizids));
}		