function AppLogger(){
	this.add=function(pmsg){ console.log(pmsg);	};
}
function AppConfig(){
	this.SuffleIsThere = true;
	this.qPagerIsScroll = false;
	this.qPagerLineQCount = 5;
}
function AppData(){
	this.IsLoggedIn = false;
	this.pgQueryRes = null;
	this.user_id ="";
	this.user_name ="";
	this.QStarted=false;
	this.menuData = null;
	this.v_show_error = false;
	this.v_is_timedout = false;
	this.QuestionsRes = null;
	this.CurrQuAid = -1;
	this.CurrQid = -1;
	this.qno_lar = [];
	this.QsAr = [];
	this.qpaper = null;
	this.out = null;
	this.action = null;
	this.Init=function(){
		//alert(1032);
		JsController.apdata.qpaper = new QPaper();
		JsController.apdata.qpaper.Init();
		JsController.apdata.out = new PrintPaper();
		this.action = new frmActions();; 
	}
}

function AppHtml(){
	this.PgHtml = "";	
	this.TitleHtml = 
"{{#quiz}}<span>{{quiz_name}}</span>, <span>Total number of questions:</span><span id='myQCount'>{{score}}</span>, <span>Max Time Limit: {{quiz_time}} minutes</span>{{/quiz}}";
	this.menuHtml = "";
	this.questionHtml = "";
	this.htmlQPager = "";
	this.htmlQMatrix = "";
	this.TimerHtml = 
"{{#timer}}<div {{clsDiv}}><div class='{{class}}'>{{min}}<span  class='tmrTxt'>mins</span></div> <div class='{{class}}' style='width:20px;'>:</div> <div class='{{class}}'>{{sec}}<span class='tmrTxt'>secs</span></div> </div>{{/timer}}</div>";
}

function AppSerCalls(){
	this.log = null;
	this.config = null;
	this.auth = null;
	this.viewpg = null;
	this.mdass = null;
	this.viewmnu = null;
	this.mdmnu = null;
	this.viewQ = null;
	this.viewQPgr = null;
	this.viewQNav = null;
	this.mdQ = null;
	this.mdwqzinit = null;
	this.mdwanssave = null;
	this.mdwqzfin = null;
	
	
	this.Init=function(){
		//alert(7346);		
		JsController.apdata.Init();
		
		this.log = new AppLogger();		
		this.config = new AppConfig();
		this.auth = new AppAuth();
		this.viewpg = new PageView();
		this.mdass = new ModelAssessment();
		this.viewmnu = new ViewMenu();
		this.mdmnu = new ModelMenu();
		this.viewQ = new QView();
		this.viewQPgr = new QPgrView();
		this.viewQNav = new QNavView();
		this.mdQ = new ModelQ();
		this.mdwqzinit = new ModelWriteInitQuiz();
		this.mdwanssave = new ModelWriteSaveAnswer();
		this.mdwanssave.init();
		this.mdwqzfin = new ModelWriteFinishQuiz();
		
		this.auth.SerCall();		
	};
}

function AppAuth(){
	this.SerCall = function(){			
		var vurl = "form/conductTest/v2mLogin.php";		
		var vparams = { m: "is_logged_in"};					
		var vfnRes = JsController.apser.auth.SerCallRes;		
		$.post(vurl, vparams, vfnRes, "json");
	};
	
	this.SerCallRes = function(pData){		
		if(pData.r_code==2)	JsController.apser.auth.RedirectTo();
		else if(pData.r_code==1){ 
			//JsController.QPgHtml(); 
			JsController.apser.viewpg.SerCall(); 
		}
	};
	
	this.RedirectTo = function(){ window.location.href = "login.php"; };	
}


function PageView(){
	this.SerCall=function(){
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m: "html"};
		var vfnRes = JsController.apser.viewpg.SerCallRes;
		$.post(vurl, vparams, vfnRes);
	};
	this.SerCallRes=function(htmlData){
		JsController.aphtm.PgHtml = htmlData;		
		JsController.apser.mdass.SerCall();
		JsController.apser.viewmnu.SerCall()			
	};
}


