<?php
class Register {
	public $fname; 
	public $lname;
	public $email;
	public $email2;
	private $password;
	private $password2;
	public $date;
	public static $db;

	public function __construct() {
		$this->fname = ""; //First name
		$this->lname = ""; //Last name
		$this->em = ""; //email
		$this->em2 = ""; //email 2
		$this->password = ""; //password
		$this->password2 = ""; //password 2
		$this->date = ""; //Sign up date 
		self::$db = new DB("secure/config.ini");
		if (!self::$db) echo "<p>Cannot connect to database</p>";

    }

	public static function processForm(){

		if(isset($_POST['register_button'])){

			$fname = strip_tags($_POST['reg_fname']); 
			$fname = str_replace(' ', '', $fname); 
			$fname = ucfirst(strtolower($fname)); 
			$_SESSION['reg_fname'] = $fname;
			$lname = strip_tags($_POST['reg_lname']); 
			$lname = str_replace(' ', '', $lname); 
			$lname = ucfirst(strtolower($lname));
			$_SESSION['reg_lname'] = $lname; 
			$email = strip_tags($_POST['reg_email']);
			$email = str_replace(' ', '', $email); 
			$_SESSION['reg_email'] = $email;
			$email2 = strip_tags($_POST['reg_email2']); 
			$email2 = str_replace(' ', '', $email2); 
			$_SESSION['reg_email2'] = $email2; 
			$password = $_POST['reg_password']; 
			$password2 = $_POST['reg_password2']; 
			$date = date("Y-m-d"); //Current date

			if($email == $email2) {
				//Check if email is in valid format 
				if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$email = filter_var($email, FILTER_VALIDATE_EMAIL);
					//Check if email already exists 
					$e_check = self::$db->select("SELECT email FROM users WHERE email='$email'");
					if($e_check) {
						array_push($_SESSION['error'], "Email already in use<br>");
					}

				}else{
					array_push($_SESSION['error'], "Invalid email format<br>");
				}

			}else {
				array_push($_SESSION['error'], "Emails don't match<br>");
			}

			if(strlen($fname) > 25 || strlen($fname) < 2) {
				array_push($_SESSION['error'], "Your first name must be between 2 and 25 characters<br>");
			}

			if(strlen($lname) > 25 || strlen($lname) < 2) {
				array_push($_SESSION['error'],  "Your last name must be between 2 and 25 characters<br>");
			}

			if($password != $password2) {
				array_push($_SESSION['error'],  "Your passwords do not match<br>");
			}
			else {
				if(!preg_match('/^(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/', $password)) {
					array_push($_SESSION['error'], "Your password must contain at least one lower case letter, one upper case letter, and one number<br>");
				}
			}

			if(strlen($password > 30 || strlen($password) < 8)) {
				array_push($_SESSION['error'], "Your password must be betwen 8 and 30 characters<br>");
			}


			if(empty($_SESSION['error'])) {
				$passhash = password_hash($password, PASSWORD_BCRYPT); //Encrypt password before sending to database
				//Generate username by concatenating first name and last name
				$check_username_query = self::$db->select("SELECT username FROM users WHERE first_name='$fname' AND last_name = '$lname';");
				$username = $fname . " " . $lname;
				$num_u = count($check_username_query);
				if($num_u>0){
					$username .= $num_u;
				}


				$i = 0; 
				/*
				$query = self::$db->query("INSERT INTO users('first_name', 'last_name', 'username', 'email', 'password') VALUES ('$fname', '$lname', '$username', '$email', '$password')");
				echo 'hi';
				*/
				//echo $fname . $lname . $username . $email . $password;
				$fname = self::$db->escape($fname);
				$lname = self::$db->escape($lname);
				$username = self::$db->escape($username);
				$email = self::$db->escape($email);
				//$password = self::$db->escape($password);
				//echo $fname . $lname . $username . $email . $password;

				//$s_q = "SELECT * FROM users;";
				$myquery = "INSERT INTO `users` VALUES ('',$fname, $lname, $username, $email, '$passhash', '', '', '');";
				self::$db->query($myquery);
				//print_r(self::$db->select($s_q));
				array_push($_SESSION['error'], "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");
				
				//Clear session variables 
				$_SESSION['reg_fname'] = "";
				$_SESSION['reg_lname'] = "";
				$_SESSION['reg_email'] = "";
				$_SESSION['reg_email2'] = "";
				$_POST['reg_password2']='';
				$_POST['reg_password']='';
				$password = "";
				$password2='';
				return true;
			}else{
				return false;
			}
		}
	}
}
?>