<?php 
	include("header.php");
?>
		<script language ="javascript" src="form/conductTest/login.js"></script>
		<script language ="javascript">
			var JsController = new LoginJsController();
			JsController.OnLoad();
		</script>
</head>
<style type="text/css">
body{
background: #ADA996;  /* fallback for old browsers */
background: -webkit-radial-gradient(#ADA996, #EAEAEA);  /* Chrome 10-25, Safari 5.1-6 */
background: radial-gradient(#bdc3c7, #2c3e50);/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style>
<body>	
	<div id="PageBefore" style="color:white;width:99%;height:80%;border:1px solid silver;border-radius:100px;text-align:center;font-family:Arial;font-size:14pt;">
			<br><br><br>
			<img src="../static/img/comp/fav.png" width=100 height=100 align=center><br><br><br>
			Loading Online Test Platform...	
	</div>
	<div style="display:none;" id="PageAfter">
		<div style="height: 100%;  display: flex;  align-items: center;  justify-content: center;">
			<div>
				<div id="pageContent">
				</div>
			</div>
		</div>
	</div>
</body>
</html>		 