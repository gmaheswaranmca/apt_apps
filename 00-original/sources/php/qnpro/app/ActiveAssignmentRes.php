<?php 
	include("header.php");
?>		
		<script language ="javascript" src="form/conductTest/ActiveAssignment.js"></script>
		<script language ="javascript">
			var JsController = new ActiveAssignmentJsController();
			JsController.OnLoad();
			window.onscroll = function() {PageHeaderFix()};
		</script>
<?php include("footer.php")?>