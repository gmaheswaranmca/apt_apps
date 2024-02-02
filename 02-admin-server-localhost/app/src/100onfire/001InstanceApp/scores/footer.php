</head>
<body><!--  onbeforecopy = "return false"
    ondragstart = "return false" 
    onselectstart = "return false" 
    oncontextmenu = "return false" 
    onselect = "SupSel()" 
    oncopy = "SupSel()"-->
<div id="PageBefore" style="color:white;width:99%;height:80%;border:1px solid silver;border-radius:100px;text-align:center;font-family:Arial;font-size:14pt;">
		<br><br><br>
		<img src="../static/img/comp/fav.png" width=100 height=100 align=center><br><br><br>
		Loading Online Test Platform...
	
</div>
<div style="display:none;" id="PageAfter">
	<div style="overflow:auto;padding:0;margin:0;" class="heading_view" id="myHeader">
		<a style="color:white;float:left;" href="index.php">Home</a> <div class="heading_data" id="myTitle"><?php echo(PageName); ?></div>		
	</div>
	<div style="overflow:auto" class="main_view">
		<div class="main_menus">
			<div id="testPagers">				
			</div>
			<div align="center" id="divPaperList" class="qst_main_table_li">
			</div>
		</div>
		<div class="main_data">
			<div id="pageContent">
			</div>
		
	 