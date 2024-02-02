<?php  
	if (!defined('DR')) define('DR', __DIR__.'/'); include_once(realpath(DR.'../pref.php'));
?>
<html>
<head>
		<title>Apt Online Test</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<link rel="shortcut icon" href="../static/img/comp/fav.png" />
		<link href="../static/css/aptStyle.css<?php echo(AptTime);?>" type="text/css" rel="stylesheet">
		<script language ="javascript" src="../static/js/jquery/jquery.min.js<?php echo(AptTime);?>"></script>
		<script language ="javascript" src="../static/js/mustache/mustache.js<?php echo(AptTime);?>"></script>
		<script language ="javascript" src="../static/js/lib/pouchdb.min.js<?php echo(AptTime);?>"></script>
		<script language ="javascript" src="../static/js/lib/js.cookie.min.js<?php echo(AptTime);?>"></script>
		
		
		<script language ="javascript" src="../static/js/PageBase.js<?php echo(AptTime);?>"></script>
<style type="text/css">
.compe{
	padding: 5px;	
	border:1px solid #f4f5f7;border-radius:20px;	
	background: #f4f5f7!important; color:#c44844!important; 
	font-family: tahoma; font-size:14pt;font-weight:bold; 	
}
</style>