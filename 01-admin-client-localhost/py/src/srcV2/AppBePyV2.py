#import docx
#import pandas as pd
import os
#import io
import os.path

#import random
#import string

#import mysql.connector

from Captions import Captions
from StudMkPwd import StudMkPwd  
from StudSavePwd import StudSavePwd
from QnMake import QnMake
from PickToDb import PickToDb        
from PickCodeQnToDb import PickCodeQnToDb        
from ReadPref import ReadPref     
from QnCodeMake import CodeQnMake

#Menu Handling        
class MenuHandler:
    @classmethod
    def mainMenu(cls): 
        menuStr = Captions.MenuHandler_mainMenu_menuStr#!
        choice = int(input(menuStr))        
        if choice == 1:
            StudMkPwd.do()
        elif choice == 2:
            StudSavePwd.do()
        elif choice == 3:
            QnMake.InvQnMake()
        elif choice == 4:
            PickToDb.Do()
        elif choice == 5:
            PickToDb.DoByPickListString()
        elif choice == 6:
            ReadPref.getFilesList()
        else:
            print(Captions.MenuHandler_mainMenu_thanks)#!
        return choice
    @classmethod
    def processByPref(cls): 
        jobDetail = ReadPref.getFilesList()
        prefFilefolderPath = os.path.join(ReadPref.PrefFolderPath, jobDetail['latestJob'])
        pref = jobDetail['pref']
        if pref['genpwd_is']:
          srcFilePath = os.path.join(prefFilefolderPath, '1UserID.csv')
          outFilePath = os.path.join(prefFilefolderPath, '2Password.csv')            
          StudMkPwd.docaller(srcFilePath, outFilePath)
        elif pref['savepwd_is']:
          IsQuiz = pref['cleanquiz']
          IsAssignment= pref['cleanassignment']
          IsUser= pref['cleanuser']
          havetosavepwd= pref['havetosavepwd']
          if(IsQuiz or IsAssignment or IsUser):
            databaseName = pref['toDatabase']
            print()
            print(databaseName, IsQuiz,IsAssignment,IsUser)
            sayYesOrNo = Captions.MenuHandler_sayYesOrNo#!
            choice = input(sayYesOrNo) == 'y'
            if(choice):
                StudSavePwd.databaseName = databaseName
                StudSavePwd.cleanDb(IsQuiz,IsAssignment,IsUser)
          if(havetosavepwd):
            databaseName = pref['toDatabase']
            srcFilePathManager = os.path.join(prefFilefolderPath, '1ManagerUsableUser.csv')
            srcFilePathStudent = os.path.join(prefFilefolderPath, '2Student.csv')
            print()
            print(databaseName, srcFilePathManager, srcFilePathStudent)
            sayYesOrNo = Captions.MenuHandler_sayYesOrNo#!
            choice = input(sayYesOrNo) == 'y'
            if(choice):                    
                StudSavePwd.opt02caller(databaseName, srcFilePathManager, srcFilePathStudent)                
        elif pref['uploadqn_is']:
          toDatabase = pref['toDatabase']
          quizName = pref['quizName']
          qnCount = pref['qnCount']
          timeLimit = pref['timeLimit']
          
          QnFile = os.path.join(prefFilefolderPath, '2Question.docx')
          OptFile = os.path.join(prefFilefolderPath, '3Option.docx')
          QnJsonFileV1 = os.path.join(prefFilefolderPath, '4QuestionPlDataV1.json')
          QnJsonFileV2 = os.path.join(prefFilefolderPath, '5QuestionPlDataV2.json')
          print()
          print(QnFile)
          print(OptFile)
          print(QnJsonFileV1)
          print(QnJsonFileV2)
          print(quizName, qnCount, timeLimit, toDatabase)
          sayYesOrNo = Captions.MenuHandler_sayYesOrNo#!
          choice = input(sayYesOrNo) == 'y'
          if(choice):
              QnMake.QnMakeCaller(QnFile, OptFile, QnJsonFileV1, QnJsonFileV2, quizName, qnCount, timeLimit, toDatabase)
        elif pref['uploadcodeqn_is']:
          toDatabase = pref['toDatabase']
          QnFile = os.path.join(prefFilefolderPath, '1Question.xlsx')
          print()
          print(QnFile)
          print(toDatabase)
          sayYesOrNo = Captions.MenuHandler_sayYesOrNo#!
          choice = input(sayYesOrNo) == 'y'
          if(choice):
              CodeQnMake.CodeQnMakeCaller(QnFile, toDatabase)             
        elif pref['pickqn_is']:          
          hasBrandInInstruction = pref['hasBrandInInstruction']
          fromDatabase = pref['fromDatabase']
          toDatabase = pref['toDatabase']
          testPaper = pref['testPaper']
          
          print()
          print(hasBrandInInstruction, fromDatabase, toDatabase, testPaper)
          sayYesOrNo = Captions.MenuHandler_sayYesOrNo#!
          choice = input(sayYesOrNo) == 'y'
          if(choice and len(testPaper)>0):
              PickToDb.DoByPref(hasBrandInInstruction, fromDatabase, toDatabase, testPaper)          
        elif pref['mktest_is']:
          fromDatabase = pref['fromDatabase']
          toDatabase = pref['toDatabase']
          hasBrandInInstruction = pref['hasBrandInInstruction']          
          testPaper = pref['testPaper']
          codeQn = pref['codeQn']
          srcFilePathManager = os.path.join(prefFilefolderPath, '1ManagerUsableUser.csv')
          srcFilePathStudent = os.path.join(prefFilefolderPath, '2Student.csv')
          print(srcFilePathManager)
          print(srcFilePathStudent)
          print()
          print(hasBrandInInstruction, fromDatabase, toDatabase)
          print()
          for papr in testPaper:
              print('---------------------------')
              print('Copy From:')
              print('---------------------------')
              for fromPapr in papr['pick_list']:
                  print(fromPapr)
              print('---------------------------')    
              print('Copy as:')
              print('---------------------------')
              print({'test_name':papr['test_name'],'qn_count':papr['qn_count'],
                     'time_limit':papr['time_limit']})
              print('---------------------------')
              print()
          print()
          print('Coding Qns')
          for acodeQn in codeQn:
              print('---------------------------')
              print('Copy From:')
              print('---------------------------')
              for fromPapr in acodeQn['pick_list']:
                  print(fromPapr)
              print('---------------------------')    
              print('Copy as:')
              print('---------------------------')
              print({'test_name':acodeQn['test_name'],'qn_count':acodeQn['qn_count'],
                     'time_limit':acodeQn['time_limit'],'max_runs':acodeQn['max_runs']})
              print('---------------------------')
              print()
          print()          
          
          sayYesOrNo = Captions.MenuHandler_sayYesOrNo#!
          choice = input(sayYesOrNo) == 'y'
          if(choice  and (len(testPaper)>0 or len(codeQn)>0)):
            StudSavePwd.databaseName = toDatabase
            IsQuiz = True
            IsAssignment= True
            IsUser= True
            StudSavePwd.cleanDb(IsQuiz,IsAssignment,IsUser)

          choice = True #choice = input(sayYesOrNo) == 'y'
          if(choice  and (len(testPaper)>0 or len(codeQn)>0)):
            # ######################################                    
            #Create the User Data Base   
            havetosavepwd= True            
            StudSavePwd.opt02caller(toDatabase, srcFilePathManager, srcFilePathStudent) 

          if(choice  and len(testPaper)>0):
            # ######################################
            PickToDb.DoByPref(hasBrandInInstruction, fromDatabase, toDatabase, testPaper)    
          
          choice = True #choice = input(sayYesOrNo) == 'y'

          if (choice and len(codeQn)>0):
            PickCodeQnToDb.DoByPref(hasBrandInInstruction, fromDatabase, toDatabase, codeQn)

          choice = True #choice = input(sayYesOrNo) == 'y'
          if(choice  and (len(testPaper)>0 or len(codeQn)>0)):
            # ######################################            
            #Add MCQ Test the users
            StudSavePwd.opt02maketest(toDatabase, srcFilePathManager, srcFilePathStudent, testPaper, codeQn) 
  
#App Main    
#choice = 1   
#while choice != 0 and choice != 100:
#    choice = MenuHandler.mainMenu()    
MenuHandler.processByPref()
