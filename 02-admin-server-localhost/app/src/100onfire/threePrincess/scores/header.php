<?php  
	@session_start();
	if (!defined('DR')) define('DR', __DIR__.'/'); include_once(realpath(DR.'../pref.php'));
	
	if(isset($_SESSION['link']))
		$link = '(' . $_SESSION['link'] . ')';
	else
		$link = '';	

?>
<html>
<head>
		<title>Apt Online Test<?php echo($link);?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<link rel="shortcut icon" href="../static/img/comp/fav.png" />
		
		<script language ="javascript" src="../static/js/jquery/jquery.min.js<?php echo(AptTime);?>"></script>
		<link href="../static/css/cat.css<?php echo(AptTime);?>" type="text/css" rel="stylesheet">		
		<script language ="javascript" src="../static/js/mustache/mustache.js<?php echo(AptTime);?>"></script>
		<script language ="javascript" src="../static/js/gfo.js<?php echo(AptTime);?>"></script>
<style type="text/css">
.compe{
background: #f4f5f7!important; color:#c44844!important; font-family: tahoma; font-size:14pt;font-weight:bold; 
border-radius:20px;	border:1px solid #f4f5f7;	padding: 5px;	
}
</style>