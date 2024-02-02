class Captions:
    StudMkPwd_do_caption_srcPath = r'''------------------------------------------------------------        
Example:F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\2103-20-king\01-Src\genpwd
------------------------------------------------------------
Folder Path:'''
    StudMkPwd_do_caption_srcFileNumber = r'''------------------------------------------------------------
Example:210320
------------------------------------------------------------
File Number:'''    
    StudMkPwd_do_caption_verNumber = r'''------------------------------------------------------------
Example:1
------------------------------------------------------------
Version Number:'''
    StudSavePwd_getCon_caption_databaseName = r'''------------------------------------------------------------
Example:aptonlinefour
------------------------------------------------------------
data base name:'''
    StudSavePwd_scriptCleanQuiz_scriptCleanQuiz = r'''
DELETE FROM cats;
DELETE FROM quizzes;
DELETE FROM questions;
DELETE FROM answers;
DELETE FROM question_groups;
ALTER TABLE cats AUTO_INCREMENT =1;
ALTER TABLE quizzes AUTO_INCREMENT =1;
ALTER TABLE questions AUTO_INCREMENT =1;
ALTER TABLE answers AUTO_INCREMENT =1;
ALTER TABLE question_groups AUTO_INCREMENT =1;
DELETE FROM tcode_language;
DELETE FROM tcode_level;
DELETE FROM tcode_q_base;
DELETE FROM tcode_q_testcase;
ALTER TABLE tcode_language AUTO_INCREMENT =1;
ALTER TABLE tcode_level AUTO_INCREMENT =1;
ALTER TABLE tcode_q_base AUTO_INCREMENT =1;
ALTER TABLE tcode_q_testcase AUTO_INCREMENT =1;'''
    StudSavePwd_scriptCleanQuiz_scriptCleanAssignment = r'''
DELETE FROM assignments;
DELETE FROM assignment_users;
DELETE FROM user_quizzes;
DELETE FROM user_answers;
ALTER TABLE assignments AUTO_INCREMENT =1;
ALTER TABLE assignment_users AUTO_INCREMENT =1;
ALTER TABLE user_answers AUTO_INCREMENT =1;
ALTER TABLE user_quizzes AUTO_INCREMENT =1;
DELETE FROM tcode_q_group_base;
DELETE FROM tcode_q_group_q;
DELETE FROM tcode_assess_base;
DELETE FROM tcode_assess_user;
DELETE FROM tcode_assess_submit_q;
DELETE FROM tcode_assess_submit_testcase;
ALTER TABLE tcode_q_group_base AUTO_INCREMENT =1;
ALTER TABLE tcode_assess_base AUTO_INCREMENT =1;
ALTER TABLE tcode_assess_submit_q AUTO_INCREMENT =1;'''
    StudSavePwd_scriptCleanQuiz_scriptCleanUser = r'''
DELETE FROM users where UserName!='admin';
ALTER TABLE users AUTO_INCREMENT =2;'''
    StudSavePwd_opt01_caption_option = r'''------------------------------------------------------------
Choices Are:
    1 - Clean Quiz
    2 - Clean Assignment
    3 - Clean User
    4 - Clean Quiz, Assignment
    5 - Clean Quiz, Assignment, User
    0 - Exit
------------------------------------------------------------    
Your Choice:'''
    
    StudSavePwd_caption_srcPath_caption_srcPath = r'''------------------------------------------------------------
Example:F:\v2m\techLang\assignment\2020-07-08-Apt-BulkQuestions\OLT\OLTAssignment\2103-20-king\01-Src\genpwd
------------------------------------------------------------
Src Folder Path:'''
    StudSavePwd_caption_srcPath_caption_srcDateStr = r'''------------------------------------------------------------
Example:210320
------------------------------------------------------------
Date Str:'''
    StudSavePwd_caption_srcPath_caption_srcLinkName = r'''------------------------------------------------------------
king
------------------------------------------------------------
Web Site Link Name:'''
    StudSavePwd_do_caption_option = r'''------------------------------------------------------------
Choices Are:
------------------------------------------------------------
    1 - Clean DB
    2 - Update User IDs    
------------------------------------------------------------    
Your Choice:'''
    gfQnMake_getConV1_caption_databaseName = r'''------------------------------------------------------------
Example:t20apt00, aptonlineone, ..., aptonlinefive
Default:t20apt00
------------------------------------------------------------
data base name:'''
    gfQnMake_getIntroText_intro_text = f'''<h2>
<strong>Test Organized by</strong></h2>
<h2 style="border-bottom: 1px solid #F4F5F7;margin-bottom:5px;padding-bottom:5px;">
<span style="color:red">Apt Training Resources</span></h2>
<h2>
<strong>Total number of questions: %s Questions</strong></h2>
<h2>
<strong>Maximum Time Limit: %s minutes</strong></h2>
<p style="border-top: 1px solid #F4F5F7;margin-top:5px;padding-top:5px;">
Please click on the&nbsp;<strong>Continue</strong>&nbsp;button only after reading the instructions thoroughly.</p>
<p>
<strong><u>Instructions:</u></strong></p>
<p>
1. For every question, click the answer option &amp; then click the&nbsp;<strong>Save</strong>&nbsp;button to save the answer for that particular question. Clicking on the&nbsp;<strong>Save </strong>button is essential for the answer to be saved.</p>
<p>
2. Do not keep on pressing the&nbsp;<strong>Save </strong>button for the same question again &amp; again. Clicking once is enough.</p>
<p>
3. Clicking on the particular question number (available on the right side or bottom side) will take you directly to the particular question, but click it only after you have pressed the&nbsp;<strong>Save </strong>button for that question, that you are currently attending in the test.&nbsp;</p>
<p>
4. If after choosing the correct option, you click on the&nbsp;<strong>Previous</strong>&nbsp;button, instead of the&nbsp;<strong>Save </strong>button, even then answers will be saved. Don&rsquo;t worry.</p>
<p>
5. If you click the correct option and then click the&nbsp;<strong>Question number link</strong>&nbsp;in the right or in the bottom or if u click the <strong>Instruction page link</strong>, without pressing the&nbsp;<strong>Save </strong>button, answer won&rsquo;t be saved. Clicking on the&nbsp;<strong>Save </strong>button is essential for the answer to be saved.</p>
<p>
6. If you exceed the time limit for the test, the answers for which u have clicked the&nbsp;<strong>Save </strong>button alone, will automatically be saved &amp; it will take you to the home page.</p>
<p>
7. If incase u want to check the remaining time available for u any time during the test, u can scroll up, to see the timer on the right top corner.</p>
<p>
8. Once you have finished the test, click the&nbsp;<strong>Finish</strong>&nbsp;button available in the top right corner.</p>'''
    QnMake_QnMake_caption_srcPath = r'''------------------------------------------------------------
Example:    F:/v2m/techLang/assignment/2020-07-08-Apt-BulkQuestions/automate/qn
Default:    F:/v2m/techLang/assignment/2020-07-08-Apt-BulkQuestions/automate/qn
------------------------------------------------------------
Src Folder Path:'''
    QnMake_QnMake_caption_srcFileNumber = r'''------------------------------------------------------------
Example:    501
------------------------------------------------------------
File Number:''' 
    QnMake_QnMake_caption_srcVersionNumber = r'''------------------------------------------------------------
Example:    1
------------------------------------------------------------
Version Number:''' 
         
    PickToDb_getIntroText_prefix = '''<h2><b>Test Organized by</b></h2>
<h2 style="border-bottom: 1px solid #F4F5F7;margin-bottom:5px;padding-bottom:5px;"><span style="color:red">Apt Training Resources</span></h2>'''
    PickToDb_getIntroText_intro_text = f'''<h2><b>Total number of questions: %d Questions</b></h2>
<h2><b>Maximum Time Limit: %d minutes</b></h2>
<p style="border-top: 1px solid #F4F5F7;margin-top:5px;padding-top:5px;">
Please click on the <b>Continue</b> button only after reading the instructions thoroughly.</p>
<p><b><u>Instructions:</u></b></p>
<p>1.For every question, click the answer option &amp; then click the <b>Save</b> button to save the answer for that particular question. Clicking on the <b>Save </b>button is essential for the answer to be saved.</p>
<p>2.Do not keep on pressing the <b>Save </b>button for the same question again &amp; again. Clicking once is enough.</p>
<p>3.Clicking on the particular question number (available on the right side or bottom side) will take you directly to the particular question, but click it only after you have pressed the <b>Save </b>button for that question, that you are currently attending in the test.</p>
<p>4.If after choosing the correct option, you click on the <b>Previous</b> button, instead of the <b>Save </b>button, even then answers will be saved. Don't worry.</p>
<p>5.If you click the correct option and then click the <b>Question number link</b> in the right or in the bottom or if u click the <b>Instruction page link</b>, without pressing the <b>Save </b>button, answer won't be saved. Clicking on the <b>Save </b>button is essential for the answer to be saved.</p>
<p>6.If you exceed the time limit for the test, the answers for which u have clicked the <b>Save </b>button alone, will automatically be saved &amp; it will take you to the home page.</p>
<p>7.If incase u want to check the remaining time available for u any time during the test, u can scroll up, to see the timer on the right top corner.</p>
<p>8.Once you have finished the test, click the <b>Finish</b> button available in the top right corner.</p>'''
    
    PickToDb_Do_caption_pHasPrefix = r'''------------------------------------------------------------
Example:y
------------------------------------------------------------
should "Intro Text" use brand name?y/n:'''
    PickToDb_Do_caption_fromDb = r'''------------------------------------------------------------
Example:t20apt00
------------------------------------------------------------
from Database Name:'''
    PickToDb_Do_caption_toDb = r'''------------------------------------------------------------
Example:aptonlinethree
------------------------------------------------------------
to Database Name:'''     
    PickToDb_Do_caption_testPaperName = r'''------------------------------------------------------------
Example:537
------------------------------------------------------------
Test Paper Name:'''    
    PickToDb_Do_caption_QnFrom = r'''------------------------------------------------------------
Example:1
------------------------------------------------------------
Question From (Sno):'''
    PickToDb_Do_caption_QnTo = r'''------------------------------------------------------------
Example:30
------------------------------------------------------------
Question To (Sno):'''
    PickToDb_Do_caption_askPaper = r'''------------------------------------------------------------
Example:y
------------------------------------------------------------
do you "add" more papers?y/n:'''
    PickToDb_Do_caption_askMoreTest = r'''------------------------------------------------------------
Example:y
------------------------------------------------------------
do you "add" more test?y/n:'''
    PickToDb_Do_caption_toPaperName = r'''------------------------------------------------------------
Example:Test Assessment #005, Test Assessment #001 - Part A
------------------------------------------------------------
New Paper Name:'''
    PickToDb_Do_caption_QnsCount = r'''------------------------------------------------------------
Example:30
------------------------------------------------------------
Questions Count:'''
    PickToDb_Do_caption_TimeDuration = r'''------------------------------------------------------------
Example:50
------------------------------------------------------------
Time Duration (Max Time, in minutes):'''    
    PickToDb_DoByPickListString_caption_LineStr = r'''------------------------------------------------------------
Example:
'430',1,30|'431',1,30!'Test Assessment #001',30,50
'430',1,30|'431',1,30!'Test Assessment #001',30,50

------------------------------------------------------------
Line Str:
'''
    MenuHandler_mainMenu_menuStr = r'''------------------------------------------------------------
Menu Options:
    1-Generate Password
    2-Save Password to Database
    3-Question Make
    4-Pick Questions
    5-Pick Questions By String
    6-Read Preferences
    0 or 100-Exit
------------------------------------------------------------    
Your Option:'''
    MenuHandler_mainMenu_thanks = '''
    ------------------------------------------------------------
                            Thank you!!!
    ------------------------------------------------------------
'''
    MenuHandler_sayYesOrNo = r'''Do you continue(y/n)?'''
         
    PickCodeQnToDb_getIntroText_prefix = '''<h2><b>Test Organized by</b></h2>
<h2 style="border-bottom: 1px solid #F4F5F7;margin-bottom:5px;padding-bottom:5px;">
<span style="color:red">Apt Training Resources</span></h2>'''
    PickCodeQnToDb_getIntroText_intro_text = '''<h2><b>Total number of <span style="color:red">Coding</span> questions: %d Questions</b></h2>
<h2><b>Maximum Time Limit: %d minutes</b></h2>
<p style="border-top: 1px solid #F4F5F7;margin-top:5px;padding-top:5px;">Please click on the <b>Continue</b>&nbsp;button only after reading the instructions thoroughly.</p>
<p><b><u>Instructions:</u></b></p> 
<p>1. For every question, check the correctness of the code and edit it fully, wherever required.</p>
<p>2. Only after completely editing the code, click the <b>RUN</b> button to see if your code runs successfully & if the 1st test case has been passed.</p>
<p>3. If it doesn't run successfully, re-check your code for errors & try again.</p>
<p>4. Please note that you can use the <b>RUN</b> button a maximum of %d times only for each question.</p>
<p>5. If the code runs successfully, it will mark your <b>1st test case</b> alone as <b>PASS</b>, but it will not save your code. </p>
<p>6. Even if the 1st test case is passed, re-check the code again before clicking the <b>SUBMIT</b> button, because once you click the <b>SUBMIT</b> button, the code gets saved and it will give you the output, whether all the test cases are passed or not.</p>
<p>7. You are not allowed the click the <b>SUBMIT</b> button again for the same question.</p>
<p>8. If you exceed the time limit for the test, the code that is visible to you will get automatically submitted and the test will be finished.</p>
<p>9. Once you have finished all the questions in the test, then click on the <b>FINISH</b> button available in the top-right corner. </p>
<p>10. Please note that clicking on the <b>FINISH</b> button before attending all the questions will finish your test automatically and you cannot attend the test again.</p>'''
    
    PickCodeQnToDb_Do_caption_pHasPrefix = r'''------------------------------------------------------------
Example:y
------------------------------------------------------------
should "Intro Text" use brand name?y/n:'''
    PickCodeQnToDb_Do_caption_fromDb = r'''------------------------------------------------------------
Example:t20apt00
------------------------------------------------------------
from Database Name:'''
    PickCodeQnToDb_Do_caption_toDb = r'''------------------------------------------------------------
Example:aptonlinethree
------------------------------------------------------------
to Database Name:'''     
    PickCodeQnToDb_Do_caption_testPaperName = r'''------------------------------------------------------------
Example:537
------------------------------------------------------------
Test Paper Name:'''    
    PickCodeQnToDb_Do_caption_QnFrom = r'''------------------------------------------------------------
Example:1
------------------------------------------------------------
Question From (Sno):'''
    PickCodeQnToDb_Do_caption_QnTo = r'''------------------------------------------------------------
Example:30
------------------------------------------------------------
Question To (Sno):'''
    PickCodeQnToDb_Do_caption_askPaper = r'''------------------------------------------------------------
Example:y
------------------------------------------------------------
do you "add" more papers?y/n:'''
    PickCodeQnToDb_Do_caption_askMoreTest = r'''------------------------------------------------------------
Example:y
------------------------------------------------------------
do you "add" more test?y/n:'''
    PickCodeQnToDb_Do_caption_toPaperName = r'''------------------------------------------------------------
Example:Test Assessment #005, Test Assessment #001 - Part A
------------------------------------------------------------
New Paper Name:'''
    PickCodeQnToDb_Do_caption_QnsCount = r'''------------------------------------------------------------
Example:30
------------------------------------------------------------
Questions Count:'''
    PickCodeQnToDb_Do_caption_TimeDuration = r'''------------------------------------------------------------
Example:50
------------------------------------------------------------
Time Duration (Max Time, in minutes):'''    
    PickCodeQnToDb_DoByPickListString_caption_LineStr = r'''------------------------------------------------------------
Example:
'430',1,30|'431',1,30!'Test Assessment #001',30,50
'430',1,30|'431',1,30!'Test Assessment #001',30,50

------------------------------------------------------------
Line Str:
'''    
