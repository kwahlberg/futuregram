<?php
require_once('init.php') ;

class Controller {  
	public static $model;
            
	public function __construct()    
	{    

	}
	
	public function invoke()  
	{	
		
		if(!$login)$login = new Login;
		if($_SESSION['logout'])$login->logOut();
		if($_SESSION['login'])$login->logIn();
		if($_SESSION['allow'])$login->setCookies();
			include_once 'phplib/app/views/header.html';
       		if(!$_SESSION['allow']) $_SESSION['allow'] = $login->checkToken();
		if(!$_SESSION['allow'])include_once('phplib/app/views/register.php');
        	if($_SESSION['allow']) include_once('phplib/app/views/navbar.php');
/*
//////////////////////////////////////////////////////////////////////////////
		------ROUTER------
*/
		
		if ($_SESSION['allow'])
		{  
			if(isset($_GET['page'])){
				$page = $_GET['page'];
			}else{
				$page = "home";
			}
			if($page == 'login') {
				  include_once('phplib/app/views/login.php');
			}

			if($page == 'logout'){
               			$login->logOut();
			}
            
			if($page == 'settings'){
				include_once('phplib/app/views/settings.php'); 
			}

            if($page == 'profile'){
				include_once('phplib/app/views/profile.php'); 
			}

            if($page == 'following'){
				include_once('phplib/app/views/following.php'); 
			}
			if($page == 'checklog'){
				include_once('phplib/app/views/error.php');
            }

            if($page == 'checkreg'){
				include_once('phplib/app/views/error.php');
            }
            if($page == 'error'){
				include_once('phplib/app/views/error.php');
            }
        	if($page =='home'){
            	include_once('phplib/app/views/home.php');
            }
		}elseif(isset($_POST['register_button'])) { 
			
			$register = new Register;
			if(!$register->processForm()){
				include_once('phplib/app/views/register.php');
			}else{
				include_once('phplib/app/views/thanks.php');
			}
			
		}elseif (isset($_POST['login_button'])) {
			if(!$login->logIn()){
				unset($_POST['login_button']);
				array_push($_SESSION['error'], "does not match");
				header("Refresh:0; url=index.php");

				}     

		}elseif(isset($_SESSION['usertoken']) && !isset($_COOKIE['usertoken'])) {
			if($login->setCookies()){
			header("Refresh:0; url=index.php?page=home");
			}else{
				include_once('phplib/app/views/register.php');
			}

		}else{
			include_once('phplib/app/views/register.php');

		}
		
/////////////////////////////////////////////////////////////////////////////

		
	}  
		
}
	?>
