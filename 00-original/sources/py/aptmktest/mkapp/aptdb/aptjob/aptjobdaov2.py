from .aptjobdb import AptJobDb

class AptJobDao:
    @staticmethod
    def addScoreJob(fileNames, linkname, test_date): 
        opStatus = False
        sqlJob = """INSERT INTO aptjob_base(job_type, status, linkname, test_date) 
VALUES(1,1,'%s','%s')"""
        sqlJobParsed = sqlJob%(linkname,test_date,)
        AptJobDb.WriteBatchDo([sqlJobParsed])
        job_id = AptJobDb.GetLastId() #get "generated 'job id'" here
        

        sqlScoreJob = """INSERT INTO aptjob_score(job_id, task_start_date, task_end_date,  
files_path_name, mail_subject, mail_file_path, dest_file_path, status)
VALUES(%s,now(),NULL,
    '%s','','','',1)
"""
        sqlScoreJobParsed = sqlScoreJob%(job_id, fileNames,)

        AptJobDb.WriteBatchDo([sqlScoreJobParsed])
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