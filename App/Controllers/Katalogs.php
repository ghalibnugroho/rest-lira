<?php
namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;

Class Katalogs {

    var $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getKatalogs(){

        $query = "SELECT catalogs.ID, BIBID, Title, Author, PublishYear, CoverURL, (select count(collections.Catalog_id) from collections where Catalog_id = catalogs.ID and Status_id = 1) as Quantity FROM catalogs ORDER BY `catalogs`.`CoverURL` DESC";  
        $result = $this->db->query($query);

        // var_dump($result);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Buku Katalog";
                $response["status"] = 1;
                $response["message"] = "Response Success";
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
                $response["status"] = 0;
                $response["message"] = "Response OK";
                return json_encode($response);
            }
        }
        if ($this->db->sql_error()) {
            $response["message"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }

    }

    function getKatalogDetailByID($param){

        $query = "SELECT catalogs.ID, BIBID, Title, Author, Publisher, PublishLocation, PublishYear, Subject, PhysicalDescription, ISBN, CallNumber, CoverURL, (select count(collections.Catalog_id) from collections where Catalog_id = catalogs.ID and Status_id = 1) as Quantity FROM catalogs Where ID = {$param}";  

        $result = $this->db->query($query);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] =  "Data Buku - {$param}";
                $response["status"] = 1;
                $response["message"] = "Response Success";
                $response["data"] = null; // array()
                while ($row = $result->fetch_array()){
                    $data = null;
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
                    $data["quantity"]=$row["Quantity"];
                    // array_push($response["data"], $data);
                    $response["data"] = $data;
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["title"] = "Data Buku | `{$param}` Tidak Tersedia";
                $response["status"] = 0;
                $response["message"] = "Response OK";
                return json_encode($response);
            }
        }
        if ($this->db->sql_error()) {
            $response["message"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }  

    function getSearchKatalogs(){
        $param = $_GET['param'];
        $number_validation_regex = "/^\\d+$/"; 
        if($param == null){$param = " ";}
        if($param != null){
            if(strlen($param) == 4 && preg_match($number_validation_regex, $param)){
                $query = "SELECT catalogs.ID, BIBID, Title, Author, PublishYear, CoverURL, (select count(collections.Catalog_id) from collections where Catalog_id = catalogs.ID and Status_id = 1) as Quantity FROM catalogs WHERE catalogs.PublishYear = $param ORDER BY `catalogs`.`CoverURL` DESC";  
            }else{
                $query = "SELECT catalogs.ID, BIBID, Title, Author, PublishYear, CoverURL, (select count(collections.Catalog_id) from collections where Catalog_id = catalogs.ID and Status_id = 1) as Quantity FROM catalogs WHERE catalogs.Title LIKE '%$param%' ORDER BY `catalogs`.`CoverURL` DESC";  
            }
        }

        $result = $this->db->query($query);
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Buku Katalog";
                $response["status"] = 1;
                $response["message"] = "Response Success";
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
                $response["status"] = 0;
                $response["message"] = "Response OK";
                return json_encode($response);
            }
        }
        else {
            // no results found
                $response["title"] = "Data Buku Katalog Bercover Tidak Tersedia";
                $response["status"] = 0;
                $response["message"] = "Response OK";
                return json_encode($response);
        }
        if ($this->db->sql_error()) {
            $response["message"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }


}