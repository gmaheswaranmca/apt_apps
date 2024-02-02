$(document).ready(function(){
		//gfMgr.Alert(12121);	
		var f = function(){
			$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
			LoginViewRender.Init(); LoginReqRes.Init();
		};
		f();//gfMgr.RunAfGivSec(f,2);//
	}
);
var LoginReqDoConfig = { 
	'vLoginPage':{'url':'TestPaper/TestPaperDo.php',
		'params':{'m':'vLoginPage'}
	},
	'mdLoginDo':{'url':'TestPaper/TestPaperDo.php',
		'params':{'m':'mdLoginDo'}
	}
};var LoginReqDoRes = {
	'vLoginPage':{},
	'mdLoginDo':{}
};var LoginReqRes = new function (){ 
	this.vLoginPage = new function(){
		this.gfRes = function(pRes){			
			LoginReqRes.vLoginPage.Dor.fResLog(pRes);
			LoginReqRes.vLoginPage.fResDo();			
		};this.gfResFail = function(){
			var Dor = LoginReqRes.vLoginPage.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			LoginReqRes.vLoginPage.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			LoginReqRes.vLoginPage.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = LoginReqDoRes[this.Dor.ReqName];
			LoginViewRender.vLoginPage.Res(Res);			
		};this.Init=function(){
			this.Dor = new ReqDo(LoginReqDoConfig, LoginReqDoRes, 'vLoginPage', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'vLoginPageReq');
			this.Dor.Init();
		};this.Dor = null;				
	};this.mdLoginDo = new function(){
		this.gfRes = function(pRes){
			LoginReqRes.mdLoginDo.Dor.fResLog(pRes);
			LoginReqRes.mdLoginDo.fResDo();			
		};this.gfResFail = function(){
			var Dor = LoginReqRes.mdLoginDo.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			LoginReqRes.mdLoginDo.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			LoginReqRes.mdLoginDo.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = LoginReqDoRes[this.Dor.ReqName];							
			//return;
			if(parseInt(Res.IsLoggedIn)==1)
				window.location.href = "ActiveTestPaper.php";
			else
				alert("Invalid Login User Name / Password");
				
		};this.Init=function(){
			this.Dor = new ReqDo(LoginReqDoConfig, LoginReqDoRes, 'mdLoginDo', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'mdLoginDoReq');
			this.Dor.Init();
		};this.Dor = null;				
	};this.Init=function(){
		this.vLoginPage.Init();
		this.mdLoginDo.Init();
		LoginReqRes.vLoginPage.Dor.fReqDo();		
	};
};var LoginViewRender = new function(){	
	this.vLoginPage = new function(){
		this.Res = function(Res){			
			if(parseInt(Res.IsLoggedIn)==1){
				window.location.href = "ActiveTestPaper.php";
				return;
			}
			var vLoginPage = Res.vLoginPage;
			
			this.Out(vLoginPage);			
		};this.Out = function(vLoginPage){
			$("#pageContent").html(vLoginPage);		
			$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
		};
	};this.Init=function(){
		
	};	
	this.MoveToPassword=function() {
		if (event.keyCode == 13) {
			$("#uxPassword").focus();
		}
	};
	this.FireLogin=function() {
		if (event.keyCode == 13) {
			LoginViewRender.DoLogin()
		}
	};
	this.DoLogin=function() {
		if($("#uxUserName").val() == ""){
			$("#uxUserName").focus();
			alert("Please Enter User Name");			
			return;
		}
		if($("#uxPassword").val() == ""){
			$("#uxPassword").focus();
			alert("Please Enter Password");			
			return;
		}
		LoginReqDoConfig.mdLoginDo.params['txtLogin'] = $("#uxUserName").val();
		LoginReqDoConfig.mdLoginDo.params['txtPass'] = $("#uxPassword").val();
		console.log(LoginReqDoConfig.mdLoginDo.params);
		LoginReqRes.mdLoginDo.Dor.fReqDo();
	}
}
