<?php 
session_start();
   $RUN = 1;
   
?>
<?php 
  if(!isset($RUN)) { exit(); } 
  
?>
<?php 
if (!defined('FS_DIR_CONDUCTTEST_PC')) { /* FS: File System, PC: Page Controller */
define('FS_DIR_CONDUCTTEST_PC', __DIR__.'/');
}

$util_path = realpath(FS_DIR_CONDUCTTEST_PC.'../../../gf/ar6PhpUtil.php');	
$db_path = realpath(FS_DIR_CONDUCTTEST_PC.'ConductTestDb.php');
$module_db_path = realpath(FS_DIR_CONDUCTTEST_PC.'../userAndModule/UserAndModuleDb.php');	

include ($util_path);
include ($db_path);
include ($module_db_path);



class ConductTestPageController	// change 1b
{
	private $m_method = ''; 
	private $phpUtil = null;
	
	public function __construct()
	{
		global $phpUtil;
		$this->phpUtil = $phpUtil;
		$this->frm_init();
	}
	
	public function frm_init(){
		$v_m = $this->phpUtil->field('m','');
		
		if(!($v_m==='')){
			switch($v_m)
			{
				case 'html': $this->html();break;
				
				case 'dao_save_answer_only':$this->BmSaveUserAnswerOnly();break;	
				case 'dao_finish_quiz_only':$this->BmFinishQuizOnly();break;
				case 'dao_save_shuffle_ids':$this->BmSaveShuffleIDs();break;
				case 'mdAdjustQuizTime':$this->mdAdjustQuizTime();break;				
			}
		}
	}
	
