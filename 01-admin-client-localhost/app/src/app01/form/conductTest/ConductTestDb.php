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
		public function QueryIsLiveTest($p_user_id)	{	
		$v_sql = 
"SELECT au.assignment_id
FROM assignments a INNER JOIN
	assignment_users au ON(a.id=au.assignment_id) INNER JOIN
    user_quizzes uq ON (au.user_id =uq.user_id AND au.assignment_id=uq.assignment_id)
WHERE (au.user_id = :p_user_id) AND (a.status=1) AND (uq.status=1)"; 

		$v_param = array("p_user_id"=>$p_user_id);			
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 		
		if ($v_result === true)	return $this->m_dao->getResult();			
		return $v_result;
	}
	public function QueryAssessesment($p_assignment_id, $p_user_id)	// change 5a
	{
	$v_sql = 
"select a.id assignment_id, a.quiz_id, a.quiz_time, a.pass_score, a.status,
	q.cat_id, q.quiz_name, q.quiz_desc, q.show_intro, q.intro_text,  
	ifnull(ua.status,0) user_quiz_status, ua.id user_quiz_id, ua.added_date uq_added_date, 
	ifnull(ua.pass_score_point,-1) pass_score_point
 from assignments a left join quizzes q on a.quiz_id = q.id 
 left join user_quizzes ua on ua.assignment_id =a.id and ua.user_id=:p_user_id 
 where a.status = 1 and a.id in 
	(select assignment_id 
	from assignment_users 
	where user_id = :p_user_id  and assignment_id=:p_assignment_id) and 
	a.id=:p_assignment_id 
 order by a.added_date desc"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryUserQuiz($p_assignment_id, $p_user_id)	// change 5a
	{
		/*
select ifnull(ua.status,0) user_quiz_status, 
	ua.id user_quiz_id, ua.added_date uq_added_date, ifnull(ua.pass_score_point,-1) pass_score_point
from user_quizzes ua 
	inner join assignments a on(a.id=ua.assignment_id)
where a.status=1 and ua.user_id=17 and ua.assignment_id=38 
order by a.added_date desc		
		*/

		/* 	fields in use:
			user_quiz_status -> $status, user_quiz_id -> SESSION, quiz_type 
		*/
		$v_sql = 
"select ifnull(ua.status,0) user_quiz_status, 
	ua.id user_quiz_id, ua.added_date uq_added_date
from user_quizzes ua 
	inner join assignments a on(a.id=ua.assignment_id)
where a.status=1 and ua.user_id=:p_user_id and ua.assignment_id=:p_assignment_id 
order by a.added_date desc"; // change 5b
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
		/*
select qs.id question_id, qs.quiz_id, qs.question_text, header_text, qs.footer_text, 
	qs.priority curr_priority, 
			ifnull(
			   (select priority 
				from questions qs2 
				where qs2.priority>qs.priority and 
				qs2.quiz_id=q.id 
				order by priority limit 0,1)
			   ,-1
			) next_priority,
			ifnull((select priority 
				 from questions qs3 
				 where qs3.priority<qs.priority and 
				 qs3.quiz_id=q.id 
				 order by priority 
				 desc limit 0,1)
				,-1
			) prev_priority, 
	qs.question_type_id, qs.point, qs.added_date question_added_date, qs.parent_id question_parent_id, 
	qg.group_name  
from questions qs  left join quizzes q on q.id=qs.quiz_id
left join assignments asg on asg.quiz_id=q.id
inner join assignment_users au on au.assignment_id=asg.id and au.user_id=21
left join question_groups qg on qg.question_id=qs.id
where asg.id=38
order by qs.priority;		
		*/

		/* 	fields in use:
			user_quiz_status -> $status, user_quiz_id -> SESSION, quiz_type 
		*/
		$v_sql = 
"select qs.id question_id, qs.quiz_id, qs.question_text, header_text, qs.footer_text, 
		qs.priority curr_priority, 
				ifnull(
				   (select priority 
					from questions qs2 
					where qs2.priority>qs.priority and 
					qs2.quiz_id=q.id 
					order by priority limit 0,1)
				   ,-1
				) next_priority,
				ifnull((select priority 
					 from questions qs3 
					 where qs3.priority<qs.priority and 
					 qs3.quiz_id=q.id 
					 order by priority 
					 desc limit 0,1)
					,-1
				) prev_priority, 		 
		qg.group_name, -1 qno_a, -1 qno_l
	from questions qs  left join quizzes q on q.id=qs.quiz_id
	left join assignments asg on asg.quiz_id=q.id
	inner join assignment_users au on au.assignment_id=asg.id and au.user_id=:p_user_id
	left join question_groups qg on qg.question_id=qs.id
	where asg.id=:p_assignment_id
	order by qs.priority"; // change 5b
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
		/*
select
	a.id answer_id, a.answer_text, a.correct_answer, a.priority,
	a.correct_answer_text, a.group_id, qg.group_name, qg.question_id,
	ifnull(uqa.user_answer_id,-1) user_answer_id
from answers a
	inner join question_groups qg on a.group_id=qg.id
	inner join questions qs on qs.id=qg.question_id
	inner join assignments asg on asg.quiz_id=qs.quiz_id
	left join (select question_id, answer_id, user_answer_id from user_quizzes uq
	    inner join user_answers ua  on ua.user_quiz_id=uq.id
      where uq.user_id=17 and uq.assignment_id=38) uqa
             on uqa.question_id=qs.id and a.id=uqa.answer_id
where asg.id=38
order by qs.priority	
		*/

		/* 	fields in use:
			user_quiz_status -> $status, user_quiz_id -> SESSION, quiz_type 
		*/
		$v_sql = 
"select
	a.id answer_id, a.answer_text, a.correct_answer, a.priority,
	a.correct_answer_text, a.group_id, qg.group_name, qg.question_id,
	ifnull(uqa.user_answer_id,-1) user_answer_id
from answers a
	inner join question_groups qg on a.group_id=qg.id
	inner join questions qs on qs.id=qg.question_id
	inner join assignments asg on asg.quiz_id=qs.quiz_id
	left join (select question_id, answer_id, user_answer_id from user_quizzes uq
	    inner join user_answers ua  on ua.user_quiz_id=uq.id
      where uq.user_id=:p_user_id and uq.assignment_id=:p_assignment_id) uqa
             on uqa.question_id=qs.id and a.id=uqa.answer_id
where asg.id=:p_assignment_id
order by qs.priority
"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryUserAnswers($p_assignment_id, $p_user_id)	// change 5a
	{
		/*
		select question_id, answer_id, user_answer_id from user_quizzes uq
	    inner join user_answers ua  on ua.user_quiz_id=uq.id
		where uq.user_id=17 and uq.assignment_id=38	
		*/

		/* 	fields in use:
			user_quiz_status -> $status, user_quiz_id -> SESSION, quiz_type 
		*/
		$v_sql = 
"select question_id, answer_id, user_answer_id from user_quizzes uq
	    inner join user_answers ua  on ua.user_quiz_id=uq.id
		where uq.user_id=:p_user_id and uq.assignment_id=:p_assignment_id
"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryAssessesmentByUser($p_user_id)	// change 5a
	{
		/*
select a.id assignment_id, a.quiz_id, a.quiz_time, a.pass_score, a.status,
	q.cat_id, q.quiz_name, q.quiz_desc, q.show_intro, q.intro_text,  
	ifnull(ua.status,0) user_quiz_status, ua.id user_quiz_id, ua.added_date uq_added_date, ifnull(ua.pass_score_point,-1) ua.pass_score_point,
	a.quiz_type, a.results_mode, a.org_quiz_id, a.added_date asg_added_date, a.show_results,
	q.added_date quiz_added_date, q.parent_id quiz_parent_id
from assignments a
	left join quizzes q on a.quiz_id = q.id
	left join user_quizzes ua on ua.assignment_id =a.id and ua.user_id=23
where a.status = 1 and
	a.id in
		(select assignment_id
			from assignment_users
			where user_id = 23)	
order by a.added_date desc		
		*/

		/* 	fields in use:
			user_quiz_status -> $status, user_quiz_id -> SESSION, quiz_type 
		*/
		$v_sql = 
"select a.id assignment_id, a.quiz_id, a.quiz_time, a.pass_score, a.status,
	q.cat_id, q.quiz_name, q.quiz_desc, q.show_intro, q.intro_text,  
	ifnull(ua.status,0) user_quiz_status, ua.id user_quiz_id, ua.added_date uq_added_date, 
	ifnull(ua.pass_score_point,-1) pass_score_point
 from assignments a left join quizzes q on a.quiz_id = q.id 
 left join user_quizzes ua on ua.assignment_id =a.id and ua.user_id=:p_user_id 
 where a.status = 1 and a.id in 
	(select assignment_id 
	from assignment_users 
	where user_id = :p_user_id ) 
 order by a.added_date desc"; // change 5b
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
		/*
select 
	uq.*,q.quiz_name,asg.quiz_type,asg.results_mode,asg.show_results , 
	(case show_results when 1 then asg.pass_score else '' end) pass_score, 
	(CASE show_results when 0 then 'Not enabled' ELSE 
		(case success when 1 then 'Yes' else 'No' end) end) is_success , 
		(CASE show_results when 1 then (case results_mode when 1 
			THEN pass_score_point else pass_score_perc end) else '' end) total_point 
from user_quizzes uq 
	left join assignments asg on asg.id=uq.assignment_id 
	left join quizzes q on q.id=asg.quiz_id 
where asg.quiz_type=1 and uq.user_id=19 
order by uq.added_date desc		
		*/

		/* 	fields in use:
			user_quiz_status -> $status, user_quiz_id -> SESSION, quiz_type 
		*/
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
	public function InsertUserQuiz($p_asg_id, $p_user_id, $p_status, $p_date, $p_success)	// change 2a
	{
		/* DEL this comment fully. Below code is NEW CODE.
			$v_sql = "INSERT INTO user_quizzes(assignment_id, user_id, status, added_date, success) VALUES(:p_asg_id, :p_user_id, :p_status, :p_date, :p_success)"; // change 2b
			$v_param = array("p_asg_id"=>$p_asg_id, "p_user_id"=>$p_user_id, "p_status"=>$p_status, 
							 "p_date"=>$p_date, "p_success"=>$p_success); // change 2c
			
			$v_result = $this->m_dao->db_write($v_sql, $v_param);
			return $v_result;
		*/
		
		$v_sql1 = "DELETE FROM user_quizzes WHERE user_id=:p_user_id AND assignment_id=:p_asg_id"; // change 2b
		$v_param1 = array("p_asg_id"=>$p_asg_id, "p_user_id"=>$p_user_id); // change 2c
		
		$v_sql2 = "INSERT INTO user_quizzes(assignment_id, user_id, status, added_date, success) VALUES(:p_asg_id, :p_user_id, :p_status, :p_date, :p_success)"; // change 2b
		$v_param2 = array("p_asg_id"=>$p_asg_id, "p_user_id"=>$p_user_id, "p_status"=>$p_status, 
						 "p_date"=>$p_date, "p_success"=>$p_success); // change 2c
		
		$v_result = $this->m_dao->db_write_batch(array($v_sql1,$v_sql2), array($v_param1,$v_param2));
		return $v_result;
	}	
	public function QueryUserAnswer($p_user_quiz_id, $p_question_id)	// change 5a
	{
		$v_sql = "SELECT id FROM user_answers where user_quiz_id=:p_user_quiz_id and question_id=:p_question_id";
		$v_param = array("p_user_quiz_id"=>$p_user_quiz_id, "p_question_id"=>$p_question_id);		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 		
		if ($v_result === true)	return $this->m_dao->getResult();			
		return $v_result;
	}
	public function SaveUserAnswer($p_user_quiz_id, $p_question_id, $p_answer_id, 
								$p_user_answer_id, $p_added_date)	// change 2a
	{
		$v_dao_result01 = $this->QueryUserAnswer($p_user_quiz_id, $p_question_id);
		if(is_null($v_dao_result01)){		
			$v_sql2 = "INSERT INTO user_answers(user_quiz_id, question_id, answer_id, user_answer_id, added_date) 
					   VALUES(:p_user_quiz_id, :p_question_id, :p_answer_id, :p_user_answer_id, now())"; 
			$v_param2 = array("p_user_quiz_id"=>$p_user_quiz_id, "p_question_id"=>$p_question_id,
				"p_answer_id"=>$p_answer_id, "p_user_answer_id"=>$p_user_answer_id);
		}
		else{
			$v_sql2 = "UPDATE user_answers SET answer_id=:p_answer_id, user_answer_id=:p_user_answer_id,added_date=now()
					   WHERE  id=:p_id"; 
			$v_param2 = array("p_answer_id"=>$p_answer_id, "p_user_answer_id"=>$p_user_answer_id,'p_id'=>$v_dao_result01[0]['id']); 
		}			   
		

		$v_result = $this->m_dao->db_write_batch(array($v_sql2), array($v_param2));
		//$v_result = array('$v_param2' => $v_param2, '$v_result' => $v_result, 'm_err' => $this->m_dao->m_err);
		return $v_result;
	}
	
	
	public function FinishQuiz($p_assignment_id, $p_user_id, $p_status, $p_now, $p_user_quiz_id)	// change 2a
	{
		$v_sql0 = "select sum(case when correct_answer=1 and ans.answer_id=ans.user_answer_id then 1 else 0 end) secure_score,
   ans.pass_score max_score,
   sum(case when correct_answer=1 and ans.answer_id=ans.user_answer_id then 1 else 0 end)*100/ans.pass_score secure_per,
   case sum(case when correct_answer=1 and ans.answer_id=ans.user_answer_id then 1 else 0 end)*100/ans.pass_score
     when 100 then 1 else 0 end is_success, ans.user_quiz_id
 from
(select
	a.id answer_id, a.correct_answer, ifnull(uqa.user_answer_id,-1) user_answer_id, asg.pass_score, uqa.user_quiz_id
from answers a
	inner join question_groups qg on a.group_id=qg.id
	inner join questions qs on qs.id=qg.question_id
	inner join assignments asg on asg.quiz_id=qs.quiz_id
	left join (select question_id, answer_id, user_answer_id, ua.user_quiz_id from user_quizzes uq
	    inner join user_answers ua  on ua.user_quiz_id=uq.id
      where uq.user_id=:p_user_id and uq.assignment_id=:p_assignment_id) uqa
             on uqa.question_id=qs.id and a.id=uqa.answer_id
where asg.id=:p_assignment_id) ans";
	$v_param0 = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);		
		$v_res0 = $this->m_dao->db_read($v_sql0, $v_param0);
		
		$v_sql2 = "select uq.id user_quiz_id from user_quizzes uq
      where uq.user_id=:p_user_id and uq.assignment_id=:p_assignment_id";
	    $v_param2 = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);

		
		
		if ($v_res0 === true)
		{	
			$v_res = $this->m_dao->getResult();			
			
		    $v_res2 = $this->m_dao->db_read($v_sql2, $v_param2);				
			if ($v_res2 === true){
				$v_res2 = $this->m_dao->getResult();			
				$p_user_quiz_id = $v_res2[0]['user_quiz_id'];
			}
		}
		//echo("wow");print_r($v_res);echo("hi");
		
		$v_sql1 = "UPDATE user_quizzes SET success=:p_success, status=:p_status, 
			finish_date=:p_finish_date, pass_score_point=:p_pass_score_point, 
			pass_score_perc=:p_pass_score_perc 
			WHERE id=:p_user_quiz_id"; // change 2b
		$v_param1 = array("p_success"=>$v_res[0]['is_success'], "p_status"=>$p_status, 
					"p_finish_date"=>$p_now, "p_pass_score_point"=>$v_res[0]['secure_score'],
					"p_pass_score_perc"=>$v_res[0]['secure_per'],
					"p_user_quiz_id"=>$p_user_quiz_id); // change 2c	
		
		
		$v_result = $this->m_dao->db_write($v_sql1,$v_param1 );
		return $v_result;
	}
	public function FinishQuizOnly($p_assignment_id, $p_user_id, $p_status, $p_now, $p_user_quiz_id)	// change 2a
	{
		$v_sql2 = "select uq.id user_quiz_id from user_quizzes uq
      where uq.user_id=:p_user_id and uq.assignment_id=:p_assignment_id";
	    $v_param2 = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);
		
		$v_res2 = $this->m_dao->db_read($v_sql2, $v_param2);	
		$p_user_quiz_id	= '';
		if ($v_res2 === true){
			$v_res2 = $this->m_dao->getResult();			
			$p_user_quiz_id = $v_res2[0]['user_quiz_id'];
		}

		//echo("wow");print_r($v_res);echo("hi");
		
		$v_sql1 = "UPDATE user_quizzes SET status=:p_status, 
			finish_date=:p_finish_date
			WHERE id=:p_user_quiz_id"; // change 2b
		$v_param1 = array("p_status"=>$p_status, 
					"p_finish_date"=>$p_now, 
					"p_user_quiz_id"=>$p_user_quiz_id); // change 2c	
		
		
		$v_result = $this->m_dao->db_write($v_sql1,$v_param1);
		$v_result = array('$v_result' => $v_result, '$v_param2' => $v_param2, '$p_user_quiz_id' => $p_user_quiz_id, '$v_res2' => $v_res2);
			
		return $v_result;
	}
}
?>