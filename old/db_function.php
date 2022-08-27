<?php
include("db_config.php");

function getKatalog(){
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT ID, BIBID, Title, Author, Publisher, PublishLocation, PublishYear, Subject, PhysicalDescription, ISBN, CallNumber, CoverURL FROM catalogs") or die(mysqli_error($db));
    return $result;
    // echo json_encode($result);
}

// var_dump(getKatalog());