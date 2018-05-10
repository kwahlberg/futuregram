<?php


class Post {
	private $p_id;
	private $u_id;
	private $body;
	private $image;
	private $comments;
	private $user_image;
	


	public function __construct($db, $p_id=null){
		if($p_id)$this->p_id = $p_id;
		$this->db = $db;
		$post_query = "SELECT * FROM posts WHERE p_id ='$p_id'";
		$this->post = $this->db->select($post_query)[0];
	}
}


?>