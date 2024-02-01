<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerDb')) define('DIR_ControllerDb', __DIR__.'/');
	include (realpath(DIR_ControllerDb.'model.php'));
    class  AptJobDb{ 
		public $db;
		public function __construct(){
			$this->db = new AptJobModel(); 
		}
		// ***
		public function QueryJobDB()	{
			return $this->db->QueryJobDB();
		}
		public function AddSchedule($schedule_id, $job_from_date, $job_to_date, $test_link_name)	{
			return $this->db->AddSchedule($schedule_id, $job_from_date, $job_to_date, $test_link_name);
		}
		public function AddJob($schedule_dbid, $job_id, $job_type, 
			$job_src_text, $job_py_text, $job_date,
			$test_link_name, $job_cost)	{
			return $this->db->AddJob($schedule_dbid, $job_id, $job_type, 
			$job_src_text, $job_py_text, $job_date,
			$test_link_name, $job_cost);
		}
		public function ChangeSchedule($schedule_dbid, $version_no, $job_from_date, $job_to_date)	{
			return $this->db->ChangeSchedule($schedule_dbid, $version_no, $job_from_date, $job_to_date);
		}
		public function ChangeJob($job_dbid, $version_no, $job_type, 
			$job_src_text, $job_py_text, $job_date,	
			$job_cost)	{
			return $this->db->ChangeJob($job_dbid, $version_no, $job_type, 
			$job_src_text, $job_py_text, $job_date,	
			$job_cost);
		}
		public function UpdateSchedule($schedule_dbid, $version_no, $job_from_date, $job_to_date){
			return $this->db->UpdateSchedule($schedule_dbid, $version_no, $job_from_date, $job_to_date);
		}

		public function UpdateJob($job_dbid, $version_no, $job_type, 
			$job_src_text, $job_py_text, $job_date,	
			$job_cost){
			return $this->db->UpdateJob($job_dbid, $version_no, $job_type, 
			$job_src_text, $job_py_text, $job_date,	
			$job_cost);
		}

		public function CloseSchdule($schedule_dbid, $is_closed){
			return $this->db->CloseSchdule($schedule_dbid, $is_closed);
		}


		public function DoneJob($job_dbid, $is_job_done, $job_done_date){
			return $this->db->DoneJob($job_dbid, $is_job_done, $job_done_date);
		}

		public function UpdateLiveStatus($live_status){
			return $this->db->UpdateLiveStatus($live_status);
		}
    }