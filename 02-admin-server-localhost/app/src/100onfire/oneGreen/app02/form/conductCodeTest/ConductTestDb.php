<?php if(!isset($RUN)) { exit(); } ?>
<?php 
if (!defined('ROOTDB')) {
define('ROOTDB', __DIR__.'/');
}
$dbbase_path = realpath(ROOTDB.'../../../gf/ar6PhpMySqlDao.php');	
/*
echo("aa". $dbbase_path . "bb<br>");
if (file_exists($dbbase_path)) {
	echo("aa File Exists bb<br>");
}
*/
include ($dbbase_path); 

class ConductTestDb	
{
	private $m_dao = NULL;
	
	public function __construct()
	{
		$this->m_dao = new ar6PhpMySqlDao();
	}
	
	public function QueryAssessesment($p_assignment_id, $p_user_id)	// change 5a
	{
		$v_sql = 
"select a.assess_id assignment_id, a.group_id quiz_id, a.total_duration quiz_time, a.total_score pass_score,
	a.assignment_status status,
	a.assignment_name quiz_name, q.group_name quiz_desc, 1 show_intro, a.instructions intro_text,
	ua.user_ass_status user_quiz_status, a.group_id user_quiz_id,
	ua.ass_start_date uq_added_date, ua.user_secure_score pass_score_point,
	a.total_q, a.total_score, now() db_now, a.max_submissions, a.max_runs
from tcode_assess_base a
	inner join tcode_q_group_base q on a.group_id = q.group_id
	inner join tcode_assess_user ua on ua.assess_id =a.assess_id and ua.user_id=:p_user_id
where a.assignment_status = 1
	and a.assess_id=:p_assignment_id and ua.user_id=:p_user_id
order by a.assess_id desc		
"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	
	public function QueryQuestions($p_assignment_id, $p_user_id)	// change 5a
	{
		$v_sql = 
"select q.question_id question_id, g.group_id quiz_id, q.code_title question_text, q.code_question,
'' header_text, '' footer_text,
1 curr_priority, 1 next_priority, 1 prev_priority,
1 question_type_id, 1 point, g.group_name group_name, -1 qno_a, -1 qno_l,
ifnull(uqt.user_program,'') user_program, ifnull(uqt.q_status,0)  q_status, 
ifnull(uqt.submit_id,0)  submit_id, ifnull(uqt.q_secure_score,0)  q_secure_score,
la.lang_code, la.full_name lang_full_name, la.api_lang_name, la.api_version_no, la.default_program,
le.level_no, le.level_name, 
ifnull(uqt.number_of_runs,0) number_of_runs, 
ifnull(uqt.number_of_submits,0) number_of_submits
from tcode_q_group_base g
inner join tcode_q_group_q qg on g.group_id=qg.group_id
inner join tcode_q_base q on qg.question_id=q.question_id
inner join tcode_language la on q.lang_code=la.lang_code
inner join tcode_level le on q.level_no=le.level_no
inner join tcode_assess_base a on a.group_id=g.group_id
inner join tcode_assess_user au on au.assess_id=a.assess_id and au.user_id=:p_user_id
left join
  (select uq.assess_id, uq.submit_id, uq.question_id, uq.user_program, 
  uq.q_status, uq.test_cases_haverun, uq.q_secure_score,
  uq.number_of_runs, uq.number_of_submits
   from tcode_assess_submit_q uq
   where  uq.assess_id=:p_assignment_id and uq.user_id=:p_user_id) uqt
  on au.assess_id=uqt.assess_id AND qg.question_id=uqt.question_id
where a.assess_id=:p_assignment_id and au.user_id=:p_user_id
order by 1"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryAnswers($p_assignment_id, $p_user_id)	// change 5a
	{
		
		$v_sql = 
"select
	qa.testcase_id answer_id, qa.testcase_id, qa.sno, 'ABC' answer_text, qa.input, qa.output, qa.point tc_point,
  1 correct_answer, 1 priority,
	'' correct_answer_text, qg.group_id, g.group_name, qg.question_id,
	ifnull(uqt.testcase_id, -1)user_answer_id,
	case when uqt.testcase_id is null then 0 else 1 end uqt_created_status,
  ifnull(uqt.case_status,0) case_status, ifnull(uqt.testcase_secure_score,0) testcase_secure_score,
  ifnull(uqt.user_output,'') user_output, ifnull(uqt.submit_id,0) submit_id
from tcode_q_testcase qa
	inner join tcode_q_base q on q.question_id=qa.question_id
	inner join tcode_q_group_q qg on qg.question_id=q.question_id
	inner join tcode_q_group_base g on qg.group_id=g.group_id
	inner join tcode_assess_base a on a.group_id=g.group_id
	inner join tcode_assess_user ua on ua.assess_id=a.assess_id and ua.user_id=:p_user_id
  left join
  (select uq.assess_id, uq.submit_id, uq.question_id, uq.user_program, uq.q_status, uq.test_cases_haverun,
  utc.testcase_id, utc.user_output, utc.case_status, utc.testcase_secure_score
   from tcode_assess_submit_q uq
     left  join tcode_assess_submit_testcase utc on uq.submit_id=utc.submit_id
   where  uq.assess_id=:p_assignment_id and uq.user_id=:p_user_id) uqt
  on ua.assess_id=uqt.assess_id AND qa.question_id=uqt.question_id AND qa.testcase_id=uqt.testcase_id
where a.assess_id=:p_assignment_id and ua.user_id=:p_user_id
order by qg.question_id, qa.sno
"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryQuestionsByQn($p_assignment_id, $p_user_id, $p_question_id)	// change 5a
	{
		$v_sql = 
"select q.question_id question_id, g.group_id quiz_id, q.code_title question_text, q.code_question,
'' header_text, '' footer_text,
1 curr_priority, 1 next_priority, 1 prev_priority,
1 question_type_id, 1 point, g.group_name group_name, -1 qno_a, -1 qno_l,
ifnull(uqt.user_program,'') user_program, ifnull(uqt.q_status,0)  q_status, 
ifnull(uqt.submit_id,0)  submit_id, ifnull(uqt.q_secure_score,0)  q_secure_score,
la.lang_code, la.full_name lang_full_name, la.api_lang_name, la.api_version_no, la.default_program,
le.level_no, le.level_name, 
ifnull(uqt.number_of_runs,0) number_of_runs, 
ifnull(uqt.number_of_submits,0) number_of_submits
from tcode_q_group_base g
inner join tcode_q_group_q qg on g.group_id=qg.group_id
inner join tcode_q_base q on qg.question_id=q.question_id
inner join tcode_language la on q.lang_code=la.lang_code
inner join tcode_level le on q.level_no=le.level_no
inner join tcode_assess_base a on a.group_id=g.group_id
inner join tcode_assess_user au on au.assess_id=a.assess_id and au.user_id=:p_user_id
left join
  (select uq.assess_id, uq.submit_id, uq.question_id, uq.user_program, 
  uq.q_status, uq.test_cases_haverun, uq.q_secure_score,
  uq.number_of_runs, uq.number_of_submits
   from tcode_assess_submit_q uq
   where  uq.assess_id=:p_assignment_id and uq.user_id=:p_user_id) uqt
  on au.assess_id=uqt.assess_id AND qg.question_id=uqt.question_id
where a.assess_id=:p_assignment_id and au.user_id=:p_user_id and q.question_id=:p_question_id
order by 1"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id,
		"p_question_id"=>$p_question_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryAnswersByQn($p_assignment_id, $p_user_id, $p_question_id)	// change 5a
	{
		
		$v_sql = 
"select
	qa.testcase_id answer_id, qa.testcase_id, qa.sno, 'ABC' answer_text, qa.input, qa.output, qa.point tc_point,
  1 correct_answer, 1 priority,
	'' correct_answer_text, qg.group_id, g.group_name, qg.question_id,
	ifnull(uqt.testcase_id, -1)user_answer_id,
	case when uqt.testcase_id is null then 0 else 1 end uqt_created_status,
  ifnull(uqt.case_status,0) case_status, ifnull(uqt.testcase_secure_score,0) testcase_secure_score,
  ifnull(uqt.user_output,'') user_output, ifnull(uqt.submit_id,0) submit_id
from tcode_q_testcase qa
	inner join tcode_q_base q on q.question_id=qa.question_id
	inner join tcode_q_group_q qg on qg.question_id=q.question_id
	inner join tcode_q_group_base g on qg.group_id=g.group_id
	inner join tcode_assess_base a on a.group_id=g.group_id
	inner join tcode_assess_user ua on ua.assess_id=a.assess_id and ua.user_id=:p_user_id
  left join
  (select uq.assess_id, uq.submit_id, uq.question_id, uq.user_program, uq.q_status, uq.test_cases_haverun,
  utc.testcase_id, utc.user_output, utc.case_status, utc.testcase_secure_score
   from tcode_assess_submit_q uq
     left  join tcode_assess_submit_testcase utc on uq.submit_id=utc.submit_id
   where  uq.assess_id=:p_assignment_id and uq.user_id=:p_user_id) uqt
  on ua.assess_id=uqt.assess_id AND qa.question_id=uqt.question_id AND qa.testcase_id=uqt.testcase_id
where a.assess_id=:p_assignment_id and ua.user_id=:p_user_id and q.question_id=:p_question_id
order by qg.question_id, qa.sno
"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id,
		"p_question_id"=>$p_question_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QuerySubmitId($p_assess_id, $p_user_id, $p_question_id)	// change 5a
	{
		
		$v_sql = 
"SELECT submit_id 
FROM tcode_assess_submit_q 
WHERE assess_id=:p_assess_id AND user_id=:p_user_id AND question_id=:p_question_id
"; // change 5b
		$v_param = array("p_assess_id"=>$p_assess_id, "p_user_id"=>$p_user_id, 
		"p_question_id"=>$p_question_id);	
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	
	public function InitUserQuiz($p_assess_id, $p_user_id)	// change 2a
	{
		
		$v_sql = "UPDATE tcode_assess_user SET user_ass_status=1, ass_start_date=now()
			WHERE assess_id=:p_assess_id AND user_id=:p_user_id"; // change 2b
		$v_param = array("p_assess_id"=>$p_assess_id, "p_user_id"=>$p_user_id); // change 2c
		
		$v_result = $this->m_dao->db_write($v_sql, $v_param);
		return $v_result;
	}	
	
	public function SubmitProgram($p_assess_id, $p_user_id, $p_group_id, $p_question_id, $p_user_program)	// change 2a
	{
		$v_sql1 = "INSERT INTO tcode_assess_submit_q
			(assess_id, user_id, group_id, question_id, user_program, q_status)
			VALUES(:p_assess_id, :p_user_id, :p_group_id, :p_question_id, :p_user_program, 1)"; // change 2b
		$v_param1 = array("p_assess_id"=>$p_assess_id, "p_user_id"=>$p_user_id, 
						"p_group_id"=>$p_group_id, "p_question_id"=>$p_question_id, 
						"p_user_program"=>$p_user_program); // change 2c		
	
		$v_result = $this->m_dao->db_write_batch(array($v_sql1), array($v_param1));
		return $v_result;
	}

	public function SubmitProgramForRunInit($p_assess_id, $p_user_id, $p_group_id, $p_question_id)	// change 2a
	{
		$v_sql1 = "INSERT INTO tcode_assess_submit_q
			(assess_id, user_id, group_id, question_id, q_status, user_program)
			VALUES(:p_assess_id, :p_user_id, :p_group_id, :p_question_id, 0, '')"; // change 2b
		$v_param1 = array("p_assess_id"=>$p_assess_id, "p_user_id"=>$p_user_id, 
						"p_group_id"=>$p_group_id, "p_question_id"=>$p_question_id); // change 2c		
	
		$v_result = $this->m_dao->db_write_batch(array($v_sql1), array($v_param1));
		return $v_result;
	}

	public function SubmitProgramForCode($p_submit_id, $p_user_program)	// change 2a
	{
		$v_sql1 = "UPDATE tcode_assess_submit_q  
			SET user_program=:p_user_program, q_status=1
			WHERE submit_id=:p_submit_id"; // change 2b
		$v_param1 = array("p_user_program"=>$p_user_program, "p_submit_id"=>$p_submit_id); // change 2c		
	
		$v_result = $this->m_dao->db_write_batch(array($v_sql1), array($v_param1));
		return $v_result;
	}

	public function SubmitProgramForRuns($p_submit_id)	// change 2a
	{
		$v_sql1 = "UPDATE tcode_assess_submit_q  
SET number_of_runs = number_of_runs + 1   
WHERE submit_id=:p_submit_id"; // change 2b
		$v_param1 = array("p_submit_id"=>$p_submit_id); // change 2c		
	
		$v_result = $this->m_dao->db_write_batch(array($v_sql1), array($v_param1));
		return $v_result;
	}
	
	public function InitTestCase($p_submit_id, $p_assess_id, $p_user_id, $p_group_id, $p_question_id, 
			$p_testcase_id)	// change 2a
	{
		$v_sql1 = "INSERT INTO tcode_assess_submit_testcase
			(submit_id, assess_id, user_id, group_id, question_id, testcase_id, case_status)
			VALUES(:p_submit_id, :p_assess_id, :p_user_id, :p_group_id, :p_question_id, :p_testcase_id, 2)"; // change 2b
		$v_param1 = array("p_submit_id"=>$p_submit_id, "p_assess_id"=>$p_assess_id, "p_user_id"=>$p_user_id, 
						"p_group_id"=>$p_group_id, "p_question_id"=>$p_question_id, 
						"p_testcase_id"=>$p_testcase_id); // change 2c		
	
		$v_result = $this->m_dao->db_write_batch(array($v_sql1), array($v_param1));
		return $v_result;
	}
	public function FinishTestCase($p_submit_id, $p_testcase_id, $p_useroutput, $p_testcase_secure_score)	// change 2a
	{
		$v_sql1 = "UPDATE tcode_assess_submit_testcase SET 
				case_status=3, user_output=:p_useroutput, testcase_secure_score=:p_testcase_secure_score
			    WHERE submit_id=:p_submit_id AND testcase_id=:p_testcase_id"; // change 2b
		$v_param1 = array( "p_useroutput"=>$p_useroutput, "p_testcase_secure_score"=>$p_testcase_secure_score,
				"p_submit_id"=>$p_submit_id,  "p_testcase_id"=>$p_testcase_id); // change 2c	

		$v_sql2 = "UPDATE tcode_assess_submit_q SET 
				q_status=CASE WHEN q_status=1 THEN 2 ELSE q_status END, q_secure_score= q_secure_score + :p_testcase_secure_score
			    WHERE submit_id=:p_submit_id"; // change 2b
		$v_param2 = array("p_testcase_secure_score"=>$p_testcase_secure_score, 
			"p_submit_id"=>$p_submit_id); // change 2c			
	
		$v_result = $this->m_dao->db_write_batch(array($v_sql1,$v_sql2), array($v_param1,$v_param2));
		return $v_result;
	}
	public function FinishProgram($p_submit_id, $p_assess_id,  $p_user_id, $p_q_secure_score)	// change 2a
	{
		$v_sql1 = "UPDATE tcode_assess_submit_q SET 
				q_status=3, test_cases_haverun=false
			    WHERE q_status=2 AND submit_id=:p_submit_id"; // change 2b
		$v_param1 = array("p_submit_id"=>$p_submit_id); // change 2c			
	
	
		$v_sql2 = "UPDATE tcode_assess_user SET 
				user_secure_score=user_secure_score + :p_q_secure_score
			    WHERE assess_id=:p_assess_id AND user_id=:p_user_id"; // change 2b
		$v_param2 = array("p_assess_id"=>$p_assess_id, "p_user_id"=>$p_user_id, 
		     "p_q_secure_score"=>$p_q_secure_score); // change 2c			
	
		$v_result = $this->m_dao->db_write_batch(array($v_sql1, $v_sql2), array($v_param1, $v_param2));
		return $v_result;
	}
	
	
	public function FinishQuiz($p_assess_id, $p_user_id, $p_user_ass_status)	// change 2a
	{
		
		$assDat = $this->QueryAssessesment($p_assess_id, $p_user_id);
		$v_sql2 = "UPDATE tcode_assess_user SET 
				user_ass_status=:p_user_ass_status, ass_finish_date=now()
			    WHERE assess_id=:p_assess_id AND user_id=:p_user_id"; // change 2b
		$v_param2 = array("p_assess_id"=>$p_assess_id, "p_user_id"=>$p_user_id, 
		     "p_user_ass_status"=>$p_user_ass_status); // change 2c		
		$arSql = array($v_sql2); $arParam = array($v_param2);
		$p_quiz_time = 'Unknown';
		if(!is_null($assDat))	{
			$p_quiz_time = $assDat[0]['quiz_time']; 
			
			$v_sql2 = "UPDATE tcode_assess_user 
			SET ass_finish_date=TIMESTAMPADD(MINUTE,:p_quiz_time_set,ass_start_date )
			WHERE assess_id=:p_assess_id AND user_id=:p_user_id 
				AND (TIMESTAMPDIFF(minute,ass_start_date, ass_finish_date) > :p_quiz_time_chk OR 
					user_ass_status=3)";
		$v_param2 = array("p_quiz_time_set"=>$p_quiz_time,  
					"p_assess_id"=>$p_assess_id, "p_user_id"=>$p_user_id,
					"p_quiz_time_chk"=>$p_quiz_time);
					array_push($arSql,$v_sql2); array_push($arParam,$v_param2);
		}
	
		$v_result = $this->m_dao->db_write_batch($arSql, $arParam);
		
		return array('res' => $v_result, 'qz_time' => $p_quiz_time);
	}
	
	//
	public function QueryAssessesmentByUser($p_user_id)	// change 5a
	{
	
		$v_sql = 
"select a.assess_id, a.group_id, a.total_duration, a.total_score, a.total_q,
	a.assignment_status, a.assignment_name, 
	g.group_name, 
	ua.user_ass_status, ua.ass_start_date, ua.user_secure_score, 
	now() db_now	
from tcode_assess_base a
	inner join tcode_q_group_base g on a.group_id = g.group_id
	inner join tcode_assess_user ua on ua.assess_id =a.assess_id and ua.user_id=:p_user_id
where a.assignment_status = 1
	and ua.user_id=:p_user_id
order by a.assess_id asc"; // change 5b
		$v_param = array("p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryOldAssessesmentByUser($p_user_id)	// change 5a
	{
		
		$v_sql = 
"select 
	uq.*,q.quiz_name,asg.quiz_type,asg.results_mode,asg.show_results , 
	(case show_results when 1 then asg.pass_score else '' end) pass_score, 
	(CASE show_results when 0 then 'Not enabled' ELSE 
		(case success when 1 then 'Yes' else 'No' end) end) is_success , 
		(CASE show_results when 1 then (case results_mode when 1 
			THEN pass_score_point else pass_score_perc end) else '' end) total_point 
from user_quizzes uq 
	left join assignments asg on asg.id=uq.assignment_id 
	left join quizzes q on q.id=asg.quiz_id 
where asg.quiz_type=1 and uq.user_id=:p_user_id 
order by uq.added_date desc	"; // change 5b
		$v_param = array("p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
}
?>