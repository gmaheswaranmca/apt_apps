


class Controller:
    @staticmethod
    def ActionMain():
        while True:
            print("Choices:")        
            print("\t1-Student List Processing (Password, Test File, Score File etc)")        
            print("\t2-Job Processing")        
            print("\t3-Schedule Entry Processing")        
            print("\t0-Exit")
            choice = int(input('Your Choice:'))
        
            if choice == 1:
                from MainStudentListController import MainStudentListController
                MainStudentListController.ActionStudentListProcess()
                continue

            if choice == 2:
                from JobController import MainJobontroller
                MainJobontroller.ActionJobProcess()
                continue  

            if choice == 3:
                from ScheduleEntryController import ScheduleEntryController
                ScheduleEntryController.ActionScheduleProcess()
                continue        
            break               


#-------------Main Driver Code-------------
Controller.ActionMain()
