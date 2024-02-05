jobLoc = {
    'jobDir' : r'C:\mywork\source\apt\apt-test-files\db',
    'uploadDir' : '%s/%s/to', #jobDir testLikName
    'downloadDir' : '%s/%s/from', #jobDir testLikName
    'command_path' : r'C:/Program Files/MySQL/MySQL Server 8.2/bin'
}

import os 
import json
class JsonUtil:
    @staticmethod
    def readFromJson(fileName):
        fileObj = open(fileName, "r")
        data = json.load(fileObj)
        #print(lsOfEmpDict)
        records = data
        
        return (records)
    @staticmethod 
    def showInFolderExplorer(fileName):
        import subprocess
        dirName = os.path.dirname(fileName)
        subprocess.Popen(f'explorer {dirName}')
    @staticmethod
    def writeToJson(fileName, data):     
        fileObj = open(fileName, "w")           
        json.dump(data, fileObj)
        fileObj.close()
        #JsonUtil.showInFolderExplorer(fileName)
class MysqlBkupUtil:
  @staticmethod
  def dumpMysqlDb(fileName, linkCodeName):
    import pipes
    #import pythoncom
    #pythoncom.CoInitialize()
    global jobLoc
    DB_HOST = "localhost"
    DB_USER = "root"
    DB_USER_PASSWORD = ""
    db = f'aptonline{linkCodeName}' 
    command_path = jobLoc['command_path']
    if DB_USER_PASSWORD != "" : 
        DB_USER_PASSWORD = f'-p {DB_USER_PASSWORD}'

    dumpcmd = f'"{command_path}/mysqldump"  --defaults-file=C:/mywork/source/apt/apt-test-files/config.cnf --column-statistics=0 -h localhost -P 3308  {db} > "{fileName}.sql"'
    print(dumpcmd)
    os.system(dumpcmd)

    return dumpcmd
class UpDownLoadUtil:
    """     @staticmethod
        def CreateFile(dirAndFileName, data):    
            fileLoc = dirAndFileName       
            file = open(fileLoc,'w')
            file.write(data)
            file.close()
    """
    @staticmethod
    def UploadFile(testLinkName, fileNameWOExt, jsonData, linkCodeName):
        global jobLoc        
        dir = jobLoc['uploadDir']%( jobLoc['jobDir'], testLinkName )
        dirAndFileName = os.path.join(dir,f'{fileNameWOExt}') 
        JsonUtil.writeToJson(f'{dirAndFileName}.json', jsonData)

        return MysqlBkupUtil.dumpMysqlDb(dirAndFileName, linkCodeName) 
    @staticmethod
    def DownloadFile(testLinkName, fileNameWOExt, jsonData, linkCodeName):
        global jobLoc        
        dir = jobLoc['downloadDir'] % ( jobLoc['jobDir'], testLinkName )
        dirAndFileName = os.path.join( dir, f'{fileNameWOExt}' ) 
        JsonUtil.writeToJson( f'{dirAndFileName}.json', jsonData )     

        return MysqlBkupUtil.dumpMysqlDb(dirAndFileName, linkCodeName)   
    
    @staticmethod
    def DownUpLoadFile(testLinkName, fileNameWOExt, jsonData, upDownStatus, linkCodeName):
        if upDownStatus == 1:
            result = UpDownLoadUtil.UploadFile(testLinkName, fileNameWOExt, jsonData, linkCodeName)
        else:#upDownStatus == 2:
            result = UpDownLoadUtil.DownloadFile(testLinkName, fileNameWOExt, jsonData, linkCodeName)
        
        return {'status' : 'Job Done!', 'mysqldump' : result}