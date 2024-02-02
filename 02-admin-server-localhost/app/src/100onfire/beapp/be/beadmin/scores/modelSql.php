<?php 
	if(!isset($RUN)) exit(); 
class McqTestScoresSql{

    /* Read	*/

    /*3*/public $QData = 
"SELECT lu.UserID, lu.Name, lu.UserName, y.score Score, y.status_text Attendance, y.answered QnsAnswered, 
y.TestStartedAt, y.TimeSpent from users lu INNER JOIN
(SELECT c.assignment_id, c.user_id,
CASE WHEN a.user_id IS NOT NULL THEN a.status ELSE 0 END status,
CASE WHEN a.user_id IS NOT NULL THEN (CASE WHEN a.status>=1 THEN 'PRESENT' ELSE 'ABSENT' END) ELSE 'ABSENT' END status_text,
ifnull(b.score,0) score,
ifnull(b.answered,0) answered, IFNULL(a.TestStartedAt,'NA**') TestStartedAt, IFNULL(a.TimeSpent,'NA**') TimeSpent
FROM
(SELECT au.assignment_id,au.user_id FROM assignment_users au)c LEFT JOIN
(SELECT  uqz.assignment_id, uqz.user_id,uqz.status,
CONCAT('[',DATE_FORMAT(ADDTIME(uqz.added_date,'0:00'),'%h:%i %p'),']') TestStartedAt,
CONCAT(IFNULL(CONCAT(CASE WHEN TIMESTAMPDIFF(minute,uqz.added_date,uqz.finish_date)=0 THEN 1 ELSE TIMESTAMPDIFF(minute,uqz.added_date,uqz.finish_date) END, ''),''),
CASE WHEN uqz.finish_date IS NULL THEN 'NOT FINISHED' WHEN uqz.status=3 THEN '(TIMED OUT)' ELSE '' END) TimeSpent
FROM  user_quizzes uqz
/*WHERE assignment_id=8
ORDER BY 5*/) a ON(c.assignment_id=a.assignment_id and c.user_id=a.user_id and a.user_id IS NOT NULL) LEFT JOIN
(SELECT
uqz.assignment_id assignment_id, uqz.user_id, SUM(CASE WHEN an.correct_answer=1 THEN 1 ELSE 0 END) score,
COUNT(ua.question_id) answered
FROM  user_quizzes uqz INNER JOIN
  user_answers ua  ON(uqz.id = ua.user_quiz_id) INNER JOIN
  answers an ON(ua.answer_id = an.id)
GROUP BY uqz.assignment_id, uqz.user_id
) b ON(c.user_id = b.user_id and c.assignment_id=b.assignment_id and b.user_id IS NOT NULL)
WHERE c.assignment_id=:p_assignment_id
) y ON(lu.UserID=y.user_id)"; //-5:30

/*4*/
public $QAssSet = "SET GLOBAL group_concat_max_len = 8000;";

public $QAssTP = "SELECT quiz.quiz_id, quiz.quiz_name, quiz.about_quiz,
quiz.qn_count, IFNULL(GROUP_CONCAT(ass.user_list SEPARATOR '</div><div class=\"aptUserList\">'), 'NOT ASSIGNED') assignment
FROM
(SELECT q.id quiz_id, q.quiz_name, q.quiz_desc about_quiz, count(qn.id) qn_count
 FROM quizzes q INNER JOIN questions qn ON(q.id=qn.quiz_id) GROUP BY q.id
 ) quiz
LEFT JOIN
  (SELECT agn.id, agn.quiz_id, convert(agn.pass_score,unsigned) qz_count, agn.quiz_time qz_time,
CONCAT('#',agn.id,',',convert(agn.pass_score,unsigned), ' Qns, ', agn.quiz_time, ' Mins',GROUP_CONCAT(UserName SEPARATOR ', ')) user_list FROM
assignments agn
INNER JOIN assignment_users au ON(agn.id = au.assignment_id)
INNER JOIN users u ON(au.user_id = u.UserID)
GROUP BY agn.id) ass ON (quiz.quiz_id = ass.quiz_id)
GROUP BY quiz.quiz_id";


public $QAssTest = "
SELECT assignment_id, quiz_id, quiz_name, concat(quiz_name, ' ', CASE WHEN user_list like '%DEVELOPER%' THEN '(DEMO)' ELSE '(STUD)' END) d_quiz_name, qz_count question_count, qz_time quiz_duration, user_list FROM( 
SELECT agn.id assignment_id, agn.quiz_id, q.quiz_name, convert(agn.pass_score,unsigned) qz_count, agn.quiz_time qz_time,
GROUP_CONCAT(UserName SEPARATOR ', ') user_list FROM
assignments agn INNER JOIN quizzes q ON(agn.quiz_id=q.id)
INNER JOIN assignment_users au ON(agn.id = au.assignment_id)
INNER JOIN users u ON(au.user_id = u.UserID)
GROUP BY agn.id) test
ORDER BY CASE WHEN user_list like '%DEVELOPER%' THEN 1 ELSE 0 END, assignment_id DESC";

public $QRptField = "SELECT field_id, field_name, field_list, field_caption, is_active FROM aa_mkrpt_field WHERE is_active=1";

public $QRptUsrGroup = "SELECT group_id, group_name, user_list, is_active FROM aa_mkrpt_usrgroup";


} 