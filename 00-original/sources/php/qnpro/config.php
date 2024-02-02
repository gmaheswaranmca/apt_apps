<?php
	@session_start();  
	include_once('pref.php');

	$config = array("base" => array("db" => "t20apt00"),
					"one" => array("db" => "aptonlineone"),
					"two" => array("db" => "aptonlinetwo"),
					"three" => array("db" => "aptonlinethree"),
					"four" => array("db" => "aptonlinefour"),
					"five" => array("db" => "aptonlinefive"),
					"six" => array("db" => "aptonlinesix"),
					"seven" => array("db" => "aptonlineseven"),
					"eight" => array("db" => "aptonlineeight"),
					"job" => array("db" => "aptjob"),
					"qabase" => array("db" => "aptqndbquants"),
					"codeone" => array("db" => "aptonlinecodeone"),
					"codetwo" => array("db" => "t20apt03camel")
					);
	//$link = "dgvc";
	//
	if(isset($IsRest))  {
		$link = 'one'; //base camel
		if(isset($RestLinkName)){
			$link = $RestLinkName;
		}
	}
	else if(!isset($_SESSION["link"])) $link = 'base'; //base camel
	else $link = $_SESSION["link"];	
	
	$configByLink = $config[$link];	
	
	define("SQL_IP", "localhost");
	define("SQL_USER", "root");
	define("SQL_PWD","");
	define("SQL_DATABASE", $configByLink["db"]);	
	
	define("DEBUG_SQL","no");

	function Imported_Users_Password_Hash($entered_password,$password_from_db){
	  return md5($entered_password);
	}
	
?>

