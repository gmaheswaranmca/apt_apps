/*
//DB
var aptDbName = 'aptPref';
var aptDb = new PouchDB(aptDbName);
var remoteCouch = false;
var aptDbCanDoFurther = false;
var aptDbHasScanned = false;
aptDb.info().then(function (info) {
	  console.log(info);
	  aptDbCanDoFurther = true;
	  aptDbHasScanned=true;
	}).catch(function(err){
		console.log(info);
		aptDbHasScanned=true;
	});*/

//Cookie
var aptDbCanDoFurther = true;
var aptDbHasScanned = true;
var appTabChangedCount = 0;
var appAutoLogoutCount = 0;
var aptCaptureAppChangeEnable = false;
function aptCaptureAppChange(){
	if(!aptCaptureAppChangeEnable) return;
	var finMsg = 'Please do not switch from the test to other apps.<br>You have switched to other tab or other app :cnt~ times.<br> We are monitoring you.<br> You will be informed about this to our test management.<br>Wait we will load your test shortly.';
		var IsOnFinMsg = false;
		var finMsgParsed = function(){
			var ret =  finMsg.replace(':cnt~',appTabChangedCount);
			if(appTabChangedCount >= ((appAutoLogoutCount+1) * 5)) ret += '<br>You are violating test taking rules and regulations.';
			return ret;
		};var finMsgD = function(){ 
			$('#PageBefExtraText').html(finMsgParsed());
		};
		
		var fn3 = function(){
			if(IsOnFinMsg) return;
			setTimeout(function(){
				$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');						
				IsOnFinMsg=false;
			},3000);
			IsOnFinMsg=true;
		}
		var fn1 = function(){
			setTimeout(function(){				
				finMsgD();
				var focused = document.hasFocus();
				if(focused) fn3(); else fn1();				
			}, 100);
		};
		var fn2 = function(){	 		
				appTabChangedCount++;
				setCkQnoVisitedReset();				
				finMsgD();
				$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
				fn1();					
		};	
		$(window).focus(function () {
			
		});

		$(window).blur(function () {
			fn2();
		})
		
		document.addEventListener("visibilitychange", function() {
			if(document.hidden)	fn2();	
		});
}

