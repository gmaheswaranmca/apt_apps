<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
    include (realpath(ROOTDB.'modelSql.php'));
	class SysAdmModel{
		public $wmd = NULL;		
		public $sql = NULL;
		public $sqlRpt = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new SysAdmModelSql();
		}

        //Live Tests Dashboard
		public function QueryNow()	{
			return $this->wmd->QueryNoParam($this->sql->QueryNow);
		}


        public function QueryTestCountTotal()	{
			return $this->wmd->QueryNoParam($this->sql->QueryTestCountTotal);
		}public function QueryTestCountLive()	{
			return $this->wmd->QueryNoParam($this->sql->QueryTestCountLive);
		}public function QueryTestCountAnswered()	{
			return $this->wmd->QueryNoParam($this->sql->QueryTestCountAnswered);
		}public function QueryTestStatus()	{			
			return $this->wmd->QueryNoParam($this->sql->QueryTestStatus);
		}public function QueryTestIsDemo()	{			
			return $this->wmd->QueryNoParam($this->sql->QueryTestIsDemo);
		}public function WriteAssignmentSetStatus($p_assignment_id,$p_status)	{		
			return $this->wmd->WriteParam(
				array($this->sql->WriteAssignmentSetStatus), 
				array(
					array("p_assignment_id" => $p_assignment_id,
						"p_status" => $p_status)
					)
				);
		}

		//
		public function QueryCodeQnTestCountTotal()	{
			return $this->wmd->QueryNoParam($this->sql->QueryCodeQnTestCountTotal);
		}public function QueryCodeQnTestCountLive()	{
			return $this->wmd->QueryNoParam($this->sql->QueryCodeQnTestCountLive);
		}public function QueryCodeQnTestCountAnswered()	{
			return $this->wmd->QueryNoParam($this->sql->QueryCodeQnTestCountAnswered);
		}public function QueryCodeQnTestStatus()	{			
			return $this->wmd->QueryNoParam($this->sql->QueryCodeQnTestStatus);
		}public function QueryCodeQnTestIsDemo()	{			
			return $this->wmd->QueryNoParam($this->sql->QueryCodeQnTestIsDemo);
		}public function QueryCodeQnTestCases()	{			
			return $this->wmd->QueryNoParam($this->sql->QueryCodeQnTestCases);
		}public function WriteCodeQnAssignmentSetStatus($p_assignment_id,$p_status)	{		
			return $this->wmd->WriteParam(
				array($this->sql->WriteCodeQnAssignmentSetStatus), 
				array(
					array("p_assignment_id" => $p_assignment_id,
						"p_status" => $p_status)
					)
				);
		}

		//
		public function QueryAppHmStartup()	{
			$apps = $this->wmd->QueryNoParam($this->sql->QueryAppHmApps);
			$servers = $this->wmd->QueryNoParam($this->sql->QueryAppHmServers);
			
			$res = array('apps' => $apps, 'servers' => $servers);			
			return $res;
		}
		private function QueryMetaProcess($sql)	{
			$r = $this->wmd->QueryNoParamMeta($sql);
			$table_name = $r['column'][0]['table'];
			$column_list = '';
			$param_list = '';
			
			$table_name = $r['column'][0]['table'];
			$sqls = array();
			for($i = 0; $i < count($r['data']); $i++){
				$row = $r['data'][$i];
				$params = array();
				for($j=0;$j<count($r['column']);$j++){
					$column = $r['column'][$j];
					$column_name = $column['name'];
					if($i==0) $column_list .=($j > 0 ? ',' : '') . $column_name ;
					if($i==0) $param_list .= ($j > 0 ? ',' : '') . ':p_' . $column_name;
					$data = $row[$column_name];
					$params['p_' . $column_name]  = $data;					
				}
				$stmt = "INSERT INTO t_" . $table_name . "(" . $column_list . ")" 
						. "VALUES(" . $param_list . ")";
				array_push($sqls,array('sql' => $stmt, 'param' => $params));
			}

			$db_sql = array();
			$db_param = array();
			array_push($db_sql,"DELETE FROM t_" . $table_name . "");
			array_push($db_param,array());
			for($i = 0; $i < count($sqls); $i++){
				$a_sql = $sqls[$i];
				array_push($db_sql, $a_sql['sql']);
				array_push($db_param, $a_sql['param']);
			}

			//$qz = $this->QueryMetaProcess("SELECT * FROM quizzes");
			//$qn = $this->QueryMetaProcess("SELECT * FROM questions");
			
			
			//$wr_res = $this->wmd->WriteParam($qz['db_sql'], $qz['db_param']);
			/*ob_start();
			var_dump($wr_res);
			$wr_res2 = ob_get_clean();*/

			//$wr_res2 = var_export($wr_res, true);

			return array('db' => $r, 'sqls' => $sqls, 'db_sql' => $db_sql, 'db_param' => $db_param);
		}
		public function QueryMeta()	{
			$tables = array('users', 'cats', 'quizzes', 'apt_tp_rule', 'questions', 
				'question_groups', 'answers', 'user_quizzes', 'user_answers',
				'tcode_q_base', 'tcode_q_testcase', 'tcode_q_group_base', 'tcode_q_group_q',
				'tcode_language','tcode_level',
				'tcode_assess_base','tcode_assess_user',
				'tcode_assess_submit_q','tcode_assess_submit_testcase'
				);
			$db = $this->DbMeta($tables);
			$db_sql = $this->DBSQL($db);
			$batch = $this->DBSQLToBatch($db_sql);
			
			$res = array('db' => $db, 'db_sql' => $db_sql, 'batch' => $batch);			
			return $res;
		}
		private function EachTableMeta($table)	{
			$result = array('table' => $table);
			$sql = 'SELECT * FROM ' . $table;
			$data = $this->wmd->QueryNoParam($sql);
			$result['data'] = $data;
			return $result;
		}
		private function DbMeta($tables)	{
			$db = array();			
			for($i = 0; $i < count($tables); $i++){
				$table = $tables[$i];
				array_push($db, $this->EachTableMeta($table));
			}
			return $db;
		}
		private function EachTableSQL($db_table)	{
			$db_clean_sql = array();
			$db_clean_param = array();

			$db_sql = array();
			$db_param = array();

			$table_name = $db_table['table'];
			$data_rows = $db_table['data'];
			

			array_push($db_clean_sql, 'DELETE FROM ' . $table_name);
			array_push($db_clean_param, array());

			array_push($db_clean_sql, 'ALTER TABLE ' . $table_name . ' AUTO_INCREMENT =1;' );
			array_push($db_clean_param, array());

			for($i = 0; $i < count($data_rows); $i++){
				$column_list = '';
				$param_list = '';
				$row = $data_rows[$i];
				$params = array();
				
				foreach ($row as $column_name  => $data) {
					$column_list .=($column_list !== '' ? ',' : '') . $column_name ;
					$param_list .=($param_list !== '' ? ',' : '') . ':p_' . $column_name;					
					$params['p_' . $column_name]  = $data;
				}
				$stmt = "INSERT INTO " . $table_name . "(" . $column_list . ")" 
						. "VALUES(" . $param_list . ")";
				array_push($db_sql, $stmt);
				array_push($db_param, $params);
			}

			return array('db_clean_sql' => $db_clean_sql, 'db_clean_param' => $db_clean_param, 
						 'db_sql' => $db_sql, 			  'db_param' => $db_param, 'count_data' => count($data_rows));
		}
		private function EachTableSQLV2($db_table)	{
			$db_clean_sql = array();
			$db_clean_param = array();

			$db_sql = array();
			$db_param = array();

			$table_name = $db_table['table'];
			$data_rows = $db_table['data'];
			

			array_push($db_clean_sql, 'DELETE FROM ' . $table_name);
			array_push($db_clean_param, array());

			array_push($db_clean_sql, 'ALTER TABLE ' . $table_name . ' AUTO_INCREMENT =1;' );
			array_push($db_clean_param, array());

			$column_list = '';
			$stmt = '';
			$params = array();
			$j = 0;
			for($i = 0; $i < count($data_rows); $i++){
				
				$param_list = '';
				$row = $data_rows[$i];
				
				
				foreach ($row as $column_name  => $data) {
					if($i === 0) $column_list .=($column_list !== '' ? ',' : '') . $column_name ;
					$param_list .=($param_list !== '' ? ',' : '') . '?';					
					$params[]  = $data;
				}
				if($i != 0){
					
				}

				if($j == 0)	$stmt = "INSERT INTO " . $table_name . "(" . $column_list . ")" . "VALUES (" . $param_list . ")";
				else $stmt .= ", (" . $param_list . ")";
				
				$j += 1;
				$j %= 1000;
				if($j == 0){
					array_push($db_sql, $stmt);
					array_push($db_param, $params);
					
					$stmt = '';
					$params = array();
				}
			}
			if($j != 0){
				array_push($db_sql, $stmt);
				array_push($db_param, $params);
			}

			return array('db_clean_sql' => $db_clean_sql, 'db_clean_param' => $db_clean_param, 
						 'db_sql' => $db_sql, 			  'db_param' => $db_param, 'count_data' => count($data_rows));
		}
		private function DBSQL($db)	{
			$db_sql = array();			
			for($i = 0; $i < count($db); $i++){
				$db_table = $db[$i];
				array_push($db_sql, $this->EachTableSQLV2($db_table));
			}
			return $db_sql;
		}
		private function DBSQLToBatch($db_sql)	{
			$batch_sql = array();
			$batch_param = array();
			for($i = count($db_sql) - 1; $i >= 0 ; $i--){
				$db_clean_sql_st = $db_sql[$i]['db_clean_sql'];
				$db_clean_param = $db_sql[$i]['db_clean_param'];


				$batch_sql = array_merge($batch_sql, $db_clean_sql_st);
				$batch_param = array_merge($batch_param, $db_clean_param);
			}

			for($i =  0; $i < count($db_sql) ; $i++){
				$db_sql_st = $db_sql[$i]['db_sql'];
				$db_param = $db_sql[$i]['db_param'];

				$batch_sql = array_merge($batch_sql, $db_sql_st);
				$batch_param = array_merge($batch_param, $db_param);
			}
			return array('batch_sql' => $batch_sql, 'batch_param' => $batch_param);
		}
		

		public function DoDownload()	{
			$time_start = microtime(true); 
			$tables = array('users', 'cats', 'quizzes', 'apt_tp_rule', 'questions', 
				'question_groups', 'answers', 
				'assignments', 'assignment_users',
				'user_quizzes', 'user_answers',
				'tcode_q_base', 'tcode_q_testcase', 'tcode_q_group_base', 'tcode_q_group_q',
				'tcode_language','tcode_level',
				'tcode_assess_base','tcode_assess_user',
				'tcode_assess_submit_q','tcode_assess_submit_testcase'
				);
			$db = $this->DbMeta($tables);
						
			$time_end = microtime(true);
			//dividing with 60 will give the execution time in minutes otherwise seconds
			$execution_time = ($time_end - $time_start);
			$res = array('db' => $db, 'execution_time' => $execution_time); //, 'dbp' => var_export($db, true), 'dbp2' => var_export(json_decode(json_encode($db),true),true));			
			return $res;
		}

		public function DoUpload($db)	{
			set_time_limit(0);
			//place this before any script you want to calculate time
			$time_start = microtime(true); 

			$db = json_decode(json_encode($db),true);
			$db_sql = $this->DBSQL($db);//var_export($db, true);//;
			$batch = $this->DBSQLToBatch($db_sql);//false;//

			$batch_sql = $batch['batch_sql'];
			$batch_param = $batch['batch_param'];
			$result = array('status' => 'Not Uploaded');
			//Write Operation 
			$result = $this->DoUploadWrite($batch_sql, $batch_param);
			$result = array('status' => 'Uploaded', 'result' => $result);
			

			$time_end = microtime(true);
			//dividing with 60 will give the execution time in minutes otherwise seconds
			$execution_time = ($time_end - $time_start);
			$res = array('batch' => $batch, 'result' => $result, 'overall_execution_time' => $execution_time);			
			return $res;
		}

		public function DoUploadWrite($batch_sql, $batch_param){
			//place this before any script you want to calculate time
			$time_start = microtime(true); 

			//script
			$result = 'SQL is not Executed';
			$result = $this->wmd->WriteParamBulk($batch_sql, $batch_param);

			$time_end = microtime(true);
			//dividing with 60 will give the execution time in minutes otherwise seconds
			$execution_time = ($time_end - $time_start);

			return array('script_result' => $result, 'execution_time' => $execution_time);
		}
    }
    		