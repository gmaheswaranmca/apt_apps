<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../gf/WrapperModel.php'));
			
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
		}public function QnFileSave($qz_id, $qz_name, $qz_desc, $instructions, $rule){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->UpdateQuizV2;
			$a_param = array('p_instruction_text' => $instructions, 
				'p_qz_name' => $qz_name, 'p_qz_desc' => $qz_desc, 'p_quiz_id' => $qz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			$a_sql = $this->sql->UpdateQuizRule;
			$a_param = array('p_rule_text' => $rule, 'p_quiz_id' => $qz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('res'=>$res,'sql'=>$sql,'param'=>$param);
		}public function QzAdd($qz_name, $qz_desc, $instructions, $rule){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->UpdateQuizV2;
			$a_param = array('p_instruction_text' => $instructions, 
				'p_qz_name' => $qz_name, 'p_qz_desc' => $qz_desc, 'p_quiz_id' => $qz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			$a_sql = $this->sql->UpdateQuizRule;
			$a_param = array('p_rule_text' => $rule, 'p_quiz_id' => $qz_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			
			
			$res =  $this->wmd->WriteParam($sql, $param);
			return array('res'=>$res,'sql'=>$sql,'param'=>$param);
		}public function QnDataSave($qn_id, $qn_text, $options){
			$sql = array(); 
			$param = array();
			$a_sql = $this->sql->UpdateQn;
			$a_param = array('p_question_text' => $qn_text, 'p_question_id' => $qn_id);
			array_push($sql,$a_sql);array_push($param,$a_param);
			$a_sql = $this->sql->UpdateQnOpt;
			for ($I = 0; $I < count($options); $I++) {
				$a_param = array(
					'p_option_text' => $options[$I]->option, 
					'p_is_answer' => $options[$I]->is_answer, 
					'p_option_id'=> $options[$I]->option_id);
				array_push($sql,$a_sql);array_push($param,$a_param);
			}
			
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
	public $UpdateQuizV2 = "UPDATE quizzes SET 
quiz_name=:p_qz_name,  
quiz_desc=:p_qz_desc,
intro_text=:p_instruction_text WHERE id=:p_quiz_id"; 
	public $UpdateQuizRule = "UPDATE apt_tp_rule SET rule=:p_rule_text WHERE tp_id=:p_quiz_id"; 

	public $AddQz = "INSERT INTO quizzes(quiz_name,quiz_desc,intro_text, cat_id, 
	added_date, parent_id, show_intro) VALUES 
(:p_qz_name, :p_qz_desc, :p_instruction_text, :p_cat_id,
now(),0,1)"; 
	public $AddCat = "INSERT INTO cats(cat_name) VALUES 
(:p_qz_name)";
	public $AddQn = "INSERT INTO questions(question_text, quiz_id, priority,
	question_type_id, point, added_date, parent_id, header_text, footer_text) VALUES 
(:p_question_text, :p_quiz_id, :p_sno,
	1, 1,now(),0,'','')";
	public $AddQnOpt = "INSERT INTO questions(answer_text, correct_answer, group_id,
	question_type_id, point, added_date, parent_id, header_text, footer_text) VALUES 
(:p_question_text, :p_quiz_id, :p_sno,
	1, 1,now(),0,'','')";

	public $sqlQn = "SELECT qn.quiz_id,qn.id question_id,qn.question_text FROM questions qn WHERE qn.id=:p_question_id";
	public $sqlQnOpt = "SELECT qo.id, qo.answer_text option_text, qo.correct_answer is_answer 
	FROM question_groups qg INNER JOIN answers qo ON(qg.id=qo.group_id) 
	WHERE qg.question_id=:p_question_id";
	}
?>