function setCk(aptUserId, aptUserQuizId, aptQno, qnVisited){
	Cookies.set('aptUserId', aptUserId);
	Cookies.set('aptUserQuizId', aptUserQuizId);
	Cookies.set('aptQno', aptQno);	
	Cookies.set('qnVisited', qnVisited);
	Cookies.set('appTabChangedCount', appTabChangedCount);
	Cookies.set('appAutoLogoutCount', appAutoLogoutCount);
}function setCkQnoVisitedReset(){
	setCk(JsController.apdata.user_id, JsController.apdata.user_quiz_id, 1, '');	
}
function setCkQnNumber(qno){
	/*
	//DB
	if(!aptDbCanDoFurther) return;	
	aptDb.get('1').then(function(rec){				
		rec.aptUserId = JsController.apdata.user_id;
		rec.aptUserQuizId = JsController.apdata.user_quiz_id;
		rec.aptQno = qno;
		rec.qnVisited=setQnVisited();
		aptDb.put(rec);
	}).catch(function(err){console.log(err);});	
	*/
	
	//Cookie
	setCk(JsController.apdata.user_id, JsController.apdata.user_quiz_id, qno, setQnVisited());	
}function getCkQnNumber(){
	/*
	//DB
	var vPagerIndex =  1; 
	if(!aptDbCanDoFurther){
		JsController.apdata.qpaper.PagerIndex = vPagerIndex; 
		JsController.apdata.out.Paper();
		return;
	}	
	aptDb.get('1').then(function(rec){
		vPagerIndex =  1; 
		if(JsController.apdata.user_id == rec.aptUserId && JsController.apdata.user_quiz_id == rec.aptUserQuizId){
			vPagerIndex =  rec.aptQno;			
			parseQnVisited(rec.qnVisited);
		}
		JsController.apdata.qpaper.PagerIndex = vPagerIndex; 		
		JsController.apdata.out.Paper();		
	}).catch(function(err){	console.log(err); 
			JsController.apdata.qpaper.PagerIndex = vPagerIndex; 
			JsController.apdata.out.Paper();
		}
	);
	*/
	
	//Cookie
	var vPagerIndex =  1; 
	if(parseInt(JsController.apdata.user_id) == parseInt(Cookies.get("aptUserId")) && 
		parseInt(JsController.apdata.user_quiz_id) == parseInt(Cookies.get("aptUserQuizId"))){
		vPagerIndex =  parseInt(Cookies.get("aptQno"));					
		parseQnVisited(Cookies.get("qnVisited"));
		appTabChangedCount = parseInt(Cookies.get("appTabChangedCount"));
		appAutoLogoutCount = parseInt(Cookies.get("appAutoLogoutCount"));
	}
	JsController.apdata.qpaper.PagerIndex = vPagerIndex; 		
	JsController.apdata.out.Paper();			
	$('#idLogout').css('display','none'); 
	$('#idFinish').css('display','inline-block');
}function setQnVisited(){
	var Qns = JsController.apdata.qpaper.Qs;
	var val = '';
	for(I=0;I<Qns.length;I++){
		var Qn = Qns[I]; var IsNotVisited = (Qn.IsNotVisited ? "1" : "0");
		if(val != '') val += ','; val += Qn.question_id + ":" + IsNotVisited;
	}return val;
}function parseQnVisited(ids){
	if(ids == '') return;
	ids=JSON.parse("{\"qn" + ids.replace(/,/g,',"qn').replace(/:/g,'":') + "}");
	var Qns = JsController.apdata.qpaper.Qs;
	for(I=0;I<Qns.length;I++){
		var Qn = Qns[I]; var IsNotVisited = ids["qn" + Qn.question_id]=="1";
		Qn.IsNotVisited = IsNotVisited;		
	}
}function getAnsweredQns(){
	var Qns = JsController.apdata.qpaper.Qs;
	var val = '';	
	var vCurQnIdx = JsController.apdata.qpaper.QueryQuestionIndex(JsController.apdata.qpaper.PagerIndex);//ZeroBased
	for(I=0;I<Qns.length;I++){
		var Qn = Qns[I];Qn.user_answer_id = parseInt(Qn.user_answer_id); var answer_id = Qn.user_answer_id;
		if(I==vCurQnIdx) answer_id = Qn.user_answering_id;
		if(val != '') val += ',';	val += Qn.question_id + ":" +  answer_id;
	}return val;
}function parseAnsweredQns(ids){	
	ids=JSON.parse("{\"qn" + ids.replace(/,/g,',"qn').replace(/:/g,'":') + "}");
	var Qns = JsController.apdata.qpaper.Qs;
	for(I=0;I<Qns.length;I++){
		var Qn = Qns[I]; var user_answer_id = ids["qn" + Qn.question_id];
		Qn.user_answer_id = user_answer_id;		
	}
}function getQnsFinish(){
	var Qns = JsController.apdata.qpaper.Qs;
	var val = {'qn_count':Qns.length,'qns_answered':0, 'qns_not_answered':0, 'qns_not_visited':0};	
	for(I=0;I<Qns.length;I++){
		var Qn = Qns[I];
		if(Qn.IsAnswering() || ((!Qn.IsAnswering()) && Qn.IsAnswered()))	val.qns_answered++;
		else if(!Qn.IsNotVisited) val.qns_not_answered++;
		else val.qns_not_visited++;		
	}return val;
}


function ConductTestJsController(passignment_id){
	this.m_assignment_id = passignment_id;	
	this.apdata = null;
	this.aphtm = null;
	this.apser = null;
	
	this.OnLoad=function(){				
		if(this.apdata==null)  this.apdata= new AppData();	
		if(this.aphtm==null)  this.aphtm= new AppHtml();
		if(this.apser==null)  this.apser = new AppSerCalls();
		aptCaptureAppChange();
		this.apser.Init();				
	};
}	
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
		JsController.apdata.qpaper = new QPaper();
		JsController.apdata.qpaper.Init();
		JsController.apdata.out = new PrintPaper();
		this.action = new frmActions();; 
	}
}

function AppHtml(){
	this.PgHtml = "";	
	this.TitleHtml = 
"{{#quiz}}<span class='AboutQuizInScreen'><span>{{quiz_name}}</span>, <span>Total number of questions:</span><span id='myQCount'>{{score}}</span>, <span>Max Time Limit: {{quiz_time}} minutes</span></span><span class='AboutQuizInMobile'>{{quiz_name}}, {{score}} Qns, Time: {{quiz_time}} mins</span>{{/quiz}}";
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

	this.viewpg = null;
	this.mdass = null;
	this.mdwshufids = null;
	
	this.Init=function(){
		//alert(7346);		
		JsController.apdata.Init();
		
		this.log = new AppLogger();		
		this.config = new AppConfig();
		this.viewpg = new PageView();
		this.mdass = new ModelAssessment();
		this.mdwshufids = new ModelSaveShuffleIDs();
		var fnCount = 0;
		var fn = function(){
			setTimeout(function(){
				if(fnCount >= 100) aptDbHasScanned=true;				
				fnCount++;//console.log(['Reading Db ', fnCount, aptDbHasScanned] );
				if(aptDbHasScanned)	
					JsController.apser.viewpg.SerCall(); 
				else
					fn();				
			}, 1*100);
		};
		fn();		
	};
}

