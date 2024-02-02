<?php 	
	@session_start();
	if (!isset($_GET["id"]))
		header("location:ActiveTestPaper.php");
	$_SESSION['quiz_id'] = $_GET["id"];
	define('PageName','Test Paper');
	include("header.php")
?>
	<script language ="javascript" src="TestPaper/TakeTestReq.js<?php echo(AptTime);?>"></script>	
<?php include("footer.php")?>
			<div id="pageEditContent" sty1le="display:none;">				
				<div id="idQnDiv" style="border:1px solid yellow;">					
					<span id="idQnTitle">Question</span>: <div  class="pgrBt pgrBtAns" 
					onclick="TakeTestViewRender.vTakeTestPage.UpdateQnToSave();" style="background-repeat:center center;">&#9745;</div><br>
					<textarea id="idQn"></textarea> <br>
				</div>
				<div id="QnEditOptions">Welcome
				</div>
				
			</div>
		</div>
	</div>
</div>	


<script type="text/javascript">
	window.CKEDITOR_BASEPATH='../ckeditor/';
</script>
<script type="text/javascript" src="../ckeditor/ckeditor.js?t=B8DJ5M3"></script>
<script type="text/javascript">
	CKEDITOR.replace('idQn',{
		"toolbar":[["Source","-","Bold","Italic","Underline","Strike"],["Image","Link","Unlink","Anchor"]],
		'width':'100%',
		'height':'200px'
	});	
	CKEDITOR.appendTo( 'idQn',{ removePlugins: 'htmlwriter' }); 
</script>
</body>
</html>	

