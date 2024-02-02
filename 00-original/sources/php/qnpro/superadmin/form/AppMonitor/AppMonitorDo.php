<?php 
	$RUN = 1;
	if(!isset($RUN)) 				  exit(); 
	if (!defined('DIR_AppMonitor')) define('DIR_AppMonitor', __DIR__.'/');
	include (realpath(DIR_AppMonitor.'../../../gf/ar6PhpUtil.php'));
	include (realpath(DIR_AppMonitor.'../../../gf/LinuxModule.php'));
	include (realpath(DIR_AppMonitor.'AppMonitorModel.php'));

	class AppMonitorDoNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new AppMonitorDo();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 			
			switch($v_m){
				case 'vPage': 				$ext->vPage(); 			break;
				case 'mdTestStatus': 		$ext->mdTestStatus(); 	break;
				case 'mdResultDownload': 	$ext->mdResultDownload(); 	break;
				case 'mdAssessmentUpdateStatus': 		$ext->mdAssessmentUpdateStatus(); 	break;
				//case 'mdFinishAssessment': 	$ext->mdFinishAssessment(); 	break;
			}
		}
	}
	new AppMonitorDoNav();	
	class AppMonitorDo{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new AppMonitorDoDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}public function vPage(){
			$vPage = $this->phpUtil->output_form(realpath(DIR_AppMonitor.'ViewPage.php'));
			$vSecret = $this->phpUtil->output_form(realpath(DIR_AppMonitor.'../Generic/ViewSecret.php'));
		/**/$mdTestCountTotal = $this->dodb->QueryTestCountTotal();			 
			$mdTestCountLive = $this->dodb->QueryTestCountLive();
			$mdTestCountAnswered = $this->dodb->QueryTestCountAnswered();
			$mdTestIsDemo = $this->dodb->QueryTestIsDemo();
			
		/**/$lret = array('vPage' => $vPage, 'vSecret' => $vSecret, 'mdTestCountTotal' => $mdTestCountTotal,
						  'mdTestCountLive' => $mdTestCountLive,'mdTestCountAnswered' => $mdTestCountAnswered,
						  'mdTestIsDemo' => $mdTestIsDemo); 
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function mdTestStatus(){			
			$mdTestCountLive = $this->dodb->QueryTestCountLive();
			$mdTestCountAnswered = $this->dodb->QueryTestCountAnswered();
			$mdTestStatus = $this->dodb->QueryTestStatus();
		/**/$lret = array('mdTestCountLive' => $mdTestCountLive,
						  'mdTestCountAnswered' => $mdTestCountAnswered,
						  'mdTestStatus' => $mdTestStatus); 
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function mdResultDownload(){			
			$assignment_id = $this->q('assignment_id');
			$mdResultDownload = $this->dodb->QueryResultDownload($assignment_id);			
			/**/
			/*$fp = fopen('php://output', 'w');
			$filename = '' + $assignment_id;
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            foreach ($mdResultDownload as $ferow) {
                fputcsv($fp, $ferow);
            }*/
			$lret = array('mdResultDownload' => $mdResultDownload); 
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function mdAssessmentUpdateStatus(){	 		
			$this->dodb->WriteAssignmentSetStatus($this->q('assignment_id'),$this->q('status'));
			$this->mdTestStatus();
		}
	}
	class AppMonitorDoDb{ 
		private $db;
		public function __construct(){
			$this->db = new AppMonitorModel(); 
		}public function QueryTestCountTotal(){
			return $this->db->QueryTestCountTotal();
		}public function QueryTestCountLive(){
			return $this->db->QueryTestCountLive();
		}public function QueryTestCountAnswered(){
			return $this->db->QueryTestCountAnswered();
		}public function QueryTestStatus(){
			return $this->db->QueryTestStatus();
		}public function QueryTestIsDemo(){
			return $this->db->QueryTestIsDemo();
		}public function WriteAssignmentSetStatus($p_assignment_id,$p_status){
			return $this->db->WriteAssignmentSetStatus($p_assignment_id,$p_status);
		}public function QueryResultDownload($p_assignment_id){
			return $this->db->QueryResultDownload($p_assignment_id);
		}
	}
?>