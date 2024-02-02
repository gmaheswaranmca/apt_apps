<?php 

   $RUN = 1;
?>
<?php if(!isset($RUN)) { exit(); } ?>
<?php 
if (!defined('ROOTTESTDB')) {
define('ROOTTESTDB', __DIR__.'/');
}
$util_path = realpath(ROOTTESTDB.'../../sdk/ar6PhpUtil.php');	
$db_path = realpath(ROOTTESTDB.'ConductTestDb.php');	
include ($util_path);
include ($db_path);

class TestConductTestDb	// change 1b
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
				case 'dao_assessment': // m=dao_assessment&assignment_id=38&user_id=21
					$this->BmQueryAssessesment();
					break;
				case 'dao_question':	// m=dao_question&assignment_id=38&user_id=21
					$this->BmQueryQuestionAndAnswer();	
					break;
				case 'dao_user_answer':
					$this->BmQueryAnswers();	
					break;	
				case 'dao_finish_quiz': //m=dao_finish_quiz&assignment_id=39&user_id=21&status=3
					$this->FinishQuiz();	
					break;	
			}
		}
	}
	/*2. dao-read*/
		public function BmQueryAssessesment()
		{
			//input
			$p_assignment_id = $this->phpUtil->field('assignment_id'); // change 4a
			$p_user_id = $this->phpUtil->field('user_id'); // change 4a
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				
				$v_dao_result = $oConductTestDb->QueryAssessesment($p_assignment_id, $p_user_id);
								
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
		
		public function BmQueryQuestionAndAnswer()
		{
			//input
			$p_assignment_id = $this->phpUtil->field('assignment_id'); // change 4a
			$p_user_id = $this->phpUtil->field('user_id'); // change 4a
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
	
		
	/*3. dao-write*/
		public function FinishQuiz()
		{
			//input
			$p_assignment_id = $this->phpUtil->field('assignment_id'); // change 4a
			$p_user_id = $this->phpUtil->field('user_id'); // change 4a
			$p_status = $this->phpUtil->field('status');
			//process
			$v_r_no = 989;
			{
				$oConductTestDb = new ConductTestDb();	// change 3a
				
				$v_dao_result = $oConductTestDb->FinishQuiz($p_assignment_id, $p_user_id, $p_status, $this->phpUtil->Now());	// change 3b
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

$oTestConductTestDb = new TestConductTestDb();	// change 7

?>