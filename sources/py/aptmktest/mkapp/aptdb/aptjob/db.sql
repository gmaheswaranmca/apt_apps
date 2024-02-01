/*
DB: db.sqlite3
apt_job: job_id, job_type, status
apt_score_job: score_job_id, files_path_name, status, mail_subject, mail_file_path

            (+)

aptjob_base: 
        job_id, job_type,                   status          linkname    test_date       
                1-Generate Scores           1-NOT DONE                  ie test_date        
                2-Send Mail                 2-DONE
                3-Download Test Link DB
                4-Upload Test Link DB

aptjob_score: job_id, task_start_date, task_end_date, files_path_name, mail_subject,  
    mail_file_path, dest_file_path, status [0-NA, 1-Source Files Created, 2-Dest/Mail Files Create]

aptjob_mail: job_id, task_start_date, task_end_date, status[0-Not Mail Sent, 1-Mail Sent], recipients, sender, body_of_mail

aptjob_config: 
    config_id, 
    server_and_link_file_path,  -> Path for Preference file where 'Server of Links' table and 'Links of tests' are available
    job_log_file_path, -> Path for Jobs Entry file
    
=> 


*/

/*
DB: db.sqlite3
*/
Create Table apt_job(
    job_id integer primary key autoincrement,
    job_type integer not null default 1,
    status integer not null default 1
);
/*
Here,
job_type    : 1-scores, 2-upload test link db, 3-download test link db
status      : 1-not done, 2-done
*/

INSERT INTO apt_job(job_id,job_type,status) VALUES(1,1,1);

/*
*/
Create Table apt_score_job(
    score_job_id integer primary key autoincrement,
    files_path_name varchar(1000),
    status integer not null default 1,,
	mail_subject	varchar(250) NOT NULL DEFAULT '',
	mail_file_path	VARCHAR(1500) NOT NULL DEFAULT ''
);
/*
Here,
status: 0-NA, 1-Source Done, 2-Dest Done, 3-Scores Done, 4-Mail Done
*/

INSERT INTO apt_score_job(score_job_id,files_path_name,status) VALUES(1,'',1);



/*
(+)
*/

/*

aptjob_base: 
        job_id, job_type,                   status          linkname    test_date       
                1-Generate Scores           1-NOT DONE                  ie test_date        
                2-Send Mail                 2-DONE
                3-Download Test Link DB
                4-Upload Test Link DB

*/

Create Table aptjob_base(
    job_id integer primary key autoincrement,
    job_type integer not null default 1,
    status integer not null default 1,
    linkname varchar(100) not null default '',
    test_date DATETIME
);

/*

aptjob_score: job_id, task_start_date, task_end_date,  files_path_name, mail_subject,  
    mail_file_path, dest_file_path, status [0-NA, 1-Source Files Created, 2-Dest/Mail Files Create]


*/

Create Table aptjob_score(
    job_id integer primary key autoincrement,
    task_start_date DATETIME,
    task_end_date DATETIME,
    files_path_name varchar(1000),
    status integer not null default 1,
	mail_subject	varchar(250) NOT NULL DEFAULT '',
	mail_file_path	VARCHAR(1500) NOT NULL DEFAULT '',
	dest_file_path	VARCHAR(1500) NOT NULL DEFAULT ''
);

/*

aptjob_mail: job_id, task_start_date, task_end_date, status[0-Not Mail Sent, 1-Mail Sent], to_ids, from_id, body_of_mail

*/

Create Table aptjob_mail(
    job_id integer primary key autoincrement,
    task_start_date DATETIME,
    task_end_date DATETIME,
    status integer not null default 1,
	to_ids	VARCHAR(1500) NOT NULL DEFAULT '',
    from_id	varchar(250) NOT NULL DEFAULT '',
	body_of_mail	VARCHAR(1500) NOT NULL DEFAULT ''
);


/*

aptjob_config: 
    config_id, 
    server_and_link_file_path,  -> Path for Preference file where 'Server of Links' table and 'Links of tests' are available
    job_log_file_path, -> Path for Jobs Entry file

*/

Create Table aptjob_config(
    config_id integer primary key autoincrement,
	server_and_link_file_path	VARCHAR(1500) NOT NULL DEFAULT '',
    job_log_file_path	VARCHAR(1500) NOT NULL DEFAULT ''
);


INSERT INTO aptjob_config(config_id,server_and_link_file_path,job_log_file_path) 
VALUES(1,
'F:/v2m/techLang/assignment/2020-07-08-Apt-BulkQuestions/OLT/OLTAssignment/scoresfiles/app_master/apt_job_master.json',
'F:/v2m/techLang/assignment/2020-07-08-Apt-BulkQuestions/OLT/OLTAssignment/scoresfiles/app_master/job-log.xlsx');