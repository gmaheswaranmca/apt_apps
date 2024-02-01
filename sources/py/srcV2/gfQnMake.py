import docx
import pandas as pd
import os
import io
import os.path

import random
import string

import mysql.connector

from Captions import Captions

class gfQnMake:
    databaseName = '' 
    @classmethod
    def DoEsc(cls,txt,Chrs,ChrsRe):#HtmlEsc
        for I in range(len(Chrs)):
            txt = txt.replace(Chrs[I],ChrsRe[I])
        return txt
    @classmethod
    def QnTagEsc(cls,txt):
        Chrs = ['~uc:','~uo:','~bo:','~ubo:','~sp:']    
        ChrsRe = ['</span>','<span style="text-decoration:underline;">','<span style="font-weight:bold;">','<span style="text-decoration:underline;font-weight:bold;">','&nbsp;']
        return gfQnMake.DoEsc(txt,Chrs,ChrsRe)
    @classmethod
    def QnEsc(cls,txt):
        Chrs = ['“','”','‘','’','½','¼','°','√','¼']    
        ChrsRe = ['&ldquo;','&rdquo;','&lsquo;','&rsquo;','&frac12;','&frac14;','&deg;','&radic;','&frac34;']
        txt = gfQnMake.QnTagEsc(txt)
        txt = gfQnMake.DoEsc(txt, Chrs, ChrsRe)
        #print(txt)
        return txt
    @classmethod
    def OptEsc(cls,txt):
        Chrs   = ['“' ,'”'       ,'‘'  ,'’'  ,'½' ,'¼' ,'°' ,'√'  ]    	
        ChrsRe  = ['"' ,'"'       ,'\''  ,'\''  ,'(1/2)' ,'(1/4)' ,'&deg;' ,'&radic;'  ]    	
        #ChrsRe = ['"','"',r''˜    ,'â€™','Â½','Â¼','Â¼','Â°','âˆš']
        #ChrsRe = ['â€œ','â€','â€˜','â€™','Â½','Â¼','Â¼','Â°','âˆš']
        #QPRS  = ['â€œ','â€','â€˜','â€™','Â½','Â¼','Â¼','Â°','âˆš']
        return gfQnMake.DoEsc(txt,Chrs,ChrsRe)
    @classmethod
    def parseQnText(cls,QnText,Code):
        LsQnTxt = QnText.splitlines()
        LsCode = Code.splitlines()
        ResQn = ''
        if len(LsQnTxt)>0 and len(LsCode)>0 and len(LsQnTxt)==len(LsCode):		
            PreCodeLine = ''
            for I in range(len(LsQnTxt)):
                QnLine = LsQnTxt[I]
                CodeLine = LsCode[I] 
                style = 'margin-bottom:7px;'
                if 'N' in CodeLine:
                    style += 'font-weight:normal;'
                elif 'B' in CodeLine:
                    style += 'font-weight:bold;'
                if 'J' in CodeLine:
                    style += 'text-align:justify;'
                if 'P' in CodeLine:
                    style += 'text-indent:0.5in;'
                
                if 'L' in CodeLine:
                    QnLine = '<li style="list-style-type:disc;">' + QnLine + '</li>'
                QnLine = f'<div style="{style}">' + QnLine + '</div>\n'
                ResQn += QnLine
                PreCodeLine=CodeLine		
        elif len(LsQnTxt)>1 :
            ResQn = ''
            for I in range(len(LsQnTxt)):
                QnLine = LsQnTxt[I]
                style = ''
                style += 'font-weight:bold;'
                QnLine = f'<div style="{style}">' + QnLine + '</div>\n'
                ResQn += QnLine
        else:
            style = ''
            style += 'font-weight:bold;'
            QnLine = f'<div style="{style}">' + QnText + '</div>\n'
            ResQn += QnLine
        return(gfQnMake.QnEsc(ResQn))
    @classmethod
    def ValidateDocx(cls,TblRow, pmsg):
        msg = pmsg[0]
        msg += '' + str(len(TblRow)) + ','

        CountCol = len(TblRow[0].cells)
        Col = [CountCol]
        for I in range(0,len(TblRow),1):
            CountCol = len(TblRow[I].cells)
            if CountCol not in Col:
                Col.append(CountCol)	
        msg += '' + str(Col) + ','
        pmsg[0] = msg
    @classmethod
    def v2ParseOpt(cls,rec,recOpt):
        sequence = [i+1 for i in range(20)]
        rno = random.choice(sequence)
        optcount = int(rec['optcount'])
        optStrFmt = r'{"id":"%d","option":"%s"}'	* optcount
        optStrFmt = '[' + optStrFmt + ']'
        #
        optStrVal = []
        lsOpt = []
        lsAns = []
        for J in range(optcount):
            optCh = chr(ord('a') + J)
            optName = 'opt' + optCh		
            rec[optName] = recOpt[optName] 
            lsOpt.append(rec[optName])
            lsAns.append(1 if (J+1)==int(rec['optans']) else 0)		
            optVal = rec[optName]
            optStrVal.append(rno + J);
            optStrVal.append(optVal);
        rec['lsOpt'] = lsOpt
        rec['lsAns'] = lsAns

        optStrVal = tuple(optStrVal)
        #
        res01 = optStrFmt%optStrVal
        res02 = rno + int(rec['optans'])-1
        res = (res01, res02)
        return res

    @classmethod
    def ParseQnSec(cls, DatQn, QnSec, QnHasToIncludeSec=True):	
        for e in QnSec:
            for I in range(int(e['from'])-1,int(e['to'])):
                if QnHasToIncludeSec:
                    DatQn[I]['q'] = e['intro'] + DatQn[I]['q']
                DatQn[I]['sec_lid'] = e['lid']

    @classmethod
    def ParseSecShuffle(cls, QnSec):	
        ruleStr = ''; I=1;
        for e in QnSec:		
            ruleStr += ('' if ruleStr=='' else ',\n')  + '\t\t\t{"rule":%d,"from": %d,"to": %d, "suffleCount":0}'%(I,int(e['from']),int(e['to']),)
            I+=1
        ruleStr = '\t\t"rule":[\n' + ruleStr + '\n\t\t]\n'
        return ruleStr
    @classmethod
    def ParseQnGrp(cls, DatQn, DatGrp):	
        for e in DatGrp:
            for I in range(int(e['from'])-1,int(e['to'])):						
                DatQn[I]['grp_lid'] = e['lid']
    @classmethod
    def ParseQn(cls,TblRow, DatQn, pDatGrp, QnSec):		
        DatGrp = pDatGrp[0]
        for I in range(0,len(TblRow),1):
            cells = TblRow[I].cells
            colType = cells[0].text.lower()
            if colType=='qn':
                rec = {'sno':cells[1].text,'q':gfQnMake.parseQnText(cells[4].text,cells[3].text),'sec_lid':'0','grp_lid':'0'}	
                DatQn.append(rec)
            elif colType=='group':			
                DatGrp = cells[4].text
            elif colType[0:3]=='sec':						
                rec = {'lid':str(len(QnSec)+1),
                    'secName':colType.replace('sec','').replace('[','').replace(']','').strip(),
                    'from':cells[1].text,'to':cells[2].text,
                    'intro':gfQnMake.parseQnText(cells[4].text,cells[3].text)#intro,code
                    }	
                QnSec.append(rec)
        
        #print(DatQn)
        pDatGrp[0] = DatGrp
    @classmethod
    def ParseOpt(cls,TblRow, DatOpt):
        for I in range(0,len(TblRow),1):
            cells = TblRow[I].cells
            colType = cells[0].text.lower()		
            sno = cells[1].text
            optcount = int(cells[2].text.strip())
            optans 	 = int(cells[3].text.strip())

            if colType=='opt':
                rec = {'sno' : sno, 'optcount' : optcount, 'optans' : optans}
                for J in range(optcount):				
                    optCh = chr(ord('a') + J)
                    optName = 'opt' + optCh
                    optVal = cells[4+J].text.strip()
                    optVal = optVal[2:].strip();
                    rec[optName] = gfQnMake.OptEsc(optVal)
                
                #opta = cells[4].text.strip()[2:].strip();
                #optb = cells[5].text.strip()[2:].strip();
                #optc = cells[6].text.strip()[2:].strip();
                #optd = cells[7].text.strip()[2:].strip();
                #opte = cells[8].text.strip()[2:].strip();
                #rec = {'sno':sno,'opta':opta,'optb':optb,'optc':optc,'optd':optd,'opte':opte,'optcount':cells[2].text,'optans':cells[3].text}	
                DatOpt.append(rec)

    @classmethod        
    def DoQnOpt(cls, DatQn,DatGrp,DatOpt,QnSec,DatQnOpt,DatQnOptV2):
        for I in range(0,len(DatQn),1):
            recQn = DatQn[I]
            recOpt = DatOpt[I]
            rec = {'sno':recQn['sno'],'q':recQn['q'], 'optcount':recOpt['optcount'],'optans':recOpt['optans']}
            #'opta':recOpt['opta'],'optb':recOpt['optb'],'optc':recOpt['optc'],'optd':recOpt['optd'],'opte':recOpt['opte'],
            res = gfQnMake.v2ParseOpt(rec,recOpt)
            recv2  = {'sno':recQn['sno'],'q':recQn['q'],'options':res[0],'answer_key':res[1],'sec_lid':recQn['sec_lid'],'grp_lid':recQn['grp_lid']}

            DatQnOpt.append(rec)
            DatQnOptV2.append(recv2)
        gfQnMake.ParseQnSec(DatQnOpt, QnSec,True)
        gfQnMake.ParseQnSec(DatQnOptV2, QnSec,False)
        DatGrp[0] = eval(DatGrp[0])
        gfQnMake.ParseQnGrp(DatQnOptV2, DatGrp[0])

    @classmethod 
    def getConV1(cls):
        '''caption_databaseName = Captions.gfQnMake_getConV1_caption_databaseName#!
        default_databaseName = 't20apt00'
        databaseName = input(caption_databaseName)
        if(databaseName==''):
            databaseName = default_databaseName'''
        
        mydb = mysql.connector.connect(host = 'localhost', 	user = 'root', database = gfQnMake.databaseName)#t20apt01apple
        return mydb

    @classmethod
    def writeQuizV1(cls,DatQnOpt,quiz_name,question_count,time_limit):
        intro_text = gfQnMake.getIntroText(question_count,time_limit)
        mydb = gfQnMake.getConV1()
        msg = ''
        sqlCat 	= "INSERT INTO cats (cat_name) VALUES (%s)"
        sqlQuiz = "INSERT INTO quizzes (cat_id, quiz_name, quiz_desc, added_date, parent_id, show_intro, intro_text) VALUES (%s,%s, %s,now(),0,1,%s)"
        sqlQn 	= "INSERT INTO questions(question_text, question_type_id, priority, quiz_id, point, added_date, parent_id, header_text, footer_text) VALUES (%s,1,%s,%s,1,now(),0,'','')"
        sqlGrp 	= "INSERT INTO question_groups (group_name, show_header, group_total, question_id, parent_id, added_date) VALUES ('',0,0,%s,0,now())"	
        sqlOpt 	= "INSERT INTO answers (group_id, answer_text, correct_answer, priority, correct_answer_text, answer_pos, parent_id, control_type, answer_parent_id) VALUES (%s,%s,%s,0,'',0,0,1,0)"
        mycursor = mydb.cursor()

        valCat = (quiz_name,)
        mycursor.execute(sqlCat, valCat) 	
        dbcat_id=mycursor.lastrowid
        valQuiz = (dbcat_id,quiz_name,quiz_name,intro_text)
        mycursor.execute(sqlQuiz, valQuiz)
        dbquiz_id=mycursor.lastrowid
        ids = [dbcat_id,dbquiz_id,[]]
        for I in range(len(DatQnOpt)):
            rec = DatQnOpt[I]
            valQn = (rec['q'],rec['sno'],dbquiz_id) #sno,q,opta,optb,optc,optd,opte,optcount,optans
            mycursor.execute(sqlQn, valQn)
            dbqn_id=mycursor.lastrowid
            valGrp = (dbqn_id,)
            mycursor.execute(sqlGrp, valGrp)
            dbgrp_id=mycursor.lastrowid
            Opts = rec['lsOpt'] #[OptEsc(rec['opta']),OptEsc(rec['optb']),OptEsc(rec['optc']),OptEsc(rec['optd']),OptEsc(rec['opte'])][:int(rec['optcount'])]
            OptCorAnss = rec['lsAns'] #[1 if 1==int(rec['optans']) else 0,1 if 2==int(rec['optans']) else 0,1 if 3==int(rec['optans']) else 0,1 if 4==int(rec['optans']) else 0,1 if 5==int(rec['optans']) else 0][:int(rec['optcount'])]
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
    def getIntroText(cls,question_count,time_limit):
        intro_text = Captions.gfQnMake_getIntroText_intro_text%(str(question_count),str(time_limit))#!
        #print(intro_text)
        return intro_text