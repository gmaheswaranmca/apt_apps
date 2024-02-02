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
		UserAndModuleDb::allow("2"); // Role Based Access
		
		$v_m = $this->phpUtil->field('m','');
		
		if(!($v_m==='')){
			switch($v_m)
			{
				case 'html':	// change 2a
					$html_page = realpath(FS_DIR_CONDUCTTEST_PC.'InstructionsView.php');
					//echo "aa $html_page bb<br>";
					$this->phpUtil->output_form_init($html_page); // change 2b	
					break;
				case 'question_htm':	// change 2a
					$html_page = realpath(FS_DIR_CONDUCTTEST_PC.'QuestionView.php');
					//echo "aa $html_page bb<br>";
					$this->phpUtil->output_form_init($html_page); // change 2b	
					break;	
				case 'pager_htm':	// change 2a					
					$html_page = realpath(FS_DIR_CONDUCTTEST_PC.'QPagerView.php');
					//echo "aa $html_page bb<br>";
					$this->phpUtil->output_form_init($html_page); // change 2b	
					break;	
				case 'pager_qmatrix_htm':	// change 2a
					$html_page = realpath(FS_DIR_CONDUCTTEST_PC.'QPagerMatrix.php');
					//echo "aa $html_page bb<br>";
					$this->phpUtil->output_form_init($html_page); // change 2b	
					break;
				case 'menu_htm':	// change 2a
					$html_page = realpath(FS_DIR_CONDUCTTEST_PC.'../userAndModule/MenusView.php');
					//echo "aa $html_page bb<br>";
					$this->phpUtil->output_form_init($html_page); // change 2b	
					break;		
				case 'dao_assessment':
					$this->BmQueryAssessesment();
					break;
				case 'dao_question':
					$this->BmQueryQuestionAndAnswer();	
					break;				
				case 'daomodule_get':
					$this->BmQueryModuleGet();	
					break;	
				case 'dao_insert_userquiz':
					$this->BmInsertUserQuiz();
					break;	
				case 'dao_save_answer':				
					$this->BmSaveUserAnswer();
					break;
				case 'dao_save_answer_only':					
					$this->BmSaveUserAnswerOnly();
					break;	
				case 'dao_save_answer_only_test':					
					$this->BmSaveUserAnswerOnlyTest();
					break;	
				case 'dao_finish_quiz':	
					$this->BmFinishQuiz();
					break;
				case 'dao_finish_quiz_only':	
					$this->BmFinishQuizOnly();
					break;	
			}
		}
	}
	/*2. dao-read*/
		public function BmQueryAssessesment()
		{
			//input
			$p_assignment_id = $this->phpUtil->field('assignment_id'); // change 4a
			$p_user_id = $_SESSION['user_id']; // change 4a
			//echo("aa ass=$p_assignment_id usr=$p_user_id bb");
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				
				$v_dao_result = $oConductTestDb->QueryAssessesment($p_assignment_id, $p_user_id);
				$v_dao_result = array("assignment"=>$v_dao_result, "user_id"=>$p_user_id, "user"=>$_SESSION['txtLogin'], "now_server"=>$this->phpUtil->Now());				
				$v_r_no = 1;
				$_SESSION['asg_id']=$p_assignment_id;
			}	
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, '', $v_dao_result);
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		
		public function BmQueryQuestionAndAnswer()
		{
			//input
			$p_assignment_id = $this->phpUtil->field('assignment_id'); // change 4a
			$p_user_id = $_SESSION['user_id']; // change 4a
			//$qonly = $this->phpUtil->field('qonly');
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				
				$v_dao_result_q = $oConductTestDb->QueryQuestions($p_assignment_id, $p_user_id);	// change 3b
				$v_dao_result_ans = $oConductTestDb->QueryAnswers($p_assignment_id, $p_user_id);	// change 3b
				/*if(isset($qonly) && $qonly=="1")
					$v_dao_result = array("question"=>$v_dao_result_q);
				elseif(isset($qonly) && $qonly=="2")
					$v_dao_result = array("answer"=>$v_dao_result_ans);
				else
				*/  $v_dao_result = array("question"=>$v_dao_result_q, "answer"=>$v_dao_result_ans);
				$v_r_no = 1;
			}	
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, '', $v_dao_result);
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		public function BmQueryModuleGet()
		{
			//input
			$p_user = $_SESSION['txtLogin'];
			$p_password = $_SESSION['txtPass'];
			$p_imp_password = $_SESSION['txtPassImp'];
			$p_check_pass = true;			
			//process
			$v_r_no = 989;
			{
				$oUserAndModuleDb = new UserAndModuleDb();	// change 4b
				$v_dao_result = $oUserAndModuleDb->GetModules($p_user, $p_password, $p_imp_password, $p_check_pass);	// change 4c
				//echo($v_dao_result);
				$v_r_no = 1;
				
				
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1: //$v_msg = $p_user . " " . $p_password . " " . $p_imp_password;
					$v_out = $this->phpUtil->output($v_r_no, '', $v_dao_result);
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
	/*3. dao-write*/
		public function BmInsertUserQuiz()
		{
		
			//input:  
			$p_asg_id = $this->phpUtil->field('assignment_id');
			$p_user_id = $_SESSION['user_id'];
			$assignment_id=$_SESSION['assignment_id'];
			$p_status = "1";
			$p_date = $this->phpUtil->Now(); 
			$p_success = "0";			
			//process
			$v_r_no = 989;
			if(!($p_asg_id === '')){		
				$oConductTestDb = new ConductTestDb();	// change 5a
				$v_dao_result = $oConductTestDb->QueryUserQuiz($p_asg_id, $p_user_id);
				$v_r_no = 1;
				if(is_null($v_dao_result)){
					$v_dao_result = $oConductTestDb->InsertUserQuiz($p_asg_id, $p_user_id, $p_status, $p_date, $p_success); // change 5b
					$_SESSION['asg_id']=$p_asg_id;
				}	
				else
					$v_r_no = 201;
				
				
				$v_dao_result = $oConductTestDb->QueryUserQuiz($p_asg_id, $p_user_id);
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, 'User Quiz Initiated Successfully', $v_dao_result);	// change 5c
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Delete Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Delete Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		public function BmSaveUserAnswer()
		{
			//input:  
			$p_user_quiz_id = $this->phpUtil->field('user_quiz_id');
			$p_question_id = $this->phpUtil->field('question_id');
			$p_answer_id = $this->phpUtil->field('answer_id'); 
			$p_user_answer_id = $p_answer_id;
			$p_added_date = $this->phpUtil->Now();
						
			//process
			$v_r_no = 989;
			if(!($p_question_id === '')){		
				$oConductTestDb = new ConductTestDb();	// change 5a
				
				$v_dao_result = $oConductTestDb->SaveUserAnswer(
						$p_user_quiz_id, $p_question_id, $p_answer_id, 
						$p_user_answer_id, $p_added_date); // change 5b
				
				$v_r_no = 1;				
				$v_dao_result = $oConductTestDb->QueryAnswers($_SESSION['asg_id'], $_SESSION['user_id']);
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, 'User Answer Saved Successfully', $v_dao_result);	// change 5c
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Delete Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Delete Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		public function BmSaveUserAnswerOnly()
		{
			//input:  
			$p_user_quiz_id = $this->phpUtil->field('user_quiz_id');
			$p_question_id = $this->phpUtil->field('question_id');
			$p_answer_id = $this->phpUtil->field('answer_id'); 
			$p_user_answer_id = $p_answer_id;
			$p_added_date = $this->phpUtil->Now();
			$p_qno_l = $this->phpUtil->field('qno_l');
			$p_qno_a = $this->phpUtil->field('qno_a');
			//process
			$v_r_no = 989;
			if(!($p_question_id === '')){		
				$oConductTestDb = new ConductTestDb();	// change 5a
				
				$p_user_id = $_SESSION['user_id'];
				$assignment_id=$_SESSION['assignment_id'];
				$v_dao_result01 = $oConductTestDb->QueryUserQuiz($assignment_id, $p_user_id);
				$p_user_quiz_id01 = '';
				if(!is_null($v_dao_result01)){
					$p_user_quiz_id01 = $v_dao_result01[0]['user_quiz_id'];
					$v_dao_result = $oConductTestDb->SaveUserAnswer($p_user_quiz_id01, $p_question_id, $p_answer_id, $p_user_answer_id, $p_added_date);					
				}else{
					$v_dao_result = $oConductTestDb->SaveUserAnswer($p_user_quiz_id, $p_question_id, $p_answer_id, 	$p_user_answer_id, $p_added_date); 
				}	
				
				$v_r_no = 1;				
				
				$v_dao_result = array(
					"qno_l" => $p_qno_l, "qno_a" => $p_qno_a, 			
					'$p_user_quiz_id01'=>$p_user_quiz_id01, '$p_user_quiz_id01'=>$p_user_quiz_id01,					
					"question_id" => $p_question_id, 
					"answer_id" => $p_answer_id, "res" => $v_dao_result,					
					'$v_dao_result01' => $v_dao_result01
					);
				
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, 'User Answer Saved Successfully', $v_dao_result);	// change 5c
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Delete Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Delete Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		
		public function BmSaveUserAnswerOnlyTest()
		{
			//input:  
			$p_user_id = $_SESSION['user_id'];
			$assignment_id=$_SESSION['assignment_id'];

			$p_user_quiz_id = $this->phpUtil->field('user_quiz_id');
			$p_question_id = $this->phpUtil->field('question_id');
			$p_answer_id = $this->phpUtil->field('answer_id'); 
			$p_user_answer_id = $p_answer_id;
			$p_added_date = $this->phpUtil->Now();
			$p_qno_l = $this->phpUtil->field('qno_l');
			$p_qno_a = $this->phpUtil->field('qno_a');
			//process
			$v_r_no = 989;
			if(!($p_question_id === '')){		
				$oConductTestDb = new ConductTestDb();	// change 5a
				
				$p_user_id = $_SESSION['user_id'];
				$assignment_id=$_SESSION['assignment_id'];
				$v_dao_result01 = $oConductTestDb->QueryUserQuiz($assignment_id, $p_user_id);
				$p_user_quiz_id01 = '';
				if(!is_null($v_dao_result01)){
					$p_user_quiz_id01 = $v_dao_result01[0]['user_quiz_id'];
					//$v_dao_result = $oConductTestDb->SaveUserAnswer($p_user_quiz_id01, $p_question_id, $p_answer_id, 	$p_user_answer_id, $p_added_date); 
					$v_dao_result = 'Not Saved';
				}else
					$v_dao_result = 'Not Saved';
					//$v_dao_result = $oConductTestDb->SaveUserAnswer($p_user_quiz_id, $p_question_id, $p_answer_id, 	$p_user_answer_id, $p_added_date); 
				
				
				$v_r_no = 1;				
				
				$v_dao_result = array(
					"qno_l" => $p_qno_l, "qno_a" => $p_qno_a, 			
					'$p_user_quiz_id01'=>$p_user_quiz_id01, '$p_user_quiz_id01'=>$p_user_quiz_id01,					
					"question_id" => $p_question_id, 
					"answer_id" => $p_answer_id, "res" => $v_dao_result,					
					'$v_dao_result01' => $v_dao_result01
					);
				
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, 'User Answer Saved Successfully', $v_dao_result);	// change 5c
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Delete Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Delete Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		public function BmFinishQuiz()
		{
			//input
			//$p_assignment_id = $this->phpUtil->field('assignment_id'); // change 4a
			//$p_user_id = $this->phpUtil->field('user_id'); // change 4a
			$p_status = $this->phpUtil->field('status');
			//$p_user_quiz_id = $this->phpUtil->field('user_quiz_id');
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				
				$p_user_id = $_SESSION['user_id'];
				$p_assignment_id=$_SESSION['assignment_id'];
				$v_dao_result01 = $oConductTestDb->QueryUserQuiz($p_assignment_id, $p_user_id);
				$p_user_quiz_id01 = '';
				if(!is_null($v_dao_result01)) $p_user_quiz_id01 = $v_dao_result01[0]['user_quiz_id'];				
				$p_user_quiz_id = $p_user_quiz_id01;
				
				$v_dao_result = $oConductTestDb->FinishQuiz($p_assignment_id, $p_user_id, $p_status, 
					$this->phpUtil->Now(),$p_user_quiz_id );	// change 3b
				// change 3b
				//$v_dao_result = array("question"=>$v_dao_result_q, "answer"=>$v_dao_result_ans);
				$v_r_no = 1;
			}	
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, '', $v_dao_result);
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
		
		public function BmFinishQuizOnly()
		{
			//input
			//$p_assignment_id = $this->phpUtil->field('assignment_id'); // change 4a
			//$p_user_id = $this->phpUtil->field('user_id'); // change 4a
			$p_status = $this->phpUtil->field('status');
			//$p_user_quiz_id = $this->phpUtil->field('user_quiz_id');
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				$p_user_id = $_SESSION['user_id'];
				$p_assignment_id=$_SESSION['assignment_id'];
				$v_dao_result01 = $oConductTestDb->QueryUserQuiz($p_assignment_id, $p_user_id);
				$p_user_quiz_id01 = '';
				if(!is_null($v_dao_result01)) $p_user_quiz_id01 = $v_dao_result01[0]['user_quiz_id'];				
				$p_user_quiz_id = $p_user_quiz_id01;
				
				$v_dao_result = $oConductTestDb->FinishQuizOnly($p_assignment_id, $p_user_id, $p_status, 
					$this->phpUtil->Now(),$p_user_quiz_id );	// change 3b
				// change 3b
				//$v_dao_result = array("question"=>$v_dao_result_q, "answer"=>$v_dao_result_ans);
				$v_r_no = 1;
			}	
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, '', $v_dao_result);
					break;
				case 989:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;
				case 988:
					$v_out = $this->phpUtil->output($v_r_no, 'Query Not Possible, Invalid Operation', '');
					break;	
			}
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}
}

$oConductTestPageController = new ConductTestPageController();	// change 7

?>