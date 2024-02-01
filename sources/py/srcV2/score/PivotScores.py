import pyexcel as pyxl
import os
import sys
from datetime import datetime
from PrefPivot import readConfig

config = readConfig()


#print(config)
if config == None:
    sys.exit('Job File is not defined')
    
md_soruces = config['md_soruces']
md_templates = config['md_templates']

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

def readXlBk(fileName, sheetList=[], headerRowNum=1, colNumsInList=[]):
    xlBook = pyxl.get_book(file_name=fileName)
    sheets = []
    #print(type(xlBook))
    for sheet in xlBook:
        if sheet.name not in sheetList:
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

def readBkByCols(fileName, sheetList=[], colNames='', headerRowNum=1):
    colNumsInList = colNamesIntoNumbers(colNames)
    sheets = readXlBk(fileName, sheetList, headerRowNum, colNumsInList)
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
        md_templates['cols'])

md_templates['topCaption'] = {}

testPathIndex = 0

for testPathGroup in md_soruces:
    testFileIdx = 0
    for testFile in testPathGroup['files']:
        print('Reading {0} - {1}...'.format(testFile['name'],testFile['dsname'][2]))
        xlBk = readBkByCols(
            os.path.join(testPathGroup['path'],
                testFile['name']), 
                md_templates['sheets'], 
                testFile['cols'],
                (1 if testFile['dsname'][1]=='' else 2))
        
        testFile['xlBk'] = xlBk
        metaData = {}
        metaData['testName'] = testFile['dsname'][2]
        metaData['date'] = testFile['dsname'][0]
        dt = datetime.strptime(metaData['date'], '%d/%m/%Y')
        metaData['date_d'] = dt.strftime('%b %d')
        metaData['day_name'] = dt.strftime('%a')
        metaData['day_name_full'] = dt.strftime('%A')
        metaData['part'] = testFile['dsname'][1]
        metaData['colDef'] = [colName for colName in xlBk[0]['data'][0]]
        metaData['xlBk'] = xlBk
        md_templates['topCaption'][testFile['dsname'][2]] = metaData
        testFileIdx += 1
    testPathIndex += 1    
dtNow = datetime.now().strftime('%Y%m%d%H%M%S')        
fromMeta =     md_templates['topCaption'][ md_soruces[0]['files'][0] ['dsname'][2] ]
toMeta   =     md_templates['topCaption'][ md_soruces[testPathIndex-1]['files'][testFileIdx-1] ['dsname'][2] ]
destFileName = '{1} {0}_-_to_-_{3} {2}_-_Scores_-_{4}%s.xlsx' .format (
        fromMeta['date_d'], fromMeta['day_name'], 
        toMeta['date_d'], toMeta['day_name'],
        dtNow        
        )
'''
print(destFileName)
import sys
sys.exit() 
'''

#print(md_soruces[0]['files'][testFileIdx-1]['xlBk'][0]['data'][:5])

#Data Processing
def ReadDataFromBook(xlSheet, studentName, colDef):
    res = {'score':'Name N.A.',
           'attendance':'Name N.A.',
           'remarks':'Name N.A.'}
           
    for row in xlSheet['data']:
        if row['Name of Student'] == studentName:
            for colName in colDef:
                if colName.find('Score') >= 0:
                    res['score'] = row[colName]
                elif colName == 'Attendance':
                    res['attendance'] = row[colName]
                else:
                    res['remarks'] = row[colName]
            if res['attendance'] == 'ABSENT':
                res['score'] = 'ABSENT'
            if res['remarks'] == "Scores can't be displayed":
                res['score'] = 'N.A.' 
            break
    return res            
        

#print(md_templates['topCaption'])
#Reading student's each test score
topCaption = md_templates['topCaption']
sheetNum = 0
for sheet in templateBk:
    for row in sheet['data']:
        nameOfStudent = row['Name of Student']
        print(f'{sheet["name"]}-{nameOfStudent} Processing...')
        for testName in topCaption:
            xlSheet = topCaption[testName]['xlBk'][sheetNum]
            colDef = topCaption[testName]['colDef']
            date_d = topCaption[testName]['date_d']            
            #print(colDef, date_d)            
            testData = ReadDataFromBook(xlSheet, nameOfStudent, colDef)
            row[testName] = testData
    sheetNum += 1
    
'''    
print('-'*40)    
print(templateBk[3]['data'][:5])    
print('-'*40)    
'''

#list of records with column headings to write into each sheet
for sheet in templateBk:
    resRows3Col = [['','',''],['','',''],['','',''],['S. No.','Name of Student','Dept']]
    resRows2Col = [['','',''],['','',''],['','',''],['S. No.','Name of Student','Dept']]
    resRows1Col = [['','',''],['','',''],['','',''],['S. No.','Name of Student','Dept']]
    resRowsAll = [resRows3Col,resRows2Col,resRows1Col]
    resRowsAllSize = [3,2,1]
    for testName in topCaption:
        colDef = topCaption[testName]['colDef']
        day_name_full = topCaption[testName]['day_name_full']
        date_d = topCaption[testName]['date_d']
        resRowsIndex = 0
        for resRows in resRowsAll:
            ColSize = resRowsAllSize[resRowsIndex]
            resRows[0].extend([testName]*ColSize)
            resRows[1].extend([day_name_full]*ColSize)
            resRows[2].extend([date_d]*ColSize)
            resRows[3].extend(colDef[1:1+ColSize])
            resRowsIndex += 1
    for row in sheet['data']:    
        resRow3Col = []        
        resRow2Col = []  
        resRow1Col = []          
        
        resRow3Col.extend([row['S. No.'],row['Name of Student'],row['Dept']])
        resRow2Col.extend([row['S. No.'],row['Name of Student'],row['Dept']])
        resRow1Col.extend([row['S. No.'],row['Name of Student'],row['Dept']])
           
        for testName in topCaption:
            testData = row[testName]
            resRow3Col.extend([testData['score'],testData['attendance'],testData['remarks']])
            resRow2Col.extend([testData['score'],testData['remarks']])
            resRow1Col.extend([testData['score']])
        resRows3Col.append(resRow3Col)
        resRows2Col.append(resRow2Col)
        resRows1Col.append(resRow1Col)
    sheet['resSheet3Col'] = resRows3Col
    sheet['resSheet2Col'] = resRows2Col
    sheet['resSheet1Col'] = resRows1Col
    
'''    
print('-'*40)    
#print(templateBk[3]['resSheet1Col'][:9])    
print(templateBk[3]['resSheet1Col'][0])
print(templateBk[3]['resSheet1Col'][3])
print(templateBk[3]['resSheet1Col'][4])
print('-'*40)      
'''


exportableFiles = [
 {'sheetName':'resSheet1Col', 'fileName':destFileName%('Consolidated_-_1col',)},
 {'sheetName':'resSheet2Col', 'fileName':destFileName%('Consolidated_-_2col',)},
 {'sheetName':'resSheet3Col', 'fileName':destFileName%('Consolidated_-_3col',)},
]
for exportableFile in exportableFiles:    
    sheetName = exportableFile["sheetName"]
    fileName = exportableFile["fileName"]
    print(f'{fileName} Exporting...')
    
    bookdict=dict()
    for i in range(len(templateBk)):
        bookdict['Batch ' + str(i + 1)] = templateBk[i][sheetName]

    pyxl.save_book_as(
           bookdict=bookdict,
           dest_file_name = os.path.join(os.path.join(md_templates['path'][0:-4],'dest'),fileName)
           )
    print(f'{fileName} Exported!')

print('!!!Thank you!!!')    