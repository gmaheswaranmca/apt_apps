#from ConfigAppAptTestScores import readConfig, openWorkBook
import pyexcel as pyxl
import os
import sys
import win32com.client
from datetime import datetime

datPathAndFile = r'F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\scoresfiles'

pref = {
    "md_source": {
        "path": "", "file":"",
        "dsname": ["07/07/2021","","Test 48"], 
        "cols":"B,C,E,F,K","headerRow" : "2"        
    },
    "md_template": {
        "path":"", 
        "file":"", 
        "formatFile":"",
        "testLinkName" : "King", "sheets": ["Batch 1","Batch 2","Batch 3","Batch 4" ],
        "cols": "A,B,C,D", "MatchHeading": "Login ID"
    }
}   
testName=""
md_soruces = pref['md_source']
md_templates = pref['md_template']
destFileName = ''
metaData = {}
templateBk=None
isCode = False

#os.path.join(md_templates['path'],md_templates['file'])
fileDb = dict()
    
class ScoreTE:
    @staticmethod
    def getPref(srcPath, srcFile, srcCols, srcDate, srcTestName, tmplPath, 
        tmplFile, fmtPathFile, testName, sheetNames, tmplCols, isMCQ):
        return {
            "md_source": {
                "path": srcPath, "file":srcFile,
                "dsname": [srcDate,"",srcTestName], 
                "cols":srcCols,"headerRow" : "2"        
            },
            "md_template": {
                "path":tmplPath, 
                "file":tmplFile, 
                "formatFile":fmtPathFile,
                "testLinkName" : testName, "sheets": sheetNames,
                "cols": tmplCols, "MatchHeading": "Login ID"
                
            },
            "isMCQ" : isMCQ
        }
    @staticmethod
    def printPref(pref):
        print('***************** ****************** *********************')
        print('Soruce')
        for srcNm in pref['md_source']:
            print(f'    {srcNm} : {pref["md_source"][srcNm]}')
        print('Template')
        for srcNm in pref['md_template']:
            print(f'    {srcNm} : {pref["md_template"][srcNm]}')
        print('***************** ****************** *********************')
    @staticmethod
    def getJobFileDetail(datPathAndFile):
            resFiles = []
            prefFolder = os.path.join(datPathAndFile, 'pref')
            resFiles = [os.path.basename(f.path) for f in os.scandir(prefFolder) if f.is_file()]

            for eFile in resFiles:
                #print(eFile)
                
                fileParts = eFile.split('.xlsx')[0].split('-')
                testName = fileParts[0]
                if not testName.isalpha:
                    continue

                if(fileParts[1].lower() == 'template' and len(fileParts) == 5):
                    fileDet = {
                                'formatFile' : '',
                                'templateFile' : eFile,
                                'src':[],
                                'sheets':fileParts[2].split('_'),
                                'srcCols': ','.join(fileParts[3].split('_')), 
                                'templateCols':','.join(fileParts[4].split('_'))
                            }
                    fileDb[testName]=fileDet
            for eFile in resFiles:
                #print(eFile)
                
                fileParts = eFile.split('.xlsx')[0].split('-')
                testName = fileParts[0]

                if not testName.isalpha:
                    continue
                if(fileParts[1].lower() == 'format' and len(fileParts) == 2):
                    fileDet = fileDb[testName]
                    fileDet['formatFile'] = eFile

            
            
            srcFolder = os.path.join(datPathAndFile, 'src')
            resFiles = [os.path.basename(f.path) for f in os.scandir(srcFolder) if f.is_file() and (not f.path.endswith('-done.csv'))]
            for eFile in resFiles:
                #print(eFile)
                
                fileParts = eFile.split('.csv')[0].split('-')
                testName = fileParts[1]
                if not testName.isalpha:
                    continue

                if(len(fileParts) == 5):
                    dt = datetime.strptime(fileParts[2], '%Y%m%d')
                    dt = dt.strftime('%d/%m/%Y')
                    src = {
                        'srcFile':eFile,
                        'date': dt, 'isMCQ':fileParts[3]=='MCQ', 'testName':fileParts[4]}
                    fileDet = fileDb[testName]
                    fileDet['src'].append(src)
                    
                    
            allPrefs = []
            for eachTest in fileDb:          
                #print(f'{eachTest}')
                eachTestDic = fileDb[eachTest]
                eachTestSoruces = eachTestDic['src']
                for eSrc in eachTestSoruces:
                    allPrefs.append(ScoreTE.getPref(srcFolder, eSrc['srcFile'], eachTestDic['srcCols'], 
                            eSrc['date'], eSrc['testName'], prefFolder, 
                            eachTestDic['templateFile'], os.path.join(prefFolder, 
                            eachTestDic['formatFile']), eachTest, 
                            eachTestDic['sheets'], eachTestDic['templateCols'],
                            eSrc['isMCQ']))
            
            return allPrefs 

