import docx
import pandas as pd
import os
import io
import os.path

import random
import string

import mysql.connector

from Captions import Captions

class PickToDb:    
    hasPrefix = True
    @classmethod
    def getIntroText(cls,question_count,time_limit):       
        prefix = Captions.PickToDb_getIntroText_prefix#!  
        intro_text = Captions.PickToDb_getIntroText_intro_text%(question_count,time_limit)#!  
        #intro_text += '\n<p>\n9. There are four sections. Finish all the four sections.\n</p>'
        #print(intro_text)
        return (prefix if PickToDb.hasPrefix else '') + intro_text


    @classmethod
    def getSrcCon(cls,database):
        mydb = mysql.connector.connect(host = 'localhost', 	user = 'root', database = database)
        return mydb
    @classmethod
    def getToCon(cls,database):
        mydb = mysql.connector.connect(host = 'localhost', 	user = 'root', database = database)
        return mydb
    @classmethod
    def queryQs(cls,mydb, quiz_name):
        sqlQn 	= r'''SELECT qn.quiz_id,qn.id question_id,qn.question_text,
        CONCAT('[',GROUP_CONCAT(CONCAT('{"id":',qo.id,',"option":"', replace(qo.answer_text,'"','\\"'),'","is_correct":', qo.correct_answer,'}')),']') options
    FROM quizzes qz INNER JOIN 
        questions qn ON(qz.id = qn.quiz_id) INNER JOIN
        question_groups qg ON(qn.id=qg.question_id) INNER JOIN
        answers qo ON (qg.id=qo.group_id)
    WHERE qn.parent_id=0 AND qz.quiz_name=%s
    GROUP BY qn.id'''
        valQn = (quiz_name,)

        mycursor = mydb.cursor()	
        mycursor.execute(sqlQn, valQn) 	
        myresult = mycursor.fetchall()
        i,qns = 1,[]
        for rec in myresult:
            qn=dict()
            #print(rec);		
            rec3 = ''
            try:
                rec3 = eval(rec[3])
            except:
                rec3 = [rec[3],'Err','Err','Err','Err']
            qn['sno'],qn['question_id'],qn['question_text'],qn['options']=i,rec[1],rec[2],rec3
            qns.append(qn)
            i+=1
        return qns
    @classmethod
    def writeToCon(cls,mydb,TestData):
        intro_text = PickToDb.getIntroText(TestData['qn_count'],TestData['time_limit'])
        msg = ''
        sqlCat 	= "INSERT INTO cats (cat_name) VALUES (%s)"
        sqlQuiz = "INSERT INTO quizzes (cat_id, quiz_name, quiz_desc, added_date, parent_id, show_intro, intro_text) VALUES (%s,%s, %s,now(),0,1,%s)"
        sqlQn 	= "INSERT INTO questions(question_text, question_type_id, priority, quiz_id, point, added_date, parent_id, header_text, footer_text) VALUES (%s,1,%s,%s,1,now(),0,'','')"
        sqlGrp 	= "INSERT INTO question_groups (group_name, show_header, group_total, question_id, parent_id, added_date) VALUES ('',0,0,%s,0,now())"	
        sqlOpt 	= "INSERT INTO answers (group_id, answer_text, correct_answer, priority, correct_answer_text, answer_pos, parent_id, control_type, answer_parent_id) VALUES (%s,%s,%s,0,'',0,0,1,0)"
        mycursor = mydb.cursor()

        valCat = (TestData['test_name'],)
        mycursor.execute(sqlCat, valCat) 	
        dbcat_id=mycursor.lastrowid
        valQuiz = (dbcat_id,TestData['test_name'],TestData['test_name'],intro_text)
        mycursor.execute(sqlQuiz, valQuiz)
        dbquiz_id=mycursor.lastrowid
        ids = [dbcat_id,dbquiz_id,[]]
        K=1
        for el in TestData['pick_list']:
            for I in range(el['from']-1,el['to']):
                qn = el['qns'][I]
                valQn = (qn['question_text'],K,dbquiz_id) #sno,q,opta,optb,optc,optd,opte,optcount,optans
                mycursor.execute(sqlQn, valQn)
                K=K+1
                dbqn_id=mycursor.lastrowid
                valGrp = (dbqn_id,)
                mycursor.execute(sqlGrp, valGrp)
                dbgrp_id=mycursor.lastrowid
                Opts,OptCorAnss=[],[]
                for elOpt in qn['options']:
                    Opts.append(elOpt['option'])
                    OptCorAnss.append(elOpt['is_correct'])
                OptIds =[]
                for J in range(len(Opts)):
                    valOpt = (dbgrp_id,Opts[J],OptCorAnss[J])
                    mycursor.execute(sqlOpt, valOpt)
                    dbans_id=mycursor.lastrowid		
                    OptIds.append(dbans_id)
                ids[2].append([dbqn_id,dbgrp_id,OptIds])
            mydb.commit() 
        print(ids)
    @classmethod
    def DoOneQn(cls, TestData, fromDb, toDb):
        for el in TestData['pick_list']:
            #print('******Bef\n',len(el['qns']),'\n********')
            el['qns'] = PickToDb.queryQs(PickToDb.getSrcCon(fromDb),el['tp']);print(len(el['qns']),end=',')
            #print('******Aft\n',len(el['qns']),'\n********')
        PickToDb.writeToCon(PickToDb.getToCon(toDb),TestData)	
    @classmethod
    def DoAllPaper(cls, pHasPrefix, fromDb, toDb, ArTestData):
        PickToDb.hasPrefix = pHasPrefix
        #for TesDat in ArTestData:
        #    print('******Mmmm\n',TesDat,'\n********')
        for TesDat in ArTestData:
            PickToDb.DoOneQn(TesDat,fromDb,toDb)

    @classmethod
    def Do(cls): 
        caption_pHasPrefix = Captions.PickToDb_Do_caption_pHasPrefix#!  
        caption_fromDb = Captions.PickToDb_Do_caption_fromDb#!  
        caption_toDb = Captions.PickToDb_Do_caption_toDb#!      
        caption_testPaperName = Captions.PickToDb_Do_caption_testPaperName#!      
        caption_QnFrom = Captions.PickToDb_Do_caption_QnFrom#!  
        caption_QnTo = Captions.PickToDb_Do_caption_QnTo#!  
        caption_askPaper = Captions.PickToDb_Do_caption_askPaper#!  
        caption_askMoreTest = Captions.PickToDb_Do_caption_askMoreTest#!  
        caption_toPaperName = Captions.PickToDb_Do_caption_toPaperName#!  
        caption_QnsCount = Captions.PickToDb_Do_caption_QnsCount#!  
        caption_TimeDuration = Captions.PickToDb_Do_caption_TimeDuration#!  

        pHasPrefix = input(caption_pHasPrefix)=='y'
        fromDb = input(caption_fromDb)
        toDb = input(caption_toDb)
        ArTestData = []
        askMoreTest = True
        while(askMoreTest):            
            pick_list = []
            askPaper = True
            while(askPaper):
                testPaperName = input(caption_testPaperName)
                QnFrom = int(input(caption_QnFrom))
                QnTo = int(input(caption_QnTo))
                pick_list.append({'tp':testPaperName,'from':QnFrom,'to':QnTo,'qns':[]})
                askPaper = input(caption_askPaper)=='y'
            toPaperName = input(caption_toPaperName)
            QnsCount = int(input(caption_QnsCount))
            TimeDuration = int(input(caption_TimeDuration))
            ArTestData.append({'pick_list': pick_list, 'test_name': toPaperName, 'qn_count': QnsCount, 'time_limit': TimeDuration})
            askMoreTest = input(caption_askMoreTest)=='y' 
        print({'pHasPrefix':pHasPrefix, 'fromDb':fromDb, 'toDb':toDb, 'ArTestData':ArTestData})       
        PickToDb.DoAllPaper(pHasPrefix, fromDb, toDb, ArTestData)    
    @classmethod
    def DoByPickListString(cls):
        #'430',1,30|'431',1,30->'Test Assessment #001',30,50
        #PickToDb.DoAllPaper(pHasPrefix, fromDb, toDb, ArTestData)        
        caption_LineStr = Captions.PickToDb_DoByPickListString_caption_LineStr#!
        Tests = []
        TestsDict = []
        Lines = []
        LineStr = input(caption_LineStr)
        while(LineStr != ''):            
            SrcDest = LineStr.split('!')            
            Src = SrcDest[0].split('|')
            SrcDict = []
            for e in Src:
                eParts = e.split(',')
                SrcDict.append({'tp':eParts[0],'from':int(eParts[1]),'to':int(eParts[2]),'qns':[]})
            eParts = SrcDest[1].split(',')
            TestsDict.append({'pick_list': SrcDict, 'test_name': eParts[0], 'qn_count': int(eParts[1]), 'time_limit': int(eParts[2])})
            Tests.append({'Src':Src,'Dest':SrcDest[1]})
            Lines.append(LineStr)
            LineStr = input('')
        print(TestsDict)
        caption_pHasPrefix = Captions.PickToDb_Do_caption_pHasPrefix#!  
        caption_fromDb = Captions.PickToDb_Do_caption_fromDb#!  
        caption_toDb = Captions.PickToDb_Do_caption_toDb#!   
        pHasPrefix = input(caption_pHasPrefix)=='y'
        fromDb = input(caption_fromDb)
        toDb = input(caption_toDb)           
        PickToDb.DoAllPaper(pHasPrefix, fromDb, toDb, TestsDict)
    @classmethod
    def DoByPref(cls,hasBrandInInstruction, fromDatabase, toDatabase, testPaper):  
        PickToDb.DoAllPaper(hasBrandInInstruction, fromDatabase, toDatabase, testPaper)
