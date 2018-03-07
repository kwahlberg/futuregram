<?php
require_once('init.php') ;

class Controller {  
	public static $model;
            
	public function __construct()    
	{    

	}
	
	public function invoke()  
	{
		$login = new Login;
        $allow = $login->checkToken();
        if($allow) include_once('phplib/app/views/navbar.php');

        

/*
//////////////////////////////////////////////////////////////////////////////
		------ROUTER------
*/
		
		if (isset($_GET['page']) && $allow)
		{  
			$page = $_GET['page'];

			if($page == 'home') { 
				include_once('phplib/app/views/home.php');
			}

			if($page == 'login') {
				  include_once('phplib/app/views/login.php');
			}

			if($page == 'logout'){
               	include_once('phplib/app/views/logout.php'); 
			}
            
			if($page == 'settings'){
				include_once('phplib/app/views/setting.php'); 
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
		}elseif(isset($_POST['register_button'])) { 
			
			$register = new Register;
			if(!$register->processForm()){
				include_once('phplib/app/views/register.php');
			}else{
				include_once('phplib/app/views/thanks.php');
			}
			
		}elseif (isset($_POST['login_button'])) {
			$login->logIn();
			header("Refresh:0; url=index.php");      
		}else{
			include_once('phplib/app/views/register.php');

		}  
/////////////////////////////////////////////////////////////////////////////

		
	}  
		
}
	?>