<?php 	
	@session_start();	
	define('PageName','Edit Text');
	include("header.php")
?>
	<script language ="javascript" src="BridgeEditor/BridgeEditorRestClient.js<?php echo(AptTime);?>"></script>	
</head>
<body>
<div id="pageEditContent">				
	<div id="idEditorDiv" style="border:1px solid yellow;">										
		<textarea id="idEditor"></textarea> <br>
	</div>
	<div id="idEditorOptions">
		<button type="button" class="" 
			onclick="BridgeEditorRestClientProcessor.SaveEdited();">Save</button>
	</div>
				



<script type="text/javascript">
	window.CKEDITOR_BASEPATH='../ckeditor/';
</script>
<script type="text/javascript" src="../ckeditor/ckeditor.js?t=B8DJ5M3"></script>
<script type="text/javascript">
	CKEDITOR.replace('idEditor',{
		"toolbar":[["Source","-","Bold","Italic","Underline","Strike"],["Image","Link","Unlink","Anchor"]],
		'width':'100%',
		'height':'300px'
	});	
	CKEDITOR.appendTo( 'idEditor',{ removePlugins: 'htmlwriter' }); 
</script>
</body>
</html>	

