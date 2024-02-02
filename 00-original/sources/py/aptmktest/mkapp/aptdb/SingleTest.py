import os
import pyexcel as pyxl
from datetime import datetime
from .MkscoreUtil import MkscoreUtil


class SingleTest:
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
        sourceBk =  MkscoreUtil.readBkByCols(
                os.path.join(md_soruces['path'],md_soruces['file']), 
                [], 
                md_soruces['cols'], 
                int(md_soruces['headerRow']),True)

        metaData = {}
        metaData['date'] = md_soruces['dsname'][0] # one time
        dt = datetime.strptime(metaData['date'], '%d/%m/%Y')
        metaData['date_d'] = dt.strftime('%d-%b')
        metaData['day_name'] = dt.strftime('%a')
        metaData['day_name_full'] = dt.strftime('%A')

        testName =  md_soruces['dsname'][2] # one time
        metaData['testName'] = testName
        
        metaData['part'] = md_soruces['dsname'][1]
        metaData['colDef'] = [colName for colName in sourceBk[0]['data'][0]]
        metaData['xlBk'] = sourceBk
                
        
        dtNow = datetime.now().strftime('%Y%m%d%H%M%S')        
        destFileName = '{3}_-_{1}_-_{0}_-_{4}-Scores_-_{2}.xlsx' .format (
                metaData['date_d'], metaData['day_name'],         
                dtNow, md_templates['testLinkName'] ,
                testName
                )     
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
                                                            ??testName: {score:20,attendance:xx,remarks:xx}
                                                    }                ....
                                            ], 
                     

                            ??testName: {??'Attendance':{'PRESENT':103, ...},??'Remarks:{'ScoreNot':121, ....}}
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

        sheetNum = 0
        for sheet in templateBk:
            sheet[testName] = {}
            sheet[testName]['Attendance'] = {}
            sheet[testName]['Remarks'] = {}
            for row in sheet['data']:
                matchData = row[md_templates['MatchHeading']]
                #???print(f'{sheet["name"]}-{matchData} Processing...')
                
                xlSheet = metaData['xlBk'][0]
                colDef = metaData['colDef']
                date_d = metaData['date_d']            
                #print(colDef, date_d)            
                testData = MkscoreUtil.ReadDataFromBook(xlSheet, matchData, md_templates['MatchHeading'], colDef, isCode)#MUTE the SOURCE attendance, remarks, scores 
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
                                                            Recent: {score:20,attendance:xx,remarks:xx}
                                                    }                ....
                                            ], 
                     

                          Recent: {'Attendance':{'PRESENT':103, ...},'Remarks:{'ScoreNot':121, ....}} ,
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
        #???print(f'{fileName} at {dest_file_name}Exporting...')
        bookdict = {}
        for SheetIndex in range(len(templateBk)):
            bookdict[md_templates['sheets'][SheetIndex]] = templateBk[SheetIndex][sheetName]
        bookdict['Consolidated']  =  dbOneMatrix  
        pyxl.save_book_as(bookdict=bookdict,  dest_file_name = dest_file_name)

        #???print(f'{fileName}  at {dest_file_name} Exported!')

        srcFilePath = os.path.join(md_soruces['path'],md_soruces['file'])
        os.rename(srcFilePath, srcFilePath[0:-4] + '-done.csv')


        MkscoreUtil.openWorkBook(md_templates['formatFile'])
        MkscoreUtil.openWorkBook(dest_file_name)


        #???print('!!!Thank you!!!')   
        #Data Output
        singleData['testName'], singleData['md_templates'],singleData['md_soruces'],singleData['destFileName'],singleData['metaData'],singleData['templateBk'],singleData['isCode'] = testName, md_templates, md_soruces, destFileName, metaData,templateBk, isCode