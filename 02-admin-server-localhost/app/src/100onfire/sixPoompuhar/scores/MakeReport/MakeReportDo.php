<?php 
	@session_start();
	$RUN = 1;
	if(!isset($RUN)) 				  exit(); 
	if (!defined('DIR_MakeReport')) define('DIR_MakeReport', __DIR__.'/');
	include (realpath(DIR_MakeReport.'../../gf/ar6PhpUtil.php'));
	include (realpath(DIR_MakeReport.'MakeReportModel.php'));

	class MakeReportDoNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new MakeReportDo();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 			
			switch($v_m){
				case 'vMakeReportPage': 			$ext->vMakeReportPage(); 	break;
				case 'mdData': 			$ext->mdData(); 	break;
			}
		}
	}
	new MakeReportDoNav();	
	class MakeReportDo{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new MakeReportDoDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}public function vMakeReportPage(){
				$vMakeReportPage = $this->phpUtil->output_form(realpath(DIR_MakeReport.'ViewMakeReport.php'));
				$vTestPlan = $this->phpUtil->output_form(realpath(DIR_MakeReport.'ViewTestPlan.php'));
				$vTPActions = $this->phpUtil->output_form(realpath(DIR_MakeReport.'ViewTPActions.php'));
				
			/**/$mdReports 	= $this->dodb->QReports();
				$mdReportAssignment 	= $this->dodb->QReportAssignment();
				$mdReportDef 	= $this->dodb->QReportDef();
				$mdAss 	= $this->dodb->QAss();
			/**/$lret = array(
					'vMakeReportPage' => $vMakeReportPage, 'mdReports' => $mdReports, 
					'mdReportAssignment' => $mdReportAssignment, 'mdReportDef' => $mdReportDef,
					'vTestPlan' => $vTestPlan, 'mdAss' => $mdAss,
					'vTPActions' => $vTPActions
					 ); 			
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function mdData(){
			/**/$assignment_id = $this->q('assignment_id');
				$mdData 	= $this->dodb->QData($assignment_id);	
			/**/	
			/**/$lret = array('assignment_id' => $assignment_id,
					'mdData' => $mdData
					 ); 
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
	}
	class MakeReportDoDb{ 
		private $db;
		public function __construct(){ 
			$this->db = new MakeReportModel(); 
		}public function QReportDef()	{return $this->db->QReportDef();}
		public function QReports()	{return $this->db->QReports();}
		public function QReportAssignment(){return $this->db->QReportAssignment();}
		public function QData($p_assignment_id){return $this->db->QData($p_assignment_id);}
		public function QAss(){return $this->db->QAss();}		
	}
?>