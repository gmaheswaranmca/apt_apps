def CreateSchedule(testName, sno, jobDate, jobDay, jobSpec):
        from Model.ScheduleEntryModel import ScheduleEntry
        return ScheduleEntry(testName, sno, jobDate, jobDay, jobSpec)

class ScheduleEntryController:
    @staticmethod
    def ActionScheduleProcess():
        from Model.ScheduleEntryModel import ScheduleEntryModel
        from DAL.ScheduleEntryDAL import ScheduleEntryDAL
        scheduleEntryModel = ScheduleEntryModel(CreateSchedule)
        
        # model
        # view
        # process
        scheduleEntryModel.ClearData()
        ScheduleEntryDAL.ReadScheduleExcelBook(scheduleEntryModel)
        '''
        while True:
            print("Choices:")        
            print("\t10-Print Jobs")  
            print("\t0-Exit")
            choice = int(input('Your Choice:'))
            
            if choice == 10:
                scheduleEntryModel.ClearData()
                ScheduleEntryDAL.ReadScheduleExcelBook(scheduleEntryModel)
        '''