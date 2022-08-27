<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $database = "lira";
 
 // Create connection
 mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
 $mysqli = new mysqli($servername, $username, $password, $database);
 /* change default database to "world" */
// $mysqli->select_db("lira");

/* get the name of the current default database */
$result = $mysqli->query("SELECT DATABASE()");
$row = $result->fetch_row();
// printf("Default database is %s.\n", $row[0]);

// echo "directory is " . __DIR__;



 ?> 