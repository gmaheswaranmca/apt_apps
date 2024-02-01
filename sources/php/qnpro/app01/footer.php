</head>
<body  onbeforecopy = "return false"
    ondragstart = "return false" 
    onselectstart = "return false" 
    oncontextmenu = "return false" 
    onselect = "SupSel()" 
    oncopy = "SupSel()">
	<div id="PageBefore" style="color:white;width:99%;height:80%;border:1px solid silver;border-radius:100px;text-align:center;font-family:Arial;font-size:14pt;">
			<br><br><br>
			<img src="../static/img/comp/fav.png" width=100 height=100 align=center><br><br><br>
			Loading Online Test Platform...	
	</div>
	<div style="display:none;" id="PageAfter">
		<div style="overflow:auto" class="top_banner" id="topping">
			<div class="top_ins"><img src="../static/img/comp/APEC-LOGO.png"></div>
			<div class="top_header brand">
				<?php include("BrandOut.php")?>
						
			</div>
			<div class="top_comp"><div>&nbsp;</div>
				<div style="width:100%;padding-top:5px;">
					<table width="100%">
					<tr>
						<td class="tmrBox" align="center"><div style="width:100%" id="myRemainingTime">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
					</tr>
					</table>
				</div>
			</div>
		</div>
		<div style="overflow:auto;" class="heading_view" id="myHeader">
			<div class="heading_data" id="myTitle">Active Assignments</div>
			<div class="heading_logout" style="display:table;">
			<div style="display:table-cell;text-align:right; vertical-align: middle; color: white; font-family: Arial; font-weight: bold; font-size: 12pt;"><span>Welcome </span><span id="myUserName">-</span><span>(</span><span id="myFullName">-</span><span>)! </span></div>
			<div style="display:table-cell;"><a href="logout.php" border="1">Logout</a></div></div>
		</div>
		<div style="overflow:auto" class="main_view">
			<div class="main_menus">
				<div id="menuContent">
				</div>		
				<div id="testPagers" style="display:none;">
					
				</div>
			</div>
			<div class="main_data">
				<div id="pageContent">
				</div>
			</div>
		</div>
	</div>	
</body>
</html>		 