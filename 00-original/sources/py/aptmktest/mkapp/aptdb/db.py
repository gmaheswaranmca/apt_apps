import mysql.connector

class config:
    host = 'localhost'
    user = 'root'
    database = 't20apt00'

class aptdb:
    @staticmethod
    def queryQs(qn_id, maxTestCases, scorePerTestCase):
            mydb = mysql.connector.connect(host = config.host,user = config.user, database = config.database)
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