function ModelAssessment(){
	this.doer = null;
	this.SerCall=function(){
		if(this.doer == null) this.doer = new ModelAssessmentDo();
		
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m:"dao_assessment", 
			assignment_id:JsController.m_assignment_id
			};
		var vfnRes = JsController.apser.mdass.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
		
		
	};
	this.SerCallRes=function(queryData){
		JsController.apdata.pgQueryRes = queryData;	
		JsController.apser.mdass.doer.render();
		JsController.apser.viewQ.SerCall();		
	};
}

function ViewMenu(){
	this.SerCall=function(){
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m: "menu_htm"};
		var vfnRes = JsController.apser.viewmnu.SerCallRes;
		$.post(vurl, vparams, vfnRes);
	};
	this.SerCallRes=function(htmlData){
		JsController.aphtm.menuHtml = htmlData;
		JsController.apser.mdmnu.SerCall();
	};	
}
function ModelMenu(){
	this.preparedHtml = "";
	this.SerCall=function(){
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={  m: "daomodule_get"};
		var vfnRes= JsController.apser.mdmnu.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
	};
	this.SerCallRes=function(queryData){
		JsController.apdata.menuData = queryData;		
		var v_r = queryData.r;
		$("#myFullName").html(v_r[0].full_name);
		
		FixMenus(v_r,2);			
		JsController.apser.mdmnu.preparedHtml = Mustache.render(
				JsController.aphtm.menuHtml, 
				{menus: v_r});
		
		JsController.apdata.out.Menu();		
	};	
}


function QView(){
	this.SerCall=function(){
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m: "question_htm"};
		var vfnRes = JsController.apser.viewQ.SerCallRes;
		$.post(vurl, vparams, vfnRes);
	};
	this.SerCallRes=function(htmlData){		
		JsController.aphtm.questionHtml = htmlData;	
		JsController.apser.viewQPgr.SerCall()			
	};
}
function QPgrView(){
	this.SerCall=function(){
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m: "pager_htm"};
		var vfnRes = JsController.apser.viewQPgr.SerCallRes;
		$.post(vurl, vparams, vfnRes);
	};
	this.SerCallRes=function(htmlData){
		JsController.aphtm.htmlQPager = htmlData;		
		JsController.apser.viewQNav.SerCall();		
	};
}
function QNavView(){
	this.SerCall=function(){
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m: "pager_qmatrix_htm"};
		var vfnRes = JsController.apser.viewQNav.SerCallRes;
		$.post(vurl, vparams, vfnRes);
	};
	this.SerCallRes=function(htmlData){
		JsController.aphtm.htmlQMatrix = htmlData;		
		JsController.apser.mdQ.SerCall();		
	};
}

function ModelQ(){
	this.SerCall=function(){
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m: "dao_question", assignment_id:JsController.m_assignment_id};
		var vfnRes= JsController.apser.mdQ.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
	};
	this.SerCallRes=function(queryData){
		JsController.apdata.QuestionsRes = queryData;
		//JsController.apser.log.add(queryData);		
		//....
		JsController.apdata.qpaper.prepareTest();
	};	
}

function ModelAssessmentDo(){
	this.preparedDatInstruction = null;
	this.render=function(){
		this.parse();			
		var v_r = JsController.apdata.pgQueryRes.r.assignment;
		
		//JsController.apser.log.add(v_r);		//JsController.apser.log.add(JsController.opgls.pgQueryRes.r);
		JsController.apdata.QStarted = false;
		
		JsController.apser.mdass.doer.preparedDatInstruction ={ 
			quiz: v_r[0],  
			show_error: JsController.apdata.v_show_error, 
			is_timedout: JsController.apdata.v_is_timedout};
		
		$("#myUserName").html(JsController.apdata.user_name);
		JsController.apdata.out.Instruction();	
		
		
		if(v_r == null) return;		
		
		var vRenHtmTitle = Mustache.render(JsController.aphtm.TitleHtml, {quiz: v_r[0]} ); 				
		$("#myTitle").html(vRenHtmTitle);	  		
		//alert(3);
		//console.log({val:"title",title:vRenHtmTitle,quiz: v_r});
		//alert(v_r[0].quiz_name);
		
		
		if(v_r[0].user_quiz_status==0){  // || v_r[0].user_quiz_status==1  <- debugging the qz init
			JsController.apser.mdwqzinit.SerCall();
		}
	};
	this.parse=function(){
		var v_r = JsController.apdata.pgQueryRes.r.assignment;
		JsController.apdata.user_id = JsController.apdata.pgQueryRes.r.user_id;
		JsController.apdata.user_name = JsController.apdata.pgQueryRes.r.user;
		//console.log(JsController.apdata);
		if(v_r != null){
			v_r[0].quiz_time = parseInt(v_r[0].quiz_time);
			v_r[0].pass_score = parseInt(v_r[0].pass_score);	
			v_r[0].pass_score_point = parseInt(v_r[0].pass_score_point);			
			v_r[0].QStarted = JsController.apdata.qpaper.qutil.qHasStarted;
			JsController.apdata.v_show_error = v_r[0].user_quiz_status>=2;
			JsController.apdata.v_is_timedout = v_r[0].user_quiz_status==3;
			v_r[0].score = v_r[0].pass_score;
		}		
	};
}

