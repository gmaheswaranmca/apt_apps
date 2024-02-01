<?php 
    if(!isset($RUN)) 				  exit();
    if (!defined('DIR_ControllerAct')) define('DIR_ControllerAct', __DIR__.'/');
	include (realpath(DIR_ControllerAct.'../../../gf/ar6PhpUtil.php'));

	/* Link Name */
	function qInput($f){
		global $phpUtil;
		return $phpUtil->field($f,'');
	}
	$linkName = qInput('LinkCodeName');
	if($linkName!=='')	$RestLinkName = $linkName;
	/* End Link Name */
	
	include (realpath(DIR_ControllerAct.'controllerDb.php'));

    class McqTestScoresController{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new McqTestScoresControllerDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}
		// 

		public function RptScoreInit(){				
			/**/$mdAss 	= $this->dodb->QAss();
			/**/$lret = array(
					'mdAss' => $mdAss
					); 			
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		
		public function RptScoreEachTestLive(){
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