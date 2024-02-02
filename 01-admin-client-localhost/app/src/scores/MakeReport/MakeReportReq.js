$(document).ready(function() {
    //gfMgr.Alert(1100);	
    var f = function() {
        $('#PageBefore').css('display', 'block');
        $('#PageAfter').css('display', 'none');
        MakeReportViewRender.Init();
        MakeReportReqRes.Init();
    };
    f(); //gfMgr.RunAfGivSec(f,10);
});
var MakeReportReqDoConfig = { //mdData
    'vMakeReportPage': {
        'url': 'MakeReport/MakeReportDo.php',
        'params': { 'm': 'vMakeReportPage' }
    },
    'mdData': {
        'url': 'MakeReport/MakeReportDo.php',
        'params': { 'm': 'mdData' }
    }
};
var MakeReportReqDoRes = {
    'vMakeReportPage': {},
    'mdData': {}
};
var MakeReportReqRes = new function() {
    this.vMakeReportPage = new function() {
        this.gfRes = function(pRes) {
            MakeReportReqRes.vMakeReportPage.Dor.fResLog(pRes);
            MakeReportReqRes.vMakeReportPage.fResDo();
        };
        this.gfResFail = function() {
            var Dor = MakeReportReqRes.vMakeReportPage.Dor;
            Dor.fResFailLog();
            Dor.Tmr.fRun();
        };
        this.gfTmrStart = function() {
            MakeReportReqRes.vMakeReportPage.Dor.Tmr.fStart()
        };
        this.gfTmrTask = function() {
            MakeReportReqRes.vMakeReportPage.Dor.fReqDo();
        };
        this.fResDo = function() {
            var Res = MakeReportReqDoRes[this.Dor.ReqName];
            MakeReportViewRender.vMakeReportPage.Res(Res);
        };
        this.Init = function() {
            this.Dor = new ReqDo(MakeReportReqDoConfig, MakeReportReqDoRes, 'vMakeReportPage', this.gfRes, this.gfResFail,
                this.gfTmrStart, this.gfTmrTask, 'vMakeReportPageReq');
            this.Dor.Init();
        };
        this.Dor = null;
    };
    this.mdData = new function() {
        this.gfRes = function(pRes) {
            MakeReportReqRes.mdData.Dor.fResLog(pRes);
            MakeReportReqRes.mdData.fResDo();
        };
        this.gfResFail = function() {
            var Dor = MakeReportReqRes.mdData.Dor;
            Dor.fResFailLog();
            Dor.Tmr.fRun();
        };
        this.gfTmrStart = function() {
            MakeReportReqRes.mdData.Dor.Tmr.fStart()
        };
        this.gfTmrTask = function() {
            MakeReportReqRes.mdData.Dor.fReqDo();
        };
        this.fResDo = function() {
            var ResData = MakeReportReqDoRes[this.Dor.ReqName];

            var Res = MakeReportReqDoRes.vMakeReportPage;
            Res.DataRes['ass' + Res.ResultIDs[Res.DataRes.downloaded]] = ResData.mdData;
            Res.DataRes.downloaded++;
            if (Res.DataRes.downloaded < Res.DataRes.count)
                MakeReportViewRender.NextAssessment();
            else
            if (Res.DownloadOption == 1) {
                MakeReportViewRender.InvokeGenReport();
            } else if (Res.DownloadOption == 2) {
                console.log('Option 2');
                MakeReportViewRender.InvokeGenReport01();
            }

        };
        this.Init = function() {
            this.Dor = new ReqDo(MakeReportReqDoConfig, MakeReportReqDoRes, 'mdData', this.gfRes, this.gfResFail,
                this.gfTmrStart, this.gfTmrTask, 'mdDataReq');
            this.Dor.Init();
        };
        this.Dor = null;
    };
    this.Init = function() {
        this.vMakeReportPage.Init();
        this.mdData.Init();
        MakeReportReqRes.vMakeReportPage.Dor.fReqDo();
    };
};
var MakeReportViewRender = new function() {
    this.vMakeReportPage = new function() {
        this.Res = function(Res) {
            Res.strMakeReportPage = '';
            Res.strTestPlan = '';
            var vMakeReportPage = Res.vMakeReportPage;
            var mdReports = Res.mdReports;
            if (mdReports != null)
                for (var I = 0; I < mdReports.length; I++) {
                    mdReports[I].idx = I;
                }
            for (var I = 0; I < Res.mdAss.mdAssTP.length; I++) {
                var TP = Res.mdAss.mdAssTP[I];
                TP.idx = I;
                //
            }
            for (var I = 0; I < Res.mdAss.mdAssTest.length; I++) {
                var Test = Res.mdAss.mdAssTest[I];
                Test.idx = I;
                //
            }
            for (var I = 0; I < Res.mdAss.mdRptField.length; I++) {
                var Field = Res.mdAss.mdRptField[I];
                Field.idx = I;
                //
            }
            for (var I = 0; I < Res.mdAss.mdRptUsrGroup.length; I++) {
                var UsrGroup = Res.mdAss.mdRptUsrGroup[I];
                UsrGroup.d_user_list = UsrGroup.user_list.split(',').join(', ');
                UsrGroup.idx = I;
            }
            this.Out(Res);
        };
        this.Out = function(Res) {
            var strMakeReportPage = Mustache.render(Res.vMakeReportPage, { 'report': Res.mdReports });
            var strTestPlan = Mustache.render(Res.vTestPlan, {
                'testpaper': Res.mdAss.mdAssTP,
                'assignment': Res.mdAss.mdAssTest,
                'fields': Res.mdAss.mdRptField,
                'user_groups': Res.mdAss.mdRptUsrGroup
            });
            Res.strMakeReportPage = strMakeReportPage;
            Res.strTestPlan = strTestPlan;
            $('#pageContent').html(strMakeReportPage);
            $('#testPagers').html(Res.vTPActions);

            $('#PageBefore').css('display', 'none');
            $('#PageAfter').css('display', 'block');


        };
    };
    this.Init = function() {

    };
    this.Download = function(idx) {
        //alert(idx);		
        var Res = MakeReportReqDoRes.vMakeReportPage;
        var RL = Res.mdReports[idx];
        $('#idDivDownloadMsg').html("Fetching Data " + RL.report_name + "....");


        Res.ResultIDs = [];
        Res.DataRes = { 'count': 0, 'downloaded': 0 };
        Res.TP = [];
        Res.report_idx = idx;
        Res.report_id = RL.report_id;
        Res.is_demo = RL.is_demo;
        for (var I = 0; I < Res.mdReportAssignment.length; I++) {
            var ass = Res.mdReportAssignment[I];

            if (ass.report_id == RL.report_id && ass.is_demo == RL.is_demo) {
                Res.ResultIDs.push(ass.assignment_id);
                Res.TP.push(ass);
                Res.DataRes['ass' + ass.assignment_id] = false;

                Res.DataRes.count++;
            }
        }
        Res.DownloadOption = 1;
        //console.log(Res.ResultIDs);console.log(Res.DataRes);
        MakeReportViewRender.NextAssessment();
    };
    this.Download01 = function() {
        //alert(idx);		
        var Res = MakeReportReqDoRes.vMakeReportPage;
        var RL = Res.NMR.rptDef;
        $('#idDivDownloadMsg').html("Fetching Data " + RL.report_name + "....");


        Res.ResultIDs = [];
        Res.DataRes = { 'count': 0, 'downloaded': 0 };
        Res.TP = [];
        //Res.report_idx = idx;
        //Res.report_id = RL.report_id;
        //Res.is_demo = RL.report_name.indexOf('DEM') >= 0;
        for (var I = 0; I < Res.NMR.Test.length; I++) {
            var ass = Res.NMR.Test[I];
            Res.ResultIDs.push(ass.assignment_id);
            Res.TP.push(ass);
            Res.DataRes['ass' + ass.assignment_id] = false;
            Res.DataRes.count++;
        }
        Res.DownloadOption = 2;
        console.log({ 'ResultIDs': Res.ResultIDs, 'DataRes': Res.DataRes, 'TP': Res.TP });
        MakeReportViewRender.NextAssessment();
    };
    this.NextAssessment = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        MakeReportReqDoConfig.mdData.params['assignment_id'] = Res.ResultIDs[Res.DataRes.downloaded];
        MakeReportReqRes.mdData.Dor.fReqDo();
    };
    this.InvokeGenReport01 = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        MakeReportViewRender.GenReport(Res.NMR.rptDef);
    };
    this.InvokeGenReport = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        idx = Res.report_idx;
        var RL = Res.mdReports[idx];

        var rptDef = this.getReportDef();
        rptDef.report_name = RL.report_name;
        MakeReportViewRender.GenReport(rptDef);
    };
    this.GenReport = function(rptDef) {
        var Res = MakeReportReqDoRes.vMakeReportPage;

        var RL = rptDef

        $('#idDivDownloadMsg').html(RL.report_name + "<br>Got Data.<br>Generating Report....");

        var fieldReplace = {
            'username': 'UserName',
            'fullname': 'Name',
            'answered': 'QnsAnswered',
            'score': 'Score',
            'attendance': 'Attendance',
            'TestStartedAt': 'TestStartedAt',
            'TimeSpent': 'TimeSpent'
        };
        var field_list = rptDef.field_list;
        var field_caption = rptDef.field_caption;
        var fields = field_list.split(",");
        var captions = field_caption.split(",");
        this.trimList(fields);
        this.trimList(captions);
        var CapStr = '';
        var CapStr01 = '';
        for (var J = 0; J < fields.length; J++) {
            fields[J] = this.getFieldParts(fields[J]);
            if (fields[J].is_part) {
                var TP = Res.TP[fields[J].tp_id - 1];
                captions[J] = captions[J].replace('~tp_name~', TP.quiz_name);
                captions[J] = captions[J].replace('~qn_count~', parseInt(TP.question_count));
                captions[J] = captions[J].replace('~time_limit~', parseInt(TP.quiz_duration));
            }
            CapStr += (CapStr == '' ? '' : ',') + '"' + captions[J] + '"';
        }
        //
        var Dat01 = Res.DataRes['ass' + Res.ResultIDs[0]];
        var DatOut = [];
        rptDef.user_list = rptDef.user_list.trim()
        var users = [];
        var usrData = {};
        var isAll = true;
        if (rptDef.user_list != '*') {
            isAll = false;
            users = rptDef.user_list.split(",");
            this.trimList(users);
            for (var J = 0; J < users.length; J++) {
                usrData[users[J]] = {};
            }
        }
        var DatStr = '';
        var hasCap02Done = false;
        K = 0;
        for (var I = 0; I < Dat01.length; I++) {
            var rec = {},
                recstr = '';

            rec['username'] = Dat01[I][fieldReplace['username']];
            if ((!isAll) && rptDef.user_list.indexOf(rec['username']) < 0) continue;
            K++;
            rec['fullname'] = Dat01[I][fieldReplace['fullname']];
            rec['usercode'] = '';
            rec['sno'] = K;

            for (var J = 0; J < fields.length; J++) {
                switch (fields[J].field_name) {
                    case 'answered':
                    case 'score':
                    case 'attendance':
                    case 'TestStartedAt':
                    case 'TimeSpent':
                        rec[fields[J].field_name] = Res.DataRes['ass' + Res.ResultIDs[fields[J].tp_id - 1]][I][fieldReplace[fields[J].field_name]];
                        if (!hasCap02Done) CapStr01 += (CapStr01 == '' ? '' : ',') + '"' + Res.TP[fields[J].tp_id - 1].quiz_name + '"';
                        break;
                    case 'Remark':
                    case 'ScorePer':
                    case 'TimePer':
                    case 'RuleRemark':
                        var RemarkReturnType = 1;
                        if (fields[J].field_name == 'TimePer') RemarkReturnType = 2;
                        else if (fields[J].field_name == 'ScorePer') RemarkReturnType = 3;
                        else if (fields[J].field_name == 'RuleRemark') RemarkReturnType = 4;
                        rec[fields[J].field_name] = this.getRemarkColumn(
                            rec['TimeSpent'], parseInt(Res.TP[fields[J].tp_id - 1].quiz_duration),
                            rec['score'], parseInt(Res.TP[fields[J].tp_id - 1].question_count),
                            rec['attendance'], RemarkReturnType
                        )
                        if (!hasCap02Done) CapStr01 += (CapStr01 == '' ? '' : ',') + '"' + Res.TP[fields[J].tp_id - 1].quiz_name + '"';
                        break;
                    default:
                        if (!hasCap02Done) CapStr01 += (CapStr01 == '' ? '' : ',') + '"' + '' + '"'
                }
                if (fields[J].field_name != 'sno') recstr += (recstr == '' ? '' : ',') + '"' + rec[fields[J].field_name] + '"';
            }
            hasCap02Done = true;
            DatOut.push(rec);
            DatStr += "\n" + K + ',' + recstr;
            usrData[rec['username']] = recstr;
        }
        //
        if (isAll) {
            DatStr = CapStr01 + '\n' + CapStr + DatStr;
            //
            $('#idDivDownloadMsg').html(RL.report_name + "<br>Got Data.<br>Generated Report.<br>");
            gfMgr.ToCsv(DatStr, RL.report_name + "_-_Scores");
            $('#idDivDownloadMsg').html(RL.report_name + "<br>Got Data.<br>Generated Report.<br>Downloaded.");
        } else {
            DatStr = '';
            //
            for (var J = 0; J < users.length; J++) {
                DatStr += "\n" + (J + 1) + ',' + usrData[users[J]];
            }

            DatStr = CapStr01 + '\n' + CapStr + DatStr;
            $('#idDivDownloadMsg').html(RL.report_name + "<br>Got Data.<br>Generated Report.<br>");
            gfMgr.ToCsv(DatStr, RL.report_name + "_-_Scores");
            $('#idDivDownloadMsg').html(RL.report_name + "<br>Got Data.<br>Generated Report.<br>Downloaded.");
        }
    };
    this.getRemarkColumn = function(TimeSpent, TimeMax, ScoreTaken, ScoreMax, Attendance, ReturnType) {
        // ReturnType -> 1-Remarks, 2-TimePer, 3-ScorePer
        var Remark = 'NA**';
        var RemarkRule = 'NA**';
        var TimePer = 0;
        var ScorePer = 0;

        if (Attendance === 'PRESENT') {
            if (TimeSpent === "NOT FINISHED") TimeSpent = 0;
            TimeSpent = parseInt(TimeSpent);
            ScoreTaken = parseInt(ScoreTaken);
            TimePer = TimeSpent * 100 / TimeMax;
            ScorePer = ScoreTaken * 100 / ScoreMax;

            var RuleBook = [
                    /* [0, 0, 0, 0, 'Absent', 'Absent for the test'], */
                    [0, 10, 0, 15, '(Present) - Time taken less than or equal to 10% of total time, score less than or equal to 15%', 'Answered all questions without reading even a single question'],
                    [0, 10, 16, 40, '(Present) - Time taken less than or equal to 10% of total time, score between (16% to 40%)', 'Scored all marks by luck'],
                    [0, 10, 41, 100, '(Present) - Time taken less than or equal to 10% of total time, score between (41% to 100%)', "Scores can't be displayed"],
                    [11, 20, 0, 20, '(Present) - Time taken between (11% to 20%), score less than or equal to 20%', 'Answered most of the questions without reading them'],
                    [11, 20, 21, 50, '(Present) - Time taken between (11% to 20%), score between (21% to 50%)', 'Scored most of the marks by luck'],
                    [11, 20, 51, 100, '(Present) - Time taken between (11% to 20%), score between (51% to 100%)', "Scores can't be displayed"],
                    [21, 50, 0, 50, '(Present) - Time taken between (21% to 50%), score between (0% to 50%)', 'Need to spend more time in the online test'],
                    [21, 50, 51, 100, '(Present) - Time taken between (21% to 50%), score between (51% to 100%)', 'Scored some additional marks by luck'],
                    [51, 100, 0, 5, '(Present) - Time taken between (51% to 100%), score less than or equal to 5%', 'Some problem in your internet connectivity'],
                    [51, 100, 6, 50, '(Present) - Time taken between (51% to 100%), score between (6% to 50%)', 'Need to work a lot in this Section'],
                    [51, 100, 51, 75, '(Present) - Time taken between (51% to 100%), score between (51% to 75%)', 'Attended test in a Genuine manner'],
                    [51, 100, 76, 100, '(Present) - Time taken between (51% to 100%), score between (76% to 100%)', 'Good job. Keep it up!']
                ]
                //console.log(RuleBook);
            for (var I = RuleBook.length - 1; I >= 0; I--) {
                var Rule = RuleBook[I];
                //console.log(I,Rule);
                var RuleTimePerMin = Rule[0];
                var RuleTimePerMax = Rule[1];
                var RuleScorePerMin = Rule[2];
                var RuleScorePerMax = Rule[3];
                var RuleDef = Rule[4];
                var RuleRemark = Rule[5];
                if ((RuleTimePerMin <= TimePer && TimePer <= RuleTimePerMax) && (RuleScorePerMin <= ScorePer && ScorePer <= RuleScorePerMax)) {
                    RemarkRule = RuleDef;
                    Remark = RuleRemark;
                }
            }
            /*if(TimeSpent <= 2){
            	Remark = 'TOOK_AT_2_MIN';
            }
            else if(TimeSpent <= 2){
            	Remark = 'TOOK_AT_2_MIN';
            }else if (ScorePer >= 90){
            	Remark = 'EXCELLENT';
            }else if (ScorePer >= 80){
            	Remark = 'GREAT';
            }else if (ScorePer >= 70){
            	Remark = 'DISTINCTION';
            }else if(ScorePer >= 50){
            	Remark = 'AVERAGE';
            }else if(ScorePer >= 30){
            	if((30 <= TimePer && TimePer <= 40) && (30 <= ScorePer && ScorePer <= 40)){
            		Remark = 'Approx. 30-40% Time Spent to score Approx.30-40%';
            	}else{
            		Remark = 'STUDY MORE ON TOPICS'
            	}
            }	
            */
            //Remark += 'score: [' + ScoreTaken + ',' + ScoreMax + ']' + ScorePer + '% and spent:[' + TimeSpent + ',' + TimeMax + ']'  + TimePer + '%';
        } else {
            RemarkRule = 'Absent';
            Remark = 'Absent for the test';
        }

        if (ReturnType == 1) return Remark;
        else if (ReturnType == 2) return this.FormatNumber(TimePer, 2);
        else if (ReturnType == 3) return this.FormatNumber(ScorePer, 2);
        else if (ReturnType == 4) return RemarkRule;
    };
    this.FormatNumber = function(TheNumber, DecimalPlaces) {
        return TheNumber.toLocaleString(undefined, { maximumFractionDigits: DecimalPlaces, minimumFractionDigits: DecimalPlaces })
    };
    this.getReportDef = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        for (var I = 0; I < Res.mdReportDef.length; I++) {
            var rptDef = Res.mdReportDef[I];
            if (rptDef.report_id == Res.report_id)
                return rptDef;
        }
        return null;
    };
    this.trimList = function(pList) {
        for (var I = 0; I < pList.length; I++) {
            pList[I] = pList[I].trim();
        }
    };
    this.getFieldParts = function(field) {
        var parts = field.split("_");
        return { 'field_name': parts[0], 'is_part': parts.length >= 2, 'tp_id': parts.length >= 2 ? parseInt(parts[1]) : 0 };
    };
    this.MakeReport = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        $('#pageContent').html(Res.strMakeReportPage);

    };
    this.TestPlan = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        $('#pageContent').html(Res.strTestPlan);
        gfMgr.CheckboxClickToSelUnsel('idDivTP');
        gfMgr.CheckboxClickToSelUnsel('idDivTest');
        gfMgr.CheckboxClickToSelUnsel('idDivUserGroup');
        gfMgr.CheckboxClickOnlyOne('idDivField');
    };
    this.PleaseTellMe = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        var data = gfMgr.CheckboxValues('idDivTP', ['idQzIdx', 'idQzQns', 'idQzMins'], ['idx', 'qn_count', 'time_limit']);
        console.log(data);
    };
    this.NewMakeReport = function() {
        MakeReportViewRender.TestPlan();
        var Res = MakeReportReqDoRes.vMakeReportPage;
        $('#pageContent').html(Res.strTestPlan);
        gfMgr.CheckboxClickToSelUnsel('idDivTP');
        gfMgr.CheckboxClickToSelUnsel('idDivTest');
        gfMgr.CheckboxClickToSelUnsel('idDivUserGroup');
        gfMgr.CheckboxClickOnlyOne('idDivField');
        MakeReportViewRender.NewMakeReportStep01();

    };
    this.NewMakeReportStep01 = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        $('#secTP').css('display', 'none');
        $('#secTest').css('display', 'none');
        $('#secField').css('display', 'block');
        $('#secUserGroup').css('display', 'none');
        Res.NMR = { 'MetaTest': [], 'MetaField': [], 'MetaUserGroup': [] }
        Res.NMR.StepNumber = 1;
        $('#idNMRPrev').val('  ');
        $('#idNMRNext').val('>>');
    };
    this.NewMakeReportStep02 = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        $('#secTP').css('display', 'none');
        $('#secTest').css('display', 'block');
        $('#secField').css('display', 'none');
        $('#secUserGroup').css('display', 'none');
        var data = gfMgr.CheckboxValues('idDivField', ['idFieldIdx'], ['idx']);
        Res.NMR.MetaField = data;
        Res.NMR.StepNumber = 2;
        $('#idNMRPrev').val('<<');
        $('#idNMRNext').val('>>');
    };
    this.NewMakeReportStep03 = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        $('#secTP').css('display', 'none');
        $('#secTest').css('display', 'none');
        $('#secField').css('display', 'none');
        $('#secUserGroup').css('display', 'block');
        var data = gfMgr.CheckboxValues('idDivTest', ['idAssignmentIdx'], ['idx']);
        Res.NMR.MetaTest = data;
        Res.NMR.StepNumber = 3;
        $('#idNMRPrev').val('<<');
        $('#idNMRNext').val('Do');
    };
    this.InvokeGenReport01_rptDef = function(dfField, dfUserGroup, dfTP) {
        var jsonConcat = function(o1, o2) {
            o1 = JSON.parse(JSON.stringify(o1));
            for (var key in o2) o1[key] = o2[key];
            return o1;
        };
        var greatestCommonPrefix = function(a, b) {
            var minLength = Math.min(a.length, b.length);
            for (var i = 0; i < minLength; i++) {
                if (a.charAt(i) != b.charAt(i)) {
                    return a.substring(0, i);
                }
            }
            return a.substring(0, minLength);
        }
        var rptDef = jsonConcat(dfField, dfUserGroup);
        rptDef.report_name = dfUserGroup.group_name + '_-';

        var whatIsCommon = '',
            prevQuizName = '';
        var valTP = null;
        for (var J = 0; J < dfTP.length; J++) {
            valTP = dfTP[J];
            var QuizName = valTP.quiz_name;
            if (whatIsCommon == '' && prevQuizName != '') {
                whatIsCommon = greatestCommonPrefix(prevQuizName, QuizName);
                alert(whatIsCommon)
            }
            var addStr = QuizName;
            if (whatIsCommon != '') addStr = addStr.replace(whatIsCommon, '');

            rptDef.report_name += '_' + addStr;
            prevQuizName = QuizName;
        }
        rptDef.report_name += '_-_' + (valTP.user_list.indexOf('DEVELOPER') > -1 ? 'DEM' : 'STD');
        return rptDef;
    };
    this.NewMakeReportStep04 = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        var data = gfMgr.CheckboxValues('idDivUserGroup', ['idUsrGroupIdx'], ['idx']);
        Res.NMR.MetaUserGroup = data;
        Res.NMR.Test = [];
        for (var J = 0; J < Res.NMR.MetaTest.length; J++) Res.NMR.Test.push(Res.mdAss.mdAssTest[Res.NMR.MetaTest[J].idx]);
        Res.NMR.Field = [];
        for (var J = 0; J < Res.NMR.MetaField.length; J++) Res.NMR.Field.push(Res.mdAss.mdRptField[Res.NMR.MetaField[J].idx]);
        Res.NMR.UserGroup = [];
        for (var J = 0; J < Res.NMR.MetaUserGroup.length; J++) Res.NMR.UserGroup.push(Res.mdAss.mdRptUsrGroup[Res.NMR.MetaUserGroup[J].idx]);
        if (Res.NMR.Test.length > 0 && Res.NMR.Field.length > 0 && Res.NMR.UserGroup.length > 0) {
            var rptDef = MakeReportViewRender.InvokeGenReport01_rptDef(Res.NMR.Field[0], Res.NMR.UserGroup[0], Res.NMR.Test);
            Res.NMR.rptDef = rptDef;
            //alert(rptDef.report_name);			
            MakeReportViewRender.Download01();
        }
        Res.NMR.StepNumber = 4;
        $('#idNMRPrev').val('<<');
        $('#idNMRNext').val('  ');
    };
    this.NewMakeReportPrev = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        if (Res.NMR.StepNumber == 2)
            MakeReportViewRender.NewMakeReportStep01();
        else if (Res.NMR.StepNumber == 3)
            MakeReportViewRender.NewMakeReportStep02();
        else if (Res.NMR.StepNumber == 4)
            MakeReportViewRender.NewMakeReportStep03();
    };
    this.NewMakeReportNext = function() {
        var Res = MakeReportReqDoRes.vMakeReportPage;
        if (Res.NMR.StepNumber == 1)
            MakeReportViewRender.NewMakeReportStep02();
        else if (Res.NMR.StepNumber == 2)
            MakeReportViewRender.NewMakeReportStep03();
        else if (Res.NMR.StepNumber == 3)
            MakeReportViewRender.NewMakeReportStep04();
    };

}