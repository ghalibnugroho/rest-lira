<?php
namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;
use DateTime;

class Presensi{
    var $db;

    public function __construct(){
        $this->db = new Database();
    }

    function getAllDaftarPresensi(){
        // select max(id), member_id, max(CreateDate) from collectionloans group by Member_id;
        $query = "SELECT MemberNo, FullName, presensi.create_date FROM `presensi` JOIN members on members.ID = presensi.member_id ORDER BY `presensi`.`create_date` DESC";  
        $result = $this->db->query($query);

        // var_dump($result);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Presensi Anggota";
                $response["status"] = 1;
                $response["message"] = "Response Success";
                $response["data"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["memberNo"] = $row["MemberNo"];
                    $data["fullName"]=$row["FullName"];
                    $data["createdate"]=$row["create_date"];
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

    function getPresensiByMemberNo($memberNo){
        $query = "SELECT MemberNo, FullName, presensi.create_date FROM `presensi` JOIN members on members.ID = presensi.member_id WHERE MemberNo = $memberNo ORDER BY `presensi`.`create_date` DESC"; 

        $result = $this->db->query($query);

        // var_dump($result);
        
        if($result->num_rows > 0){
            if($result){
                $response["title"] = "Data Presensi Anggota";
                $response["status"] = 1;
                $response["message"] = "Response Success";
                $response["data"] = array();
                while ($row = $result->fetch_array()){
                    $data = array();
                    $data["memberNo"] = $row["MemberNo"];
                    $data["fullName"]=$row["FullName"];
                    $data["createdate"]=$row["create_date"];
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

    function getDataAnggota($memberNo){
        $query = "SELECT MemberNo, Fullname, Sex_id, `Address`, Phone, InstitutionName FROM members WHERE members.MemberNo = $memberNo";
        $result = $this->db->query($query);

        if($result->num_rows > 0){
            if($result){
                while ($row = $result->fetch_array()){
                    $response["memberNo"] = $row["MemberNo"];
                    $response["fullName"] = $row["Fullname"];
                    $response["sexId"] = $row["Sex_id"];
                    $response["address"] = $row["Address"];
                    $response["phone"]=$row["Phone"];
                    $response["institution"]=$row["InstitutionName"];
                }
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["memberNo"] = "";
                $response["fullName"] = "";
                $response["sexId"] = "";
                $response["address"] = "";
                $response["phone"]="";
                $response["institution"]="";
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
        }
        else if($result->num_rows <= 0){
            $response["memberNo"] = "";
            $response["fullName"] = "";
            $response["sexId"] = "";
            $response["address"] = "";
            $response["phone"]="";
            $response["institution"]="";
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
        if ($this->db->sql_error()) {
            $response["message"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }

    }

    function presensiByMemberNo(){

        $memberNo = $_POST["memberNo"];
        $getMemberId = $this->getMemberIdByMemberNo($memberNo);

        // get current DateTime
        $datetime = new DateTime('Asia/Jakarta');
        $currentDateTimeSeconds = $datetime->format('Y-m-d H:i:s');

        $query="INSERT INTO Presensi (member_id, create_date) VALUES ('$getMemberId','$currentDateTimeSeconds')";
        $result=$this->db->query($query);

        $response["status"] = 1;
        $response["message"] = "Presensi Berhasil dilakukan";

        if ($this->db->sql_error()) {
            $response["database"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }

    function getMemberIdByMemberNo($memberNo){
        $query="SELECT ID FROM members WHERE MemberNo='$memberNo'";
        $result=$this->db->query($query);
        $getMemberNo=$result->fetch_array()["ID"];
        return $getMemberNo;
    }
}