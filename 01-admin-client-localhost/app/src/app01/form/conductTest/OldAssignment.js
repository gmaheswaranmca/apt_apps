 function OldAssignmentJsController(){
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
			}, "json"
		);
	};
	this.RedirectTo=function(){
		window.location.href = "login.php";
	};
	this.QPgHtml=function()	// QPgHtml -> QListData -> ParsePgHtmlWListData
	{
		$.post("form/conductTest/v2mOldAssignment.php",  { m: "html"}, 
			function(htmlData){
				JsController.pgHtml = htmlData;
				JsController.QListData();
				JsController.QMenuHtml()
			}
		);
	};
	this.QListData=function(){
		$.post("form/conductTest/v2mOldAssignment.php",  { m: "dao_list"},
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
		var rendered = Mustache.render(JsController.pgHtml,{assignment: v_r});
		$("#pageContent").html(rendered);
	}
	this.QMenuHtml=function()	// QMenuHtml -> QMenuData 
	{
		$.post("form/conductTest/v2mOldAssignment.php",  { m: "menu_htm"}, 
			function(htmlData){
				JsController.menuHtml = htmlData;
				JsController.QMenuData();
			}
		);
	};
	this.QMenuData=function(){
		$.post("form/conductTest/v2mOldAssignment.php",  { m: "daomodule_get"},
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
