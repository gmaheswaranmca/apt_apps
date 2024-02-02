def CreateStudent(sno, studentName, userName, password, batch):
        from Model.StudentListProcessModel import Student
        return Student(sno, studentName, userName, password, batch)

class MainStudentListController:
    @staticmethod
    def ActionStudentListProcess():
        from Model.StudentListProcessModel import StudentListProcessModel
        processModel = StudentListProcessModel(CreateStudent)
        from DAL.StudentListDAL import StudentListDAL
        from UI.StudentListView import StudentListView
        # model
        #processModel = Controller.processModel
        # view
        StudentListView.ReadPath(processModel)
        # process
        #StudentListDAL.PrintHello('Maheswaran')

        while True:
            print("Choices:")        
            print("\t1-Print Students")        
            print("\t2-Test File")        
            print("\t3-Password File To Send Mail")
            print("\t4-Score File")
            print("\t5-Generate Password")
            print("\t0-Exit")
            choice = int(input('Your Choice:'))
        
            if choice in [1,2,3,4]:
                processModel.ClearData()
                StudentListDAL.ReadStudentsExcelBook(processModel)

            if choice == 1:
                StudentListDAL._PrintStudentsList(processModel)
                continue

            if choice == 2:
                StudentListDAL.DownloadTestFile(processModel)
                continue

            if choice == 3:
                StudentListDAL.DownloadPasswordFileYetToMail(processModel)
                continue

            if choice == 4:
                StudentListDAL.DownloadScoreFile(processModel)
                continue

            if choice == 5:
                if input('Are you sure to update the password?') == 'n':
                    continue
                StudentListDAL.ReadStudentsAndUpdatePassword(processModel)
                continue

            break