#proEachJob(datPathAndFile)
#print(pref)


    @staticmethod
    def openWorkBook(bookPathAndFileName):   
        excelApp = win32com.client.Dispatch('Excel.Application')
        excelApp.Workbooks.Open(bookPathAndFileName)
        excelApp.Visible = True

    @staticmethod
    def colNamesIntoNumbers(colNames):
        #print(colNamesIntoNumbers('C,U,V,AA'))
        colNamesList = colNames.split(',')
        ordNum = 0
        for colName in colNamesList:
            if(len(colName) == 1):
                colNamesList[ordNum] = ord(colName) - 65
            else:
                colNamesList[ordNum] = 26 + ord(colName[-1]) - 65
            ordNum += 1
        return (colNamesList)

    @staticmethod
    def readXlBk(fileName, sheetList=[], headerRowNum=1, colNumsInList=[], ignoringSheetName=False):
        print(f'Trace:{fileName}')
        xlBook = pyxl.get_book(file_name=fileName)
        sheets = []
        #print(type(xlBook))
        for sheet in xlBook:
            if sheet.name not in sheetList and ignoringSheetName==False:
                continue
            sheetDict = dict()
            
            rowNum=1
            fields = []
            data = []
            for record in sheet:
                if rowNum <= headerRowNum:
                    fields = record        
                else:
                    recDict = dict()
                    colNum=0
                    for colDat in record:
                        if colNum in colNumsInList:
                            recDict[fields[colNum]] = colDat
                        colNum += 1
                    data.append(recDict)
                rowNum += 1
            sheetDict['name'] = sheet.name
            sheetDict['data'] = data
            
            sheets.append(sheetDict)    
        return sheets    

    @staticmethod
    def readBkByCols(fileName, sheetList=[], colNames='', headerRowNum=1, ignoringSheetName=False):
        colNumsInList = ScoreTE.colNamesIntoNumbers(colNames)
        sheets = ScoreTE.readXlBk(fileName, sheetList, headerRowNum, colNumsInList,ignoringSheetName)
        return sheets    

    @staticmethod
    def test_readXlBook(fileName, sheetList=[], colNames=''):
        '''
        test_readXlBook(
            os.path.join(md_templates['path'],md_templates['file']), 
            md_templates['sheets'], 
            md_templates['cols'])'
        '''
        sheets = ScoreTE.readBkByCols(fileName, sheetList=[], colNames='')
        print(len(sheets))
        for sheet in sheets:            
            print(sheet['name'], len(sheet['data']), sheet['data'][0],sep='\n',end='\n\n\n\n')
            
    #Data Processing
    @staticmethod
    def ReadDataFromBook(xlSheet, matchData, matchColumnHeader, colDef):
        res = {'score':'Name N.A.',
            'attendance':'Name N.A.',
            'remarks':'Name N.A.'}
            
        for row in xlSheet['data']:
            if row[matchColumnHeader] == matchData:
                for colName in colDef:
                    if colName.find('Score') >= 0:
                        res['score'] = row[colName]
                    elif colName == 'Attendance':
                        res['attendance'] = row[colName]
                    elif colName == 'Remarks' or colName == 'Remark':
                        res['remarks'] = row[colName]
                '''if res['attendance'] == 'ABSENT':
                    res['score'] = 'ABSENT' '''
                if (not isCode) and res['remarks'] == "Scores can't be displayed":
                    pass #res['score'] = 'N.A.' 
                break
        return res   

    @staticmethod        
    def setCountInDict(dataDict, key):        
        dataDict[key] = dataDict.get(key,0) + 1            
    
    @staticmethod
    def readTemplateBool():
        global testName, md_templates, md_soruces, destFileName, metaData,templateBk
        print('Reading Template Book...')        
        templateBk = ScoreTE.readBkByCols(
                os.path.join(md_templates['path'],md_templates['file']), 
                md_templates['sheets'], 
                md_templates['cols'], 
                1)

        print('Reading Source Book...')        
        sourceBk =  ScoreTE.readBkByCols(
                os.path.join(md_soruces['path'],md_soruces['file']), 
                [], 
                md_soruces['cols'], 
                int(md_soruces['headerRow']),True)
        metaData = {}
        testName =  md_soruces['dsname'][2]
        metaData['testName'] = testName
        metaData['date'] = md_soruces['dsname'][0]
        dt = datetime.strptime(metaData['date'], '%d/%m/%Y')
        metaData['date_d'] = dt.strftime('%d-%b')
        metaData['day_name'] = dt.strftime('%a')
        metaData['day_name_full'] = dt.strftime('%A')
        metaData['part'] = md_soruces['dsname'][1]
        metaData['colDef'] = [colName for colName in sourceBk[0]['data'][0]]
        metaData['xlBk'] = sourceBk
                
        
        dtNow = datetime.now().strftime('%Y%m%d%H%M%S')        
        destFileName = '{3}_-_{1}_-_{0}_-_{4}-Scores_-_{2}.xlsx' .format (
                metaData['date_d'], metaData['day_name'],         
                dtNow, md_templates['testLinkName'] ,
                testName
                )      
    @staticmethod
    def readStudentEachTestScore():
        #Reading student's each test score
        global testName, md_templates, md_soruces, destFileName, metaData,templateBk
        sheetNum = 0
        for sheet in templateBk:
            sheet[testName] = {}
            sheet[testName]['Attendance'] = {}
            sheet[testName]['Remarks'] = {}
            for row in sheet['data']:
                matchData = row[md_templates['MatchHeading']]
                print(f'{sheet["name"]}-{matchData} Processing...')
                
                xlSheet = metaData['xlBk'][0]
                colDef = metaData['colDef']
                date_d = metaData['date_d']            
                #print(colDef, date_d)            
                testData = ScoreTE.ReadDataFromBook(xlSheet, matchData, md_templates['MatchHeading'], colDef)
                ScoreTE.setCountInDict(sheet[testName]['Attendance'],testData['attendance'])
                ScoreTE.setCountInDict(sheet[testName]['Remarks'],testData['remarks'])
                row[testName] = testData
            sheetNum += 1
            
        '''    
        print('-'*40)    
        print(templateBk[3]['data'][:5])    
        print('-'*40)    
        '''

        #list of records with column headings to write into each sheet
        dbOne = []
        for sheet in templateBk:
            sheetMatrix = [['S. No.','Name of Student','Dept']]   
            colDef = metaData['colDef']        
            sheetMatrix[0].extend(colDef[-3:])
            
            
                
            for row in sheet['data']:    
                testData = row[testName]
                sheetRow = []                 
                sheetRow.extend([row['S. No.'],row['Name of Student'],row['Dept'],
                                testData['score'],testData['attendance'],testData['remarks']])        
                sheetMatrix.append(sheetRow)
                
            dbOneData = {
                '''ABSENT''':0,
                '''PRESENT''':0,
                '''Good job. Keep it up!''':0,  
                '''Attended test in a Genuine manner''':0} #db means dashboard
            
            for summaryEach in sheet[testName]: 
                summaryTotal = 0
                #sheetMatrix.append(['','','','','',''])
                #sheetMatrix.append(['',summaryEach + ':','','','',''])
                for summaryKey in sheet[testName][summaryEach]:
                    #sheetMatrix.append(['',summaryKey,'',sheet[testName][summaryEach][summaryKey],'',''])
                    summaryTotal += sheet[testName][summaryEach][summaryKey]
                    if summaryEach=='Attendance' and (summaryKey in('ABSENT','PRESENT')):
                        dbOneData[summaryKey] += sheet[testName][summaryEach][summaryKey]
                    if summaryEach=='Remarks' and (summaryKey  in('Good job. Keep it up!','Attended test in a Genuine manner')):
                        dbOneData[summaryKey] += sheet[testName][summaryEach][summaryKey]
                        
                #sheetMatrix.append(['','','','','',''])
            dbOne.append(dbOneData)    
                
            sheet['sheetMatrix'] = sheetMatrix
            
        '''    
        print('-'*40)    
        #print(templateBk[3]['resSheet1Col'][:9])    
        print(templateBk[3]['resSheet1Col'][0])
        print(templateBk[3]['resSheet1Col'][3])
        print(templateBk[3]['resSheet1Col'][4])
        print('-'*40)      
        '''
        dbOneMatrix = [
            ['', 'Batch',	'Total',	'Attended',	'Absent',	'Good Scorers',	'Genuine Attender', 	'Just Attended'],
            ['','Total',0,0,0,0,0,0]
        ]
        dbOneIndex = 0
        for dbOneRow in dbOne:    
            dbOneABSENT = dbOneRow['ABSENT']
            dbOnePRESENT =  dbOneRow['PRESENT']
            dbOneTotal = dbOneABSENT + dbOnePRESENT
            dbOneGoodScorers =  dbOneRow['Good job. Keep it up!']
            dbOneGenuineAttender = dbOneRow['Attended test in a Genuine manner']
            dbOneJustAttended = dbOnePRESENT - dbOneGoodScorers - dbOneGenuineAttender
            dbOneMatrix.insert(-1,['', md_templates['sheets'][dbOneIndex],	
                                dbOneTotal,	
                                dbOnePRESENT,	
                                dbOneABSENT,	
                                dbOneGoodScorers,	
                                dbOneGenuineAttender, 	
                                dbOneJustAttended])
            dbOneMatrix[-1][2] += dbOneTotal
            dbOneMatrix[-1][3] += dbOnePRESENT
            dbOneMatrix[-1][4] += dbOneABSENT
            dbOneMatrix[-1][5] += dbOneGoodScorers
            dbOneMatrix[-1][6] += dbOneGenuineAttender
            dbOneMatrix[-1][7] += dbOneJustAttended
            dbOneIndex += 1

        
        sheetName = 'sheetMatrix'
        fileName = destFileName
        #print(md_soruces['path'][0:-4])
        dest_file_name = os.path.join(os.path.join(md_soruces['path'][0:-4],'dest'),fileName)
        print(f'{fileName} at {dest_file_name}Exporting...')
        bookdict = {}
        for SheetIndex in range(len(templateBk)):
            bookdict[md_templates['sheets'][SheetIndex]] = templateBk[SheetIndex][sheetName]
        bookdict['Consolidated']  =  dbOneMatrix  
        pyxl.save_book_as(bookdict=bookdict,  dest_file_name = dest_file_name)

        print(f'{fileName}  at {dest_file_name} Exported!')

        srcFilePath = os.path.join(md_soruces['path'],md_soruces['file'])
        os.rename(srcFilePath, srcFilePath[0:-4] + '-done.csv')


        ScoreTE.openWorkBook(md_templates['formatFile'])
        ScoreTE.openWorkBook(dest_file_name)


        print('!!!Thank you!!!')   

    @staticmethod
    def proEachJob(datPathAndFile):
        global testName, md_templates, md_soruces, destFileName, metaData,templateBk, isCode
        allPrefs =  ScoreTE.getJobFileDetail(datPathAndFile)
        for eachPref in allPrefs:  
            #ScoreTE.printPref(eachPref)
            print('--------------------------------------------------------')
            print(f"    {eachPref['md_source']['file']}")
            isCode = not eachPref['isMCQ']
            md_templates = eachPref['md_template']
            md_soruces = eachPref['md_source']
            if(isCode):
                print('                 ****Coding Test****')
            choice = input('    Are you sure to DO SCORES TRANSFORMATIONS (y/n)?')
            print('--------------------------------------------------------')
            if choice == 'y':                                
                ScoreTE.readTemplateBool()
                ScoreTE.readStudentEachTestScore()                                
            print('------------------The End------------------------')

    #
    #@staticmethod
    
