$(document).ready(function(){
		//gfMgr.Alert(11);	
		var f = function(){
			AppMonitorViewRender.Init(); AppMonitorReqRes.Init();		
		};
		f();//gfMgr.RunAfGivSec(f,10);
	}
);
var AppMonitorReqDoConfig = { 
	'vPage':{'url':'form/AppMonitor/AppMonitorDo.php',
		'params':{'m':'vPage'}
	},'mdTestStatus':{'url':'form/AppMonitor/AppMonitorDo.php',
		'params':{'m':'mdTestStatus'}
	},'mdResultDownload':{'url':'form/AppMonitor/AppMonitorDo.php',
		'params':{'m':'mdResultDownload'}			
	},'mdAssessmentUpdateStatus':{'url':'form/AppMonitor/AppMonitorDo.php',
		'params':{'m':'mdAssessmentUpdateStatus'}			
	}
};var AppMonitorReqDoRes = {
	'vPage':{},
	'mdTestStatus':{},
	'mdResultDownload':{},
	'mdAssessmentUpdateStatus':{}
};var AppMonitorReqRes = new function (){ 
	this.vPage = new function(){
		this.gfRes = function(pRes){			
			AppMonitorReqRes.vPage.Dor.fResLog(pRes);
			AppMonitorReqRes.vPage.fResDo();			
		};this.gfResFail = function(){
			var Dor = AppMonitorReqRes.vPage.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			AppMonitorReqRes.vPage.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			AppMonitorReqRes.vPage.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = AppMonitorReqDoRes[this.Dor.ReqName];					
			$('#DivSecretCode').html(Res.vSecret);
			AppMonitorViewRender.vPage.Res(Res);			
		};this.Init=function(){
			this.Dor = new ReqDo(AppMonitorReqDoConfig, AppMonitorReqDoRes, 'vPage', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'vPageReq');
			this.Dor.Init();
		};this.Dor = null;				
	};this.mdTestStatus = new function(){
		this.gfRes = function(pRes){
			AppMonitorReqRes.mdTestStatus.Dor.fResLog(pRes);
			AppMonitorReqRes.mdTestStatus.fResDo();			
		};this.gfResFail = function(){
			var Dor = AppMonitorReqRes.mdTestStatus.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			AppMonitorReqRes.mdTestStatus.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			AppMonitorReqRes.mdTestStatus.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = AppMonitorReqDoRes[this.Dor.ReqName];				
			AppMonitorViewRender.mdTestStatus.Res(Res);			
		};this.Init=function(){
			this.Dor = new ReqDo(AppMonitorReqDoConfig, AppMonitorReqDoRes, 'mdTestStatus', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'mdTestStatusReq');
			this.Dor.Init();
		};this.Dor = null;				
	};this.mdResultDownload = new function(){
		this.CallMe = function(args){
			var assignment_id = args[0];
			var quiz_name = args[1];
			//AppMonitorReqDoConfig.mdResultDownload.params['is_csv'] = 1;
			AppMonitorReqDoConfig.mdResultDownload.params['assignment_id'] = assignment_id;			
			AppMonitorReqDoConfig.mdResultDownload.params['quiz_name'] = quiz_name;
			AppMonitorReqRes.mdResultDownload.Dor.fReqDo();
			return false;
		}		
		this.gfRes = function(pRes){
			AppMonitorReqRes.mdResultDownload.Dor.fResLog(pRes);
			AppMonitorReqRes.mdResultDownload.fResDo();			
		};this.gfResFail = function(){
			var Dor = AppMonitorReqRes.mdResultDownload.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			AppMonitorReqRes.mdResultDownload.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			AppMonitorReqRes.mdResultDownload.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = AppMonitorReqDoRes[this.Dor.ReqName];
			var lCsv = "Name, UserName, Score, Attendance, QnsAnswered\n";
			for(var I = 0; I < Res.mdResultDownload.length; I++){
				var lRec = Res.mdResultDownload[I];
				lCsv += '\"Name:' + lRec['Name'       ] + '\",' + 
					    '\"ID:' + lRec['UserName'   ] + '\",' + 
					    '\"' + lRec['Score'      ] + '\",' + 
					    '\"' + lRec['Attendance' ] + '\",' + 
					    '\"' + lRec['QnsAnswered'] + '\"\n';
			}
			quiz_name = AppMonitorReqDoConfig.mdResultDownload.params['quiz_name'];
			gfMgr.ToCsv(lCsv,'Result_' + quiz_name);
			//console.log(lCsv);
		};this.Init=function(){
			this.Dor = new ReqDo(AppMonitorReqDoConfig, AppMonitorReqDoRes, 'mdResultDownload', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'mdResultDownloadReq');
			this.Dor.Init();
		};this.Dor = null;				
	};this.mdAssessmentUpdateStatus = new function(){
		this.CallMe = function(args){
			var assignment_id = args[0];
			var status = args[1];			
			AppMonitorReqDoConfig.mdAssessmentUpdateStatus.params['assignment_id'] = assignment_id;
			AppMonitorReqDoConfig.mdAssessmentUpdateStatus.params['status'] = status;
			AppMonitorReqRes.mdAssessmentUpdateStatus.Dor.fReqDo();
			return false;
		}		
		this.gfRes = function(pRes){
			AppMonitorReqRes.mdAssessmentUpdateStatus.Dor.fResLog(pRes);
			AppMonitorReqRes.mdAssessmentUpdateStatus.fResDo();			
		};this.gfResFail = function(){
			var Dor = AppMonitorReqRes.mdAssessmentUpdateStatus.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			AppMonitorReqRes.mdAssessmentUpdateStatus.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			AppMonitorReqRes.mdAssessmentUpdateStatus.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = AppMonitorReqDoRes[this.Dor.ReqName];	
			AppMonitorReqDoRes['mdTestStatus']= Res;			
			console.log(Res);
			AppMonitorViewRender.mdTestStatus.OutOther(Res);
		};this.Init=function(){
			this.Dor = new ReqDo(AppMonitorReqDoConfig, AppMonitorReqDoRes, 'mdAssessmentUpdateStatus', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'mdAssessmentUpdateStatusReq');
			this.Dor.Init();
		};this.Dor = null;				
	};
	this.Init=function(){
		this.vPage.Init();
		this.mdTestStatus.Init();
		this.mdResultDownload.Init();
		this.mdAssessmentUpdateStatus.Init();	
		AppMonitorReqRes.vPage.Dor.fReqDo();
	};
};var AppMonitorViewRender = new function(){	
	this.vPage = new function(){
		this.Res = function(Res){			
			//Disply:quiz_name|not_taken|answereduser_count|live_no_ans|tookuser_count|user_count
			//Model:user_count, liveuser_count, answereduser_count, tookuser_count
			var fnot_taken = function(){return this.user_count - this.liveuser_count - this.tookuser_count;};
			var flive_no_ans = function(){return this.liveuser_count - this.answereduser_count;};
			var fis_on = function(){return parseInt(this.assignment_status)==1;};
			var fis_off = function(){return parseInt(this.assignment_status)==0;};
			var fis_finished = function(){return parseInt(this.assignment_status)==2;};
			var fstatus_disp_no = function(){return parseInt(this.assignment_status)==1 ? 1 : (parseInt(this.assignment_status)==0 ? 2 : 3) ;};
			var fis_demo_disp = function(){return this.is_demo ? 1 : 0 ;};
			var fstatus_disp_name = function(){return parseInt(this.assignment_status)==1 ? "ON" : (parseInt(this.assignment_status)==0 ? "OFF" : "FINISHED") ;};
			var mdTestCountTotal = Res.mdTestCountTotal;
			var mdTestIsDemo = Res.mdTestIsDemo;
			var mdTestCountLive = Res.mdTestCountLive;
			var mdTestCountAnswered = Res.mdTestCountAnswered;
			
			if(mdTestCountTotal!=null)
			for(I=0;I<mdTestCountTotal.length;I++){
				var atest = mdTestCountTotal[I];
				atest.not_taken = fnot_taken;
				atest.live_no_ans = flive_no_ans;
				atest.is_on = fis_on;
				atest.is_off = fis_off;
				atest.is_finished = fis_finished;
				atest.status_disp_no = fstatus_disp_no;
				atest.status_disp_name = fstatus_disp_name;
				atest.is_demo_disp = fis_demo_disp;
				
				/*Update Other Status Data*/
				this.SetLive(atest,	mdTestCountLive);
				this.SetAnswer(atest, mdTestCountAnswered);
				this.SetIsDemo(atest, mdTestIsDemo);
			}
			this.Out();
		};this.Out = function(){
			var Res = AppMonitorReqDoRes['vPage'];
			var strPage = Mustache.render(Res.vPage, {'test': AppMonitorViewRender.vPage.TestDispData()});
			$('#DivAppMonitor').html(strPage);
			
			AppMonitorReqRes.mdTestStatus.Dor.fReqDo();
		};this.SetLive=function(aTest, aLive){
			if(aLive!=null)
				for(var J=0; J<aLive.length;J++){
					var atestlive = aLive[J];
					if(aTest.assignment_id == atestlive.assignment_id){		
						aTest.tookuser_count = atestlive.tookuser_count;
						aTest.liveuser_count = atestlive.liveuser_count;						
					}
				}
		};this.SetAnswer=function(aTest, aAns){
			if(aAns!=null)
				for(var J=0; J<aAns.length;J++){
					var atestans = aAns[J];
					if(aTest.assignment_id == atestans.assignment_id){
						aTest.answereduser_count = atestans.answereduser_count;					
					}
				}
		};this.SetIsDemo=function(aTest, aIsDemo){
			var is_demo = false;
				if(aIsDemo!=null)
				for(var J=0; J<aIsDemo.length;J++){
					var atestisdemo = aIsDemo[J];
					if(aTest.assignment_id == atestisdemo.assignment_id){								
						aTest.quiz_name = aTest.quiz_name + "(Demo)";
						is_demo = true;
					}
				} if(!is_demo) aTest.quiz_name = aTest.quiz_name + "(Student)";
				aTest['is_demo'] = is_demo;
		};this.SetStatus=function(aTest, aStatus){
			if(aStatus!=null)
				for(var J=0; J<aStatus.length;J++){
					var ateststa = aStatus[J];
					if(aTest.assignment_id == ateststa.assignment_id){
						aTest.assignment_status = ateststa.assignment_status;					
					}
				}
		};this.TestDispData=function(){		
			var ResPage = AppMonitorReqDoRes['vPage'];
			var Tests = ResPage.mdTestCountTotal;
			Tests = Tests.slice();
			Tests.sort(function(a,b){
				return (
				  ((a.is_demo_disp() - b.is_demo_disp())     * 1000000000) +  
				  ((a.status_disp_no() - b.status_disp_no()) *     100000) +  
				  (b.assignment_id - a.assignment_id)
				  ); 
			   });
			return Tests;
		};
	}	
	this.mdTestStatus = new function(){
		this.ResDo=function(Res){									
			var ResPage = AppMonitorReqDoRes['vPage'];
			var mdTestCountTotal = ResPage.mdTestCountTotal;
			var mdTestCountLive = Res.mdTestCountLive;
			var mdTestCountAnswered = Res.mdTestCountAnswered;
			var mdTestStatus = Res.mdTestStatus;
			
			if(mdTestCountTotal!=null)
			for(I=0;I<mdTestCountTotal.length;I++){
				var atest = mdTestCountTotal[I];	
				/*Update Other Status Data*/
				AppMonitorViewRender.vPage.SetLive(atest,	mdTestCountLive);
				AppMonitorViewRender.vPage.SetAnswer(atest, mdTestCountAnswered);
				AppMonitorViewRender.vPage.SetStatus(atest, mdTestStatus);
			}			
		};
		this.Res = function(Res){									
			this.ResDo(Res);
			this.Out();
		};this.Out = function(){			
			var Res = AppMonitorReqDoRes['vPage'];
			var strPage = Mustache.render(Res.vPage, {'test': AppMonitorViewRender.vPage.TestDispData()});
			$('#DivAppMonitor').html(strPage);
			
			AppMonitorViewRender.mdTestStatus.Tmr.fRun();
		};
		this.OutOther = function(Res){			
			this.ResDo(Res);
			var Res = AppMonitorReqDoRes['vPage'];
			var strPage = Mustache.render(Res.vPage, {'test': AppMonitorViewRender.vPage.TestDispData()});
			$('#DivAppMonitor').html(strPage);			
		};
		this.gfTmrStart = function(){			
			AppMonitorViewRender.mdTestStatus.Tmr.fStart()			
		};this.gfTmrTask = function(){			
			AppMonitorReqRes.mdTestStatus.Dor.fReqDo();
		};this.Init=function(){
			this.Tmr = new TmrMgr(60,'DivAppMonitorTmr', this.gfTmrStart, this.gfTmrTask);	
		};this.Tmr = null;
	};this.Init=function(){
		this.mdTestStatus.Init();
	};	
}
