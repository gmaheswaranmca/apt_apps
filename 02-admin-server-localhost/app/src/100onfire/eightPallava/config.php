<?php
  include_once('pref.php');
  define("SQL_IP", "mysqldb");

  define("SQL_USER", "oxygen_aptonline");
  define("SQL_PWD","I8U+RxjE7*.H");  
  define("SQL_DATABASE","oxygen_aptonlineeight");
  define("SQL_PORT","3306"); 
  
  define("DEBUG_SQL","no");

  function Imported_Users_Password_Hash($entered_password,$password_from_db)
  {
      return md5($entered_password);
  }

  @session_start();
?>