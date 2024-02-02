<?php 	
	@session_start();
	if(!isset($_SESSION['txtLogin']))	header("location:login.php");
	if (!isset($_GET["assess_id"])){
		exit();
	}
	$assess_id = $_GET["assess_id"];
	$_SESSION['asg_id'] = $assess_id;
	//if (!isset($_GET["assignment_id"]))	header("location:ActiveAssignmentRes.php");
	//$assignment_id = $_GET["assignment_id"];$_SESSION['assignment_id']=$assignment_id;
	include("header.php");	
	
?>
<script language ="javascript" src="../static/js/bootstrap/bootstrap-4.min.js"></script>
<link rel="stylesheet" href="../static/js/bootstrap/bootstrap-4.min.css">
<script language ="javascript" src="form/conductCodeTest/conductTest.js<?php echo(AptTime);?>"></script>
<script language ="javascript">
	var JsController = new ConductTestJsController('<?php echo($assess_id); ?>');
	JsController.OnLoad();
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
<?php include("footer.php")?>
		<div style="overflow:auto" class="AptMain">			
			<div class="AptContent">
				<div id="pageContent">
				</div>
			</div>
			<div class="AptSideBar">
				<div id="testPagers" style="display:none;">						
				</div>
			</div>
		</div>
	</div>	


		<!-- The Modal -->
<div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content">
  <span class="close" style="cursor:hand;" onclick="$('#myModal').css('display', 'none');">&times;</span>
  <p>Some text in the Modal..</p>
</div>
</div>
</body>
</html>	
