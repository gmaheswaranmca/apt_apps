<?php

@session_start();

  $_SESSION['txtLogin'] = null;
  $_SESSION['txtPass'] = null;
  $_SESSION['txtPassImp'] = null;
  $_SESSION['user_id'] = null;
  $_SESSION['full_name'] = null;
  $_SESSION['user_type'] = null;  
  $_SESSION['asg_id'] = null;
  $_SESSION['user_quiz_id'] = null;

  header("location:login.php");

?>
