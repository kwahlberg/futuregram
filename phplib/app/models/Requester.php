<?php
class Requester{
	private $request = array();
	private $login = new Login;
	private static $db = new DB;
	private $out_array = array();

	public function __construct($request=null) {
       if($request){
            if(is_array($request)$this->login->checkToken()){
                foreach($request as $query ){
                    array_push($this->out_array,  self::$db->select($query));
                }
            }elseif ($request) {
            array_push($this->out_array,  self::$db->select($query));
            }

       } 
    }

    public function query($request) {
        
        if(is_array($request)$this->login->checkToken()){
            foreach($request as $query ){
                array_push($this->out_array,  self::$db->select($query));
            }
        }elseif ($request) {
            array_push($this->out_array,  self::$db->select($query));
        }   
    }

}

?>