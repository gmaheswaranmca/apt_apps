
class JobDAL:
    @staticmethod
    def ReadJobExcelBook(jobModel):
        import pyexcel as pyxl
        #
        xlBook = pyxl.get_book(file_name=jobModel.JobFileNameAndPath)
        
        for sheet in xlBook:
            if sheet == xlBook['JobType'] or sheet == xlBook['Dates']:
                continue
            JobDAL._ReadJobExcelSheet(jobModel, sheet)
        
    @staticmethod 
    def _ReadJobExcelSheet(jobModel, sheet):
        rowNumber = 1
        for row in sheet: 
            if rowNumber != 1:           
                JobDAL._ReadJobRow(jobModel, row)
            rowNumber += 1
        
    @staticmethod 
    def _ReadJobRow(jobModel, row):
        sno, jobDate, jobDay, testName, jobSpec, jobCode, jobType = row[0], row[1], row[2], row[3], row[4], row[5], row[6]
        job = jobModel.CreateJob(sno, jobDate, jobDay, testName, jobSpec, jobCode, jobType)
        jobModel.Jobs.append(job)
        test = jobModel.TestNameJobs.get(job.TestName, [])
        test.append(job)
        jobModel.TestNameJobs[job.TestName] = test

    @staticmethod
    def _DoJobListByRange(jobModel,fromDate,toDate,FnPrint): 
        jobs = []
        for job in jobModel.Jobs:
            if(not job.IsBetween(fromDate,toDate)):
                continue
            jobs.append(job)
        
        jobs = JobDAL._SortJobsByJobDate(jobs)
        FnPrint(jobModel, jobs)     
        if input('Are you sure to download(y/n)?')!='y':
            return 
        JobDAL._DownloadJobsDesc(jobModel,jobs,fromDate,toDate)

    @staticmethod
    def _DoJobListByDate(jobModel,fromDate,FnPrint): 
        jobs = []
        for job in jobModel.Jobs:
            if(job.JobDate != fromDate):
                continue
            jobs.append(job)
        jobs = JobDAL._SortJobsByJobDate(jobs)
        FnPrint(jobModel, jobs)

    @staticmethod
    def _PrintJobsTabular(jobModel,jobs):
        jobSum = 0

        print("%10s%10s%10s%10s"%('Date','Test','Job','Cost'))
        for job in jobs:
            for jobType in job.JobTypes:
                print("%10s%10s%10s%10s%20s%20s"%(
                    job.JobDateDisplay(),
                    job.TestName,
                    jobModel.JobCosts[jobType][0],
                    jobModel.JobCosts[jobType][1],
                    job.JobSpecTiming(),
                    job.JobCodeTestNo()
                    ))
                jobSum += jobModel.JobCosts[jobType][1]
        print("%10s%10s%10s%10s"%(
            '',
            '',
            '',
            jobSum
            ))     
           
    @staticmethod
    def _DownloadJobsDesc(jobModel, jobs, fromDate, toDate):
        import pyexcel as pyxl
        import os
        from .FileAndExcelUtil import FileAndExcelUtil
        fileName = f"Jobs_{fromDate.strftime('%a-%d-%b-%Y')}_{toDate.strftime('%a-%d-%b-%Y')}"
        fileNamePath = f'{jobModel.JobFilePath}/weekJob/{fileName}.xlsx'
        #print(fileNamePath)
        
        result = {'Weekly Job':[]}
        result['Weekly Job'].append(['Sno',	'Date' ,
        	'Day', 'Link',	
            'Src Text',	'Py Text',	'Job Type'])
        I=1
        for job in jobs:
            result['Weekly Job'].append([I, job.JobDateDisplay(), 
                job.JobDateDay(), job.TestName, 
                job.JobSpec, job.JobCode, job.JobType])
            I += 1
        pyxl.save_book_as(bookdict=result,  dest_file_name = fileNamePath)
        FileAndExcelUtil._MakeFormat(f'{jobModel.JobFilePath}/weekJob', 
            f'{fileName}', 
            f"format/Format", 
            f'{fileName}_Formatted')        

        FileAndExcelUtil.RemoveFile(fileNamePath)
        print(f'Downloaded the Weekly Jobs File\n\tie{jobModel.JobFilePath}/weekJob/{fileName}_Formatted.xlsx')

    @staticmethod
    def _PrintJobsDesc(jobModel,jobs):
        I=1
        prevDate = ''
        for job in jobs:
            if prevDate != job.JobDateDisplay():
                print(f'..................Date:{job.JobDateDay()},{job.JobDateDisplay()}.................')
            print(job.DisplayJob())
            prevDate = job.JobDateDisplay()
            if I == 1:
                job.JobSpecTiming()
                job.JobCodeTestNo()
            I+=1

    @staticmethod
    def _SortJobsByJobDate(jobs):
        sortedJobs = sorted(list(jobs),key=lambda e :e.JobDate)
        return sortedJobs

    @staticmethod
    def StringToDate(str): 
        from datetime import datetime
        return datetime.strptime(str, "%d-%b-%Y").date()