function PageView(){ 
	this.SerCall=function(){
		$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
		var vurl="form/conductTest/v2mConductTest.php";
		var vparams ={ m: "html",			
			assignment_id:JsController.m_assignment_id};
		var vfnRes = JsController.apser.viewpg.SerCallRes;
		$.post(vurl, vparams, vfnRes,"json");
	};
	this.SerCallRes=function(pData){
		if(pData.r.IsLoggedIn == "0"){
			window.location.href = "login.php";
			return;
		}
		JsController.aphtm.PgHtml = pData.r.vhtml;
		JsController.aphtm.vFinishTP = pData.r.vFinishTP;
		

		JsController.apdata.pgQueryRes = {r:pData.r.mdassessment};	
		
		if(this.doer == null) JsController.apser.mdass.doer = new ModelAssessmentDo();
		
		
		JsController.aphtm.questionHtml = pData.r.vquestion_htm;	
		
		JsController.aphtm.htmlQPager = pData.r.vpager_htm;		
		
		JsController.aphtm.htmlQMatrix = pData.r.vpager_qmatrix_htm;		
		
		// JsController.aphtm.menuHtml = pData.r.vmenu;
		// JsController.apser.mdmnu.SerCallRes({r:pData.r.mdmenu});
		
		JsController.apdata.QuestionsRes = {r:pData.r.mdqnAns};		
		//if(pData.r.mdassessment.assignment!=null)
			//JsController.apdata.qpaper.prepareTest();
		
		JsController.apser.mdass.doer.render();
		$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
	};
}

function ModelAssessment(){
	this.doer = null;
}

function ModelAssessmentDo(){
	this.preparedDatInstruction = null;
	this.render=function(){
		this.parse();			
		JsController.apdata.qpaper.prepareTest();
		var v_r = JsController.apdata.pgQueryRes.r.assignment;
		JsController.apdata.QStarted = false;
		
		JsController.apser.mdass.doer.preparedDatInstruction ={ 
			quiz: v_r==null?v_r:v_r[0],  
			show_error: JsController.apdata.v_show_error, 
			is_timedout: JsController.apdata.v_is_timedout};
		
		$("#myUserName").html(JsController.apdata.user_name);
		$("#myFullName").html(JsController.apdata.full_name);
		
		
		if(v_r != null){		
			var vRenHtmTitle = Mustache.render(JsController.aphtm.TitleHtml, {quiz: v_r[0]} ); 				
			$("#myTitle").html(vRenHtmTitle);
		}
		
		
		if(JsController.apdata.v_show_error){
			var vmsg = "You have already finished this quiz	";
			if(JsController.apdata.v_is_timedout) vmsg += " by time out.";
			//alert(vmsg);
			window.location.href = "ActiveAssignmentRes.php";
			return;
		}else if(v_r == null){
			var vmsg = "You don't have access to this quiz.";
			//alert(vmsg);
			window.location.href = "ActiveAssignmentRes.php";
			return;
		}else if(JsController.apdata.pgQueryRes.r.IsFirstTimeVisit=="1"){
			//alert(111)
			JsController.apdata.out.Instruction();	
		}
		else {
			//alert(211)
			JsController.apdata.action.NextToInstructions();
		}
		
		/*if(v_r!=null && v_r[0].user_quiz_status==0){  
			JsController.apser.mdwqzinit.SerCall();
		}*/
	};this.parse=function(){
		var v_r = JsController.apdata.pgQueryRes.r.assignment;
		JsController.apdata.user_id = JsController.apdata.pgQueryRes.r.user_id;
		JsController.apdata.user_name = JsController.apdata.pgQueryRes.r.user;		
		JsController.apdata.full_name = JsController.apdata.pgQueryRes.r.full_name;
		
		if(v_r != null){
			v_r[0].quiz_time = parseInt(v_r[0].quiz_time);
			v_r[0].pass_score = parseInt(v_r[0].pass_score);	
			v_r[0].pass_score_point = parseInt(v_r[0].pass_score_point);			
			v_r[0].QStarted = JsController.apdata.qpaper.qutil.qHasStarted;
			JsController.apdata.v_show_error = v_r[0].user_quiz_status>=2;
			JsController.apdata.v_is_timedout = v_r[0].user_quiz_status==3;
			JsController.apdata.tp_rule = v_r[0].tp_rule;
			v_r[0].score = v_r[0].pass_score;
			
			JsController.apdata.shuffled_qn_ids = v_r[0].shuffled_qn_ids.trim();
			
			JsController.apdata.user_quiz_id = v_r[0].user_quiz_id;
		}//else JsController.apdata.v_show_error = true;
	};
}function ModelSaveShuffleIDs(){
	this.SerCall=function(p_shuffled_qn_ids){	
		var vurl="form/conductTest/v2mConductTest.php";		
		var vparams ={ m:"dao_save_shuffle_ids", assignment_id:JsController.m_assignment_id,shuffled_qn_ids:p_shuffled_qn_ids};
		var vfnRes= JsController.apser.mdwshufids.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
	};this.SerCallRes=function(queryData){	
		var v_r = queryData.r;
		//console.log(v_r);
	};	
}

