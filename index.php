<?php

ob_start(); //output buffering 
  //setcookie("usertoken", $_SESSION['usertoken'], time()+3600, " ", '', false, false);  

if(isset($_SESSION['usertoken']) && isset($_SESSION['sesstoken'])){

  //setcookie("sesstoken", $_SESSION['sesstoken'], time()+3600, " ", '', false, false);  
  setcookie("usertoken", $_SESSION['usertoken'], time()+3600, " ", '', false, false);  

}else{
  if(!isset($_SESSION)) {
  session_start();
  setcookie("usertoken", 'doodoo', time()+3600, " ", '', false, false);  

}
  //echo  $_SESSION['sesstoken'];

}

  ?>
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>FutureEyes</title>
  <meta name="description" content="FuturEyes">
  <meta name="author" content="By Kurt Wahlberg">


  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>

  <?php
  
  require_once("phplib/app/controllers/Controller.php");
  require_once("init.php");
  
  $_SESSION['error']=array();
  //error_reporting(E_ALL); ini_set('display_errors', 1);
    if (isset($_GET['source'])) {
      highlight_file($_SERVER['SCRIPT_FILENAME']);
      exit;
    }
    $control = new Controller;
    $control->invoke();
  ?>

  <script src="js/scripts.js"></script>
</body>
</html>

<?php 
ob_end_flush();
?>
