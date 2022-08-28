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
		"database" => "lira"
	);

    // private $servername = "localhost";
    // private $username = "root";
    // private $password = "";
    // private $database = "lira";

    function __construct()
    {
		// echo "abc";
		$this->link = new \mysqli($this->conn["servername"], $this->conn["username"], $this->conn["password"], $this->conn["database"]);
		// print_r($this->link->query('SELECT DATABASE()')->fetch_row());
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