<?php 
	if(!isset($RUN)) exit(); 
class AptJobModelSql{

    /* Read	*/
    //
    public $QueryJobSchedule = 
"SELECT schedule_dbid, schedule_id, version_no, 
    job_from_date, job_to_date, 
    added_date, is_closed, test_link_name
FROM apt_job_schedule"; 	

    //
    public $QueryJobBase = 
"SELECT job_dbid, schedule_dbid, job_id, version_no, 
    job_type, job_src_text, job_py_text, job_date, 
    added_date, test_link_name, 
    is_job_done, job_done_date, job_cost
FROM apt_job_base"; 			

    //
    public $QueryJobScheduleVersion = 
"SELECT schedule_dbid, schedule_id, version_no, 
    job_from_date, job_to_date, 
    added_date, is_closed, test_link_name
FROM apt_job_schedule_version"; 			

    //
    public $QueryJobBaseVersion = 
"SELECT job_dbid, schedule_dbid, job_id, version_no, 
    job_type, job_src_text, job_py_text, job_date, 
    added_date, test_link_name, 
    is_job_done, job_done_date, job_cost
FROM apt_job_base_version"; 			

    //Write

    //
public $InsertJobSchedule = "INSERT INTO apt_job_schedule
    (schedule_id, version_no, job_from_date, job_to_date, 
        added_date, is_closed, test_link_name)
    VALUES(:p_schedule_id, 1, :p_job_from_date, :p_job_to_date, 
        now(), 0, :p_test_link_name)"; 	
//
public $InsertJobScheduleVersion = "INSERT INTO apt_job_schedule_version
(schedule_dbid, schedule_id, version_no, 
    job_from_date, job_to_date, 
    added_date, is_closed, test_link_name)    
SELECT schedule_dbid, schedule_id, version_no, 
    job_from_date, job_to_date, 
    added_date, is_closed, test_link_name
FROM apt_job_schedule WHERE schedule_dbid=:p_schedule_dbid"; 

//
public $InsertJobBase = "INSERT INTO apt_job_base
(schedule_dbid, job_id, version_no, 
    job_type, job_src_text, job_py_text, job_date, 
    added_date, test_link_name, 
    is_job_done, job_done_date, job_cost)
VALUES(:p_schedule_dbid, :p_job_id, 1, 
    :p_job_type, :p_job_src_text, :p_job_py_text, :p_job_date, 
    NOW(), :p_test_link_name, 
    false, NULL, :p_job_cost)";

//
public $InsertJobBaseVersion = "INSERT INTO apt_job_base_version
(job_dbid, schedule_dbid, job_id, version_no, 
    job_type, job_src_text, job_py_text, job_date, 
    added_date, test_link_name, 
    is_job_done, job_done_date, job_cost)
SELECT job_dbid, schedule_dbid, job_id, version_no, 
    job_type, job_src_text, job_py_text, job_date, 
    added_date, test_link_name, 
    is_job_done, job_done_date, job_cost
FROM apt_job_base WHERE job_dbid=:p_job_dbid";

//
public $UpdateJobSchedule = "UPDATE apt_job_schedule
 SET version_no=:p_version_no, 
    job_from_date=:p_job_from_date, job_to_date=:p_job_to_date, 
    added_date=NOW()
 WHERE schedule_dbid=:p_schedule_dbid";

//
public $UpdateCloseJobSchedule = "UPDATE apt_job_schedule
 SET is_closed=:p_is_closed
 WHERE schedule_dbid=:p_schedule_dbid";

//
public $UpdateJobBase = "UPDATE apt_job_base
 SET version_no = :p_version_no, job_type = :p_job_type,
    job_src_text = :p_job_src_text, job_py_text = :p_job_py_text, job_date = :p_job_date, 
    job_cost = :p_job_cost,
    added_date=NOW()
 WHERE job_dbid=:p_job_dbid";

//
public $UpdateDoneJobBase = "UPDATE apt_job_base
 SET is_job_done=:p_is_job_done, job_done_date=:p_job_done_date
 WHERE job_dbid=:p_job_dbid";

//
public $DeleteJobScheduleVersion = "DELETE FROM apt_job_schedule_version
 WHERE schedule_dbid=:p_schedule_dbid AND version_no=:p_version_no";

//
public $DeleteJobBaseVersion = "DELETE FROM apt_job_base_version
 WHERE job_dbid=:p_job_dbid AND version_no=:p_version_no";

//
public $UpdateLiveStatus = 
"UPDATE apt_job_config SET live_status=:p_live_status
 WHERE config_dbid=1";
} 