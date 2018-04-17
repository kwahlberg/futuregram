<?php
class User {
	private $user;
	private $db;

	public function __construct($db, $user){
		$this->db = $db;
		$user_details_query = "SELECT * FROM users WHERE id='$user'";
		$this->user = $this->db->select($user_details_query)[0];
	}

	public function getUsername() {
		return $this->user['username'];
	}

	public function getFirstAndLastName() {
		$username = $this->user['username'];
		$query = "SELECT first_name, last_name FROM users WHERE username='$username'";
		$row = $this->db->select($query)[0];
		return $row['first_name'] . " " . $row['last_name'];
	}

	public function getProfilePic() {
		$username = $this->user['username'];
		$query = "SELECT profile_pic FROM users WHERE username='$username'";
		$row = $this->db->select($query)[0];
		return $row['profile_pic'];
	}

	public function getFriendArray() {
		$username = $this->user['username'];
		$query = "SELECT following FROM users WHERE username='$username'";
		$row = $this->db->select($query)[0];
		return $row['following'];
	}
	

	public function getMutualFollows($user_to_check) {
		$mutualFollows = 0;
		$user_array = $this->user['following'];
		$user_array_explode = explode(",", $user_array);

		$query = "SELECT following FROM users WHERE username='$user_to_check'";
		$row = $this->db->select($query)[0];
		$user_to_check_array = $row['following'];
		$user_to_check_array_explode = explode(",", $user_to_check_array);

		foreach($user_array_explode as $i) {

			foreach($user_to_check_array_explode as $j) {

				if($i == $j && $i != "") {
					$mutualFriends++;
				}
			}
		}
		return $mutualFriends;

	}




}

?>