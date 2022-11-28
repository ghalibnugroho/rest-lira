<?php
namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use DateTime;
use DateTimeZone;

Class Autentikasi{

    var $db;
    var $key = '694983a061145497f6731f6b2acc65892bd6a37b'; //lira_mobile_app_api_key
    var $payload = [];

    public function __construct(){
        $this->db = new Database();
    }

    /*
        Fungsi login menggunakan hash sha1 pada password, Jika sukses akan mereturn JWT Token.
    */

    function login(){
        $emailPOST = $_POST['email'];
        $passwordPOST = sha1($_POST['password']);

        // var_dump($_POST);

        /*
            membuat query untuk melakukan pengecekan 2 tabel, membersonline dan users (petugas)
        */

        $queryAnggota = "SELECT Email, Password, NoAnggota from membersonline WHERE Email = '$emailPOST' && Password = '$passwordPOST'";  
        $queryPetugas = "SELECT EmailAddress, password, Fullname from users Where EmailAddress = '$emailPOST' && Password = '$passwordPOST'";
        
        // result query anggota
        $resultQA = $this->db->query($queryAnggota); 
        // result query petugas
        $resultQP = $this->db->query($queryPetugas); 
        
        // check kondisi hasil query apakah user tersedia, return JWT token.
        if($resultQA->num_rows > 0){
            $response["status"] = 1;
            $response["message"] = "Auth - Response Success";
            $response["token"] = null;
            while ($row = $resultQA->fetch_array()){
                $payload["identitas"] = $row["NoAnggota"];
                $payload["email"] = $row["Email"];
                $payload["role"] = 2;
                $jwt = JWT::encode($payload, $this->key, 'HS256');
                $response["token"] = $jwt;
            }
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
        else if($resultQP->num_rows > 0) {
            $response["status"] = 1;
            $response["message"] = "Auth - Response Success";
            $response["token"] = null;
            while ($row = $resultQP->fetch_array()){
                $payload["identitas"] = $row["Fullname"];
                $payload["email"] = $row["EmailAddress"];
                $payload["role"] = 1;
                $jwt = JWT::encode($payload, $this->key, 'HS256');
                $response["token"] = $jwt;
            }
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
        else{
            $response["status"] = 0;
            $response["message"] = "Email / Password Salah";
            $response["token"] = null;
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
        if ($this->db->sql_error()) {
            $response["message"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }

    function registrasi(){
        $emailPost = $_POST['email'];
        $passwordPost = sha1($_POST['password']);
        $jenisIdentitasPost = $_POST['jenis_identitas']; //value: 13 NIK / 14 Kartu Mahasiswa
        $nomorIdentitasPost = $_POST['no_identitas']; //value: nomor nik/nim
        $namaPost = $_POST['nama_lengkap']; //value: fullname / nama lengkap
        $jeniskelaminPost = $_POST['jenis_kelamin']; // value: 1 (laki-laki) & 2 (perempuan)
        $alamatPost = $_POST['alamat'];
        $noHpPost = $_POST['no_hp'];
        $institusiPost = $_POST['institusi'];

        if($jenisIdentitasPost === "KTP"){
            $jenisIdentitasPost = 13;
        }elseif($jenisIdentitasPost === "KTM"){
            $jenisIdentitasPost = 14;
        }

        if($jeniskelaminPost === "Pria"){
            $jeniskelaminPost = 1;
        }elseif($jeniskelaminPost === "Wanita"){
            $jeniskelaminPost = 2;
        }

        // var_dump($_POST);
        
        /*
            check keunikan email dan nik ke tabel members dan membersonline,
            input data atribut informasi ke members,
            input data atribut login ke membersonline
        */

        // query check tabel members - Apakah nomor identitas anggota lama?
        $Qcheck1 = "SELECT MemberNo, Email FROM members WHERE MemberNo = '$nomorIdentitasPost'";
        $resultQC1 = $this->db->query($Qcheck1);

        // query check tabel membersonline
        $Qcheck2 = "SELECT NoAnggota, Email FROM membersonline WHERE NoAnggota = '$nomorIdentitasPost'";
        $resultQC2 = $this->db->query($Qcheck2);

        // get time / currenttime from php
        $datetime = new DateTime('Asia/Jakarta');
        $currentDateTime = $datetime->format('Y-m-d H:i:s');
        // var_dump($currentDateTime);
        $datetimeLater = new DateTime("+10 years", new DateTimeZone('Asia/Jakarta'));
        $endDateTime = $datetimeLater->format('Y-m-d H:i:s');
        // var_dump($endDateTime);
        // var_dump(date('Y-m-d H:i:s'));

       // jika anggota lama 
        if($resultQC1->num_rows > 0){
            // jika sudah daftar
            if($resultQC2->num_rows > 0){
                $response["status"] = 0;
                $response["message"] = "Nomor Identitas telah terdaftar";
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            // anggota lama daftar akun online
            else{
                // insert into tabel membersonline
                $query = "INSERT INTO membersonline (NoAnggota, `Password`, Email, `Status`, CreateBy, CreateDate) values (
                    '$nomorIdentitasPost', '$passwordPost', '$emailPost', 'ACTIVE', '50', '$currentDateTime'
                )";
                $result = $this->db->query($query);
                $response["status"] = 1;
                $response["message"] = "Registrasi data berhasil dilakukan";
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
        }
        // bukan anggota lama insert into 2 tabel
        else{
            /*
                Insert tabel members
                JenisPermohonan_id = 1 (baru), StatusAnggota_id = 3(aktif), CreateBy = 50 (mobileapp), CreateDate = Timestamp
            */

            $query1 = "INSERT INTO members (MemberNo, Fullname, `Address`, AddressNow, Phone, InstitutionName, IdentityType_id, IdentityNo, Sex_id, RegisterDate, EndDate, Email, JenisPermohonan_id, StatusAnggota_id, CreateBy, CreateDate) values ('$nomorIdentitasPost', '$namaPost', '$alamatPost', '$alamatPost', '$noHpPost', '$institusiPost', '$jenisIdentitasPost', '$nomorIdentitasPost', '$jeniskelaminPost','$currentDateTime', '$endDateTime', '$emailPost', '1', '3', '50', '$currentDateTime')";
            $result1 = $this->db->query($query1);
            // $lastID1 = $this->db->lastInsertedID();

            /*
                Insert tabel membersonline
            */

            $query2 = "INSERT INTO membersonline (NoAnggota, `Password`, Email, `Status`, CreateBy, CreateDate) values ('$nomorIdentitasPost', '$passwordPost', '$emailPost', 'ACTIVE', '50', '$currentDateTime')";
            $result2 = $this->db->query($query2);
            // $lastID2 = $this->db->lastInsertedID();

            if($result1 && $result2 === TRUE){
                // var_dump($lastID1);
                // var_dump($lastID2);
                $response["status"] = 1;
                $response["message"] = "Registrasi data berhasil dilakukan";
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["status"] = 0;
                $response["message"] = "Terjadi Kesalahan pada registrasi";
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            if ($this->db->sql_error()) {
                $response["message"] = "DB-nya ".$this->db->sql_error();
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
        }
    }
}