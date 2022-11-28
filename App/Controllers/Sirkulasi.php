<?php
namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;

Class Sirkulasi{
    
    
    var $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getAllMembers(){

        // select max(id), member_id, max(CreateDate) from collectionloans group by Member_id;
        $query = "SELECT MemberNo, FullName, max(collectionloans.ID), collectionloans.Member_id, max(collectionloans.CreateDate) FROM `members` LEFT JOIN collectionloans on members.ID = collectionloans.Member_id GROUP by members.ID;";  
        $result = $this->db->query($query);

        // var_dump($result);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Anggota";
                $response["status"] = 1;
                $response["message"] = "Response Success";
                $response["data"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["memberNo"] = $row["MemberNo"];
                    $data["fullName"]=$row["FullName"];
                    array_push($response["data"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["title"] = "Data Anggota Tidak Tersedia";
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

    function getMemberByID($memberId){
        $query = "SELECT FullName, MemberNo, Email, Phone FROM members WHERE ID = {$memberId}";
        $result = $this->db->query($query);
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Anggota";
                $response["status"] = 1;
                $response["message"] = "Response Success";
                $response["data"] = null;
                while ($row = $result->fetch_array()){
                    $data = null;
                    $data["fullName"]=$row["FullName"];
                    $data["memberNo"]=$row["MemberNo"];
                    $data["email"]=$row["Email"];
                    $data["phone"]=$row["Phone"];
                    $response["data"] = $data;
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["title"] = "Data Anggota Tidak Tersedia";
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

    function getMemberCollectionLoans($memberNo){
        $query = "SELECT collectionloans.ID, collectionloans.CreateDate, collectionloans.CollectionCount FROM collectionloans join members on Member_id = members.ID WHERE members.MemberNo = {$memberNo}  ORDER BY `collectionloans`.`CreateDate` DESC";  
        $result = $this->db->query($query);

        // var_dump($result);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Anggota";
                $response["status"] = 1;
                $response["message"] = "Response Success";
                $response["data"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["id"] = $row["ID"];
                    $data["createdate"]=$row["CreateDate"];
                    $data["collectioncount"]=$row["CollectionCount"];
                    array_push($response["data"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["title"] = "Data Anggota Tidak Tersedia";
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
    
    /* 
    
    SELECT CollectionLoan_id, LoanDate, DueDate, ActualReturn, LoanStatus, catalogs.ID as Catalogs_id, Collection_id, collections.NomorBarcode, catalogs.Title, catalogs.Author, catalogs.PublishYear FROM collectionloanitems JOIN collections ON Collection_id = collections.ID JOIN catalogs ON collections.Catalog_id = catalogs.ID WHERE CollectionLoan_id = 122041200002 ORDER BY `collectionloanitems`.`CollectionLoan_id` DESC;

    SELECT members.Fullname, members.MemberNo, members.Email, members.Phone, CollectionLoan_id, LoanDate, DueDate, ActualReturn, LoanStatus, catalogs.ID as Catalogs_id, Collection_id, collections.NomorBarcode, catalogs.Title, catalogs.Author, catalogs.PublishYear FROM collectionloanitems JOIN collections ON Collection_id = collections.ID JOIN catalogs ON collections.Catalog_id = catalogs.ID JOIN members ON collectionloanitems.member_id = members.ID WHERE CollectionLoan_id = 122041200002 && members.id = collectionloanitems.member_id ORDER BY `collectionloanitems`.`CollectionLoan_id` DESC; 
    */

    function getMemberCollectionLoanItems($collectionLoan_id){

        $query = "SELECT members.Fullname, members.MemberNo, members.Email, members.Phone, CollectionLoan_id, LoanDate, DueDate, ActualReturn, LoanStatus, catalogs.ID as Catalogs_id, Collection_id, collections.NomorBarcode, catalogs.Title, catalogs.Author, catalogs.PublishYear, catalogs.CoverURL FROM collectionloanitems JOIN collections ON Collection_id = collections.ID JOIN catalogs ON collections.Catalog_id = catalogs.ID JOIN members ON collectionloanitems.member_id = members.ID WHERE CollectionLoan_id = {$collectionLoan_id} && members.id = collectionloanitems.member_id ORDER BY `collectionloanitems`.`CollectionLoan_id` DESC";  

        $result = $this->db->query($query);

        // var_dump($result);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Buku yang dipinjam anggota";
                $response["status"] = 1;
                $response["message"] = "Response Success";
                $response["data"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["fullname"]=$row["Fullname"];
                    $data["memberno"]=$row["MemberNo"];
                    $data["email"]=$row["Email"];
                    $data["phone"]=$row["Phone"];
                    $data["collectionloanid"] = $row["CollectionLoan_id"];
                    $data["loandate"]=$row["LoanDate"];
                    $data["duedate"]=$row["DueDate"];
                    $data["actualreturn"]=$row["ActualReturn"];
                    $data["loanstatus"]=$row["LoanStatus"];
                    $data["catalogsid"]=$row["Catalogs_id"];
                    $data["collectionid"]=$row["Collection_id"];
                    $data["nomorbarcode"]=$row["NomorBarcode"];
                    $data["title"]=$row["Title"];
                    $data["author"]=$row["Author"];
                    $data["publishyear"]=$row["PublishYear"];
                    $data["coverURL"]=$row["CoverURL"];
                    array_push($response["data"], $data);
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["title"] = "Data Buku yang dipinjam tidak ada";
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

    function getKatalogByKodeQR($kodeQR){

    }
}
