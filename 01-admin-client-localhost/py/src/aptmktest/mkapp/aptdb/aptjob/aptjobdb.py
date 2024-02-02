import sqlite3

from pkg_resources import run_script

class AptJobDb:
    #dbFile = './../db.sqlite3'
    dbFile = 'F:/v2m/techLang/dev/php/apt/aaa/aaapydj/app/aptmktest/db.sqlite3'

    @staticmethod
    def getCon():
        con = None
        con = sqlite3.connect(AptJobDb.dbFile)
        return con
    @staticmethod
    def BeginTran():
        con = AptJobDb.getCon()
        cur = con.cursor()
        return con, cur
    @staticmethod
    def EndTran(con):
        con.commit()
        con.close()
    @staticmethod
    def WriteBatch(cur, sqlList):
        for sql in sqlList:
            cur.execute(sql)
    @staticmethod
    def WriteBatchDo(sqlList):
        con, cur = AptJobDb.BeginTran()
        AptJobDb.WriteBatch(cur, sqlList)
        AptJobDb.EndTran(con)
    @staticmethod
    def ReadOneQuery(cur, sql):  #SELECT job_type,status FROM apt_job => [{'job_type':data,'status':data}, ...]
        cur.execute(sql)
        columns = [column[0] for column in cur.description]
        queryResult = []
        for row in cur.fetchall():
            queryResult.append(dict(zip(columns, row)))
        return queryResult 

    @staticmethod
    def ReadBatch(cur, sqlList): 
        #SELECT job_type,status FROM apt_job 
        #SELECT files_path_name,status FROM apt_score_job 
        # => 
        # [         
        #   [{'job_type':data,'status':data}, ...], 
        #   [{'files_path_name':data,'status':data}, ...], 
        #   ...
        # ]
        queriesResult = []
        for sql in sqlList:
            queryResult = AptJobDb.ReadOneQuery(cur,sql)
            queriesResult.append(queryResult)

        return queriesResult

    @staticmethod
    def ReadBatchDo(sqlList): 
        con, cur = AptJobDb.BeginTran()
        dbData = AptJobDb.ReadBatch(cur, sqlList)
        AptJobDb.EndTran(con)
        return dbData  

    @staticmethod
    def ReadOneQueryDo(sql): 
        con, cur = AptJobDb.BeginTran()
        dbData = AptJobDb.ReadOneQuery(cur, sql)
        AptJobDb.EndTran(con)
        return dbData 


    @staticmethod
    def GetLastId(): 
        sqlId = 'SELECT last_insert_rowid() last_id'
        dbData = AptJobDb.ReadBatchDo([sqlId])
        return dbData[0][0]["last_id"] 