var mdAdjustQuizTime = new function(){
	this.SerCall=function(){	
		var vurl="form/conductTest/v2mConductTest.php";		
		var vparams = {m:"mdAdjustQuizTime"};
		var vfnRes= mdAdjustQuizTime.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
	};this.SerCallRes=function(queryData){	
		console.log(['Adjusted Quiz Time', queryData]);		
	};	
}

var mdSaveQnAns = new function(){
	this.SerCall=function(){	
		//alert(3)
		var vdata = mdQnCurr.isvalid();
		//console.log(vdata);
		if(!vdata.is_valid) return false;		
		var vurl="form/conductTest/v2mConductTest.php";		
		var vparams = vdata.post_data;
		var vfnRes= mdSaveQnAns.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
	};this.SerCallRes=function(queryData){	
		//alert(4)
		var v_r = queryData.r;
		var vIdx = parseInt(v_r.qno_a)-1;
		var aq = JsController.apdata.qpaper.Qs[vIdx];
		aq.user_answer_id = aq.user_answering_id;  aq.user_answering_id=-1;
		JsController.apdata.out.Pgr();
		//console.log(v_r);
	};	
}
var mdQnCurr = new function(){
	this.isvalid=function(){
		var vIdx = JsController.apdata.qpaper.PagerIndex;
		var aq = JsController.apdata.qpaper.QueryQuestion(vIdx);
		
		var answer_id = $('input[name=rdAns]:checked').val();
		if (typeof answer_id == 'undefined'){
			answer_id = -1;
		}if((parseInt(answer_id) == -1) || 
			(parseInt(answer_id) !=-1 && aq.user_answer_id==parseInt(answer_id))){
			return {is_valid: false} ;
		}
		aq.user_answering_id = answer_id;
		return { 
			is_valid: true, post_data:{
				qno_l:aq.qno_l,
				qno_a:aq.qno_a,
				question_id:aq.question_id,
				answer_id:answer_id,
				answered_ids: getAnsweredQns(),
				m:"dao_save_answer_only"
				}
		};
	};
}
var mdEndTP = new function(){
	this.SerCall=function(){	
		//alert(1)
		var finMsg = 'We are finishing your test.<br> Please wait few moments.<br> Do not Close Browser.';
		$("#pageContent").html(finMsg);
		$('#PageBefExtraText').html(finMsg);
		$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
		
		var vdata = mdQnCurr.isvalid();		
		var vurl="form/conductTest/v2mConductTest.php";		
		var vparams = {};
		if(vdata.is_valid){
			vparams = vdata.post_data;
			vparams.is_qn = 1;
		}
		vparams.m = "dao_finish_quiz_only";
		
		vparams.status = (JsController.apdata.qpaper.timerdata.QzTimeIsTimedOut==true ? 3 : 2);
		vparams.quiz_time = JsController.apdata.pgQueryRes.r.assignment[0].quiz_time;
		
		var vfnRes= mdEndTP.SerCallRes;
		$.post(vurl, vparams, vfnRes, "json");
	};this.SerCallRes=function(queryData){	
		//alert(2)
		//console.log(queryData);
		window.location.href = "ActiveAssignmentRes.php";
	};	
}

