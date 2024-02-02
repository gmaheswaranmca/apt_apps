import os
from datetime import datetime
import pyexcel as pyxl
import win32com.client

class MkscoreUtil:
    @staticmethod
    def openWorkBook(bookPathAndFileName):   
        '''
        ** function
        **      arguments: 
        **          string "bookPathAndFileName" 
        **              -  Example: 
        **                  'F:\\v2m\\techLang\\assignment\\2020-07-08-Apt-BulkQuestions\\OLT\\OLTAssignment\\scoresfiles\\pref\\Ultra-Format.xlsx'
        **      returns:
        **          None                
        **      example:
        **          input:
        **                bookPathAndFileName = 'F:\\v2m\\techLang\\assignment\\2020-07-08-Apt-BulkQuestions\\OLT\\OLTAssignment\\scoresfiles\\pref\\Ultra-Format.xlsx'
        **          usage code:
        **              openWorkBook(bookPathAndFileName)
        **          action:
        **              opens the given excel file whose name and path is given in a string named "bookPathAndFileName"
        '''         
        import pythoncom
        pythoncom.CoInitialize()
        excelApp = win32com.client.Dispatch('Excel.Application')
        excelApp.Workbooks.Open(bookPathAndFileName)
        excelApp.Visible = True    

    @staticmethod
    def getPref(srcPath, srcFile, srcCols, srcDate, srcTestName, tmplPath, 
        tmplFile, fmtPathFile, testName, sheetNames, tmplCols, isMCQ):

        return {
            "md_source": {
                "path": srcPath, 
                "file":srcFile,
                "dsname": [srcDate,"",srcTestName], 
                "cols":srcCols,"headerRow" : "2"        
            },
            "md_template": {
                "path":tmplPath, 
                "file":tmplFile, 
                "formatFile":fmtPathFile,
                "testLinkName" : testName, 
                "sheets": sheetNames,
                "cols": tmplCols, 
                "MatchHeading": "Login ID"                
            },
            "isMCQ" : isMCQ
        }

    @staticmethod
    def colNamesIntoNumbers(colNames):        
        '''
        ** function
        **      arguments: 
        **          string "colNames" -  Example: 'C,U,V,AA'
        **      returns:
        **          list of column indices of column names in the comma separated text named "colNames"
        **              - list of Column Names from the given string "colNames"
        **                  - each item of list will become the column index starts at 0
        **      example:
        **          input:
        **                'C,U,V,AA'
        **          usage code:
        **              arColIndices = colNamesIntoNumbers('C,U,V,AA')
        **              print(arColIndices)
        **          output:
        **              [2, 20, 21, 26]
        ''' 
        
        
        #- list of Column Names from the given string "colNames"
        colNamesList = colNames.split(',')
        ordNum = 0


        for colName in colNamesList:
            #each item of list will become the column index starts at 0
            if(len(colName) == 1):
                colNamesList[ordNum] = ord(colName) - 65
            else:
                colNamesList[ordNum] = 26 + ord(colName[-1]) - 65
            ordNum += 1
        return (colNamesList)

    @staticmethod
    def printPref(pref):
        pass
    '''
        print('***************** ****************** *********************')
        print('Soruce')
        for srcNm in pref['md_source']:
            print(f'    {srcNm} : {pref["md_source"][srcNm]}')
        print('Template')
        for srcNm in pref['md_template']:
            print(f'    {srcNm} : {pref["md_template"][srcNm]}')
        print('***************** ****************** *********************')
    '''

    @staticmethod
    def readXlBk(fileName, sheetList=[], headerRowNum=1, colNumsInList=[], ignoringSheetName=False):
        #???print(f'Trace:{fileName}')
        '''
            Bk : [] 
                eachSheet : []
                    eachRow : []
                        eachCell ie value
                ==>                         
            Bk : []                                    
                eachSheet : {} 
                    name : 'Batch 1'
                    data : []
                        eachRow is {}
                            eachItem is as
                            columnCaption : data    ex: Sno : data
                            columnCaption : data    ex: ID  : data
                            columnCaption : data    ex: Name : data                            
                            ...
            In short:
                    []  []      []     primitive
                Src Bk  sheet   row    value  
                    [   [       [      value, value, ... ] ... ] ...   ]                
                =======>
                     []  {}                  []       {}        primitive 
                Dest Bk Sheet                Rows    Row    key:value
                     [  {name:Batch 1, data:[       {       col:value ....} ....]  } ]
        '''
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
        colNumsInList = MkscoreUtil.colNamesIntoNumbers(colNames)
        sheets = MkscoreUtil.readXlBk(fileName, sheetList, headerRowNum, colNumsInList,ignoringSheetName)
        return sheets    

    @staticmethod
    def test_readXlBook(fileName, sheetList=[], colNames=''):
        '''
        test_readXlBook(
            os.path.join(md_templates['path'],md_templates['file']), 
            md_templates['sheets'], 
            md_templates['cols'])'
        '''
        sheets = MkscoreUtil.readBkByCols(fileName, sheetList=[], colNames='')

    @staticmethod
    def ReadDataFromBook(xlSheet, matchData, matchColumnHeader, colDef, isCode):
        #reads the score data from source book's given sheet
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
    @staticmethod
    def ReadDataFromBookv2(xlSheet, matchData, matchColumnHeader, colDef, isCode):
        #reads the score data from source book's given sheet
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
                if res['attendance'] == 'ABSENT':
                    res['score'] = 'ABSENT' 
                if (not isCode) and res['remarks'] == "Scores can't be displayed":
                    res['score'] = 'N.A.' 
                elif isCode:
                    res['remarks'] = 'No Remarks'
                break
        return res          

    @staticmethod        
    def setCountInDict(dataDict, key):        
        dataDict[key] = dataDict.get(key,0) + 1 

    @staticmethod        
    def DictSetGetKey(dataDict, key, defaultValue):        
        dataDict[key] = dataDict.get(key,defaultValue) 
        return dataDict[key]

    @staticmethod
    def apiJobFileMkPref(datPath, srcFileWOext):
        resFiles = []
        prefFolder = os.path.join(datPath, 'pref')
        resFiles = [os.path.basename(f.path) for f in os.scandir(prefFolder) if f.is_file()]

        fileParts = srcFileWOext.split('-')
        srcTestName = fileParts[1]

        fileDet = {
            'formatFile' : '',
            'templateFile' : '',
            'src':[],
            'sheets':[],
            'srcCols': '', 
            'templateCols':'',
            'isTemplate' : False,
            'isFormat' : False,
            'isSrc' : False
        }

        #discover template file
        #discover format file                           
        for eFile in resFiles:
            fileParts = eFile.split('.xlsx')[0].split('-')
            testName = fileParts[0]
            
            if not testName.isalpha:
                continue

            if testName != srcTestName:
                continue

            if(fileParts[1].lower() == 'template' and len(fileParts) == 5):
                fileDet['templateFile'] = eFile
                fileDet['sheets'] = fileParts[2].split('_')
                fileDet['srcCols'] = ','.join(fileParts[3].split('_'))
                fileDet['templateCols'] = ','.join(fileParts[4].split('_'))
                fileDet['isTemplate'] = True                    

            if(fileParts[1].lower() == 'format' and len(fileParts) == 2):                    
                fileDet['formatFile'] = eFile
                fileDet['isFormat'] = True
                
            if fileDet['isTemplate'] and fileDet['isFormat']:
                break
        
        #discover src file 
        #make the preference 
        srcFolder = os.path.join(datPath, 'src')
        eFile = f'{srcFileWOext}.csv'
        eFilePath = os.path.join(srcFolder, f'{srcFileWOext}.csv')
        
        if(os.path.isfile(eFilePath)):
            fileParts = eFile.split('.csv')[0].split('-')
            testName = fileParts[1]
            
            if testName.isalpha and (len(fileParts) == 5):
                dt = datetime.strptime(fileParts[2], '%Y%m%d')
                dt = dt.strftime('%d/%m/%Y')
                src = {
                    'srcFile':eFile,
                    'date': dt, 
                    'isMCQ':fileParts[3]=='MCQ', 
                    'testName':fileParts[4]
                }                    
                fileDet['src'].append(src)
                fileDet['isSrc'] = True
                
                eachTestDic = fileDet
                eachTestSoruces = eachTestDic['src']
                eSrc = eachTestSoruces[0]
                pref = MkscoreUtil.getPref(srcFolder, 
                        eSrc['srcFile'], 
                        eachTestDic['srcCols'], 
                        eSrc['date'], 
                        eSrc['testName'], 
                        prefFolder, 
                        eachTestDic['templateFile'], 
                        os.path.join(prefFolder, eachTestDic['formatFile']), 
                        testName, 
                        eachTestDic['sheets'], 
                        eachTestDic['templateCols'],
                        eSrc['isMCQ']
                    )
                return pref  
        #print(srcTestName,fileDet,datPath,prefFolder,sep="\n")                           
        return None

    @staticmethod
    def apiJobFileMkPrefMultiple(datPath, srcFileWOext):
        srcFileWOexts = srcFileWOext
        res = {
            "md_source": [],
            "md_template": {},
            "isMCQ" : False
        }
        I = 0
        for srcFileWOext in srcFileWOexts:
            pref = MkscoreUtil.apiJobFileMkPref(datPath, srcFileWOext)
            pref['md_source']['isMCQ']  = pref['isMCQ']
            res['md_source'].append(pref['md_source'])            
            I += 1

        res['md_template'] = pref['md_template']
        res['isMCQ'] = pref['isMCQ']

        return res
