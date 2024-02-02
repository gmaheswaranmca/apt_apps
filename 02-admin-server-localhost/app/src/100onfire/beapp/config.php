<?php
	@session_start();  
	include_once('pref.php');

	$config = array(
					"one" => array("db" => "oxygen_aptonlineone"),
					"two" => array("db" => "oxygen_aptonlinetwo"),
					"three" => array("db" => "oxygen_aptonlinethree"),
					"four" => array("db" => "oxygen_aptonlinefour"),
					"five" => array("db" => "oxygen_aptonlinefive"),
					"six" => array("db" => "oxygen_aptonlinesix"),
					"seven" => array("db" => "oxygen_aptonlineseven"),
					"eight" => array("db" => "oxygen_aptonlineeight")
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
	
	define("SQL_IP", "mysqldb");
  define("SQL_USER", "oxygen_aptonline");
  define("SQL_PWD","I8U+RxjE7*.H"); 
  define("SQL_PORT","3306"); 
  
	define("SQL_DATABASE", $configByLink["db"]);	
	
	define("DEBUG_SQL","no");

	function Imported_Users_Password_Hash($entered_password,$password_from_db){
	  return md5($entered_password);
	}
	
