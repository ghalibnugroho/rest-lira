<?php
namespace App\Controllers;

use App\Database\Database;
// include_once 'Database/Database.php';

Class Katalogs {
    
    function __construct(){
        echo "12423";
        $a = new Database(); 
    }

    // private $kon;
    // private $table = katalogs;

    // public function __construct(){
    //     $this->kon = new Database();
    // }

    function getAllKatalogs(){
        // $query = "SELECT ID, BIBID, Title, Author, Publisher, PublishLocation, PublishYear, Subject, PhysicalDescription, ISBN, CallNumber, CoverURL FROM " . $this->tabel . "";  

        // $result = $kon->query($query)->fetchAll();
      

        // return json_encode($result);
        echo "345566";
    }


}