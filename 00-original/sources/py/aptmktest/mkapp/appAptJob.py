from aptdb.aptjobdao import AptJobDao
from aptdb.aptjobcontroller import AptJobController
import time

if __name__ == '__main__':
    print("App Started")
    whileCond = True 
    while whileCond:
        #print("Before")
        time.sleep(1)
        #opStatus = AptJobDao.addScoreJob("Test1,Test4")
        #print("Status: ", opStatus)
        '''
        dbData = AptJobDao.readJob()
        print("\nPrint All")
        print(dbData)

        print("\nPrint Table By Table")
        for dbDataTable in dbData:
            print(dbDataTable)

        print("\nPrint Row By Row in all Tables")
        I = 0
        for dbDataTable in dbData:
            I += 1
            print("Table", I)
            for dbRow in dbDataTable:
                print(dbRow)
        '''
        statusActionScoreJob = AptJobController.actionScoreJob()
        #print("actionScoreJob:", statusActionScoreJob)
        if input("Are you continue?") != "y":
            break

    print("App Ended")