function ModelWriteInitQuiz(){
	this.SerCall=function(){	
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m:"dao_insert_userquiz", assignment_id:JsController.m_assignment_id};
		var vfnRes= JsController.apser.mdwqzinit.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
	};
	this.SerCallRes=function(queryData){	
		var v_r = queryData.r;
		var v_r_old = JsController.apdata.pgQueryRes.r.assignment;
		//JsController.apser.log.add(v_r_old);	
		v_r_old[0].uq_added_date = v_r[0].uq_added_date;
		v_r_old[0].user_quiz_status = v_r[0].user_quiz_status;
		v_r_old[0].user_quiz_id = v_r[0].user_quiz_id;
		//JsController.apser.log.add(v_r_old);	
		//JsController.apser.log.add(JsController.apdata.pgQueryRes.r.assignment);
		//To Do: Continue button enabled after init quiz ....
	};	
}

function ModelWriteSaveAnswer(){
	this.doer = null; 
	this.init=function(){
		if(this.doer == null) this.doer = new ModelWriteSaveAnswerDo();
	}
	this.SerCall=function(){
		if(this.doer == null) this.doer = new ModelWriteSaveAnswerDo();
		if(this.doer.isvalid()==false) return true;
		
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams =this.doer.formdata();
		var vfnRes= JsController.apser.mdwanssave.SerCallRes;
		//console.log(vparams);
		
		
		this.doer.beforesave();		
		$.post(vurl, vparams, vfnRes, "json");
		
		return false;
	};
	this.SerCallRes=function(queryData){	
		JsController.apser.mdwanssave.doer.aftersave(queryData);	
	};	
	this.SerCallFin=function(){		
		if(this.doer.isvalid()==false) return true;
		
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams =this.doer.formdata();
		var vfnRes= JsController.apser.mdwanssave.SerCallFinRes;
		//console.log(vparams);
		
		
		this.doer.beforesave();		
		$.post(vurl, vparams, vfnRes, "json");
		
		return false;
	};
	this.SerCallFinRes=function(queryData){	
		JsController.apser.mdwanssave.doer.aftersavefin(queryData);	
	};
}
function ModelWriteSaveAnswerDo(){
	this.answer_id = -1;
	this.question_id = -1;
	this.user_quiz_id = -1;
	this.isvalid=function(){
		//var vJ = JsController.apdata.qpaper.QuestionIndex - 1;		
		//var vI = JsController.apdata.qpaper.Pgr[vJ].idx-1;
		//var aq = JsController.apdata.qpaper.Qs[vI];
		
		var vIdx = JsController.apdata.qpaper.PagerIndex;
		var aq = JsController.apdata.qpaper.QueryQuestion(vIdx);
		
		this.answer_id = $('input[name=rdAns]:checked').val();
		if (typeof this.answer_id == 'undefined'){
			this.answer_id = -1;
		}
		//console.log(aq.QUserAnsId())
		//console.log(this.answer_id)
		if( (parseInt(this.answer_id) == -1) || 
			(parseInt(this.answer_id) !=-1 && aq.user_answer_id==parseInt(this.answer_id))){
			//alert("You have not selected answer");
			//this.ParseQuestionHtml();
			return false;
		}
		return true;
	};
	this.formdata=function(){
		//var vJ = JsController.apdata.qpaper.QuestionIndex - 1;		
		//var vI = JsController.apdata.qpaper.Pgr[vJ].idx-1;
		//var aq = JsController.apdata.qpaper.Qs[vI];
		
		var vIdx = JsController.apdata.qpaper.PagerIndex;
		var aq = JsController.apdata.qpaper.QueryQuestion(vIdx);
		//console.log(aq);
		this.question_id = aq.question_id;
		this.user_quiz_id = JsController.apdata.pgQueryRes.r.assignment[0].user_quiz_id;
		var vdata = { 
			qno_l:aq.qno_l,
			qno_a:aq.qno_a,
			question_id:this.question_id,
			answer_id:this.answer_id,
			m:"dao_save_answer_only"
		} //, user_quiz_id:this.user_quiz_id
		//console.log({msg:"during save",res:vdata})
		return vdata;
	};
	this.aftersave=function(queryData){		
		/* ... Placing into Save Pool.... Do Coding Later
		*/
		//JsController.QuestionsRes.r.answer = queryData.r;
		//
		//console.log({msg:"after save",res:queryData})
		var vI = queryData.r.qno_a-1;
		var aq = JsController.apdata.qpaper.Qs[vI];
		//console.log({a:aq.user_answer_id, b:aq.user_answering_id});
		aq.user_answer_id = aq.user_answering_id;  aq.user_answering_id=-1;
		JsController.apdata.out.Pgr();
		setTimeout(this.aftersaveofmsg, 2000);		
		$("#myDbMsg").html("Saved Your Answer Successfully!");
		$("#myNonQBtns").css("display", "none");				
		
		//...
	};
	this.aftersavefin=function(queryData){				
		$("#myDbMsg").html("Finish Quiz...");
		$("#myNonQBtns").css("display", "none");
		$("#pageContent").html("Finishing Test....");
		//...save
		JsController.apser.mdwqzfin.SerCall();
	};
	this.beforesave=function(){
		/*... Marking Save Done at Save Pool.... Do Coding Later
		*/
		$("#myDbMsg").css("display","inline");		
		$("#myDbMsg").html("On Save Answer of Question...");
		$("#myNonQBtns").css("display", "block");
			
	}
	this.aftersaveofmsg=function(){
		$("#myDbMsg").html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
	}
}
function ModelWriteFinishQuiz(){ 
	this.SerCall=function(){	
		var vurl="form/conductTest/v2mConductTest.php";
		var lstatus = (JsController.apdata.qpaper.timerdata.QzTimeIsTimedOut==true ? 3 : 2);
		var vparams ={ 
			m:"dao_finish_quiz_only", 
			status:lstatus 
		};
			/* assignment_id:JsController.m_assignment_id, 
			user_id:JsController.apdata.user_id, 
			user_quiz_id:JsController.apdata.pgQueryRes.r.assignment[0].user_quiz_id, 
			*/
		//console.log(vparams);
		var vfnRes= JsController.apser.mdwqzfin.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
	};
	this.SerCallRes=function(queryData){					
		$("#myDbMsg").html("Finished Quiz!");
		console.log(queryData);
		//window.location.reload(false);
		JsController.apser.auth.RedirectTo();
	};	
}

