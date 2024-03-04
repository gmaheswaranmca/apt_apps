class JobDescriptorConfig:
    def __init__(self):
        self.folderDescriptor = r''
        self.fileDescriptor = r''
        self.folderQnDbStmt = r''
        self.fileQnDbStmt = r''

class QnDbStmt:
    def _read(self):
        #read job file into list        
        pass 
    def _parse(self):
        import pandas as pd
        import os
        jobs = []
        return jobs 

class BaseJobDescriptor:    
    def readJobs(self):
        pass 
    def _fetchQnDbStmt(self):
        self.jobs = []
        pass 
