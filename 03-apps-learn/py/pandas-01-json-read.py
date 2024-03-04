import pandas as pd
import os

def trimByIndex(row, index):
    return row.iloc[index].strip()

fileData = 'data.json'
'''
    How to get the current directory in Python?
    https://flexiple.com/python/python-get-current-directory
'''
folderData = os.getcwd()
fileFolderData = os.path.join(folderData, fileData)
# print(f'fileData: {fileData}, folderData: {folderData}, fileFolderData: {fileFolderData}') #??DEBUG??


'''
https://pandas.pydata.org/docs/user_guide/io.html

    https://pandas.pydata.org/docs/user_guide/io.html#io-json-reader
'''
df = pd.read_json(fileFolderData)

#0-Name, 1-Username, 3-Password
indexUserName, indexName, indexPassword = 1, 0, 2
#
keyUserName, keyName, keyPassword = "username", "full name", "password"

print('Field value by index: #1')     
for index, row in df.iterrows():
    UserName, Name, Password = row.iloc[indexUserName].strip(), \
        row.iloc[indexName].strip(),  \
        row.iloc[indexPassword].strip()
    print(UserName, Name, Password)     

print('\n\n\nField value by key: #2')     
for index, row in df.iterrows():
    UserName, Name, Password = row[keyUserName].strip(), \
        row[keyName].strip(),  \
        row[keyPassword].strip()
    print(UserName, Name, Password)