ScoreTE.proEachJob(datPathAndFile)

"""
isCode = False
#print(f'{len(sys.argv)} arguments I got.');
if len(sys.argv)>=2:
    isCode = True
    print(f'*****************Coding Test***************\n\n');        

config = readConfig()
#print(config)
if config == None:
    sys.exit('Job File is not defined')

if input('Are you sure to do job? Say (y/n):') != 'y':
    sys.exit('You will do the job later!\nSee you!!!')
    
md_soruces = config['md_soruce']
md_templates = config['md_template']

#print(md_soruces,end='\n\n\n')
#print(md_templates,end='\n\n\n')

#sys.exit('Stopping')
def colNamesIntoNumbers(colNames):
    #print(colNamesIntoNumbers('C,U,V,AA'))
    colNamesList = colNames.split(',')
    ordNum = 0
    for colName in colNamesList:
        if(len(colName) == 1):
            colNamesList[ordNum] = ord(colName) - 65
        else:
            colNamesList[ordNum] = 26 + ord(colName[-1]) - 65
        ordNum += 1
    return (colNamesList)

def readXlBk(fileName, sheetList=[], headerRowNum=1, colNumsInList=[], ignoringSheetName=False):
    xlBook = pyxl.get_book(file_name=fileName)
    sheets = []
    #print(type(xlBook))
    for sheet in xlBook:
        if sheet.name not in sheetList and ignoringSheetName==False:
            continue
        sheetDict = dict()
        
        rowNum=1
        fields = []
        data = []
        for record in sheet:
            if rowNum <= headerRowNum:
                fields = record        
            else:
                recDict = dict()
                colNum=0
                for colDat in record:
                    if colNum in colNumsInList:
                        recDict[fields[colNum]] = colDat
                    colNum += 1
                data.append(recDict)
            rowNum += 1
        sheetDict['name'] = sheet.name
        sheetDict['data'] = data
        
        sheets.append(sheetDict)    
    return sheets

def readBkByCols(fileName, sheetList=[], colNames='', headerRowNum=1, ignoringSheetName=False):
    colNumsInList = colNamesIntoNumbers(colNames)
    sheets = readXlBk(fileName, sheetList, headerRowNum, colNumsInList,ignoringSheetName)
    return sheets

def test_readXlBook(fileName, sheetList=[], colNames=''):
    '''
    test_readXlBook(
        os.path.join(md_templates['path'],md_templates['file']), 
        md_templates['sheets'], 
        md_templates['cols'])'
    '''
    sheets = readBkByCols(fileName, sheetList=[], colNames='')
    print(len(sheets))
    for sheet in sheets:            
        print(sheet['name'], len(sheet['data']), sheet['data'][0],sep='\n',end='\n\n\n\n')
        
     
print('Reading Template Book...')        
templateBk = readBkByCols(
        os.path.join(md_templates['path'],md_templates['file']), 
        md_templates['sheets'], 
        md_templates['cols'], 
        1)

print('Reading Source Book...')        
sourceBk = readBkByCols(
        os.path.join(md_soruces['path'],md_soruces['file']), 
        [], 
        md_soruces['cols'], 
        int(md_soruces['headerRow']),True)
metaData = {}
testName =  md_soruces['dsname'][2]
metaData['testName'] = testName
metaData['date'] = md_soruces['dsname'][0]
dt = datetime.strptime(metaData['date'], '%d/%m/%Y')
metaData['date_d'] = dt.strftime('%d-%b')
metaData['day_name'] = dt.strftime('%a')
metaData['day_name_full'] = dt.strftime('%A')
metaData['part'] = md_soruces['dsname'][1]
metaData['colDef'] = [colName for colName in sourceBk[0]['data'][0]]
metaData['xlBk'] = sourceBk
        
  
dtNow = datetime.now().strftime('%Y%m%d%H%M%S')        
destFileName = '{3}_-_{1}_-_{0}_-_Scores_-_{2}.xlsx' .format (
        metaData['date_d'], metaData['day_name'],         
        dtNow, md_templates['testLinkName']        
        )

#Data Processing
def ReadDataFromBook(xlSheet, matchData, matchColumnHeader, colDef):
    res = {'score':'Name N.A.',
           'attendance':'Name N.A.',
           'remarks':'Name N.A.'}
           
    for row in xlSheet['data']:
        if row[matchColumnHeader] == matchData:
            for colName in colDef:
                if colName.find('Score') >= 0:
                    res['score'] = row[colName]
                elif colName == 'Attendance':
                    res['attendance'] = row[colName]
                elif colName == 'Remarks' or colName == 'Remark':
                    res['remarks'] = row[colName]
            '''if res['attendance'] == 'ABSENT':
                res['score'] = 'ABSENT' '''
            if (not isCode) and res['remarks'] == "Scores can't be displayed":
                res['score'] = 'N.A.' 
            break
    return res            
def setCountInDict(dataDict, key):        
    dataDict[key] = dataDict.get(key,0) + 1


#Reading student's each test score

sheetNum = 0
for sheet in templateBk:
    sheet[testName] = {}
    sheet[testName]['Attendance'] = {}
    sheet[testName]['Remarks'] = {}
    for row in sheet['data']:
        matchData = row[md_templates['MatchHeading']]
        print(f'{sheet["name"]}-{matchData} Processing...')
        
        xlSheet = metaData['xlBk'][0]
        colDef = metaData['colDef']
        date_d = metaData['date_d']            
        #print(colDef, date_d)            
        testData = ReadDataFromBook(xlSheet, matchData, md_templates['MatchHeading'], colDef)
        setCountInDict(sheet[testName]['Attendance'],testData['attendance'])
        setCountInDict(sheet[testName]['Remarks'],testData['remarks'])
        row[testName] = testData
    sheetNum += 1
    
'''    
print('-'*40)    
print(templateBk[3]['data'][:5])    
print('-'*40)    
'''

#list of records with column headings to write into each sheet
dbOne = []
for sheet in templateBk:
    sheetMatrix = [['S. No.','Name of Student','Dept']]   
    colDef = metaData['colDef']        
    sheetMatrix[0].extend(colDef[-3:])
    
    
        
    for row in sheet['data']:    
        testData = row[testName]
        sheetRow = []                 
        sheetRow.extend([row['S. No.'],row['Name of Student'],row['Dept'],
                        testData['score'],testData['attendance'],testData['remarks']])        
        sheetMatrix.append(sheetRow)
        
    dbOneData = {
        '''ABSENT''':0,
        '''PRESENT''':0,
        '''Good job. Keep it up!''':0,  
        '''Attended test in a Genuine manner''':0} #db means dashboard
    
    for summaryEach in sheet[testName]: 
        summaryTotal = 0
        #sheetMatrix.append(['','','','','',''])
        #sheetMatrix.append(['',summaryEach + ':','','','',''])
        for summaryKey in sheet[testName][summaryEach]:
            #sheetMatrix.append(['',summaryKey,'',sheet[testName][summaryEach][summaryKey],'',''])
            summaryTotal += sheet[testName][summaryEach][summaryKey]
            if summaryEach=='Attendance' and (summaryKey in('ABSENT','PRESENT')):
                dbOneData[summaryKey] += sheet[testName][summaryEach][summaryKey]
            if summaryEach=='Remarks' and (summaryKey  in('Good job. Keep it up!','Attended test in a Genuine manner')):
                dbOneData[summaryKey] += sheet[testName][summaryEach][summaryKey]
                
        #sheetMatrix.append(['','','','','',''])
    dbOne.append(dbOneData)    
        
    sheet['sheetMatrix'] = sheetMatrix
    
'''    
print('-'*40)    
#print(templateBk[3]['resSheet1Col'][:9])    
print(templateBk[3]['resSheet1Col'][0])
print(templateBk[3]['resSheet1Col'][3])
print(templateBk[3]['resSheet1Col'][4])
print('-'*40)      
'''
dbOneMatrix = [
    ['', 'Batch',	'Total',	'Attended',	'Absent',	'Good Scorers',	'Genuine Attender', 	'Just Attended'],
    ['','Total',0,0,0,0,0,0]
]
dbOneIndex = 0
for dbOneRow in dbOne:    
    dbOneABSENT = dbOneRow['ABSENT']
    dbOnePRESENT =  dbOneRow['PRESENT']
    dbOneTotal = dbOneABSENT + dbOnePRESENT
    dbOneGoodScorers =  dbOneRow['Good job. Keep it up!']
    dbOneGenuineAttender = dbOneRow['Attended test in a Genuine manner']
    dbOneJustAttended = dbOnePRESENT - dbOneGoodScorers - dbOneGenuineAttender
    dbOneMatrix.insert(-1,['', md_templates['sheets'][dbOneIndex],	
                        dbOneTotal,	
                        dbOnePRESENT,	
                        dbOneABSENT,	
                        dbOneGoodScorers,	
                        dbOneGenuineAttender, 	
                        dbOneJustAttended])
    dbOneMatrix[-1][2] += dbOneTotal
    dbOneMatrix[-1][3] += dbOnePRESENT
    dbOneMatrix[-1][4] += dbOneABSENT
    dbOneMatrix[-1][5] += dbOneGoodScorers
    dbOneMatrix[-1][6] += dbOneGenuineAttender
    dbOneMatrix[-1][7] += dbOneJustAttended
    dbOneIndex += 1

 
sheetName = 'sheetMatrix'
fileName = destFileName
dest_file_name = os.path.join(md_soruces['path'],fileName)
print(f'{fileName} at {dest_file_name}Exporting...')
bookdict = {}
for SheetIndex in range(len(templateBk)):
    bookdict[md_templates['sheets'][SheetIndex]] = templateBk[SheetIndex][sheetName]
bookdict['Consolidated']  =  dbOneMatrix  
pyxl.save_book_as(bookdict=bookdict,  dest_file_name = dest_file_name)

print(f'{fileName}  at {dest_file_name} Exported!')

openWorkBook(md_templates['formatFile'])
openWorkBook(dest_file_name)


print('!!!Thank you!!!')    
"""
