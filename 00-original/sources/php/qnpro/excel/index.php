<?php
set_time_limit(1200);


if (!defined('APPDB')) define('APPDB', __DIR__.'/');
$config_path = realpath(APPDB.'../config.php');
include_once ($config_path);
?>


<?php
$inputFileName = 'data-user.xlsx';	
define ("DB_HOST", SQL_IP); // set database host
define ("DB_USER", SQL_USER); // set database user
define ("DB_PASS", SQL_PWD); // set database password
define ("DB_NAME", SQL_DATABASE); // set database name



?>


<?php
/*
This script is use to upload any Excel file into database.
Here, you can browse your Excel file and upload it into 
your database.

Download Link: http://www.discussdesk.com/import-excel-file-data-in-mysql-database-using-PHP.htm

Website URL: http://www.discussdesk.com
*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Demo - Import Excel file data in mysql database using PHP, Upload Excel file data in database</title>
<meta name="description" content="This tutorial will learn how to import excel sheet data in mysql database using php. Here, first upload an excel sheet into your server and then click to import it into database. All column of excel sheet will store into your corrosponding database table."/>
<meta name="keywords" content="import excel file data in mysql, upload ecxel file in mysql, upload data, code to import excel data in mysql database, php, Mysql, Ajax, Jquery, Javascript, download, upload, upload excel file,mysql"/>
</head>
<body>

<?php
/************************ YOUR DATABASE CONNECTION START HERE   ****************************/



$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
$db = mysql_select_db(DB_NAME, $link) or die("Couldn't select database");

$databasetable = "sample";

/************************ YOUR DATABASE CONNECTION END HERE  ****************************/


set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';

// This is the file path to be uploaded.
 

try {
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}


$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
$arrayCount = count($allDataInSheet);  // Here get total count of row in that Excel sheet

$msg='';
for($i=2;$i<=$arrayCount;$i++){
	$login = trim($allDataInSheet[$i]["A"]);
	$pass = trim($allDataInSheet[$i]["B"]);
	$password=md5($pass);
	$name = trim($allDataInSheet[$i]["C"]);
	$added_date=date('Y/m/d h:i:sa');



	$query = "SELECT UserName FROM users WHERE UserName = '".$login."' and Password  = '".$password."'";
	$sql = mysql_query($query);
	$recResult = mysql_fetch_array($sql);
	$existName = $recResult["UserName"];
	if($existName=="") {
	$insertTable= mysql_query("insert into users (UserName,Password,Name,added_date,user_type,email) values('".$login."', '".$password."','".$name."','".$added_date."','2','');");


	$msg = $msg.$login.'Record has been added<br>';
	} else {
	$insertTable= mysql_query("update users set Password='".$password."',Name='".$name."' where UserName='".$login."'");
	$msg = $msg.$login.'Record has been updated<br>';
	}
}
$msg = $msg.'<div style="Padding:20px 0 0 0;"><a href="">Go Back to tutorial</a></div>';
echo "<div style='font: bold 18px arial,verdana;padding: 45px 0 0 500px;'>".$msg."</div>";
 

?>
<body>
</html>