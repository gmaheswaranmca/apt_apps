
<?php  
	if (!defined('DR')) define('DR', __DIR__.'/'); include_once(realpath(DR.'../pref.php'));
?>
<?php 
	if (!isset($_GET["assess_id"])){
		exit();
	}
	$assess_id = $_GET["assess_id"];
	//echo("xx $assess_id xx");
?>
<html>
<head>
		<title>APT Online Test</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	

		<link href="../static/css/cat.css" type="text/css" rel="stylesheet">
		<script language ="javascript" src="../static/js/jquery/jquery.min.js"></script>
		<script language ="javascript" src="../static/js/mustache/mustache.js"></script>
		<script language ="javascript" src="../static/js/PageBase.js"></script>
				
		<script language ="javascript" src="form/conductCodeTest/conductTest.js<?php echo(AptTime);?>"></script>
		
		<script language ="javascript">
			var JsController = new ConductTestJsController('<?php echo($assess_id); ?>');
			JsController.OnLoad();
			//window.onscroll = function() {PageHeaderFix()};
		</script>
		
		<link rel="stylesheet" href="../static/js/codemirror/codemirror.css">		
			<script src="../static/js/codemirror/codemirror.js"></script>
		
			<link rel="stylesheet" href="../static/js/codemirror/theme/eclipse.css">
		
			<script src="../static/js/codemirror/clike.js"></script>
		
			<script src="../static/js/codemirror/matchbrackets.js"></script>
		
			<link rel="stylesheet" href="../static/js/codemirror/show-hint.css">
			<script src="../static/js/codemirror/show-hint.js"></script>			
		
			<link rel="stylesheet" href="../static/js/codemirror/fullscreen.css">
			<script src="../static/js/codemirror/fullscreen.js"></script>
		<style>.CodeMirror {border: 1px solid #4CAF50; font-size:13px; border-radius: 2px;}</style>	
</head>
<body>
	<div style="overflow:auto" class="top_banner" id="topping">
		<div class="top_ins"><img src="../static/img/comp/APEC-LOGO.png">
		</div>
		<div class="top_header brand">
			<?php include("BrandOut.php")?>				
		</div>	
		<div class="top_comp"><img src="../static/img/comp/logo.png">
			<div style="width:100%">
				<table width="100%">
				<tr>
					<td class="tmrBox" align="center"><div style="width:100%" id="myRemainingTime">&nbsp;&nbsp;&nbsp;&nbsp;</div></td>
				</tr>
				</table>
			</div>
		</div>
	</div>
	<div style="overflow:auto" class="heading_view" id="myHeader">
		<div class="heading_data" id="myTitle">Student Test Platform</div>
		<div class="heading_logout" style="display:table;">
		<div style="display:table-cell;text-align:right; vertical-align: middle; color: white; font-family: Arial; font-weight: bold; font-size: 12pt;"><span class='qcountdesc'>Welcome </span><span id="myUserName">-</span><span class='qcountdesc'>(</span><span id="myFullName" class='qcountdesc'>-</span><span class='qcountdesc'>)! </span><span class='qcountsimple'>!</span></div>
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

	
	<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close" onclick="$('#myModal').css('display', 'none');">&times;</span>
    <p>Some text in the Modal..</p>
  </div>
</div>
</body>
</html>		 