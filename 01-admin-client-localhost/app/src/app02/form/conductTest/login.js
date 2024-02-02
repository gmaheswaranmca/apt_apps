function LoginJsController(){	
	this.pgHtml = "";

	this.OnLoad=function(){	
		$('#PageBefore').css('display','block');$('#PageAfter').css('display','none');				
		this.QPgHtml();
		
	};	
	this.QPgHtml=function()	{
		$.post("form/conductTest/v2mLogin.php",  { m: "html"}, 
			function(pData){				
				if(pData.r.IsLoggedIn == "0")
					$("#pageContent").html(pData.r.html); 
				else{
					window.location.href = "ActiveAssignmentRes.php";
					return;
				}
				$('#PageBefore').css('display','none');$('#PageAfter').css('display','block');
			},"json"
		);
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
			    console.log(pData);
				if(pData.r_code!=1){
					alert(pData.r_msg);
				}
				else{
					window.location.href = "ActiveAssignmentRes.php";
				}
				
			}, "json"
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

