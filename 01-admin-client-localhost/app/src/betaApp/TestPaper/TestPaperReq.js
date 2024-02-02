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
	this.vTestPaperPage = null;
	this.Init=function(){
		this.vTestPaperPage = new gfMgr.DefServiceReq(
			TestPaperReqRes,
			TestPaperReqDoConfig,
			TestPaperReqDoRes, 
			'vTestPaperPage',
			function(){
				var Res = TestPaperReqDoRes[this.Dor.ReqName];
				TestPaperViewRender.vTestPaperPage.Res(Res);
			}
		);
	
		this.vTestPaperPage.Init();
		//console.log(131);
		this.vTestPaperPage.Dor.fReqDo();
	};
	/*this.vTestPaperPage = new function(){
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
	};*/
};var TestPaperViewRender = new function(){	
	this.vTestPaperPage = new function(){
		this.Res = function(Res){			

			var vTestPaperPage = Res.vTestPaperPage;
			var mdTestPaperActive = Res.mdTestPaperActive;

			if(mdTestPaperActive!=null)
				for(var i=0; i < mdTestPaperActive.length; i++){
				}
			
			this.Out(Res);
		};this.Out = function(Res){			
			var strTestPaperPage = Mustache.render(Res.vTestPaperPage, {'assignment': Res.mdTestPaperActive});
			$('#pageContent').html(strTestPaperPage);			
			$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
		};
	};this.Init=function(){
		
	};		
}
