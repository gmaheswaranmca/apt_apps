<?php 
	if(!isset($RUN))  exit(); 

	if (!defined('ROOTBASEDB')) define('ROOTBASEDB', __DIR__.'/');
	include_once (realpath(ROOTBASEDB.'../config.php'));

	define('DB_HOST', SQL_IP);
	define('DB_NAME', SQL_DATABASE);
	define('DB_USER', SQL_USER);
	define('DB_PASS', SQL_PWD);
	define('DB_PORT', SQL_PORT);

	class ar6PhpMySqlDao
	{
		public $m_db = NULL;
		private $m_connection_string = NULL;

		private $m_db_host = DB_HOST;	//private $m_db_host = 'mysqldb';     //     
		private $m_db_port = DB_PORT;   //private $m_db_port = '3306';     /  
		private $m_db_name = DB_NAME; 	
		private $m_db_user = DB_USER; //  private $m_db_user = 'root';     
		private $m_db_pass = DB_PASS;   // private $m_db_pass = '123456';

		   
		private $m_con = false;
		private $m_result = array();
		
		private $m_last_id;
		private $m_num_results;
		public $m_err;
		
		public function __construct()
		{
			$this->m_connection_string = "mysql:host=".$this->m_db_host."; port=".$this->m_db_port.";dbname=".$this->m_db_name;			
			//echo($this->m_connection_string.'\n');
		}
		public function connect()
		{	
			
			if(!$this->m_con)
			{
				try {
					$this->m_db = new PDO($this->m_connection_string, $this->m_db_user, $this->m_db_pass);
					
					$this->m_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->m_con = true;
					$this->db_write_tz_set();
					return $this->m_con;
				}
				catch (PDOException $v_e)
				{
					//echo('[[['.$this->m_db_user.' | '.$this->m_db_pass.' | '.$v_e->getMessage().']]]');
					return $v_e->getMessage();
				}
			}
			else
			{
				return true; //already connected, do nothing and show true
			}
		}
		public function disconnect()
		{
			if($this->m_con)
			{
				unset($this->m_db);$this->m_con = false;
				return true;
			}
		}
		public function db_write_tz_set()
		{
			try {
				$v_num_results = $this->m_db->exec("SET time_zone='".APT_TZ_OFFSET."';");
			}
			catch (PDOException $v_e)
			{
				$this->m_err = $v_e->getMessage();
			}	
		}
		public function db_write($p_sql, $p_param)
		{
			$this->connect();
			$this->m_err = "";
			//	
			try {
				// Statement And Params
				$v_stmt = $this->m_db->prepare($p_sql);
				$this->bindParam($v_stmt, $p_param);
				// Execute
				$v_stmt->execute();
				$v_last_id = $this->m_db->lastInsertId();
				$v_num_results = $v_stmt->rowCount();
				
				$this->m_last_id = $v_last_id;
				$this->m_num_results = $v_num_results;			
			}
			catch (PDOException $v_e)
			{
				$this->m_err = $v_e->getMessage();
			}	
			//
			$this->disconnect();
			//
			if($this->m_err === ""){return true;} else{return $this->m_err;}
		}
		public function db_write_batch($p_sql, $p_param)
		{
			$this->connect();
			$this->m_err = "";
			//	
			try {
				$sqllength = count($p_sql);
				$this->m_db->beginTransaction();
				for($x = 0; $x < $sqllength; $x++) {
					// Statement And Params
					$v_stmt = $this->m_db->prepare($p_sql[$x]);
					$this->bindParam($v_stmt, $p_param[$x]);
					// Execute
					$v_stmt->execute();
					$v_last_id = $this->m_db->lastInsertId();
					$v_num_results = $v_stmt->rowCount();
				}	
				$this->m_db->commit();
				
				
				//$this->m_last_id = $v_last_id;
				//$this->m_num_results = $v_num_results;			
			}
			catch (PDOException $v_e)
			{
				$this->m_err = $v_e->getMessage();
			}	
			//
			$this->disconnect();
			//
			if($this->m_err === ""){return true;} else{return $this->m_err;}
		}
		
		public function db_read($p_sql, $p_param, $p_read_as=1)
		{
			
			$this->connect();
			$this->m_err = "";
			//
			$v_fetch_kind = PDO::FETCH_ASSOC;
			//
			try {
				// Statement And Params
				$v_stmt = $this->m_db->prepare($p_sql);
				$this->bindParam($v_stmt, $p_param);
				// Execute
				$v_stmt->execute();
				$v_result = $v_stmt->fetchAll($v_fetch_kind);
				
				$v_num_results = count($v_result);
				if($v_num_results === 0){
					$v_result = null;
				}
				
				$this->result = $v_result;
				$this->m_num_results = $v_num_results;	
				//echo($v_num_results);			
			}
			catch (PDOException $v_e)
			{
				
				$this->m_err = $v_e->getMessage().''.$v_e->getTraceAsString().'';
				
				//echo($this->m_err);
			}	
			//
			$this->disconnect();
			//
			if($this->m_err === ""){return true;} else{return $this->m_err;}
		}
		private function bindParam($p_stmt, $p_param)
		{
			foreach($p_param as $v_key => $v_value) {
					$p_stmt->bindValue(':'.$v_key, $v_value);
				}
		}
		public function getResult()
		{
			return $this->result;
		}
		
	}?>