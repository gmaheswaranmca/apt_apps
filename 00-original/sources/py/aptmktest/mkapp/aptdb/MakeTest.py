
class MakeTest:
    @staticmethod
    def parseTestPaper(testPaperStr):        
        TestData = []
        
        for I in range(len(testPaperStr)):
            aTestPaperStr = testPaperStr[I]            
                      
            partsSourceData = aTestPaperStr.split('!')            
            ASource = partsSourceData[0].split('|')
            SourceData = []
            for e in ASource:
                DestData = e.split(',')
                SourceData.append({'tp':DestData[0],'from':int(DestData[1]),'to':int(DestData[2]),'qns':[]})

            DestData = partsSourceData[1].split(',')
            TestData.append({'pick_list': SourceData, 'test_name': DestData[0], 'qn_count': int(DestData[1]), 'time_limit': int(DestData[2])})
                                
                
        return TestData
    @staticmethod
    def parseCodeQn(codeQnStr):        
        TestData = []
        
        for I in range(len(codeQnStr)):
            aCodeQnStr = codeQnStr[I]            
                      
            partsSourceData = aCodeQnStr.split('!')            
            ASource = partsSourceData[0].split('|')
            SourceData = []
            for e in ASource:
                DestData = e.split(',')
                SourceData.append({'qn':DestData[0], 'numOfTestCases':int(DestData[1]),'scorePerTestCase':int(DestData[2]),'testCases':[]})

            DestData = partsSourceData[1].split(',')
            TestData.append({'pick_list': SourceData, 'test_name': DestData[0], 'qn_count': int(DestData[1]), 'time_limit': int(DestData[2]), 'max_runs': int(DestData[3])})
                                
                
        return TestData
    @staticmethod
    def parsePref(prefStr):
        for I in range(len(prefStr)):
            prefAStr = prefStr[I]
            prefStr[I] = str(prefAStr).replace('\n','')

        pref = {'genpwd_is':False, 'savepwd_is':False, 
            'uploadqn_is':False,
            'uploadcodeqn_is':False,
            'pickqn_is':False,'mktest_is':False}

        pref['testPaperStr'] = []
        pref['codeQnStr'] = []
        for I in range(len(prefStr)):
            prefAStr = prefStr[I]
            partsPrefAStr = prefAStr.split('=')
            if partsPrefAStr[0] == 'cmd':
                if partsPrefAStr[1] == 'genpwd':
                    pref['genpwd_is'] = True
                elif partsPrefAStr[1] == 'savepwd':
                    pref['savepwd_is'] = True 
                elif partsPrefAStr[1] == 'uploadqn':
                    pref['uploadqn_is'] = True 
                elif partsPrefAStr[1] == 'pickqn':
                    pref['pickqn_is'] = True 
                elif partsPrefAStr[1] == 'mktest':
                    pref['mktest_is'] = True
                elif partsPrefAStr[1] == 'uploadcodeqn':
                    pref['uploadcodeqn_is'] = True
            elif partsPrefAStr[0] == 'hasBrandInInstruction':
                pref['hasBrandInInstruction'] = int(partsPrefAStr[1])==1
            elif partsPrefAStr[0] == 'fromDatabase':
                pref['fromDatabase'] = partsPrefAStr[1]            
            elif partsPrefAStr[0] == 'toDatabase':
                pref['toDatabase'] = partsPrefAStr[1]
            elif partsPrefAStr[0] == 'quizName':
                pref['quizName'] = partsPrefAStr[1]
            elif partsPrefAStr[0] == 'qnCount':
                pref['qnCount'] = int(partsPrefAStr[1])
            elif partsPrefAStr[0] == 'timeLimit':
                pref['timeLimit'] = int(partsPrefAStr[1])
            elif partsPrefAStr[0] == 'testPaper':
                pref['testPaperStr'].append(partsPrefAStr[1])
            elif partsPrefAStr[0] == 'codeQn':
                pref['codeQnStr'].append(partsPrefAStr[1])
            elif partsPrefAStr[0] == 'cleanuser':
                pref['cleanuser'] = int(partsPrefAStr[1])==1
            elif partsPrefAStr[0] == 'cleanquiz':
                pref['cleanquiz'] = int(partsPrefAStr[1])==1
            elif partsPrefAStr[0] == 'cleanassignment':
                pref['cleanassignment'] = int(partsPrefAStr[1])==1
            elif partsPrefAStr[0] == 'havetosavepwd':
                pref['havetosavepwd'] = int(partsPrefAStr[1])==1
        pref['testPaper'] = MakeTest.parseTestPaper(pref['testPaperStr'])  
        pref['codeQn'] = MakeTest.parseCodeQn(pref['codeQnStr'])   
          
        return pref
    @staticmethod
    def processMakeTestByPref(prefStr, prefFilefolderPath): 
        pref = MakeTest.parsePref(prefStr)
        #????
        #prefFilefolderPath = os.path.join(ReadPref.PrefFolderPath, jobDetail['latestJob'])
        #print(jobDetail)
        if pref['mktest_is']:
          fromDatabase = pref['fromDatabase']
          toDatabase = pref['toDatabase']
          hasBrandInInstruction = pref['hasBrandInInstruction']          
          testPaper = pref['testPaper']
          codeQn = pref['codeQn']
          srcFilePathManager = os.path.join(prefFilefolderPath, '1ManagerUsableUser.csv')
          srcFilePathStudent = os.path.join(prefFilefolderPath, '2Student.csv')
          #print(srcFilePathManager)
          #print(srcFilePathStudent)
          #print()
          #print(hasBrandInInstruction, fromDatabase, toDatabase)
          #print()
          '''
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
          '''
          '''
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
          '''
          choice = True 
          
          #sayYesOrNo = Captions.MenuHandler_sayYesOrNo#!
          #choice = input(sayYesOrNo) == 'y'
          
          if(choice):
            if(len(testPaper)>0 or len(codeQn)>0):
                StudSavePwd.databaseName = toDatabase
                IsQuiz = True
                IsAssignment= True
                IsUser= True
                StudSavePwd.cleanDb(IsQuiz,IsAssignment,IsUser)

          #choice = input(sayYesOrNo) == 'y'
          if(choice):  
            if(len(testPaper)>0 or len(codeQn)>0):
                # ######################################                    
                #Create the User Data Base   
                havetosavepwd= True            
                StudSavePwd.opt02caller(toDatabase, srcFilePathManager, srcFilePathStudent) 

          if(choice)
            if len(testPaper)>0):
                # ######################################
                PickToDb.DoByPref(hasBrandInInstruction, fromDatabase, toDatabase, testPaper)    
          
          #choice = input(sayYesOrNo) == 'y'

          if (choice):
            if  len(codeQn)>0):
                PickCodeQnToDb.DoByPref(hasBrandInInstruction, fromDatabase, toDatabase, codeQn)

          #choice = input(sayYesOrNo) == 'y'
          if(choice)
            if (len(testPaper)>0 or len(codeQn)>0):
                # ######################################            
                #Add MCQ Test the users
                StudSavePwd.opt02maketest(toDatabase, srcFilePathManager, srcFilePathStudent, testPaper, codeQn) 
  