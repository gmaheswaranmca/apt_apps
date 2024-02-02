'''
1.smtplib, ssl, email are of standard/core python
2. but
   pip install cryptocode ==>>>  CryptUtil module uses it

https://myaccount.google.com/lesssecureapps

Switch it to ON so that we can send mail from here.
'''

import smtplib, ssl 
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
from email import encoders
from email.mime.base import MIMEBase

from datetime import datetime

from .CryptUtil import cryto


import os
class MailUtil:
    config = {
        "addressFrom": "gmaheswaranmca@gmail.com",
        "passwordFrom": "TEcE+EbEiEFE1EcEpExEHEIE*E6EXEJEVEtELEVEiEuENEyEOEZEjEGE+EhEDEvEyEpEQE=E=E*EEEpEOEsEHEaEyE6EVEWETEWEbEMEoEeEzEaEjEoEuEAE=E=E*EhE+EwEgEdE7ENEbEPEAEPErExEhE1ExEcEiEkEGEkEwE=E=E",
        "addressTo": "ARAVIND APT <askapt@rediffmail.com>",
        "addressCc": "",
        "addressBcc": "",
        "Subject": "****",
        "mailBody": "Scores Attached!",
        "attachmentFile": "****"
    }
    
    '''
    if config == None:
        import sys
        sys.exit('No job for today!')
    '''
    @staticmethod
    def getAttachment(fileWithPath):
        filename = os.path.basename(fileWithPath)
        fp = open(fileWithPath, 'rb')
        part = MIMEBase("application", "octet-stream")
        part.set_payload(fp.read())
        #filename = os.path.basename(fp.name)
        fp.close()    
        
        #print(f'\n----------------\n{filename}\n----------------\n')
        
        encoders.encode_base64(part)
        part.add_header(
            "Content-Disposition",
            f"attachment; filename= {filename}",      )
        return part

    @staticmethod
    def sendMail(fromAddress, fromPassword, toAddress, ccAddress, bccAddress, subject, mailbody, attachment):
        #Setup the MIME
        message = MIMEMultipart()
        message['From'] = fromAddress
        message['To'] = toAddress
        message['Subject'] = subject   #The subject line
        #The body and the attachments for the mail
        message.attach(MIMEText(mailbody, 'plain'))
        message.attach(MailUtil.getAttachment(attachment))
        
        #Create SMTP session for sending the mail
        #session = smtplib.SMTP('smtp.gmail.com', 587) #use gmail with port #465
        try:
            # Create a secure SSL context
            context = ssl.create_default_context()
            #session = smtplib.SMTP_SSL('smtp.gmail.com', 465, context=context)         
            session = smtplib.SMTP_SSL('smtp.gmail.com', 465, context=context)         
            #session.starttls() #enable security
            session.login(fromAddress, fromPassword) #login with mail_id and password
            text = message.as_string()
            session.sendmail(fromAddress, toAddress, text)
        except  Exception as e:
            pass
            #print(f'\n----------------\n{e}\n----------------\n')
        finally:
            session.quit()
        #print(f'Mail Sent to {toAddress} {ccAddress}  {bccAddress}')    
        
    @staticmethod
    def sendScoreMail(pSubject, pFile):
        config = MailUtil.config
        #config['addressTo'] =    "Outstanding 20 <pystud19@gmail.com>"#???
        #config['addressTo'] += ", Mahesh Viji <gmaheswaranviji@gmail.com>"#???


        config['addressTo'] =    "ARAVIND APT <askapt@rediffmail.com>"#???
        #config['addressTo'] += ", ARAVIND APT Training <aravindsrinivasan@yahoo.com>"#???

        

        config['attachmentFile'] = pFile
        
        config['Subject'] = pSubject #???
        dtNow = datetime.now().strftime('%Y%m%d%H%M%S') 
        config['Subject'] += '_-_' + dtNow #???
        
        decodedPassword =  config['passwordFrom'][0::2]        
        actualPassword = cryto.getMailPassword(decodedPassword)        
        

        ''' 
        print(config['addressFrom'], 
                '',         
                config['addressTo'],
                config['addressCc'],
                config['addressBcc'],
                config['Subject'],
                config['mailBody'],
                config['attachmentFile'],sep='\n----------------\n')
        '''

        #choice = input('Are you sure to send mail? Say y/n:')
        #if choice == 'y':
        MailUtil.sendMail(config['addressFrom'], 
            actualPassword,         
            config['addressTo'],
            config['addressCc'],
            config['addressBcc'],
            config['Subject'],
            config['mailBody'],
            config['attachmentFile'])