
class ScheduleEntryDAL:
    @staticmethod
    def ReadScheduleExcelBook(scheduleEntryModel):
        import pyexcel as pyxl
        #
        xlBook = pyxl.get_book(file_name=scheduleEntryModel.JobFileNameAndPath)
        
        for sheet in xlBook:
            ScheduleEntryDAL._ReadScheduleExcelSheet(scheduleEntryModel, sheet)
        ScheduleEntryDAL._DoScheduleListByRange(scheduleEntryModel, ScheduleEntryDAL._PrintSchedulesTabular)
    @staticmethod 
    def _ReadScheduleExcelSheet(scheduleEntryModel, sheet):
        rowNumber = 1
        for row in sheet: 
            if rowNumber != 1:           
                ScheduleEntryDAL._ReadScheduleRow(
                    scheduleEntryModel, 
                    row)
            rowNumber += 1
    @staticmethod 
    def _ReadScheduleRow(scheduleEntryModel, row):
        sno, jobDate, jobDay, jobSpec, testName = row[1], row[2], row[3], row[4], row[0]
        scheduleEntry = scheduleEntryModel.CreateSchedule(testName, sno, jobDate, jobDay, jobSpec)
        scheduleEntryModel.Schedules.append(scheduleEntry)
        test = scheduleEntryModel.TestNameSchedules.get(scheduleEntry.TestName, [])
        test.append(scheduleEntry)
        scheduleEntryModel.TestNameSchedules[scheduleEntry.TestName] = test

    @staticmethod
    def _DoScheduleListByRange(scheduleEntryModel,FnPrint): 
        schedules = []
        for schedule in scheduleEntryModel.Schedules:            
            schedules.append(schedule)

        FnPrint(scheduleEntryModel, schedules)     
        

    @staticmethod
    def _PrintSchedulesTabular(scheduleEntryModel,schedules):
        import pyexcel as pyxl
        import os
        from .FileAndExcelUtil import FileAndExcelUtil
        fileName = f"Jobs"
        fileNamePath = f'{scheduleEntryModel.JobFilePath}/{fileName}.xlsx'
        result = {'Jobs':[]}
        result['Jobs'].append(['Sno',	'Date' ,
        	'Day', 'Link',	
            'Src Text',	'Py Text',	'Job Type'])
        
        I=1
        for schedule in schedules:
            """
            print(f'''{I})TestName:{schedule.TestName}
Sno:{schedule.Sno}
JobDate:
    {schedule.JobDate} 
    {schedule.JobDateDisplay()} 
    {schedule.JobDateDay()}
JobDay:{schedule.JobDay}
{schedule.JobDayDetailed()}
{schedule.JobDaysDisplay()}
JobSpec:{schedule.JobSpec}
Job:{schedule.JobSpecDisplay()}
''')    """
            #print('\n',schedule) #DEBUG
            result['Jobs'].append(['',	
                schedule.JobDateValue,
        	    schedule.JobDateDay(), 
                f'{schedule.TestName[0:1].upper()}{schedule.TestName[1:].lower()}',	
                f'''{schedule.JobSpec}
({schedule.Sno}) {schedule.JobDaysDisplay()}''',	
                '',	
                'SP'])
            I += 1
        #print(result)
        pyxl.save_book_as(bookdict=result,  dest_file_name = fileNamePath)
        FileAndExcelUtil._MakeFormat(f'{scheduleEntryModel.JobFilePath}', 
            f'{fileName}', 
            f"../weekJob/format/Format", 
            f'{fileName}_Formatted')        

        FileAndExcelUtil.RemoveFile(fileNamePath)
        print(f'Downloaded the Jobs File from Schedule(Source) Files\n\tie{scheduleEntryModel.JobFilePath}/weekJob/{fileName}_Formatted.xlsx')

                