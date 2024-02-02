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
	ifnull(ua.pass_score_point,-1) pass_score_point, now() now_server, au.shuffled_qn_ids,
	ifnull(tpr.rule,'') tp_rule
 from assignments a
   inner join quizzes q on a.quiz_id = q.id
   inner join apt_tp_rule tpr on a.quiz_id = tpr.tp_id
   inner join assignment_users au on a.id = au.assignment_id
   left join user_quizzes ua on ua.assignment_id =a.id and au.user_id=ua.user_id
 where a.status = 1 and a.id=:p_assignment_id and au.user_id=:p_user_id
 order by a.added_date desc;"; // change 5b
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);	// change 5c
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryUserQuiz($p_assignment_id, $p_user_id)	{
		
		$v_sql = 
"select ifnull(ua.status,0) user_quiz_status, 
	ua.id user_quiz_id, ua.added_date uq_added_date
from user_quizzes ua 
	inner join assignments a on(a.id=ua.assignment_id)
where a.status=1 and ua.user_id=:p_user_id and ua.assignment_id=:p_assignment_id 
order by a.added_date desc";
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryQuestions($p_assignment_id, $p_user_id){
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
	public function QueryAnswers($p_assignment_id, $p_user_id)
	{
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
";
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	
	public function QueryAssessesmentByUser($p_user_id){
		
		$v_sql = 
"select a.id assignment_id, a.quiz_id, a.quiz_time, a.pass_score, a.status,
	q.cat_id, q.quiz_name, q.quiz_desc, q.show_intro, q.intro_text,  
	ifnull(ua.status,0) user_quiz_status, ua.id user_quiz_id, ua.added_date uq_added_date, 
	ua.finish_date, 
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
		
		if ($v_result === true){	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}

	public function QueryAssCodeByUser($p_user_id)	// change 5a
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
		$v_param = array("p_user_id"=>$p_user_id);	
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryAssLink()	
	{	
		$v_sql = 
"select link_id, link_text, link_url, order_no, is_active	
from aa_link
where is_active = 1
order by order_no asc"; 
		$v_param = array();	
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}

	public function InsertUserQuiz($p_asg_id, $p_user_id){
		$v_sql2 = "INSERT INTO user_quizzes(assignment_id, user_id, status, added_date, success) VALUES(:p_asg_id, :p_user_id, 1, now(), 0)";
		$v_param2 = array("p_asg_id"=>$p_asg_id, "p_user_id"=>$p_user_id); // change 2c
		
		$v_result = $this->m_dao->db_write_batch(array($v_sql2), array($v_param2));
		return $v_result;
	}
	public function SaveShuffleIDs($p_asg_id, $p_user_id, $p_shuffled_qn_ids){
		$v_sql2 = "UPDATE assignment_users SET shuffled_qn_ids=:p_shuffled_qn_ids WHERE assignment_id=:p_asg_id and user_id=:p_user_id";
		$v_param2 = array('p_shuffled_qn_ids'=>$p_shuffled_qn_ids,"p_asg_id"=>$p_asg_id, "p_user_id"=>$p_user_id); // change 2c
		
		$v_result = $this->m_dao->db_write_batch(array($v_sql2), array($v_param2));
		return $v_result;
	}
	public function UpdateAdjustQuizTime($p_user_quiz_id){
		$v_sql1 = "UPDATE user_quizzes SET added_date=now()	WHERE id=:p_user_quiz_id";
		$v_param1 = array("p_user_quiz_id"=>$p_user_quiz_id);
		$v_result = $this->m_dao->db_write($v_sql1,$v_param1);			
		return $v_result;
	}
	public function QueryUserAnswers($p_assignment_id, $p_user_id){
		
		$v_sql = "select question_id, answer_id, user_answer_id from user_quizzes uq
	    inner join user_answers ua  on ua.user_quiz_id=uq.id
		where uq.user_id=:p_user_id and uq.assignment_id=:p_assignment_id
"; 
		$v_param = array("p_assignment_id"=>$p_assignment_id, "p_user_id"=>$p_user_id);	
		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 
		
		if ($v_result === true)
		{	
			return $this->m_dao->getResult();			
		}
		return $v_result;
	}
	public function QueryUserAnswer($p_user_quiz_id, $p_question_id){
		$v_sql = "SELECT id FROM user_answers where user_quiz_id=:p_user_quiz_id and question_id=:p_question_id";
		$v_param = array("p_user_quiz_id"=>$p_user_quiz_id, "p_question_id"=>$p_question_id);		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 		
		if ($v_result === true)	return $this->m_dao->getResult();			
		return $v_result;
	}
	public function QueryUserQz($p_user_quiz_id){
		$v_sql = "SELECT * FROM user_quizzes where id=:p_user_quiz_id";
		$v_param = array("p_user_quiz_id"=>$p_user_quiz_id);		
		$v_result = $this->m_dao->db_read($v_sql, $v_param, 1); 		
		if ($v_result === true)	{
			$v_result = $this->m_dao->getResult();			
			return array('user_id'=>$v_result[0]['user_id'],'assignment_id'=>$v_result[0]['assignment_id']);
		}
		return $v_result; 
	}
	public function SaveUserAnswer($p_user_quiz_id, $p_question_id, $p_answer_id, $p_answered_ids)	
	{
		$v_dao_result01 = $this->QueryUserAnswer($p_user_quiz_id, $p_question_id);
		$data = $this->QueryUserQz($p_user_quiz_id);
		$v_sql1 = "UPDATE assignment_users SET answered_ids=:p_answered_ids WHERE user_id=:p_user_id and assignment_id=:p_assignment_id";
		$v_param1 = array('p_answered_ids'=>$p_answered_ids,'p_user_id'=>$data['user_id'],'p_assignment_id'=>$data['assignment_id']);
		if(is_null($v_dao_result01)){		
			$v_sql2 = "INSERT INTO user_answers(user_quiz_id, question_id, answer_id, user_answer_id, added_date) 
					   VALUES(:p_user_quiz_id, :p_question_id, :p_answer_id, :p_user_answer_id, now())"; 
			$v_param2 = array("p_user_quiz_id"=>$p_user_quiz_id, "p_question_id"=>$p_question_id,
				"p_answer_id"=>$p_answer_id, "p_user_answer_id"=>$p_answer_id);
		}
		else{
			$v_sql2 = "UPDATE user_answers SET answer_id=:p_answer_id, user_answer_id=:p_user_answer_id,added_date=now()
					   WHERE  id=:p_id"; 
			$v_param2 = array("p_answer_id"=>$p_answer_id, "p_user_answer_id"=>$p_answer_id,'p_id'=>$v_dao_result01[0]['id']); 
		}			  		

		$v_result = $this->m_dao->db_write_batch(array($v_sql1,$v_sql2), array($v_param1,$v_param2));
		return $v_result;
	}
	
	public function FinishQuizOnly($p_status, $p_user_quiz_id, $p_quiz_time){
		$v_sql1 = "UPDATE user_quizzes SET status=:p_status, 
			finish_date=now()
			WHERE id=:p_user_quiz_id";
		$v_param1 = array("p_status"=>$p_status,  
					"p_user_quiz_id"=>$p_user_quiz_id);
		$v_sql2 = "UPDATE user_quizzes SET finish_date=TIMESTAMPADD(MINUTE,:p_quiz_time_set,added_date )
			WHERE id=:p_user_quiz_id AND (TIMESTAMPDIFF(minute,added_date, finish_date) > :p_quiz_time_chk OR status=3)";
		$v_param2 = array("p_quiz_time_set"=>$p_quiz_time,  
					"p_user_quiz_id"=>$p_user_quiz_id,
					"p_quiz_time_chk"=>$p_quiz_time);
		//$v_result = $this->m_dao->db_write($v_sql1,$v_param1);			
		$v_result = $this->m_dao->db_write_batch(array($v_sql1,$v_sql2), array($v_param1,$v_param2));
		return $v_result;
	}
}
?>