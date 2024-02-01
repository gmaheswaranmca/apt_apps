function ConductTestJsController(passignment_id){
	this.m_assignment_id = passignment_id;
	this.pgHtml = "";
	this.menuHtml = "";
	this.questionHtml = "";
	this.htmlQPager = "";
	this.htmlQMatrix = "";
	this.lastRunOutput = "";
	this.IsThereLastRun = false;
	this.lastRunProgram = '';
    this.pgQueryRes = {};
	this.QuestionsRes = {};
	this.OnLoad=function(){		
		this.QIsLoggedIn();		
	};
	this.QIsLoggedIn=function() 
	{	
		//alert(99);
		$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
		 
		$.get("form/conductCodeTest/v2mConductTest.php",  { m: "htmlOne", assignment_id:JsController.m_assignment_id}, 
			function(pData){	
				if(pData.r.IsLoggedIn == "0"){
					window.location.href = "login.php";
					return;
				}				
				 // 
				JsController.pgHtml = pData.r.InstructionsView;
				JsController.questionHtml = pData.r.QuestionView;
				JsController.htmlQPager = pData.r.QPagerView;
				JsController.htmlQMatrix = pData.r.QPagerMatrix;	

				JsController.pgQueryRes = {r:{}}
				JsController.pgQueryRes.r.assignment = pData.r.mdQueryAssessesment;
				JsController.pgQueryRes.r.user = pData.r.mdInput.user;
				JsController.pgQueryRes.r.full_name = pData.r.mdInput.full_name;
				JsController.InstructionsShownFirstTime = parseInt(pData.r.IsFirstTimeVisit) === 1;
				//alert(JsController.InstructionsShownFirstTime)				
				JsController.QuestionsRes = {r:pData.r.mdQnAns}	
				
				mdData.ParseData(pData.r.mdQueryAssessesment, pData.r.mdInput, pData.r.mdQnAns, pData.r.IsFirstTimeVisit)
				
				//JsController.ParsePgHtmlWListData();
				
				$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
				JsController.InitStep();
				
				
			}, "json"
		);
	};
	this.InitStep = function(){
		mdData.OutTitle();
		mdData.QuestionIndexSet(1)
		if(mdData.InstructionsShownFirstTime || parseInt(mdData.assignment.user_quiz_status) > 1)
			JsController.StepShowInstruction();
		else{			
			JsController.StepAfterInstruction();
		}
	};
	this.StepAfterInstruction = function(){	
		if(parseInt(mdData.assignment.user_quiz_status) > 1){
			JsController.StepShowInstruction();
			return;
		}	
		mdData.OutQn();		
		if(this.QzTime == null)
			this.DBInitQuizAfter();
	};
	this.StepShowInstruction = function(){		
		mdData.OutInstruction();	
	};


	
	
	this.NextQuestion=function(){		
		if(JsController.QuestionIndex<JsController.QuestionsRes.r.question.length){
      JsController.lastRunOutput = "";
      JsController.IsThereLastRun = false; 
      JsController.lastRunProgram = '';
			mdData.QuestionIndexSet(JsController.QuestionIndex+1);
			//JsController.QuestionIndex = JsController.QuestionIndex+1;
		}			
		JsController.StepAfterInstruction();	//this.ParseQuestionHtml();		
	};
	this.PreviousQuestion=function(){		
		if(JsController.QuestionIndex>1){			
      JsController.lastRunOutput = "";
      JsController.IsThereLastRun = false; 
			mdData.QuestionIndexSet(JsController.QuestionIndex-1);
			//JsController.QuestionIndex = JsController.QuestionIndex-1;
		}
		JsController.StepAfterInstruction();	 //this.ParseQuestionHtml();		
	};
	this.SaveQnActionMsg = 
	"<h3>We are submitting your coding(program) to the server.</h3>" + 
	"<p>Wait few seconds.</p>" +
	"<p><b>we will run all the test cases for your program.</b><p>";
	this.AfterSaveQnActionMsg = 
	"<h3>We have run all test cases for your program.</h3>" + 
	"<p>Thank you for your patience.</p>";
	this.SaveQnAction=function(){	
		if(!confirm("Are you sure to submit program?"))
			return;
        var v_user_program = $("#plainCode").val();
		var vprg = this.codeEditr.getValue();
		var reqData = mdData.getSaveData(vprg);
		//console.log({'reqData':reqData});

		JsController.MsgOnModel(
		JsController.SaveQnActionMsg 
		/*+ '<p><br>' 
		+ v_user_program 
		+ '</p><p><br>' 
		+ vprg 
		+ '</p>'*/
		);
		$('#idSubmitCode').css('display', 'none');
		$('#idRunCode').css('display', 'none');
		
		$.post(
			"form/conductCodeTest/v2mConductTest.php",  
			reqData,
			function(resData){				
				//console.log({'resData' : resData});
				JsController.MsgOnModel(
				    JsController.AfterSaveQnActionMsg  
		            /*+ '<p><br>' 
		            + v_user_program 
		            + '</p><p><br>' 
		            + vprg 
		            + '</p>'*/
		            );
                JsController.lastRunOutput = "";
                JsController.IsThereLastRun = false;    
                JsController.lastRunProgram = '';    
				mdData.updateQnAns(resData.r.question, resData.r.answer);
				JsController.StepAfterInstruction();
			}, "json"
		);	
	};

  this.RunQnAction=function(){	
		if(!confirm("Are you sure to RUN program?"))
			return;
    var v_user_program = $("#plainCode").val();
		var vprg = this.codeEditr.getValue();
		var reqData = mdData.getSaveData(vprg);
    reqData.m =   "RunQnAction";
		//console.log({'reqData':reqData});
    
		//JsController.MsgOnModel(
		//JsController.SaveQnActionMsg 
		/*+ '<p><br>' 
		+ v_user_program 
		+ '</p><p><br>' 
		+ vprg 
		+ '</p>'*/
		//);
    
		$('#idSubmitCode').css('display', 'none');
		$('#idRunCode').css('display', 'none');
		$('#idRunningCode').css('display', 'inline');
		$.post(
			"form/conductCodeTest/v2mConductTest.php",  
			reqData,
			function(resData){				
				//console.log({'resData' : resData});
				//JsController.MsgOnModel(
				    //JsController.AfterSaveQnActionMsg  
		            /*+ '<p><br>' 
		            + v_user_program 
		            + '</p><p><br>' 
		            + vprg 
		            + '</p>'*/
		            //);
                JsController.lastRunOutput = resData.r.useroutput;
                JsController.IsThereLastRun = true;      
                JsController.lastRunProgram = resData.r.user_program;  
				mdData.updateQnAns(resData.r.question, resData.r.answer);
				JsController.StepAfterInstruction();
			}, "json"
		);	
	};


	this.FinishTest=function(){	
		if(parseInt(mdData.assignment.user_quiz_status) == 1){
			JsController.OnFinish();
		}
	};
	this.FinishTestMsg = 
	"<h3>We are submitting your test result to the server.</h3>" + 
	"<p>Wait few seconds.</p>" +
	"<p><b>Kindly show your patience.</b><p>";
	this.QzTimeIsTimedOut = false;
	this.OnFinish=function(){
		if(!confirm("Are you sure to finish your test?"))
			return;
		//$("#myDbMsg").css("display","inline");		
		//$("#myDbMsg").html("Updating Scores for the 'Program Test'...");
		//	
		JsController.MsgOnModel(JsController.FinishTestMsg);
		$.get("form/conductCodeTest/v2mConductTest.php",  { m:"dao_finish_quiz", 
			user_ass_status:(JsController.QzTimeIsTimedOut==true?3:2)},
			function(queryData){
				//setTimeout(JsController.AfterSaveAnswerMsg, 2000);
				//$("#myDbMsg").css("display","inline");
				//$("#myDbMsg").html("Updated Scores for the 'Program Test' Successfully!");
				//$("#testPagers").css("display","none");
				//$("#menuContent").css("display","block");
				//JsController.QListData();	
				//console.log(queryData);
				mdData.copyData(queryData.r.assessment[0], mdData.assignment, ['user_quiz_id', 'user_quiz_status']);				
				JsController.StepAfterInstruction();		
			}, "json"
		);
	};
		
	

	this.DbQuizStartTime = null;
	this.DbQuizServerNow = null;
	this.ClientQuizStartTime = null;
	this.ClientNow = null;
	this.QuizSecs = null;
	this.QzTime = null;
	
	this.DBInitQuizAfter =function(){		
		var v_r = JsController.pgQueryRes.r.assignment;
		this.DbQuizStartTime = new Date(v_r[0].uq_added_date);
		this.DbQuizServerNow = new Date(v_r[0].db_now);
		this.ClientNow = new Date();
		var vQuizStartToNow = Math.abs(this.DbQuizServerNow.getTime() - this.DbQuizStartTime.getTime()) / 1000;
		this.ClientNow = new Date();
		this.ClientQuizStartTime = new Date();
		this.ClientQuizStartTime.setSeconds(this.ClientNow.getSeconds() - vQuizStartToNow);
		var vStartToNow = Math.abs(this.ClientNow.getTime() - this.ClientQuizStartTime.getTime()) / 1000;
		var vQuizMins = parseInt(v_r[0].quiz_time);
		this.QuizSecs =  vQuizMins * 60;
		var vMins = vQuizMins - (vStartToNow / 60);
		var vSecs = vStartToNow % 60;
		this.QzTime = new QuizTimer("myRemainingTime, #myRemainingTime02", "myTestStartAt", vMins, vSecs, this.ClientQuizStartTime, this.QuizSecs);
		this.QzTime.Init_Timer();
	};

	this.MsgOnModel=function(pText){
		$("#myModal").css("display", "block");
		$("#myModal p").html(pText);
	};

	this.codeEditr = null;
	this.DoEditorCloseFullScreen=function(){
		var cm = this.codeEditr;
		if (cm.getOption("fullScreen")) {
			cm.setOption("fullScreen", false);
			$("#codeClose").css("display", "none");
		}	
	};
	this.DoEditorOnFullScreen=function(){
		var cm = this.codeEditr;
		if (!cm.getOption("fullScreen")) {
			cm.setOption("fullScreen", true);
			$("#codeClose").css("display", "inline");
		}	
	};
	this.DoSetEditor=function(){
		$("#codeClose").css("display", "none");
		var vmode="text/x-csrc";
		var CurrQ = mdData.CurrQ;
		if(CurrQ.lang_code=="c"){
			vmode="text/x-csrc";
		}else if(CurrQ.lang_code=="cpp"){
			vmode="text/x-c++src";
		}else if(CurrQ.lang_code=="java"){
			vmode="text/x-java";
		}
		var cEditor = CodeMirror.fromTextArea(document.getElementById("plainCode"), {
			lineNumbers: true,
			matchBrackets: true,
			mode: vmode, 
			theme: "eclipse",
			extraKeys: {
				"F11": function(cm) {
				  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
				  $("#codeClose").css("display",cm.getOption("fullScreen") ? "inline" : "none");
				},
				"Esc": function(cm) {
				  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
				  $("#codeClose").css("display", "none");
				}
			  }	,
			readOnly:CurrQ.IsAnswered()==true?true:false
		 });
		var mac = CodeMirror.keyMap.default == CodeMirror.keyMap.macDefault;
		CodeMirror.keyMap.default[(mac ? "Cmd" : "Ctrl") + "-Space"] = "autocomplete";
		this.codeEditr = cEditor;
	};
};


