<?php 	
	@session_start();
	if(!isset($_SESSION['txtLogin']))	header("location:login.php");
	if (!isset($_GET["assignment_id"]))	header("location:ActiveAssignmentRes.php");
	$assignment_id = $_GET["assignment_id"];$_SESSION['assignment_id']=$assignment_id;
	include("header.php");	
	
?>
<script language ="javascript" src="form/conductTest/conductTestMisc.js<?php echo(AptTime);?>"></script>
<script language ="javascript"><?php include("form/conductTest/SuffleRule.js")?></script>
<script language ="javascript">
	var JsController = new ConductTestJsController('<?php echo($assignment_id); ?>');JsController.OnLoad();
</script>
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
</body>
</html>		  