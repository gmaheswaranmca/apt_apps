<?php
	$vIsSideBar = True;
	if (defined('IsSideBar')) $vIsSideBar = IsSideBar;
?>
</head>
<body onbeforecopy = "return false"
    ondragstart = "return false" 
    onselectstart = "return false" 
    oncontextmenu = "return false" 
    onselect = "SupSel()" 
    oncopy = "SupSel()">
	<div id="PageBefore" style="color:white;width:99%;height:80%;border:1px solid silver;border-radius:100px;text-align:center;font-family:Arial;font-size:14pt;">
			<br><br><br>
			<img src="../static/img/comp/fav.png" width=100 height=100 align=center><br>
			<div>
				<div style="overflow:auto;background-color:#F4F5F7;"  >
					<table class="aptTable">
						<tr>
							<td class="data" align="center" style="font-size:18pt;font-family:\'Arial Narrow\';" id="PageBefExtraText">
								Loading Online Test Platform...
								<br>Please wait for few seconds.
								<br>We are loading the application.
							</td>
						</tr>
					</table>
				</div>				
				<br><br><br><br><br><br>
				<span class="aptLogout" style="float:none;"><a href="logout.php" border="1">Logout</a></span>			
			</div>
			 
	</div>
	<div style="display:none;" id="PageAfter">
		<div class="AptStTopLine" >			
				<img src="../static/img/comp/APEC-LOGO.png">
				<div class="AptStTopLineBrand AptStMobile" >
					<span  class="AptStBrandName">Online Test Platform</span>
					<span class="AptStCompName">Apt Training Resources</span>
				</div>			
				<div  class="AptStTimer" id="myRemainingTime">&nbsp;&nbsp;&nbsp;&nbsp;</div>			
		</div>
		<div class="AptStTopicLine" id="myHeader">						
			<span class="aptTitle" id="myTitle">Active Assignments</span>
			<span class="aptLogout" id="idLogout"><a href="logout.php" border="1">Logout</a></span> 
			<span class="aptLogout" id="idFinish" style="display:none;"><a href="#" border="1"  onclick="return JsController.apdata.action.FinishTest();">Finish <strong style="color:black;">&#x2714;</strong></a></span>
			<span class="aptUser"><span>Welcome </span><span id="myUserName">-</span><span>(</span><span id="myFullName">-</span><span>)! </span></span>
		</div> 
