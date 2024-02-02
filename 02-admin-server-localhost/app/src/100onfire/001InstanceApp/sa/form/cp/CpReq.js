$(document).ready(function(){
		//gfMgr.Alert(1);	
		var f = function(){
			CpViewRender.Init(); CpReqRes.Init();		
		};
		f();//gfMgr.RunAfGivSec(f,10);
	}
);
var CpReqDoConfig = { 
	'vLoad':{'url':'form/cp/CpDo.php',
		'params':{'m':'vLoad'}
	},'mdLoad':{'url':'form/cp/CpDo.php',
		'params':{'m':'mdLoad'}
	},'mdLoadHis':{'url':'form/cp/CpDo.php',
		'params':{'m':'mdLoadHis'}
	}
};var CpReqDoRes = {
	'vLoad':{},/*vLoad,vLoadVal,vEyeDet,vHisDet,vLoadHisModal,vEye,mdLoad*/
	'mdLoad':{},
	'mdLoadHis':{}
};var CpReqRes = new function (){ 
	this.vLoad = new function(){
		this.gfRes = function(pRes){
			CpReqRes.vLoad.Dor.fResLog(pRes);
			CpReqRes.vLoad.fResDo();			
		};this.gfResFail = function(){
			var Dor = CpReqRes.vLoad.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			CpReqRes.vLoad.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			CpReqRes.vLoad.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = CpReqDoRes[this.Dor.ReqName];			
			$('#DivCp').html(Res.vLoad);
			$('#DivCpModalHis').html(Res.vLoadHisModal);
			$('#DivViewEye').html(Res.vEye);			
			CpViewRender.mdLoad.Res(Res);			
		};this.Init=function(){
			this.Dor = new ReqDo(CpReqDoConfig, CpReqDoRes, 'vLoad', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'vLoadReq');
			this.Dor.Init();
		};this.Dor = null;				
	};this.mdLoad = new function(){
		this.gfRes = function(pRes){
			CpReqRes.mdLoad.Dor.fResLog(pRes);
			CpReqRes.mdLoad.fResDo();			
		};this.gfResFail = function(){
			var Dor = CpReqRes.mdLoad.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			CpReqRes.mdLoad.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			CpReqRes.mdLoad.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = CpReqDoRes[this.Dor.ReqName];				
			CpViewRender.mdLoad.Res(Res);			
		};this.Init=function(){
			this.Dor = new ReqDo(CpReqDoConfig, CpReqDoRes, 'mdLoad', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'mdLoadReq');
			this.Dor.Init();
		};this.Dor = null;				
	};this.mdLoadHis = new function(){
		this.gfRes = function(pRes){
			CpReqRes.mdLoadHis.Dor.fResLog(pRes);
			CpReqRes.mdLoadHis.fResDo();			
		};this.gfResFail = function(){
			var Dor = CpReqRes.mdLoadHis.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			CpReqRes.mdLoadHis.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			CpReqRes.mdLoadHis.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = CpReqDoRes[this.Dor.ReqName];				
			CpViewRender.mdLoadHis.Res(Res);			
		};this.Init=function(){
			this.Dor = new ReqDo(CpReqDoConfig, CpReqDoRes, 'mdLoadHis', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'mdLoadHisReq');
			this.Dor.Init();
		};this.Dor = null;				
	};
	this.Init=function(){
		this.vLoad.Init();
		this.mdLoad.Init();
		this.mdLoadHis.Init();
		CpReqRes.vLoad.Dor.fReqDo();
	}
};var CpViewRender = new function(){	
	this.mdLoad = new function(){
		this.Res = function(Res){						
			CpReqDoRes['mdLoad'] = {'mdLoad':Res.mdLoad,'dbMaxLoad':Res.dbMaxLoad};
			this.Out();
		};this.Out = function(){
			var Res = CpReqDoRes['mdLoad'];				
			var vLoadRes = CpReqDoRes['vLoad'];			
			var strLoad = Mustache.render(vLoadRes.vLoadVal, {'loadval': Res.mdLoad,'dbMaxLoad':Res.dbMaxLoad}); 						
			$('#DivCpLoadVal').html(strLoad);
			CpViewRender.mdLoad.Tmr.fRun();
		};this.gfTmrStart = function(){			
			CpViewRender.mdLoad.Tmr.fStart()			
		};this.gfTmrTask = function(){			
			CpReqRes.mdLoad.Dor.fReqDo();
		};this.Init=function(){
			this.Tmr = new TmrMgr(2,'DivCpTmr', this.gfTmrStart, this.gfTmrTask);	
		};this.Tmr = null;
	};this.eye = new function(){
		this.Res = function(Res){
			this.Out();
		};this.Out = function(){	
			var vLoadRes = CpReqDoRes['vLoad'];			
			var mdEye = [CpReqRes.vLoad.Dor,CpReqRes.mdLoad.Dor,CpReqRes.mdLoadHis.Dor];						
			for(I=0;I<mdEye.length;I++){
				var Dor = mdEye[I];
				var strEye = Mustache.render(vLoadRes.vEyeDet, {'mdEye': Dor});				
				$('#' + Dor.ReqName + 'Eye').html(strEye);	
			}			
		};
	};this.mdLoadHis = new function(){
		this.Res = function(Res){									
			this.Out();
		};this.Out = function(){			
			var vLoadRes = CpReqDoRes['vLoad'];					
			var Res = CpReqDoRes['mdLoadHis'];							
			var strHis = Mustache.render(vLoadRes.vHisDet, {'loadhis': Res.mdLoadHis});			
			$('#dlgCpLoadDet').html(strHis);
		};
	};this.Init=function(){
		this.mdLoad.Init();
	}	
}
