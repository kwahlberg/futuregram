<?php
//takes path to config ini as arg
class DB {
    protected static $connection;
    
    public function __construct($config=null) {
        $this->config = ($config) ?: 'secure/config.ini';
    }

    public function connect() {
			if(!isset(self::$connection)) {
				$db_login = parse_ini_file($this->config);
				self::$connection = new mysqli($db_login['host'],$db_login['username'],$db_login['psk'],$db_login['dbname']);
			//echo 'trying to connect';
				
			}

			if(self::$connection === false) {
					echo "Warning! Can't connect to database!";
					return false;
			}
			return self::$connection;
    }

    public function query($query) {
			$connection = $this -> connect();
			$result = $connection -> query($query);
			return $result;
    }

    public function select($query) {
			$rows = array();
			$result = $this -> query($query);

			if($result === false) {
					return false;
			}
			while ($row = $result -> fetch_assoc()) {
					$rows[] = $row;
			}
			return $rows;
    }
    
    public function escape($value) {
			$connection = $this -> connect();
			return "'" . $connection -> real_escape_string($value) . "'";
    }
    
     public function getId() {
			$connection = $this -> connect();
			return $connection->insert_id;
    }
    
    public function error() {
			$connection = $this -> connect();
			return $connection -> error;
    }
    
    public function close() {
			if($connection)
			{
					$connection->close();
					$connection = null;

			}
			return ;
    }
    
}
?>
