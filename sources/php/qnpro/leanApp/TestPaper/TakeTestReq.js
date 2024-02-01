$(document).ready(function(){
		//gfMgr.Alert(1100);	
		var f = function(){
			$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
			TakeTestViewRender.Init(); TakeTestReqRes.Init();		
		};
		f();//gfMgr.RunAfGivSec(f,10);		
	}
);
var TakeTestReqDoConfig = { 
	'vTakeTestPage':{'url':'TestPaper/TestPaperDo.php',
		'params':{'m':'vTakeTestPage'}
	}
};var TakeTestReqDoRes = {
	'vTakeTestPage':{}
};var TakeTestReqRes = new function (){ 
	this.vTakeTestPage = new function(){
		this.gfRes = function(pRes){			
			TakeTestReqRes.vTakeTestPage.Dor.fResLog(pRes);
			TakeTestReqRes.vTakeTestPage.fResDo();			
		};this.gfResFail = function(){
			var Dor = TakeTestReqRes.vTakeTestPage.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			TakeTestReqRes.vTakeTestPage.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			TakeTestReqRes.vTakeTestPage.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = TakeTestReqDoRes[this.Dor.ReqName];
			TakeTestViewRender.vTakeTestPage.Res(Res);			
		};this.Init=function(){
			this.Dor = new ReqDo(TakeTestReqDoConfig, TakeTestReqDoRes, 'vTakeTestPage', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'vTakeTestPageReq');
			this.Dor.Init();
		};this.Dor = null;				
	};
	this.Init=function(){
		this.vTakeTestPage.Init();
		TakeTestReqRes.vTakeTestPage.Dor.fReqDo();
	};
};var TakeTestViewRender = new function(){	
	this.vTakeTestPage = new function(){
		this.Res = function(Res){			
			if(parseInt(Res.IsLoggedIn)==0){
				window.location.href = "login.php";
				return;
			}
			var user = Res.user;
			var vTakeTestPageInstruction = Res.vTakeTestPageInstruction;
			var mdAssignment = Res.mdAssignment;
			var vMenu = Res.vMenu;
			var mdModule = Res.mdModule;
			
			if(mdModule!=null)
			for(var i=0; i < mdModule.length; i++){					
				switch(parseInt(mdModule[i].menu_id)){
					case 9: mdModule[i].redirect_to = "ActiveAssignmentRes.php"; break;
				}	
			}
			if(mdAssignment.IsValidAssignment && mdAssignment.mdUserTestTakingPaper !=null){
				var TTT = mdAssignment.mdUserTestTakingPaper;
				for(var i=0; i < TTT.length; i++){				
					TTT[i].user_tp_status = parseInt(TTT[i].user_tp_status);
					TTT[i].IsQuizToStart = TTT[i].user_tp_status <= 1;
					TTT[i].IsQuizToContinue = TTT[i].user_tp_status == 1;
					TTT[i].IsTimedOut = TTT[i].user_tp_status == 3;
					TTT[i].IsFinished = TTT[i].user_tp_status == 2 || TTT[i].user_tp_status == 3;
					TTT[i].qn_count = parseInt(TTT[i].qn_count);
					TTT[i].time_limit = parseInt(TTT[i].time_limit);
				}				
				this.PreparePaper(Res);
				//alert(1123121);
				console.log(Res);
			}
			
			this.Out(Res, user, vTakeTestPageInstruction, mdAssignment, vMenu, mdModule);
		};this.Out = function(Res, user, vTakeTestPageInstruction, mdAssignment, vMenu, mdModule){						
			$("#myFullName").html(user.full_name);
			$("#myUserName").html(user.user_name);

			var strTakeTestPageTitle = Mustache.render(Res.vTakeTestPageTitle, {'quiz': mdAssignment.mdUserTestTakingPaper} ); 				
			$("#myTitle").html(strTakeTestPageTitle);	  		
		
			var rendered = Mustache.render(vMenu,{menus: mdModule});
			$("#menuContent").html(rendered);
			
			alert(123)		
			TakeTestViewRender.vTakeTestPage.OutInstruction();

			//
			$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
			
			//console.log(mdAssignment.mdQuestion)
			//console.log(mdAssignment.mdAnswer)
		};
		this.PreparePaper = function(Res){			
			Res.Qs = [];
			Res.Pgr = [];
			Res.PagerIndex = 1;
			Res.QStarted = false;	
			Res.SnapIs = false;
			Res.QueryQuestion = function(pDispIdxOneBased){ //PagerIndex points CurrentSnapshotQuestionIndex
				var Res = TakeTestReqDoRes.vTakeTestPage;
				var vDispIdx = pDispIdxOneBased - 1;		
				var oPgr = Res.Pgr[vDispIdx];
				if(oPgr == null) return null;
				var vQIdx = oPgr.qno - 1;
				var oQuestion = Res.Qs[vQIdx];
				return oQuestion;
			} 
			var fnQUserAnsId = function(){	
				var a = parseInt(this.user_answer_id); 
				var b = parseInt(this.user_answering_id);
				return b!=-1 ? b : a;
			},fnIsAnswering = function(){	
				return parseInt(this.user_answering_id) != -1;
			},fnIsAnswered = function(){	
				return parseInt(this.QUserAnsId()) != -1;
			},fnIsLastQn = function(){	
				var Res = TakeTestReqDoRes.vTakeTestPage;
				return (this.qno_l == Res.Pgr.length);
			},fnqIsCurrent = function(){		
				var Res = TakeTestReqDoRes.vTakeTestPage;
				return this.qno_l == Res.PagerIndex;
			},fnIsNotAnswered = function(){	
				return !this.IsAnswered();
			},fnqIsUserAnswered = function(){	
				var Res = TakeTestReqDoRes.vTakeTestPage;
				var pI = this.qno_a-1;				
				return pI!=-1 && parseInt(this.id) == parseInt(Res.Qs[pI].QUserAnsId());//answer_id
			},fnqGet=function(){	
				var Res = TakeTestReqDoRes.vTakeTestPage;
				var pI = this.idx-1;
				var pQID = this.qno - 1;				
				var aq = Res.Qs[pQID];
				//console.log({pI:pI, qno_a:aq.qno_a, qno_l:aq.qno_l, aq:aq});
				return aq;
			},fnIsPagerLine = function(){	
				return this.idx % 5 == 0;
			}	;
			var Answer = Res.mdAssignment.mdAnswer[0];
			this.ShuffleRuleDo();
			for(var I=0; I < Res.mdAssignment.mdQuestion.length; I++){
				var Qn = Res.mdAssignment.mdQuestion[I];
				Qn.qno_a = I + 1;
				Qn.QUserAnsId = fnQUserAnsId;
				Qn.IsAnswering = fnIsAnswering;
				Qn.IsAnswered = fnIsAnswered;
				Qn.IsLastQn = fnIsLastQn;				
					var Key = 'qn' + Qn.question_id;
				Qn.user_answer_id = Answer.hasOwnProperty(Key) ? Answer[Key] : -1;
				Qn.user_answering_id = -1;				
				//
				Qn.answer = [];
				console.log(Qn);
				Qn.options = JSON.parse(Qn.options);
				for(var J=0; J < Qn.options.length; J++){
					var QnOpt = Qn.options[J];
					QnOpt.IsUserAnswered = false; //fnqIsUserAnswered;
					Qn.answer.push(QnOpt);
				}
								
				//
				Res.Qs.push(Qn);
				//
				Qn.IsNotVisited = true;	
				//
				CurrRulesIsThere = false;
				Qn.qno_l = this.nextRandNo(I);
				Qn.IsCurrent = fnqIsCurrent;
				Qn.IsNotAnswered = fnIsNotAnswered;
				
				var PgrEl = {qno: Qn.qno_l, idx:Qn.qno_a};
				PgrEl.Q = fnqGet;
				PgrEl.IsPagerLine = fnIsPagerLine;
				Res.Pgr.push(PgrEl);
			}
			for(var i=0; i < Res.Pgr.length; i++){//			
				var oPgr = Res.Pgr[i];
				var oQ = Res.Qs[oPgr.qno-1];
				oQ.qno_l = oPgr.idx;				
			}//
		};
		this.nextRandNo = function(pI){
			return  (!CurrRulesIsThere) ? this.nextRandNoForAll(pI) : this.nextRandNoByRule(pI);			
		};this.nextRandNoForAll = function(pI){			
			var Res = TakeTestReqDoRes.vTakeTestPage;			
			var rnd_max = Res.mdAssignment.mdQuestion.length;
			var rnd_no = pI + 1;			
			if(parseInt(Res.mdAssignment.ShuffleIsThere)==1){
				rnd_no = this.randNo(rnd_max);
				while(this.existQNo(rnd_no))
					rnd_no = this.randNo(rnd_max);
			}			
			return rnd_no;
		};this.nextRandNoByRule = function(pI){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			var pFrom = CurrSuffledRules[CurrRuleSufIdx].rule.from;
			var pTo = CurrSuffledRules[CurrRuleSufIdx].rule.to;
			var SC = CurrSuffledRules[CurrRuleSufIdx].rule.suffleCount;
			var v_mx = pTo - pFrom + 1;
			
			var v_r = JsController.apdata.QuestionsRes.r;
			var v_rq = v_r.question; 
			
			var rnd_max = v_rq.length;			
			var rnd_no = pI + 1;
			
			if(parseInt(Res.mdAssignment.ShuffleIsThere)==1){
				rnd_no = this.randNo(v_mx) + pFrom - 1;
				while(this.existQNo(rnd_no))
					rnd_no = this.randNo(v_mx) + pFrom - 1;
				SC++;
				CurrSuffledRules[CurrRuleSufIdx].rule.suffleCount = SC;
				if(SC == v_mx) CurrRuleSufIdx ++;
			}			
			return rnd_no;
		};this.randNo = function(pMax){ // util function
			var vNo = Math.floor(Math.random() * pMax) + 1;
			return vNo;
		};this.existQNo=function(pNewQNo){		
			var Res = TakeTestReqDoRes.vTakeTestPage;
			for(var i=0; i < Res.Pgr.length; i++)
				if(pNewQNo == Res.Pgr[i].qno)
					return true;			  
			return false;
		};this.ShuffleRuleDo = function(){			
			var Res = TakeTestReqDoRes.vTakeTestPage;
			CurrRulesIsThere = false;
			CurrSuffledRules=[];			
			if(parseInt(Res.mdAssignment.ShuffleIsThere)!=1) return;		
			var v_r = Res.mdAssignment.mdUserTestTakingPaper;				
			for(i=0;i<vSuffleRule.length;i++){
				if(vSuffleRule[i].name == v_r[0].quiz_name){
					CurrRules = vSuffleRule[i];
					CurrRulesIsThere = true;
					break;
				}
			}if(!CurrRulesIsThere) return;
			if(CurrRulesIsThere){				
				CurrSuffledRules=[];
				var rnd_max = CurrRules.rule.length;				
				for(i=0;i < rnd_max;i++){					
					var rnd_no = this.randNo(rnd_max);
					while(this.existRuleNo(rnd_no))
						rnd_no = this.randNo(rnd_max);
					var aSuffledRule = {
						sno: i+1, 
						newRuleNo: rnd_no,
						rule: CurrRules.rule[rnd_no-1]
					};
					CurrSuffledRules.push(aSuffledRule);
				}
			}		
		};this.existRuleNo=function(pNewRuleNo){		
			for(var i=0; i < CurrSuffledRules.length; i++)
				if(pNewRuleNo == CurrSuffledRules[i].newRuleNo)
					return true;			  
			return false;
		};this.OutQnNum = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			$("#myQMatrix").html(Mustache.render(
				Res.vTakeTestQnNum, 
				{pager:Res.Pgr}
			));
		};this.OutQnNumDiv = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			//**********************
			if(Res.SnapIs==true) return;
			Res.SnapIs = true;	
			$("#testPagers").css("display","block");
			$("#menuContent").css("display","none");
			$("#testPagers").html(Res.vTakeTestQnNumDiv);
			//if(Res.QStarted == true)
			//	JsController.apdata.qpaper.timerdata.init();			
			//**********************
		};this.OutQn = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			var vIdx = Res.PagerIndex; //QuestionIndex;
			var vq = Res.QueryQuestion(vIdx);
			if(vq == null) return;			
			vq.IsNotVisited = false;
			$("#pageContent").html(Mustache.render(
				Res.vTakeTestPageQn, 
				{question:vq}
				));
			Res.QStarted = true;		
			AppUtil.focus('pageContent','myHeader');//**************************
		};this.OutInstruction = function(){
			//**********************
			var Res = TakeTestReqDoRes.vTakeTestPage;
			var IsValidAssignment = parseInt(Res.mdAssignment.IsValidAssignment)==1;			
			var strTakeTestPageInstruction = Mustache.render(Res.vTakeTestPageInstruction, {'IsValidAssignment':IsValidAssignment,'quiz': Res.mdAssignment.mdUserTestTakingPaper});
			$('#pageContent').html(strTakeTestPageInstruction);						
			//**********************
		}; this.OutQnAll = function(){
			TakeTestViewRender.vTakeTestPage.OutQnNumDiv();
			TakeTestViewRender.vTakeTestPage.OutQnNum();
			TakeTestViewRender.vTakeTestPage.OutQn();
		};  this.NextToInstruction = function(){
			TakeTestViewRender.vTakeTestPage.OutQnAll();
		};
	};this.Init=function(){
		
	};this.LoadQn=function(pQno){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		Res.PagerIndex = pQno; // QuestionIndex=pQno;
		TakeTestViewRender.vTakeTestPage.OutQn();
	};this.NextQn=function(pQno){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		if(Res.PagerIndex == (Res.Qs.length+1)) return;		
		Res.PagerIndex++;
		TakeTestViewRender.vTakeTestPage.OutQn();
	};this.PrevQn=function(pQno){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		if(Res.PagerIndex == 1) return;		
		Res.PagerIndex--;
		TakeTestViewRender.vTakeTestPage.OutQn();
	}
}


