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
	include (realpath(DIR_TestPaper.'../../gf/ar6PhpUtil.php'));
	include (realpath(DIR_TestPaper.'TestPaperModel.php'));

	class TestPaperDoNav{
		public function __construct(){ $this->fDo(); }		
		public function fDo(){			
			$ext = new TestPaperDo();
			$v_m = $ext->q('m');			
			if($v_m==='') return; 	

			switch($v_m){
				case 'vTestPaperPage': 			$ext->vTestPaperPage(); 	break;
				case 'vTakeTestPage': 			$ext->vTakeTestPage(); 	break;
				case 'mdQnSaveDo': 				$ext->mdQnSaveDo(); 	break;
			}
		}
	}
	new TestPaperDoNav();	
	class TestPaperDo{
		private $phpUtil = null;
		private $dodb = null;
		public function __construct(){
			global $phpUtil; $this->phpUtil = $phpUtil; 
			$this->dodb = new TestPaperDoDb();
		}public function q($f){
			return $this->phpUtil->field($f,'');
		}public function vTestPaperPage(){
				$vTestPaperPage = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTestPaperPage.php'));
			/**/$mdTestPaperActive 	= $this->dodb->QueryTestPaperActive();
				
			/**/$lret = array(
					'vTestPaperPage' => $vTestPaperPage, 'mdTestPaperActive' => $mdTestPaperActive					
					 ); 			
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function vTakeTestPage(){
			/**/$vTakeTestPageInstruction = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageInstruction.php'));
				$vTakeTestPageQn = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageQn.php'));				
				$vTakeTestQnNumDiv = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestQnNumDiv.php'));
				$vTakeTestQnNum = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestQnNum.php'));
				$vTakeTestPageTitle = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageTitle.php'));
				$vTestPaperNum = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTestPaperNum.php'));
				$vTakeTestPageQnEditOptions = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageQnEditOptions.php'));
				$vTakeTestPageQnService = $this->phpUtil->output_form(realpath(DIR_TestPaper.'ViewTakeTestPageQnService.php'));
				//
				if(isset($_GET['quiz_id']))
					$quiz_id = $_GET['quiz_id'];
				else
					$quiz_id = $_SESSION['quiz_id'];
				//
				$mdTestPapers 	= $this->dodb->QueryTestPaperActive();	
				$mdUserTestTakingPaper 	= $this->dodb->QueryUserTestTakingPaper($quiz_id);	
				$mdQuestion 	= $this->dodb->QueryUTTPQuestion($quiz_id);	
				
			/**/	
			/**/$lret = array('quiz_id' => $quiz_id,
					'vTakeTestPageInstruction' => $vTakeTestPageInstruction, 'vTakeTestPageQn' => $vTakeTestPageQn, 
					'vTakeTestQnNumDiv' => $vTakeTestQnNumDiv, 'vTakeTestQnNum' => $vTakeTestQnNum, 
					'vTakeTestPageTitle' => $vTakeTestPageTitle, 'vTestPaperNum' => $vTestPaperNum,
					'vTakeTestPageQnEditOptions' => $vTakeTestPageQnEditOptions, 'vTakeTestPageQnService' => $vTakeTestPageQnService,
					'mdTestPapers' => $mdTestPapers,
					'mdUserTestTakingPaper' => $mdUserTestTakingPaper, 'mdQuestion' => $mdQuestion 
					 ); 
			
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}public function mdQnSaveDo(){			
			$IsInstructionToSave = $this->q('IsInstructionToSave')=='1';
			$IsLastQn = $this->q('IsLastQn')=='1';
			if(!$IsInstructionToSave){				
				$IsQnToSave = $this->q('IsQnToSave')=='1';
				$IsOptToSave = $this->q('IsOptToSave')=='1';			
				$QnID =$this->q('QnID');
				$QnTxt =$this->q('QnTxt');			
				$OptID =json_decode($this->q('OptID'));
				$OptAns =json_decode($this->q('OptAns'));
				$OptText =json_decode($this->q('OptText'));
				/**/
				$mdQnSaveDoRes = $this->dodb->mdQnSaveDo($IsQnToSave, $IsOptToSave, $QnID, $QnTxt, $OptID, $OptAns, $OptText);
				/**/$lret = array('IsInstructionToSave' => $IsInstructionToSave,
					'IsQnToSave' => $IsQnToSave,'IsOptToSave' => $IsOptToSave,'QnID' => $QnID, 'QnTxt' => $QnTxt,
					'OptID' => $OptID,'OptAns' => $OptAns,'OptText' => $OptText, 'IsLastQn' => $IsLastQn,
					'mdQnSaveDoRes' => $mdQnSaveDoRes
						 ); 			
				if($IsLastQn){
					$quiz_id = $_SESSION['quiz_id'];			
					$mdUserTestTakingPaper 	= $this->dodb->QueryUserTestTakingPaper($quiz_id);						
					$mdQuestion 	= $this->dodb->QueryUTTPQuestion($quiz_id);	
					$lret['mdUserTestTakingPaper'] = $mdUserTestTakingPaper;
					$lret['mdQuestion'] = $mdQuestion;
				}
			}else{
				$quiz_id = $_SESSION['quiz_id'];
				$InstructionText = $this->q('InstructionText');
				$RuleText = $this->q('RuleText');
				
				$mdQnSaveDoRes = $this->dodb->mdQuizSaveDo($quiz_id, $InstructionText,$RuleText);
				
				$lret = array('IsInstructionToSave' => $IsInstructionToSave,
					'InstructionText' => $InstructionText, 'RuleText' => $RuleText,
					'mdQnSaveDoRes' => $mdQnSaveDoRes);
				if($IsLastQn){
					$mdUserTestTakingPaper 	= $this->dodb->QueryUserTestTakingPaper($quiz_id);						
					$mdQuestion 	= $this->dodb->QueryUTTPQuestion($quiz_id);	
					$lret['mdUserTestTakingPaper'] = $mdUserTestTakingPaper;
					$lret['mdQuestion'] = $mdQuestion;
				}
			}
			$lret = $this->phpUtil->arr_to_json($lret);
			header('Content-Type: application/json');
			echo($lret);
		}
	}
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
		}public function mdQnSaveDo($IsQnToSave, $IsOptToSave, $QnID, $QnTxt, $OptID, $OptAns, $OptText){
			return $this->db->mdQnSaveDo($IsQnToSave, $IsOptToSave, $QnID, $QnTxt, $OptID, $OptAns, $OptText);
		}public function mdQuizSaveDo($quiz_id, $InstructionText,$RuleText){
			return $this->db->mdQuizSaveDo($quiz_id, $InstructionText,$RuleText);
		}	
	}
?>