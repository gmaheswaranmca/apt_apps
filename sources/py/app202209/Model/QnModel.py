class Job:
    def __init__(self, sno, jobDate, jobDay, testName, jobSpec, jobCode, jobType):
        self.Sno = sno
        self.JobDate = jobDate
        self.JobDay = jobDay
        self.TestName = testName
        self.JobSpec = jobSpec
        self.JobCode = jobCode
        self.JobType = jobType
        self.JobTypes = [str(e).strip() for e in jobType.split(',')]
    def __str__(self):
        #return f'''[{self.Sno}, {self.JobDate}, {self.JobDay}, {self.TestName}, {self.JobSpec}, {self.JobCode}, {self.JobType}]'''
        return f'''[{self.Sno}, {self.JobDateDisplay()}, {self.JobDateDay()}, {self.TestName}, Spec, Code, {self.JobType}]'''
    def __repr__(self):
        return f'''{self.__str__()}'''
    def JobDateDisplay(self):
        from datetime import datetime
        return self.JobDate.strftime('%d-%b-%Y')
    def JobDateDay(self):
        return self.JobDate.strftime('%a')    
    def JobSpecTiming(self):
        import pytz, datetime
        import re
        spec = self.JobSpec.lower()
        timesInStr = re.findall('(1[012]|[1-9])([:][0-5][0-9])?(\\s)?(?i)(am|pm)', spec)
        timesInStr = ' to '.join([''.join(e) for e in timesInStr])
        return (timesInStr)

    def JobCodeTestNo(self):
        import pytz, datetime
        import re
        text = self.JobCode #'gfgfdAAA1234ZZZuijjk'
        m = re.search('#(.+?)(,)', text)
        found = ''
        if m:
            found = m.group(1)
        return (found)
        
    def IsBetween(self,fromDate,toDate):
        return fromDate <= self.JobDate and self.JobDate <= toDate
    def DisplayJob(self):
        return f'''
*********Test:*********
{self.TestName}
*********Desc:*********
{self.JobSpec}
*********Code:*********
{self.JobCode}
^^^^^^^^^^^^^^^^^^^^^^^
'''
class JobModel:
    def __init__(self, FnCreateJob):
        self.CreateJob = FnCreateJob
        self.JobFilePath = r'F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\scoresfiles\app_master'
        self.JobFileNameAndPath = f'{self.JobFilePath}/job-log.xlsx'
        self.JobCosts = {'SP':['Test',125],
            'SP-C':['Test-Coding',150],
            'MP':['Multipart Test',250],
            'MP-C':['Multipart Test-1 Coding',275],
            'NID':['New IDs',125],
            'AID':['Add IDs',125]
        }
        self.ClearData()
    def ClearData(self):
        self.Jobs = []
        self.TestNameJobs = {}