function QPaper(){
	this.Qs = [];
	this.Pgr = [];
	this.QuestionIndex = 0;
	this.PagerIndex = 0;
	this.qutil = null;
	this.pgrutil = null;
	this.timer = null;
	this.timerdata = null;

	this.Init = function(){
		this.qutil = new QUtilFns();
		this.pgrutil = new PgrUtilFns();
		this.timerdata = new TimerPaperData();		
	}
	this.prepareTest=function(){
		this.SuffleRuleDo();
		this.prepareTestPaper();
	}
	this.prepareTestPaper=function(){
		var v_r = JsController.apdata.QuestionsRes.r;
		var v_rq = v_r.question; 
		var v_ra = v_r.answer;		
		
		this.Qs = [];
		this.Pgr = [];
		//this.QuestionIndex = 10;
		//this.PagerIndex = 10;
		if(JsController.apdata.shuffled_qn_ids != ''){
			var ids = JsController.apdata.shuffled_qn_ids;			
			JsController.apdata.shuff_ids=JSON.parse("{\"qn" + ids.replace(/,/g,',"qn').replace(/:/g,'":') + "}")
		}
		
		var QsPosition = '';
		for(var i=0; i < v_rq.length; i++){
			var aq = v_rq[i];
			this.addQ(i);	
			QsPosition += QsPosition == '' ? '' : ',';
			QsPosition += (aq.question_id + ':' + aq.qno_l);
		}
		if(JsController.apdata.shuffled_qn_ids == ''){
			//alert(123);
			//console.log(QsPosition);			
			JsController.apser.mdwshufids.SerCall(QsPosition);
		}		
		var oQs = [];
		for(var i=0; i < this.Pgr.length; i++){
			var oPgr = this.Pgr[i];
			var oQ = this.Qs[oPgr.qno-1];
			oQ.qno_l = oPgr.idx;
			//oQs.push({qno_l:oQ.qno_l,qno_a:oQ.qno_a});						
		}
		
		
		
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
		
		if(JsController.apdata.shuffled_qn_ids != ''){			
			aq.qno_l = JsController.apdata.shuff_ids['qn'+aq.question_id];			
			//if(pI == 0)
				//alert(JsController.apdata.shuffled_qn_ids[pI][0] + ',' + aq.question_id)
		}
		else if(!CurrRulesIsThere)
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
	};
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
		CurrRulesIsThere = false;
		CurrSuffledRules=[];
		
		if(!JsController.apser.config.SuffleIsThere) return;		
		var v_r = JsController.apdata.pgQueryRes.r.assignment;	
		if(v_r == null) return;
		
		if(JsController.apdata.tp_rule != ''){
			var rule_json = JSON.parse(JsController.apdata.tp_rule);
			//console.log(rule_json);
			CurrRules = {
				'name' : v_r[0].quiz_name,
			    'rule' : rule_json
				};
			CurrRulesIsThere = true;
			//alert('Wow');
		}else{
			for(i=0;i<vSuffleRule.length;i++)
				if(vSuffleRule[i].name == v_r[0].quiz_name){
					CurrRules = vSuffleRule[i];
					CurrRulesIsThere = true;
					break;
				}
			if(!CurrRulesIsThere) return;
		}
		
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
				//console.log(aSuffledRule);
				CurrSuffledRules.push(aSuffledRule);
			}
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
	};this.randNo = function(pMax){ // util function
		var vNo = Math.floor(Math.random() * pMax) + 1;
		return vNo;
	};this.existQNo=function(pNewQNo){		
		for(var i=0; i < this.Pgr.length; i++)
			if(pNewQNo == this.Pgr[i].qno)
				return true;			  
		return false;
	};this.QueryQuestion = function(pDispIdxOneBased){ //PagerIndex points CurrentSnapshotQuestionIndex
		var vDispIdx = pDispIdxOneBased - 1;		
		var oPgr = JsController.apdata.qpaper.Pgr[vDispIdx];
		if(oPgr == null) return null;
		var vQIdx = oPgr.qno - 1;
		var oQuestion = JsController.apdata.qpaper.Qs[vQIdx];
		return oQuestion;
	};this.QueryQuestionIndex = function(pDispIdxOneBased){ //PagerIndex points CurrentSnapshotQuestionIndex
		var vDispIdx = pDispIdxOneBased - 1;		
		var oPgr = JsController.apdata.qpaper.Pgr[vDispIdx];
		if(oPgr == null) return null;
		var vQIdx = oPgr.qno - 1;		
		return vQIdx;
	} 
}

