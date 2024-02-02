<?php 
	include_once('header.php');
?>
	<script language ="javascript" src="form/cp/CpReq.js"></script>
</head>
<body>
<div class="container-responsive">
	<header class="navbar navbar-expand navbar-info bg-info p-0">
		<div class="label  w-50 h5">EduMax</div>
		<div  class="label w-50 text-right" id="DivCp">			
			<div  class="label" id="DivCp">			
				<?php include_once('form/cp/ViewCp.php'); ?>			
			</div>
		</div>
	</header>
	<main>			
		<div id="DivAppMonitor">
			
		</div>
	</main>		
</div>	
<div class="container">
<div id="DivCpModalHis" style="color:black;" ></div>
<div id="DivViewEye" style="color:black;"></div>
</div>
</body>
</html>