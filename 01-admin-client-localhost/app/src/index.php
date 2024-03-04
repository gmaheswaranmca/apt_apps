<?php
	@session_start(); 
	/*
	https://stackoverflow.com/questions/16765158/date-it-is-not-safe-to-rely-on-the-systems-timezone-settings
	*/
	if( ! ini_get('date.timezone') )
	{
		date_default_timezone_set('GMT');
	}
	$dt = date('Ymd', time());
	if(isset($_GET["dt"])){
		//echo('Get Dt:' . $_GET["dt"] . '<br>');
		if($dt==$_GET["dt"]){
			//echo('Sys Dt:' . $dt . '<br>');
			$_SESSION["dt"] = $_GET["dt"];
		}
	}
	if(!isset($_SESSION["dt"])){
		echo('Ses Dt ' . $_SESSION["dt"]);
		return;
	}		
	if($dt !== $_SESSION["dt"]){
		//echo('Sys Dt:' . $dt . '<br>');
		//echo('Ses Dt:' . $_SESSION["dt"] . '<br>');
		return;
	}
	if(isset($_GET["link"])){
		$_SESSION["link"] = $_GET["link"];
	}
	if(!isset($_SESSION["link"])){
		echo('Link is not set');
		return;
	}
	
	if(isset($_GET["app"])){
		if($_GET["app"] == "app")
			header("location:app/");	
		elseif($_GET["app"] == "app01")
			header("location:app01/");
		elseif($_GET["app"] == "app02")
			header("location:app02/");
		elseif($_GET["app"] == "app03")
			header("location:app03/");
		elseif($_GET["app"] == "admin")
			header("location:admin/");
		elseif($_GET["app"] == "apps")
			header("location:betaApp/");
		elseif($_GET["app"] == "beta")
			header("location:betaApp/PageTestPaperList.php");
		elseif($_GET["app"] == "super")
			header("location:superadmin/PageAppMonitor.php");
		elseif($_GET["app"] == "report")
			header("location:betaApp/MakeReport.php");
		elseif($_GET["app"] == "lean")
			header("location:leanApp/");
	}
	else
		header("location:betaApp/");
