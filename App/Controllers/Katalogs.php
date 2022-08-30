<?php
namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;

Class Katalogs {

    var $db;
    var $response = array();

    public function __construct(){
        $this->db = new Database();
    }

    function getCoveredKatalogs(){

        $query = "SELECT ID, BIBID, Title, Author, PublishYear, CoverURL FROM catalogs where coverURL is NOT NULL";  

        $result = $this->db->query($query);
        
        if($result->num_rows > 0){
            if($result){
                $response["Title"] = "Data Buku Katalog Bercover";
                $response["success"] = http_response_code();
                $response["message"] = "Successfully Displayed";
                $response["data"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["id"] = $row["ID"];
                    $data["bibid"]=$row["BIBID"];
                    $data["title"]=$row["Title"];
                    $data["author"]=$row["Author"];
                    $data["publishYear"]=$row["PublishYear"];
                    $data["coverURL"]=$row["CoverURL"];
                    array_push($response["data"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["Title"] = "Data Buku Katalog Bercover Tidak Tersedia";
                $response["success"] = http_response_code();
                $response["message"] = "Try Again";
                return json_encode($response);
            }
        }
        else {
            // no results found
                $response["Title"] = "Data Buku Katalog Bercover Tidak Tersedia";
                $response["success"] = http_response_code();
                $response["message"] = "No Details Found";
                return json_encode($response);
        }

    }

    function getAllKatalogs(){

        $query = "SELECT ID, BIBID, Title, Author, PublishYear, CoverURL FROM catalogs";  

        $result = $this->db->query($query);
        
        if($result->num_rows > 0){
            if($result){
                $response["Title"] = "Data Buku Seluruh Katalog";
                $response["success"] = http_response_code();
                $response["message"] = "Successfully Displayed";
                $response["data"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["id"] = $row["ID"];
                    $data["bibid"]=$row["BIBID"];
                    $data["title"]=$row["Title"];
                    $data["author"]=$row["Author"];
                    $data["publishYear"]=$row["PublishYear"];
                    $data["coverURL"]=$row["CoverURL"];
                    array_push($response["data"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["Title"] = "Data Buku Seluruh Katalog Tidak Tersedia.";
                $response["success"] = http_response_code();
                $response["message"] = "Try Again";
                return json_encode($response);
            }
        }
        else {
            // no results found
                $response["Title"] = "Data Buku Seluruh Katalog Tidak Tersedia.";
                $response["success"] = http_response_code();
                $response["message"] = "No Details Found";
                return json_encode($response);
        }
        
    }

    function getDetailKatalogByID($param){
        $query = "SELECT ID, BIBID, Title, Author, Publisher, PublishLocation, PublishYear, Subject, PhysicalDescription, ISBN, CallNumber, CoverURL FROM catalogs Where ID = {$param}";  

        $result = $this->db->query($query);
        
        if($result->num_rows > 0){
            if($result){
                $response["Title"] =  "Data Buku - {$param}";
                $response["success"] = http_response_code();
                $response["message"] = "Successfully Displayed";
                $response["data"] = array();
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
                    array_push($response["data"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["Title"] = "Data Buku `{$param}` Tidak Tersedia";
                $response["success"] = http_response_code();
                $response["message"] = "Try Again";
                return json_encode($response);
            }
        }
        else {
            // no results found
                $response["Title"] = "Data Buku Tidak Tersedia";
                $response["success"] = http_response_code();
                $response["message"] = "No Details Found";
                return json_encode($response);
        }
    }


}