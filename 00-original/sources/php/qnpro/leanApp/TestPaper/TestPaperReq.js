$(document).ready(function(){
		//gfMgr.Alert(1100);	
		var f = function(){
			$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
			TestPaperViewRender.Init(); TestPaperReqRes.Init();		
		};
		f();//gfMgr.RunAfGivSec(f,10);
	}
);
var TestPaperReqDoConfig = { 
	'vTestPaperPage':{'url':'TestPaper/TestPaperDo.php',
		'params':{'m':'vTestPaperPage'}
	}
};var TestPaperReqDoRes = {
	'vTestPaperPage':{}
};var TestPaperReqRes = new function (){ 
	this.vTestPaperPage = new function(){
		this.gfRes = function(pRes){			
			TestPaperReqRes.vTestPaperPage.Dor.fResLog(pRes);
			TestPaperReqRes.vTestPaperPage.fResDo();			
		};this.gfResFail = function(){
			var Dor = TestPaperReqRes.vTestPaperPage.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			TestPaperReqRes.vTestPaperPage.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			TestPaperReqRes.vTestPaperPage.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = TestPaperReqDoRes[this.Dor.ReqName];
			TestPaperViewRender.vTestPaperPage.Res(Res);			
		};this.Init=function(){
			this.Dor = new ReqDo(TestPaperReqDoConfig, TestPaperReqDoRes, 'vTestPaperPage', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'vTestPaperPageReq');
			this.Dor.Init();
		};this.Dor = null;				
	};
	this.Init=function(){
		this.vTestPaperPage.Init();
		TestPaperReqRes.vTestPaperPage.Dor.fReqDo();
	};
};var TestPaperViewRender = new function(){	
	this.vTestPaperPage = new function(){
		this.Res = function(Res){			
			if(parseInt(Res.IsLoggedIn)==0){
				window.location.href = "login.php";
				return;
			}
			var user = Res.user;
			var vTestPaperPage = Res.vTestPaperPage;
			var mdTestPaperActive = Res.mdTestPaperActive;
			var vMenu = Res.vMenu;
			var mdModule = Res.mdModule;
			
			if(mdModule!=null)
			for(var i=0; i < mdModule.length; i++){					
				switch(parseInt(mdModule[i].menu_id)){
					case 9: mdModule[i].redirect_to = "ActiveAssignmentRes.php"; break;
				}	
			}
			if(mdTestPaperActive!=null)
			for(var i=0; i < mdTestPaperActive.length; i++){
				mdTestPaperActive[i].user_tp_status = parseInt(mdTestPaperActive[i].user_tp_status);
				mdTestPaperActive[i].IsQuizToStart = mdTestPaperActive[i].user_tp_status <= 1;
				mdTestPaperActive[i].IsQuizToContinue = mdTestPaperActive[i].user_tp_status == 1;
				mdTestPaperActive[i].IsTimedOut = mdTestPaperActive[i].user_tp_status == 3;
				mdTestPaperActive[i].qn_count = parseInt(mdTestPaperActive[i].qn_count);
				mdTestPaperActive[i].time_limit = parseInt(mdTestPaperActive[i].time_limit);
			}
			
			this.Out(user, vTestPaperPage, mdTestPaperActive, vMenu, mdModule);
		};this.Out = function(user, vTestPaperPage, mdTestPaperActive, vMenu, mdModule){						
			$("#myFullName").html(user.full_name);
			$("#myUserName").html(user.user_name);
			
			var rendered = Mustache.render(vMenu,{menus: mdModule});
			$("#menuContent").html(rendered);
			
			var strTestPaperPage = Mustache.render(vTestPaperPage, {'assignment': mdTestPaperActive});
			$('#pageContent').html(strTestPaperPage);			
			$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
		};
	};this.Init=function(){
		
	};		
}
