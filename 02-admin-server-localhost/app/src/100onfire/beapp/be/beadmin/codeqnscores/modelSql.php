<?php 
	if(!isset($RUN)) exit(); 
class CodeQnTestScoresSql{

    /* Read	*/

    /*3*/public $QData = 
"SELECT lu.UserID, lu.Name, lu.UserName, y.score Score, y.status_text Attendance, y.answered QnsAnswered, 
y.TestStartedAt, y.TimeSpent 
FROM users lu 
INNER JOIN
	(SELECT c.assignment_id, c.user_id,
		CASE WHEN a.user_id IS NOT NULL THEN a.status ELSE 0 END status,
		CASE WHEN a.user_id IS NOT NULL THEN (CASE WHEN a.status>=1 THEN 'PRESENT' ELSE 'ABSENT' END) ELSE 'ABSENT' END status_text,
		ifnull(b.score,0) score,
		ifnull(b.answered,0) answered, IFNULL(a.TestStartedAt,'NA**') TestStartedAt, IFNULL(a.TimeSpent,'NA**') TimeSpent
	FROM
		(SELECT au.assess_id assignment_id,au.user_id FROM tcode_assess_user au)c 
		LEFT JOIN
			(SELECT  uqz.assess_id assignment_id, uqz.user_id,uqz.user_ass_status status,
				CONCAT('[',DATE_FORMAT(ADDTIME(uqz.ass_start_date,'0:00'),'%h:%i %p'),']') TestStartedAt,
				CONCAT(IFNULL(CONCAT(CASE WHEN TIMESTAMPDIFF(minute,uqz.ass_start_date,uqz.ass_finish_date)=0
										  THEN 1 ELSE TIMESTAMPDIFF(minute,uqz.ass_start_date,uqz.ass_finish_date) END, ''),''),
				CASE WHEN uqz.ass_finish_date IS NULL THEN 'NOT FINISHED'
					 WHEN uqz.user_ass_status=3 THEN '(TIMED OUT)' ELSE '' END) TimeSpent
			FROM  tcode_assess_user uqz
				/*WHERE assignment_id=8
				ORDER BY 5*/
			) a 
		ON(c.assignment_id=a.assignment_id and c.user_id=a.user_id and a.user_id IS NOT NULL) 
		LEFT JOIN
			(SELECT
				uqz.assess_id assignment_id, uqz.user_id, uqz.user_secure_score score,
				IFNULL(ans.question_count,0) question_count,
				IFNULL(ans.testcase_count,0) testcase_count,
				IFNULL(ans.testcase_passed_count,0) testcase_passed_count,
				IFNULL(ans.testcase_count,0)*10 answered
			FROM tcode_assess_base bas
			INNER JOIN
				tcode_assess_user uqz
			ON (bas.assess_id = uqz.assess_id)
			LEFT JOIN
				(SELECT tc.assess_id, tc.user_id,
					  COUNT(DISTINCT tc.question_id) question_count,
					  COUNT(tc.testcase_id) testcase_count,
					  COUNT(DISTINCT CASE WHEN testcase_secure_score>0 THEN tc.testcase_id ELSE NULL END) testcase_passed_count
				  FROM tcode_assess_submit_testcase tc
				  GROUP BY tc.assess_id, tc.user_id
				) ans
			ON (uqz.assess_id=ans.assess_id AND uqz.user_id=ans.user_id)
		   ) b 
		ON(c.user_id = b.user_id and c.assignment_id=b.assignment_id and b.user_id IS NOT NULL)
	WHERE c.assignment_id=:p_assignment_id
	) y 
ON(lu.UserID=y.user_id)"; //-5:30

/*4*/
public $QAssSet = "SET GLOBAL group_concat_max_len = 8000;";

public $QAssTP = "SELECT quiz.quiz_id, quiz.quiz_name, quiz.about_quiz,
quiz.qn_count, 
IFNULL(GROUP_CONCAT(ass.user_list SEPARATOR '</div><div class=\"aptUserList\">'), 'NOT ASSIGNED') assignment
FROM
(SELECT q.group_id quiz_id, q.group_name quiz_name, q.group_name about_quiz,
    count(qn.question_id) qn_count
FROM tcode_q_group_base q
INNER JOIN
  tcode_q_group_q qn
ON(q.group_id=qn.group_id)
GROUP BY q.group_id
) quiz
LEFT JOIN
(SELECT agn.assess_id id, agn.group_id quiz_id, convert(agn.total_score,unsigned) qz_count, agn.total_duration qz_time,
    CONCAT('#',agn.assess_id,',',convert(agn.total_score,unsigned), ' Qns, ', 
      agn.total_duration, ' Mins',GROUP_CONCAT(UserName SEPARATOR ', ')) user_list 
FROM
  tcode_assess_base agn
INNER JOIN 
  tcode_assess_user au 
ON(agn.assess_id = au.assess_id)
INNER JOIN 
  users u 
ON(au.user_id = u.UserID)
GROUP BY agn.assess_id
) ass 
ON (quiz.quiz_id = ass.quiz_id)
GROUP BY quiz.quiz_id";


public $QAssTest = "SELECT assignment_id, quiz_id, quiz_name,
	concat(quiz_name, ' ', CASE WHEN user_list like '%DEVELOPER%' 
								THEN '(DEMO)' ELSE '(STUD)' END) d_quiz_name, 
	qz_count question_count, qz_time quiz_duration, user_list 
FROM( 
  SELECT agn.assess_id assignment_id, agn.group_id quiz_id, agn.assignment_name quiz_name,
    agn.total_score qz_count, agn.total_duration qz_time,
    GROUP_CONCAT(UserName SEPARATOR ', ') user_list 
  FROM
    tcode_assess_base agn 
  INNER JOIN 
    tcode_assess_user au 
  ON(agn.assess_id = au.assess_id)
  INNER JOIN 
    users u
  ON(au.user_id = u.UserID)
  GROUP BY agn.assess_id
  ) test
ORDER BY (CASE WHEN user_list like '%DEVELOPER%' THEN 1 ELSE 0 END), assignment_id DESC";

public $QRptField = "SELECT field_id, field_name, field_list, field_caption, is_active FROM aa_mkrpt_field WHERE is_active=1";

public $QRptUsrGroup = "SELECT group_id, group_name, user_list, is_active FROM aa_mkrpt_usrgroup";


} 