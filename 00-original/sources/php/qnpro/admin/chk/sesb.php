<?php
session_start();
if($_SESSION['first']) {
echo $_SESSION['first'];
echo '<br>';
echo isset($_SESSION['first']);
}
?>