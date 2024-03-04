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


class AppUser:
    def __init__(self, userName, name, password):
        self.userName = userName 
        self.name = name
        self.password = password 
    def __repr__(self):
        return f'[name={self.name}, username={self.userName}, password={self.password}]'
    def __str__(self):
        return f'[name={self.name}, username={self.userName}, password={self.password}]'

users = []
for index, row in df.iterrows():
    UserName, Name, Password = row[keyUserName].strip(), \
        row[keyName].strip(),  \
        row[keyPassword].strip()
    users.append([UserName, Name, Password])

print('\n\n\nList of list of fields: #3')     
for user in users:
    print(user)

users = []
for index, row in df.iterrows():
    UserName, Name, Password = row[keyUserName].strip(), \
        row[keyName].strip(),  \
        row[keyPassword].strip()
    users.append({'UserName':UserName, 'Name':Name, 'Password':Password})

print('\n\n\nList of dictionary of fields: #4')     
for user in users:
    print(user)    

users = []
for index, row in df.iterrows():
    UserName, Name, Password = row[keyUserName].strip(), \
        row[keyName].strip(),  \
        row[keyPassword].strip()
    users.append(AppUser(UserName, Name, Password))

print('\n\n\nList of User instances: #5')     
for user in users:
    print(user)