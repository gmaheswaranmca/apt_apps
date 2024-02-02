<?php 
	if(!isset($RUN)) exit(); 
	if (!defined('ROOTDB')) define('ROOTDB', __DIR__.'/');
	include (realpath(ROOTDB.'../../../gf/WrapperModel.php'));
			
	class AppMonitorModel{
		private $wmd = NULL;		
		private $sql = NULL;
		public function __construct(){
			$this->wmd = new WrapperModel();
			$this->sql = new AppMonitorModelSql();
		}public function QueryTestCountTotal()	{
			return $this->wmd->QueryNoParam($this->sql->sqlQueryTestCountTotal);
		}public function QueryTestCountLive()	{
			return $this->wmd->QueryNoParam($this->sql->sqlQueryTestCountLive);
		}public function QueryTestCountAnswered()	{
			return $this->wmd->QueryNoParam($this->sql->sqlQueryTestCountAnswered);
		}public function QueryTestStatus()	{			
			return $this->wmd->QueryNoParam($this->sql->sqlQueryTestStatus);
		}public function QueryTestIsDemo()	{			
			return $this->wmd->QueryNoParam($this->sql->sqlQueryTestIsDemo);
		}public function WriteAssignmentSetStatus($p_assignment_id,$p_status)	{		
			return $this->wmd->WriteParam(
				array($this->sql->sqlAssignmentSetStatus), 
				array(
					array("p_assignment_id" => $p_assignment_id,
						"p_status" => $p_status)
					)
				);
		}public function QueryResultDownload($p_assignment_id)	{			
			return $this->wmd->QueryParam(
					$this->sql->sqlQueryResultDownload, 
					array(
						"p_assignment_id" => $p_assignment_id
					)
				);
		}
	}
	class AppMonitorModelSql{ 
	
	/*cats	: id, cat_name
	quizzes	: id, cat_id, quiz_name, quiz_desc, added_date, parent_id, show_intro, intro_text
	assignments: id, quiz_id, org_quiz_id, results_mode, added_date, quiz_time, show_results, pass_score, quiz_type, status 
	assignment_users : id, assignment_id, user_type, user_id
	user_quizzes	 : id, assignment_id, user_id, status, added_date, success, finish_date, pass_score_point, pass_score_perc
	user_answers	 : id, user_quiz_id, question_id, answer_id, user_answer_id, user_answer_text, added_date
	users 			 : UserID, UserName, Password, Name, Surname, added_date, user_type, email
01-TestCountTotal 	 -> assignment_id, quiz_name, quiz_duration, question_count, assignment_status, user_count, liveuser_count, answereduser_count, tookuser_count
02-TestCountLive  	 -> assignment_id, liveuser_count, tookuser_count
03-TestCountAnswered ->  assignment_id, answereduser_count
04-TestStatus 		 -> assignment_id, assignment_status
05-TestIsDemo -> assignment_id, is_demo
	*/
	
	/*01-TestCountTotal -> assignment_id, quiz_name, quiz_duration, question_count, assignment_status, user_count, liveuser_count, answereduser_count
	*/public $sqlQueryTestCountTotal = 
"SELECT
  ass.id assignment_id,
  qz.quiz_name,  ass.status assignment_status,
  COUNT(asusr.id) user_count, 0 liveuser_count, 0 answereduser_count, 0 tookuser_count,
  ass.quiz_time quiz_duration, ass.pass_score question_count
FROM         assignments ass
  INNER JOIN quizzes qz   ON(ass.quiz_id = qz.id)
  INNER JOIN assignment_users asusr ON(ass.id = asusr.assignment_id)
GROUP BY ass.id"; 			

	/*02-TestCountLive -> assignment_id, liveuser_count, tookuser_count
	*/public $sqlQueryTestCountLive = 
"SELECT
  uqz.assignment_id, SUM(CASE WHEN uqz.status=1 then 1 else 0 end) liveuser_count,
	SUM(CASE WHEN uqz.status>1 then 1 else 0 end) tookuser_count
FROM user_quizzes uqz WHERE uqz.user_id IS NOT NULL
GROUP BY uqz.assignment_id"; 			

	/*03-TestCountAnswered -> assignment_id, answereduser_count
	*/public $sqlQueryTestCountAnswered = 
"SELECT
  uqz.assignment_id,COUNT(DISTINCT uqz.user_id) answereduser_count
FROM user_quizzes uqz INNER JOIN
     user_answers ua ON(uqz.id = ua.user_quiz_id and uqz.status=1)
GROUP BY uqz.assignment_id"; 			

	/*04-TestStatus -> assignment_id, assignment_status
	*/public $sqlQueryTestStatus = 
"SELECT
  ass.id assignment_id, ass.status assignment_status
FROM         assignments ass
ORDER BY ass.status DESC"; 			
	
	/*05-TestIsDemo -> assignment_id, is_demo
	*/public $sqlQueryTestIsDemo = 
"SELECT ausr.assignment_id, 1 is_demo
FROM         assignment_users ausr
  INNER JOIN users usr ON(ausr.user_id = usr.UserID and usr.UserName like 'developer%')
GROUP BY ausr.assignment_id"; 			
	/*06-AssignmentSetStatus :: args >> p_assignment_id, p_status
	*/public $sqlAssignmentSetStatus = "UPDATE assignments SET status = :p_status WHERE id=:p_assignment_id"; 	

	/*07-ResultDownload :: args >> p_assignment_id
	*/public $sqlQueryResultDownload = 
"select lu.UserID, lu.Name, lu.UserName, y.score Score, y.status_text Attendance, y.answered QnsAnswered from users lu INNER JOIN
(SELECT c.assignment_id, c.user_id,
  CASE WHEN a.user_id IS NOT NULL THEN a.status ELSE 0 END status,
  CASE WHEN a.user_id IS NOT NULL THEN (CASE WHEN a.status>=1 THEN 'PRESENT' ELSE 'ABSENT' END) ELSE 'ABSENT' END status_text,
  ifnull(b.score,0) score,
  ifnull(b.answered,0) answered
FROM
(SELECT au.assignment_id,au.user_id FROM assignment_users au)c LEFT JOIN
(SELECT  uqz.assignment_id, uqz.user_id,uqz.status FROM  user_quizzes uqz) a ON(c.assignment_id=a.assignment_id and c.user_id=a.user_id and a.user_id IS NOT NULL) LEFT JOIN
(SELECT
  uqz.assignment_id assignment_id, uqz.user_id, SUM(CASE WHEN an.correct_answer=1 THEN 1 ELSE 0 END) score,
  COUNT(ua.question_id) answered
FROM  user_quizzes uqz INNER JOIN
      user_answers ua  ON(uqz.id = ua.user_quiz_id) INNER JOIN
      answers an ON(ua.answer_id = an.id)
GROUP BY uqz.assignment_id, uqz.user_id
) b ON(c.user_id = b.user_id and c.assignment_id=b.assignment_id and b.user_id IS NOT NULL)
WHERE c.assignment_id=:p_assignment_id
) y ON(lu.UserID=y.user_id)"; 			
	}
	/*
create table questions_ext01	
SELECT a.id,a.question_text,
    group_concat(concat('{\"id\":',c.id,',\"answer\":\"',
        c.answer_text,'\"}')) question_options,
    md5(max(CASE WHEN c.correct_answer=1 THEN c.id ELSE 0 END)) about_question
from questions a inner join
    question_groups b on(a.id=b.question_id) inner join
    answers c on (b.id=c.group_id)
where a.parent_id=0
group by a.id;	

create table quizzes_ext01	
SELECT a.id, a.quiz_name, a.intro_text, 30 pass_score, 60 quiz_time FROM quizzes a WHERE a.parent_id=0;	

CREATE TABLE user_group_ext01 AS
SELECT assignment_id user_group_id, user_id FROM assignment_users WHERE assignment_id=2;

CREATE TABLE user_admin_ext01 AS
SELECT a.user_id, b.UserName login_user_id, '' login_password_nomd5, b.Password login_password, b.Name full_name
FROM assignment_users a INNER JOIN users b ON(a.user_id=b.UserID)
WHERE a.assignment_id=1;

CREATE TABLE user_student_ext01 AS
SELECT a.user_id, b.UserName login_user_id, '' login_password_nomd5, b.Password login_password, b.Name full_name
FROM assignment_users a INNER JOIN users b ON(a.user_id=b.UserID)
WHERE a.assignment_id=1;

CREATE TABLE user_superadmin_ext01 AS
SELECT b.UserID user_id, b.UserName login_user_id, '' login_password_nomd5, b.Password login_password, b.Name full_name
FROM  users b
WHERE b.UserID=1;

CREATE TABLE assignments_ext01 AS
SELECT a.id assignment_id, a.quiz_id,2 user_group_id  FROM assignments a WHERE a.id%2=1;

CREATE TABLE student_test_score_ext01 AS
SELECT a.assignment_id assignment_id, a.user_id, 0 attempt_no, b.status,b.added_date test_start_time, b.added_date test_end_time,
  ifnull(b.pass_score_point,0) score_took, 0 qns_answered_count, '' score_card, '' detailed_score_card
FROM assignment_users a INNER JOIN
    user_quizzes b ON(a.user_id = b.user_id and a.assignment_id=b.assignment_id)
WHERE a.assignment_id=2 and b.user_id=385


DROP TABLE IF EXISTS `t20apt01moon`.`assignments_ext01`;
CREATE TABLE  `t20apt01moon`.`assignments_ext01` (
  `assignment_id` int(11) NOT NULL DEFAULT '0',
  `quiz_id` int(11) NOT NULL DEFAULT '0',
  `user_group_id` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t20apt01moon`.`questions_ext01`;
CREATE TABLE  `t20apt01moon`.`questions_ext01` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_text` varchar(8000) DEFAULT NULL,
  `question_options` varchar(342) CHARACTER SET utf8 DEFAULT NULL,
  `about_question` varchar(32) CHARACTER SET utf8 DEFAULT NULL COMMENT 'answer key',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t20apt01moon`.`quizzes_ext01`;
CREATE TABLE  `t20apt01moon`.`quizzes_ext01` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quiz_name` varchar(500) NOT NULL,
  `intro_text` varchar(3850) DEFAULT NULL,
  `pass_score` int(2) NOT NULL DEFAULT '0',
  `quiz_time` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t20apt01moon`.`student_test_score_ext01`;
CREATE TABLE  `t20apt01moon`.`student_test_score_ext01` (
  `assignment_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `attempt_no` int(1) NOT NULL DEFAULT '0',
  `status` int(11) DEFAULT NULL,
  `test_start_time` datetime DEFAULT NULL,
  `test_end_time` datetime DEFAULT NULL,
  `score_took` decimal(10,2) NOT NULL DEFAULT '0.00',
  `qns_answered_count` int(1) NOT NULL DEFAULT '0',
  `score_card` char(0) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `detailed_score_card` char(0) CHARACTER SET utf8 NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t20apt01moon`.`user_admin_ext01`;
CREATE TABLE  `t20apt01moon`.`user_admin_ext01` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `login_user_id` varchar(50) NOT NULL,
  `login_password_nomd5` char(0) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `login_password` varchar(50) NOT NULL,
  `full_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t20apt01moon`.`user_group_ext01`;
CREATE TABLE  `t20apt01moon`.`user_group_ext01` (
  `user_group_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t20apt01moon`.`user_student_ext01`;
CREATE TABLE  `t20apt01moon`.`user_student_ext01` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `login_user_id` varchar(50) NOT NULL,
  `login_password_nomd5` char(0) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `login_password` varchar(50) NOT NULL,
  `full_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `t20apt01moon`.`user_superadmin_ext01`;
CREATE TABLE  `t20apt01moon`.`user_superadmin_ext01` (
  `user_id` int(11) NOT NULL DEFAULT '0',
  `login_user_id` varchar(50) NOT NULL,
  `login_password_nomd5` char(0) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `login_password` varchar(50) NOT NULL,
  `full_name` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ext01_question : question_id, question_text, question_options, answer_key, question_score_point, section_id, 
  question_group_id, question_section_id, question_subject_id
ext01_quiz: quiz_id, quiz_name, intro_text, qns_count, time_mins, suffle_rule, total_score_point, is_disabled  
ext01_quiz_question: quiz_id, question_id
ext01_question_section: question_section_id, question_section (<<<<===optional)
ext01_question_group: question_group_id, question_group, question_subject_id (<<<<===optional)
ext01_question_subject: question_subject_id, question_subject (<<<<===optional)

ext01_user: user_id, login_user_name, login_password, full_name, is_super_admin, is_admin, 
            is_disabled  (optional)
ext01_user_group: user_group_id, user_group_name, is_diabled (optional)
ext01_user_group_user: user_group_id, user_id
    
ext01_assignment: assignment_id, quiz_id, assignment_name, assginment_status, valid_from, valid_to, user_group_id,
                  assignment_score_card
ext01_assignment_user_score: assignment_id, user_id, attempt_no, user_assignment_status, assignment_user_score, 
      qns_answered_count, simple_score_card, extended_score_card, questions_suffle_order, test_start_time, score_update_time,
	  test_end_time, total_time_took
	  !extended_score_card -> |average_score_point_per_qn, qns_answered_count, user_score
							  |ques_id, user_answer_option, is_answered_correct, visited_secs, ques_score, answered_times_count
	                          |subject_id, qns_answered_correct_count, subject_score, subject_maximum_score_point
                              |question_group_id, qns_answered_correct_count, group_score, group_maximum_score_point
							  
							  
							  
							  
							  
							  
							  
							  
							  
	  

*/
	
	
?>
