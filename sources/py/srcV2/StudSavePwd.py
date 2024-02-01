import docx
import pandas as pd
import os
import io
import os.path

import random
import string

import mysql.connector

from Captions import Captions

class StudSavePwd:
    databaseName = 'aptonlinefour'

    @classmethod
    def getCon(cls):
        '''caption_databaseName = Captions.StudSavePwd_getCon_caption_databaseName#!
        StudSavePwd.databaseName = input(caption_databaseName)'''
        mydb = mysql.connector.connect(host = 'localhost', 	user = 'root', database = StudSavePwd.databaseName)#aptonlineone, aptonlinetwo, aptonlinethree, aptonlinefour, aptonlinefive
        return mydb

    @classmethod    
    def saveUser(cls,df,srcFieldsPos):
        msg=''
        mydb = StudSavePwd.getCon()
        mycursor = mydb.cursor()
        for index, row in df.iterrows():
            aboutUser = row[srcFieldsPos[2]] + '-' + row[srcFieldsPos[0]]  + '-' + row[srcFieldsPos[1]]
            mycursor.execute("SELECT UserName FROM users WHERE UserName=%s",(row[srcFieldsPos[0]].strip(),))
            myresult = mycursor.fetchall()
            isThere = False 
            for x in myresult:
                isThere = True
                break
            msg += aboutUser
            if isThere:
                sql = "UPDATE users SET Password=md5(%s), Name=%s WHERE UserName=%s"
                val = (row[srcFieldsPos[1]].strip(),row[srcFieldsPos[2]].strip(),row[srcFieldsPos[0]].strip())   
                msg += ' Updated! '
            else:
                sql = "INSERT INTO users(UserName, Name, Password) VALUES (%s,%s,md5(%s))"
                val = (row[srcFieldsPos[0]].strip(),row[srcFieldsPos[2]].strip(),row[srcFieldsPos[1]].strip())     
                msg += ' Added! '
            #print(aboutUser,end=" | ")
            mycursor.execute(sql, val) 	
        mydb.commit() 	
        print("\n" + msg)
    @classmethod    
    def makeTest(cls,df,srcFieldsPos, testPaper, codeQn):
        msg=''
        mydb = StudSavePwd.getCon()
        mycursor = mydb.cursor()
        for TestData in testPaper:
            test_name = TestData['test_name']
            qn_count, time_limit= TestData['qn_count'],TestData['time_limit']
            mycursor.execute("SELECT id quiz_id FROM quizzes WHERE quiz_name=%s",(test_name.strip(),))
            myresultquiz = mycursor.fetchall()            
            quiz_id = str(myresultquiz[0][0]) #quiz_id

            sql = '''INSERT INTO assignments
(quiz_id, org_quiz_id, results_mode, 
added_date, quiz_time, show_results, 
pass_score, quiz_type, status) VALUES (%s,%s,1,
now(),%s,1,
%s,1,0)'''
            val = (quiz_id,quiz_id,time_limit,qn_count)               
            mycursor.execute(sql, val)
            dbassignments_id=str(mycursor.lastrowid)

            msg += '\nTest [%s](%s,%s,%s)|Quiz=%s|Users:' %(dbassignments_id, test_name,qn_count,time_limit,quiz_id)
            for index, row in df.iterrows():
                aboutUser = row[srcFieldsPos[2]] + '-' + row[srcFieldsPos[0]]  + '-' + row[srcFieldsPos[1]]
                mycursor.execute("SELECT UserID user_id FROM users WHERE UserName=%s",(row[srcFieldsPos[0]].strip(),))
                myresultusers = mycursor.fetchall()
                user_id = str(myresultusers[0][0]) #'user_id'
                
                sql = "INSERT INTO assignment_users(assignment_id, user_type, user_id) VALUES (%s,%s,%s)"
                val = (dbassignments_id, 1, user_id)   
                mycursor.execute(sql, val)   
                dbassignment_users_id=str(mycursor.lastrowid)
                msg += '[' + dbassignment_users_id + ']' + user_id + ','
                #print(aboutUser,end=" | ")
            msg += '\n'    

        for TestData in codeQn:
            assess_id = TestData['assess_id']    
            
            for index, row in df.iterrows():
                aboutUser = row[srcFieldsPos[2]] + '-' + row[srcFieldsPos[0]]  + '-' + row[srcFieldsPos[1]]
                mycursor.execute("SELECT UserID user_id FROM users WHERE UserName=%s",(row[srcFieldsPos[0]].strip(),))
                myresultusers = mycursor.fetchall()
                user_id = str(myresultusers[0][0]) #'user_id'
                
                sql = "INSERT INTO tcode_assess_user(assess_id, user_id, user_ass_status, user_secure_score) VALUES (%s,%s,0,0)"
                val = (assess_id, user_id)   
                mycursor.execute(sql, val)   
                dbassignment_users_id=str(mycursor.lastrowid)
                msg += '[' + dbassignment_users_id + ']' + user_id + ','
                #print(aboutUser,end=" | ")
            msg += '\n'    
	
        mydb.commit() 	
        print("\n" + msg)

    @classmethod
    def cleanDb(cls,IsQuiz,IsAssignment,IsUser):	
        scriptCleanQuiz = Captions.StudSavePwd_scriptCleanQuiz_scriptCleanQuiz#!
        scriptCleanAssignment = Captions.StudSavePwd_scriptCleanQuiz_scriptCleanAssignment#!
        scriptCleanUser = Captions.StudSavePwd_scriptCleanQuiz_scriptCleanUser#!
        scriptAll = ''
        if IsQuiz:
            scriptAll += scriptCleanQuiz
        if IsAssignment:
            scriptAll += scriptCleanAssignment
        if IsUser:
            scriptAll += scriptCleanUser
        print(scriptAll)
        lsEach = scriptAll.split('\n')
        print(lsEach)
        mydb = StudSavePwd.getCon()
        mycursor = mydb.cursor()
        for st in lsEach:
            if st.strip()!='':
                print(st,end=" ")
                mycursor.execute(st)
                print("Done!")
        mydb.commit()

    @classmethod
    def writeToDb(cls,df):
        mydb = StudSavePwd.getCon()

    @classmethod
    def opt01(cls):
        '''caption_option = Captions.StudSavePwd_opt01_caption_option#!        
        option = int(input(caption_option))'''
        option = 6
        IsQuiz,IsAssignment,IsUser = False, False, False
        if option == 1:
            IsQuiz,IsAssignment,IsUser = True,False,False
            StudSavePwd.cleanDb(IsQuiz,IsAssignment,IsUser)
        elif option == 2:
            IsQuiz,IsAssignment,IsUser = False,True,False
            StudSavePwd.cleanDb(IsQuiz,IsAssignment,IsUser)
        elif option == 3:
            IsQuiz,IsAssignment,IsUser = False,False,True
            StudSavePwd.cleanDb(IsQuiz,IsAssignment,IsUser)
        elif option == 4:
            IsQuiz,IsAssignment,IsUser = True,True,False
            StudSavePwd.cleanDb(IsQuiz,IsAssignment,IsUser)
        elif option == 5:
            IsQuiz,IsAssignment,IsUser = True,True,True
            StudSavePwd.cleanDb(IsQuiz,IsAssignment,IsUser)

    @classmethod
    def opt02caller(cls, databaseName, srcFilePathManager, srcFilePathStudent): 
        StudSavePwd.databaseName = databaseName

        FieldsPosStr = '2,3,1'.split(',') #input('"UserName","Password","Name" Pos:').split(",")
        srcFieldsCount = 4
        srcFieldsPos = [int(e.strip()) for e in FieldsPosStr]#[2,3,1]
        print(srcFieldsPos)

        df = pd.read_csv(srcFilePathManager)
        print(df.head())
        print(df.tail())        

        StudSavePwd.saveUser(df,srcFieldsPos)

        df = pd.read_csv(srcFilePathStudent)
        print(df.head())
        print(df.tail())

        StudSavePwd.saveUser(df,srcFieldsPos)
    @classmethod
    def opt02maketest(cls, databaseName, srcFilePathManager, srcFilePathStudent, testPaper, codeQn): 
        StudSavePwd.databaseName = databaseName

        FieldsPosStr = '2,3,1'.split(',') #input('"UserName","Password","Name" Pos:').split(",")
        srcFieldsCount = 4
        srcFieldsPos = [int(e.strip()) for e in FieldsPosStr]#[2,3,1]
        print(srcFieldsPos)

        df = pd.read_csv(srcFilePathManager)
        print(df.head())
        print(df.tail())        

        StudSavePwd.makeTest(df,srcFieldsPos,testPaper, codeQn)

        df = pd.read_csv(srcFilePathStudent)
        print(df.head())
        print(df.tail())

        StudSavePwd.makeTest(df,srcFieldsPos,testPaper, codeQn)
    @classmethod
    def opt02(cls): 
        caption_srcPath = Captions.StudSavePwd_caption_srcPath_caption_srcPath#! 
        caption_srcDateStr = Captions.StudSavePwd_caption_srcPath_caption_srcDateStr#! 
        caption_srcLinkName = Captions.StudSavePwd_caption_srcPath_caption_srcLinkName#! 
        srcPath = input(caption_srcPath)
        srcDateStr = input(caption_srcDateStr) #input('Date Option:')#'200728'
        srcLinkName = input(caption_srcLinkName) #input('Link Plus Option:') #'appleDemo'
        
        

        srcFilePath = srcPath + '/' + srcDateStr + '-' + srcLinkName + '.csv'
        dbFieldNames = ["UserName","Password","Name"]

        

        df = pd.read_csv(srcFilePath)
        print(df.head())
        print(df.tail())

        #StudSavePwd.saveUser(df,srcFieldsPos)

    @classmethod
    def do(cls): 
        '''caption_databaseName = Captions.StudSavePwd_getCon_caption_databaseName#!
        StudSavePwd.databaseName = input(caption_databaseName)'''
        
        caption_option = Captions.StudSavePwd_do_caption_option#!
        option = int(input(caption_option))
        while option==1 or option==2:
            if option == 1:
                StudSavePwd.opt01()
            elif option == 2:
                StudSavePwd.opt02()
            elif option == 3:
                pass
            option = int(input(caption_option)) 