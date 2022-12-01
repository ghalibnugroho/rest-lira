<?php
namespace App\Controllers;
header('Content-type: Application/JSON');

use App\Database\Database;
use DateTime;
use DateTimeZone;
use Carbon\Carbon;

Class Sirkulasi{
    
    
    var $db;

    public function __construct(){
        $this->db = new Database();
        
    }

    // dashboard screen
    function getAllMembers(){

        $query = "SELECT MemberNo, FullName, max(collectionloans.ID), collectionloans.Member_id, max(collectionloans.CreateDate), (select count(LoanStatus) from collectionloanitems where collectionloanitems.member_id = collectionloans.Member_id && LoanStatus != 'Return') as Loan FROM `members` LEFT JOIN collectionloans on members.ID = collectionloans.Member_id GROUP by members.ID ORDER BY `max(collectionloans.CreateDate)` DESC";  
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
                    $data["memberNo"]=$row["MemberNo"];
                    $data["fullName"]=$row["FullName"];
                    $data["loan"]=$row["Loan"];
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
                    $data["createdate"]=Carbon::parse($row["CreateDate"])->format("d-m-Y H:i:s");
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

        $datetime = new DateTime('Asia/Jakarta');
        $currentDateTime = $datetime->format('dmy');

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
                    $data["loandate"]=Carbon::parse($row["LoanDate"])->format("d F Y");

                    // check duedate apakah sudah diperpanjang/extend atau belum
                        $collectionId=$row["Collection_id"];
                        $extendloanExist="SELECT CollectionLoanItem_id, DueDateExtend FROM collectionloanextends WHERE CollectionLoan_id='$collectionLoan_id' && Collection_id = '$collectionId'";
                        $getExtendLoanExist=$this->db->query($extendloanExist)->num_rows;
                        if($getExtendLoanExist>0){ // num_rows count
                            $getExtendLoanDueDate=$this->db->query($extendloanExist)->fetch_array()["DueDateExtend"];
                            // var_dump($getExtendLoanDueDate);
                            $data["duedate"]=Carbon::parse($getExtendLoanDueDate)->format("d F Y");
                            $data["isextended"]=1;
                        }else{
                            $data["duedate"]=Carbon::parse($row["DueDate"])->format("d F Y");
                            $data["isextended"]=0;
                        }
                    // check apakah sudah dikembalikan atau belum
                        if($row["ActualReturn"]==null){
                            $data["actualreturn"]=null;
                            $data["terlambat"]=0;
                        }else{
                            $data["actualreturn"]=Carbon::parse($row["ActualReturn"])->format("d F Y");
                            // setting jumlah keterlambatan
                            if(Carbon::create($data["actualreturn"])->diffInDays(Carbon::create($data["duedate"]), false)<0){
                                // var_dump(Carbon::create("15 December 2022")->diffInDays(Carbon::create($data["duedate"]), false));
                                $data["terlambat"]=Carbon::create($data["actualreturn"])->diffInDays(Carbon::create($data["duedate"]));
                            }else{
                                $data["terlambat"]=0;
                            }
                        }    

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

    // afterscan screen
    function getKatalogByKodeQR($kodeQR){
        $query = "SELECT catalogs.ID as KatalogID, Title, Author, PublishYear, Publisher, PublishLocation, CoverURL, collections.ID as CollectionsID, NomorBarcode, collections.CallNumber FROM catalogs JOIN collections ON catalogs.ID = collections.Catalog_id WHERE collections.NomorBarcode = {$kodeQR}";
        $result = $this->db->query($query);

        if($result->num_rows > 0){
            if($result){
                while($row = $result->fetch_array()){
                    $response["status"]=1;
                    $response["catalogid"]=$row["KatalogID"];
                    $response["title"]=$row["Title"];
                    $response["author"]=$row["Author"];
                    $response["publishYear"]=$row["PublishYear"];
                    $response["publisher"]=$row["Publisher"];
                    $response["publishLocation"]=$row["PublishLocation"];
                    $response["coverURL"]=$row["CoverURL"];
                    $response["collectionid"]=$row["CollectionsID"];
                    $response["nomorqrcode"]=$row["NomorBarcode"];
                    $response["callnumber"]=$row["CallNumber"];
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


    // anggota pinjam buku
    function addSirkulasiLoanAnggota(){

        // $katalogId = $_POST["katalogId"];
        $collectionId = $_POST["collectionId"];
        $memberNo = $_POST["memberNo"];

        // get current DateTime
        $datetime = new DateTime('Asia/Jakarta');
        $currentDateTime = $datetime->format('ymd');
        $currentDateTimeSeconds = $datetime->format('Y-m-d H:i:s');
        // var_dump($currentDateTimeSeconds);
        $datetimeLater = new DateTime("+7 days", new DateTimeZone('Asia/Jakarta'));
        $endDateTime = $datetimeLater->format('ymd');
        // var_dump($currentDateTime);
        // var_dump($endDateTime);

        /*
##########  Generate LoanID ##########
        */

        $loanId=$this->generateID();
        // var_dump($loanId);

        /*
##########  Insert Peminjaman Anggota ##########
        */

        // get memberId by memberNo
        $getMemberIdByMemberNo=$this->getMemberIdByMemberNo($memberNo);
        // get Max Loan ID By Member
        $getMaxLoanIdByMemberId=$this->getMaxLoanByMemberId($getMemberIdByMemberNo);
        $getMaxDayLoanMember=substr($getMaxLoanIdByMemberId, 1,6);

        $checkStatusCollection="SELECT Status_id FROM collections WHERE collections.ID='$collectionId'";
        $getStatusCollection=$this->db->query($checkStatusCollection);
        $status=(int)$getStatusCollection->fetch_array()['Status_id'];
        // var_dump($status);

        $checkStatusLoanMember="SELECT LoanStatus from collectionloanitems WHERE member_id = '$getMemberIdByMemberNo' && LoanStatus='Loaning'";
        $getLoanExist=$this->db->query($checkStatusLoanMember);

        // var_dump($getLoanExist);

        if($getLoanExist->num_rows > 0){
            $response["status"] = -1;
            $response["message"] = "Tidak bisa meminjam buku, kembalikan dahulu buku yang dipinjam";
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }else{
            if($status==5 || $status==7){
                $response["status"] = 0;
                $response["message"] = "Buku sedang/akan dipinjam";
                return json_encode($response, JSON_UNESCAPED_SLASHES);
            }
            else if($status==1){
                if($getMaxDayLoanMember==$currentDateTime){
                    // jika hari ini sudah pinjam
                    // input table loanItems, update tambah CollectionCount pada table collectionloans
        
                    $query1="INSERT INTO collectionloanitems(CollectionLoan_Id, LoanDate, DueDate, LoanStatus, Collection_id, member_id, CreateBy, CreateDate) VALUES('$getMaxLoanIdByMemberId', '$currentDateTimeSeconds', '$endDateTime', 'Waiting', '$collectionId','$getMemberIdByMemberNo', '50', '$currentDateTimeSeconds')";
                    $result1 = $this->db->query($query1);
        
                    $query2="SELECT count(CollectionLoan_id) as quantity FROM `collectionloanitems` where CollectionLoan_id='$getMaxLoanIdByMemberId'";
                    $result2=$this->db->query($query2);
                    $count=$result2->fetch_array()['quantity'];
                    // var_dump($count['quantity']);
        
                    $query3="UPDATE collectionloans SET CollectionCount='$count' WHERE ID = '$getMaxLoanIdByMemberId'";
        
                    $result3=$this->db->query($query3);
        
                    $query4="UPDATE collections SET Status_id='7' WHERE collections.ID='$collectionId'";
                    $result4=$this->db->query($query4);
                    
                    $response["status"] = 1;
                    $response["message"] = "Anggota Berhasil meminjam buku";
                    // $response["message2"] = "first if";
                    return json_encode($response, JSON_UNESCAPED_SLASHES);
                }
                else{
        
                    // hari ini belum pinjam
                    // input kedua tabel (loans dan loanItems)
        
                    $query1="INSERT INTO collectionloans(ID, CollectionCount, LateCount, ExtendCount, LoanCount, ReturnCount, Member_id, CreateBy, CreateDate, LocationLibrary_id) VALUES('$loanId', '1', '0', '0', '0','0','$getMemberIdByMemberNo', '50', '$currentDateTimeSeconds', '1')";
                    $result1 = $this->db->query($query1);
        
        
                    $query2="INSERT INTO collectionloanitems(CollectionLoan_Id, LoanDate, DueDate, LoanStatus, Collection_id, member_id, CreateBy, CreateDate) VALUES('$loanId', '$currentDateTimeSeconds', '$endDateTime', 'Waiting', '$collectionId','$getMemberIdByMemberNo', '50', '$currentDateTimeSeconds')";
                    $result2 = $this->db->query($query2);
        
                    $query3="UPDATE collections SET Status_id='7' WHERE collections.ID='$collectionId'";
                    $result3=$this->db->query($query3);
        
                    $response["status"] = 1;
                    $response["message"] = "Anggota Berhasil meminjam buku";
                    // $response["message2"] = "last Else";
                    return json_encode($response, JSON_UNESCAPED_SLASHES);
        
                }
            }
        }

        if ($this->db->sql_error()) {
            $response["message"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }

        // var_dump($_POST);

        // var_dump($loanId);
        // var_dump($currentDateTime);
        // var_dump($getMemberIdByMemberNo);
        // var_dump($getMaxId);
        // var_dump($getCurrentDayMaxId);
        // var_dump($getCurrentIndexMaxId);
        // var_dump(sprintf('%05d', $getCurrentIndexMaxId));
        // var_dump($getMaxLoanIdByMemberId);
        // var_dump($getMaxDayLoanMember);
        // var_dump($newId);
    }

    function generateID(){
        // get current DateTime
            $datetime = new DateTime('Asia/Jakarta');
            $currentDateTime = $datetime->format('ymd');

        // get Max ID from database
            $getMaxId=$this->getMaxLoanId();
        // split 2 side of Max ID (Day and Index) from database
            $getCurrentDayMaxId=substr($getMaxId,1,6);
            $getCurrentIndexMaxId=(int) substr($getMaxId,7,11);

        // getCurrentIndex before kalkulasi
            // var_dump($getCurrentIndexMaxId);

        // jika hari baru reset index di database
            if($currentDateTime > $getCurrentDayMaxId){
                if($getCurrentIndexMaxId != 1){
                    $getCurrentIndexMaxId = 1;
                }
            }else if($currentDateTime == $getCurrentDayMaxId){
                $getCurrentIndexMaxId += 1;
            }
        // ID baru telah di generate
            $newId=join("", array("1", $currentDateTime,sprintf('%05d', $getCurrentIndexMaxId)));
        
        return $newId;
    }

    function getMaxLoanId(){
        // get Max collectionLoan ID
        $maxID="SELECT max(collectionloans.ID) as maxId from collectionloans";
        $dbMaxId=$this->db->query($maxID);
        $getMaxId=$dbMaxId->fetch_array()["maxId"];
        return $getMaxId;
    }

    function getMaxLoanByMemberId($member_id){
        // get Max ID peminjaman anggota
        $maxLoanIdByMemberId="SELECT max(collectionloans.ID) as maxId from collectionloans WHERE Member_id = '$member_id'";
        $dbMaxLoanIdByMemberId=$this->db->query($maxLoanIdByMemberId);
        $getMaxLoanIdByMemberId=$dbMaxLoanIdByMemberId->fetch_array()["maxId"];
        return $getMaxLoanIdByMemberId;
    }

    function getMemberIdByMemberNo($memberNo){
        $query="SELECT ID FROM members WHERE MemberNo='$memberNo'";
        $result=$this->db->query($query);
        $getMemberNo=$result->fetch_array()["ID"];
        return $getMemberNo;
    }

    function validateLoan($collectionLoanId){

        $select="SELECT Collection_id from collectionloanitems where CollectionLoan_id = '$collectionLoanId'";
        $getCollectionId=$this->db->query($select);

        while($row = $getCollectionId->fetch_array()){
            $collectionId=$row["Collection_id"];
            $query="UPDATE collections SET Status_id='5' WHERE collections.ID='$collectionId'";
            $result=$this->db->query($query);
        }

        $query="UPDATE collectionloanitems SET LoanStatus='Loaning' WHERE collectionloanitems.CollectionLoan_id='$collectionLoanId'";
        $result=$this->db->query($query);

        $response["status"] = 1;
        $response["message"] = "Peminjaman berhasil di validasi";

        if ($this->db->sql_error()) {
            $response["database"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }

    function abortLoan($collectionLoanId){

        $select="SELECT Collection_id from collectionloanitems where CollectionLoan_id = '$collectionLoanId'";
        $getCollectionId=$this->db->query($select);

        while($row = $getCollectionId->fetch_array()){
            $collectionId=$row["Collection_id"];
            $query="UPDATE collections SET Status_id='1' WHERE collections.ID='$collectionId'";
            $result=$this->db->query($query);
        }

        $query="DELETE FROM `collectionloanitems` WHERE CollectionLoan_id = '$collectionLoanId'";
        $result=$this->db->query($query);

        $query="DELETE FROM `collectionloans` WHERE `collectionloans`.`ID` = '$collectionLoanId'";
        $result=$this->db->query($query);

        $response["status"] = 1;
        $response["message"] = "Peminjaman telah dibatalkan";

        if ($this->db->sql_error()) {
            $response["database"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }

    function finishLoan($collectionLoanId, $collectionId){

        $query="UPDATE collectionloanitems SET LoanStatus='Return' WHERE collectionloanitems.Collection_id='$collectionId' && collectionloanitems.CollectionLoan_id='$collectionLoanId'";
        $result=$this->db->query($query);

        $getCurrentDate=Carbon::now()->format("Y-m-d");
        // var_dump($getCurrentDate);

        $query="UPDATE collectionloanitems SET ActualReturn='$getCurrentDate' WHERE collectionloanitems.Collection_id='$collectionId' && collectionloanitems.CollectionLoan_id='$collectionLoanId'";
        $result=$this->db->query($query);

        $query="UPDATE collections SET Status_id='1' WHERE collections.ID='$collectionId'";
        $result=$this->db->query($query);

        $response["status"] = 1;
        $response["message"] = "Peminjaman telah diselesaikan";

        if ($this->db->sql_error()) {
            $response["database"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }
    }

    function extendLoan(){
        $collectionLoanId = $_POST["collectionLoanId"];
        $collectionId=$_POST['collectionId'];


        // get loanitemsId
        $loanItemsID="SELECT ID FROM collectionloanitems WHERE CollectionLoan_id = '$collectionLoanId' && Collection_id='$collectionId'";
        $getLoanItemsId=$this->db->query($loanItemsID)->fetch_array()["ID"];

        // var_dump($getLoanItemsId);

        // get member_id
        $memberId="SELECT member_id FROM collectionloanitems WHERE ID = '$getLoanItemsId'";
        $getMemberId=$this->db->query($memberId)->fetch_array()["member_id"];
        // var_dump($getMemberId);

        // get date & due date
        $dateSQL="SELECT LoanDate, DueDate FROM collectionloanitems WHERE ID='$getLoanItemsId'";
        $getDobleDate=$this->db->query($dateSQL)->fetch_array();
        // var_dump($getDobleDate);

        $getLoanDate=$getDobleDate[0];  // USE THIS DAtE FOR INPUT DATE EXTEND
        // var_dump($getLoanDate);
        $getDueDate=$getDobleDate[1];
        // var_dump($getDueDate);
        /*
            set tambah hari => 7 Days
        */
        $getExtendDate = Carbon::parse($getDueDate)->addDays(7)->format("Y-m-d"); 
        // var_dump($getExtendDate);

        $getCurrentDate=Carbon::now()->format("Y-m-d");
        // var_dump($getCurrentDate);

        $inputExtend="INSERT INTO collectionloanextends (CollectionLoan_id, CollectionLoanItem_id, Collection_id, Member_id, DateExtend , DueDateExtend, CreateBy, CreateDate) values('$collectionLoanId', '$getLoanItemsId', '$collectionId', '$getMemberId', '$getLoanDate', '$getExtendDate', '50', '$getCurrentDate')";
        $setInput=$this->db->query($inputExtend);

        $response["status"] = 1;
        $response["message"] = "Tanggal Peminjaman telah diperpanjang";

        if ($this->db->sql_error()) {
            $response["database"] = "DB-nya ".$this->db->sql_error();
            return json_encode($response, JSON_UNESCAPED_SLASHES);
        }

    }
    


}
