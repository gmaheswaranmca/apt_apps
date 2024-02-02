<?php
$inputFileName = 'data-user.xlsx';
define ("AR_XL_FILE", $inputFileName); 
if (!defined('APPDB')) define('APPDB', __DIR__.'/');	
$arexcel_path = realpath(APPDB.'/ArExcel.php');
//echo($arexcel_path);
include_once($arexcel_path);
$exUsers = $ValueExcel->ExData();
$jsonUsers = json_encode($exUsers);		
echo($jsonUsers);
?>