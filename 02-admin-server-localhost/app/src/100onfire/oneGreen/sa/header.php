<?php  
if (!defined('DR')) define('DR', __DIR__.'/'); include_once(realpath(DR.'../pref.php'));
?>
<html>
<head>
		<title>EduMax - SuperAdmin</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<link rel="shortcut icon" href="../static/img/comp/fav.png" />
		<link href="../static/css/cat.css<?php echo(AptTime);?>" type="text/css" rel="stylesheet">
		<script language ="javascript" src="../static/js/jquery/jquery.min.js<?php echo(AptTime);?>"></script>
		<script language ="javascript" src="../static/js/moment/moment.min.js<?php echo(AptTime);?>"></script>
		
		<link href="../static/js/bootstrap/bootstrap-4.min.css<?php echo(AptTime);?>" type="text/css" rel="stylesheet">
		<script language ="javascript" src="../static/js/bootstrap/bootstrap-4.min.js<?php echo(AptTime);?>"></script>		
		
		<script language ="javascript" src="../static/js/mustache/mustache.js<?php echo(AptTime);?>"></script>		
		<script language ="javascript" src="../static/js/gfo.js<?php echo(AptTime);?>"></script>
		<style type="text/css">
			.loadvaltmr{background:url('../static/img/icons/timer-16px.png') no-repeat left center yellow; 
			width:3rem;text-align:right;}
			.f10{font-size:10pt;}
			.wh3rem{width:2.5rem;height:2.5rem;padding-top:0.8rem;}
			.w10h2rem{width:10rem;height:2rem;padding-top:0.6rem;}
			.w3h2rem{width:2.5rem;height:2rem;padding-top:0.6rem;}
			.mw10remw18per{min-width:10rem;width:18%;}			
		</style>