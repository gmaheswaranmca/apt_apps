function LoginJsController(){	
	this.pgHtml = "";

	this.OnLoad=function(){		
		this.QIsLoggedIn();		
	};
	
	this.QPgHtml=function()	
	{
		$.post("form/conductTest/v2mLogin.php",  { m: "html"}, 
			function(htmlData){				
				JsController.pgHtml = htmlData;
				$("#pageContent").html(htmlData);				
			}
		);
	};
	this.QIsLoggedIn=function()
	{	
		$.post("form/conductTest/v2mLogin.php",  { m: "is_logged_in"}, 
			function(pData){				
				if(pData.r_code==2){
					JsController.QPgHtml();
				}else if(pData.r_code==1){
					JsController.RedirectTo();
				}
			}
		);
	};
	this.RedirectTo=function(){
		window.location.href = "ActiveAssignmentRes.php";
	};
	
	this.DoLoginIn=function()
	{	
		if($("#uxUserName").val() == ""){
			$("#uxUserName").focus();
			alert("Please Enter User Name");			
			return;
		}
		if($("#uxPassword").val() == ""){
			$("#uxPassword").focus();
			alert("Please Enter Password");			
			return;
		}
		
		
		$.post("form/conductTest/v2mLogin.php",  { m: "do_login", txtLogin:$("#uxUserName").val(), txtPass:$("#uxPassword").val(),  }, 
			function(pData){				
				if(pData.r_code!=1){
					alert(pData.r_msg);
				}
				else{
					JsController.RedirectTo();
				}
				
			}
		);
	};
	
	this.MoveToPassword=function() {
		if (event.keyCode == 13) {
			$("#uxPassword").focus();
		}
	};
	this.FireLogin=function() {
		if (event.keyCode == 13) {
			JsController.DoLoginIn();
		}
	};
};

