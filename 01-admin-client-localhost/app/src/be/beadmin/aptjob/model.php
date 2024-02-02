<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
	//include_once (realpath(ROOTDB.'../../../gf/ar6PhpUtil.php'));
    include (realpath(ROOTDB.'modelSql.php'));
	class AptJobModel{
		public $wmd = NULL;		
		public $sql = NULL;
		public $sqlRpt = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new AptJobModelSql();
		}

        //Live Tests Dashboard
		public function QueryJobDB()	{
			$schedule = $this->wmd->QueryNoParam($this->sql->QueryJobSchedule);
			$job = $this->wmd->QueryNoParam($this->sql->QueryJobBase);
			$schedule_ver = $this->wmd->QueryNoParam($this->sql->QueryJobScheduleVersion);
			$job_ver = $this->wmd->QueryNoParam($this->sql->QueryJobBaseVersion);

			$res = array("schedule" => $schedule, "job" =>$job, 
				"schedule_ver" => $schedule_ver ,"job_ver"=> $job_ver);

			return $res;
		}
		public function AddSchedule($schedule_id, $job_from_date, $job_to_date, $test_link_name){
			//
			$db_sql = array();
			$db_param = array();
			//
			$sql = $this->sql->InsertJobSchedule;
			$param = array('p_schedule_id' => $schedule_id, 'p_job_from_date' => $job_from_date, 
				'p_job_to_date' => $job_to_date, 'p_test_link_name' => $test_link_name);
			$idRes = $this->wmd->WriteIdParam($sql, $param);				
			$schedule_dbid = $idRes['last_id'];
			//
			$sql = $this->sql->InsertJobScheduleVersion;
			$param = array('p_schedule_dbid' => $schedule_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);	
			//			
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}
		public function AddJob($schedule_dbid, $job_id, $job_type, 
			$job_src_text, $job_py_text, $job_date,
			$test_link_name, $job_cost){
			//
			$db_sql = array();
			$db_param = array();
			//
			$sql = $this->sql->InsertJobBase;
			$param = array('p_schedule_dbid' => $schedule_dbid, 'p_job_id' => $job_id, 	'p_job_type' => $job_type, 
				'p_job_src_text' => $job_src_text,	'p_job_py_text' => $job_py_text, 'p_job_date' => $job_date,
				'p_test_link_name' => $test_link_name,	'p_job_cost' => $job_cost);
			$idRes = $this->wmd->WriteIdParam($sql, $param);
			$job_dbid = $idRes['last_id'];
			//
			$sql = $this->sql->InsertJobBaseVersion;
			$param = array('p_job_dbid' => $job_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//				
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}
		public function ChangeSchedule($schedule_dbid, $version_no, $job_from_date, $job_to_date){
			$db_sql = array();
			$db_param = array();
			//
			$version_no++;
			$sql = $this->sql->UpdateJobSchedule;
			$param = array('p_version_no' => $version_no, 
				'p_job_from_date' => $job_from_date, 'p_job_to_date' => $job_to_date,
				'p_schedule_dbid' => $schedule_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$sql = $this->sql->InsertJobScheduleVersion;
			$param = array('p_schedule_dbid' => $schedule_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}
		public function ChangeJob($job_dbid, $version_no, $job_type, 
			$job_src_text, $job_py_text, $job_date,	
			$job_cost){
			//
			$db_sql = array();
			$db_param = array();
			//
			$version_no++;
			$sql = $this->sql->UpdateJobBase;
			$param = array('p_version_no' => $version_no, 'p_job_type' => $job_type, 	
				'p_job_src_text' => $job_src_text,	'p_job_py_text' => $job_py_text, 'p_job_date' => $job_date,
				'p_job_cost' => $job_cost,
				'p_job_dbid' => $job_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$sql = $this->sql->InsertJobBaseVersion;
			$param = array('p_job_dbid' => $job_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}
		public function UpdateSchedule($schedule_dbid, $version_no, $job_from_date, $job_to_date){
			$db_sql = array();
			$db_param = array();
			//
			$sql = $this->sql->UpdateJobSchedule;
			$param = array('p_version_no' => $version_no, 
				'p_job_from_date' => $job_from_date, 'p_job_to_date' => $job_to_date,
				'p_schedule_dbid' => $schedule_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$sql = $this->sql->DeleteJobScheduleVersion;
			$param = array('p_schedule_dbid' => $schedule_dbid, 'p_version_no' => $version_no);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$sql = $this->sql->InsertJobScheduleVersion;
			$param = array('p_schedule_dbid' => $schedule_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}
		public function UpdateJob($job_dbid, $version_no, $job_type, 
			$job_src_text, $job_py_text, $job_date,	
			$job_cost){
			//
			$db_sql = array();
			$db_param = array();
			//
			$sql = $this->sql->UpdateJobBase;
			$param = array('p_version_no' => $version_no, 'p_job_type' => $job_type, 	
				'p_job_src_text' => $job_src_text,	'p_job_py_text' => $job_py_text, 'p_job_date' => $job_date,
				'p_job_cost' => $job_cost,
				'p_job_dbid' => $job_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$sql = $this->sql->DeleteJobBaseVersion;
			$param = array('p_job_dbid' => $job_dbid, 'p_version_no' => $version_no);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$sql = $this->sql->InsertJobBaseVersion;
			$param = array('p_job_dbid' => $job_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}
		public function CloseSchdule($schedule_dbid, $is_closed){
			$db_sql = array();
			$db_param = array();
			//
			$sql = $this->sql->UpdateCloseJobSchedule;
			$param = array('p_is_closed' => $is_closed,
				'p_schedule_dbid' => $schedule_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}
		public function DoneJob($job_dbid, $is_job_done, $job_done_date){
			//
			$db_sql = array();
			$db_param = array();
			//
			$sql = $this->sql->UpdateDoneJobBase;
			$param = array('p_is_job_done' => $is_job_done, 'p_job_done_date' => $job_done_date,
				'p_job_dbid' => $job_dbid);
			array_push($db_sql, $sql);
			array_push($db_param, $param);			
			//
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}

		public function UpdateLiveStatus($live_status){
			$db_sql = array();
			$db_param = array();
			//
			$sql = $this->sql->UpdateLiveStatus;
			$param = array('p_live_status' => $live_status);
			array_push($db_sql, $sql);
			array_push($db_param, $param);
			//
			$res = $this->wmd->WriteParam($db_sql, $db_param);
			return $res;
		}

    }
    		