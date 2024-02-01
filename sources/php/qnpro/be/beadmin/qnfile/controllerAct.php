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

    class QnFileController{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new QnFileControllerDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}
		// 
		public function vTestPaperPage(){
			/**/
			$mdTestPaperActive 	= $this->dodb->QueryTestPaperActive();				
			/**/
			$lret = array(
					'mdTestPaperActive' => $mdTestPaperActive					
					 );		
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		
		public function vTakeTestPage(){
			/**/
			if(isset($_GET['quiz_id']))
				$quiz_id = $_GET['quiz_id'];
			else
				$quiz_id = $_SESSION['quiz_id'];
			//
			$mdTestPapers 	= $this->dodb->QueryTestPaperActive();	
			$mdUserTestTakingPaper 	= $this->dodb->QueryUserTestTakingPaper($quiz_id);	
			$mdQuestion 	= $this->dodb->QueryUTTPQuestion($quiz_id);
			/**/			
			$lret = array('quiz_id' => $quiz_id,					
					'mdTestPapers' => $mdTestPapers,
					'mdUserTestTakingPaper' => $mdUserTestTakingPaper, 'mdQuestion' => $mdQuestion 
					 ); 
			//
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
		
		public function QzFileSave(){			
			$Qz = $this->q('Qz');			
			$res = $this->dodb->QnFileSave($Qz->quiz_id, $Qz->quiz_name, $Qz->about_quiz, 
				$Qz->intro_text, $Qz->rule);
			$ret = array('input' => $Qz, 'output' => $res);
			//
			$lret = $this->phpUtil->arr_to_json($ret);
			header('Content-Type: application/json');
			echo($lret);
		}
		
		public function QnDataSave(){			
			$Qn = $this->q('Qn');
			$res = $this->dodb->QnDataSave($Qn->question_id,  $Qn->question_text, $Qn->options);
			$ret = array('input' => $Qn, 'output' => $res);
			//
			$lret = $this->phpUtil->arr_to_json($ret);
			header('Content-Type: application/json');
			echo($lret);
		}

		

		
    }