#import docx
import pandas as pd
import os
#import io
import os.path

import random
#import string

import mysql.connector

from Captions import Captions

class StudMkPwd:
    @classmethod
    def pwd(cls,length):
        letters = list('ABCDEFGHIJKLMNPQRSTUVWXYZ')
        result_str = ''.join(random.choice(letters) for i in range(length))
        return result_str
    @classmethod
    def f(cls,p):
        passwo = StudMkPwd.pwd(4)
        print(p, passwo)
        return passwo

    @classmethod
    def do(cls):        
        caption_srcPath = Captions.StudMkPwd_do_caption_srcPath#!
        caption_srcFileNumber = Captions.StudMkPwd_do_caption_srcFileNumber#!    
        caption_verNumber = Captions.StudMkPwd_do_caption_verNumber#!

        srcPath = input(caption_srcPath)
        srcFileNumber = input(caption_srcFileNumber)
        verNumber = input(caption_verNumber)  

        srcFilePath = srcPath + '/' + srcFileNumber + '-v' + verNumber + '.csv'
        outFilePath = srcPath + '/' + srcFileNumber + '-v' + verNumber + '-out.csv'

        StudMkPwd.docaller(srcFilePath, outFilePath)        
    @classmethod
    def docaller(cls, srcFilePath, outFilePath):        
        '''caption_srcPath = Captions.StudMkPwd_do_caption_srcPath#!
        caption_srcFileNumber = Captions.StudMkPwd_do_caption_srcFileNumber#!    
        caption_verNumber = Captions.StudMkPwd_do_caption_verNumber#!

        srcPath = input(caption_srcPath)
        srcFileNumber = input(caption_srcFileNumber)
        verNumber = input(caption_verNumber) '''       

        #srcFileNumber,verNumber,srcPath = '210320','1',r'F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\2103-20-king\01-Src\genpwd'
        #
        ''' srcFilePath = srcPath + '/' + srcFileNumber + '-v' + verNumber + '.csv'
        outFilePath = srcPath + '/' + srcFileNumber + '-v' + verNumber + '-out.csv' '''
        print(srcFilePath,'\n',outFilePath)
        #srcValueFile = open(srcFilePath,'r')
        #srcData = srcValueFile.readlines()
        #srcValueFile.close()

        #print(srcData,len(srcData))
        print("Hello\n\t",srcFilePath,"\n",os.path.exists(srcFilePath))
        print("_________________________________________________________")
        df = pd.read_csv(srcFilePath,encoding ='utf8')
        #print(df.head())
        df['Password'] = df.apply(lambda row: StudMkPwd.f(row.Sno), axis = 1)
        print(df.head())
        #print(df.dtypes)

        df.to_csv(outFilePath)

        #SELECT AES_ENCRYPT('xyz', 'world'),AES_DECRYPT(AES_ENCRYPT('xyz', 'world'),'world');    