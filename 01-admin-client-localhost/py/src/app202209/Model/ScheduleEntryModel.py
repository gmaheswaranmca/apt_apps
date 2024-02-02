class ScheduleEntry:
    def __init__(self, testName, sno, jobDate, jobDay, jobSpec):
        self.Sno = sno
        self.JobDate = jobDate
        self.JobDay = jobDay
        self.TestName = testName
        self.JobSpec = jobSpec
        #print(self.__str__()) #DEBUG
        self.SetJobDate()
        
    def __str__(self):
        return f'''[{self.Sno}, {self.JobDate}, {self.JobDay}, {self.TestName}, {self.JobSpec}]'''

    def __repr__(self):
        return f'''{self.__str__()}'''

    def SetJobDate(self):
        import re
        from datetime import datetime 
        parts = [int(e) for e in re.findall(r'\d+', self.JobDate)]
        self.JobDateValue = datetime(2000+parts[2],parts[1],parts[0])

    def JobDayDetailed(self):
        parts = self.JobDay.split("to")
        parts = [e.strip().split(' ') for e in parts]
        parts = parts[0] + parts[1]
        return parts

    def JobDaysDisplay(self):
        from datetime import datetime, date, timedelta
        dayNames=["monday","tuesday","wednesday","thursday","friday","saturday","sunday"]
        parts = self.JobDayDetailed()
        fromWeekDay = parts[0]
        toWeekDay = fromWeekDay
        fromTime = parts[1] + parts[2]
        #print(parts) #DEBUG
        if parts[3].lower() in dayNames:
            toWeekDay = parts[3]
            toTime = parts[4] + parts[5]
        else:
            toTime = parts[3] + parts[4]
        
        fromWeekDayIndex = dayNames.index(fromWeekDay.lower())
        toWeekDayIndex = dayNames.index(toWeekDay.lower())

        if self.JobDateValue.weekday() != fromWeekDayIndex:
            return f'''Date ***{self.JobDateValue.strftime('%a-%d-%b-%Y')}*** and its 
day ***{fromWeekDay} {fromTime} - {toWeekDay} {toTime}*** are not matching'''
        else:
            toWeekDate = self.JobDateValue - timedelta(days=self.JobDateValue.weekday()) + timedelta(days=toWeekDayIndex)
            return f'''{self.JobDateValue.strftime('%a,%d-%b-%Y')} {fromTime} to {toWeekDate.strftime('%a,%d-%b-%Y')} {toTime}'''
        
    def JobDateDisplay(self):
        from datetime import datetime
        return self.JobDateValue.strftime('%d-%b-%Y')

    def JobDateDay(self):
        from datetime import datetime
        return self.JobDateValue.strftime('%a')    

    def JobSpecDisplay(self):
        return f'''{self.JobSpec}
({self.Sno}){self.JobDate} | {self.JobDay}'''

class ScheduleEntryModel:
    def __init__(self, FnCreateSchedule):
        self.CreateSchedule = FnCreateSchedule
        self.JobFilePath = r'F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\scoresfiles\app_master\schedule'
        self.JobFileNameAndPath = f'{self.JobFilePath}/all-tests.xlsx'
        self.ClearData()
    def ClearData(self):
        self.Schedules = []
        self.TestNameSchedules = {}