function QPaper(){
	this.Qs = [];
	this.Pgr = [];
	this.QuestionIndex = -1;
	this.PagerIndex = -1;
	this.qutil = null;
	this.pgrutil = null;
	this.timer = null;
	this.timerdata = null;
	/*
		Qs:
			each Q: 
		Data Dictionary:
			Assessment:
				assignment_id, quiz_id, 
				quiz_time, pass_score, status, 
				cat_id, quiz_name, quiz_desc, show_intro, intro_text, 
				user_quiz_status, user_quiz_id, uq_added_date, pass_score_point	
			UserQuiz:
				user_quiz_status, user_quiz_id, uq_added_date
			Questions:
				question_id, quiz_id, question_text, header_text, footer_text, 
				curr_priority, next_priority, prev_priority, 				
				group_name,
				qno_a, qno_l
			Answers:
				answer_id, answer_text, correct_answer, priority, 
				correct_answer_text, group_id, group_name, question_id,
				user_answer_id
	*/
	this.Init = function(){
		this.qutil = new QUtilFns();
		this.pgrutil = new PgrUtilFns();
		this.timerdata = new TimerPaperData();		
	}
	this.prepareTest=function(){
		this.SuffleRuleDo();
		this.prepareTestPaper();
		//console.log(this.Qs)
		//console.log(this.Pgr)
		
		//JsController.apdata.out.Paper();
	}
	this.prepareTestPaper=function(){
		//alert(7);
		//console.log(JsController.apdata.QuestionsRes);

		
		var v_r = JsController.apdata.QuestionsRes.r;
		var v_rq = v_r.question; 
		var v_ra = v_r.answer;		
		
		this.Qs = [];
		this.Pgr = [];
		this.QuestionIndex = 10;
		this.PagerIndex = 10;
		
		for(var i=0; i < v_rq.length; i++)			
			this.addQ(i);	
		var oQs = [];
		for(var i=0; i < this.Pgr.length; i++){//			
			var oPgr = this.Pgr[i];
			var oQ = this.Qs[oPgr.qno-1];
			oQ.qno_l = oPgr.idx;
			oQs.push({qno_l:oQ.qno_l,qno_a:oQ.qno_a});
		}//
		
		//console.log(JSON.stringify(this.Pgr));	
		//console.log(JSON.stringify(oQs));	
		//console.log(JSON.stringify(CurrSuffledRules));
		
		this.Pgr.sort(function(a,b){				
				//return parseInt(a.qno) - parseInt(b.qno);
			}
		);
		
		//console.log(JSON.stringify(this.Pgr));	
	};
	this.addQ = function(pI){
		var v_r = JsController.apdata.QuestionsRes.r;
		var v_rq = v_r.question; 
		var v_ra = v_r.answer;	
		
		var aq = v_rq[pI];
			
		//aq.qno_a 
		aq.qno_a = pI + 1;
		aq.QUserAnsId = this.qutil.QUserAnsId;
		aq.IsAnswering = this.qutil.IsAnswering;
		aq.IsAnswered = this.qutil.IsAnswered;
		aq.IsLastQn = this.qutil.IsLastQn;
		aq.user_answer_id = -1;
		aq.user_answering_id = -1;
		this.addAns(pI);		
				
		aq.IsNotVisited = true;			 		
		//aq.qno_l 
		
		if(!CurrRulesIsThere)
			aq.qno_l = this.nextRandNo(pI);
		else
			aq.qno_l = this.nextRandNoByRule(pI);
		aq.IsCurrent = this.qutil.qIsCurrent;	
		aq.IsCur = aq.IsCurrent();				
		aq.IsNotAnswered = this.qutil.IsNotAnswered;;		
		this.Qs.push(aq);
		
		this.addPgrIt(pI);	
	};
	this.addPgrIt = function(pI){
		var v_r = JsController.apdata.QuestionsRes.r;
		var v_rq = v_r.question; 		
		var aq = v_rq[pI];	
		
		var aPgrIt = {qno:aq.qno_l, idx:aq.qno_a};
		aPgrIt.Q = this.pgrutil.qGet;	
		//console.log({aPgrIt:aPgrIt, Q:aPgrIt.Q()});
		//aPgrIt.Qo = aPgrIt.Q();
		aPgrIt.IsPagerLine = this.pgrutil.IsPagerLine;
		//aPgrIt.IsPagerLineo = aPgrIt.IsPagerLine();
		
		this.Pgr.push(aPgrIt);
	}
	this.addAns=function(pI){
		var v_r = JsController.apdata.QuestionsRes.r;
		var v_rq = v_r.question; 
		var v_ra = v_r.answer;	
		
		var aq = v_rq[pI];	
		aq.answer = [];
		
		for(var j=0; j < v_ra.length; j++){
			var aa = v_ra[j];
			if(parseInt(aa.question_id) != parseInt(aq.question_id)) continue;			
			if(parseInt(aa.user_answer_id)!=-1){			  
			   aq.user_answer_id = aa.user_answer_id;
			}
			aa.qno_a = aq.qno_a;
			aa.IsUserAnswered = this.qutil.qIsUserAnswered; 
			//aa.IsUserAnsweredo = aa.IsUserAnswered();
			aq.answer.push(aa);
		}
	}
	this.SuffleRuleDo = function(){
		//alert(32);
		CurrRulesIsThere = false;
		CurrSuffledRules=[];
		//console.log(!JsController.apser.config.SuffleIsThere);
		if(!JsController.apser.config.SuffleIsThere) return;		
		var v_r = JsController.apdata.pgQueryRes.r.assignment;	
		//console.log(v_r[0].quiz_name);
		for(i=0;i<vSuffleRule.length;i++)
			if(vSuffleRule[i].name == v_r[0].quiz_name){
				CurrRules = vSuffleRule[i];
				CurrRulesIsThere = true;
				break;
			}
		if(!CurrRulesIsThere) return;
		if(CurrRulesIsThere){
			//alert(CurrRules.name);
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
			//console.log(CurrSuffledRules);
			//console.log(JSON.stringify(CurrSuffledRules));
		}
		
	}
	this.existRuleNo=function(pNewRuleNo){		
		for(var i=0; i < CurrSuffledRules.length; i++)
			if(pNewRuleNo == CurrSuffledRules[i].newRuleNo)
				return true;			  
		return false;
	};
	this.nextRandNo = function(pI){
		var v_r = JsController.apdata.QuestionsRes.r;	 
		var v_rq = v_r.question;
		var rnd_max = v_rq.length;			
		var rnd_no = pI + 1;
		
		if(JsController.apser.config.SuffleIsThere){
			rnd_no = this.randNo(rnd_max);
			while(this.existQNo(rnd_no))
				rnd_no = this.randNo(rnd_max);
		}
		
		return rnd_no;
	};
	this.nextRandNoByRule = function(pI){
		var pFrom = CurrSuffledRules[CurrRuleSufIdx].rule.from;
		var pTo = CurrSuffledRules[CurrRuleSufIdx].rule.to;
		var SC = CurrSuffledRules[CurrRuleSufIdx].rule.suffleCount;
		var v_mx = pTo - pFrom + 1;
		//console.log([CurrRuleSufIdx ,SC , pFrom , pTo , v_mx]);
		//console.log(CurrSuffledRules[CurrRuleSufIdx].rule);
		//console.log(v_mx);
		var v_r = JsController.apdata.QuestionsRes.r;
		var v_rq = v_r.question; 
		
		var rnd_max = v_rq.length;			
		var rnd_no = pI + 1;
		
		if(JsController.apser.config.SuffleIsThere){
			rnd_no = this.randNo(v_mx) + pFrom - 1;
			while(this.existQNo(rnd_no))
				rnd_no = this.randNo(v_mx) + pFrom - 1;
			SC++;
			CurrSuffledRules[CurrRuleSufIdx].rule.suffleCount = SC;
			if(SC == v_mx)
				CurrRuleSufIdx ++;
		}
		
		return rnd_no;
	};
	
			
			
	this.randNo = function(pMax){ // util function
		var vNo = Math.floor(Math.random() * pMax) + 1;
		return vNo;
	};
	this.existQNo=function(pNewQNo){		
		for(var i=0; i < this.Pgr.length; i++)
			if(pNewQNo == this.Pgr[i].qno)
				return true;			  
		return false;
	};
	
	this.QueryQuestion = function(pDispIdxOneBased){ //PagerIndex points CurrentSnapshotQuestionIndex
		var vDispIdx = pDispIdxOneBased - 1;		
		var oPgr = JsController.apdata.qpaper.Pgr[vDispIdx];
		if(oPgr == null) return null;
		var vQIdx = oPgr.qno - 1;
		var oQuestion = JsController.apdata.qpaper.Qs[vQIdx];
		return oQuestion;
	} 
}

