import docx
import pandas as pd
import os
import io
import os.path

import random
import string

import mysql.connector

from Captions import Captions

class PickCodeQnToDb:    
    hasPrefix = True
    @classmethod
    def getIntroText(cls,question_count,time_limit, max_runs=3):       
        prefix = Captions.PickCodeQnToDb_getIntroText_prefix#!  
        intro_text = Captions.PickCodeQnToDb_getIntroText_intro_text%(question_count,time_limit,max_runs)#!  
        #intro_text += '\n<p>\n9. There are four sections. Finish all the four sections.\n</p>'
        print(intro_text)
        return (prefix if PickCodeQnToDb.hasPrefix else '') + intro_text


    @classmethod
    def getSrcCon(cls,database):
        mydb = mysql.connector.connect(host = 'localhost', 	user = 'root', database = database)
        return mydb
    @classmethod
    def getToCon(cls,database):
        mydb = mysql.connector.connect(host = 'localhost', 	user = 'root', database = database)
        return mydb
    @classmethod
    def queryQs(cls,mydb, qn_id, maxTestCases, scorePerTestCase):
        mycursor = mydb.cursor()	

        sqlQn 	= r'''SELECT qn.code_title, qn.code_question, qn.lang_code, qn.level_no, qn.tested_program 
    FROM tcode_q_base qn
    WHERE qn.question_id=%s'''
        valQn = (qn_id,)        
        mycursor.execute(sqlQn, valQn) 	
        myresult = mycursor.fetchall()        

        qn=dict()
        lang = dict()
        level = dict()
        testCases = []
        recQn = myresult[0]            
        qn['code_title'],qn['code_question'],qn['lang_code'],qn['level_no'],qn['tested_program']=recQn[0],recQn[1],recQn[2],recQn[3],recQn[4]

        sqlLang 	= r'''SELECT lang_code, full_name, api_lang_name, api_version_no, default_program
    FROM tcode_language lang
    WHERE lang.lang_code=%s'''
        valLang = (qn['lang_code'],)        
        mycursor.execute(sqlLang, valLang) 	
        myresult = mycursor.fetchall()

        recLang = myresult[0]            
        lang['lang_code'],lang['full_name'],lang['api_lang_name'],lang['api_version_no'],lang['default_program']=recLang[0],recLang[1],recLang[2],recLang[3],recLang[4]
        
        sqlLevel 	= r'''SELECT level_no, level_name
    FROM tcode_level level
    WHERE level.level_no=%s'''
        valLevel = (qn['level_no'],)        
        mycursor.execute(sqlLevel, valLevel) 	
        myresult = mycursor.fetchall()

        recLevel = myresult[0]            
        level['level_no'],level['level_name']=recLevel[0],recLevel[1]
        
        sqlTc 	= r'''SELECT testcase_id, question_id, input, output, point, sno, is_active
    FROM tcode_q_testcase tc
    WHERE tc.question_id=%s'''
        valTc = (qn_id,)        
        mycursor.execute(sqlTc, valTc) 	
        myresult = mycursor.fetchall()
        recTcI = 0
        for recTc in myresult:
            recTcI+=1
            if recTcI > maxTestCases:
                break
            tc = dict()
            tc['input'], tc['output'], tc['point'], tc['sno'], tc['is_active'] = recTc[2], recTc[3], scorePerTestCase, recTcI, 1
            testCases.append(tc)
        return {'qn':qn,'lang':lang,'level':level,'testCases':testCases}
    @classmethod
    def sqlInsert(cls,mycursor,sql, val):
        mycursor.execute(sql, val) 	
        db_id=mycursor.lastrowid
        return db_id
    @classmethod
    def sqlInsertOnly(cls,mycursor,sql, val):
        mycursor.execute(sql, val) 	
    @classmethod
    def sqlInsertIfNotExists(cls,mycursor,sql, val, condSql, condVal):
        mycursor.execute(condSql, condVal) 
        myresult = mycursor.fetchall()
        if len(myresult) == 0:
            mycursor.execute(sql, val)     
    @classmethod
    def writeToCon(cls,mydb,TestData):
        
        sqlLang = "INSERT INTO tcode_language (lang_code, full_name, api_lang_name, api_version_no, default_program) VALUES (%s,%s,%s,%s,%s)"
        sqlLangCond = "SELECT lang_code, full_name, api_lang_name, api_version_no, default_program FROM tcode_language WHERE lang_code=%s"
        sqlLevel  = "INSERT INTO tcode_level (level_no, level_name) VALUES (%s,%s)"
        sqlLevelCond = "SELECT level_no, level_name FROM tcode_level WHERE level_no=%s"
        sqlQn = "INSERT INTO tcode_q_base (code_title, code_question, lang_code, level_no, tested_program) VALUES (%s,%s,%s,%s,%s)"
        sqlTestCase = "INSERT INTO tcode_q_testcase (question_id, input, output, point, sno, is_active) VALUES (%s,%s,%s,%s,%s,%s)"
        sqlGroup = "INSERT INTO tcode_q_group_base (group_name) VALUES (%s)"
        sqlGroupQn = "INSERT INTO tcode_q_group_q (group_id, question_id) VALUES (%s,%s)"
        sqlAssessment = "INSERT INTO tcode_assess_base (assignment_name, group_id, total_q, total_score, total_duration, duration_per, max_submissions, is_to_suffle_q, assignment_status, instructions, max_runs) VALUES (%s,%s,%s,%s,%s,99,1,0,0,%s,%s)"


        mycursor = mydb.cursor()

        test_name, qn_count, time_limit, qnSet, max_runs = TestData['test_name'], TestData['qn_count'], TestData['time_limit'], TestData['pick_list'], TestData['max_runs']
        intro_text = PickCodeQnToDb.getIntroText(TestData['qn_count'],TestData['time_limit'],max_runs)
        print(f'\n\n*************\n{intro_text}\n*******************\n\n')
        input('Yes?')
        msg = ''
        print(test_name, qn_count, time_limit, sep="\n")
        totalScore = 0
        ids=[]
        group_id = PickCodeQnToDb.sqlInsert(mycursor,sqlGroup,(test_name,))
        ids.append(group_id)
        for el in qnSet:
            qnRes = el['qnRes']
            qn, level, lang, testCases = qnRes['qn'],                qnRes['level'],                qnRes['lang'],                qnRes['testCases']
            print(qn, level, lang, testCases, sep="\n\n")
            PickCodeQnToDb.sqlInsertIfNotExists(mycursor,sqlLang,(lang['lang_code'],lang['full_name'],lang['api_lang_name'],lang['api_version_no'],lang['default_program'],),sqlLangCond, (lang['lang_code'],))            
            PickCodeQnToDb.sqlInsertIfNotExists(mycursor,sqlLevel,(level['level_no'],level['level_name'],),sqlLevelCond, (level['level_no'],))
            qn_id = PickCodeQnToDb.sqlInsert(mycursor,sqlQn,(qn['code_title'],qn['code_question'],qn['lang_code'],qn['level_no'],qn['tested_program'],))
            qn['qn_id'] = qn_id
            ids.append(qn_id)
            for eCase in testCases:
                case_id = PickCodeQnToDb.sqlInsert(mycursor,sqlTestCase,(qn_id,eCase['input'],eCase['output'],eCase['point'],eCase['sno'],eCase['is_active'],))
                eCase['qn_id'] = qn_id
                eCase['case_id'] = case_id
                totalScore += int(eCase['point'])
                ids.append(case_id)
            PickCodeQnToDb.sqlInsertOnly(mycursor,sqlGroupQn,(group_id,qn_id,))
        assess_id = PickCodeQnToDb.sqlInsert(mycursor,sqlAssessment,(test_name,group_id,qn_count,totalScore,time_limit,intro_text,max_runs,))
        TestData['assess_id'] = assess_id
        mydb.commit() 
        ids.append(assess_id)
        print(f'{test_name} has score {totalScore}')    
        print(ids)


    @classmethod
    def DoOneQn(cls, TestData, fromDb, toDb):#{'qn': '6', 'numOfTestCases': 3, 'scorePerTestCase': 10, 'testCases': []}
        qns = []
        #print(TestData)
        for el in TestData['pick_list']:
            #print(el)
            #print('******Bef\n',len(el['qns']),'\n********')
            qnRes = PickCodeQnToDb.queryQs(PickCodeQnToDb.getSrcCon(fromDb),el['qn'],el['numOfTestCases'],el['scorePerTestCase'])
            el['qnRes'] = qnRes
            qns.append(qnRes)
            #el['qns'] = PickCodeQnToDb.queryQs(PickCodeQnToDb.getSrcCon(fromDb),el['qn'],el['numOfTestCases'],el['scorePerTestCase']);print(len(el['qns']),end=',')
            #print('******Aft\n',len(el['qns']),'\n********')
        #TestData['qns'] = qns
        #print(TestData, len(TestData['pick_list']),end='\n')
        #input('Are you sure to continue?')
        PickCodeQnToDb.writeToCon(PickCodeQnToDb.getToCon(toDb),TestData)	
    @classmethod
    def DoAllPaper(cls, pHasPrefix, fromDb, toDb, ArTestData):
        PickCodeQnToDb.hasPrefix = pHasPrefix
        #for TesDat in ArTestData:
        #    print('******Mmmm\n',TesDat,'\n********')
        for TesDat in ArTestData:
            #print(TesDat)
            PickCodeQnToDb.DoOneQn(TesDat,fromDb,toDb)
    
    @classmethod
    def DoByPref(cls,hasBrandInInstruction, fromDatabase, toDatabase, testPaper):  
        #print(testPaper)
        PickCodeQnToDb.DoAllPaper(hasBrandInInstruction, fromDatabase, toDatabase, testPaper)
