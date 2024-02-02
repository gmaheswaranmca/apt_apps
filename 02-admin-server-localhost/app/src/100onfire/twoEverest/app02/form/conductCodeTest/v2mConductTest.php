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
				case 'htmlOne':
					$this->htmlOne();	
					break;
				case 'SaveQnAction':
					$this->SaveQnAction();	
					break;					
				case 'RunQnAction':
					$this->RunQnAction();	
					break;	
				/*case 'html':	// change 2a
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
					break;	*/
				case 'dao_submit_program':
					$this->BmSubmitProgram();
					break;
				case 'dao_init_testcase':
					$this->BmInitTestCase();
					break;
				case 'dao_run_testcase':
					$this->BmFinishTestCase();  
					break;	
				case 'dao_finish_program':
					$this->BmFinishProgram();  
					break;	
				case 'dao_finish_quiz':	
					$this->BmFinishQuiz();
					break;
			}
		}
	}
	public function htmlOne()
	{			
		if(!isset($_SESSION['txtLogin'])){ 
			$outdata = array('IsLoggedIn'=>0);
		}else{
			$p_assignment_id = $this->phpUtil->field('assignment_id'); // change 4a
			$p_user_id = $_SESSION['user_id'];
			$p_user = $_SESSION['txtLogin'];
			$p_full_name = $_SESSION['full_name'];
			$InstructionsView = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'InstructionsView.php'));		
			$QuestionView = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'QuestionView.php'));		
			$QPagerView = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'QPagerView.php'));		
			$QPagerMatrix = $this->phpUtil->output_form(realpath(FS_DIR_CONDUCTTEST_PC.'QPagerMatrix.php'));
			$oConductTestDb = new ConductTestDb();	
			$mdQueryAssessesment = $oConductTestDb->QueryAssessesment($p_assignment_id, $p_user_id);
			$IsFirstTimeVisit = 0;
			if($mdQueryAssessesment[0]["user_quiz_status"] == 0){				
				$v_dao_result = $oConductTestDb->InitUserQuiz($p_assignment_id, $p_user_id); // change 5b
				$mdQueryAssessesment = $oConductTestDb->QueryAssessesment($p_assignment_id, $p_user_id);
				$IsFirstTimeVisit = 1;
			} 
			$mdQueryQuestions = $oConductTestDb->QueryQuestions($p_assignment_id, $p_user_id);	// change 3b
			$mdQueryAnswers = $oConductTestDb->QueryAnswers($p_assignment_id, $p_user_id);	// change 3b
			$mdQnAns = array("question"=>$mdQueryQuestions, "answer"=>$mdQueryAnswers);
			$outdata = array('IsLoggedIn'=>1,
				'InstructionsView' => $InstructionsView,
				'QuestionView' => $QuestionView,
				'QPagerView' => $QPagerView,
				'QPagerMatrix' => $QPagerMatrix,
				'mdQueryAssessesment' => $mdQueryAssessesment,
				'mdQnAns' => $mdQnAns,
				'mdInput' => array('assignment_id'=> $p_assignment_id, 'user_id'=> $p_user_id, 'user'=> $p_user, 'full_name'=> $p_full_name),
				'IsFirstTimeVisit' => $IsFirstTimeVisit
			);
		}
				
		$v_out = $this->phpUtil->output(1, 'Yet To Login', $outdata);
		
		header('Content-Type: application/json');
		echo($v_out);
		return $v_out;
	}

	/*2. dao-read*/
		
	/*3. dao-write*/
		public function SaveQnAction()
		{
			$p_assess_id = $_SESSION['asg_id']; 
			$p_user_id = $_SESSION['user_id'];

			$p_group_id = $this->phpUtil->field('group_id');
			$p_question_id = $this->phpUtil->field('question_id');
			$p_user_program = $this->phpUtil->field('user_program');

			$p_testcase_id = $this->phpUtil->field('testcase_id');
			$p_tc_point = $this->phpUtil->field('tc_point');
			$p_tc_input = $this->phpUtil->field('tc_input');
			$p_tc_output = $this->phpUtil->field('tc_output');

			$p_api_lang = $this->phpUtil->field('api_lang');
			$p_api_version = $this->phpUtil->field('api_version');			

			$oConductTestDb = new ConductTestDb();	
			$v_dao_SubmitId = $oConductTestDb->QuerySubmitId(
				$p_assess_id, $p_user_id, 
				$p_question_id); 	
			$v_dao_result01 = count($v_dao_SubmitId);
			if(count($v_dao_SubmitId)==0)	{
				$v_dao_result01 = $oConductTestDb->SubmitProgram(
						$p_assess_id, $p_user_id, $p_group_id, 
						$p_question_id, $p_user_program); 		//1
				$v_dao_SubmitId = $oConductTestDb->QuerySubmitId(
					$p_assess_id, $p_user_id, 
					$p_question_id); 	
			}
			$p_submit_id = $v_dao_SubmitId[0]["submit_id"]; 

			$v_dao_result04 = $oConductTestDb->SubmitProgramForCode(
				$p_submit_id, $p_user_program);

			$v_dao_result02 = array();
			$p_qn_secure_score = 0;
			for ($I = 0; $I < count($p_testcase_id); $I++) {
				$a_testcase_id = $p_testcase_id[$I];
				$a_tc_point = $p_tc_point[$I];
				$a_tc_input = $p_tc_input[$I];
				$a_tc_output = $p_tc_output[$I];
				$a_tc_is_input = ($a_tc_input!='');
				$v_dao_result_itc = $oConductTestDb->InitTestCase(
					$p_submit_id, $p_assess_id, $p_user_id, $p_group_id, $p_question_id, 
					$a_testcase_id); 												//2
				array_push($v_dao_result02,$v_dao_result_itc);

				$p_useroutput = 'None'; /* Comment */
				$tc_out = array();
				
				/*  */
				$tc_out = $this->phpUtil->RunTechCode($p_user_program, $p_api_lang, 
					$p_api_version, $a_tc_is_input, 
					$a_tc_input);	// 3.1
				$p_useroutput=$tc_out['output']['output'];				
				
				$p_testcase_secure_score = 0;
				if($p_useroutput === $a_tc_output){
				$p_testcase_secure_score = 1 * $a_tc_point;
				}
				$v_dao_result_ftc = $oConductTestDb->FinishTestCase(
					$p_submit_id, $a_testcase_id, $p_useroutput, $p_testcase_secure_score); // 3.2
				array_push($v_dao_result02,
				    array($v_dao_result_ftc,
				    $p_useroutput, $a_tc_output, 
				    $p_useroutput === $a_tc_output,
				    $a_tc_point)
				);
				$p_qn_secure_score += $p_testcase_secure_score;
			}	


			$v_dao_result03 = $oConductTestDb->FinishProgram(
				$p_submit_id, $p_assess_id,  $p_user_id, $p_qn_secure_score); // 4
		
			$v_dao_result_q = $oConductTestDb->QueryQuestionsByQn($p_assess_id, $p_user_id,$p_question_id);
			$v_dao_result_a = $oConductTestDb->QueryAnswersByQn($p_assess_id, $p_user_id,$p_question_id);
			$v_dao_result_data = array('question' => $v_dao_result_q, 'answer' => $v_dao_result_a,
				'res01' => $v_dao_result01,'res02' => $v_dao_result02,
				'res03' => $v_dao_result03,
				'submit_id' => $p_submit_id);
			$v_out = $this->phpUtil->output(1, 'Program Submission Is Successfully Done', $v_dao_result_data);	// change 5c
			
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}

		public function RunQnAction()
		{
			$p_assess_id = $_SESSION['asg_id']; 
			$p_user_id = $_SESSION['user_id'];

			$p_group_id = $this->phpUtil->field('group_id');
			$p_question_id = $this->phpUtil->field('question_id');
			$p_user_program = $this->phpUtil->field('user_program');

			$p_testcase_id = $this->phpUtil->field('testcase_id');
			$p_tc_point = $this->phpUtil->field('tc_point');
			$p_tc_input = $this->phpUtil->field('tc_input');
			$p_tc_output = $this->phpUtil->field('tc_output');

			$p_api_lang = $this->phpUtil->field('api_lang');
			$p_api_version = $this->phpUtil->field('api_version');			

			$oConductTestDb = new ConductTestDb();	
			$v_dao_SubmitId = $oConductTestDb->QuerySubmitId(
				$p_assess_id, $p_user_id, 
				$p_question_id); 	
			$v_dao_result01 = count($v_dao_SubmitId);
			if(count($v_dao_SubmitId)==0)	{
				$v_dao_result01 = $oConductTestDb->SubmitProgramForRunInit(
						$p_assess_id, $p_user_id, $p_group_id, 
						$p_question_id, $p_user_program); 		//1
				$v_dao_SubmitId = $oConductTestDb->QuerySubmitId(
					$p_assess_id, $p_user_id, 
					$p_question_id); 	
			}
			$p_submit_id = $v_dao_SubmitId[0]["submit_id"]; 
			$v_dao_result02 = array();
			$p_qn_secure_score = 0;
			$p_useroutput = 'None';
			for ($I = 0; $I < count($p_testcase_id); $I++) {
				$a_testcase_id = $p_testcase_id[$I];
				$a_tc_point = $p_tc_point[$I];
				$a_tc_input = $p_tc_input[$I];
				$a_tc_output = $p_tc_output[$I];
				$a_tc_is_input = ($a_tc_input!='');
				/*
				InitTestCase
				*/

				$p_useroutput = '408 81.60'; /* Comment */
				$tc_out = array();
				
				/* */
				$tc_out = $this->phpUtil->RunTechCode($p_user_program, $p_api_lang, 
					$p_api_version, $a_tc_is_input, 
					$a_tc_input);	// 3.1
				$p_useroutput=$tc_out['output']['output'];				
				
				$p_testcase_secure_score = 0;
				if($p_useroutput === $a_tc_output){
				$p_testcase_secure_score = 1 * $a_tc_point;
				}
				/* 			FinishTestCase			*/						
				$p_qn_secure_score += $p_testcase_secure_score;

				break;
			}	
			/* 			FinishProgram			*/	

			$v_dao_result04 = $oConductTestDb->SubmitProgramForRuns(
				$p_submit_id);

			$v_dao_result_q = $oConductTestDb->QueryQuestionsByQn($p_assess_id, $p_user_id,$p_question_id);
			$v_dao_result_a = $oConductTestDb->QueryAnswersByQn($p_assess_id, $p_user_id,$p_question_id);
			$v_dao_result_data = array('question' => $v_dao_result_q, 'answer' => $v_dao_result_a,
				'res01' => $v_dao_result01,'res02' => $v_dao_result04,				
				'submit_id' => $p_submit_id,
				'useroutput'=>$p_useroutput,
				'user_program'=>$p_user_program);
			$v_out = $this->phpUtil->output(1, 'Program Run Is Successfully Done', $v_dao_result_data);	// change 5c
			
			header('Content-Type: application/json');
			echo($v_out);
			return $v_out;
		}

		public function BmFinishQuiz()
		{
			//input
			$p_assess_id = $_SESSION['asg_id'];
			$p_user_id = $_SESSION['user_id'];
			$p_user_ass_status = $this->phpUtil->field('user_ass_status');
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				
				$v_dao_result = $oConductTestDb->FinishQuiz($p_assess_id, $p_user_id, $p_user_ass_status
						);	// change 3b
				// change 3b
				//$v_dao_result_q = $oConductTestDb->QueryQuestions($p_assess_id, $p_user_id);
				//$v_dao_result_a = $oConductTestDb->QueryAnswers($p_assess_id, $p_user_id);
				$v_dao_result_as = $oConductTestDb->QueryAssessesment($p_assess_id, $p_user_id);
				$v_dao_result = array(
						'assessment'=>$v_dao_result_as);
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

		public function BmSubmitProgram()
		{
			//input:  
			
			$p_assess_id = $_SESSION['asg_id']; 
			$p_user_id = $_SESSION['user_id'];
			
			$p_group_id = $this->phpUtil->field('group_id');
			$p_question_id = $this->phpUtil->field('question_id');
			$p_user_program = $this->phpUtil->field('user_program'); 

			

			
			
						
			//process
			$v_r_no = 989;
			if(!($p_question_id === '')){		
				$v_input = array($p_assess_id, $p_user_id, $p_group_id, 
					$p_question_id, $p_user_program);
				$oConductTestDb = new ConductTestDb();	// change 5a
				
				$v_dao_result = $oConductTestDb->SubmitProgram(
						$p_assess_id, $p_user_id, $p_group_id, 
						$p_question_id, $p_user_program); // change 5b
				
				$v_r_no = 1;				
				$v_dao_result = $oConductTestDb->QueryQuestions($p_assess_id, $p_user_id);
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, 'User Program Submitted Successfully', $v_dao_result);	// change 5c
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
		public function BmInitTestCase()
		{
			//input:  
			
			$p_assess_id = $_SESSION['asg_id'];
			$p_user_id = $_SESSION['user_id'];
			
			$p_group_id = $this->phpUtil->field('group_id');
			$p_question_id = $this->phpUtil->field('question_id');
			$p_submit_id = $this->phpUtil->field('submit_id');			
			$p_testcase_id = $this->phpUtil->field('testcase_id');	
			$p_sno = $this->phpUtil->field('sno');		
						
			//process
			$v_r_no = 989;
			if(!($p_question_id === '')){		
				$oConductTestDb = new ConductTestDb();	// change 5a
				//$p_submit_id, $p_assess_id, $p_user_id, $p_group_id, $p_question_id, $p_testcase_id
				$v_dao_result = $oConductTestDb->InitTestCase(
						$p_submit_id, $p_assess_id, $p_user_id, $p_group_id, $p_question_id, 
						$p_testcase_id); // change 5b
				
				$v_r_no = 1;	
				$vsp = array($p_submit_id, $p_assess_id, $p_user_id, $p_group_id, $p_question_id, 
						$p_testcase_id, $v_dao_result, 'Test Case #' . $p_sno . ' Initiated  Successfully');
				$v_dao_result = $oConductTestDb->QueryAnswers($p_assess_id, $p_user_id);
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, 'Test Case #' . $p_sno . ' Initiated  Successfully', $v_dao_result);	// change 5c
					//$v_out = $this->phpUtil->output($v_r_no, $vsp, $v_dao_result);	// change 5c
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
		public function BmFinishTestCase()
		{
			//input:  
			
			$p_assess_id = $_SESSION['asg_id'];
			$p_user_id = $_SESSION['user_id'];
			
			$p_group_id = $this->phpUtil->field('group_id');
			$p_question_id = $this->phpUtil->field('question_id');
			$p_submit_id = $this->phpUtil->field('submit_id');			
			$p_testcase_id = $this->phpUtil->field('testcase_id');	
			$p_tc_input = $this->phpUtil->field('tc_input'); 
			$p_tc_output = $this->phpUtil->field('tc_output');
			$p_tc_point = $this->phpUtil->field('tc_point');
			$p_sno = $this->phpUtil->field('sno');
			$p_tc_is_input = ($p_tc_input!='');
			$p_user_program = $this->phpUtil->field('user_program');
			//
			$p_api_lang = $this->phpUtil->field('api_lang');
			$p_api_version = $this->phpUtil->field('api_version');
			
			
			
			//$p_program, $p_lang, $p_version, $p_is_input, $p_input
			$p_useroutput = $p_tc_output;
			$tc_out = array();
			
			 /*$tc_out = $this->phpUtil->RunTechCode($p_user_program, $p_api_lang, $p_api_version, $p_tc_is_input, $p_tc_input);
			 $p_useroutput=$tc_out['output']['output'];
			 //OR
			 */
			 $p_useroutput='None';/*   */
			
			/*
			print_r($tc_out);
			 */
						
			$p_testcase_secure_score = 0;
			if($p_useroutput === $p_tc_output){
				$p_testcase_secure_score = 1 * $this->phpUtil->field('tc_point');
			}
			
			/* echo("assess_id= $p_assess_id , user_id = $p_user_id , group_id = $p_group_id , question_id = $p_question_id , 
					submit_id = $p_submit_id ,  testcase_id = $p_testcase_id , tc_input = $p_tc_input , 
					sno = $p_sno ,  tc_is_input = $p_tc_is_input , 
					api_lang = $p_api_lang , api_version = $p_api_version , user_program = $p_user_program ,
					tc_output = $p_tc_output , useroutput = $p_useroutput, 
					testcase_secure_score  = $p_testcase_secure_score ");
			*/		
			
			//process
			$v_r_no = 989;
			if(!($p_question_id === '')){		
				$oConductTestDb = new ConductTestDb();	// change 5a
				$v_dao_result = $oConductTestDb->FinishTestCase(
						$p_submit_id, $p_testcase_id, $p_useroutput, $p_testcase_secure_score); // change 5b
				
				$v_r_no = 1;				
				$v_dao_result_q = $oConductTestDb->QueryQuestions($p_assess_id, $p_user_id);
				$v_dao_result_a = $oConductTestDb->QueryAnswers($p_assess_id, $p_user_id);
				$v_dao_result = array('question' => $v_dao_result_q, 'answer' => $v_dao_result_a, 'tc_output' => $tc_out);
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, 'Test Case #' . $p_sno . ' Finished  Successfully', $v_dao_result);	// change 5c
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
		public function BmFinishProgram()
		{
			//input:  
			
			$p_assess_id = $_SESSION['asg_id'];
			$p_user_id = $_SESSION['user_id'];
			
			$p_submit_id = $this->phpUtil->field('submit_id');
			//
			$p_q_secure_score = $this->phpUtil->field('q_secure_score');
					
					
			
			//process
			$v_r_no = 989;
			if(!($p_submit_id === '')){		
				$oConductTestDb = new ConductTestDb();	// change 5a
				$v_dao_result = $oConductTestDb->FinishProgram(
						$p_submit_id, $p_assess_id,  $p_user_id, $p_q_secure_score); // change 5b
				
				$v_r_no = 1;				
				$v_dao_result_q = $oConductTestDb->QueryQuestions($p_assess_id, $p_user_id);
				
				$v_dao_result = $v_dao_result_q;
			}
			//output
			$v_out='';
			switch($v_r_no){
				case 1:
					$v_out = $this->phpUtil->output($v_r_no, 'Program Submission Is Successfully Done', $v_dao_result);	// change 5c
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
		

		/* public function BmQueryAssessesment()
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
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				
				$v_dao_result_q = $oConductTestDb->QueryQuestions($p_assignment_id, $p_user_id);	// change 3b
				$v_dao_result_ans = $oConductTestDb->QueryAnswers($p_assignment_id, $p_user_id);	// change 3b
				$v_dao_result = array("question"=>$v_dao_result_q, "answer"=>$v_dao_result_ans);
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
		
		public function BmInsertUserQuiz()
		{
		
			//input:  
			$p_asg_id = $this->phpUtil->field('assignment_id');
			$p_user_id = $_SESSION['user_id'];
			$p_status = "1";
			$p_date = $this->phpUtil->Now(); 
			$p_success = "0";			
			//process
			$v_r_no = 989;
			if(!($p_asg_id === '')){		
				$oConductTestDb = new ConductTestDb();	// change 5a
				$v_dao_result = $oConductTestDb->InitUserQuiz($p_asg_id, $p_user_id); // change 5b
				
				$v_r_no = 1;
				$_SESSION['asg_id']=$p_asg_id;
				$v_dao_result = $oConductTestDb->QueryAssessesment($p_asg_id, $p_user_id);
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
		*/
}

$oConductTestPageController = new ConductTestPageController();	// change 7

?>