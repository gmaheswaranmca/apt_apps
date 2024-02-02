function ConductTestJsController(passignment_id){
	this.m_assignment_id = passignment_id;
	
	this.apdata = null;
	this.aphtm = null;
	this.apser = null;
	
	
	this.pgHtml = "";
	this.menuHtml = "";
	this.questionHtml = "";
	this.htmlQPager = "";
	this.htmlQMatrix = "";
    this.pgQueryRes = {};
	this.QuestionsRes = {};
	this.OnLoad=function(){				
		if(this.apdata==null)  this.apdata= new AppData();	
		if(this.aphtm==null)  this.aphtm= new AppHtml();
		if(this.apser==null)  this.apser = new AppSerCalls();
		
		this.apser.Init();				
	};	
	this.QPgHtml=function()	// QPgHtml -> QListData -> ParsePgHtmlWListData
	{
		$.post("form/conductTest/v2mConductTest.php",  { m: "html"}, 
			function(htmlData){
				JsController.pgHtml = htmlData;
				JsController.QListData();
				JsController.QMenuHtml()
			}
		);
	};
	this.QListData=function(){
		//alert(JsController.m_assignment_id);
		$.post("form/conductTest/v2mConductTest.php",  { m:"dao_assessment", assignment_id:JsController.m_assignment_id},
			function(queryData){
				JsController.pgQueryRes = queryData;
				JsController.ParsePgHtmlWListData();
			}, "json"
		);	
	};
	this.user_id = "";
	this.user_name = "";
	
	this.ParsePgHtmlWListData=function(){
		var v_r = JsController.pgQueryRes.r.assignment;
		this.user_id = JsController.pgQueryRes.r.user_id;
		this.user_name = JsController.pgQueryRes.r.user;		
		$("#myUserName").html(this.user_name);
		var v_show_error = false;
		var v_is_timedout = false;
		if(v_r != null){
			v_r[0].quiz_time = parseInt(v_r[0].quiz_time);
			v_r[0].pass_score = parseInt(v_r[0].pass_score);	
			v_r[0].pass_score_point = parseInt(v_r[0].pass_score_point);			
			v_r[0].InstructionsShownFirstTime = this.InstructionsShownFirstTime;
			v_show_error = v_r[0].user_quiz_status>=2;
			v_is_timedout = v_r[0].user_quiz_status==3;
			
		}
		var rendered = Mustache.render(JsController.pgHtml,{quiz: v_r, show_error: v_show_error,is_timedout:v_is_timedout});
		$("#pageContent").html(rendered);
		if(v_r != null){
			rendered = Mustache.render(
				"{{#quiz}}<span>{{quiz_name}}</span>, <span>Total number of questions:</span><span id='myQCount'>{{score}}</span>, <span>Max Time Limit: {{quiz_time}} minutes</span>{{/quiz}}",
				{quiz: v_r}); 
			//
			$("#myTitle").html(rendered);	  
			//					
		}else{
			return;
		}
		
		if(v_r[0].user_quiz_status==0){
			this.DBInitQuiz();
		}
		
		if(this.InstructionsShownFirstTime == false){
			this.QQuestionHtml();
		}else{
			
		}
	}
	this.QMenuHtml=function()	// QMenuHtml -> QMenuData 
	{
		$.post("form/conductTest/v2mConductTest.php",  { m: "menu_htm"}, 
			function(htmlData){
				JsController.menuHtml = htmlData;
				JsController.QMenuData();
			}
		);
	};
	this.QMenuData=function(){
		$.post("form/conductTest/v2mConductTest.php",  { m: "daomodule_get"},
			function(queryData){				
				var v_r = queryData.r;
				FixMenus(v_r,2);
				
				var rendered = Mustache.render(JsController.menuHtml,{menus: v_r});
				$("#menuContent").html(rendered);
				$("#myFullName").html(v_r[0].full_name);
			}
		);	
	};
	this.InstructionsShownFirstTime = false;
	this.NextToInstructions=function(){		
		if(this.InstructionsShownFirstTime == false){
			JsController.QuestionIndex = 1;
			this.ShuffleQuestions();		
			this.InstructionsShownFirstTime = true;
			JsController.DBInitQuizAfter();	
		}
		
		this.ParseQuestionHtml();
	};
	this.NextQuestion=function(){		
		if(JsController.QuestionIndex<JsController.QuestionsRes.r.question.length){
			JsController.QuestionIndex = JsController.QuestionIndex+1;
		}			
		this.SaveAnswer();			
	};
	this.PreviousQuestion=function(){		
		if(JsController.QuestionIndex>1){
			JsController.QuestionIndex = JsController.QuestionIndex-1;
		}
		this.SaveAnswer();				
	};
	this.FinishTest=function(){	
		if(JsController.pgQueryRes.r.assignment[0].user_quiz_status == 1){
			this.SaveAnswerOnFinish();
		}
	};
	this.QQuestionHtml=function()	// QMenuHtml -> QMenuData 
	{
		$.post("form/conductTest/v2mConductTest.php",  { m: "question_htm"}, 
			function(htmlData){
				JsController.questionHtml = htmlData;
				JsController.QQuestionData();
			}
		);
		// Pager HTML
		$.post("form/conductTest/v2mConductTest.php",  { m: "pager_htm"},
			function(htmlData){
				JsController.htmlQPager = htmlData;					
				$("#testPagers").html(htmlData);	
			}
		);
		// Pager HTML
		$.post("form/conductTest/v2mConductTest.php",  { m: "pager_qmatrix_htm"},
			function(htmlData){
				JsController.htmlQMatrix = htmlData;				
			}
		);
	};
	this.QQuestionData=function(){
		$.post("form/conductTest/v2mConductTest.php",  { m: "dao_question", assignment_id:JsController.m_assignment_id},
			function(queryData){				
				JsController.QuestionsRes = queryData;
				JsController.QuestionIndex = -1;
				
			}
		);	
	};
	this.QuestionIndex = -1;
	this.qno_lar = [];
	
	this.ExistQnoL=function(pQnoL){
		for(var i=0; i < this.qno_lar.length; i++){
			if(pQnoL == this.qno_lar[i])
				return true;
		}	  
		return false;
	};
	this.FindQ=function(pQno){
		var v_r = JsController.QuestionsRes.r;
		for(var i=0; i < v_r.question.length; i++){
			if(v_r.question[i].qno_l == pQno){
				return JsController.QuestionsRes.r.question[i];
			}
		}
		return null;
	};
	this.FindQIsAnswered=function(pQId){
		var v_r = JsController.QuestionsRes.r;
		var v_question = null; var v_answer = [];
		var v_q_idx = 0;
		for(var i=0; i < v_r.question.length; i++){
		  if(v_r.question[i].question_id == pQId){
			v_question = v_r.question[i];	 
			v_q_idx = i;
			break;
		  }	
		}
		if(v_question==null) {			
			return false;
		}	
		var vRet = false;
		for(var i=0; i < v_r.answer.length; i++){
			if(v_r.answer[i].question_id == v_question.question_id && 			   
			   v_r.answer[i].user_answer_id!=-1){
			   JsController.QuestionsRes.r.question[v_q_idx].user_answer_id = v_r.answer[i].user_answer_id;
			   vRet = true;
			   break;
			}
		}
		return vRet;
	};
	this.DoQIsAnswered=function(){
		var v_r = JsController.QuestionsRes.r;
		for(var i=0; i < v_r.question.length; i++){	
			JsController.QuestionsRes.r.question[i].IsAnswered = this.FindQIsAnswered(v_r.question[i].question_id);
		}
		this.ParsePager();
	}
	this.ShuffleQuestions=function(){
		var v_r = JsController.QuestionsRes.r;
		$("#myQCount").html(v_r.question.length);
		v_max = v_r.question.length;
		this.pgQueryRes.r.assignment[0].pass_score = v_max;
		
		for(var i=0; i < v_max; i++){	
		  if(v_r.question[i].qno_a == -1){
			JsController.QuestionsRes.r.question[i].qno_a = i + 1;
			JsController.QuestionsRes.r.question[i].IsAnswered = this.FindQIsAnswered(v_r.question[i].question_id);
			JsController.QuestionsRes.r.question[i].IsNotAnswered = false;
			JsController.QuestionsRes.r.question[i].IsNotVisited = true;
			JsController.QuestionsRes.r.question[i].IsCurrent = false;			
		  }	
		  if(v_r.question[i].qno_l == -1){
		    var rnd_max = v_max;
			var rnd_no = i + 1;
			/* Math.floor(Math.random() * rnd_max) + 1;
			while(this.ExistQnoL(rnd_no))
				rnd_no = Math.floor(Math.random() * rnd_max) + 1; */			
			JsController.QuestionsRes.r.question[i].qno_l = rnd_no;			
			this.qno_lar.push(rnd_no);		
			if(v_r.question[i].qno_l == this.QuestionIndex){
				JsController.QuestionsRes.r.question[i].IsCurrent = true;
				JsController.QuestionsRes.r.question[i].IsNotAnswered = true && (!v_r.question[i].IsAnswered);
			}	
		  }	
		}
		JsController.QuestionsRes.r.pager = [];
		for(var i=0; i < v_max; i++){
			JsController.QuestionsRes.r.pager.push(this.FindQ(i+1));			
		}
		for(var i=0; i < v_r.pager.length; i++){				
			JsController.QuestionsRes.r.pager[i].IsPagerLine = (JsController.QuestionsRes.r.pager[i].qno_l % 5==0);	
		}
		//alert(this.qno_lar);
		//console.log(this.qno_lar );		
		//console.log(v_r.pager);
		//console.log(this.user_name);
		this.ParsePager();
	};
	this.ParsePager=function(){
		var v_r = JsController.QuestionsRes.r;
		JsController.QuestionsRes.r.pager = [];
		for(var i=0; i < v_r.question.length; i++){
			JsController.QuestionsRes.r.pager.push(this.FindQ(i+1));			
		}
		for(var i=0; i < v_r.pager.length; i++){				
			JsController.QuestionsRes.r.pager[i].IsPagerLine = (JsController.QuestionsRes.r.pager[i].qno_l % 5==0);	
		}
		var rendered = Mustache.render(JsController.htmlQMatrix,{quiz: v_r.pager});
		$("#myQMatrix").html(rendered);
		$("#testPagers").css("display","block");
		$("#menuContent").css("display","none");
		
		var v_r_as = JsController.pgQueryRes.r.assignment;
		
	};	
	this.CurrQuAid = -1;
	this.CurrQid = -1;
	this.ParseQuestionHtml=function(){
		var v_r = JsController.QuestionsRes.r;
		var v_question = null; var v_answer = [];
		var qno_l_a = -1;
		for(var i=0; i < v_r.question.length; i++){
		  if(v_r.question[i].qno_l == this.QuestionIndex){
			v_question = v_r.question[i];
			qno_l_a = v_question.qno_a;
		  }	

		   JsController.QuestionsRes.r.question[i].IsCurrent = false;		   
		}
		if(v_question==null) {
			/*  if no question exists or loaded before */
			return;
		}	
		
		this.QuestionsRes.r.question[qno_l_a-1].IsNotAnswered = true;
		this.QuestionsRes.r.question[qno_l_a-1].IsNotVisited = false;
		this.QuestionsRes.r.question[qno_l_a-1].IsCurrent = true;
		this.CurrQuAid = this.QuestionsRes.r.question[qno_l_a-1].user_answer_id;
		this.CurrQid = this.QuestionsRes.r.question[qno_l_a-1].question_id;
		for(var i=0; i < v_r.answer.length; i++){
			if(v_r.answer[i].question_id == v_question.question_id){
				v_r.answer[i].IsUserAnswered = v_r.answer[i].answer_id == v_r.answer[i].user_answer_id;
				v_answer.push(v_r.answer[i]);
			}
		}
		var v_ar_question = [v_question];
		var rendered = Mustache.render(JsController.questionHtml,{question: v_ar_question, answer:v_answer});
		$("#pageContent").html(rendered);
		
		this.ParsePager();
	};
	this.LoadQuestionByNo=function(pQno){			
		if(!(pQno >= 1 && pQno <= this.QuestionsRes.r.question.length))
			return;
		this.QuestionIndex = pQno;
		this.ParseQuestionHtml();
	};
	
	//db-write
	this.DBInitQuiz=function(){		
		$.post("form/conductTest/v2mConductTest.php",  { m:"dao_insert_userquiz", assignment_id:JsController.m_assignment_id},
			function(queryData){				
				var v_r = queryData.r;
				var v_r_old = JsController.pgQueryRes.r.assignment;
				//console.log(v_r_old);
				JsController.pgQueryRes.r.assignment[0].uq_added_date = v_r[0].uq_added_date;
				JsController.pgQueryRes.r.assignment[0].user_quiz_status = v_r[0].user_quiz_status;
				JsController.pgQueryRes.r.assignment[0].user_quiz_id = v_r[0].user_quiz_id;
				//console.log(v_r_old);	
							
			}
		);	
	};
	this.DbQuizStartTime = null;
	this.DbQuizServerNow = null;
	this.ClientQuizStartTime = null;
	this.ClientNow = null;
	this.QuizSecs = null;
	
	this.DBInitQuizAfter =function(){		
		var v_r = JsController.pgQueryRes.r.assignment;
		this.DbQuizStartTime = new Date(v_r[0].uq_added_date);
		this.DbQuizServerNow = new Date(JsController.pgQueryRes.r.now_server);
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
	this.SaveAnswer=function(){	
		var v_r = JsController.QuestionsRes.r;
		var v_answer_id = $('input[name=rdAns]:checked').val();
		if (typeof v_answer_id == 'undefined'){
			v_answer_id = -1;
		}
		if((v_answer_id == -1) || (this.CurrQuAid!=-1 && this.CurrQuAid==v_answer_id)){
			//alert("You have not selected answer");
			this.ParseQuestionHtml();
			return true;
		}
		var v_question_id = this.CurrQid;
		var v_user_quiz_id = JsController.pgQueryRes.r.assignment[0].user_quiz_id;
		//
		
		$("#myDbMsg").css("display","inline");		
		$("#myDbMsg").html("Saving Your Answer...");
		$("#myQBtns").css("display", "none"); $("#myNonQBtns").css("display", "block");
		this.CurrQuAid = v_answer_id;
		$.post("form/conductTest/v2mConductTest.php",  { m:"dao_save_answer", user_quiz_id:v_user_quiz_id, 
				question_id:v_question_id, answer_id:v_answer_id},
			function(queryData){
				JsController.AfterSaveAnswer(queryData);				
			}
		);
		return false;
	};
	this.AfterSaveAnswer=function(queryData){			
		JsController.QuestionsRes.r.answer = queryData.r;
		setTimeout(this.AfterSaveAnswerMsg, 2000);
		$("#myDbMsg").css("display","inline");
		$("#myDbMsg").html("Saved Your Answer Successfully!");	
		$("#myQBtns").css("display", "block"); $("#myNonQBtns").css("display", "none");		
		this.DoQIsAnswered();
		this.ParseQuestionHtml();
	}
	this.AfterSaveAnswerMsg=function(queryData){
		$("#myDbMsg").css("display","none");
	};
	this.QzTime = null;
	this.SaveAnswerOnFinish=function(){	
		var v_r = JsController.QuestionsRes.r;
		var v_answer_id = $('input[name=rdAns]:checked').val();
		if (typeof v_answer_id == 'undefined'){
			v_answer_id = -1;
		}
		if((v_answer_id == -1) || (this.CurrQuAid!=-1 && this.CurrQuAid==v_answer_id)){
			//alert("You have not selected answer");
			JsController.OnFinish();
			return true;
		}
		var v_question_id = this.CurrQid;
		var v_user_quiz_id = JsController.pgQueryRes.r.assignment[0].user_quiz_id;
		//
		
		$("#myDbMsg").css("display","inline");		
		$("#myDbMsg").html("Finishing Quiz | Saving Last Question...");
		this.CurrQuAid = v_answer_id;
		$.post("form/conductTest/v2mConductTest.php",  { m:"dao_save_answer", user_quiz_id:v_user_quiz_id, 
				question_id:v_question_id, answer_id:v_answer_id},
			function(queryData){
				$("#myDbMsg").css("display","inline");
				$("#myDbMsg").html("Finishing Quiz | Saved Last Question.");
				setTimeout(JsController.AfterSaveAnswerMsg, 2000);					
				JsController.OnFinish();	
			}
		);
		return false;
	};
	this.QzTimeIsTimedOut = false;
	this.OnFinish=function(){
		$("#myDbMsg").css("display","inline");		
		$("#myDbMsg").html("Updating Scores for the Quiz...");
		//	+ this.m_assignment_id + " " + this.user_id + " " + (this.QzTimeIsTimedOut==true?3:2));
		$.post("form/conductTest/v2mConductTest.php",  { m:"dao_finish_quiz", assignment_id:this.m_assignment_id, 
				user_id:this.user_id, status:(this.QzTimeIsTimedOut==true?3:2), user_quiz_id:JsController.pgQueryRes.r.assignment[0].user_quiz_id},
			function(queryData){
				setTimeout(JsController.AfterSaveAnswerMsg, 2000);
				$("#myDbMsg").css("display","inline");
				$("#myDbMsg").html("Updated Scores for the Quiz Successfully!");
				$("#testPagers").css("display","none");
				$("#menuContent").css("display","block");
				JsController.QListData();				
			}
		);
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
		$("#" + this.Ids).html(vStr);
	};
	this.StartTimerLogicAfter = function () {
		this.Check();

		if (this.mins <= 0 && this.secs <= 0)
			this.StopTimer();

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

    this.Pad =  function (number) 
	//pads the mins/secs with a 0 if its less than 10
	{
		if (number < 10)
			number = 0 + "" + number;
		return number;
	}
	
}	




function Answering(pQ, pOption, pAId){
  
}

function QLastAnswers(pQ, pAId, pAId){
  
}
