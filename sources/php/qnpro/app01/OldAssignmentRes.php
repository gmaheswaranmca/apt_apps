<?php 
	include("header.php");
?>	
		<script language ="javascript" src="form/conductTest/OldAssignment.js"></script>
		<script language ="javascript">
			var JsController = new OldAssignmentJsController();
			JsController.OnLoad();
			window.onscroll = function() {PageHeaderFix()};
		</script>
<?php include("footer.php")?>