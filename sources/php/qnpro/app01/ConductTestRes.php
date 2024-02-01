<?php 	
	@session_start();
	if(!isset($_SESSION['txtLogin']))	header("location:login.php");
	if (!isset($_GET["assignment_id"]))	exit();	
	$assignment_id = $_GET["assignment_id"];
	$_SESSION['assignment_id']=$assignment_id;
	include("header.php")
	
?>
		
		<script language ="javascript" src="form/conductTest/conductTest.js"></script>
		<script language ="javascript" src="form/conductTest/conductTestMisc.js"></script>
		<script language ="javascript">
		    <?php include("form/conductTest/SuffleRule.js")?>
		</script>
		<script language ="javascript">
			var JsController = new ConductTestJsController('<?php echo($assignment_id); ?>');
			JsController.OnLoad();
			//window.onscroll = function() {PageHeaderFix()};
		</script>

<?php include("footer.php")?>

