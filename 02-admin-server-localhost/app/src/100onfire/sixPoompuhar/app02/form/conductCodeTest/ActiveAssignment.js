 function ActiveAssignmentJsController(){
	this.pgHtml = "";
	this.menuHtml = "";
    this.pgQueryRes = {};	
	this.OnLoad=function(){			
		this.QIsLoggedIn();		
	};
	this.QIsLoggedIn=function()
	{	
		$.post("form/conductTest/v2mLogin.php",  { m: "is_logged_in"}, 
			function(pData){				
				if(pData.r_code==2){
					JsController.RedirectTo();
				}else if(pData.r_code==1){
					JsController.QPgHtml();
				}
			}
		);
	};
	this.RedirectTo=function(){
		window.location.href = "login.php";
	};
	this.QPgHtml=function()	// QPgHtml -> QListData -> ParsePgHtmlWListData
	{
		$.post("form/conductCodeTest/v2mActiveAssignment.php",  { m: "html"}, 
			function(htmlData){
				JsController.pgHtml = htmlData;
				JsController.QListData();
				JsController.QMenuHtml()
			}
		);
	};
	this.QListData=function(){
		$.post("form/conductCodeTest/v2mActiveAssignment.php",  { m: "dao_list"},
			function(queryData){
				JsController.pgQueryRes = queryData;
				JsController.ParsePgHtmlWListData();
			}
		);	
	};
	this.user_id = "";
	this.user_name = "";
	this.ParsePgHtmlWListData=function(){
		
		this.user_id = JsController.pgQueryRes.r.user_id;
		this.user_name = JsController.pgQueryRes.r.user;
		$("#myUserName").html(this.user_name);
		//
		
		
		var v_r = JsController.pgQueryRes.r.assessment;			
		for(var i=0; v_r!=null && i < v_r.length; i++){
			v_r[i].IsQuizToStart = v_r[i].user_ass_status <= 1;
			v_r[i].IsQuizToContinue = v_r[i].user_ass_status == 1;
			var vAdjDatTime = null;
			if(v_r[i].user_ass_status >= 1)
				vAdjDatTime = this.AdjustTime(v_r[i].db_now, v_r[i].ass_start_date, v_r[i].total_duration);
			v_r[i].AdjDatTime = vAdjDatTime;
				
		}
		var rendered = Mustache.render(JsController.pgHtml,{assess_list: v_r});
		$("#pageContent").html(rendered);
	}
	this.QMenuHtml=function()	// QMenuHtml -> QMenuData 
	{
		$.post("form/conductCodeTest/v2mActiveAssignment.php",  { m: "menu_htm"}, 
			function(htmlData){
				JsController.menuHtml = htmlData;
				JsController.QMenuData();
			}
		);
	};
	this.QMenuData=function(){
		$.post("form/conductCodeTest/v2mActiveAssignment.php",  { m: "daomodule_get"},
			function(queryData){				
				var v_r = queryData.r;
				FixMenus(v_r,2);			
				var rendered = Mustache.render(JsController.menuHtml,{menus: v_r});
				$("#menuContent").html(rendered);
				
				
				if(v_r!=null) $("#myFullName").html(v_r[0].full_name);
			}
		);	
	};
	this.AdjustTime =function(pdb_now, p_start_time, pTotalMins){
		var vDbStartTime = new Date(p_start_time);
		var vDbServerNow = new Date(pdb_now);
		
		var vSecsDbStartToNow = Math.abs(vDbServerNow.getTime() - vDbStartTime.getTime()) / 1000;
		
		var vCliNow = new Date();
		var vCliStartTime = new Date();
		vCliStartTime.setSeconds(vCliNow.getSeconds() - vSecsDbStartToNow);
		var vSecsCliStartToNow = Math.abs(vCliNow.getTime() - vCliStartTime.getTime()) / 1000;
		var vTotMins = parseInt(pTotalMins);
		var vTotSecs =  vTotMins * 60;
		var vMins = vTotMins - (vSecsCliStartToNow / 60);
		var vSecs = vSecsCliStartToNow % 60;
		vMins = parseInt(vMins);
		vSecs = parseInt(vSecs);
		var vRet = {dbStartTime:vDbStartTime, dbServerNow:vDbServerNow, 
					cliStartTime:vCliStartTime, cliNow:vCliNow,
					mins:vMins, secs:vSecs};
		return vRet;
	};
};
