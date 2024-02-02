
from rest_framework.response import Response


class vgen:
    @staticmethod
    def mkscorev3Multiple(request):
        '''
        *** api call arguments
        ***     csvData         -- list of csv Data
        ***     csvFileWOext    -- list of csv file name without extension that is ".csv"
        '''
        #api call arguments
        csvData, csvFileWOext =  request.data['csvData'] , request.data['csvFileWOext']    
        
        #Singe Test Report    
        #if len(csvData) == 1:
        #    return vgen.mkscorev3(request)

        #Multiple Tests Report
        #   --actuall call
        from .aptdb.mkscores import ScoreTE        
        result = ScoreTE.DoApiJobMultiple(csvData, csvFileWOext)
    
        #   --response
        return Response({'result': result, 'input' : [csvData, csvFileWOext]})     
    @staticmethod
    def mkscorev4Multiple(request):
        '''
        *** api call arguments
        ***     csvData         -- list of csv Data
        ***     csvFileWOext    -- list of csv file name without extension that is ".csv"
        '''
        #api call arguments
        csvData, csvFileWOext =  request.data['csvData'] , request.data['csvFileWOext']    
        
        #Singe Test Report    
        #if len(csvData) == 1:
        #    return vgen.mkscorev3(request)

        #Multiple Tests Report
        #   --actuall call
        from .aptdb.mkscores import ScoreTE        
        result = ScoreTE.DoApiJobMultiple_v2(csvData, csvFileWOext)
    
        #   --response
        return Response({'result': result, 'input' : [csvData, csvFileWOext]}) 
    @staticmethod
    def doUpLoadDown(request):
        '''
        *** api call arguments
        ***     testLinkName
        ***     fileNameWOExt
        ***     jsonData
        ***     upDownStatus
        '''
        #api call arguments
        testLinkName, fileNameWOExt, jsonData, upDownStatus, linkCodeName =  request.data['testLinkName'] , request.data['fileNameWOExt'] , request.data['jsonData'] , request.data['upDownStatus']   , request.data['linkCodeName']
        
        #   --actuall call
        from .aptdb.UpDownLoadUtil import UpDownLoadUtil        
        result = UpDownLoadUtil.DownUpLoadFile(testLinkName, fileNameWOExt, jsonData, upDownStatus, linkCodeName) 
    
        #   --response
        return Response({'result': result, 'input' : [testLinkName, fileNameWOExt, jsonData, upDownStatus, linkCodeName]})                      

    @staticmethod
    def doSendScoresMail(request):
        '''
        *** api call arguments
        ***     testLinkName
        ***     fileNameWOExt
        ***     jsonData
        ***     upDownStatus
        '''
        #api call arguments
        pSubject, pFile =  request.data['subject'] , request.data['fileAttachment']
        
        #   --actuall call
        from .aptdb.MailUtil import MailUtil        
        result = MailUtil.sendScoreMail(pSubject, pFile) 
    
        #   --response
        return Response({'result': result, 'input' : [pSubject, pFile]})                      

    """
    @staticmethod
    def home(request):
        return Response({'hello':'hello'})    

    @staticmethod 
    def home_io(request):    
        stud = dict()
        stud['firstName'] = request.data['firstName']
        stud['studAge'] = 'NA'
        stud['dateOfBirth'] = 'NA'
        yourdata= [{"stud": stud}]

        return Response(yourdata) 

    @staticmethod 
    def home_iov2(request):            
        stud = dict()
        stud['firstName'] = request.data['firstName']
        from .aptdb.db import aptdb
        stud['studAge'] = aptdb.queryQs(1,10,20)
        stud['dateOfBirth'] = 'NA'
        yourdata= [{"stud": stud}]

        return Response(yourdata)         

    @staticmethod
    def mkscorev1(request):
        from .aptdb.mkscores import ScoreTE
        #ScoreTE.DoJob()
        return Response({'status':'done'})

    @staticmethod
    def mkscorev2(request):
        '''
        *** api call arguments
        ***     csvData         -- Data
        ***     csvFileWOext    -- file name without extension that is ".csv"
        '''
        # api call arguments
        csvData, csvFileWOext =  request.data['csvData'] , request.data['csvFileWOext']        
        
        # actuall call
        from .aptdb.mkscores import ScoreTE
        ScoreTE.DoApiJob(csvData, csvFileWOext)

        # response
        return Response({'status':'done', 'csvData' : csvData, 'csvFileWOext' : csvFileWOext})

    @staticmethod
    def mkscorev3(request):
        '''
        *** api call arguments
        ***     csvData         -- Data
        ***     csvFileWOext    -- file name without extension that is ".csv"
        '''
        # api call arguments
        csvData, csvFileWOext =  request.data['csvData'] , request.data['csvFileWOext']        
        
        # actuall call
        from .aptdb.mkscores import ScoreTE
        
        for i in range(len(csvData)):
            ecsvData = csvData[i]
            ecsvFileWOext = csvFileWOext[i]
            ScoreTE.DoApiJob(ecsvData, ecsvFileWOext)
    
        # response
        return Response({'status':'done', 'csvData' : csvData, 'csvFileWOext' : csvFileWOext,
            'type_csvData' : str(type(csvData)), 'type_csvFileWOext' : str(type(csvFileWOext))})         
    """        