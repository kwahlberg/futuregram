<?php
class User {
	private $user;
	private $db;

	public function __construct($user){
		$this->db = new DB;
		$user_details_query = "SELECT * FROM users WHERE id='$user'";
		$this->user = $this->db->select($user_details_query)[0];
	}

	public function getUsername() {
		return $this->user['username'];
	}

	public function getFirstAndLastName() {
		return $this->user['first_name'] . " " . $this->user['last_name'];
	}

	public function getProfilePic() {
		return $this->user['image'];
	}

	public function getFollowArray() {
		$this->user['following'];
	}

	public function getPosts(){
		$id = $this->user['id'];
		$query = "SELECT * FROM posts WHERE u_id='$id'";
		return $this->db->select($query);

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