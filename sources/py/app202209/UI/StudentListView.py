class StudentListView:
    @staticmethod
    def ReadPath(processModel):
        processModel.StudentListFilePath = input('Enter student list file path:')
        processModel.StudentListFileAndPath = f'{processModel.StudentListFilePath}/Students.xlsx'
        
