<?php 	
	@session_start();
	if (!isset($_GET["id"]))
		header("location:ActiveTestPaper.php");
	$_SESSION['assignment_id'] = $_GET["id"];
	include("header.php")
?>
	<script language ="javascript">
		    <?php include("../app/form/conductTest/SuffleRule.js")?>
	</script>
	<script language ="javascript" src="TestPaper/TakeTestReq.js"></script>
<?php include("footer.php")?>

