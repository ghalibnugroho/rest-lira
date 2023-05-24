<?php
namespace App\Database;

// use \Mysqli;

Class Database{

    var $query;
    var $link;

    var $errno = '';
	var $error = '';

	// connect pakai webserver php native wajib 127.0.0.1 || webserver xampp bisa localhost/127.0.0.1

	public $conn = array(
		"servername" => "127.0.0.1",
		"username" => "root",
		"password" => "",
		"database" => "lira1"
	);

    function __construct()
    {
		$this->link = new \mysqli($this->conn["servername"], $this->conn["username"], $this->conn["password"], $this->conn["database"]);
		// print_r($this->link->query('SELECT DATABASE()')->fetch_row());
		
		// $this->link = mysqli_init();
		// if (!$this->link) {
		// 	die('mysqli_init failed');
		// }
		// if (!$this->link->options(MYSQLI_INIT_COMMAND, 'SET AUTOCOMMIT = 0')) {
		// 	die('Setting MYSQLI_INIT_COMMAND failed');
		// }
		
		// if (!$this->link->options(MYSQLI_OPT_CONNECT_TIMEOUT, 7)) {
		// 	die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');
		// }
		
		// if (!$this->link->real_connect($this->conn["servername"], $this->conn["username"], $this->conn["password"], $this->conn["database"])) {
		// 	die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
		// }
		
    }

    // Executes a database query
	function query( $query ) 
	{
		$this->classQuery = $query;
		return $this->link->query( $query );
	}
	
	function escapeString( $query )
	{
		return $this->link->escape_string( $query );
	}
	
	// Get the data return int result
	function numRows( $result )
	{
		return $result->num_rows;
	}
	
	function lastInsertedID()
	{
		return $this->link->insert_id;
	}
	
	// Get query using assoc method
	function fetchAssoc( $result )
	{
		return $result->fetch_assoc();
	}
	
	// Gets array of query results
	function fetchArray( $result , $resultType = MYSQLI_ASSOC )
	{
		return $result->fetch_array( $resultType );
	}
	
	// Fetches all result rows as an associative array, a numeric array, or both
	function fetchAll( $result , $resultType = MYSQLI_ASSOC )
	{
		return $result->fetch_all( $resultType );
	}
	
	// Get a result row as an enumerated array
	function fetchRow( $result )
	{
		return $result->fetch_row();
	}
	
	// Free all MySQL result memory
	function freeResult( $result )
	{
		$this->link->free_result( $result );
	}
	
	//Closes the database connection
	function close() 
	{
		$this->link->close();
	}
	
	function sql_error()
	{
		if( empty( $error ) )
		{
			$errno = $this->link->errno;
			$error = $this->link->error;
		}
		return $errno . ' : ' . $error;
	}

    
}


?> 