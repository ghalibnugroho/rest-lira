<?php
// echo "A";
include("db_function.php");
// echo "B";
$response = array();
$result = getKatalog();
// var_dump($result);


// function getAllKatalog(){
    if(mysqli_num_rows($result) > 0){
            if($result){
                $response["success"] = 1;
                $response["message"] = "Successfully Displayed";
                $response["details"] = array();
                while ($row = mysqli_fetch_array($result)){
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
                    array_push($response["details"], $data);
                }
                echo json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else{
                $response["success"] = 0;
                $response["message"] = "Try Again";
                echo json_encode($response);
            }
    }
    else {
    // no results found
        $response["success"] = 0;
        $response["message"] = "No Details Found";
        echo json_encode($response);
    }
    if($db == true){
        mysqli_close($db); //Closing the Connection
    }
// }