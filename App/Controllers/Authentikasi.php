<?php
namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;

class Authentikasi{
    var $db;

    public function __construct(){
        $this->db = new Database();
    }

    function login(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        $query = "SELECT catalogs.ID, BIBID, Title, Author, PublishYear, CoverURL, (select count(collections.Catalog_id) from collections where Catalog_id = catalogs.ID and Status_id = 1) as Quantity FROM catalogs ORDER BY `catalogs`.`CoverURL` DESC";  
        $result = $this->db->query($query);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Buku Katalog";
                $response["status"] = http_response_code();
                $response["message"] = "Success";
                $response["data"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["id"] = $row["ID"];
                    $data["bibid"]=$row["BIBID"];
                    $data["title"]=$row["Title"];
                    $data["author"]=$row["Author"];
                    $data["publishYear"]=$row["PublishYear"];
                    $data["coverURL"]=$row["CoverURL"];
                    $data["quantity"]=$row["Quantity"];
                    array_push($response["data"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["title"] = "Data Buku Katalog Bercover Tidak Tersedia";
                $response["status"] = http_response_code();
                $response["message"] = "Failed";
                return json_encode($response);
            }
        }
        else {
            // no results found
                $response["title"] = "Data Buku Katalog Bercover Tidak Tersedia";
                $response["status"] = http_response_code();
                $response["message"] = "No Details Found";
                return json_encode($response);
        }
    }

    function registrasi(){
        
    }
}