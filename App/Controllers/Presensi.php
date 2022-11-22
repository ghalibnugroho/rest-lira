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

    }

    function getPresensiByMemberNo($memberNo){

    }
}