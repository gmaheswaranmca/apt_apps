class Student:
    def __init__(self, sno, studentName, userName, password, batch):
        self.Sno = sno
        self.StudentName = studentName
        self.UserName = userName
        self.Password = password
        self.Batch = batch
    def __str__(self):
        return f'''[{self.Sno}, {self.StudentName}, {self.StudentName}, {self.Password}, {self.Batch}]'''
    def __repr__(self):
        return f'''{self.__str__()}'''

class StudentListProcessModel:
    def __init__(self, FnCreateStudent):
        self.CreateStudent = FnCreateStudent
        self.StudentListFilePath = ''
        self.StudentListFileAndPath = ''
        self.ClearData()
    def ClearData(self):
        self.Students = []
        self.BatchStudents = {}