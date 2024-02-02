<?php
	function getOffSet(){
		$now = new DateTime();
		$mins = $now->getOffset() / 60;
		$sgn = ($mins < 0 ? -1 : 1);
		$mins = abs($mins);
		$hrs = floor($mins / 60);
		$mins -= $hrs * 60;
		$offset = sprintf('%+d:%02d', $hrs*$sgn, $mins);		
		return $offset;
	}	
	define('APT_TIMEZONE', 'Asia/Calcutta');
	date_default_timezone_set(APT_TIMEZONE);
	$offset = getOffSet();
	define('APT_TZ_OFFSET', $offset);
	$time = time();
	define("AptTime", '?t='.date('YmdHis', $time));
	define("AptDateTime", date('D d-m-Y h:i:s a', $time));
	define("AptDateOnly", date('d-M-Y', $time));
	define("AptDayName", date('D', $time));
	define("AptTimeOnly", date('h:i:s a', $time));
	//$db = new PDO('mysql:host=localhost;dbname=test', 'dbuser', 'dbpassword');
	//$$offset=APT_TZ_OFFSET;
	//$db->exec("SET time_zone='$offset';");
