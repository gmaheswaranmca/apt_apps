<?php 
	@session_start();
	if(!isset($_SESSION['txtLogin']))	header("location:login.php");
	include("header.php");
?>		
<script language ="javascript" src="form/conductTest/ActiveAssignment.js<?php echo(AptTime);?>"></script>
<script language ="javascript">
var JsController = new ActiveAssignmentJsController();	JsController.OnLoad();
</script>
	<?php include("footer.php")?>
		<div class="AptMain">
			<div class="AptContentOnly">
				<div id="pageContent">
				</div>
			</div>
		</div>
	</div>	
</body>
</html>		 

