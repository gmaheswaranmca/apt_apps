<?php 
	if(!isset($RUN)) exit(); 
class SysAdmModelSql{

    /* Read	*/
    public $QueryNow = 
"SELECT now() now_date_time";
    //
    //
    public $QueryTestCountTotal = 
"SELECT
ass.id assignment_id,
qz.quiz_name,  ass.status assignment_status,
COUNT(asusr.id) user_count, 0 liveuser_count, 0 answereduser_count, 0 tookuser_count,
ass.quiz_time quiz_duration, ass.pass_score question_count
FROM         assignments ass
INNER JOIN quizzes qz   ON(ass.quiz_id = qz.id)
INNER JOIN assignment_users asusr ON(ass.id = asusr.assignment_id)
GROUP BY ass.id"; 	

    //
    public $QueryTestCountLive = 
"SELECT
uqz.assignment_id, SUM(CASE WHEN uqz.status=1 then 1 else 0 end) liveuser_count,
SUM(CASE WHEN uqz.status>1 then 1 else 0 end) tookuser_count
FROM user_quizzes uqz WHERE uqz.user_id IS NOT NULL
GROUP BY uqz.assignment_id"; 			

    //
    public $QueryTestCountAnswered = 
"SELECT
uqz.assignment_id,COUNT(DISTINCT uqz.user_id) answereduser_count
FROM user_quizzes uqz INNER JOIN
    user_answers ua ON(uqz.id = ua.user_quiz_id and uqz.status=1)
GROUP BY uqz.assignment_id"; 			

    //
    public $QueryTestStatus = 
"SELECT
ass.id assignment_id, ass.status assignment_status
FROM         assignments ass
ORDER BY ass.status DESC"; 			

    //
    public $QueryTestIsDemo = 
"SELECT ausr.assignment_id, 1 is_demo
FROM         assignment_users ausr
INNER JOIN users usr ON(ausr.user_id = usr.UserID and usr.UserName like 'developer%')
GROUP BY ausr.assignment_id"; 			

    //Write

    //
    public $WriteAssignmentSetStatus = "UPDATE assignments 
SET status = :p_status 
WHERE id=:p_assignment_id"; 	

    //
        //
        public $QueryCodeQnTestCountTotal = 
        "SELECT
ass.assess_id assignment_id,
ass.assignment_name quiz_name,  ass.assignment_status assignment_status,
COUNT(asusr.user_id) user_count, 0 liveuser_count, 0 answereduser_count, 0 tookuser_count,
ass.total_duration quiz_duration, ass.total_q question_count, ass.total_score question_count_d
FROM         tcode_assess_base ass 
INNER JOIN tcode_assess_user asusr ON(ass.assess_id = asusr.assess_id) 
GROUP BY ass.assess_id"; 	
        
            //
            public $QueryCodeQnTestCountLive = 
        "SELECT
        uqz.assess_id assignment_id, SUM(CASE WHEN uqz.user_ass_status=1 then 1 else 0 end) liveuser_count,
        SUM(CASE WHEN uqz.user_ass_status>1 then 1 else 0 end) tookuser_count
        FROM tcode_assess_user uqz WHERE uqz.user_id IS NOT NULL
        GROUP BY uqz.assess_id"; 			
        
            //
            public $QueryCodeQnTestCountAnswered = 
        "SELECT
uqz.assess_id assignment_id,COUNT(DISTINCT uqz.user_id) answereduser_count
FROM tcode_assess_user uqz INNER JOIN
    tcode_assess_submit_testcase ua ON(uqz.assess_id = ua.assess_id and uqz.user_ass_status=1)
GROUP BY uqz.assess_id"; 			
        
            //
            public $QueryCodeQnTestStatus = 
        "SELECT
ass.assess_id assignment_id, ass.assignment_status assignment_status
FROM         tcode_assess_base ass
ORDER BY ass.assignment_status DESC"; 			
        
            //
            public $QueryCodeQnTestIsDemo = 
        "SELECT ausr.assess_id assignment_id, 1 is_demo
FROM         tcode_assess_user ausr
INNER JOIN users usr ON(ausr.user_id = usr.UserID and usr.UserName like 'developer%')
GROUP BY ausr.assess_id"; 

        //
        public $QueryCodeQnTestCases = 
        "SELECT
        uqz.assess_id assignment_id,
        ifnull(uqcount.number_of_runs,0) number_of_runs,
        ifnull(uacount.tc_count,0) tc_count,
        ifnull(uqcount.number_of_runs,0) + 	ifnull(uacount.tc_count,0) total_runs,
        ifnull(uacount.tc_scored_count,0) tc_scored_count,
        ifnull(uqstatus.run_users,0) run_users,
        ifnull(uastatus.tc_users,0) tc_users,
		ifnull(totstatus.total_runners,0) total_runners
    FROM tcode_assess_base uqz
        LEFT JOIN
          (SELECT ua.assess_id, SUM(number_of_runs) number_of_runs
           FROM tcode_assess_submit_q ua
           GROUP BY ua.assess_id) uqcount
        ON (uqz.assess_id=uqcount.assess_id)
        LEFT JOIN
          (SELECT ua.assess_id, COUNT(*) tc_count,
            SUM(CASE WHEN testcase_secure_score>0 THEN 1 ELSE 0 END) tc_scored_count
           FROM tcode_assess_submit_testcase ua
           GROUP BY ua.assess_id) uacount
         ON (uqz.assess_id=uacount.assess_id)
        LEFT JOIN
          (SELECT ua.assess_id, COUNT(DISTINCT CASE WHEN ua.number_of_runs>0 THEN ua.user_id ELSE NULL END) run_users
           FROM tcode_assess_submit_q ua
           GROUP BY ua.assess_id) uqstatus
        ON (uqz.assess_id=uqstatus.assess_id)
        LEFT JOIN
          (SELECT ua.assess_id, COUNT(DISTINCT ua.user_id) tc_users
           FROM tcode_assess_submit_testcase ua
           GROUP BY ua.assess_id) uastatus
         ON (uqz.assess_id=uastatus.assess_id)
		 LEFT JOIN
			(SELECT totstatusbef.assess_id, count(DISTINCT user_id) total_runners  FROM 
          (SELECT ua.assess_id, CASE WHEN ua.number_of_runs>0 THEN ua.user_id ELSE NULL END user_id
           FROM tcode_assess_submit_q ua
           GROUP BY ua.assess_id,ua.user_id
		   UNION
		  SELECT ua.assess_id, ua.user_id 
           FROM tcode_assess_submit_testcase ua
           GROUP BY ua.assess_id,ua.user_id) totstatusbef
		   GROUP BY totstatusbef.assess_id) totstatus
         ON (uqz.assess_id=totstatus.assess_id)";

    //
    public $WriteCodeQnAssignmentSetStatus = "UPDATE tcode_assess_base 
    SET assignment_status = :p_status 
    WHERE assess_id=:p_assignment_id"; 	


    //
    //
    public $QueryAppHmServers = 
        "SELECT server_id, server_name, url, url_mid
FROM  apphm_servers"; 

    public $QueryAppHmApps = 
        "SELECT app_id, server_id, app_name, db_name, display_name, is_active
FROM  apphm_apps WHERE is_active=1";

    public $QueryAptJobConfig = 
"SELECT config_dbid, job_master_path, live_status
FROM  apt_job_config where config_dbid=1";

} 