function TimerPaperData(){
	this.DbQuizStartTime = null;
	this.DbQuizServerNow = null;
	this.ClientQuizStartTime = null;
	this.ClientNow = null;
	this.QuizSecs = null;
	this.QzTimeIsTimedOut = false;
	
	this.initIs = false;
	this.init =function(){		
		var Res = TakeTestReqDoRes.vTakeTestPage;
		Res.timerdata.initializer();//***********************
	}
	this.initializer =function(){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		if(this.initIs == true) return;
		this.initIs = true;
		var v_r = Res.mdAssignment.mdUserTestTakingPaper; // JsController.apdata.pgQueryRes.r.assignment;
		var uq_added_date = v_r[0].test_started_time;
		var quiz_time = v_r[0].time_limit;
		var now_server = Res.now_server;
		
		this.DbQuizStartTime = new Date(uq_added_date);
		this.DbQuizServerNow = new Date(now_server);
		this.ClientNow = new Date();
		
		var vQuizStartToNow = Math.abs(this.DbQuizServerNow.getTime() - this.DbQuizStartTime.getTime()) / 1000;
		this.ClientNow = new Date();
		this.ClientQuizStartTime = new Date();
		this.ClientQuizStartTime.setSeconds(this.ClientNow.getSeconds() - vQuizStartToNow);
		var vStartToNow = Math.abs(this.ClientNow.getTime() - this.ClientQuizStartTime.getTime()) / 1000;
		var vQuizMins = parseInt(quiz_time);
		this.QuizSecs =  vQuizMins * 60;
		var vMins = vQuizMins - (vStartToNow / 60);
		var vSecs = vStartToNow % 60;
		
		vMins=parseInt(vMins); vSecs=parseInt(vSecs);
		Res.timer = new TimerPaper("myRemainingTime, #myRemainingTime02", "myTestStartAt", vMins, vSecs, this.ClientQuizStartTime, this.QuizSecs);
		Res.timer.Init_Timer(); //***********************
	};	
	this.endTestByTimeOut =function(){
			this.QzTimeIsTimedOut = true;
			//JsController.FinishTest(); //.... do here
			//JsController.apser.mdwqzfin.SerCall();**************************************
			//console.log("Going To Finish By Time Out");
	}
}
function TimerPaper(pIds, pStartAtId, pmins, psecs, pStartTime, pQuizSec){
	this.Ids = pIds;
	this.StartAtId = pStartAtId;
	this.TimerRunning = false;
	this.mins = pmins;
	this.secs = psecs;
	this.StartTime = pStartTime;
	this.QuizSec = pQuizSec;	
	//
    this.Init_Timer = function() 
	//call the Init function when u need to start the timer
	{            
		/* alert(this.StartAtId + " " + this.TimerRunning + " " +
			this.mins + " " + this.secs + " " + 
			this.StartTime + " " + this.QuizSec); */
		//vStr = this.Pad(0) + ":" + this.Pad(0)
		//$("#" + this.Ids).html(vStr);	
		this.outTmrs(this.Ids,0,0)  //new
		this.StopTimer();
		this.StartTimer();
	};

    this.StopTimer =  function () {
		if (this.TimerRunning)
			clearTimeout(this.TimerID);
		this.TimerRunning = false;
	};
	this.TimerID = "";
	this.StartTimer = function () {
		var Res = TakeTestReqDoRes.vTakeTestPage;
		//alert("Timer" + 2323);
		var timer = Res.timer; //JsController.apdata.qpaper.timer;
		//console.log(timer);
		//console.log("hello");
		
		timer.StartTimerLogicBefore();		
		timer.TimerID = self.setTimeout(timer.StartTimer, 1000);			
		timer.StartTimerLogicAfter();		
	};
	this.StartTimerLogicBefore = function () {
		this.TimerRunning = true;
		//var vStr = this.Pad(this.mins) + ":" + this.Pad(this.secs);
		// $("#myDbMsg").html(vStr);
		//$("#" + this.Ids).html(vStr);
		this.outTmrs(this.Ids,this.mins,this.secs)  //new
	};
	this.StartTimerLogicAfter = function () {
		this.Check();

		if (this.mins <= 0 && this.secs <= 0){
			//vStr = this.Pad(0) + ":" + this.Pad(0)
			//$("#" + this.Ids).html(vStr);
			this.outTmrs(this.Ids,0,0)
			this.StopTimer();			
		}
		if (this.secs == 0) {
			this.mins--;
			this.secs = 60;
		}
		this.secs--;
	};
	
	
	this.Check = function () {
		/* M */
		var timerdata = JsController.apdata.qpaper.timerdata;
		var vCliNow = new Date();
		var vdNowSec = (Math.abs(vCliNow.getTime() - this.StartTime.getTime()) / 1000) - 1;
		var va = parseInt(this.QuizSec - vdNowSec);
		var vam = parseInt(va / 60);
		var vas = va % 60;
		
		var vTampm = (this.StartTime.getHours() >= 12 ? "PM" : "AM");
		var vThr = (this.StartTime.getHours() > 12 ? this.StartTime.getHours() - 12 : this.StartTime.getHours());
		
		var vTmin = this.StartTime.getMinutes();
		
		var vStr = this.Pad(vThr) + ':' + this.Pad(vTmin) + ' ' + vTampm;
		//$("#" + this.StartAtId).html(vStr);
		/* M End */
		
		if(!(this.mins == vam && this.secs == vas)) {this.mins = vam; this.secs = vas;}
		
		if (this.mins == 5 && this.secs == 0) {
			
		}
		else if (this.mins <= 0 && this.secs <= 0)
		{
			//alert("Time ended !");			
			timerdata.endTestByTimeOut();
			
			this.StopTimer();
			this.TimerRunning = false;
			
		    // HideTable();
			//
						
		}
		else{
			
		}
		$("#" + this.StartAtId).html(vStr);
	}
	this.outTmrs = function(pIds, pMin, pSec){
		var Res = TakeTestReqDoRes.vTakeTestPage; //JsController.aphtm.TimerHtml
		var vMin = this.Pad(pMin);
		var vSec = this.Pad(pSec);
		//var vText = vMin + ":" + vSec;
		var vText = Mustache.render(Res.vTakeTestPageTimer,{timer:{min:vMin,sec:vSec,class:"timerCounter",clsDiv:"timerDiv"}});
		$("#" + pIds).html(vText);
	}
    this.Pad =  function (number) 
	//pads the mins/secs with a 0 if its less than 10
	{
		if (number < 10)
			number = 0 + "" + parseInt(number);
		return number;
	}	
}


var AppUtil = new function(){
  this.focus = function(pEleById,pEleVariable){
		//document.getElementById('pageContent').scrollIntoView();		
		var element = document.getElementById(pEleVariable); 
		var positionInfo = element.getBoundingClientRect();
		var a = positionInfo.height;
		var b = $('#' + pEleById).offset().top;
		var bsuba=b-a;
		//console.log({t:b,w:a,d:bsuba,msg:"hello"});
		 $('html, body').animate({
				scrollTop:  b - a				
			}, 250);	
  }
}
