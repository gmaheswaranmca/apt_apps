
var gfMgr = new function (){
	this.RunAfSec = function(taskCode){
		this.RunAfGivSec(taskCode,1);
	};this.RunAfGivSec = function(taskCode,secAft){
		setTimeout(taskCode,1000*secAft);
	};this.Req = function(url,params,gfRes,gfResFail){
		$.post(url, params, gfRes, "json").fail(gfResFail);
	};this.HtmlMinify = function(pHtml){
		//https://stackoverflow.com/questions/10805125/how-to-remove-all-line-breaks-from-a-string
		//\s Are considered as white-spaces characters: [ \f\n\r\t\v​\u00a0\u1680​\u2000​-\u200a\u2028\u2029\u202f\u205f\u3000\ufeff]
		// I have used 
		//https://stackoverflow.com/questions/26757034/use-jquery-to-minify-html
		return pHtml.replace(/\n\s+|\n/g, "");
	};this.ReqCsv = function(url,params,gfRes,gfResFail){
		$.post(url, params, gfRes, "text").fail(gfResFail);
	};this.ToCsv = function(pCsvText, pCsvFileName){
		gfMgr.Download(pCsvText, pCsvFileName + '.csv','text/csv;encoding:utf-8');
		return;
		var uri = 'data:application/csv;filename:' + pCsvFileName + '.csv'  + ';charset=UTF-8,' + encodeURIComponent(pCsvText);		
		window.open(uri, pCsvFileName + '.csv');
	};this.Log=function(pLog){
		console.log(pLog);
	};this.Alert=function(pAlert){
		alert(pAlert);
	};this.DlgSecretCodeOpen=function(Fn,Arg){
		$('#AppSecretCode').val('');
		gfMgr.AfterModalFn = Fn;
		gfMgr.AfterModalArg = Arg;
		$('#AppSecretCodeErr').html('&nbsp;');
		return false;
	};this.DlgSecretCodeAccept=function(){
		var srcCode = moment().format('YYYYMMDDdddHH');
		var givenCode = $('#AppSecretCode').val();		
		if(srcCode != givenCode){
			$('#AppSecretCodeErr').html('<span style="color:red;">***Wrong Secret Code***</span>');
			gfMgr.RunAfGivSec(function(){$('#AppSecretCodeErr').html('&nbsp;');},10);
			return false;
		}
		gfMgr.AfterModalFn(gfMgr.AfterModalArg);
		$('#dlgSecretCode').modal('hide');
		return false;
	};
	this.AfterModalFn = null;		
	this.AfterModalArg = null;
	this.Download = function(content, fileName, mimeType) {
		  var a = document.createElement('a');
		  mimeType = mimeType || 'application/octet-stream';
		  if (navigator.msSaveBlob)  // IE10
			 navigator.msSaveBlob(new Blob([content], {type: mimeType}), fileName);
		  else if (URL && 'download' in a) { //html5 A[download]
			a.href = URL.createObjectURL(new Blob([content], {type: mimeType}));
			a.setAttribute('download', fileName);
			document.body.appendChild(a);
			a.click();
			document.body.removeChild(a);
		  }else 
			 location.href = 'data:application/octet-stream,' + encodeURIComponent(content); // only this mime type is supported			
	};	
	this.JsonToCsv = function(headers,objArray) {
		if (headers) objArray.unshift(headers);		
		var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;
		var str = '';
		var fields = '';
		for (var i = 0; i < array.length; i++) {
			var line = '';
			for (var index in array[i]) {
				if (line != '') line += ',';
				line += '"' + array[i][index] + '"';
			}
			str += line + '\r\n';
		}
		return str;
	}
	this.CheckboxClickToSelUnsel = function(t) {
		for (var e = null, i = document.querySelectorAll("#" + t + ' input[type="checkbox"]'), n = 0; n < i.length; n++)
			i[n].setAttribute("data-index", n);
		for (n = 0; n < i.length; n++)
			i[n].addEventListener("click", function (t) {
				if (e && t.shiftKey) {
					var n = parseInt(e.getAttribute("data-index")),
					c = parseInt(this.getAttribute("data-index")),
					r = this.checked,
					a = n,
					l = c;
					if (n > c)
						a = c, l = n;
					for (var d = 0; d < i.length; d++)
						a <= d && d <= l && (i[d].checked = r)
				}
				e = this
			});
	};this.CheckboxClickOnlyOne = function(t) {
		for (var e = null, i = document.querySelectorAll("#" + t + ' input[type="checkbox"]'), n = 0; n < i.length; n++)
			i[n].setAttribute("data-index", n);		
		for (n = 0; n < i.length; n++)
			i[n].addEventListener("click", function (theEvent) {
				gfMgr.CheckboxSelAllNone(t,false);
				this.checked = true;
			}
		);
	};this.CheckboxSelAllNone = function(t,pVal) {
		for (var e = null, i = document.querySelectorAll("#" + t + ' input[type="checkbox"]'), n = 0; n < i.length; n++)
			i[n].checked = pVal;
	};this.CheckboxValues = function(t,ids,keys) {
		var res = [];
		for (var e = null, i = document.querySelectorAll("#" + t + ' input[type="checkbox"]'), n = 0; n < i.length; n++){
			if(i[n].checked) {
				var id = i[n].value;
				var rec = {'id':id}
				for(var J=0;J<ids.length;J++)
					rec[keys[J]] = $('#' + ids[J]+id).val();
				res.push(rec);
			}
		}
		//console.log(res);
		return res;
	};this.DefServiceReq = function(ValReqRes,ValReqDoConfig,ValReqDoRes,ValvReqName,ValPtrTofResDo){
		this.Dor = null;
		this.ReqRes = ValReqRes;		
		this.ReqDoConfig = ValReqDoConfig;
		this.ReqDoRes = ValReqDoRes;
		this.vReqName = ValvReqName;
		this.PtrTofResDo = ValPtrTofResDo;		
		this.gfRes = function(pRes){
			//alert(ValReqRes);alert(ValvReqName);
			ValReqRes[ValvReqName].Dor.fResLog(pRes);
			ValReqRes[ValvReqName].fResDo();			
		};this.gfResFail = function(){			
			var Dor = ValReqRes[ValvReqName].Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			this.ReqRes[this.vReqName].Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			this.ReqRes[this.vReqName].Dor.fReqDo();
		};this.fResDo = function(){			
			this.PtrTofResDo();			
		};this.Init=function(){
			//alert(this.ReqRes);	alert(this.vReqName);
			this.Dor = new ReqDo(this.ReqDoConfig, this.ReqDoRes, this.vReqName, 
								this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,this.vReqName + 'Req');
			this.Dor.Init();
		};				
	};
	
};
//gfMgr.Alert('ABCD');
function TmrMgr(TmrRepeatSec, vID, gfTmrStart, gfTask){
	this.TmrRepeatSec = TmrRepeatSec; 
	this.vID = vID;
	this.TmrRunSec = 1;
	this.gfTmrStart = gfTmrStart;
	this.gfTask = gfTask;
	this.IsTmrRunning = function(){
		return this.TmrRepeatSec > 1;
	};this.fRun = function(){
		gfMgr.RunAfSec(this.gfTmrStart);
	};this.fStart = function(){		
		if(vID != '') $('#' + vID).html(this.TmrRunSec);
		if(this.TmrRepeatSec == this.TmrRunSec){
			this.gfTask();
			this.TmrRunSec = 1;
		}else {						
			this.fRun();
			this.TmrRunSec++;
		}		
	};
}
function ReqDo(ReqDoConfig, ReqDoRes, ReqName, gfRes, gfResFail, gfTmrStart, gfTmrTask, TmrViewID){
	this.ReqDoRes = ReqDoRes;
	this.ReqName = ReqName;	
	this.gfRes = gfRes;
	this.gfResFail = gfResFail;		
	this.gfTmrStart = gfTmrStart;
	this.gfTmrTask = gfTmrTask;
	this.TmrViewID = TmrViewID;
/**/this.Config = ReqDoConfig[this.ReqName];
	this.SucCount = 0;
	this.FailCount = 0;	
/**/this.fReqDo = function(){				
		if(typeof(this.Config.params.is_csv) !== 'undefined' && this.Config.params.is_csv==1)
			gfMgr.ReqCsv(this.Config.url, this.Config.params, this.gfRes, this.gfResFail);
		else
			gfMgr.Req(this.Config.url, this.Config.params, this.gfRes, this.gfResFail);
		
	};this.fResLog = function(pRes){
		this.SucCount ++;
		gfMgr.Log(this.ReqName + '#' + this.SucCount + ':Request Succeeded.\n');					
		this.ReqDoRes[this.ReqName] = pRes;
	};this.fResFailLog = function(){
		this.FailCount ++;
		gfMgr.Log(this.ReqName + '#' + this.FailCount + ':Request Failed.\n');					
	};
/**/
	this.Init=function(){
		this.Tmr = new TmrMgr(5,TmrViewID, this.gfTmrStart, this.gfTmrTask);
	};this.Tmr = null;	
}
