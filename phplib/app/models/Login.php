<?php

class Login{
	protected static $db;
	public $token;

	public function __construct() {
		self::$db = new DB;
    }
///////////////////Log out and end session etc
	public  function logOut(){
		if($_SESSION['logout']){
			setcookie("usertoken", $_SESSION['usertoken'], 1, " ", '', false, false);	
		  	setcookie("sesstoken", $_SESSION['sesstoken'], 1, " ", '', false, false); 
		  	
		  	unset($_SESSION['logout']);
		  	unset($_SESSION['username']);
		  	unset($_SESSION['usertoken']);
		  	unset($_SESSION['sesstoken']);
		  	//header("Refresh:0; url=index.php");  

		  	

			}else{
			$_SESSION['logout'] = true;
			header("Refresh:0; url=index.php");  
			}    
	    }

/////////////////////////////////// check user and call setToken
	public function logIn(){
		$email = $_POST['log_email'];
		$email = filter_var($email, FILTER_SANITIZE_EMAIL); //sanitize email
		$s_email = self::$db->escape($email);

		
		$myquery = "SELECT * FROM users WHERE email = $s_email;";
		if(!self::$db->query($myquery)){
			array_push($_SESSION['error'], "does not match");
			return false;
		}

		$user = self::$db->select($myquery);
		$hash = $user[0]['password'];
		$password = $_POST['log_password'];
		$unlocked = password_verify($password, $hash);

		if($unlocked){
			$this->setSessionVar($user[0]['id'],$hash);
			//echo 'yeah finally';
			$_SESSION['username'] = $user[0]['username'];
  			header( "refresh:0; url=index.php?page=home");
  		 			return true;
		}
		else{
			array_push($_SESSION['error'] , 'does not match');

			return false ;
		}
		array_push($_SESSION['error'] , 'does not match');
		return false;                                                                               
	}

/////////////////////Generate and set token
	private function setSessionVar($u_id, $hash){
		$id = self::$db->escape($u_id);
		$token = password_hash($hash . time(), PASSWORD_BCRYPT);
		//-----------queries
		$set_session_token = "UPDATE `users` SET `session_token` = $token WHERE `id`=$id;";
		echo $u_id;
		//-----------end queries

		//setcookie("session_token", $token, time()+36000);  
		// expire in one year 
		//setcookie("user_token", $u_id, time()+36000);
		$_SESSION['sesstoken']=$token;
		$_SESSION['usertoken']= $u_id;
		echo $_SESSION['usertoken'] . $_SESSION['sesstoken'];

		if(self::$db->query($set_session_token)) echo '<br>token set';
 	}

///////////////////////////////////////
	public function setCookies(){
		if($_SESSION['sesstoken'] && $_SESSION['usertoken']){
		  $s = setcookie("sesstoken", $_SESSION['sesstoken'], time()+3600, " ", '', false, false);  
		  $u = setcookie("usertoken", $_SESSION['usertoken'], time()+3600, " ", '', false, false);
		  if($s&&$u){

		  	return true;
		  }else {
		  	$this->logOut();
		  }
		}
		$this->logOut();

	}
//////////////////////////////////////
	public function checkToken(){

		if(isset($_COOKIE['sesstoken']) &&  isset($_COOKIE['usertoken'])){
			$u_id = self::$db->escape($_COOKIE['usertoken']);
			$q = "SELECT * FROM users WHERE id=$u_id;";
			$user = self::$db->select($q);
			if(!$_SESSION['sesstoken'] && $user){
				$_SESSION['sesstoken']= $user[0]['session_token'];
				if($_SESSION['sesstoken']){
					$s = true;
				}else{
					$s = false;
				}
			}
			if(!isset($_SESSION['username']) && isset($user[0]['username'])){
				$_SESSION['username']= $user[0]['username'];
			}
			if(!$_SESSION['usertoken'] && $user){
				$_SESSION['usertoken']= $user[0]['id'];
				if($_SESSION['usertoken']){$s = true;}else{$s = false;}
			}
			//echo $user[0]['session_token'];
			$u_session = $_COOKIE['sesstoken'];
			$s_session = $_SESSION['sesstoken'];
			$u_user = $_COOKIE['usertoken'];
			$s_user = $_SESSION['usertoken'];

			if($u_session && $s_session){
				if ($u_session == $s_session && $u_user == $s_user) {
				return true;
			}
			
			}else{
				return false;
			}
		}else{
			return false;
		}	
	}

}


