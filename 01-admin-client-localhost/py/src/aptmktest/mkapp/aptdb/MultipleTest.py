import os
import pyexcel as pyxl
from datetime import datetime
from .MkscoreUtil import MkscoreUtil


class MultipleTest:
    @staticmethod
    def readTemplateBool(singleData):
        #Data Input
        testName,               md_templates,               md_soruces,                destFileName,            metaData,               templateBk,                 isCode          = singleData['testName'], singleData['md_templates'],singleData['md_soruces'],singleData['destFileName'],singleData['metaData'],singleData['templateBk'],singleData['isCode']        
        #???print('Reading Template Book...')        
        #Processing
        templateBk = MkscoreUtil.readBkByCols(
                os.path.join(md_templates['path'],md_templates['file']), 
                md_templates['sheets'], 
                md_templates['cols'], 
                1)

        #???print('Reading Source Book...')        
        #   **NEW**    iterate here : src(es)
        pref_sources = md_soruces
        pref_source = pref_sources
        
     
        metaData = {'xlBk':[], 'testName':[],'part' :[], 'colDef':[]}
        for i in range(0,len(pref_sources)):
            pref_source = pref_sources[i] 

            if i == 1:
                metaData['date'] = pref_source['dsname'][0] # one time
                dt = datetime.strptime(metaData['date'], '%d/%m/%Y')
                metaData['date_d'] = dt.strftime('%d-%b')
                metaData['day_name'] = dt.strftime('%a')
                metaData['day_name_full'] = dt.strftime('%A')
            
            metaData['testName'].append(pref_source['dsname'][2])
            metaData['part'].append(pref_source['dsname'][1])
            #First source book
            sourceBk =  MkscoreUtil.readBkByCols(
                    os.path.join(pref_source['path'],pref_source['file']), 
                    [], 
                    pref_source['cols'], 
                    int(pref_source['headerRow']),True)
            metaData['colDef'].append([colName for colName in sourceBk[0]['data'][0]])
            metaData['xlBk'].append(sourceBk)           

        
        dtNow = datetime.now().strftime('%Y%m%d%H%M%S') 
        metaData['part'] = [e[-1] for e in metaData['testName']]       
        destFileName = '{0}-{1}-{2}-{3}-Scores-{4}.xlsx' .format (
            md_templates['testLinkName'],
            metaData['day_name'],
            metaData['date_d'],
            metaData['testName'][0][:-1] + '_'.join(metaData['part']),
            dtNow
            )     
        testName = metaData['testName']
        
        #Data Output
        singleData['testName'], singleData['md_templates'],singleData['md_soruces'],singleData['destFileName'],singleData['metaData'],singleData['templateBk'],singleData['isCode'] = testName, md_templates, md_soruces, destFileName, metaData,templateBk, isCode
        
    @staticmethod
    def readStudentEachTestScore(singleData):
        #Data Input
        testName,               md_templates,               md_soruces,                destFileName,            metaData,               templateBk,                 isCode          = singleData['testName'], singleData['md_templates'],singleData['md_soruces'],singleData['destFileName'],singleData['metaData'],singleData['templateBk'],singleData['isCode']
        #Processing
        '''
            input data:
            (1)
                    []  {}                  []       {}        primitive 
            templateBk Sheet                Rows    Row    key:value
                     [  {name:Batch 1, data:[       {       col:value ....} ....]  } ]
 

            (2)
                    []  {}                  []       {}        primitive 
                srcBk Sheet                Rows    Row    key:value
                     [  {name:Batch 1, data:[       {       col:value ....}} ....]   ]                     

           
        '''
        
        '''
        processing data:
        ************attendance category, remarks category 's FIND "count"            
            ===> (+)
            (1)
                    []  {}                  []       {}        primitive 
            templateBk Sheet                Rows    Row    key:value
                     [  {name:Batch 1, data:[       {       col:value ....
                                                            ??testName: {score:20,attendance:xx,remarks:xx}....
                                                    }                ....
                                            ], 
                     

                            ??testName: {??'Attendance':{'PRESENT':103, ...},??'Remarks:{'ScoreNot':121, ....}}
                            ....
                        }    
                    ]   
            In short 
                in the sheet: (+)
                    Recent: {Attendance:{PRESNT:103...},Remarks:{ScoreNot:123...}}
                    Here, Recent is testName
                in each row: (+)
                    Recent: {score:20,attendance:xx,remarks:xx}
                    Here, Recent is testName

        '''
        testNameParts = metaData['part']
        testNames = testName
        testCount = len(testNames)

        for testI in range(len(testNames)):
            testName = testNames[testI]   
              

            sheetNum = 0
            
            for sheet in templateBk:      
                sheet[testName] = {}
                sheet[testName]['Attendance'] = {}
                sheet[testName]['Remarks'] = {}          
                for row in sheet['data']:
                    matchCol = md_templates['MatchHeading']
                    matchData = row[matchCol]
                    #???print(f'{sheet["name"]}-{matchData} Processing...')
                    
                    xlSheet = metaData['xlBk'][testI][0]
                    colDef = metaData['colDef'][testI]
                    date_d = metaData['date_d'][testI]            
                    #print(colDef, date_d)            
                    testData = MkscoreUtil.ReadDataFromBook(xlSheet, matchData, matchCol, colDef, isCode)#MUTE the SOURCE attendance, remarks, scores 
                    MkscoreUtil.setCountInDict(sheet[testName]['Attendance'],testData['attendance']) #for example 'PRESENT' will become key
                    MkscoreUtil.setCountInDict(sheet[testName]['Remarks'],testData['remarks'])#for example 'Scores cant be displayed' will become key
                    row[testName] = testData
                sheetNum += 1
                
            '''    
            print('-'*40)    
            print(templateBk[3]['data'][:5])    
            print('-'*40)    
            '''

            #list of records with column headings to write into each sheet
            '''
            processing data:
            ************attendance category, remarks category 's FIND "count"            
                ===> (+)
                (1)             
                        []  {}                  []       {}        primitive 
                templateBk Sheet                Rows    Row    key:value
                        [  {name:Batch 1, data:[       {       col:value ....
                                                                Recent: {score:20,attendance:xx,remarks:xx}....
                                                        }                ....
                                                ], 
                        

                            Recent: {'Attendance':{'PRESENT':103, ...},'Remarks:{'ScoreNot':121, ....}} ,
                            ....
                            ??'sheetMatrix' :
                                [
                                    ['S. No.','Name of Student','Dept', 'Score', 'Remarks', 'Attendance'],
                                    [101,       Prabhu,          ECE,    20,     ScoreCant,   PRESENT]...
                                ] 
                            }  
                        ] 
                        In short, sheet we added 'sheetMatrix' key
                            which holds the printable data for the sheet
                            [
                                ['S. No.','Name of Student','Dept', 'Score', 'Remarks', 'Attendance'],
                                [101,       Prabhu,          ECE,    20,     ScoreCant,   PRESENT]...
                            ]

                (3)+
                ==> 
                []      {}       str:int
                dbOne   dbOneData   key:value
                    [   {           ABSENT :0, PRESENT:0,  Good job. Keep it up! : 0,   
                                    Attended test in a Genuine manner : 0   }   ]

            '''

        dbOne = {}
        partHeadings = ['','','']
        for testI in range(len(testNames)): #Initialize Consolidated Report
            testName = testNames[testI]
            testNamePart = testNameParts[testI] 
            partHeadings.extend(['Part ' + testNamePart,'',''])
            dbOne[testName] = []
        
        for sheet in templateBk:
            sheetMatrix = [
                list(partHeadings),
                ['S. No.','Name of Student','Dept']]   

            for testI in range(len(testNames)): #Printable Column Headings
                testName = testNames[testI] 
                colDef = metaData['colDef'][testI]        
                sheetMatrix[1].extend(colDef[-3:])
            
            
                
            for row in sheet['data']:  
                sheetRow = []    
                sheetRow.extend([row['S. No.'],row['Name of Student'],row['Dept']]) #Printable Primitive Columns
                for testI in range(len(testNames)):
                    testName = testNames[testI] 
                    testData = row[testName]                              
                    sheetRow.extend([testData['score'],testData['attendance'],testData['remarks']])   #Printable Scores     
                sheetMatrix.append(sheetRow) #Printable Data in a row

            #Calculate Consolidated Data
            for testI in range(len(testNames)):
                testName = testNames[testI] 
           
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
                dbOne[testName].append(dbOneData)    
                
            sheet['sheetMatrix'] = sheetMatrix
            
        #Printable Consolidated data
        sumHeadings = ['', 'Batch',	'Total',	'Attended',	'Absent',	'Good Scorers',	'Genuine Attender', 	'Just Attended']
        sumTotal = ['','Total',0,0,0,0,0,0]
        sumTitle = ['','','','','','','','']
        dbOneAllMatrix = [ ]

        for testI in range(len(testNames)):
            testName = testNames[testI] 
            testNamePart = testNameParts[testI] 
            dbOneMatrix = [ list(sumHeadings) , list(sumTotal) ]    
            dbOneMatrix[0][1] = 'Part ' + testNamePart
        
            dbOneIndex = 0
            for dbOneRow in dbOne[testName]:    
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
            dbOneAllMatrix.extend(dbOneMatrix)
            dbOneAllMatrix.append(list(sumTitle))
        
        sheetName = 'sheetMatrix'
        fileName = destFileName
        #print(md_soruces['path'][0:-4])
        srcPath = md_soruces[0]['path']
        destPath = os.path.join(srcPath[0:-4],'dest')
        dest_file_name = os.path.join(destPath, fileName)
        #???print(f'{fileName} at {dest_file_name}Exporting...')


        #Writeable XL Book with Sheets and save as excel book file
        bookdict = {}
        for SheetIndex in range(len(templateBk)):
            bookdict[md_templates['sheets'][SheetIndex]] = templateBk[SheetIndex][sheetName]

        bookdict['Consolidated']  =  dbOneAllMatrix  

        pyxl.save_book_as(bookdict=bookdict,  dest_file_name = dest_file_name)

        #???print(f'{fileName}  at {dest_file_name} Exported!')

        #update as job has DONE
        for eSour in md_soruces:
            srcFilePath = os.path.join(srcPath,eSour['file'])
            os.rename(srcFilePath, srcFilePath[0:-4] + '-done.csv')

        MkscoreUtil.openWorkBook(md_templates['formatFile'])
        MkscoreUtil.openWorkBook(dest_file_name)

        #???print('!!!Thank you!!!')   
        #Data Output
        singleData['testName'], singleData['md_templates'],singleData['md_soruces'],singleData['destFileName'],singleData['metaData'],singleData['templateBk'],singleData['isCode'] = testName, md_templates, md_soruces, destFileName, metaData,templateBk, isCode