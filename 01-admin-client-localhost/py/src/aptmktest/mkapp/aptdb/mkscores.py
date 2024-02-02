import pyexcel as pyxl
import os
import sys
import win32com.client
from datetime import datetime

from .MkscoreUtil import MkscoreUtil
from .SingleTest import SingleTest
from .MultipleTest import MultipleTest
from .ManyTestv2 import ManyTest


datPathAndFile = r'F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\scoresfiles'

singleData = dict()
singleData['testName'], singleData['md_templates'],singleData['md_soruces'] = '', dict(), dict()
singleData['destFileName'],singleData['metaData'],singleData['templateBk'] = '', dict(), None
singleData['isCode'] = False

    
class ScoreTE:
    @staticmethod
    def proApiJob(datPathAndFile,csvData, csvFileWOext):
        #write the data to file
        fileLoc = os.path.join(datPathAndFile,f'src/{csvFileWOext}.csv')        
        file = open(fileLoc,'w')
        file.write(csvData)
        file.close()

        #process the created file for generating scores      
        #   make preferences
        eachPref = MkscoreUtil.apiJobFileMkPref(datPathAndFile, csvFileWOext)        
        singleData['isCode'] = not eachPref['isMCQ']
        singleData['md_templates'] = eachPref['md_template']
        singleData['md_soruces'] = eachPref['md_source']

        #   form scores as per template
        SingleTest.readTemplateBool(singleData)
        SingleTest.readStudentEachTestScore(singleData)                                

    @staticmethod
    def DoApiJob(csvData, csvFileWOext):
        global datPathAndFile
        ScoreTE.proApiJob(datPathAndFile,csvData, csvFileWOext) 
        

    @staticmethod
    def proApiJobMultiple(datPathAndFile,csvData, csvFileWOext):
        #write the data to file
        
        for csvFileWOextI in range(len(csvFileWOext)):
            ecsvFileWOext = csvFileWOext[csvFileWOextI]
            ecsvData = csvData[csvFileWOextI]
            fileLoc = os.path.join(datPathAndFile,f'src/{ecsvFileWOext}.csv')        
            file = open(fileLoc,'w')
            file.write(ecsvData)
            file.close()
        
        #process the created file for generating scores      
        #   make preferences
        eachPref = MkscoreUtil.apiJobFileMkPrefMultiple(datPathAndFile, csvFileWOext)  
        #print(eachPref)      
        singleData['isCode'] = not eachPref['isMCQ']
        singleData['md_templates'] = eachPref['md_template']
        singleData['md_soruces'] = eachPref['md_source']

        #   form scores as per template
        MultipleTest.readTemplateBool(singleData)
        MultipleTest.readStudentEachTestScore(singleData)     
    @staticmethod
    def proApiJobManyStepOne(csvData, csvFileWOext):
        global datPathAndFile
        #write the data to file
        for csvFileWOextI in range(len(csvFileWOext)):
            ecsvFileWOext = csvFileWOext[csvFileWOextI]
            ecsvData = csvData[csvFileWOextI]
            fileLoc = os.path.join(datPathAndFile,f'src/{ecsvFileWOext}.csv')        
            file = open(fileLoc,'w')
            file.write(ecsvData)
            file.close()

    @staticmethod
    def proApiJobManyStepTwo( csvFileWOext):
        global datPathAndFile
        #process the created file for generating scores      
        #   make preferences
        eachPref = MkscoreUtil.apiJobFileMkPrefMultiple(datPathAndFile, csvFileWOext)  
        #print(eachPref)      
        singleData['isCode'] = not eachPref['isMCQ']
        singleData['md_templates'] = eachPref['md_template']
        singleData['md_soruces'] = eachPref['md_source']

        #   form scores as per template
        ManyTest.readTemplateBool(singleData)
        return ManyTest.readStudentEachTestScore(singleData)  
    @staticmethod
    def proApiJobMany(csvData, csvFileWOext):
        
        ScoreTE.proApiJobManyStepOne(csvData, csvFileWOext)
        ScoreTE.proApiJobManyStepTwo(csvFileWOext)
        '''
        global datPathAndFile
        #write the data to file
        
        for csvFileWOextI in range(len(csvFileWOext)):
            ecsvFileWOext = csvFileWOext[csvFileWOextI]
            ecsvData = csvData[csvFileWOextI]
            fileLoc = os.path.join(datPathAndFile,f'src/{ecsvFileWOext}.csv')        
            file = open(fileLoc,'w')
            file.write(ecsvData)
            file.close()
        
        #process the created file for generating scores      
        #   make preferences
        eachPref = MkscoreUtil.apiJobFileMkPrefMultiple(datPathAndFile, csvFileWOext)  
        #print(eachPref)      
        singleData['isCode'] = not eachPref['isMCQ']
        singleData['md_templates'] = eachPref['md_template']
        singleData['md_soruces'] = eachPref['md_source']

        #   form scores as per template
        ManyTest.readTemplateBool(singleData)
        return ManyTest.readStudentEachTestScore(singleData)                                    
        '''
    @staticmethod
    def DoApiJobMultiple(csvData, csvFileWOext):
        returnedData = ScoreTE.proApiJobMany(csvData, csvFileWOext)
        #global datPathAndFile; ScoreTE.proApiJobMultiple(datPathAndFile,csvData, csvFileWOext)
        return {'status' : 'Job Done!', 'jobData' : returnedData}

    @staticmethod
    def DoApiJobMultiple_v2(csvData, csvFileWOext):
        # delegate to appAptJop
        from .aptjobdao import AptJobDao
        files_path_name = ",".join(csvFileWOext)
        opStatus = AptJobDao.addScoreJob(files_path_name)
        # delegate to End of appAptJop
        ScoreTE.proApiJobManyStepOne(csvData, csvFileWOext)
        
        return {'status' : 'Job Done!', 'jobData' : 'AptApp will take care', 'opStatus' : opStatus}
        