	public function html()
	{			
		$vhtml = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'InstructionsView.php'));		
		$vquestion_htm = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'QuestionView.php'));		
		$vpager_htm = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'QPagerView.php'));		
		$vpager_qmatrix_htm = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'QPagerMatrix.php'));
		$vFinishTP = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'ViewFinishTP.php'));
		
		
		if(!isset($_SESSION['txtLogin'])){
			$outdata = array('IsLoggedIn'=>0);
		}else{
			$p_user_id = $_SESSION['user_id']; 	
			$p_user = $_SESSION['txtLogin'];
			$p_full_name = $_SESSION['full_name'];
			
			$p_assignment_id = $this->phpUtil->field('assignment_id');
			$p_asg_id = $p_assignment_id;			
			
			$IsFirstTimeVisit = 0;
			
			$oConductTestDb = new ConductTestDb();	
			$mdlivetest = $oConductTestDb->QueryIsLiveTest($p_user_id);
			if(count($mdlivetest)>0){
				$p_assignment_id = $mdlivetest[0]["assignment_id"];
			}
			$mdassessmentData = $oConductTestDb->QueryAssessesment($p_assignment_id, $p_user_id);
			
			if($mdassessmentData[0]["user_quiz_status"] == 0){				
				$dbRes = $oConductTestDb->InsertUserQuiz($p_asg_id, $p_user_id);
				$mdassessmentData = $oConductTestDb->QueryAssessesment($p_assignment_id, $p_user_id);
				$IsFirstTimeVisit = 1;
			}
			$user_quiz_id = $mdassessmentData[0]["user_quiz_id"];
			$now_server = $mdassessmentData[0]["now_server"];
			
			$mdassessment = array("assignment"=>$mdassessmentData, "user_id"=>$p_user_id, 
				"user"=>$p_user, "full_name"=>$p_full_name, 'user_quiz_id' => $user_quiz_id,
				'IsFirstTimeVisit'=>$IsFirstTimeVisit, "now_server" => $now_server);			
			//			
			$mdquestionData = $oConductTestDb->QueryQuestions($p_assignment_id, $p_user_id);
			$mdanswerData = $oConductTestDb->QueryAnswers($p_assignment_id, $p_user_id);
			$mdqnAns = array("question"=>$mdquestionData, "answer"=>$mdanswerData);
			//
			$_SESSION['asg_id']=$p_assignment_id;
			$_SESSION['user_quiz_id']=$mdassessmentData[0]["user_quiz_id"];
			//
			$outdata = array('IsLoggedIn'=>1, 'vhtml'=>$vhtml,
					'vquestion_htm'=>$vquestion_htm,'vpager_htm'=>$vpager_htm,
					'vpager_qmatrix_htm'=>$vpager_qmatrix_htm,					
					"mdassessment"=>$mdassessment, 'vFinishTP' => $vFinishTP,
					"mdqnAns"=>$mdqnAns
			);
		}
				
		$v_out = $this->phpUtil->output(1, 'Yet To Login', $outdata);
		
		header('Content-Type: application/json; charset=utf-8', true);
		echo($v_out);
		return $v_out;
	}
	
	
	/*3. dao-write*/
		public function BmSaveShuffleIDs(){		
			//input:  
			$p_asg_id = $this->phpUtil->field('assignment_id');
			$p_shuffled_qn_ids = $this->phpUtil->field('shuffled_qn_ids');
			$p_user_id = $_SESSION['user_id'];
			//process
			$v_r_no = 1;
			$oConductTestDb = new ConductTestDb();
			$v_dao_result = $oConductTestDb->SaveShuffleIDs($p_asg_id, $p_user_id, $p_shuffled_qn_ids);
			$v_out = $this->phpUtil->output($v_r_no, 'shuffled_qn_ids Saved' , $v_dao_result);
			
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
				
		public function BmSaveUserAnswerOnly(){
			//input:  
			$p_user_quiz_id = $_SESSION['user_quiz_id'];
			
			$p_question_id = $this->phpUtil->field('question_id');
			$p_answer_id = $this->phpUtil->field('answer_id'); 
			$p_qno_a = $this->phpUtil->field('qno_a');
			$p_qno_l = $this->phpUtil->field('qno_l');
			$answered_ids = $this->phpUtil->field('answered_ids');
			//process
			$oConductTestDb = new ConductTestDb();
			$v_dao_result = $oConductTestDb->SaveUserAnswer($p_user_quiz_id, $p_question_id, $p_answer_id,$answered_ids); 				
			$v_r_no = 1;				
				
			$v_dao_result = array(
				"qno_l" => $p_qno_l, "qno_a" => $p_qno_a, 							
				"question_id" => $p_question_id, 
				"answer_id" => $p_answer_id, "res" => $v_dao_result
				);
				
			$v_out = $this->phpUtil->output($v_r_no, 'User Answer Saved Successfully', $v_dao_result);
			
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		
		public function BmFinishQuizOnly(){
			$p_status = $this->phpUtil->field('status');
			$p_quiz_time = $this->phpUtil->field('quiz_time');
			$p_user_quiz_id = $_SESSION['user_quiz_id'];
			$oConductTestDb = new ConductTestDb();
			if(!($this->phpUtil->field('is_qn') === '')){
				$p_question_id = $this->phpUtil->field('question_id');
				$p_answer_id = $this->phpUtil->field('answer_id'); 
				$p_qno_l = $this->phpUtil->field('qno_l');
				$p_qno_a = $this->phpUtil->field('qno_a');
				$answered_ids = $this->phpUtil->field('answered_ids');
				$v_dao_result01 = $oConductTestDb->SaveUserAnswer($p_user_quiz_id, $p_question_id, $p_answer_id,$answered_ids); 				
			}
			$v_dao_result = $oConductTestDb->FinishQuizOnly($p_status, $p_user_quiz_id, $p_quiz_time);					
			if(!isset($v_dao_result01)) $v_dao_result01=false;
			
			$v_r_no = 1;
			$v_out = $this->phpUtil->output($v_r_no, '', array('res'=>$v_dao_result,'res01'=>$v_dao_result01));
			
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		
		public function mdAdjustQuizTime(){
			$p_user_quiz_id = $_SESSION['user_quiz_id'];
			$oConductTestDb = new ConductTestDb();
			$v_dao_result = $oConductTestDb->UpdateAdjustQuizTime($p_user_quiz_id);					
			$v_r_no = 1;
			$v_out = $this->phpUtil->output($v_r_no, '', array('res'=>$v_dao_result,'msg'=>'Yes. Adjusted Quiz Time.'));
			
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
}

$oConductTestPageController = new ConductTestPageController();	// change 7

?>