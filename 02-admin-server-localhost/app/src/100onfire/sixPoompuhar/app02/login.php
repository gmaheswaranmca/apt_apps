<?php 
	include("header.php");
?>
<script language ="javascript" src="form/conductTest/login.js<?php echo(AptTime);?>"></script>
<script language ="javascript">
	var JsController = new LoginJsController();	JsController.OnLoad();
</script>
<style type="text/css">
	body{background: #ADA996; background: -webkit-radial-gradient(#ADA996, #EAEAEA);  background: radial-gradient(#bdc3c7, #2c3e50);}
	.clsPageBefore{color:white;width:99%;height:80%;border:1px solid silver;border-radius:100px;text-align:center;font-family:Arial;font-size:14pt;}
	.clsPageAfter{display:none;}
	.mainPage{height: 100%;  display: flex;  align-items: center;  justify-content: center;}
</style>
</head>	
<body>
    <!-- div style="font-family:Arial;font-size:18pt;background-color:blue; color:white;text-align:center; padding:150px 0px 150px 0px; position:absolute; top:0px;left:0px;width:100%;z-index:10;">
        Only For today test<br>
        Friday, 14-May-2015<br>
        Your test link will be as follows:<br>
    <p style="border:1px solid orange;border-randius:10px;padding:20px 0px 20px 0px">
    <a href="http://aptexam.aptonlinetest.co.in/king" style="font-size:16pt;">Click here to attend Test dated Friday, 14-May-2015</a>
    </p>    
    <br>
    Or Copy the link:
    <br>
    <span style="color:silver;">http://aptexam.aptonlinetest.co.in/king</span>
    
    </div -->	
	<div id="PageBefore" class="clsPageBefore">
		<br><br><br>
		<img src="../static/img/comp/fav.png" width=100 height=100 align=center><br><br><br>
		Loading Online Test Platform...	
	</div>	
	<div id="PageAfter" class="clsPageAfter">
		<div class="mainPage">
			<div>
				<div id="pageContent"></div>
			</div>
		</div>
	</div>
</body>
</html>		 