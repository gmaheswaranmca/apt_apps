@echo off
cmd /k "deactivate & cd /d C:\mywork\source\apt\envs\ & env01\Scripts\activate & cd /d C:\mywork\source\apt\apt_apps\01-admin-client-localhost\py\src\aptmktest & start http://localhost:8002/fev5 & python manage.py runserver 7002 & pause"





