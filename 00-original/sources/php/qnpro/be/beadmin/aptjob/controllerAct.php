<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerAct')) define('DIR_ControllerAct', __DIR__.'/');
	include_once (realpath(DIR_ControllerAct.'../../../gf/ar6PhpUtil.php'));

	/* Link Name */
	function qInput($f){
		global $phpUtil;
		return $phpUtil->field($f,'');
	}
	$linkName = qInput('LinkCodeName');
	if($linkName!=='')	$RestLinkName = $linkName;
	/* End Link Name */
	
	include (realpath(DIR_ControllerAct.'controllerDb.php'));

    class AptJobController{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new AptJobDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}
		// 
        public function QueryJobDB(){
			$JobDB = $this->dodb->QueryJobDB();		
		    //
            $lret = $JobDB; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		//
		public function AddSchedule(){
			$schedule_id = $this->q('schedule_id');
			$job_from_date = $this->q('job_from_date');
			$job_to_date = $this->q('job_to_date');
			$test_link_name = $this->q('test_link_name');

			$res = $this->dodb->AddSchedule($schedule_id, $job_from_date, $job_to_date, $test_link_name);		
		    //
            $lret = $this->dodb->QueryJobDB();
			$lret['write_res'] = $res; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		//
		public function AddJob(){
			$schedule_dbid = $this->q('schedule_dbid');
			$job_id = $this->q('job_id');
			$job_type = $this->q('job_type');
			$job_src_text = $this->q('job_src_text');
			$job_py_text = $this->q('job_py_text');
			$job_date = $this->q('job_date');
			$test_link_name = $this->q('test_link_name');
			$job_cost = $this->q('job_cost');

			$res = $this->dodb->AddJob($schedule_dbid, $job_id, $job_type, 
				$job_src_text, $job_py_text, $job_date,
				$test_link_name, $job_cost);		
		    //
			$lret = $this->dodb->QueryJobDB();
			$lret['write_res'] = $res; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		//
		public function ChangeSchedule(){
			$schedule_dbid = $this->q('schedule_dbid');
			$version_no = $this->q('version_no');
			$job_from_date = $this->q('job_from_date');
			$job_to_date = $this->q('job_to_date');
			

			$res = $this->dodb->ChangeSchedule($schedule_dbid, $version_no, $job_from_date, $job_to_date);		
		    //
            $lret = $this->dodb->QueryJobDB();
			$lret['write_res'] = $res;  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		//
		public function ChangeJob(){
			$job_dbid = $this->q('job_dbid');
			$version_no = $this->q('version_no');			
			$job_type = $this->q('job_type');
			$job_src_text = $this->q('job_src_text');
			$job_py_text = $this->q('job_py_text');
			$job_date = $this->q('job_date');
			
			$job_cost = $this->q('job_cost');

			$res = $this->dodb->ChangeJob($job_dbid, $version_no, $job_type, 
				$job_src_text, $job_py_text, $job_date,	
				$job_cost);		
		    //
            $lret = $this->dodb->QueryJobDB();
			$lret['write_res'] = $res; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		//
		public function UpdateSchedule(){
			$schedule_dbid = $this->q('schedule_dbid');
			$version_no = $this->q('version_no');
			$job_from_date = $this->q('job_from_date');
			$job_to_date = $this->q('job_to_date');
			

			$res = $this->dodb->UpdateSchedule($schedule_dbid, $version_no, $job_from_date, $job_to_date);		
		    //
            $lret = $this->dodb->QueryJobDB();
			$lret['write_res'] = $res; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		//
		public function UpdateJob(){
			$job_dbid = $this->q('job_dbid');
			$version_no = $this->q('version_no');			
			$job_type = $this->q('job_type');
			$job_src_text = $this->q('job_src_text');
			$job_py_text = $this->q('job_py_text');
			$job_date = $this->q('job_date');
			
			$job_cost = $this->q('job_cost');

			$res = $this->dodb->UpdateJob($job_dbid, $version_no, $job_type, 
				$job_src_text, $job_py_text, $job_date,	
				$job_cost);		
		    //
            $lret = $this->dodb->QueryJobDB();
			$lret['write_res'] = $res; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		//
		public function CloseSchdule(){
			$schedule_dbid = $this->q('schedule_dbid');
			$is_closed = $this->q('is_closed');
			

			$res = $this->dodb->CloseSchdule($schedule_dbid, $is_closed);		
		    //
            $lret = $this->dodb->QueryJobDB();
			$lret['write_res'] = $res;  
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		//
		public function DoneJob(){
			$job_dbid = $this->q('job_dbid');
			$is_job_done = $this->q('is_job_done');			
			$job_done_date = $this->q('job_done_date');
			
			$job_cost = $this->q('job_cost');

			$res = $this->dodb->DoneJob($job_dbid, $is_job_done, $job_done_date);		
		    //
            $lret = $this->dodb->QueryJobDB();
			$lret['write_res'] = $res; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}//
		public function UpdateLiveStatus(){
			$live_status = $this->q('live_status');
			$res = $this->dodb->UpdateLiveStatus($live_status);		
			//
			$lret['write_res'] = $res; 
            //			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
    }