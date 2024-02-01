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