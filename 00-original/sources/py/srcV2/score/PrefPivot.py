import json
import os
from datetime import date

ConfigFilePath = r'F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\pivotscores\pref\pref.json'
def readConfig():
    jobFile = ConfigFilePath
    if jobFile == '':
        return None
    fpJson = open(jobFile, 'r')
    config = json.load(fpJson)
    fpJson.close()
    
    return config
