<?php
namespace App\Controllers;
?>
<head>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
</head>
<?php

use App\Database\Database;
// include_once 'Database/Database.php';

Class Katalogs {

    var $db;
    var $response = array();

    public function __construct(){
        $this->db = new Database();
        // echo "1234";
    }

    function getCoveredKatalogs(){

        $query = "SELECT ID, BIBID, Title, Author, Publisher, PublishLocation, PublishYear, Subject, PhysicalDescription, ISBN, CallNumber, CoverURL FROM catalogs where coverURL is NOT NULL";  

        $result = $this->db->query($query);
        
        if($result->num_rows > 0){
            if($result){
                $response["Title"] = "Data Buku Katalog Bercover";
                $response["success"] = 1;
                $response["message"] = "Successfully Displayed";
                $response["details"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["id"] = $row["ID"];
                    $data["bibid"]=$row["BIBID"];
                    $data["title"]=$row["Title"];
                    $data["author"]=$row["Author"];
                    $data["publisher"]=$row["Publisher"];
                    $data["publishLocation"]=$row["PublishLocation"];
                    $data["publishYear"]=$row["PublishYear"];
                    $data["subject"]=$row["Subject"];
                    $data["physicalDescription"]=$row["PhysicalDescription"];
                    $data["isbn"]=$row["ISBN"];
                    $data["callNumber"]=$row["CallNumber"];
                    $data["coverURL"]=$row["CoverURL"];
                    array_push($response["details"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["Title"] = "Data Buku Katalog Bercover";
                $response["success"] = 0;
                $response["message"] = "Try Again";
                return json_encode($response);
            }
        }
        else {
            // no results found
                $response["Title"] = "Data Buku Katalog Bercover";
                $response["success"] = 0;
                $response["message"] = "No Details Found";
                return json_encode($response);
        }

    }

    function getAllKatalogs(){

        $query = "SELECT ID, BIBID, Title, Author, Publisher, PublishLocation, PublishYear, Subject, PhysicalDescription, ISBN, CallNumber, CoverURL FROM catalogs";  

        $result = $this->db->query($query);
        
        if($result->num_rows > 0){
            if($result){
                $response["Title"] = "Data Buku Seluruh Katalog";
                $response["success"] = 1;
                $response["message"] = "Successfully Displayed";
                $response["details"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["id"] = $row["ID"];
                    $data["bibid"]=$row["BIBID"];
                    $data["title"]=$row["Title"];
                    $data["author"]=$row["Author"];
                    $data["publisher"]=$row["Publisher"];
                    $data["publishLocation"]=$row["PublishLocation"];
                    $data["publishYear"]=$row["PublishYear"];
                    $data["subject"]=$row["Subject"];
                    $data["physicalDescription"]=$row["PhysicalDescription"];
                    $data["isbn"]=$row["ISBN"];
                    $data["callNumber"]=$row["CallNumber"];
                    $data["coverURL"]=$row["CoverURL"];
                    array_push($response["details"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["Title"] = "Data Buku Seluruh Katalog";
                $response["success"] = 0;
                $response["message"] = "Try Again";
                return json_encode($response);
            }
        }
        else {
            // no results found
                $response["Title"] = "Data Buku Seluruh Katalog";
                $response["success"] = 0;
                $response["message"] = "No Details Found";
                return json_encode($response);
        }
        
    }


}