import pandas as pd

df = pd.read_csv(r'C:\mywork\source\apt\apt_apps\01-admin-client-localhost\py\src\learn_py\data.csv')
srcFieldsPos=[1,0,2]
for index, row in df.iterrows():
    #UserName, Name, Password = row[srcFieldsPos[0]].strip()  , row[srcFieldsPos[2]].strip(),  row[srcFieldsPos[1]].strip()
    UserName, Name, Password = row.iloc[srcFieldsPos[0]].strip()  , row.iloc[srcFieldsPos[2]].strip(),  row.iloc[srcFieldsPos[1]].strip()
    print(UserName, Name, Password)