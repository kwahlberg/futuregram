<?php 

class Profile {
	private $user;
	private $posts;

	public function __construct($id=null){
		if($id){
			$this->id = $id;
		}elseif($_SESSION['usertoken']){
			$this->id = $_SESSION['usertoken'];
		}
		if($this->id){

			$this->user = new User($this->id);
		}
	
		
	}

	public function getPosts {

		return
	}
}

	
?>