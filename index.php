<?php
ob_start(); 
if(!isset($_SESSION)) {
session_start();
}
  ?>

<!doctype html>


  <?php
  
  require_once("phplib/app/controllers/Controller.php");
  require_once("init.php");
  
  if(!$_SESSION['error'])$_SESSION['error']=array();
  //error_reporting(E_ALL); ini_set('display_errors', 1);
    if (isset($_GET['source'])) {
      highlight_file($_SERVER['SCRIPT_FILENAME']);
      exit;
    }
	if(!$_SESSION['login'] || !$_SESSION['logout']){
    $control = new Controller;
    $control->invoke();
	}else{
		$login = new Login;
		if($_SESSION['login'])$login->logIn();
                if($_SESSION['logOut'])$login->logIn();
}
  ?>

  <script src="js/scripts.js"></script>
</body>
</html>

<?php 
//print_r($_SESSION['error']);
//ob_end_flush();
?>