function PrintPaper(){
	this.Q = function(){		
		var vIdx = JsController.apdata.qpaper.PagerIndex; //QuestionIndex;
		var vq = JsController.apdata.qpaper.QueryQuestion(vIdx);
		if(vq == null) return;
		
		vq.IsNotVisited = false; //setQnVisited();
		$("#pageContent").html(Mustache.render(
			JsController.aphtm.questionHtml, 
			{question:vq}
			));
		JsController.apdata.QStarted = true;		
		apUtil.focus('pageContent','myHeader');
		
		setCkQnNumber(vIdx);
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
	}
	this.Menu = function(){	
		// $("#menuContent").html(JsController.apser.mdmnu.preparedHtml);		
	};
	this.Instruction = function(){	
		var v_r = JsController.apdata.pgQueryRes.r.assignment;
		
		var vRenHtmPage = Mustache.render(JsController.aphtm.PgHtml, JsController.apser.mdass.doer.preparedDatInstruction);		
		$("#pageContent").html(vRenHtmPage);
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
		
		return aq;
	}	
	this.IsPagerLine = function(){	
		return this.idx % 5 == 0;
	}	
}

function frmActions(){
	this.NextToInstructions=function(){		
		var v_rass = JsController.apdata.pgQueryRes.r.assignment[0];
		
		if(JsController.apdata.pgQueryRes.r.IsFirstTimeVisit=="1")
			mdAdjustQuizTime.SerCall();
		
		if(!JsController.apdata.QStarted){
			//JsController.apdata.qpaper.PagerIndex =  1; 
			getCkQnNumber();
		}
		else
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
		mdSaveQnAns.SerCall();
		if(JsController.apdata.qpaper.PagerIndex>1)	JsController.apdata.qpaper.PagerIndex-=1;		
		JsController.apdata.out.Paper();
	}
	this.NextQuestion=function(){	
		mdSaveQnAns.SerCall();
		if(JsController.apdata.qpaper.PagerIndex < JsController.apdata.qpaper.Pgr.length) JsController.apdata.qpaper.PagerIndex+=1;		
		JsController.apdata.out.Paper();
	}
	this.FinishTest=function(){	
		var vRenHtmPage = Mustache.render(JsController.aphtm.vFinishTP, {'finish_tp':getQnsFinish()});		
		$("#pageContent").html(vRenHtmPage);
		$("#testPagers").css('display','none');
		return false;
	}
	this.AcceptFinish=function(){	
		mdEndTP.SerCall();
		return false;
	}
	this.CancelFinish=function(){	
		JsController.apdata.out.Paper();
		$("#testPagers").css('display','block');
		return false;
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
			//JsController.FinishTest();
			//JsController.apser.mdwqzfin.SerCall();
			mdEndTP.SerCall();
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
    this.Init_Timer = function(){            

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
		var timer = JsController.apdata.qpaper.timer;
		
		timer.StartTimerLogicBefore();		
		timer.TimerID = self.setTimeout(timer.StartTimer, 1000);			
		timer.StartTimerLogicAfter();		
	};
	this.StartTimerLogicBefore = function () {
		this.TimerRunning = true;
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
		
		if(!(this.mins == vam && this.secs == vas)) {this.mins = vam; this.secs = vas;}
		
		if (this.mins == 5 && this.secs == 0) {
			
		}
		else if (this.mins <= 0 && this.secs <= 0)
		{
			//alert("Time ended !");			
			timerdata.endTestByTimeOut();
			
			this.StopTimer();
			this.TimerRunning = false;			
		}
		else{
			
		}
		$("#" + this.StartAtId).html(vStr);
	}
	this.outTmrs = function(pIds, pMin, pSec){
		var vMin = this.Pad(pMin);
		var vSec = this.Pad(pSec);
		
		var vText = Mustache.render(JsController.aphtm.TimerHtml,{timer:{min:vMin,sec:vSec,class:"timerCounter",clsDiv:"timerDiv"}});
		$("#" + pIds).html(vText);
	}
    this.Pad =  function (number){
		if (number < 10)
			number = 0 + "" + parseInt(number);
		return number;
	}	
}


function AppUtil(){
  this.focus = function(pEleById,pEleVariable){
		//return;
		var element = document.getElementById(pEleVariable); 
		var positionInfo = element.getBoundingClientRect();
		var a = positionInfo.height;
		var b = $('#' + pEleById).offset().top;
		var bsuba=b-a;
		
		 $('html, body').animate({
				scrollTop:  b - a				
			}, 250);	
  }
}

var apUtil = new AppUtil();