function PrintPaper(){
	this.Q = function(){		
		//var vJ = JsController.apdata.qpaper.QuestionIndex - 1;		
		//var vI = JsController.apdata.qpaper.Pgr[vJ].idx-1;
		//var vq = JsController.apdata.qpaper.Qs[vI];
		var vIdx = JsController.apdata.qpaper.PagerIndex; //QuestionIndex;
		var vq = JsController.apdata.qpaper.QueryQuestion(vIdx);
		if(vq == null) return;
		//console.log({vIdx:vIdx, vq_qno_a:vq.qno_a,vq_qno_l:vq.qno_l});
		vq.IsNotVisited = false;
		$("#pageContent").html(Mustache.render(
			JsController.aphtm.questionHtml, 
			{question:vq}
			));
		JsController.apdata.QStarted = true;		
		apUtil.focus('pageContent','myHeader');
	};
	
	this.SnapIs=false;
	this.Snap = function(){	
		if(this.SnapIs==true) return;
		this.SnapIs=true;
		$("#testPagers").css("display","block");
		$("#menuContent").css("display","none");
		$("#testPagers").html(
			JsController.aphtm.htmlQPager 
			);		
		if(JsController.apdata.QStarted == true){
			JsController.apdata.qpaper.timerdata.init();
		}	
	};
	this.Pgr = function(){	
		$("#myQMatrix").html(Mustache.render(
			JsController.aphtm.htmlQMatrix, 
			{pager:JsController.apdata.qpaper.Pgr}
			));
			
	};	
	this.Paper=function(){		
		this.Q();
		this.Snap();
		this.Pgr();
		//console.log(JsController.apdata.qpaper.Qs);
	}
	this.Menu = function(){	
		$("#menuContent").html(JsController.apser.mdmnu.preparedHtml);		
	};
	this.Instruction = function(){	
		var v_r = JsController.apdata.pgQueryRes.r.assignment;
		//console.log(JsController.apser.mdass.doer.preparedDatInstruction );
		var vRenHtmPage = Mustache.render(JsController.aphtm.PgHtml,
			JsController.apser.mdass.doer.preparedDatInstruction 
		);		
		$("#pageContent").html(vRenHtmPage);
		
		if(JsController.apdata.QStarted){
			$("#btnContinue").css("display","inline");
			$("#msgContinue").css("display","none");
		}else
			setTimeout(function(){
				$("#btnContinue").css("display","inline");
				$("#msgContinue").css("display","none");
				}, 10*1000);
	};
	this.PaperOnly=function(){
		this.Q();
	};
}
function QUtilFns(){
	this.qIsCurrent = function(){		
		return this.qno_l == JsController.apdata.qpaper.PagerIndex;//QuestionIndex;
	}
	this.qIsUserAnswered = function(){	
		var pI = this.qno_a-1;
		//console.log({pI:pI,aid:this.answer_id, uid:JsController.apdata.qpaper.Qs[pI].user_answer_id})
		return pI!=-1 && 
			(
			parseInt(this.answer_id) == parseInt(JsController.apdata.qpaper.Qs[pI].QUserAnsId())
			);		
	}
	this.qHasStarted = function(){
		return JsController.apdata.QStarted;
	}
	this.IsAnswered = function(){	
		return parseInt(this.QUserAnsId()) != -1;
	}
	this.IsLastQn = function(){	
		return (this.qno_l == JsController.apdata.qpaper.Pgr.length);
	}
	this.IsAnswering = function(){	
		return parseInt(this.user_answering_id) != -1;
	}
	this.QUserAnsId = function(){	
		var a = parseInt(this.user_answer_id); 
		var b = parseInt(this.user_answering_id);
		return b!=-1 ? b : a;
	}
	this.IsNotAnswered = function(){	
		return !this.IsAnswered();
	}
}

