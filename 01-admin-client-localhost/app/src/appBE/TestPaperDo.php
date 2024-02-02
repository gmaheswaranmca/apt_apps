<?php 
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Max-Age: 1000");
	header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
	header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
	@session_start();
	$RUN = 1;
	if(!isset($RUN)) 				  exit(); 
	if (!defined('DIR_TestPaper')) define('DIR_TestPaper', __DIR__.'/');
	include (realpath(DIR_TestPaper.'../gf/ar6PhpUtil.php'));
	include (realpath(DIR_TestPaper.'TestPaperModel.php'));
	class TestPaperDoDb{ 
		public $db;
		public function __construct(){
			$this->db = new TestPaperModel(); 
		}public function QueryTestPaperActive()	{
			return $this->db->QueryTestPaperActive();
		}public function QueryUserTestTakingPaper($p_quiz_id)	{
			return $this->db->QueryUserTestTakingPaper($p_quiz_id);
		}public function QueryUTTPQuestion($p_quiz_id){
			return $this->db->QueryUTTPQuestion($p_quiz_id);
		}public function QnFileSave($qz_id, $qz_name, $qz_desc, $instructions, $rule){
			return $this->db->QnFileSave($qz_id, $qz_name, $qz_desc, $instructions, $rule);
		}public function QnDataSave($qn_id, $qn_text, $options){
			return $this->db->QnDataSave($qn_id, $qn_text, $options);
		}	
	}class TestPaperDo{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new TestPaperDoDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}public function vTestPaperPage(){
			/**/
			$mdTestPaperActive 	= $this->dodb->QueryTestPaperActive();				
			/**/
			$lret = array(
					'mdTestPaperActive' => $mdTestPaperActive					
					 );		
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function vTakeTestPage(){
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
		}public function QzFileSave(){			
			$Qz = $this->q('Qz');			
			$res = $this->dodb->QnFileSave($Qz->quiz_id, $Qz->quiz_name, $Qz->about_quiz, 
				$Qz->intro_text, $Qz->rule);
			$ret = array('input' => $Qz, 'output' => $res);
			//
			$lret = $this->phpUtil->arr_to_json($ret);
			header('Content-Type: application/json');
			echo($lret);
		}public function QnDataSave(){			
			$Qn = $this->q('Qn');
			$res = $this->dodb->QnDataSave($Qn->question_id,  $Qn->question_text, $Qn->options);
			$ret = array('input' => $Qn, 'output' => $res);
			//
			$lret = $this->phpUtil->arr_to_json($ret);
			header('Content-Type: application/json');
			echo($lret);
		}
	}
	
	class TestPaperDoNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new TestPaperDo();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
				case 'vTestPaperPage': 			$ext->vTestPaperPage(); 	break;
				case 'vTakeTestPage': 			$ext->vTakeTestPage(); 	break;				
				case 'QzFileSave': 				$ext->QzFileSave(); 	break;
				case 'QnDataSave': 				$ext->QnDataSave(); 	break;
			}
		}
	}
	new TestPaperDoNav();
?>