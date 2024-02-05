import docx
import pandas as pd
import os
import glob
import io
import os.path
from datetime import date

import random
import string

import mysql.connector

from Captions import Captions

class ReadPref:
    #PrefFolderPath = r'F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\datafiles'
    PrefFolderPath = r'C:\mywork\source\apt\apt-test-files\test'
    @classmethod
    def getJobDetail(cls):
        resFiles = []
        resFiles = [ os.path.basename(f.path) for f in os.scandir(ReadPref.PrefFolderPath) if f.is_dir() and os.path.basename(f.path)!='999-Sources']
        resFiles.sort()
        latestJob = resFiles[-1]
        
        latestJob_DatePart = latestJob.split('-')[1]
        

        todayInYYMMDD = date.today().strftime("%y%m%d")

        jobDetail = {
                'latestJob' : latestJob, 
                'latestJob_DatePart':latestJob_DatePart, 
                'todayInYYMMDD':todayInYYMMDD,
                'todayMatched':todayInYYMMDD == latestJob_DatePart,
                'prefStr': ''
            }
        jobDetail['prefStr'] = []
        if(jobDetail['todayMatched']):
            prefFilefolderPath = os.path.join(ReadPref.PrefFolderPath, jobDetail['latestJob'])
            prefFileNameWithFolderPath =  os.path.join(prefFilefolderPath,'0Pref.txt')
            f=open(prefFileNameWithFolderPath, 'r')    
            jobDetail['prefStr'] = f.readlines()
        jobDetail['pref'] = ReadPref.parsePref(jobDetail['prefStr'])
        print(jobDetail)

        return jobDetail
    @classmethod
    def parsePref(cls, prefStr):
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
        pref['testPaper'] = ReadPref.parseTestPaper(pref['testPaperStr'])  
        pref['codeQn'] = ReadPref.parseCodeQn(pref['codeQnStr'])   
          
        return pref
    @classmethod
    def parseTestPaper(cls, testPaperStr):        
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
    @classmethod
    def parseCodeQn(cls, codeQnStr):        
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
    @classmethod
    def getFilesList(cls):
        return ReadPref.getJobDetail()        