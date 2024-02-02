import pyexcel as pyxl
import os
import sys
from datetime import datetime
import mysql.connector


#print(config)
#if config == None:
#    sys.exit('Job File is not defined')
"""
fileName = r'''F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\datafiles\273-210711-uploadcodeqn-C-1'''
fileName = fileName + r'''\1Question.xlsx'''
if input('Are you sure to do job? Say (y/n):') != 'y':
    sys.exit('You will do the job later!\nSee you!!!')
"""
class CodeQnMake:    
    databaseName = '' 
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
        colNumsInList = CodeQnMake.colNamesIntoNumbers(colNames)
        sheets = CodeQnMake.readXlBk(fileName, sheetList, headerRowNum, colNumsInList,ignoringSheetName)
        return sheets

    @classmethod 
    def getConV1(cls):
        mydb = mysql.connector.connect(host = 'localhost', 	user = 'root', database = CodeQnMake.databaseName)#t20apt01apple
        return mydb
    @classmethod
    def writeQn(cls,Qn):        
        print(f'***********************Qn {Qn["Sno"]}************************')
        for col in Qn:
            print(f'{col} : {Qn[col]}')
            
        input(f'Qn {Qn["Sno"]} - Shall I Insert?')
        mydb = CodeQnMake.getConV1()
        msg = ''
        sqlQn 	= "INSERT INTO tcode_q_base (code_title, code_question, lang_code, level_no, tested_program) VALUES (%s,%s,%s,%s,%s)"
        sqlTC = "INSERT INTO tcode_q_testcase (question_id, input, output, point, sno, is_active) VALUES (%s,%s, %s,10,%s,1)"
        mycursor = mydb.cursor()        
        mycursor.execute(sqlQn, (Qn['Title'],Qn['Problem'],Qn['Lang'],Qn['Level'],Qn['Code'],)) 	
        qn_id=mycursor.lastrowid
        mycursor.execute(sqlTC, (qn_id,Qn['Input1'],Qn['Output1'],1));tc1_id = mycursor.lastrowid
        mycursor.execute(sqlTC, (qn_id,Qn['Input2'],Qn['Output2'],2));tc2_id = mycursor.lastrowid
        mycursor.execute(sqlTC, (qn_id,Qn['Input3'],Qn['Output3'],3));tc3_id = mycursor.lastrowid
        mycursor.execute(sqlTC, (qn_id,Qn['Input4'],Qn['Output4'],4));tc4_id = mycursor.lastrowid
        mycursor.execute(sqlTC, (qn_id,Qn['Input5'],Qn['Output5'],5));tc5_id = mycursor.lastrowid
        ids = [qn_id,tc1_id,tc2_id,tc3_id,tc4_id,tc5_id,]
        print(ids)
        
        mydb.commit() 
        
    @staticmethod
    def test_readXlBook(fileName, sheetList=[], colNames=''):
        '''
        test_readXlBook(
            os.path.join(md_templates['path'],md_templates['file']), 
            md_templates['sheets'], 
            md_templates['cols'])'
        '''
        sheets =  CodeQnMake.readBkByCols(fileName, sheetList=sheetList, colNames=colNames)
        print(len(sheets))
        for sheet in sheets:            
            print(sheet['name'], len(sheet['data']), sheet['data'][0],sep='\n',end='\n\n\n\n')
            for row in sheet['data']:
                print(f'''\n\n***********           ***********                 ***********''')
                for col in row:
                    print(f'{col} : {row[col]}')
    @classmethod
    def CodeQnMakeCaller(cls, qnFilePath, toDatabase):
        CodeQnMake.databaseName = toDatabase
        sheetList=['Qns']
        colNames='A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q'
        sheets =  CodeQnMake.readBkByCols(qnFilePath, sheetList=sheetList, colNames=colNames)
        for sheet in sheets: 
            for row in sheet['data']:                
                CodeQnMake.writeQn(row)
