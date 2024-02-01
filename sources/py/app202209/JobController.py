def CreateJob(sno, jobDate, jobDay, testName, jobSpec, jobCode, jobType):
        from Model.JobModel import Job
        return Job(sno, jobDate, jobDay, testName, jobSpec, jobCode, jobType)

class MainJobontroller:
    @staticmethod
    def ActionJobProcess():
        from Model.JobModel import JobModel
        from DAL.JobDAL import JobDAL
        from datetime import datetime, date, timedelta
        jobModel = JobModel(CreateJob)
        
        # model
        # view
        # process

        while True:
            print("Choices:")        
            print("\t10-Jobs By Date Range")        
            print("\t20-Jobs By Date")        
            print("\t21-Jobs By Today")
            print("\t22-Jobs By Yesterday")
            print("\t23-Jobs By Tomorrow")
            print("\t30-Jobs By This Week")
            print("\t0-Exit")
            choice = int(input('Your Choice:'))
        
            if choice == 10:
                fromDateCaption = 'From Date'
            elif choice == 20:
                fromDateCaption = 'Date'

            if choice in [10,20]:
                fromDate = JobDAL.StringToDate(input(f"{fromDateCaption}(dd-MMM-yyyy):"))
            elif choice in [21,22,23,30]:
                fromDate = date.today()
                
            
            if choice == 22:
                fromDate = fromDate - timedelta(days=1)
            elif choice == 23:
                fromDate = fromDate + timedelta(days=1)
            elif choice == 30:
                fromDate = fromDate - timedelta(days=fromDate.weekday())

            if choice in [10]:
                toDate = JobDAL.StringToDate(input("To Date(dd-MMM-yyyy):"))
            elif choice in [30]:
                toDate = fromDate + timedelta(days=6)
            
            if choice in [10,20,21,22,23,30]:
                jobModel.ClearData()
                JobDAL.ReadJobExcelBook(jobModel)

            if choice in [10,30]:
                Fn = MainJobontroller.GetFnToPrint()
                JobDAL._DoJobListByRange(jobModel,fromDate,toDate,Fn)
                continue
            if choice in [20,21,22,23]:
                #fromDate = JobDAL.StringToDate(input("Date(dd-MMM-yyyy):"))
                Fn = MainJobontroller.GetFnToPrint()
                print(type(fromDate))
                JobDAL._DoJobListByDate(jobModel,fromDate,Fn)
                continue        

            break
    @staticmethod
    def GetFnToPrint():
        from DAL.JobDAL import JobDAL
        print("Choices:")        
        print("\t1-Print Tabular Jobs Cost")        
        print("\t2-Print Jobs Desc")        
        choice = int(input('Your Choice:'))

        if choice == 1:
            return JobDAL._PrintJobsTabular
        if choice == 2:
            return JobDAL._PrintJobsDesc
