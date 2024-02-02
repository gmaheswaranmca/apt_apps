from .aptjobdao import AptJobDao

class AptJobController:
    @staticmethod
    def actionScoreJob():
        dbData = AptJobDao.readJob()
        jobData = dbData[0]
        scoreJobData = dbData[1] 
        job = jobData[0]
        scoreJob = scoreJobData[0]

        subject,fileAttachment = scoreJob['mail_subject'], scoreJob['mail_file_path']

        isJob = False 
        if job['status']==1 and scoreJob['status']<=3:
            files_path_name = scoreJob['files_path_name']
            print("Files:", scoreJob['files_path_name'])
            #Do here the job

            if scoreJob['status'] == 1 or scoreJob['status'] == 2:
                #Make Scores File (Dest)
                #AptJobDao.updateScoreJob(2)

                #Make Formatted Scores File(Mail)
                print("Make Scores File (Dest)...")
                print("Make Formatted Scores File(Mail)...")
                from .mkscores import ScoreTE        
                csvFileWOext = files_path_name.split(",")
                result = ScoreTE.proApiJobManyStepTwo(csvFileWOext)
                subject,fileAttachment = result['mailFile'], result['mailFilePath']
                subject = ', '.join(subject.split(".")[0].split("-")[0:5]) # <- js :: subject.split(".")[0].split("-").splice(0,5).join(", ")
                AptJobDao.updateScoreJobMailDetail(3,subject,fileAttachment)
                scoreJob['status'] = 3

            elif scoreJob['status'] == 3: 
                #Send Mail
                print("Send Mail...")
                from .MailUtil import MailUtil 
                result = MailUtil.sendScoreMail(subject,fileAttachment) 
                AptJobDao.updateScoreJob(4)
                AptJobDao.updateJob(2)
                print("'Make Scores' to 'Send Mail' has done!!!")
            isJob = True 
        return isJob 
        
