<?php
namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;

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

    }
}