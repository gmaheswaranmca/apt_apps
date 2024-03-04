import pandas as pd
import os

def trimByIndex(row, index):
    return row.iloc[index].strip()

fileData = 'data.csv'
'''
    How to get the current directory in Python?
    https://flexiple.com/python/python-get-current-directory
'''
folderData = os.getcwd()
fileFolderData = os.path.join(folderData, fileData)
# print(f'fileData: {fileData}, folderData: {folderData}, fileFolderData: {fileFolderData}') #??DEBUG??

#df = pd.read_csv(r'C:\mywork\source\apt\apt_apps\01-admin-client-localhost\py\src\learn_py\data.csv')
df = pd.read_csv(fileFolderData)

srcFieldsPos=[1, 0, 2] #0-Name, 1-Username, 3-Password
indexUserName, indexName, indexPassword = srcFieldsPos[1], \
    srcFieldsPos[0], \
    srcFieldsPos[2]


print('Field value by index: #2')     
for index, row in df.iterrows():
    UserName, Name, Password = row.iloc[indexUserName].strip(), \
        row.iloc[indexName].strip(),  \
        row.iloc[indexPassword].strip()
    print(UserName, Name, Password)     

print('\n\nField value by index: #3')         
for index, row in df.iterrows():
    UserName, Name, Password = trimByIndex(row, indexUserName), \
        trimByIndex(row, indexName),  \
        trimByIndex(row, indexPassword)
    print(UserName, Name, Password)    

print('\n\nField value by index: #1(deprecated)') 
# row[indexUserName] is deprecated. 
# So, use row.iloc[indexUserName]
for index, row in df.iterrows():
    UserName, Name, Password = row[indexUserName].strip(), \
        row[indexName].strip(),  \
        row[indexPassword].strip()
    print(UserName, Name, Password) 

   