function PgrUtilFns(){
	this.qGet = function(){	
		var pI = this.idx-1;
		var pQID = this.qno - 1;
		var aq = JsController.apdata.qpaper.Qs[pQID];
		//console.log({pI:pI, qno_a:aq.qno_a, qno_l:aq.qno_l, aq:aq});
		return aq;
	}	
	this.IsPagerLine = function(){	
		return this.idx % 5 == 0;
	}	
}


function frmActions(){
	this.NextToInstructions=function(){		
		var v_rass = JsController.apdata.pgQueryRes.r.assignment[0];
		
		JsController.apdata.qpaper.PagerIndex = 1; //QuestionIndex = 1;
		JsController.apdata.out.Paper();		
	}	
	this.ShowInstruction=function(){		
		JsController.apdata.out.Instruction();
	}
	this.LoadQuestionByNo=function(pQno){	
		JsController.apdata.qpaper.PagerIndex = pQno; // QuestionIndex=pQno;
		JsController.apdata.out.Paper();
	}
	this.PreviousQuestion=function(){	
		//...Saving 
		this.setAnswer(false);
		if(JsController.apdata.qpaper.PagerIndex>1){	
			JsController.apdata.qpaper.PagerIndex-=1;			
		}
		this.saveAnswerBef();	
	}
	this.NextQuestion=function(){	
		//...Saving 
		this.setAnswer(false);
		if(JsController.apdata.qpaper.PagerIndex < 
			JsController.apdata.qpaper.Pgr.length){
			JsController.apdata.qpaper.PagerIndex+=1;			
		}
		this.saveAnswerBef();
	}
	this.FinishTest=function(){	
		this.setAnswer(true);
		this.saveAnswerBef();
		//....
	}
	this.saveAnswerBef = function(){		
		JsController.apdata.out.Paper();
		if(this.setAnswerIs == false) return;
		JsController.apser.mdwanssave.doer.beforesave();	
		this.setAnswerIs = false;
	}
	this.setAnswerIs = false;
	this.setAnswer = function(pIsFinish){
		//console.log(13313);
		var answer_id = $('input[name=rdAns]:checked').val();
		if (typeof answer_id == 'undefined'){
			answer_id = -1;
		}
		
		//var vJ = JsController.apdata.qpaper.QuestionIndex - 1;		
		//var vI = JsController.apdata.qpaper.Pgr[vJ].idx-1;
		//var aq = JsController.apdata.qpaper.Qs[vI];
		
		var vIdx = JsController.apdata.qpaper.PagerIndex;
		var aq = JsController.apdata.qpaper.QueryQuestion(vIdx);
		
		//console.log(aq);
		//console.log(aq.QUserAnsId());
		//console.log(parseInt(answer_id));
		/* if(parseInt(aq.QUserAnsId()) != parseInt(answer_id)){
			aq.user_answering_id=answer_id;
			//console.log("Inside");
			if(!pIsFinish)
				JsController.apser.mdwanssave.SerCall();
			else
				JsController.apser.mdwanssave.SerCallFin();
			this.setAnswerIs = true;
		} */
		//alert(1133);
		if(!pIsFinish){
			if(parseInt(aq.QUserAnsId()) != parseInt(answer_id)){
				aq.user_answering_id=answer_id;
				JsController.apser.mdwanssave.SerCall();
				this.setAnswerIs = true;
			}
		}	
		else{
			//alert(11);
			if(parseInt(aq.QUserAnsId()) != parseInt(answer_id)){
				JsController.apser.mdwanssave.SerCallFin();			
				this.setAnswerIs = true;
			}else{				
				JsController.apser.mdwanssave.doer.aftersavefin("");
				this.setAnswerIs = true;
			}
		}	
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
		JsController.apdata.qpaper.timerdata.initializer();
	}
	this.initializer =function(){	
		if(this.initIs == true) return;
		this.initIs = true;
		var v_r = JsController.apdata.pgQueryRes.r.assignment;
		
		
		this.DbQuizStartTime = new Date(v_r[0].uq_added_date);
		this.DbQuizServerNow = new Date(JsController.apdata.pgQueryRes.r.now_server);
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
		
		vMins=parseInt(vMins); vSecs=parseInt(vSecs);
		JsController.apdata.qpaper.timer = new TimerPaper("myRemainingTime, #myRemainingTime02", "myTestStartAt", vMins, vSecs, this.ClientQuizStartTime, this.QuizSecs);
		JsController.apdata.qpaper.timer.Init_Timer();
	};	
	this.endTestByTimeOut =function(){
			this.QzTimeIsTimedOut = true;
			//JsController.FinishTest(); //.... do here
			JsController.apser.mdwqzfin.SerCall();
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
		//alert("Timer" + 2323);
		var timer = JsController.apdata.qpaper.timer;
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
		var vMin = this.Pad(pMin);
		var vSec = this.Pad(pSec);
		//var vText = vMin + ":" + vSec;
		var vText = Mustache.render(JsController.aphtm.TimerHtml,{timer:{min:vMin,sec:vSec,class:"timerCounter",clsDiv:"timerDiv"}});
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


function AppUtil(){
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

var apUtil = new AppUtil();