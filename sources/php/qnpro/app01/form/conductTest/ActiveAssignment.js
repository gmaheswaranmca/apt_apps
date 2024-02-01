 function ActiveAssignmentJsController(){
	this.pgHtml = "";
	this.menuHtml = "";
    this.pgQueryRes = {};	
	this.OnLoad=function(){		
		$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');
		this.QPgHtml();
	};
	this.QPgHtml=function()	// QPgHtml -> QListData -> ParsePgHtmlWListData
	{
		$.post("form/conductTest/v2mActiveAssignment.php",  { m: "html"}, 
			function(pData){
				if(pData.r.IsLoggedIn == "0"){
					window.location.href = "login.php";
					return;
				}
				$("#myUserName").html(pData.r.user_name);					
				var v_r = pData.r.mdassignment;		
				if(v_r!=null)
					for(var i=0; i < v_r.length; i++){
						v_r[i].user_quiz_status = parseInt(v_r[i].user_quiz_status);		
						v_r[i].pass_score = parseInt(v_r[i].pass_score);
						v_r[i].quiz_time = parseInt(v_r[i].quiz_time);
						v_r[i].IsQuizToStart = v_r[i].user_quiz_status <= 1;
						v_r[i].IsQuizToContinue = v_r[i].user_quiz_status == 1;
						v_r[i].IsTimedOut = v_r[i].user_quiz_status == 3;
					}
				var rendered = Mustache.render(pData.r.vhtml,{assignment: v_r});
				$("#pageContent").html(rendered);
				
				v_r = pData.r.mdmenu;
				$("#myFullName").html(v_r[0].full_name);
				//alert(v_r[0].full_name);
				FixMenus(v_r,2);			
				var rendered = Mustache.render(pData.r.vmenu,{menus: v_r});
				$("#menuContent").html(rendered);					
				$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
			},"json"
		);
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
			}, "json"
		);
	};
	this.RedirectTo=function(){
		window.location.href = "login.php";
	};
	
	this.QListData=function(){
		$.post("form/conductTest/v2mActiveAssignment.php",  { m: "dao_list"},
			function(queryData){
				JsController.pgQueryRes = queryData;
				JsController.ParsePgHtmlWListData();
			}, "json"
		);	
	};
	this.user_id = "";
	this.user_name = "";
	this.ParsePgHtmlWListData=function(){
		this.user_id = JsController.pgQueryRes.r.user_id;
		this.user_name = JsController.pgQueryRes.r.user;
		$("#myUserName").html(this.user_name);
		//
		var v_r = JsController.pgQueryRes.r.assignment;			
		for(var i=0; i < v_r.length; i++){
			v_r[i].user_quiz_status = parseInt(v_r[i].user_quiz_status);		
			v_r[i].pass_score = parseInt(v_r[i].pass_score);
			v_r[i].quiz_time = parseInt(v_r[i].quiz_time);
			v_r[i].IsQuizToStart = v_r[i].user_quiz_status <= 1;
			v_r[i].IsQuizToContinue = v_r[i].user_quiz_status == 1;
			v_r[i].IsTimedOut = v_r[i].user_quiz_status == 3;
		}
		var rendered = Mustache.render(JsController.pgHtml,{assignment: v_r});
		$("#pageContent").html(rendered);
	}
	this.QMenuHtml=function()	// QMenuHtml -> QMenuData 
	{
		$.post("form/conductTest/v2mActiveAssignment.php",  { m: "menu_htm"}, 
			function(htmlData){
				JsController.menuHtml = htmlData;
				JsController.QMenuData();
			}
		);
	};
	this.QMenuData=function(){
		$.post("form/conductTest/v2mActiveAssignment.php",  { m: "daomodule_get"},
			function(queryData){				
				var v_r = queryData.r;
				FixMenus(v_r,2);			
				var rendered = Mustache.render(JsController.menuHtml,{menus: v_r});
				$("#menuContent").html(rendered);
				
				
				$("#myFullName").html(v_r[0].full_name);
			}, "json"
		);	
	};
};
