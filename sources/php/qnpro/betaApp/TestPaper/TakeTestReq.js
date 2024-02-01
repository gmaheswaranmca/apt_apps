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
	},'mdQnSaveDo':{'url':'TestPaper/TestPaperDo.php',
		'params':{'m':'mdQnSaveDo'}
	}	
};var TakeTestReqDoRes = {
	'vTakeTestPage':{},
	'mdQnSaveDo':{}
};var TakeTestReqRes = new function (){ 
	this.vTakeTestPage = null;
	this.mdQnSaveDo = null;
	/*this.vTakeTestPage = new function(){
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
	this.mdQnSaveDo = new function(){
		this.gfRes = function(pRes){
			TakeTestReqRes.mdQnSaveDo.Dor.fResLog(pRes);
			TakeTestReqRes.mdQnSaveDo.fResDo();			
		};this.gfResFail = function(){
			var Dor = TakeTestReqRes.mdQnSaveDo.Dor;
			Dor.fResFailLog();
			Dor.Tmr.fRun(); 
		};this.gfTmrStart = function(){			
			TakeTestReqRes.mdQnSaveDo.Dor.Tmr.fStart()
		};this.gfTmrTask = function(){			
			TakeTestReqRes.mdQnSaveDo.Dor.fReqDo();
		};this.fResDo = function(){			
			var Res = TakeTestReqDoRes[this.Dor.ReqName];							
			//return;
			TakeTestViewRender.SaveTestPaperQn();				
		};this.Init=function(){
			this.Dor = new ReqDo(TakeTestReqDoConfig, TakeTestReqDoRes, 'mdQnSaveDo', this.gfRes, this.gfResFail, 
								this.gfTmrStart,this.gfTmrTask,'mdQnSaveDoReq');
			this.Dor.Init();
		};this.Dor = null;				
	};*/
	this.Init=function(){
		this.vTakeTestPage = new gfMgr.DefServiceReq(TakeTestReqRes,TakeTestReqDoConfig,TakeTestReqDoRes, 'vTakeTestPage',
			function(){
				var Res = TakeTestReqDoRes[this.Dor.ReqName];
				TakeTestViewRender.vTakeTestPage.Res(Res);
			}
		);
		this.mdQnSaveDo = new gfMgr.DefServiceReq(TakeTestReqRes,TakeTestReqDoConfig,TakeTestReqDoRes, 'mdQnSaveDo',
			function(){
				var Res = TakeTestReqDoRes[this.Dor.ReqName];											
				TakeTestViewRender.SaveTestPaperQn();
			}
		);
		this.vTakeTestPage.Init();
		this.mdQnSaveDo.Init();
		TakeTestReqRes.vTakeTestPage.Dor.fReqDo();
	};
};var TakeTestViewRender = new function(){	
	this.vTakeTestPage = new function(){
		this.Res = function(Res){			
			if(Res.mdUserTestTakingPaper !=null){
				var TTT = Res.mdUserTestTakingPaper;
				for(var i=0; i < TTT.length; i++){	
					TTT[i].bkup_intro_text = TTT[i].intro_text;
					TTT[i].bkup_has_changed = false;					
					TTT[i].time_limit = 0;
				}
			}
			this.PreparePaper(Res);
			this.Out(Res);
		};this.Out = function(Res){						
			var strTakeTestPageTitle = Mustache.render(Res.vTakeTestPageTitle, {'quiz': Res.mdUserTestTakingPaper} ); 				
			$("#myTitle").html(strTakeTestPageTitle);	  		
		
			TakeTestViewRender.vTakeTestPage.OutInit();
			$("#divPaperList").html(Mustache.render(Res.vTestPaperNum, {'TestPapers':Res.mdTestPapers}));
			//
			$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
		};
		this.PreparePaper = function(Res){	
			Res.IsOnSave = false;
			var fnIsActive = function(){return this.qno_a == TakeTestReqDoRes.vTakeTestPage.PagerIndex;}
			//
			var fnIsChanged = function(){return TakeTestReqDoRes.vTakeTestPage.Qs[this.qno_a-1].qn_bkup.edit_qn_changed;}
			//
			var fnIsAnswer = function(){return parseInt(TakeTestReqDoRes.vTakeTestPage.Qs[this.Qno-1].option_top) == parseInt(this.id);}						
			var fnNextLineOffSet = function(){return TakeTestReqDoRes.vTakeTestPage.OptNextLineOffSet;} 
			var fnIsNextLine = function(){return this.Sno%this.NextLineOffSet()==0;} ;
			var fnOptCount = function(){return TakeTestReqDoRes.vTakeTestPage.Qs[this.Qno-1].options.length;}
			var fnCellWidth = function(){return parseInt(100/QnOpt.NextLineOffSet());} ;
			var fnLetter = function(){return String.fromCharCode(65+this.Sno-1);};
			//
			var fnOptIsChanged = function(){var Opt = TakeTestReqDoRes.vTakeTestPage.Qs[this.Qno-1].qn_bkup.options[this.Sno-1];
						return Opt.edit_opt_changed || Opt.edit_optans_changed;}
			//
			var fnBkUpIsAnswer = function(){return parseInt(TakeTestReqDoRes.vTakeTestPage.Qs[this.Qno-1].qn_bkup.option_top) == parseInt(this.id);};
			//
			Res.Qs = [];
			Res.PagerIndex = 1;
			Res.SnapIs = false;
			Res.QStarted = false;
			Res.QnViewOption = 1;
			Res.QuizCompOpt = 2;
			Res.OptNextLineOffSet = 5;
			for(var I=0; I < Res.mdQuestion.length; I++){
				var Qn = Res.mdQuestion[I];
				Qn.qno_a = I + 1;
				Qn.IsPagerLine = Qn.qno_a %5 == 0;				
				//
				console.log(Qn);console.log(Qn.options);
				try{ Qn.options = JSON.parse(Qn.options); } catch(err){ console.log({'err':err,'Qn':Qn,'QnOpt':Qn.options}); }
				//
				Qn.qn_bkup = JSON.parse(JSON.stringify(Qn));
				Qn.qn_bkup.edit_qn_changed = false;
				if(Qn.question_text!=null)Qn.question_text = gfMgr.HtmlMinify(Qn.question_text);				
				if(Qn.question_text != Qn.qn_bkup.question_text) Qn.qn_bkup.edit_qn_changed = true;				
				//
				Qn.IsActive  = fnIsActive;
				//
				Qn.IsChanged = fnIsChanged;
				if(Qn.options != null)
				for(var J = 0; J < Qn.options.length; J++){
					var QnOpt = Qn.options[J];
					QnOpt.Sno = J + 1;					
					QnOpt.Qno = I + 1;
					//
					QnOpt.Letter=fnLetter;					
					QnOpt.IsAnswer =  fnIsAnswer;					
					QnOpt.NextLineOffSet = fnNextLineOffSet;
					QnOpt.IsNextLine = fnIsNextLine ;
					QnOpt.OptCount =  fnOptCount;
					QnOpt.CellWidth = fnCellWidth;
					//
					QnOpt.IsOptChanged=fnOptIsChanged;
					//
					Qn.qn_bkup.options[J].edit_opt_changed = false;
					Qn.qn_bkup.options[J].edit_optans_changed = false;
					Qn.qn_bkup.options[J].Sno = QnOpt.Sno;
					Qn.qn_bkup.options[J].Qno = QnOpt.Qno;
					Qn.qn_bkup.options[J].IsAnswer = fnBkUpIsAnswer;					
				}								
				//
				Res.Qs.push(Qn);
				Qn.qno_l = I + 1;
			}
			for(var I = 0; I < Res.mdTestPapers.length; I++){
				var Ppr = Res.mdTestPapers[I];
				Ppr.qno_a = I + 1;
				Ppr.IsPagerLine =  (Ppr.qno_a % 4 == 0);
			}
		};
		this.OutQnNum = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			$("#myQMatrix").html(Mustache.render(
				Res.vTakeTestQnNum, 
				{Qs:Res.Qs}
			));
		};this.OutQnNumDiv = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			if(Res.SnapIs==true) return;
			Res.SnapIs = true;	
			$("#testPagers").html(Res.vTakeTestQnNumDiv);
		};this.OutInstruction = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			var TP = Res.mdUserTestTakingPaper[0];
			
			if(Res.QuizCompOpt != 1) return;
			var vOpt=TakeTestReqDoRes.vTakeTestPage.QnViewOption;
			$('#idQnTitle').html('Instruction');
			var strTakeTestPageInstruction = Mustache.render(Res.vTakeTestPageInstruction, {'quiz': Res.mdUserTestTakingPaper});
			$('#pageContent').html(strTakeTestPageInstruction);						
			
			CKEDITOR.instances.idQn.setData(Res.mdUserTestTakingPaper[0].intro_text);	
			$("#QnEditOptions").html(Mustache.render(Res.vTakeTestPageQnEditOptions, {'quiz': Res.mdUserTestTakingPaper}));		
			$('#QnSimple').css('display',vOpt==1||vOpt==2?"block":"none")
			$('#pageEditContent').css('display',vOpt == 3?"block":"none")			
			
			$('#idQnDiv').css('border',TP.bkup_has_changed?'1px solid yellow':'0px solid yellow');
		};this.OutQn = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			if(Res.QuizCompOpt != 2) return;
			var vOpt=TakeTestReqDoRes.vTakeTestPage.QnViewOption;
			var vIdx = Res.PagerIndex; //QuestionIndex;
			var vq = Res.Qs[vIdx-1];

			if(vq == null) return;			
			vq.IsNotVisited = false;
			$('#idQnTitle').html('Question ' + vIdx);
			$("#pageContent").html(Mustache.render(Res.vTakeTestPageQn, {question:vq}));
			CKEDITOR.instances.idQn.setData(vq.question_text);	
			$("#QnEditOptions").html(Mustache.render(Res.vTakeTestPageQnEditOptions, {question:vq}));		
			
			
			$('#QnSimple').css('display',vOpt==1?"table":"none")
			$('#QnInTest').css('display',vOpt == 2?"table":"none")
			$('#pageEditContent').css('display',vOpt == 3?"block":"none")
			$('#idQnDiv').css('border',vq.IsChanged()?'1px solid yellow':'0px solid yellow');			
			
			TakeTestViewRender.vTakeTestPage.OutQnNum();
		}; this.OutInit = function(){			
			TakeTestViewRender.vTakeTestPage.OutQnNumDiv();
			TakeTestViewRender.vTakeTestPage.OutQnNum();
			TakeTestViewRender.vTakeTestPage.OutSwithQn();
		};  this.NextToInstruction = function(){			
			TakeTestViewRender.vTakeTestPage.OutSwithQn();
			var vIdx = Res.PagerIndex; //QuestionIndex;
			var vq = Res.Qs[vIdx-1];
			var strTakeTestPageInstruction = Mustache.render(Res.vTakeTestPageInstruction, {'quiz': Res.mdUserTestTakingPaper});
			$('#pageContent').html(strTakeTestPageInstruction);						
		};this.ClickInstruction = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			Res.QuizCompOpt = Res.QuizCompOpt == 1 ? 2 : 1;			
			TakeTestViewRender.vTakeTestPage.OutSwithQn();
		};this.OutViewQn = function(ViewNum){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			TakeTestReqDoRes.vTakeTestPage.QnViewOption = ViewNum;
			TakeTestViewRender.vTakeTestPage.OutSwithQn();
		};this.OutViewServiceQn = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			var vIdx = Res.PagerIndex;
			var vq = Res.Qs[vIdx-1];
			$("#pageContent").html(Mustache.render(Res.vTakeTestPageQnService, {question:vq}));
		};this.OutSwithQn = function(ViewNum){
			var Res = TakeTestReqDoRes.vTakeTestPage;			
			if(Res.QuizCompOpt == 1)
				TakeTestViewRender.vTakeTestPage.OutInstruction();
			else if(Res.QuizCompOpt == 2)
				TakeTestViewRender.OutQnAll();	
				//TakeTestViewRender.vTakeTestPage.OutQn();	
			
			
			if(Res.QuizCompOpt == 1)
				$('#idInstructionAction').addClass('pgrBtAns');
			else
				$('#idInstructionAction').removeClass('pgrBtAns');			
			$('#idAllQnViewAction').removeClass('pgrBtAns');
			$('#idSaveAllAction').removeClass('pgrBtAns');
		};this.OutViewQnOpt = function(ViewNum){
			TakeTestReqDoRes.vTakeTestPage.OptNextLineOffSet = ViewNum; 
			TakeTestViewRender.vTakeTestPage.OutSwithQn();
		};this.UpdateQnToSave = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			if(Res.QuizCompOpt == 1) 
				TakeTestViewRender.vTakeTestPage.UpdateQnToSaveInstruction();
			else if(Res.QuizCompOpt == 2) 
				TakeTestViewRender.vTakeTestPage.UpdateQnToSaveQn();
		};this.UpdateQnToSaveInstruction = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			if(Res.QuizCompOpt != 1) return;			
			var TP = Res.mdUserTestTakingPaper[0];
			TP.bkup_has_changed = true;
			TP.intro_text = gfMgr.HtmlMinify(CKEDITOR.instances.idQn.getData());
			var vRule = $('#idRule').val();
			console.log(vRule);
			TP.rule = vRule;
			
			TakeTestViewRender.vTakeTestPage.OutSwithQn();
		};this.UpdateQnToSaveQn = function(){
			var Res = TakeTestReqDoRes.vTakeTestPage;
			if(Res.QuizCompOpt != 2) return;
			var vIdx = Res.PagerIndex; //QuestionIndex;
			var vq = Res.Qs[vIdx-1];
			vq.question_text = gfMgr.HtmlMinify(CKEDITOR.instances.idQn.getData());						
			if(vq.question_text != vq.qn_bkup.question_text) vq.qn_bkup.edit_qn_changed = true;				
			
			var corAnsOpt=-1;
			for(var J=0; J < vq.options.length;J++){
				var vopt = vq.options[J];				
				vopt.option = $('#idOpt' + vopt.id).val();
				vq.qn_bkup.options[J].edit_opt_changed = (vopt.option != vq.qn_bkup.options[J].option);
				//
				if($('#idOptIsAns' + vopt.id).prop("checked")==1) corAnsOpt = J;					
				
			}
			if(corAnsOpt!=-1){				
				vq.option_top = vq.options[corAnsOpt].id;				
				for(var J=0; J < vq.options.length;J++){
					vq.qn_bkup.options[J].edit_optans_changed = (vq.options[J].IsAnswer()!=vq.qn_bkup.options[J].IsAnswer());
				}
			}
			//console.log(vq);
			TakeTestViewRender.vTakeTestPage.OutSwithQn();
		};
	};
	this.Init=function(){
		
	};
	
	this.LoadQn=function(pQno){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		Res.QuizCompOpt = 2;
		Res.PagerIndex = pQno; // QuestionIndex=pQno;
		TakeTestViewRender.vTakeTestPage.OutSwithQn();
	};this.NextQn=function(pQno){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		if(Res.QuizCompOpt != 2) return;
		if(Res.PagerIndex == (Res.Qs.length+1)) return;		
		Res.PagerIndex++;
		TakeTestViewRender.vTakeTestPage.OutSwithQn();
	};this.PrevQn=function(pQno){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		if(Res.QuizCompOpt != 2) return;
		if(Res.PagerIndex == 1) return;		
		Res.PagerIndex--;
		TakeTestViewRender.vTakeTestPage.OutSwithQn();
	};this.LoadPaper=function(quiz_id){	
		window.location.href = "PageTestPaper.php?id=" + quiz_id;
	};this.OutQnAll=function(){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		if(Res.QuizCompOpt != 2) return;
		
		var vOpt=TakeTestReqDoRes.vTakeTestPage.QnViewOption;		
		var strTakeTestPageInstruction = Mustache.render(Res.vTakeTestPageInstruction, {'quiz': Res.mdUserTestTakingPaper});
		$("#pageContent").html(strTakeTestPageInstruction + Mustache.render(Res.vTakeTestPageQn, {question:Res.Qs}));		
		$('#QnSimple').css('display',vOpt==1 || vOpt>2?"table":"none");
		$('#QnInTest').css('display',vOpt == 2?"table":"none");
		$('#pageEditContent').css('display',"none")	
				
		$('#idAllQnViewAction').addClass('pgrBtAns');
	};this.SavePaperChangeLog=function(){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		var ChangeLogQn = [];		
		var QnToChange = null;
		var TP = Res.mdUserTestTakingPaper[0];		
		if(TP.bkup_has_changed){
			QnToChange = {'IsInstructionToSave':true}
			ChangeLogQn.push(QnToChange);
		}
		for(var I=0;I<Res.Qs.length;I++){			
			var Qn = Res.Qs[I];
			QnToChange = {'IsInstructionToSave' : false, 'QnIdx' : Qn.qno_a, 
						  'QnIsChanged' : false, 'OptIsChanged' : false}
			if(Qn.IsChanged()) 	QnToChange.QnIsChanged = true;
			for(var J=0;J<Qn.options.length;J++){
				var QnOpt = Qn.options[J];
				if(QnOpt.IsOptChanged()) QnToChange.OptIsChanged = true;
			}if(QnToChange.QnIsChanged || QnToChange.OptIsChanged) ChangeLogQn.push(QnToChange);
		}
		return ChangeLogQn;
	};this.SaveTestPaper=function(){	
		var Res = TakeTestReqDoRes.vTakeTestPage;
		Res.IsOnSave = true;
		Res.ChangeLogQn = TakeTestViewRender.SavePaperChangeLog();
		Res.QnScannedCount = 0;
		//console.log(Res.ChangeLogQn);
		
		$('#pageContent').html('Test Paper Qn / Options Changes - We Post To Database<br>');
		$('#pageEditContent').css('display',"none")
		TakeTestViewRender.SaveTestPaperQn();
	};this.SaveTestPaperQn=function(){
		var Res = TakeTestReqDoRes.vTakeTestPage;
		
		if(Res.QnScannedCount >= Res.ChangeLogQn.length){
			if(Res.ChangeLogQn.length>0){
				$('#pageContent').html($('#pageContent').html() + '<h2>Done Questions Posted</h2>');
				var fnRefreshPage = function(){
					if(TakeTestReqDoRes.vTakeTestPage.IsOnSave)	TakeTestViewRender.SaveTestPaperAfter();
				};
				$('#pageContent').html($('#pageContent').html() + '<h3>We are loading Questions from DataBase. Please show your patience.</h3>');
				$('#pageContent').html($('#pageContent').html() + '<p><a href="" style="color:blue;font-size:12pt;font-family:Lucida Console;" onclick="return TakeTestViewRender.SaveTestPaperAfter();">Load Qns from Database</p>');
				gfMgr.RunAfGivSec(fnRefreshPage,2*8);		
			}else{
				$('#pageContent').html($('#pageContent').html() + '<h2>No Questions changed to post into database</h2>');
			}
			return;
		}
		if(Res.ChangeLogQn[Res.QnScannedCount].IsInstructionToSave)
			this.SaveTestPaperInstruction();
		else
			this.SaveTPQnOnly();
		$('#idSaveAllAction').addClass('pgrBtAns');
	};this.SaveTPQnOnly = function(){
		var Res = TakeTestReqDoRes.vTakeTestPage;
		var I = Res.QnScannedCount;
		//alert(Res.ChangeLogQn[I].QnIdx);
		var Qn = Res.Qs[Res.ChangeLogQn[I].QnIdx-1];
		$('#idSaveAllAction').addClass('pgrBtAns');
		
		var QnSavePostData = {}
		
		$('#pageContent').html($('#pageContent').html() + '<br>Checking Question ' + Qn.qno_a +  '');
		QnSavePostData['IsInstructionToSave']=0;
		QnSavePostData['IsQnToSave'] = 0;
		QnSavePostData['QnTxt'] = '';
		if(Qn.IsChanged()) {
			$('#pageContent').html($('#pageContent').html() + '<br>Updating Question ' + 
				Qn.qno_a +  '<div style="color:silver;">' + Qn.question_text + '</div>');
			QnSavePostData['IsQnToSave'] = 1;
			QnSavePostData['QnTxt'] = Qn.question_text;
		}
		QnSavePostData['QnID'] = Qn.question_id;
		QnSavePostData['IsLastQn'] = ((Res.ChangeLogQn.length - 1) == I) ? 1 : 0;
		
		QnSavePostData['IsOptToSave'] = 0;
		QnSavePostData['OptID'] = [];
		QnSavePostData['OptAns'] = [];
		QnSavePostData['OptText'] = [];
		for(var J=0;J<Qn.options.length;J++){
			var QnOpt = Qn.options[J];
			if(QnOpt.IsOptChanged()){
				$('#pageContent').html($('#pageContent').html() + '<br>Updating Question ' + 
					Qn.qno_a +  ' Option ' + QnOpt.Letter() +  ' <br><span style="color:silver;">' +  
					QnOpt.option + (QnOpt.IsAnswer() ? ' (Answer)' : '') + '</span>');
				QnSavePostData['IsOptToSave'] = 1;
				QnSavePostData['OptID'].push(QnOpt.id);
				QnSavePostData['OptAns'].push(QnOpt.IsAnswer()?1:0);
				QnSavePostData['OptText'].push(QnOpt.option);
			}
		}
		
		QnSavePostData['OptID'] = JSON.stringify(QnSavePostData['OptID']);
		QnSavePostData['OptAns'] = JSON.stringify(QnSavePostData['OptAns']);
		QnSavePostData['OptText'] = JSON.stringify(QnSavePostData['OptText']);
		
		QnSavePostData['m'] = 'mdQnSaveDo';
		Res.QnScannedCount++;
		if(QnSavePostData['IsQnToSave']==1 || QnSavePostData['IsOptToSave']==1){
			TakeTestReqDoConfig.mdQnSaveDo.params = QnSavePostData;		
			TakeTestReqRes.mdQnSaveDo.Dor.fReqDo();
		}else
			TakeTestViewRender.SaveTestPaperQn();
	};this.SaveTestPaperInstruction=function(){
		var Res = TakeTestReqDoRes.vTakeTestPage;
		var TP = Res.mdUserTestTakingPaper[0];	

		$('#pageContent').html( $('#pageContent').html() + '<br>Updating Instruction of ' + TP.quiz_name);
		var QnSavePostData = {}
		QnSavePostData['IsInstructionToSave'] = 1;
		QnSavePostData['InstructionText'] = TP.intro_text;
		QnSavePostData['RuleText'] = TP.rule;
		console.log(TP.rule)
		QnSavePostData['IsLastQn'] = ((Res.ChangeLogQn.length - 1) == 0) ? 1 : 0;
		QnSavePostData['m'] = 'mdQnSaveDo';
		TP.bkup_has_changed = false;
		Res.QnScannedCount++;
		TakeTestReqDoConfig.mdQnSaveDo.params = QnSavePostData;		
		TakeTestReqRes.mdQnSaveDo.Dor.fReqDo();
	};this.SaveTestPaperAfter=function(){		
		var Res = TakeTestReqDoRes.vTakeTestPage;
		TakeTestReqDoRes.vTakeTestPage.IsOnSave = false;
		TakeTestReqDoRes.vTakeTestPage.mdUserTestTakingPaper = TakeTestReqDoRes.mdQnSaveDo.mdUserTestTakingPaper;
		TakeTestReqDoRes.vTakeTestPage.mdQuestion = TakeTestReqDoRes.mdQnSaveDo.mdQuestion;			
		TakeTestViewRender.vTakeTestPage.Res(Res);
		$('#idSaveAllAction').removeClass('pgrBtAns');
		return false;
	};
}