function QuizTimer(pIds, pStartAtId, pmins, psecs, pStartTime, pQuizSec){
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
		JsController.QzTime.StartTimerLogicBefore();		
		JsController.QzTime.TimerID = self.setTimeout(JsController.QzTime.StartTimer, 1000);			
		JsController.QzTime.StartTimerLogicAfter();		
	};
	this.StartTimerLogicBefore = function () {
		this.TimerRunning = true;
		var vStr = this.Pad(this.mins) + ":" + this.Pad(this.secs);
		// $("#myDbMsg").html(vStr);
		//$("#" + this.Ids).html(vStr);
		this.outTmrs(this.Ids,this.mins,this.secs)  //new
	};
	this.StartTimerLogicAfter = function () {
		this.Check();

		if (this.mins <= 0 && this.secs <= 0){
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
		var vCliNow = new Date();
		var vdNowSec = (Math.abs(vCliNow.getTime() - this.StartTime.getTime()) / 1000) - 1;
		var va = parseInt(this.QuizSec - vdNowSec);
		var vam = parseInt(va / 60);
		var vas = va % 60;
		
		var vTampm = (this.StartTime.getHours() >= 12 ? "PM" : "AM");
		var vThr = (this.StartTime.getHours() > 12 ? this.StartTime.getHours() - 12 : this.StartTime.getHours());
		
		var vTmin = this.StartTime.getMinutes();
		
		var vStr = this.Pad(vThr) + ':' + this.Pad(vTmin) + ' ' + vTampm;
		$("#" + this.StartAtId).html(vStr);
		/* M End */
		
		if(!(this.mins == vam && this.secs == vas)) {this.mins = vam; this.secs = vas;}
		
		if (this.mins == 5 && this.secs == 0) {

		}
		else if (this.mins <= 0 && this.secs <= 0)
		{
			//alert("Time ended !");
			JsController.QzTimeIsTimedOut = true;
			JsController.FinishTest();
			this.StopTimer();
			this.TimerRunning = false;
			
		    // HideTable();
			window.location.reload(false);
		}
		
	}
	this.outTmrs = function(pIds, pMin, pSec){
		var vMin = this.Pad(pMin);
		var vSec = this.Pad(pSec);
		//var vText = vMin + ":" + vSec;
		TimerHtml = 
"{{#timer}}<div {{clsDiv}}><div class='{{class}}'>{{min}}<span  class='tmrTxt'>mins</span></div> <div class='{{class}}' style='width:20px;'>:</div> <div class='{{class}}'>{{sec}}<span class='tmrTxt'>secs</span></div> </div>{{/timer}}</div>";
		var vText = Mustache.render(TimerHtml,{timer:{min:vMin,sec:vSec,class:"timerCounter",clsDiv:"timerDiv"}});
		$("#" + pIds).html(vText);
	}
    this.Pad =  function (number) 
	//pads the mins/secs with a 0 if its less than 10
	{
		number = parseInt(number);
		if (number < 10) number = 0 + "" + number;
		return parseInt(number);
	}
	
}	

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == $("#myModal")[0]) {
    $("#myModal").css("display", "none");
  }
}


