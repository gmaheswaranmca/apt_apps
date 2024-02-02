from .aptjobdb import AptJobDb
'''
DB: db.sqlite3

Create Table apt_job(
    job_id integer primary key autoincrement,
    job_type integer not null default 1,
    status integer not null default 1
);
job_type    : 1-scores, 2-upload test link db, 3-download test link db
status      : 1-not done, 2-done

INSERT INTO apt_job(job_id,job_type,status) VALUES(1,1,1);

Create Table apt_score_job(
    score_job_id integer primary key autoincrement,
    files_path_name varchar(1000),
    status integer not null default 1,,
	mail_subject	varchar(250) NOT NULL DEFAULT '',
	mail_file_path	VARCHAR(1500) NOT NULL DEFAULT ''
);
status: 0-NA, 1-Source Done, 2-Dest Done, 3-Scores Done, 4-Mail Done

INSERT INTO apt_score_job(score_job_id,files_path_name,status) VALUES(1,'',1);
'''
class AptJobDao:
    @staticmethod
    def addJob(jobType): 
        sqlJob = 'UPDATE apt_job SET job_type=%s, status=1 WHERE job_id=1'
        sqlJobParsed = sqlJob%(jobType,)

        AptJobDb.RunE2E([sqlJobParsed])

    '''
        called from web app 
        -> "save scores and make scores file"
    '''
    @staticmethod
    def addScoreJob(fileNames): 
        opStatus = False
        sqlJob = 'UPDATE apt_job SET job_type=%s, status=1 WHERE job_id=1'
        sqlJobParsed = sqlJob%('1',)

        sqlScoreJob = "UPDATE apt_score_job SET files_path_name='%s', status=1 WHERE score_job_id=1"
        sqlScoreJobParsed = sqlScoreJob%(fileNames,)

        AptJobDb.WriteBatchDo([sqlJobParsed, sqlScoreJobParsed])
        opStatus = True 
        return opStatus 

    '''
        called from web app 
        -> "turn the status to new one"
    '''
    @staticmethod
    def updateScoreJob(status): 
        opStatus = False
        sqlScoreJob = "UPDATE apt_score_job SET status=%s WHERE score_job_id=1"
        sqlScoreJobParsed = sqlScoreJob%(status,)

        AptJobDb.WriteBatchDo([sqlScoreJobParsed])
        opStatus = True 
        return opStatus 

    @staticmethod
    def updateScoreJobMailDetail(status, subject, attachment_file_path): 
        opStatus = False
        sqlScoreJob = "UPDATE apt_score_job SET status=%s, mail_subject='%s', mail_file_path='%s'  WHERE score_job_id=1"
        sqlScoreJobParsed = sqlScoreJob%(status, subject, attachment_file_path,)

        AptJobDb.WriteBatchDo([sqlScoreJobParsed])
        opStatus = True 
        return opStatus         

    @staticmethod
    def updateJob(status): 
        opStatus = False
        sqlJob = "UPDATE apt_job SET status=%s WHERE job_id=1"
        sqlJobParsed = sqlJob%(status,)

        AptJobDb.WriteBatchDo([sqlJobParsed])
        opStatus = True 
        return opStatus 

    '''
        called from jobApp
        -> "DO::make scores file"
    '''
    @staticmethod
    def readJob(): 
        sqlJob = 'SELECT job_type,status FROM apt_job'
        sqlScoreJob = 'SELECT files_path_name,status, mail_subject, mail_file_path FROM apt_score_job'
        dbData = AptJobDb.ReadBatchDo([sqlJob,sqlScoreJob])
        return dbData 