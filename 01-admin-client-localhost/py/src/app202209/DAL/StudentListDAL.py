
class StudentListDAL:
    @staticmethod
    def PrintHello(fullName):
        print(f'Hello {fullName}')

    @staticmethod
    def ReadStudentsExcelBook(processModel):
        '''
            Reads the Excel Book into 
                'processModel.Students' and 
                'processModel.BatchStudents'
            Here, path is set at 'processModel.StudentListFileAndPath'
        '''
        import pyexcel as pyxl
        #print(f'{processModel.StudentListFileAndPath}')
        
        #
        xlBook = pyxl.get_book(file_name=processModel.StudentListFileAndPath)
        sheets = []
        #print(type(xlBook))
        for sheet in xlBook:
            StudentListDAL._ReadStudentsExcelSheet(processModel, sheet)
        #StudentListDAL._PrintStudentsList(processModel)

    @staticmethod 
    def _ReadStudentsExcelSheet(processModel, sheet):
        #print(sheet.name)
        #
        rowNumber = 1
        for row in sheet: 
            if rowNumber != 1:           
                StudentListDAL._ReadStudentRow(processModel, row)
            rowNumber += 1
        
    @staticmethod 
    def _ReadStudentRow(processModel, row):
        sno, studentName, userName, password, batch = row[0], row[1], row[3], row[4], row[2]
        student = processModel.CreateStudent(sno, studentName, userName, password, batch)
        processModel.Students.append(student)
        batch = processModel.BatchStudents.get(student.Batch, [])
        batch.append(student)
        processModel.BatchStudents[student.Batch] = batch

    @staticmethod
    def _GeneratePassword(length):
        '''
        Util function 
        Argument 'length': length of password 
            For Example, length=4 means 'four char password' id XUPW is 4 alphabet password
        Returns: password of 'length'  
        '''
        import random
        letters = list('ABCDEFGHIJKLMNPQRSTUVWXYZ')
        result_str = ''.join(random.choice(letters) for i in range(length))
        return result_str
    
    @staticmethod 
    def UpdatePassword(processModel):
        for student in processModel.Students:
            student.Password = StudentListDAL.GeneratePassword(4)

    @staticmethod
    def _PrintStudentsList(processModel): 
        #print(batch)
        print('---------------------')
        for batchName in processModel.BatchStudents:
            print()
            for student in processModel.BatchStudents[batchName]:
                print(student)
        

    @staticmethod
    def ReadStudentsAndUpdatePassword(processModel):  
        '''
        This function reads the students file
        and updates the password
        '''      
        from openpyxl import load_workbook
        
        #load excel file
        workbook = load_workbook(filename=processModel.StudentListFileAndPath)
        
        #open workbook
        sheet = workbook.active
        rowNumber = 1
        for row in sheet:
            if rowNumber != 1:
                sheet[f"E{rowNumber}"] = StudentListDAL._GeneratePassword(4)
            rowNumber += 1
        
        #save the file
        workbook.save(filename=processModel.StudentListFileAndPath)

    @staticmethod
    def DownloadTestFile(processModel):  
        '''
            File Name: 2Student.csv
        '''
        fileNamePath = f'{processModel.StudentListFilePath}/2Student.csv'
        dataCSV = []
        dataCSV.append(["Sno",	"STUDENT NAME",	"Login Id",	"Password"])
        for student in processModel.Students:
            dataCSV.append([student.Sno, student.StudentName, student.UserName, student.Password])
        
        import csv
        # opening the csv file in 'w+' mode
        file = open(f'{processModel.StudentListFilePath}/2Student.csv', 'w+', newline ='')
        
        # writing the data into the file
        with file:   
            write = csv.writer(file)
            write.writerows(dataCSV)

        print(f'Downloaded the Test File\n\tie{fileNamePath}')

    
    @staticmethod
    def DownloadPasswordFileYetToMail(processModel, hasToRemoveChoice=True):  
        import pyexcel as pyxl
        import os
        from .FileAndExcelUtil import FileAndExcelUtil
        fileNamePath = f'{processModel.StudentListFilePath}/PasswordFile-01.xlsx'
        
        result = {}
        for batchName in processModel.BatchStudents:
            dataCSV = []
            dataCSV.append(["Sno",	
                "STUDENT NAME",	
                "Login Id",	
                "Password"])
            I = 1
            for student in processModel.BatchStudents[batchName]:
                dataCSV.append([I,
                    student.StudentName,
                    student.UserName,
                    student.Password])
                I += 1
            result[batchName] = dataCSV
        pyxl.save_book_as(bookdict=result,  dest_file_name = fileNamePath)

        FileAndExcelUtil._MakeFormat(processModel.StudentListFilePath, 
            'PasswordFile-01', 
            f"../PasswordFormat", 
            'PasswordYetToMail')
        FileAndExcelUtil.RemoveFile(fileNamePath, hasToRemoveChoice)
        print(f'Downloaded the Password File\n\tie{processModel.StudentListFilePath}/PasswordYetToMail.xlsx')
        
        

    @staticmethod
    def DownloadScoreFile(processModel, hasToRemoveChoice=True):  
        import pyexcel as pyxl
        import os
        from .FileAndExcelUtil import FileAndExcelUtil
        fileNamePath = f'{processModel.StudentListFilePath}/ScoreFile-01.xlsx'
        
        result = {}
        for batchName in processModel.BatchStudents:
            dataCSV = []
            dataCSV.append(["S. No.","Login ID",	
                "Name of Student",	
                "Dept",	
                "Score (Out of 20)",	
                "Attendance",	
                "Remarks"])
            I = 1
            for student in processModel.BatchStudents[batchName]:
                dataCSV.append([I,
                    student.UserName,student.StudentName,	
                    "",
                    "4",
                    "PRESENT",
                    "Answered most of the questions without reading them"])
                I += 1
            result[batchName] = dataCSV
        pyxl.save_book_as(bookdict=result,  dest_file_name = fileNamePath)

        FileAndExcelUtil._MakeFormat(processModel.StudentListFilePath, 
            'ScoreFile-01', 
            f"../ScoreFormat", 
            'ScoreFile')
        FileAndExcelUtil.RemoveFile(fileNamePath, hasToRemoveChoice)
        print(f'Downloaded the Score File\n\tie{processModel.StudentListFilePath}/ScoreFile.xlsx')
        

