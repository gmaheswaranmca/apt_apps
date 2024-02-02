<?php
	@session_start();

	$_SESSION['user_id'] = null;
	$_SESSION['role_id'] = null;
	$_SESSION['user_name'] = null;
	$_SESSION['full_name'] = null;

	header("location:login.php");
?>
