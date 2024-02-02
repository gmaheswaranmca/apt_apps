<?php 
$inputFileName = 'data-user.xlsx';
define ("AR_XL_FILE", $inputFileName); 
if (!defined('CURRPG')) define('CURRPG', __DIR__.'/');
$db_path = realpath(CURRPG.'/DBUser.php');
$arexcel_path = realpath(CURRPG.'/ArExcel.php');

include_once($arexcel_path);
$exUsers = $ValueExcel->ExData();
$jsonUsers = json_encode($exUsers);		
include($db_path);
$ValueDBUser = new DBUser();
echo("<p><strong>User Data Update....</strong></p><p>");
foreach ($exUsers as $exUser){
    $ValueDBUser->SaveUser($exUser->username, md5($exUser->password), $exUser->fullname);
}
echo("</p>");

?>