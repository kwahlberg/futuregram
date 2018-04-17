<?php
//need to fix bug in session_token
class Login{
	protected static $db;
	public $token;

	public function __construct() {
		self::$db = new DB;
    }
///////////////////Log out and end session etc
	public  function logOut(){
			setcookie("usertoken", $_SESSION['usertoken'], 1, " ", '', false, false);	
		  	setcookie("sesstoken", $_SESSION['sesstoken'], 1, " ", '', false, false); 
		  	
		  	session_destroy();
		  	header("Refresh:0; url=index.php");  

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
			$_SESSION['allow']=true;
			$_SESSION['username'] = $user[0]['username'];
  			header( "refresh:0; url=index.php?page=home");
  		 			return true;
		}
		else{
			array_push($_SESSION['error'] , 'does not match');
			$_SESSION['allow']=false;
			return false ;
		}
		array_push($_SESSION['error'] , 'does not match');
		return false;                                                                               
	}

/////////////////////Generate and set token
	private function setSessionVar($u_id, $hash){
		$id = self::$db->escape($u_id);
		//$token = password_hash($hash . time(), PASSWORD_BCRYPT);
		$token = bin2hex(openssl_random_pseudo_bytes(16));

		//$etoken = self::$db->escape($token);
		$set_session_token = "UPDATE `users` SET `session_token`= '$token' WHERE `id`=$id";
		//echo $u_id;
		

		$_SESSION['sesstoken']=$token;
		$_SESSION['usertoken']= $u_id;
		//echo $_SESSION['usertoken'] . $_SESSION['sesstoken'];

		if(!self::$db->query($set_session_token)){
		

		}
			//throw new Exception("Error Processing Request", 1);
			
 	}

///////////////////////////////////////
	public function setCookies(){
		
		if($_SESSION['allow'] && $_SESSION['sesstoken'] && $_SESSION['usertoken']){
		  $s = setcookie("sesstoken", $_SESSION['sesstoken'], time()+3600, " ", '', false, false);  
		  $u = setcookie("usertoken", $_SESSION['usertoken'], time()+3600, " ", '', false, false);
                  //$_SESSION['login'] = false;
  
		if($s&&$u){
                        

		  	return true;
		  }else {
		  	
			return false;
		  }
		}
		

	}
//////////////////////////////////////
	public function checkToken(){

		if(isset($_COOKIE['sesstoken']) &&  isset($_COOKIE['usertoken'])){
			$u_id = self::$db->escape($_COOKIE['usertoken']);
			$q = "SELECT * FROM users WHERE id=$u_id;";
			$user = self::$db->select($q);
			if($user){
				$_SESSION['sesstoken']= $user[0]['session_token'];
				if($_SESSION['sesstoken']==$_COOKIE['sesstoken']){
					$_SESSION['allow']=true;
					$_SESSION['username']= $user[0]['username'];
                    $_SESSION['usertoken']= $user[0]['id'];
					return true;

				}
			}
			$this->logOut();
		}
		return false;
	}

	public function fastToken(){
		if($_SESSION['sesstoken']==$_COOKIE['sesstoken']){
			return true;
		}else{
			$this->checkToken();
		}
	}
}


