<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../gf/WrapperModel.php'));
			
	class TestPaperModel{
		public $wmd = NULL;		
		public $sql = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new TestPaperModelSql();
		}public function QueryTestPaperActive()	{			
			return $this->wmd->QueryNoParam(
					$this->sql->sqlQueryTestPaperActive
				);
		}public function QueryUserTestTakingPaper($p_quiz_id){
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryUserTestTakingPaper, 
					array("p_quiz_id" => $p_quiz_id)
				);
		}public function QueryUTTPQuestion($p_quiz_id){			
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryUTTPQuestion, 
					array("p_quiz_id" => $p_quiz_id)
				);
		}public function QueryQnOpt($p_question_id){			
			return array(
				'Qn' => $this->wmd->QueryParam($this->sql->sqlQn, array("p_question_id" => $p_question_id)),
				'QnOpt' => $this->wmd->QueryParam($this->sql->sqlQnOpt, array("p_question_id" => $p_question_id))
			);
		}public function mdQnSaveDo($IsQnToSave, $IsOptToSave, $QnID, $QnTxt, $OptID, $OptAns, $OptText){
			//UpdateQn -> p_question_text, p_question_id
			//UpdateQnOpt -> p_option_text, p_is_answer, p_option_id
			$sql = array(); 
			$param = array();
			if($IsQnToSave){
				$a_sql = $this->sql->UpdateQn;
				$a_param = array('p_question_text' => $QnTxt, 'p_question_id' => $QnID);
				array_push($sql,$a_sql);array_push($param,$a_param);
			}if($IsOptToSave){
				$a_sql = $this->sql->UpdateQnOpt;
				for ($I = 0; $I < count($OptID); $I++) {
					$a_param = array('p_option_text' => $OptText[$I], 'p_is_answer' => $OptAns[$I], 'p_option_id'=> $OptID[$I]);
					array_push($sql,$a_sql);array_push($param,$a_param);
				}
			}			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('res'=>$res,'sql'=>$sql,'param'=>$param);
		}public function mdQuizSaveDo($quiz_id, $InstructionText,$RuleText){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->UpdateQuiz;
			$a_param = array('p_instruction_text' => $InstructionText, 'p_quiz_id' => $quiz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			$a_sql = $this->sql->UpdateQuizRule;
			$a_param = array('p_rule_text' => $RuleText, 'p_quiz_id' => $quiz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('res'=>$res,'sql'=>$sql,'param'=>$param);
		}
	}
	class TestPaperModelSql{
	/*01-QueryTestPaperActive -> 
	  02-QueryUserTestTakingPaper -> 
	  03-QueryUTTPQuestion -> 
	*/	
	/*01-QueryTestPaperActive -> 
	*/public $sqlQueryTestPaperActive = 
"SELECT q.id quiz_id, q.quiz_name, q.quiz_desc about_quiz, count(qn.id) qn_count FROM quizzes q INNER JOIN questions qn ON(q.id = qn.quiz_id) GROUP BY q.id"; 	
	/*02-QueryUserTestTakingPaper -> 
	*/public $sqlQueryUserTestTakingPaper = 
"SELECT q.id quiz_id, q.quiz_name, q.quiz_desc about_quiz, count(qn.id) qn_count, q.intro_text, rul.rule FROM  quizzes q INNER JOIN questions qn ON(q.id = qn.quiz_id)
INNER JOIN apt_tp_rule rul ON(q.id = rul.tp_id)
WHERE (q.id = :p_quiz_id)  GROUP BY q.id"; 
	/*03-QueryUTTPQuestion -> 
	*/	
	public $sqlQueryUTTPQuestion = 
"SELECT qn.quiz_id,qn.id question_id,qn.question_text, 
    CONCAT('[',GROUP_CONCAT(CONCAT('{\"id\":',qo.id,',\"option\":\"', replace(replace(qo.answer_text,'\\\\','\\\\\\\\'),'\"','\\\\\"'),'\"}')), ']') options,
    MAX(CASE WHEN qo.correct_answer=1 THEN qo.id ELSE 0 END) option_top
FROM questions qn INNER JOIN
    question_groups qg ON(qn.id=qg.question_id) INNER JOIN
    answers qo ON (qg.id=qo.group_id)
WHERE qn.quiz_id=:p_quiz_id
GROUP BY qn.id"; 
	/*04-UpdateQn -> 
	*/	
	public $UpdateQn = "UPDATE questions SET question_text=:p_question_text WHERE id=:p_question_id"; 
	public $UpdateQnOpt = "UPDATE answers SET answer_text=:p_option_text,correct_answer=:p_is_answer WHERE id=:p_option_id"; 
	public $UpdateQuiz = "UPDATE quizzes SET intro_text=:p_instruction_text WHERE id=:p_quiz_id"; 
	public $UpdateQuizRule = "UPDATE apt_tp_rule SET rule=:p_rule_text WHERE tp_id=:p_quiz_id"; 
	public $sqlQn = "SELECT qn.quiz_id,qn.id question_id,qn.question_text FROM questions qn WHERE qn.id=:p_question_id";
	public $sqlQnOpt = "SELECT qo.id, qo.answer_text option_text, qo.correct_answer is_answer 
	FROM question_groups qg INNER JOIN answers qo ON(qg.id=qo.group_id) 
	WHERE qg.question_id=:p_question_id";
	}
?>



