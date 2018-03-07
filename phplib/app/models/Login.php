<?php

class Login{
	protected static $db;
	public $token;

	public function __construct() {
		self::$db = new DB;
    }
///////////////////Log out and end session etc
	public static function logOut(){
			setcookie("session_token", '', 1); //expire cookie
			setcookie("user_token", '', 1); //expire cookie	 
			session_unset();  
			header("Refresh:0; url=index.php");      
	    }

/////////////////////////////////// check user and call setToken
	public function logIn($email=null, $password=null){
		if(!$email  && isset($_POST['log_email'])){
			$email = $_POST['log_email'];
		}
		if(!$password  && isset($_POST['log_password'])){
			$password = $_POST['log_password'];
		}
		if(!$password || !$email)return false;
		$email = filter_var($email, FILTER_SANITIZE_EMAIL); //sanitize email

		$s_email = self::$db->escape($email);
		$s_password = self::$db->escape($password);
		$ps_hash = password_hash($s_password, PASSWORD_BCRYPT);
		$_SESSION['log_email'] = $email;

		if(!self::$db->query("SELECT * FROM users WHERE email = $s_email")){
			array_push($_SESSION['error'], "User not found. Sign up for a free account");
			return false;
		}
		$myquery = "SELECT * FROM users WHERE email = $s_email";
		$user = self::$db->select($myquery);

		if($user[0]['password']==$ps_hash){
			$this->setToken($user[0]['id'],$ps_hash);
		}
		else{
			array_push($_SESSION['error'] , 'password does not match');
			return false ;
		}

		$_SESSION['username'] = $user[0]['username'];
		return true;                                                                               
	}

/////////////////////Generate and set token
	private function setToken($u_id, $hash){
		$token = password_hash($hash . time(), PASSWORD_BCRYPT);
		//-----------queries
		$set_session_token = "UPDATE users SET session_token=$token WHERE id=$u_id;";
		echo $u_id;
		//-----------end queries

		//setcookie("session_token", $token, time()+36000);  
		// expire in one year 
		//setcookie("user_token", $u_id, time()+36000);
		$_SESSION['sesstoken']=$token;
		$_SESSION['usertoken']=$u_id;

		self::$db->query($set_session_token);
 	}

	public function getToken(){
		  setcookie("sesstoken", $_SESSION['sesstoken'], time()+3600, " ", '', false, false);  
		  setcookie("usertoken", $_SESSION['usertoken'], time()+3600, " ", '', false, false);  

	}
///////////////////////////////////
	public function checkToken(){

		if(isset($_COOKIE['session_token']) &&  isset($_COOKIE['user_token'])){
			$u_id = self::$db->escape($_COOKIE['user_token']);
			$auth = self::$db->escape($_COOKIE['session_token']);
			$q = "SELECT session_token FROM users WHERE id=$u_id";

			if(!$_SESSION['session_token']){
				$_SESSION['session_token']= self::$db->query($q);
			}
			if ($auth == $_SESSION['session_token'] ) {
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
		

		
	}
}