var mdData = new function(){
	this.assignment = null;	

	this.user = '';
	this.full_name = '';
	this.InstructionsShownFirstTime = false;
	this.v_show_error = false;
	this.v_is_timedout = false;

	this.qns = null;
	this.qno_lar = null;
	this.pager = null;
	//
	this.QuestionIndex = -1;
	this.QuestionIndexSet = function(Idx){
		var self = mdData;
		self.QuestionIndex = Idx;

		JsController.QuestionIndex = self.QuestionIndex;//??? ??? ??? ???

		if(Idx < 0) return;
		var eQn = self.qns[self.QuestionIndex-1];
		eQn.IsNotAnswered = true;
		eQn.IsNotVisited = false;
		self.CurrQuAid = eQn.user_answer_id;
		self.CurrQid = eQn.question_id;
		self.GroupId = eQn.quiz_id;
		self.CurrQ = eQn;		

		//console.log({'mdData' : self});
	}
	//
	this.ParseData = function(mdAssignment, mdInput, mdQns, IsFirstTimeVisit){
		var self = mdData;
		self.user = mdInput.user;
		self.full_name = mdInput.full_name;		
		self.InstructionsShownFirstTime = parseInt(IsFirstTimeVisit) === 1;
		self.v_show_error = false;
		self.v_is_timedout = false;
		if(mdAssignment != null){
			self.assignment = mdAssignment[0];
			self.assignment.quiz_time = parseInt(self.assignment.quiz_time);
			self.assignment.pass_score = parseInt(self.assignment.pass_score);
      self.assignment.max_runs = parseInt(self.assignment.max_runs);
			self.assignment.InstructionsShownFirstTime = self.InstructionsShownFirstTime;		
      
			self.v_show_error = function(){
				var selfInr = mdData;
				return selfInr.assignment.user_quiz_status>=2;
			}
			self.v_is_timedout =  function(){
				var selfInr = mdData;
				return selfInr.assignment.user_quiz_status==3;
			}
		}
		var fnTestCaseStatus = function(){
			var selfInr = mdData;
			var eQnAns = this;			
			var eQn = selfInr.qns[eQnAns.qno_a];
			var TestCaseStatus = '';
			switch(parseInt(eQnAns.case_status)){
				case 0: case 1:
					TestCaseStatus = "<span style='color:navy;font-weight:bold;background-color:white;border-radius:20px;padding:3px;'>Yet To Run</span>"; break;
				case 2:
					TestCaseStatus = "<span style='color:orange;font-weight:bold;background-color:white;border-radius:20px;padding:3px;'>Running...</span>"; break;
				case 3:
					TestCaseStatus = "It has been run. "; 
					TestCaseStatus += parseInt(eQnAns.testcase_secure_score)!=0 ?
								" <span style='color:green;font-weight:bold;background-color:white;border-radius:20px;padding:3px;'>Passed.</span>"
								: 
								" <span style='color:red;font-weight:bold;background-color:white;border-radius:20px;padding:3px;'>Failed.</span>" 								
								; 
					break;
			}
			return TestCaseStatus;
		};var fnIsCurrent = function(){
			var selfInr = mdData;
			var eQn = this;
			return (eQn.qno_a == selfInr.QuestionIndex)
		};
		if(mdQns.question!=null){
			self.qns = [];
			self.qno_lar = [];

			self.assignment.pass_score = mdQns.question.length;			
			for(var i=0; i < mdQns.question.length; i++){	
				var eQn = mdQns.question[i];
				self.qns.push(eQn);
				eQn.qno_a = i + 1;
				eQn.IsAnswered = function(){return parseInt(this.q_status)>=1};
        eQn.max_runs = self.assignment.max_runs;
        eQn.number_of_runs = parseInt(eQn.number_of_runs);
        eQn.NumberOfBalanceRuns = function(){return this.max_runs - this.number_of_runs};
        eQn.IsRunAllowed = function(){return this.NumberOfBalanceRuns() > 0};
				eQn.IsNotAnswered = false;
				eQn.IsNotVisited = true;
				eQn.DidWeRunAllOptions = 

				eQn.IsCurrent = fnIsCurrent;
				var rnd_no = eQn.qno_a;
				/* 
				var rnd_max = mdQns.question.length;
				rnd_no = Math.floor(Math.random() * rnd_max) + 1;
				while(self.ExistQnoL(rnd_no))
					rnd_no = Math.floor(Math.random() * rnd_max) + 1; 
				*/

				eQn.qno_l = rnd_no;
				self.qno_lar.push(rnd_no);
				eQn.answers = [];
				if(mdQns.answer != null)
				for(var j=0; j < mdQns.answer.length; j++){
					var eQnAns = mdQns.answer[j];					
					if(eQnAns.question_id == eQn.question_id){
						eQnAns.qno_a = 	eQn.qno_a;		
						eQnAns.TestCaseStatus = fnTestCaseStatus;
						eQn.answers.push(eQnAns);
					}
				}
			}

			self.pager = [];
			for(var i=0; i < self.qns.length; i++){
				var eQn = self.FindQ(i+1);
				self.pager.push(eQn);			
			}			
			var vDivdr = 5;			
			vDivdr = parseInt(self.pager.length / 5) + ((self.pager.length % 5) == (self.pager.length-1) ? 1 : 0);		
			if(vDivdr==0) vDivdr=1;
			for(var i=0; i < self.pager.length; i++){
				var ePager = self.pager[i];
				ePager.IsPagerLine = false;
				if(vDivdr<=1)
					ePager.IsPagerLine = true;				
				else			
					ePager.IsPagerLine = (ePager.qno_l % vDivdr == 0);							
			}
		}
		//console.log({'mdData' : self});
	}
	this.ExistQnoL=function(pQnoL){
		var self = mdData;
		for(var i=0; i < self.qno_lar.length; i++){
			if(pQnoL == self.qno_lar[i])
				return true;
		}	  
		return false;
	};
	this.FindQ=function(pQno){
		var self = mdData;			
		for(var i=0; i < self.qns.length; i++){
			var eQn = self.qns[i];
			if(eQn.qno_l == pQno)
				return eQn;				
		}
		return null;
	};
	this.OutTitle = function(){
		var self = mdData;
		var rendered = Mustache.render(
			"{{#quiz}}<span>{{quiz_name}}</span>, <span class='qcountdesc'>Total Programs:</span><span id='myQCount'>{{total_q}}</span><span class='qcountsimple'>Qs</span>, <span class='qcountdesc'>Max Time Limit(Mins):</span><span>{{quiz_time}}</span><span class='qcountsimple'>Mins</span>{{/quiz}}",
			{quiz: self.assignment}); 
		//
		//console.log(self.assignment)
		$("#myTitle").html(rendered);

		$("#myUserName").html(self.user);
		$("#myFullName").html(self.full_name);
	};
	this.OutInstruction = function(){
		var self = mdData;
		var rendered = Mustache.render(JsController.pgHtml,{quiz: self.assignment, show_error: self.v_show_error,is_timedout:self.v_is_timedout});
			$("#pageContent").html(rendered);
		//
		$("#pageContent").html(rendered);
	}
	this.OutQn = function(){
		var self = mdData;
		var eQn = self.CurrQ;
    //eQn = JSON.parse(JSON.stringify(eQn) ) ;

    //var IsThereLastRun  = true;
    var IsThereLastRun  = JsController.IsThereLastRun;
    var lastRunOutput = JsController.lastRunOutput;    
    var lastRunProgram = JsController.lastRunProgram;    
    var firstTestCase = eQn.answers[0];

    
    
   
    var runData= 
      {
        
        IsThereLastRun : IsThereLastRun,
        input : eQn.answers[0].input,
        lastRunOutput : lastRunOutput,
        expectedOutput : firstTestCase.output,
        runStatus : JsController.lastRunOutput !== firstTestCase.output ?
        " <span style='color:red;font-weight:bold;background-color:white;border-radius:20px;padding:3px;'>Failed.</span>"
        : 
        " <span style='color:green;font-weight:bold;background-color:white;border-radius:20px;padding:3px;'>Passed.</span>" ,
        lastRunProgram : lastRunProgram								
        
      }; 
      

		//console.log(eQn)
		var rendered = Mustache.render(JsController.questionHtml,{question: eQn, answer:eQn.answers, runData: runData});
		
		$("#pageContent").html(rendered);
		JsController.DoSetEditor();
	};	
	this.getSaveData = function(pUserProgram){
		var self = mdData;
		var eQn = self.CurrQ;
		var data = {
			m:'SaveQnAction',
			group_id:self.GroupId, 			
			question_id:self.CurrQid, 
			user_program:pUserProgram,
			testcase_id: [],
			tc_point: [],
			tc_input: [],
			tc_output: [],
			api_lang: eQn.api_lang_name, 
			api_version:eQn.api_version_no
		}
		for(var i=0; i < eQn.answers.length; i++){
			var eQnAns = eQn.answers[i];
			switch(parseInt(eQnAns.case_status)){
				case 0:
				case 1: //Init
					data.testcase_id.push(eQnAns.testcase_id)
					data.tc_point.push(eQnAns.tc_point)
					data.tc_input.push(eQnAns.input)
					data.tc_output.push(eQnAns.output)
					break;
				case 2: //Run
					data.testcase_id.push(eQnAns.testcase_id)
					data.tc_point.push(eQnAns.tc_point)
					data.tc_input.push(eQnAns.input)
					data.tc_output.push(eQnAns.output)
					break;
			}
		}
		
		//console.log(data);
		return data;
	}
	this.updateQnAns = function(pQn, pAns){
		//console.log({'Before Update': pQn, 'Ans' : pAns});
		var self = mdData; 
		var eQn = self.CurrQ;
		var QnAttr = ['q_secure_score', 'q_status', 'submit_id', 'user_program', 'number_of_runs'];
		var AnsAttr = ['case_status', 'submit_id', 'testcase_secure_score', 'user_output', 'user_answer_id'];
		mdData.copyData(pQn[0], eQn, QnAttr)
		for(var I=0; I < eQn.answers.length; I++){
			var eAns = eQn.answers[I];
			for(var J=0; J < pAns.length; J++){
				var paAns = pAns[J];
				if(eAns.answer_id === paAns.answer_id){
					mdData.copyData(paAns, eAns, AnsAttr)
				}
			}
		}
		//console.log({'After Update': eQn});
	}
	this.copyData = function(pSource, pDest, pAttr){
		for(var I=0; I < pAttr.length; I++){
			var eAttr = pAttr[I];
			pDest[eAttr] = pSource[eAttr];
			//console.log([eAttr,pSource[eAttr]])
		}
	}
}
