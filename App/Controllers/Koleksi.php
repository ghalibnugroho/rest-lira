<?php 

namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;
use DateTime;

Class Koleksi{
    var $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getKoleksiKatalogById($id){

        $query = "SELECT catalogs.ID as KatalogID, catalogs.Title, collections.ID, NomorBarcode, collections.CallNumber, Status_id, TanggalPengadaan FROM collections join catalogs on catalogs.ID = collections.Catalog_id where Catalog_id = {$id};";  

        $result = $this->db->query($query);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] =  "Data koleksi Buku - {$id}";
                $response["status"] = 1;
                $response["message"] = "Response Success";
                $response["data"] = array(); // array()
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["catalogid"]=$row["KatalogID"];
                    $data["title"]=$row["Title"];
                    $data["collectionid"] = $row["ID"];
                    $data["nomorqrcode"]=$row["NomorBarcode"];
                    $data["callnumber"]=$row["CallNumber"];
                    $data["statusid"]=$row["Status_id"];
                    $data["tanggalPengadaan"]=$row["TanggalPengadaan"];
                    array_push($response["data"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["title"] = "Data koleksi Buku | `{$id}` Tidak Tersedia";
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

    function addKoleksiKatalog(){
        $katalogIdPOST = $_POST['katalogId'];
        $nomorQRCodePOST = $_POST['nomorQRCode'];
        $nomorKoleksiPOST = $_POST['nomorKoleksi'];
        
        // var_dump($_POST);

        //query check nomorQR dengan database
        $queryCheckQRCode = "SELECT NomorBarcode from collections WHERE NomorBarcode = '$nomorQRCodePOST' ";
        $resultQC1 = $this->db->query($queryCheckQRCode);

        // get time / currenttime from php || ('Y-m-d H:i:s')
        $datetime = new DateTime('Asia/Jakarta');
        $currentDateTime = $datetime->format('Y-m-d H:i:s');
        
        if($resultQC1->num_rows > 0){
            $response["status"] = 0;
            $response["message"] = "Nomor Koleksi/QR sudah terdaftar";
            return json_encode($response);
        }else{
            $query = "INSERT INTO collections (NomorBarcode, NoInduk, Currency, RFID, Price, TanggalPengadaan, CallNumber, Catalog_id, Partner_id, Location_id, Rule_id, Category_id, Media_id, Source_id, Status_id, Location_Library_id, CreateBy, CreateDate, UpdateDate, ISOPAC) values (
                '$nomorQRCodePOST', '$nomorQRCodePOST', 'IDR', '$nomorQRCodePOST', 0, '$currentDateTime', '$nomorKoleksiPOST', '$katalogIdPOST', 1104, 474, 1, 21, 2, 13, 1, 1, 50, '$currentDateTime', '$currentDateTime', 1
            )";  
    
            $result = $this->db->query($query);
            $response["status"] = 1;
            $response["message"] = "Tambah Koleksi Berhasil";
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
        
        if ($this->db->sql_error()) {
            $response["message"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }

    }

    function deleteKoleksi($collectionId){
        $query = "DELETE from collections WHERE collections.ID = {$collectionId}";
        
        // check availability parameter atau ID
        $queryCheck = "SELECT collections.ID from collections WHERE collections.ID = {$collectionId}";
        $resultCheck = $this->db->query($queryCheck);

        if($resultCheck->num_rows <= 0){
            $response["status"] = 0;
            $response["message"] = "Koleksi tidak ada / sudah terhapus";
            return json_encode($response);
        }else{
            $result = $this->db->query($query);
            $response["status"] = 1;
            $response["message"] = "Delete Koleksi Berhasil";
        }

        if ($this->db->sql_error()) {
            $response["message"] = "DB-Message ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }

    }

    function getKodeQR($kodeQR){

        $query = "SELECT NomorBarcode as KodeQR FROM collections WHERE NomorBarcode = {$kodeQR}";
        $result = $this->db->query($query);

        if($result->num_rows > 0){
            if($result){
                $response["status"] = 1;
                $response["message"] = "Response Success";
                while ($row = $result->fetch_array()){
                    $response["kodeQR"] = $row["KodeQR"];
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["status"] = 0;
                $response["message"] = "OK - Response No Data";
                return json_encode($response);
            }
        }else{
            $response["status"] = 0;
            $response["message"] = "OK - Response No Data";
            return json_encode($response);
        }
        if ($this->db->sql_error()) {
            $response["message"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
        
    }

}