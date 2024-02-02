<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../gf/WrapperModel.php'));
			
	class TestPaperModel{
		private $wmd = NULL;		
		private $sql = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new TestPaperModelSql();
		}public function QueryTestPaperActive($p_user_id)	{			
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryTestPaperActive, 
					array("p_user_id" => $p_user_id)
				);
		}public function IsUserExist($p_user_name, $p_password)	{			
			return $this->wmd->QueryParam(
					$this->sql->sqlIsUserExist, 
					array("p_user_name" => $p_user_name, "p_password" => $p_password)
				);
		}public function QueryRoleModule($p_role_id)	{			
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryRoleModule, 
					array("p_role_id" => $p_role_id)
				);
		}public function QueryUserTestTakingPaper($p_user_id, $p_assignment_id)	{			
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryUserTestTakingPaper, 
					array("p_user_id" => $p_user_id, "p_assignment_id" => $p_assignment_id)
				);
		}public function QueryUTTPQuestion($p_quiz_id)	{			
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryUTTPQuestion, 
					array("p_quiz_id" => $p_quiz_id)
				);
		}public function QueryUTTPAnswer($p_user_id, $p_assignment_id)	{
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryUTTPAnswer, 
					array("p_user_id"=>$p_user_id,"p_assignment_id" => $p_assignment_id)
				);
		}
	}
	class TestPaperModelSql{
	/*01-QueryTestPaperActive -> assignment_id, quiz_id, time_limit, qn_count, tp_status, quiz_name, user_tp_status	  
	  02-IsUserExist -> user_id, Name full_name, user_type role_id
	  03-QueryRoleModule -> module_id, module_name
	  04-QueryUserTestTakingPaper -> assignment_id, quiz_id, time_limit, qn_count, tp_status, quiz_name, user_tp_status, intro_text, user_quiz_id, test_started_time
	  05-QueryUTTPQuestion -> quiz_id, question_id, question_text, options, option_top
	  06-QueryUTTPAnswer -> user_answered
	*/	
	/*01-QueryTestPaperActive -> assignment_id, quiz_id, time_limit, qn_count, tp_status, quiz_name, user_tp_status, intro_text, user_quiz_id, test_started_time
	      arg: p_user_id
	*/public $sqlQueryTestPaperActive = 
"SELECT a.id assignment_id, a.quiz_id, a.quiz_time time_limit, a.pass_score qn_count, a.status tp_status,
    q.quiz_name, ifnull(uq.status,0) user_tp_status
FROM assignment_users au INNER JOIN
    assignments a ON (au.assignment_id = a.id) INNER JOIN
    quizzes q ON (a.quiz_id = q.id) LEFT JOIN
    user_quizzes uq ON (au.user_id =uq.user_id AND au.assignment_id=uq.assignment_id)
WHERE (au.user_id = :p_user_id) AND (a.status = 1)"; 	
	/*02-IsUserExist -> user_id, Name, user_type role_id
	      arg: p_user_name, p_password
	*/public $sqlIsUserExist = 
"SELECT usr.UserId user_id, usr.Name full_name, usr.user_type role_id 
FROM users usr 
WHERE (UserName=:p_user_name) AND (Password=md5(:p_password))";
	/*03-QueryRoleModule -> module_id, module_name
	      arg: p_role_id
	*/public $sqlQueryRoleModule = 
"SELECT m.id module_id, m.module_name
FROM roles_rights rr INNER JOIN
    modules m ON (m.id= rr.module_id)
WHERE rr.role_id=:p_role_id";
	/*04-QueryUserTestTakingPaper -> assignment_id, quiz_id, time_limit, qn_count, tp_status, quiz_name, user_tp_status, intro_text, user_quiz_id, test_started_time
	      arg: p_user_id, p_assignment_id
	*/public $sqlQueryUserTestTakingPaper = 
"SELECT a.id assignment_id, a.quiz_id, a.quiz_time time_limit, a.pass_score qn_count, a.status tp_status,
    q.quiz_name, ifnull(uq.status,0) user_tp_status,
    q.intro_text, ifnull(uq.id,0) user_quiz_id, uq.added_date test_started_time
FROM assignment_users au INNER JOIN
    assignments a ON (au.assignment_id = a.id) INNER JOIN
    quizzes q ON (a.quiz_id = q.id) LEFT JOIN
    user_quizzes uq ON (au.user_id =uq.user_id AND au.assignment_id=uq.assignment_id)
WHERE (au.user_id = :p_user_id) AND (a.status = 1) AND (au.assignment_id=:p_assignment_id)"; 
	/*05-QueryUTTPQuestion -> quiz_id, question_id, question_text, options, option_top
	      arg: p_quiz_id
	*/	
	public $sqlQueryUTTPQuestion = 
"SELECT qn.quiz_id,qn.id question_id,qn.question_text,
    CONCAT('[',GROUP_CONCAT(CONCAT('{\"id\":',qo.id,',\"option\":\"', replace(replace(qo.answer_text,'\"','\\\\\"'),'\\\\','\\\\\\\\'),'\"}')) , ']') options,
    md5(MAX(CASE WHEN qo.correct_answer=1 THEN qo.id ELSE 0 END)) option_top
FROM questions qn INNER JOIN
    question_groups qg ON(qn.id=qg.question_id) INNER JOIN
    answers qo ON (qg.id=qo.group_id)
WHERE qn.parent_id=0 AND qn.quiz_id=:p_quiz_id
GROUP BY qn.id"; 
	/*06-QueryUTTPAnswer -> user_answered
	      arg: p_user_id, p_assignment_id
		  
		  "SELECT qn.quiz_id,qn.id question_id,qn.question_text,
    CONCAT('[',GROUP_CONCAT(CONCAT('{\"id\":',qo.id,',\"option\":"', replace(qo.answer_text,'\"','\\\"'),'\"}')) , ']') options,
    md5(MAX(CASE WHEN qo.correct_answer=1 THEN qo.id ELSE 0 END)) option_top
FROM questions qn INNER JOIN
    question_groups qg ON(qn.id=qg.question_id) INNER JOIN
    answers qo ON (qg.id=qo.group_id)
WHERE qn.parent_id=0 AND qn.quiz_id=:p_quiz_id
GROUP BY qn.id"; 
		  
	*/public $sqlQueryUTTPAnswer = 
"SELECT
  CONCAT('{',ifnull(GROUP_CONCAT(CONCAT('\"qn',uqa.question_id,'\":',uqa.question_id)),''),'}') user_answered
FROM user_quizzes uq INNER JOIN
    user_answers uqa ON(uq.id=uqa.user_quiz_id)
WHERE (uq.user_id = :p_user_id) AND (uq.assignment_id=:p_assignment_id)"; 
	}
	 
	
?>


