<?php
error_reporting(0);
date_default_timezone_set("Asia/Manila");

//FUNCTIONS - ZIA
function connDB() {
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    // Check connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    else{
        return true;
    }
    mysqli_close($connection);
}

function authenticateUser($pUserID, $pUserPassword){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_HCI_PROFILE
                                  WHERE USER_ID = :pUserId COLLATE latin1_bin
                                    AND USER_PASSWORD = :pUserPass COLLATE latin1_bin");

        $stmt->bindParam(':pUserId', $pUserID);
        $stmt->bindParam(':pUserPass', $pUserPassword);

        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            session_start();
            $_SESSION['pHciNum']=$row['HCI_NO'];
            $_SESSION['pAccreNum']=$row['ACCRE_NO'];
            $_SESSION['pPmccNum']=$row['PMCC_NO'];
            $_SESSION['pEmrId']=$row['EMR_ID'];
            $_SESSION['pHospName']=$row['HOSP_NAME'];
            $_SESSION['pHospAddBrgy']=$row['HOSP_ADDBRGY'];
            $_SESSION['pHospAddMun']=$row['HOSP_ADDMUN'];
            $_SESSION['pHospAddProv']=$row['HOSP_ADDPROV'];
            $_SESSION['pHospAddRegion']=$row['HOSP_ADDREG'];
            $_SESSION['pHospAddLhio']=$row['HOSP_ADDLHIO'];
            $_SESSION['pHospSector']=$row['SECTOR'];
            $_SESSION['pHospZipCode']=$row['HOSP_ADDZIPCODE'];
            $_SESSION['pUserLname']=$row['USER_LNAME'];
            $_SESSION['pUserFname']=$row['USER_FNAME'];
            $_SESSION['pUserMname']=$row['USER_MNAME'];
            $_SESSION['pUserSuffix']=$row['USER_EXTNAME'];
            $_SESSION['pUserID']=$pUserID;
            $_SESSION['pUserPassword']=$pUserPassword;
            $_SESSION['user_is_logged_in'] = true;
            return true;
        }
        else {
            echo '<script type="text/javascript">alert("Invalid User ID/ Password!");window.location="index.php";</script>';
        }

    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function checkLogin() {
    session_start();
    if (!isset($_SESSION['user_is_logged_in']) || $_SESSION['user_is_logged_in'] != true){
        session_destroy();
        header("location:index.php");
        exit();
    }
}

/*SOAP LIBRARY LISTS*/
function listComplaint(){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_SYMPTOMS  
                                              WHERE LIB_STAT = '1' 
                                                AND SYMPTOMS_ID NOT IN('X')
                                                ORDER BY SYMPTOMS_DESC ASC");

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function listHeent(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_HEENT
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $heent[] = $row;
    }

    return $heent;
    mysqli_close($connection);
}

function listChest(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_CHEST
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $chest[] = $row;
    }

    return $chest;
    mysqli_close($connection);
}

function listHeart(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_HEART
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $heart[] = $row;
    }

    return $heart;
    mysqli_close($connection);
}

function listAbdomen(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_ABDOMEN
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $abdomen[] = $row;
    }

    return $abdomen;
    mysqli_close($connection);
}

function listExtremities(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_EXTREMITIES
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $extremities[] = $row;
    }

    return $extremities;
    mysqli_close($connection);
}

function listNeuro(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_NEURO
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $neuro[] = $row;
    }

    return $neuro;
    mysqli_close($connection);
}

function listGenitourinary(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_GENITOURINARY
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $gu[] = $row;
    }

    return $gu;
    mysqli_close($connection);
}

function listDigitalRectal(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_DIGITAL_RECTAL
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $digital[] = $row;
    }

    return $digital;
    mysqli_close($connection);
}

function listSkinExtremities(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_SKIN_EXTREMITIES
                  WHERE LIB_STAT = "1"
                  ORDER BY SORT_NO ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $skin[] = $row;
    }

    return $skin;
    mysqli_close($connection);
}


/*Address Library*/
function listProvince(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT PROCODE, PROVINCE, AREACODE, LHIO,
                     CASE 
                          WHEN PROVINCE = '74' THEN 'NCR, SECOND DISTRICT'
                          WHEN PROVINCE = '75' THEN 'NCR, THIRD DISTRICT'
                          WHEN PROVINCE = '76' THEN 'NCR, FOURTH DISTRICT'
                          WHEN PROVINCE = '82' THEN 'NCR, FIFTH DISTRICT'
                          WHEN PROVINCE = '83' THEN 'NCR, SIXTH DISTRICT'
                          ELSE PROV_NAME
                      END AS PROV_NAME
                FROM ".$ini['EPCB'].".LIB_PROVINCE
                  ORDER BY PROV_NAME ASC";

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $data[] = $row;
    }

    return $data;
    mysqli_close($connection);
}




function getMunicipality($pProvCode){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".LIB_MUNICIPALITY  WHERE PROVINCE = :provCode ORDER BY MUN_NAME ASC");

        $stmt->bindParam(':provCode', $pProvCode);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function getBarangay($pMunCode, $pProvCode){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * 
                                            FROM ".$ini['EPCB'].".LIB_BARANGAY  
                                                WHERE MUNICIPALITY = :munCode 
                                                  AND PROVINCE = :provCode
                                                    ORDER BY BRGY_NAME ASC");

        $stmt->bindParam(':munCode', $pMunCode);
        $stmt->bindParam(':provCode', $pProvCode);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function getRegionLhio($pProvCode){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".LIB_PROVINCE  WHERE PROVINCE = :provCode");

        $stmt->bindParam(':provCode', $pProvCode);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function getZipCode($pMunCode, $pProvCode){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                            FROM ".$ini['EPCB'].".LIB_ZIPCODE
                                                WHERE MUNICIPALITY = :munCode
                                                  AND PROVINCE = :provCode");

        $stmt->bindParam(':munCode', $pMunCode);
        $stmt->bindParam(':provCode', $pProvCode);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}


function listDrugsDesc(){
    $ini = parse_ini_file("config.ini");
    $connection = mysqli_connect($ini['DBSERVER'], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = 'SELECT *
                FROM '.$ini["EPCB"].'.TSEKAP_LIB_MEDICINE
                  ORDER BY DRUG_DESC ASC';

    $result = mysqli_query( $connection, $query);

    if(!$result ) {
        die('Could not get data: ' . mysqli_error());
    }

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $drugs[] = $row;
    }

    return $drugs;
    mysqli_close($connection);
}


/*GET CONSULTATION RECORD TO VIEW, EDIT, UPDATE*/
function getPatientConsultationRecord($pSoapTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.*, soap.CASE_NO, soap.TRANS_NO, soap.SOAP_OTP
                                            FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist /*PATIENT INFO*/
                                                INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS soap ON enlist.CASE_NO = soap.CASE_NO /*CONSULTATION INFO*/
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_SUBJECTIVE AS subjective ON soap.TRANS_NO = subjective.TRANS_NO /*SUBJECTIVE/ HISTORY OF ILLNESS*/
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_PEPERT AS pepert ON soap.TRANS_NO = pepert.TRANS_NO /*OBJECTIVE/PHYSICAL EXAMINATION */
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_PESPECIFIC AS pespecific ON soap.TRANS_NO = pespecific.TRANS_NO /*OBJECTIVE/PHYSICAL EXAMINATION - REMARKS */
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_ADVICE AS advice ON soap.TRANS_NO = advice.TRANS_NO /*PLAN/MANAGEMENT - ADVICE*/                                
                                                    WHERE soap.TRANS_NO = :pxTransNo
                                                      AND soap.UPD_CNT = :updCnt
                                                      AND subjective.UPD_CNT = :updCnt
                                                      AND pepert.UPD_CNT = :updCnt
                                                      AND pespecific.UPD_CNT = :updCnt
                                                      AND advice.UPD_CNT = :updCnt");

        $stmt->bindParam(':pxTransNo', $pSoapTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result[0];

}

/*GET PROFILING RECORD - PATIENT'S HSA RECORD*/
function getPatientHsaList($pHsaCaseNo){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT CASE_NO, TRANS_NO, PROF_DATE, PROF_BY, EFF_YEAR, PX_PIN FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE  WHERE CASE_NO = :caseNo");

        $stmt->bindParam(':caseNo', $pHsaCaseNo);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}



/*GET CONSULTATION RECORD - ASSESSMENT/DIAGNOSIS TO VIEW, EDIT, UPDATE*/
function getPatientAssessmentRecord($pSoapTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, libIcd.ICD_DESC, libIcd.ICD_CODE                       
                            FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS soap 
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_ICD AS icd ON soap.TRANS_NO = icd.TRANS_NO
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_LIB_ICD AS libIcd ON icd.ICD_CODE = libIcd.ICD_CODE
                                    WHERE soap.TRANS_NO = :pxTransNo
                                      AND soap.UPD_CNT = :updCnt
                                      AND icd.UPD_CNT = :updCnt");

        $stmt->bindParam(':pxTransNo', $pSoapTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*GET CONSULTATION RECORD - PLAN/MANAGEMENT - DIAGNOSTIC EXAMINATION  TO VIEW, EDIT, UPDATE*/
function getPatientDiagnosticRecord($pSoapTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *                       
                            FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS soap 
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC AS diagnostic ON soap.TRANS_NO = diagnostic.TRANS_NO
                                    WHERE soap.TRANS_NO = :pxTransNo
                                      AND soap.UPD_CNT = :updCnt
                                      AND diagnostic.UPD_CNT = :updCnt");

        $stmt->bindParam(':pxTransNo', $pSoapTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*GET CONSULTATION RECORD - PLAN/MANAGEMENT - MANAGEMENENT  TO VIEW, EDIT, UPDATE*/
function getPatientManagementRecord($pSoapTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *                       
                            FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS soap 
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MANAGEMENT AS management ON soap.TRANS_NO = management.TRANS_NO
                                    WHERE soap.TRANS_NO = :pxTransNo
                                      AND soap.UPD_CNT = :updCnt
                                      AND management.UPD_CNT = :updCnt");

        $stmt->bindParam(':pxTransNo', $pSoapTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*GET CONSULTATION RECORD - OBLIGATED SERVICE TO VIEW, EDIT, UPDATE*/
function getPatientObligatedServiceRecord($pSoapTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *                       
                            FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS soap 
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_OBLIGATED AS obligated ON soap.TRANS_NO = obligated.TRANS_NO
                                    WHERE soap.TRANS_NO = :pxTransNo
                                      AND soap.UPD_CNT = :updCnt
                                      AND obligated.UPD_CNT = :updCnt");

        $stmt->bindParam(':pxTransNo', $pSoapTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*GET CONSULTATION RECORD - MEDICINE TO VIEW, EDIT, UPDATE*/
function getPatientSoapMedicine($pSoapTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *                       
                            FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS soap 
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_MEDICINE AS meds ON soap.TRANS_NO = meds.TRANS_NO
                                    WHERE soap.TRANS_NO = :pxTransNo
                                      AND soap.UPD_CNT = :updCnt
                                      AND meds.TRANS_NO = :pxTransNo
                                      AND meds.UPD_CNT = :updCnt");

        $stmt->bindParam(':pxTransNo', $pSoapTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function getMeds($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDICINE
                                            WHERE DRUG_CODE = :drugCode
                                            ORDER BY DRUG_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getMedsSalt($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDICINE
                                            WHERE GEN_CODE = :drugCode
                                            GROUP BY SALT_CODE                                            
                                            ORDER BY GEN_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getMedsUnit($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDICINE
                                            WHERE GEN_CODE = :drugCode
                                            GROUP BY UNIT_CODE                                            
                                            ORDER BY GEN_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getMedsCopay($code){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDS_COPAYMENT
                                            WHERE DRUG_CODE = :drugCode");

        $stmt->bindParam(':drugCode', $code);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getMedsStrength($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDICINE
                                            WHERE GEN_CODE = :drugCode
                                            GROUP BY STRENGTH_CODE                                            
                                            ORDER BY GEN_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getMedsForm($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDICINE
                                            WHERE GEN_CODE = :drugCode
                                            GROUP BY FORM_CODE                                            
                                            ORDER BY GEN_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getMedsPackage($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDICINE
                                            WHERE GEN_CODE = :drugCode
                                            GROUP BY PACKAGE_CODE                                            
                                            ORDER BY GEN_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function descMedsSalt($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDS_SALT
                                            WHERE SALT_CODE = :drugCode 
                                            ORDER BY SALT_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function descMedsUnit($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDS_UNIT
                                            WHERE UNIT_CODE = :drugCode 
                                            ORDER BY UNIT_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}
function descMedsGeneric($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDS_GENERIC
                                            WHERE GEN_CODE = :drugCode 
                                            ORDER BY GEN_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}
function descMedsStrength($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDS_STRENGTH
                                            WHERE STRENGTH_CODE = :drugCode 
                                            ORDER BY STRENGTH_CODE ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function descMedsForm($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDS_FORM
                                            WHERE FORM_CODE = :drugCode 
                                            ORDER BY FORM_DESC ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function descMedsPackage($pMeds){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_LIB_MEDS_PACKAGE
                                            WHERE PACKAGE_CODE = :drugCode 
                                            ORDER BY PACKAGE_DESC ASC");

        $stmt->bindParam(':drugCode', $pMeds);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

//Describe Obligated Service
function describeObligatedService($serviceID){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *       
                            FROM ".$ini['EPCB'].".TSEKAP_LIB_OBLIGATED
                              WHERE SERVICE_ID = :pServiceId");

        $stmt->bindParam(':pServiceId', $serviceID);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

//Describe Obligated Service - Waived Reason
function describeWaivedReason($pReasonID){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *       
                            FROM ".$ini['EPCB'].".TSEKAP_LIB_WAIVED_REASON
                              WHERE REASON_ID = :pReasonId");

        $stmt->bindParam(':pReasonId', $pReasonID);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

//Describe Diagnostic Laboratory Results
function describeLabResults($pDiagnosticID){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *       
                            FROM ".$ini['EPCB'].".TSEKAP_LIB_DIAGNOSTIC
                              WHERE DIAGNOSTIC_ID = :pDiagID");

        $stmt->bindParam(':pDiagID', $pDiagnosticID);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

//Describe Province Address
function describeProvinceAddress($pProviceAddress){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *       
                            FROM ".$ini['EPCB'].".LIB_PROVINCE
                              WHERE PROVINCE = :provinceCode");

        $stmt->bindParam(':provinceCode', $pProviceAddress);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

//Describe Municipality Address
function describeMunicipalityAddress($pMunicipalityAddress, $pProvinceAddress){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *       
                            FROM ".$ini['EPCB'].".LIB_MUNICIPALITY
                              WHERE MUNICIPALITY = :municipalityCode
                                AND PROVINCE = :provinceCode");

        $stmt->bindParam(':municipalityCode', $pMunicipalityAddress);
        $stmt->bindParam(':provinceCode', $pProvinceAddress);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

//Describe Barangay Address
function describeBarangayAddress($pBarangayAddress,$MunicipalityAddress, $ProvinceAddress){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *       
                            FROM ".$ini['EPCB'].".LIB_BARANGAY
                              WHERE BARANGAY = :brgyCode
                                AND MUNICIPALITY =  :munCode
                                AND PROVINCE =  :provCode");

        $stmt->bindParam(':brgyCode', $pBarangayAddress);
        $stmt->bindParam(':munCode', $MunicipalityAddress);
        $stmt->bindParam(':provCode', $ProvinceAddress);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

//Generate Reports
function generateReport($pReportType,$pPxType,$pFromDate,$pToDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $date_format = "%m/%d/%Y";
        $search_format = "%Y-%m-%d";
        $fromdate=date('Y-m-d', strtotime($pFromDate));
        $todate=date('Y-m-d', strtotime($pToDate));

        if(!empty($pReportType) && !empty($pPxType) && !empty($pFromDate) && !empty($pToDate)){
            switch($pReportType){
                //Registered
                case '1':
                    switch($pPxType){
                        case 'All':
                            $stmt = $conn->prepare("SELECT CASE_NO, TRANS_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, 
                                                              DATE_FORMAT(TRANS_DATE, :DATE_FORMAT) AS TRANS_DATE, 
                                                              CASE PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                                                  WHERE PX_TYPE IN ('MM','DD')
                                                                        AND TRANS_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'MM':
                            $stmt = $conn->prepare("SELECT CASE_NO, TRANS_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, 
                                                              DATE_FORMAT(TRANS_DATE, :DATE_FORMAT) AS TRANS_DATE, 
                                                              CASE PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                                                  WHERE PX_TYPE LIKE 'MM'
                                                                    AND TRANS_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'DD':
                            $stmt = $conn->prepare("SELECT CASE_NO, TRANS_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, 
                                                              DATE_FORMAT(TRANS_DATE, :DATE_FORMAT) AS TRANS_DATE, 
                                                              CASE PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                                                  WHERE PX_TYPE LIKE 'DD'
                                                                    AND TRANS_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        default:
                            echo 'No record found!';
                    }
                    break;
                //Screened and Assessed
                case '2':
                    switch($pPxType){
                        case 'All':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              PROFILE.CASE_NO, DATE_FORMAT(PROFILE.PROF_DATE, :DATE_FORMAT) AS PROF_DATE 
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS PROFILE ON PROFILE.CASE_NO = ENLIST.CASE_NO
                                                                    WHERE ENLIST.PX_TYPE IN ('MM','DD')
                                                                        AND PROFILE.PROF_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'MM':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              PROFILE.CASE_NO, DATE_FORMAT(PROFILE.PROF_DATE, :DATE_FORMAT) AS PROF_DATE 
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS PROFILE ON PROFILE.CASE_NO = ENLIST.CASE_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'MM'
                                                                    AND PROFILE.PROF_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'DD':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              PROFILE.CASE_NO, DATE_FORMAT(PROFILE.PROF_DATE, :DATE_FORMAT) AS PROF_DATE 
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS PROFILE ON PROFILE.CASE_NO = ENLIST.CASE_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'DD'
                                                                    AND PROFILE.PROF_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        default:
                            echo 'No record found!';
                    }
                    break;
                //Consulted
                case '3':
                    switch($pPxType){
                        case 'All':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE 
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    WHERE ENLIST.PX_TYPE IN ('MM','DD')
                                                                        AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'MM':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE 
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'MM'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'DD':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE 
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'DD'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        default:
                            echo 'No record found!';
                    }
                    break;
                //Services Provided
                case '4':
                    switch($pPxType){
                        case 'All':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE,
                                                              OBLIGATED.TRANS_NO, OBLIGATED.SERVICE_ID, OBLIGATED.REASON_ID, OBLIGATED.REMARKS, OBLIGATED.SERVICE_VALUE, OBLIGATED.BP_TYPE
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_OBLIGATED AS OBLIGATED ON OBLIGATED.TRANS_NO = SOAP.TRANS_NO
                                                                    WHERE ENLIST.PX_TYPE IN ('MM','DD')
                                                                        AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                        GROUP BY OBLIGATED.TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'MM':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE,
                                                              OBLIGATED.TRANS_NO, OBLIGATED.SERVICE_ID, OBLIGATED.REASON_ID, OBLIGATED.REMARKS, OBLIGATED.SERVICE_VALUE, OBLIGATED.BP_TYPE 
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_OBLIGATED AS OBLIGATED ON OBLIGATED.TRANS_NO = SOAP.TRANS_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'MM'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                    GROUP BY OBLIGATED.TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'DD':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE,
                                                              OBLIGATED.TRANS_NO, OBLIGATED.SERVICE_ID, OBLIGATED.REASON_ID, OBLIGATED.REMARKS, OBLIGATED.SERVICE_VALUE, OBLIGATED.BP_TYPE 
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_OBLIGATED AS OBLIGATED ON OBLIGATED.TRANS_NO = SOAP.TRANS_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'DD'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                    GROUP BY OBLIGATED.TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        default:
                            echo 'No record found!';
                    }
                    break;

                //Laboratories
                case '5':
                    switch($pPxType){
                        case 'All':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE,
                                                              CBC.*, URINE.*, FECALYSIS.*, XRAY.*, SPUTUM.*, LIPIDPROF.*, FBS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CBC AS CBC ON SOAP.TRANS_NO = CBC.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_URINALYSIS AS URINE ON SOAP.TRANS_NO = URINE.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FECALYSIS AS FECALYSIS ON SOAP.TRANS_NO = FECALYSIS.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CHESTXRAY AS XRAY ON SOAP.TRANS_NO = XRAY.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_SPUTUM AS SPUTUM ON SOAP.TRANS_NO = SPUTUM.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_LIPIDPROF AS LIPIDPROF ON SOAP.TRANS_NO = LIPIDPROF.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FBS AS FBS ON SOAP.TRANS_NO = FBS.TRANS_NO
                                                                    WHERE ENLIST.PX_TYPE IN ('MM','DD')
                                                                        AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'MM':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE,
                                                              CBC.*, URINE.*, FECALYSIS.*, XRAY.*, SPUTUM.*, LIPIDPROF.*, FBS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CBC AS CBC ON SOAP.TRANS_NO = CBC.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_URINALYSIS AS URINE ON SOAP.TRANS_NO = URINE.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FECALYSIS AS FECALYSIS ON SOAP.TRANS_NO = FECALYSIS.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CHESTXRAY AS XRAY ON SOAP.TRANS_NO = XRAY.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_SPUTUM AS SPUTUM ON SOAP.TRANS_NO = SPUTUM.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_LIPIDPROF AS LIPIDPROF ON SOAP.TRANS_NO = LIPIDPROF.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FBS AS FBS ON SOAP.TRANS_NO = FBS.TRANS_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'MM'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'DD':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE,
                                                              CBC.*, URINE.*, FECALYSIS.*, XRAY.*, SPUTUM.*, LIPIDPROF.*, FBS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CBC AS CBC ON SOAP.TRANS_NO = CBC.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_URINALYSIS AS URINE ON SOAP.TRANS_NO = URINE.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FECALYSIS AS FECALYSIS ON SOAP.TRANS_NO = FECALYSIS.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CHESTXRAY AS XRAY ON SOAP.TRANS_NO = XRAY.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_SPUTUM AS SPUTUM ON SOAP.TRANS_NO = SPUTUM.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_LIPIDPROF AS LIPIDPROF ON SOAP.TRANS_NO = LIPIDPROF.TRANS_NO
                                                                    LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FBS AS FBS ON SOAP.TRANS_NO = FBS.TRANS_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'DD'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        default:
                            echo 'No record found!';
                    }
                    break;
                //Prescribed Drugs
                case '6':
                    switch($pPxType){
                        case 'All':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, MEDS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MEDS AS MEDS ON MEDS.TRANS_NO = SOAP.TRANS_NO
                                                                    WHERE ENLIST.PX_TYPE IN ('MM','DD')
                                                                        AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                        AND IS_DISPENSED_MEDS = 'NO'
                                                                            GROUP BY TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'MM':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, MEDS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MEDS AS MEDS ON MEDS.TRANS_NO = SOAP.TRANS_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'MM'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                    AND IS_DISPENSED_MEDS = 'NO'
                                                                      GROUP BY TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'DD':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, MEDS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MEDS AS MEDS ON MEDS.TRANS_NO = SOAP.TRANS_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'DD'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                    AND IS_DISPENSED_MEDS = 'NO'
                                                                        GROUP BY TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        default:
                            echo 'No record found!';
                    }
                    break;

                //Dispensed Drugs
                case '7':
                    switch($pPxType){
                        case 'All':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, MEDS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MEDS AS MEDS ON MEDS.TRANS_NO = SOAP.TRANS_NO
                                                                    WHERE ENLIST.PX_TYPE IN ('MM','DD')
                                                                        AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                        AND IS_DISPENSED_MEDS = 'YES'
                                                                            GROUP BY TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'MM':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, MEDS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MEDS AS MEDS ON MEDS.TRANS_NO = SOAP.TRANS_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'MM'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                    AND IS_DISPENSED_MEDS = 'YES'
                                                                      GROUP BY TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        case 'DD':
                            $stmt = $conn->prepare("SELECT ENLIST.CASE_NO, ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, 
                                                              CASE ENLIST.PX_TYPE
                                                                WHEN 'MM' THEN 'MEMBER'
                                                                WHEN 'DD' THEN 'DEPENDENT'
                                                                WHEN 'NM' THEN 'NON-MEMBER'
                                                                ELSE '-'
                                                              END PX_TYPE, 
                                                              ENLIST.EFF_YEAR,
                                                              SOAP.CASE_NO, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, MEDS.*
                                                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON SOAP.CASE_NO = ENLIST.CASE_NO
                                                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MEDS AS MEDS ON MEDS.TRANS_NO = SOAP.TRANS_NO
                                                                  WHERE ENLIST.PX_TYPE LIKE 'DD'
                                                                    AND SOAP.SOAP_DATE BETWEEN STR_TO_DATE(:fromDate, :SEARCH_FORMAT) AND STR_TO_DATE(:toDate, :SEARCH_FORMAT)
                                                                    AND IS_DISPENSED_MEDS = 'YES'
                                                                        GROUP BY TRANS_NO");

                            $stmt->bindParam(':DATE_FORMAT', $date_format);
                            $stmt->bindParam(':SEARCH_FORMAT', $search_format);
                            $stmt->bindParam(':fromDate', $fromdate);
                            $stmt->bindParam(':toDate', $todate);
                            break;
                        default:
                            echo 'No record found!';
                    }
                    break;

                default:
                    echo 'No record found!';
            }

        }

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

//Search Feature used in Enlistment/Registration, Consultation, Profiling/Health Screening & Assessment Search Module
function searchClientResult($pPIN, $pLastName, $pFirstName, $pMiddleName, $pSuffix, $pDateOfBirth, $pModule){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $date_format = "%m/%d/%Y";
        $current_Year = date('Y');

        if(isset($_GET['pPIN']) && !empty($_GET['pPIN'])){
            $stmt = $conn->prepare("SELECT CLAIM_ID, CASE_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, DATE_FORMAT(PX_DOB, :DATE_FORMAT) AS PX_DOB, PX_TYPE, EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                  WHERE PX_PIN LIKE :pxPin
                                    AND XPS_MODULE LIKE :xpsMod");

            $stmt->bindParam(':pxPin', $pPIN);
            $stmt->bindParam(':DATE_FORMAT', $date_format);
            $stmt->bindParam(':xpsMod', $pModule);
        }

        if(isset($_GET['pPIN']) && !empty($_GET['pPIN']) AND isset($_GET['pDateOfBirth']) && !empty($_GET['pDateOfBirth'])){
            $stmt = $conn->prepare("SELECT CLAIM_ID, CASE_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, DATE_FORMAT(PX_DOB, :DATE_FORMAT) AS PX_DOB, PX_TYPE, EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                  WHERE PX_PIN LIKE :pxPin
                                      AND PX_DOB LIKE :pxDob
                                      AND XPS_MODULE LIKE :xpsMod");

            $stmt->bindParam(':pxPin', $pPIN);
            $stmt->bindParam(':pxDob', date('Y-m-d', strtotime($pDateOfBirth)));
            $stmt->bindParam(':DATE_FORMAT', $date_format);
            $stmt->bindParam(':xpsMod', $pModule);
        }

        if(isset($_GET['pLastName']) && !empty($_GET['pLastName']) AND isset($_GET['pFirstName']) && !empty($_GET['pFirstName'])){
            $stmt = $conn->prepare("SELECT CLAIM_ID, CASE_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, DATE_FORMAT(PX_DOB, :DATE_FORMAT) AS PX_DOB, PX_TYPE, EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                  WHERE PX_LNAME LIKE :pxLname
                                    AND PX_FNAME LIKE :pxFname
                                    AND XPS_MODULE LIKE :xpsMod
                                    ORDER BY TRANS_NO ASC");

            $stmt->bindParam(':pxLname', $pLastName);
            $stmt->bindParam(':pxFname', $pFirstName);
            $stmt->bindParam(':DATE_FORMAT', $date_format);
            $stmt->bindParam(':xpsMod', $pModule);
        }

        if(isset($_GET['pLastName']) && !empty($_GET['pLastName']) && isset($_GET['pFirstName']) && !empty($_GET['pFirstName']) && isset($_GET['pDateOfBirth']) && !empty($_GET['pDateOfBirth'])){
            $stmt = $conn->prepare("SELECT CLAIM_ID, CASE_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, DATE_FORMAT(PX_DOB, :DATE_FORMAT) AS PX_DOB, PX_TYPE, EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                  WHERE PX_LNAME LIKE :pxLname
                                    AND PX_FNAME LIKE :pxFname
                                    AND PX_DOB LIKE :pxDob
                                    AND XPS_MODULE LIKE :xpsMod
                                    ORDER BY TRANS_NO ASC");

            $stmt->bindParam(':pxLname', $pLastName);
            $stmt->bindParam(':pxFname', $pFirstName);
            $stmt->bindParam(':pxDob', date('Y-m-d', strtotime($pDateOfBirth)));
            $stmt->bindParam(':DATE_FORMAT', $date_format);
            $stmt->bindParam(':xpsMod', $pModule);
        }

        if(isset($_GET['pPIN']) && !empty($_GET['pPIN']) AND isset($_GET['pLastName']) && !empty($_GET['pLastName']) AND isset($_GET['pFirstName']) && !empty($_GET['pFirstName'])){
            $stmt = $conn->prepare("SELECT CLAIM_ID, CASE_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, DATE_FORMAT(PX_DOB, :DATE_FORMAT) AS PX_DOB, PX_TYPE, EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                  WHERE PX_PIN LIKE :pxPin
                                    AND PX_LNAME LIKE :pxLname
                                    AND PX_FNAME LIKE :pxFname
                                    AND XPS_MODULE LIKE :xpsMod
                                    ORDER BY TRANS_NO ASC");

            $stmt->bindParam(':pxPin', $pPIN);
            $stmt->bindParam(':pxLname', $pLastName);
            $stmt->bindParam(':pxFname', $pFirstName);
            $stmt->bindParam(':DATE_FORMAT', $date_format);
            $stmt->bindParam(':xpsMod', $pModule);
        }

        if(isset($_GET['pLastName']) && !empty($_GET['pLastName']) AND isset($_GET['pFirstName']) && !empty($_GET['pFirstName']) AND isset($_GET['pMiddleName']) && !empty($_GET['pMiddleName']) AND isset($_GET['pSuffix']) && !empty($_GET['pSuffix'])){
            $stmt = $conn->prepare("SELECT CLAIM_ID, CASE_NO, PX_PIN, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, DATE_FORMAT(PX_DOB, :DATE_FORMAT) AS PX_DOB, PX_TYPE, EFF_YEAR, DATE_FORMAT(ENLIST_DATE, :DATE_FORMAT) AS ENLIST_DATE
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                  WHERE PX_LNAME LIKE :pxLname
                                    AND PX_FNAME LIKE :pxFname
                                    AND PX_MNAME LIKE :pxMname
                                    AND PX_EXTNAME LIKE :pxExtname
                                    AND XPS_MODULE LIKE :xpsMod
                                    ORDER BY TRANS_NO ASC");

            $stmt->bindParam(':pxLname', $pLastName);
            $stmt->bindParam(':pxFname', $pFirstName);
            $stmt->bindParam(':pxMname', $pMiddleName);
            $stmt->bindParam(':pxExtname', $pSuffix);
            $stmt->bindParam(':DATE_FORMAT', $date_format);
            $stmt->bindParam(':xpsMod', $pModule);
        }

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

//Search Feature used in Laboratory Search Module
function searchLabResult($pPIN, $pLastName, $pFirstName, $pMiddleName, $pSuffix, $pDateOfBirth){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $date_format = "%m/%d/%Y";

        if(isset($_GET['pPIN']) && !empty($_GET['pPIN'])){
            $stmt = $conn->prepare("SELECT SOAP.TRANS_NO, SOAP.PX_PIN, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, SOAP.EFF_YEAR,
                                ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, DATE_FORMAT(ENLIST.PX_DOB, :DATE_FORMAT) AS PX_DOB,
                                DIAG.DIAGNOSTIC_ID, DIAG.TRANS_NO
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC AS DIAG       
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON DIAG.TRANS_NO = SOAP.TRANS_NO                            
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST ON SOAP.PX_PIN = ENLIST.PX_PIN                               
                                      WHERE SOAP.PX_PIN LIKE :pxPin
                                      GROUP BY SOAP.TRANS_NO");

            $stmt->bindParam(':pxPin', $pPIN);
            $stmt->bindParam(':DATE_FORMAT', $date_format);
        }

        if(isset($_GET['pPIN']) && !empty($_GET['pPIN']) AND isset($_GET['pDateOfBirth']) && !empty($_GET['pDateOfBirth'])){
            $stmt = $conn->prepare("SELECT SOAP.TRANS_NO, SOAP.PX_PIN, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, SOAP.EFF_YEAR,
                                ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, DATE_FORMAT(ENLIST.PX_DOB, :DATE_FORMAT) AS PX_DOB,
                                DIAG.DIAGNOSTIC_ID, DIAG.TRANS_NO
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC AS DIAG       
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON DIAG.TRANS_NO = SOAP.TRANS_NO                            
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST ON SOAP.PX_PIN = ENLIST.PX_PIN 
                                  WHERE ENLIST.PX_PIN LIKE :pxPin
                                      AND ENLIST.PX_DOB LIKE :pxDob
                                      GROUP BY SOAP.TRANS_NO");

            $stmt->bindParam(':pxPin', $pPIN);
            $stmt->bindParam(':pxDob', date('m/d/Y', strtotime($pDateOfBirth)));
            $stmt->bindParam(':DATE_FORMAT', $date_format);
        }

        if(isset($_GET['pLastName']) && !empty($_GET['pLastName']) AND isset($_GET['pFirstName']) && !empty($_GET['pFirstName'])){
            $stmt = $conn->prepare("SELECT SOAP.TRANS_NO, SOAP.PX_PIN, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, SOAP.EFF_YEAR,
                                ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, DATE_FORMAT(ENLIST.PX_DOB, :DATE_FORMAT) AS PX_DOB,
                                DIAG.DIAGNOSTIC_ID, DIAG.TRANS_NO
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC AS DIAG       
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON DIAG.TRANS_NO = SOAP.TRANS_NO                            
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST ON SOAP.PX_PIN = ENLIST.PX_PIN 
                                  WHERE ENLIST.PX_LNAME LIKE :pxLname
                                    AND ENLIST.PX_FNAME LIKE :pxFname
                                    GROUP BY SOAP.TRANS_NO
                                    ORDER BY SOAP.TRANS_NO ASC");

            $stmt->bindParam(':pxLname', $pLastName);
            $stmt->bindParam(':pxFname', $pFirstName);
            $stmt->bindParam(':DATE_FORMAT', $date_format);
        }

        if(isset($_GET['pLastName']) && !empty($_GET['pLastName']) AND isset($_GET['pFirstName']) && !empty($_GET['pFirstName']) AND isset($_GET['pDateOfBirth']) && !empty($_GET['pDateOfBirth'])){
            $stmt = $conn->prepare("SELECT SOAP.TRANS_NO, SOAP.PX_PIN, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, SOAP.EFF_YEAR,
                                ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, DATE_FORMAT(ENLIST.PX_DOB, :DATE_FORMAT) AS PX_DOB,
                                DIAG.DIAGNOSTIC_ID, DIAG.TRANS_NO
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC AS DIAG       
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON DIAG.TRANS_NO = SOAP.TRANS_NO                            
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST ON SOAP.PX_PIN = ENLIST.PX_PIN 
                                  WHERE ENLIST.PX_LNAME LIKE :pxLname
                                    AND ENLIST.PX_FNAME LIKE :pxFname
                                    AND ENLIST.PX_DOB LIKE :pxDob
                                    GROUP BY SOAP.TRANS_NO
                                    ORDER BY SOAP.TRANS_NO ASC");

            $stmt->bindParam(':pxLname', $pLastName);
            $stmt->bindParam(':pxFname', $pFirstName);
            $stmt->bindParam(':pxDob', date('m/d/Y', strtotime($pDateOfBirth)));
            $stmt->bindParam(':DATE_FORMAT', $date_format);
        }

        if(isset($_GET['pPIN']) && !empty($_GET['pPIN']) AND isset($_GET['pLastName']) && !empty($_GET['pLastName']) AND isset($_GET['pFirstName']) && !empty($_GET['pFirstName'])){
            $stmt = $conn->prepare("SELECT SOAP.TRANS_NO, SOAP.PX_PIN, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, SOAP.EFF_YEAR,
                                ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, DATE_FORMAT(ENLIST.PX_DOB, :DATE_FORMAT) AS PX_DOB,
                                DIAG.DIAGNOSTIC_ID, DIAG.TRANS_NO
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC AS DIAG       
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON DIAG.TRANS_NO = SOAP.TRANS_NO                            
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST ON SOAP.PX_PIN = ENLIST.PX_PIN 
                                  WHERE ENLIST.PX_PIN LIKE :pxPin
                                    AND ENLIST.PX_LNAME LIKE :pxLname
                                    AND ENLIST.PX_FNAME LIKE :pxFname
                                    GROUP BY SOAP.TRANS_NO
                                    ORDER BY SOAP.TRANS_NO ASC");

            $stmt->bindParam(':pxPin', $pPIN);
            $stmt->bindParam(':pxLname', $pLastName);
            $stmt->bindParam(':pxFname', $pFirstName);
            $stmt->bindParam(':DATE_FORMAT', $date_format);
        }

        if(isset($_GET['pLastName']) && !empty($_GET['pLastName']) AND isset($_GET['pFirstName']) && !empty($_GET['pFirstName']) AND isset($_GET['pMiddleName']) && !empty($_GET['pMiddleName']) AND isset($_GET['pSuffix']) && !empty($_GET['pSuffix'])){
            $stmt = $conn->prepare("SELECT SOAP.TRANS_NO, SOAP.PX_PIN, DATE_FORMAT(SOAP.SOAP_DATE, :DATE_FORMAT) AS SOAP_DATE, SOAP.EFF_YEAR,
                                ENLIST.PX_PIN, ENLIST.PX_LNAME, ENLIST.PX_FNAME, ENLIST.PX_MNAME, ENLIST.PX_EXTNAME, DATE_FORMAT(ENLIST.PX_DOB, :DATE_FORMAT) AS PX_DOB,
                                DIAG.DIAGNOSTIC_ID, DIAG.TRANS_NO
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC AS DIAG       
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP AS SOAP ON DIAG.TRANS_NO = SOAP.TRANS_NO                            
                                    INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS ENLIST ON SOAP.PX_PIN = ENLIST.PX_PIN 
                                  WHERE ENLIST.PX_LNAME LIKE :pxLname
                                    AND ENLIST.PX_FNAME LIKE :pxFname
                                    AND ENLIST.PX_MNAME LIKE :pxMname
                                    AND ENLIST.PX_EXTNAME LIKE :pxExtname
                                    GROUP BY SOAP.TRANS_NO
                                    ORDER BY SOAP.TRANS_NO ASC");

            $stmt->bindParam(':pxLname', $pLastName);
            $stmt->bindParam(':pxFname', $pFirstName);
            $stmt->bindParam(':pxMname', $pMiddleName);
            $stmt->bindParam(':pxExtname', $pSuffix);
            $stmt->bindParam(':DATE_FORMAT', $date_format);
        }

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*Insert data in Facility Registration table*/
function saveHciProfileRegistration($hospRegistration){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        if($hospRegistration['pHciKey'] != ""){
            $cipherkey = $hospRegistration['pHciKey'];
        } else{
            $cipherkey = "NOT AVAILABLE";
        }

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_HCI_PROFILE(
              HCI_NO, ACCRE_NO, PMCC_NO, HOSP_NAME, HOSP_ADDBRGY, HOSP_ADDMUN, HOSP_ADDPROV, HOSP_ADDREG, HOSP_ADDZIPCODE, HOSP_ADDLHIO,
              SECTOR, EMAIL_ADD, TEL_NO, DATE_REGISTERED, USER_ID, USER_PASSWORD, USER_EMPID, USER_LNAME, USER_FNAME, USER_MNAME, USER_EXTNAME,
              USER_SEX, USER_DOB, CIPHER_KEY)
                VALUES(:hciNo, :accreNo, :pmccNo, :hospName ,:hospBrgy, :hospMun, :hospProv, :hospRegion, :hospZipCode, :hospLhio,
                      :sector, :hospEmail, :hospTelNo, NOW(), :userid, :userPassword, :userEmpId, :userLname, :userFname, :userMname, :userExtname, :userSex, :userDoB, :userKey)");

        $stmt->bindParam(':hciNo', trim($hospRegistration['pHciNo']));
        $stmt->bindParam(':accreNo', trim($hospRegistration['pAccreNo']));
        $stmt->bindParam(':pmccNo', trim($hospRegistration['pPmccNo']));
        $stmt->bindParam(':hospName', trim(strtoupper($hospRegistration['pHospName'])));
        $stmt->bindParam(':hospBrgy', $hospRegistration['pHospAddBrgy']);
        $stmt->bindParam(':hospMun', $hospRegistration['pHospAddMun']);
        $stmt->bindParam(':hospProv', $hospRegistration['pHospAddProv']);
        $stmt->bindParam(':hospRegion', $hospRegistration['pHospRegion']);
        $stmt->bindParam(':hospZipCode', $hospRegistration['pHospZipCode']);
        $stmt->bindParam(':hospLhio', $hospRegistration['pHospLhio']);
        $stmt->bindParam(':sector', strtoupper($hospRegistration['pHospSector']));
        $stmt->bindParam(':hospEmail', $hospRegistration['pHospEmailAdd']);
        $stmt->bindParam(':hospTelNo', trim($hospRegistration['pHospTelNo']));
        $stmt->bindParam(':userid', trim($hospRegistration['pUserId']));
        $stmt->bindParam(':userPassword', trim($hospRegistration['pUserPassword']));
        $stmt->bindParam(':userEmpId', trim(strtoupper($hospRegistration['pUserEmpID'])));
        $stmt->bindParam(':userLname', trim(strtoupper($hospRegistration['pUserLname'])));
        $stmt->bindParam(':userFname', trim(strtoupper($hospRegistration['pUserFname'])));
        $stmt->bindParam(':userMname', trim(strtoupper($hospRegistration['pUserMname'])));
        $stmt->bindParam(':userExtname', trim(strtoupper($hospRegistration['pUserExtName'])));
        $stmt->bindParam(':userSex', $hospRegistration['pUserSex']);
        $stmt->bindParam(':userDoB',date('Y-m-d', strtotime($hospRegistration['pUserDoB'])));
        $stmt->bindParam(':userKey',$cipherkey);

        $stmt->execute();

        $conn->commit();

        echo '<script>alert("Successfully saved!");window.location="index.php";</script>';

    } catch (PDOException $e) {
        $conn->rollback();
        echo '<script>alert("Error: User Name is already in use.'.$e->getMessage().'");</script>';
    }

    $conn = null;
}
/*Insert data for Enlistment/Registration Module*/
/*Insert data in Enlistment/Registration table*/
function savePatientRegistration($enlistDetails){
    $ini = parse_ini_file("config.ini");
    $pUserId = $_SESSION['pUserID'];

    if($enlistDetails['pPatientType']== 'MM'){
        $enlistDetails['pMemberPIN'] = $enlistDetails['pPatientPIN'];
        $enlistDetails['pMemberLastName']=strtoupper($enlistDetails['pPatientLastName']);
        $enlistDetails['pMemberFirstName']=strtoupper($enlistDetails['pPatientFirstName']);
        $enlistDetails['pMemberMiddleName']=strtoupper($enlistDetails['pPatientMiddleName']);
        $enlistDetails['pMemberSuffix']=strtoupper($enlistDetails['pPatientSuffix']);
        $enlistDetails['pMemberDateOfBirth']=$enlistDetails['pPatientDateOfBirth'];
        $enlistDetails['pMemberSex']=$enlistDetails['pPatientSexX'];
    }

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        $pCaseNo = generateTransNo('CASE_NO');
        $pTransNo = generateTransNo('ENLIST_NO');
        $pXPSmodule = "EPCB";
        $pWithLoa = "N";
        $pPatientPin=$enlistDetails['pPatientPIN'];
        $pMemPin=$enlistDetails['pMemberPIN'];
        $pEffectivityYear=date('Y', strtotime($enlistDetails['pEnlistmentDate']));
        $checkPxRecord = checkPatientRecordExist($pPatientPin, $pEffectivityYear, $pXPSmodule);
        $checkMemberAssigned = checkPatientRecordAssigned($pMemPin, $pEffectivityYear);

        if($enlistDetails['pPatientType'] == "DD"){
            $pWithDisability = $enlistDetails['pWithDisability'];
            $pDependentType = $enlistDetails['pDependentType'];
        }
        else{
            $pWithDisability = "X";
            $pDependentType = "X";
        }

        if($checkPxRecord == false) {

            $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_ENLIST (
                                  CASE_NO, TRANS_NO, TRANS_DATE, HCI_NO, ACCRE_NO, PMCC_NO, PRO_CODE, 
                                  PX_TYPE, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, PX_PIN, PX_DOB, PX_CONTACTNO, PX_SEX, PX_ADDBRGY, PX_ADDMUN, PX_ADDPROV, PX_ADDREG, PX_ADDZIPCODE, PX_ADDLHIO,
                                  MEM_PIN, MEM_LNAME, MEM_FNAME, MEM_MNAME, MEM_EXTNAME, MEM_DOB, CIVIL_STATUS, 
                                  ENLIST_DATE, PACKAGE_TYPE, CREATED_BY, EFF_YEAR, WITH_LOA, WITH_CONSENT, 
                                  PX_EMAIL_ADDRESS, MEM_SEX, IS_DEPENDENT_VALID, WITH_DISABILITY, DEPENDENT_TYPE, AVAIL_FREE_SERVICE, XPS_MODULE, DATE_ADDED) 
                                    VALUES(:caseNo, :transNo, NOW(), :hciNo, :accreNo, :pmccNo, :proCode, :pxType, :pxLname, :pxFname, :pxMname, :pxExtname, :pxPin, :pxDob, :pxContactNo, :pxSex,
                                    :pxBrgy, :pxMun, :pxProv, :pxReg, :pxZipCode, :pxLhio, :memPin, :memLname, :memFname, :memMname, :memExtname, :memDob, :pxCivilStatus,
                                    :enlistDate, :enlistType, :createdBY, :effYear, :withLoa, :withConsent, :pxEmailAdd, :memSex, :isDependentValid, :withDisability, :dependentType, :availFreeService, :xpsMod, NOW())");

            $stmt->bindParam(':caseNo', $pCaseNo);
            $stmt->bindParam(':transNo',$pTransNo);
            $stmt->bindParam(':enlistDate', date('Y-m-d', strtotime($enlistDetails['pEnlistmentDate'])));
            $stmt->bindParam(':hciNo', $enlistDetails['pHCInum']);
            $stmt->bindParam(':accreNo', $enlistDetails['pAccreNum']);
            $stmt->bindParam(':pmccNo', $enlistDetails['pPMCCnum']);
            $stmt->bindParam(':proCode', $enlistDetails['pProcode']);
            $stmt->bindParam(':pxType', $enlistDetails['pPatientType']);
            $stmt->bindParam(':pxLname', strtoupper($enlistDetails['pPatientLastName']));
            $stmt->bindParam(':pxFname', strtoupper($enlistDetails['pPatientFirstName']));
            $stmt->bindParam(':pxMname', strtoupper($enlistDetails['pPatientMiddleName']));
            $stmt->bindParam(':pxExtname', strtoupper($enlistDetails['pPatientSuffix']));
            $stmt->bindParam(':pxPin', $enlistDetails['pPatientPIN']);
            $stmt->bindParam(':pxDob', date('Y-m-d', strtotime($enlistDetails['pPatientDateOfBirth'])));
            $stmt->bindParam(':pxContactNo', $enlistDetails['pPatientContactNumber']);
            $stmt->bindParam(':pxSex', $enlistDetails['pPatientSexX']);
            $stmt->bindParam(':pxBrgy', $enlistDetails['pPatientAddBrgy']);
            $stmt->bindParam(':pxMun', $enlistDetails['pPatientAddMun']);
            $stmt->bindParam(':pxProv', $enlistDetails['pPatientAddProv']);
            $stmt->bindParam(':pxReg', $enlistDetails['pPatientRegion']);
            $stmt->bindParam(':pxZipCode', $enlistDetails['pPatientZipCode']);
            $stmt->bindParam(':pxLhio', $enlistDetails['pPatientLhio']);
            $stmt->bindParam(':memPin', $enlistDetails['pMemberPIN']);
            $stmt->bindParam(':memLname', strtoupper($enlistDetails['pMemberLastName']));
            $stmt->bindParam(':memFname', strtoupper($enlistDetails['pMemberFirstName']));
            $stmt->bindParam(':memMname', strtoupper($enlistDetails['pMemberMiddleName']));
            $stmt->bindParam(':memExtname', strtoupper($enlistDetails['pMemberSuffix']));
            $stmt->bindParam(':memDob', date('Y-m-d', strtotime($enlistDetails['pMemberDateOfBirth'])));
            $stmt->bindParam(':pxCivilStatus', $enlistDetails['pPatientCivilStatusX']);
            $stmt->bindParam(':enlistType', $enlistDetails['pEnlistType']);
            $stmt->bindParam(':createdBY', strtoupper($pUserId));
            $stmt->bindParam(':effYear', date('Y', strtotime($enlistDetails['pEnlistmentDate'])));
            $stmt->bindParam(':withLoa', $pWithLoa);
            $stmt->bindParam(':withConsent', $enlistDetails['pWithConsentValue']);
            $stmt->bindParam(':pxEmailAdd', $enlistDetails['pPatientEmailAdd']);
            $stmt->bindParam(':memSex', $enlistDetails['pMemberSex']);
            $stmt->bindParam(':isDependentValid', $enlistDetails['is_dependent_valid']);
            $stmt->bindParam(':withDisability', $pWithDisability);
            $stmt->bindParam(':dependentType', $pDependentType);
            $stmt->bindParam(':availFreeService', $enlistDetails['pAvailFreeServiceValue']);
            $stmt->bindParam(':xpsMod', $pXPSmodule);
            $stmt->execute();

            $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_HIST_ENLIST (
                              HIST_NO, CASE_NO, TRANS_NO, TRANS_DATE, HCI_NO, ACCRE_NO, PMCC_NO, PRO_CODE, 
                              PX_TYPE, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, PX_PIN, PX_DOB, PX_CONTACTNO, PX_SEX, PX_ADDBRGY, PX_ADDMUN, PX_ADDPROV, PX_ADDREG, PX_ADDZIPCODE, PX_ADDLHIO,
                              MEM_PIN, MEM_LNAME, MEM_FNAME, MEM_MNAME, MEM_EXTNAME, MEM_DOB, CIVIL_STATUS, 
                              ENLIST_DATE, PACKAGE_TYPE, CREATED_BY, EFF_YEAR, WITH_CONSENT, 
                              PX_EMAIL_ADDRESS, MEM_SEX, IS_DEPENDENT_VALID, WITH_DISABILITY, DEPENDENT_TYPE, UPD_CNT, AVAIL_FREE_SERVICE, XPS_MODULE) 
                                VALUES(:histNo, :caseNo, :transNo, NOW(), :hciNo, :accreNo, :pmccNo, :proCode, :pxType, :pxLname, :pxFname, :pxMname, :pxExtname, :pxPin, :pxDob, :pxContactNo, :pxSex,
                                :pxBrgy, :pxMun, :pxProv, :pxReg, :pxZipCode, :pxLhio, :memPin, :memLname, :memFname, :memMname, :memExtname, :memDob, :pxCivilStatus, 
                                :enlistDate, :enlistType, :createdBY, :effYear, :withConsent, :pxEmailAdd, :memSex, :isDependentValid, :withDisability, :dependentType, :updCnt, :availFreeService, :xpsMod)");

            $stmt->bindParam(':histNo', generateTransNo('HIST_ENO'));
            $stmt->bindParam(':caseNo', $pCaseNo);
            $stmt->bindParam(':transNo',$pTransNo);
            $stmt->bindParam(':enlistDate', date('Y-m-d', strtotime($enlistDetails['pEnlistmentDate'])));
            $stmt->bindParam(':hciNo', $enlistDetails['pHCInum']);
            $stmt->bindParam(':accreNo', $enlistDetails['pAccreNum']);
            $stmt->bindParam(':pmccNo', $enlistDetails['pPMCCnum']);
            $stmt->bindParam(':proCode', $enlistDetails['pProcode']);
            $stmt->bindParam(':pxType', $enlistDetails['pPatientType']);
            $stmt->bindParam(':pxLname', strtoupper($enlistDetails['pPatientLastName']));
            $stmt->bindParam(':pxFname', strtoupper($enlistDetails['pPatientFirstName']));
            $stmt->bindParam(':pxMname', strtoupper($enlistDetails['pPatientMiddleName']));
            $stmt->bindParam(':pxExtname', strtoupper($enlistDetails['pPatientSuffix']));
            $stmt->bindParam(':pxPin', $enlistDetails['pPatientPIN']);
            $stmt->bindParam(':pxDob', date('Y-m-d', strtotime($enlistDetails['pPatientDateOfBirth'])));
            $stmt->bindParam(':pxContactNo', $enlistDetails['pPatientContactNumber']);
            $stmt->bindParam(':pxSex', $enlistDetails['pPatientSexX']);
            $stmt->bindParam(':pxBrgy', $enlistDetails['pPatientAddBrgy']);
            $stmt->bindParam(':pxMun', $enlistDetails['pPatientAddMun']);
            $stmt->bindParam(':pxProv', $enlistDetails['pPatientAddProv']);
            $stmt->bindParam(':pxReg', $enlistDetails['pPatientRegion']);
            $stmt->bindParam(':pxZipCode', $enlistDetails['pPatientZipCode']);
            $stmt->bindParam(':pxLhio', $enlistDetails['pPatientLhio']);
            $stmt->bindParam(':memPin', $enlistDetails['pMemberPIN']);
            $stmt->bindParam(':memLname', strtoupper($enlistDetails['pMemberLastName']));
            $stmt->bindParam(':memFname', strtoupper($enlistDetails['pMemberFirstName']));
            $stmt->bindParam(':memMname', strtoupper($enlistDetails['pMemberMiddleName']));
            $stmt->bindParam(':memExtname', strtoupper($enlistDetails['pMemberSuffix']));
            $stmt->bindParam(':memDob', date('Y-m-d', strtotime($enlistDetails['pMemberDateOfBirth'])));
            $stmt->bindParam(':pxCivilStatus', $enlistDetails['pPatientCivilStatusX']);
            $stmt->bindParam(':enlistType', $enlistDetails['pEnlistType']);
            $stmt->bindParam(':createdBY', strtoupper($pUserId));
            $stmt->bindParam(':effYear', date('Y'));
            $stmt->bindParam(':withConsent', $enlistDetails['pWithConsentValue']);
            $stmt->bindParam(':pxEmailAdd', $enlistDetails['pPatientEmailAdd']);
            $stmt->bindParam(':memSex', $enlistDetails['pMemberSex']);
            $stmt->bindParam(':isDependentValid', $enlistDetails['is_dependent_valid']);
            $stmt->bindParam(':withDisability', $enlistDetails['pWithDisability']);
            $stmt->bindParam(':dependentType', $enlistDetails['pDependentType']);
            $stmt->bindParam(':updCnt', $enlistDetails['pUpdCntEnlist']);
            $stmt->bindParam(':availFreeService', $enlistDetails['pAvailFreeServiceValue']);
            $stmt->bindParam(':xpsMod', $pXPSmodule);

            $stmt->execute();
            $conn->commit();

            if($checkMemberAssigned == true){
                echo '<script>alert("Successfully saved!\nNOTE: MEMBER IS ASSIGNED IN THE FACILITY!");window.location="registration_data_entry.php";</script>';
            }else{
                echo '<script>alert("Successfully saved!\nNOTE: MEMBER IS NOT YET ASSIGNED IN THE FACILITY!");window.location="registration_data_entry.php";</script>';
            }

        }
        else{
            echo '<script>alert("Patient record already exist!");window.location="registration_data_entry.php";</script>';
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $conn->rollback();
        echo '<script>alert("Error: '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Update data in Enlistment/Registration table*/
function updatePatientRegistration($enlistDetails){
    $ini = parse_ini_file("config.ini");
    $pUserId = $_SESSION['pUserID'];

    if($enlistDetails['pPatientType']== 'MM'){
        $enlistDetails['pMemberPIN'] = $enlistDetails['pPatientPIN'];
        $enlistDetails['pMemberLastName']=$enlistDetails['pPatientLastName'];
        $enlistDetails['pMemberFirstName']=$enlistDetails['pPatientFirstName'];
        $enlistDetails['pMemberMiddleName']=$enlistDetails['pPatientMiddleName'];
        $enlistDetails['pMemberSuffix']=$enlistDetails['pPatientSuffix'];
        $enlistDetails['pMemberDateOfBirth']=$enlistDetails['pPatientDateOfBirth'];
        $enlistDetails['pMemberSex']=$enlistDetails['pPatientSexX'];
    }

    try {
        $conn = new PDO("mysql:host=" . $ini["DBSERVER"] . ";dbname=" . $ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        $stmt = $conn->prepare("UPDATE " . $ini['EPCB'] . ".TSEKAP_TBL_ENLIST 
                                    SET TRANS_DATE = NOW(),
                                        HCI_NO = :hciNo,
                                        ACCRE_NO = :accreNo,
                                        PMCC_NO = :pmccNo,
                                        PRO_CODE = :proCode,
                                        PX_TYPE = :pxType,
                                        PX_LNAME = :pxLname,
                                        PX_FNAME = :pxFname,
                                        PX_MNAME = :pxMname,
                                        PX_EXTNAME = :pxExtname,
                                        PX_PIN = :pxPin,
                                        PX_DOB = :pxDob,
                                        PX_CONTACTNO = :pxContactNo,
                                        PX_SEX = :pxSex,
                                        PX_ADDBRGY = :pxBrgy,
                                        PX_ADDMUN = :pxMun,
                                        PX_ADDPROV = :pxProv,
                                        PX_ADDREG = :pxReg,
                                        PX_ADDZIPCODE = :pxZipCode,
                                        PX_ADDLHIO = :pxLhio,  
                                        MEM_PIN = :memPin,
                                        MEM_LNAME = :memLname,
                                        MEM_FNAME = :memFname,
                                        MEM_MNAME = :memMname,
                                        MEM_EXTNAME = :memExtname,
                                        MEM_DOB = :memDob,                                        
                                        CIVIL_STATUS = :pxCivilStatus,
                                        ENLIST_DATE = :enlistDate,
                                        PACKAGE_TYPE = :enlistType,
                                        CREATED_BY = :createdBY,
                                        EFF_YEAR = :effYear,
                                        WITH_CONSENT = :withConsent,
                                        PX_EMAIL_ADDRESS = :pxEmailAdd,
                                        MEM_SEX = :memSex,
                                        IS_DEPENDENT_VALID = :isDependentValid,
                                        WITH_DISABILITY = :withDisability,
                                        DEPENDENT_TYPE = :dependentType,
                                        UPD_CNT = :uptCnt                                            
                                    WHERE CASE_NO = :caseNo
                                      AND TRANS_NO = :transNo");

        $stmt->bindParam(':caseNo', $enlistDetails['pCaseNum']);
        $stmt->bindParam(':transNo', $enlistDetails['pTransNum']);
        $stmt->bindParam(':enlistDate', date('Y-m-d', strtotime($enlistDetails['pEnlistmentDate'])));
        $stmt->bindParam(':hciNo', $enlistDetails['pHCInum']);
        $stmt->bindParam(':accreNo', $enlistDetails['pAccreNum']);
        $stmt->bindParam(':pmccNo', $enlistDetails['pPMCCnum']);
        $stmt->bindParam(':proCode', $enlistDetails['pProcode']);
        $stmt->bindParam(':pxType', $enlistDetails['pPatientType']);
        $stmt->bindParam(':pxLname', strtoupper($enlistDetails['pPatientLastName']));
        $stmt->bindParam(':pxFname', strtoupper($enlistDetails['pPatientFirstName']));
        $stmt->bindParam(':pxMname', strtoupper($enlistDetails['pPatientMiddleName']));
        $stmt->bindParam(':pxExtname', strtoupper($enlistDetails['pPatientSuffix']));
        $stmt->bindParam(':pxPin', $enlistDetails['pPatientPIN']);
        $stmt->bindParam(':pxDob', date('Y-m-d', strtotime($enlistDetails['pPatientDateOfBirth'])));
        $stmt->bindParam(':pxContactNo', $enlistDetails['pPatientContactNumber']);
        $stmt->bindParam(':pxSex', $enlistDetails['pPatientSexX']);
        $stmt->bindParam(':pxBrgy', $enlistDetails['pPatientAddBrgy']);
        $stmt->bindParam(':pxMun', $enlistDetails['pPatientAddMun']);
        $stmt->bindParam(':pxProv', $enlistDetails['pPatientAddProv']);
        $stmt->bindParam(':pxReg', $enlistDetails['pPatientRegion']);
        $stmt->bindParam(':pxZipCode', $enlistDetails['pPatientZipCode']);
        $stmt->bindParam(':pxLhio', $enlistDetails['pPatientLhio']);
        $stmt->bindParam(':memPin', $enlistDetails['pMemberPIN']);
        $stmt->bindParam(':memLname', strtoupper($enlistDetails['pMemberLastName']));
        $stmt->bindParam(':memFname', strtoupper($enlistDetails['pMemberFirstName']));
        $stmt->bindParam(':memMname', strtoupper($enlistDetails['pMemberMiddleName']));
        $stmt->bindParam(':memExtname', strtoupper($enlistDetails['pMemberSuffix']));
        $stmt->bindParam(':memDob', date('Y-m-d', strtotime($enlistDetails['pMemberDateOfBirth'])));
        $stmt->bindParam(':pxCivilStatus', $enlistDetails['pPatientCivilStatusX']);
        $stmt->bindParam(':enlistType', $enlistDetails['pEnlistType']);
        $stmt->bindParam(':createdBY', strtoupper($pUserId));
        $stmt->bindParam(':effYear', date('Y'));
        $stmt->bindParam(':withConsent', $enlistDetails['pWithConsent']);
        $stmt->bindParam(':pxEmailAdd', $enlistDetails['pPatientEmailAdd']);
        $stmt->bindParam(':memSex', $enlistDetails['pMemberSex']);
        $stmt->bindParam(':isDependentValid', $enlistDetails['is_dependent_valid']);
        $stmt->bindParam(':withDisability', $enlistDetails['pWithDisability']);
        $stmt->bindParam(':dependentType', $enlistDetails['pDependentType']);
        $stmt->bindParam(':uptCnt', $enlistDetails['pUpdCntEnlist']);
        $stmt->execute();

        $stmt = $conn->prepare("INSERT INTO " . $ini['EPCB'] . ".TSEKAP_HIST_ENLIST (
                              HIST_NO, CASE_NO, TRANS_NO, TRANS_DATE, HCI_NO, ACCRE_NO, PMCC_NO, PRO_CODE, 
                              PX_TYPE, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, PX_PIN, PX_DOB, PX_CONTACTNO, PX_SEX, PX_ADDBRGY, PX_ADDMUN, PX_ADDPROV, PX_ADDREG, PX_ADDZIPCODE, PX_ADDLHIO,
                              MEM_PIN, MEM_LNAME, MEM_FNAME, MEM_MNAME, MEM_EXTNAME, MEM_DOB, CIVIL_STATUS, 
                              ENLIST_DATE, PACKAGE_TYPE, CREATED_BY, EFF_YEAR, WITH_CONSENT, 
                              PX_EMAIL_ADDRESS, MEM_SEX, IS_DEPENDENT_VALID, WITH_DISABILITY, DEPENDENT_TYPE, UPD_CNT) 
                                VALUES(:histNo, :caseNo, :transNo, NOW(), :hciNo, :accreNo, :pmccNo, :proCode, :pxType, :pxLname, :pxFname, :pxMname, :pxExtname, :pxPin, :pxDob, :pxContactNo, :pxSex,
                                :pxBrgy, :pxMun, :pxProv, :pxReg, :pxZipCode, :pxLhio, :memPin, :memLname, :memFname, :memMname, :memExtname, :memDob, :pxCivilStatus, 
                                :enlistDate, :enlistType, :createdBY, :effYear, :withConsent, :pxEmailAdd, :memSex, :isDependentValid, :withDisability, :dependentType, :updCnt)");

        $stmt->bindParam(':histNo', generateTransNo('HIST_ENO'));
        $stmt->bindParam(':caseNo', $enlistDetails['pCaseNum']);
        $stmt->bindParam(':transNo', $enlistDetails['pTransNum']);
        $stmt->bindParam(':enlistDate', date('Y-m-d', strtotime($enlistDetails['pEnlistmentDate'])));
        $stmt->bindParam(':hciNo', $enlistDetails['pHCInum']);
        $stmt->bindParam(':accreNo', $enlistDetails['pAccreNum']);
        $stmt->bindParam(':pmccNo', $enlistDetails['pPMCCnum']);
        $stmt->bindParam(':proCode', $enlistDetails['pProcode']);
        $stmt->bindParam(':pxType', $enlistDetails['pPatientType']);
        $stmt->bindParam(':pxLname', strtoupper($enlistDetails['pPatientLastName']));
        $stmt->bindParam(':pxFname', strtoupper($enlistDetails['pPatientFirstName']));
        $stmt->bindParam(':pxMname', strtoupper($enlistDetails['pPatientMiddleName']));
        $stmt->bindParam(':pxExtname', strtoupper($enlistDetails['pPatientSuffix']));
        $stmt->bindParam(':pxPin', $enlistDetails['pMemberPIN']);
        $stmt->bindParam(':pxDob', date('Y-m-d', strtotime($enlistDetails['pPatientDateOfBirth'])));
        $stmt->bindParam(':pxContactNo', $enlistDetails['pPatientContactNumber']);
        $stmt->bindParam(':pxSex', $enlistDetails['pPatientSexX']);
        $stmt->bindParam(':pxBrgy', $enlistDetails['pPatientAddBrgy']);
        $stmt->bindParam(':pxMun', $enlistDetails['pPatientAddMun']);
        $stmt->bindParam(':pxProv', $enlistDetails['pPatientAddProv']);
        $stmt->bindParam(':pxReg', $enlistDetails['pPatientRegion']);
        $stmt->bindParam(':pxZipCode', $enlistDetails['pPatientZipCode']);
        $stmt->bindParam(':pxLhio', $enlistDetails['pPatientLhio']);
        $stmt->bindParam(':memPin', $enlistDetails['pPatientPIN']);
        $stmt->bindParam(':memLname', strtoupper($enlistDetails['pMemberLastName']));
        $stmt->bindParam(':memFname', strtoupper($enlistDetails['pMemberFirstName']));
        $stmt->bindParam(':memMname', strtoupper($enlistDetails['pMemberMiddleName']));
        $stmt->bindParam(':memExtname', strtoupper($enlistDetails['pMemberSuffix']));
        $stmt->bindParam(':memDob', date('Y-m-d', strtotime($enlistDetails['pMemberDateOfBirth'])));
        $stmt->bindParam(':pxCivilStatus', $enlistDetails['pPatientCivilStatusX']);
        $stmt->bindParam(':enlistType', $enlistDetails['pEnlistType']);
        $stmt->bindParam(':createdBY', $pUserId);
        $stmt->bindParam(':effYear', date('Y'));
        $stmt->bindParam(':withConsent', $enlistDetails['pWithConsent']);
        $stmt->bindParam(':pxEmailAdd', $enlistDetails['pPatientEmailAdd']);
        $stmt->bindParam(':memSex', $enlistDetails['pMemberSex']);
        $stmt->bindParam(':isDependentValid', $enlistDetails['is_dependent_valid']);
        $stmt->bindParam(':withDisability', $enlistDetails['pWithDisability']);
        $stmt->bindParam(':dependentType', $enlistDetails['pDependentType']);
        $stmt->bindParam(':updCnt', $enlistDetails['pUpdCntEnlist']);
        $stmt->execute();

        $conn->commit();

        echo '<script>alert("Successfully saved!");window.location="registration_search.php";</script>';

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $conn->rollback();
        echo '<script>alert("Error: '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

function checkPatientRecordExist($pPatientPin,$pEffectivityYear,$pXPSmodule){
    $ini = parse_ini_file("config.ini");
    try {
        $conn = new PDO("mysql:host=" . $ini["DBSERVER"] . ";dbname=" . $ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                        WHERE PX_PIN = :pxPin
                                          AND EFF_YEAR = :pxEffYear
                                          AND XPS_MODULE = :pModule");

        $stmt->bindParam(':pxPin', $pPatientPin);
        $stmt->bindParam(':pxEffYear', $pEffectivityYear);
        $stmt->bindParam(':pModule', $pXPSmodule);

        $stmt->execute();
        $conn->commit();

        if($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
            return true;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $conn->rollback();
        echo '<script>alert("Error: '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

function checkPatientRecordAssigned($pMemberPin, $pEffectivityYear){
    $ini = parse_ini_file("config.ini");
    try {
        $conn = new PDO("mysql:host=" . $ini["DBSERVER"] . ";dbname=" . $ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_TBL_ASSIGN
                                        WHERE MEM_PIN = :memPin
                                          AND EFF_YEAR = :effYear");

        $stmt->bindParam(':memPin', $pMemberPin);
        $stmt->bindParam(':effYear', $pEffectivityYear);

        $stmt->execute();
        $conn->commit();

        if($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
            return true;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $conn->rollback();
        echo '<script>alert("Error: '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert date for Follow-up Medicine*/
function saveFollowUpMedicine($soapInfo){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=" . $ini["DBSERVER"] . ";dbname=" . $ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        session_start();
        $pUserId = $_SESSION['pUserID'];
        $pHciNo = $_SESSION['pHciNum'];
        $pXPSmodule = "SOAP"; /*SOAP - Consultation*/

        /*Start Consultation Patient Details*/
        $pCaseNo = $soapInfo['pCaseNo'];
        $pPatientPin = $soapInfo['pPatientPIN'];
        $pPatientType = $soapInfo['pPatientType'];
        $pMemPin = $soapInfo['pMemPin'];
        $pEffYear = $soapInfo['pEffYear'];
        $pSoapDate = $soapInfo['pSOAPDate'];
        $pSoapOtp = $soapInfo['pSoapOTP'];

        $getUpdCnt = 0;
        $pTransNo = generateTransNo('SOAP_NO'); //automatically generated
        insertConsultationPatientInfo($pCaseNo, $pTransNo, $pHciNo, $pPatientPin, $pPatientType, $pMemPin, $pSoapDate, $pUserId, $pEffYear, $pSoapOtp, $getUpdCnt, $pXPSmodule);

        /*Start Medicine*/
        /*Medicine*/
        $pDoctorName = $soapInfo['pPrescDoctor'];
        $pDrugCodeMeds = $soapInfo['pDrugCodeMeds'];
        $pGenCodeMeds = $soapInfo['pGenCodeMeds'];
        $pStrengthMeds = $soapInfo['pStrengthMeds'];
        $pFormMeds = $soapInfo['pFormMeds'];
        $pPackageMeds = $soapInfo['pPackageMeds'];
        $pQuantityMeds = $soapInfo['pQtyMeds'];
        $pUnitPriceMeds = $soapInfo['pUnitPriceMeds'];
        $pCopayMeds = $soapInfo['pCoPaymentMeds'];
        $pTotalAmtPriceMeds = $soapInfo['pTotalPriceMeds'];
        $pInsQtyMeds = $soapInfo['pQtyInsMeds'];
        $pInsStrengthMeds = $soapInfo['pStrengthMeds'];
        $pInsFreqMeds = strtoupper($soapInfo['pFrequencyMeds']);
        $pGenericName = $soapInfo['pGenericName'];

        if ($pDrugCodeMeds != NULL) {
            $pApplicable = "Y";
            for ($i = 0; $i < count($pGenCodeMeds); $i++) {
                insertMedicine($pDrugCodeMeds[$i], $pGenCodeMeds[$i], $pStrengthMeds[$i], $pFormMeds[$i], $pPackageMeds[$i],
                    $pQuantityMeds[$i], $pUnitPriceMeds[$i], $pCopayMeds[$i], $pTotalAmtPriceMeds[$i], $pInsQtyMeds[$i], $pInsStrengthMeds[$i], $pInsFreqMeds[$i],
                    $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pDoctorName, $pApplicable, $pGenericName,"","","");
            }
        } else {
            $pApplicable = "N";
            insertMedicine(NULL, NULL, NULL, NULL, NULL,
                NULL, NULL, NULL, NULL, NULL, NULL, NULL,
                $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pDoctorName, $pApplicable, NULL,NULL, NULL, NULL);
        }
        /*End Medicine*/

        $conn->commit();

        echo '<script>alert("Successfully saved!");</script>';
        //window.location="consultation_search.php";

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: saveFollowupMeds - " . $e->getMessage();
        echo '<script>alert("Error: saveFollowupMeds - ' . $e->getMessage() . '");</script>';
    }
}


/*Insert data for Consultation Module*/
function saveConsultationInfo($soapInfo){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        session_start();
        $pUserId = $_SESSION['pUserID'];
        $pHciNo = $_SESSION['pHciNum'];
        $pXPSmodule = "SOAP"; /*SOAP - Consultation*/

        /*Start Consultation Patient Details*/
        $pCaseNo=$soapInfo['pCaseNo'];
        $pPatientPin=$soapInfo['pPatientPIN'];
        $pPatientType=$soapInfo['pPatientType'];
        $pMemPin=$soapInfo['pMemPin'];
        $pEffYear=$soapInfo['pEffYear'];
        $pSoapDate=$soapInfo['pSOAPDate'];
        $pSoapOtp=$soapInfo['pSoapOTP'];

        if(isset($soapInfo['saveClientSoap'])){
            $getUpdCnt = $soapInfo['pUpdCntSoap'];
            $pTransNo =generateTransNo('SOAP_NO'); //automatically generated
            insertConsultationPatientInfo($pCaseNo, $pTransNo, $pHciNo, $pPatientPin, $pPatientType, $pMemPin, $pSoapDate, $pUserId, $pEffYear, $pSoapOtp, $getUpdCnt, $pXPSmodule);
        }

        if(isset($soapInfo['updateClientSoap'])){
            $getUpdCnt = $soapInfo['pUpdCntSoap'];
            $pTransNo = $soapInfo['pSoapTransNum'];

            updateConsultationPatientInfo($pCaseNo, $pTransNo, $pHciNo, $pPatientPin, $pPatientType, $pMemPin, $pSoapDate, $pUserId, $pEffYear, $pSoapOtp, $getUpdCnt);
        }
        /*End Consultation Patient Details*/

        /*Start Subjective/ History of Illness*/
        $pChiefComplaint=$soapInfo['pChiefComplaint'];
        $pSymptoms=NULL;
        $pIllnessHist=strtoupper($soapInfo['pIllnessHistory']);
        $pOtherComplaint=strtoupper($soapInfo['pOtherChiefComplaint']);
        $pPainSite=strtoupper($soapInfo['pPainSite']);
        insertSubjectiveHistory($pUserId, $pTransNo, $pChiefComplaint, $pIllnessHist, $pOtherComplaint, $getUpdCnt,$pSymptoms,$pPainSite);
        /*End Subjective/ History of Illness*/

        /*Start Objective/Physical Examination*/
        /*Part 1: Pertinent Examination*/
        $pSystolic=$soapInfo['pe_bp_u'];
        $pDiastolic=$soapInfo['pe_bp_l'];
        $pHr=$soapInfo['pe_hr'];
        $pRr=$soapInfo['pe_rr'];
        $pHeight=$soapInfo['pe_height_cm'];
        $pWeight=$soapInfo['pe_weight_kg'];
        //$pWaist=$soapInfo['pe_waist_cm'];
        $pTemp = $soapInfo['pe_temp'];
        $pVision=$soapInfo['pe_visual_acuityL'].'/'.$soapInfo['pe_visual_acuityR'];
        $pLength=$soapInfo['pe_length_one_cm'];
        $pHeadCirc=$soapInfo['pe_head_one_cm'];

        insertObjectivePhysicalExam($pSystolic, $pDiastolic, $pHr, $pRr, $pHeight, $pWeight, $pTemp, $pUserId, $pTransNo, $pVision, $pLength, $pHeadCirc, $getUpdCnt);

        /*Part 2: Pertinent Findings per System*/
        $pSkin = $soapInfo['skinExtremities'];
        $pGenito = $soapInfo['genitourinary'];
        $pRectal = $soapInfo['rectal'];
        $pHeent = $soapInfo['heent'];
        $pChest = $soapInfo['chest'];
        $pHeart = $soapInfo['heart'];
        $pAbdomen = $soapInfo['abdomen'];
        $pNeuro = $soapInfo['neuro'];

        /*A. Heent*/
        for ($i = 0; $i < count($pHeent); $i++) {
            if ($pHeent[$i] != '') {
                insertPhysicalExamMisc(null, $pHeent[$i], null, null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*B. Chest/Lungs*/
        for ($i = 0; $i < count($pChest); $i++) {
            if ($pChest[$i] != '') {
                insertPhysicalExamMisc(null, null, $pChest[$i], null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*C. Heart*/
        for ($i = 0; $i < count($pHeart); $i++) {
            if ($pHeart[$i] != '') {
                insertPhysicalExamMisc(null, null, null, $pHeart[$i], null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*D. Abdomen*/
        for ($i = 0; $i < count($pAbdomen); $i++) {
            if ($pAbdomen[$i] != '') {
                insertPhysicalExamMisc(null, null, null, null, $pAbdomen[$i], null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*E. Genitourinary*/
        for ($i = 0; $i < count($pGenito); $i++) {
            if ($pGenito[$i] != '') {
                insertPhysicalExamMisc(null, null, null, null, null, null, $pGenito[$i], null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*F. Digital Rectal Examination*/
        for ($i = 0; $i < count($pRectal); $i++) {
            if ($pRectal[$i] != '') {
                insertPhysicalExamMisc(null, null, null, null, null, null, null, $pRectal[$i], $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*G. Skin/Extremities*/
        for ($i = 0; $i < count($pSkin); $i++) {
            if ($pSkin[$i] != '') {
                insertPhysicalExamMisc($pSkin[$i], null, null, null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*H. Neurological*/
        for ($i = 0; $i < count($pNeuro); $i++) {
            if ($pNeuro[$i] != '') {
                insertPhysicalExamMisc(null, null, null, null, null, $pNeuro[$i], null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*Part 3 Remarks*/
        $pHeentRemarks = strtoupper($soapInfo['heent_remarks']);
        $pChestRemarks = strtoupper($soapInfo['chest_lungs_remarks']);
        $pHeartRemarks = strtoupper($soapInfo['heart_remarks']);
        $pAbdomenRemarks = strtoupper($soapInfo['abdomen_remarks']);
        $pGenitoRemarks = strtoupper($soapInfo['gu_remarks']);
        $pRectalRemarks = strtoupper($soapInfo['rectal_remarks']);
        $pSkinExtremitiesRemarks = strtoupper($soapInfo['skinExtremities_remarks']);
        $pNeuroRemarks = strtoupper($soapInfo['neuro_remarks']);

        insertPhysicalExamMiscRemarks($pHeentRemarks, $pChestRemarks, $pHeartRemarks, $pAbdomenRemarks, $pGenitoRemarks, $pRectalRemarks, $pSkinExtremitiesRemarks, $pNeuroRemarks, $pTransNo, $pUserId, $getUpdCnt);
        /*End Objective/Physical Examination*/

        /*Start Assessment/Diagnosis*/
        $pDiagnosis = $soapInfo['diagnosis'];
        for ($i = 0; $i < count($pDiagnosis); $i++) {
            insertAssessmentDiagnosis($pUserId, $pTransNo, $pDiagnosis[$i], ($i+1), $getUpdCnt);
        }
        /*End Assessment/Diagnosis*/

        /*Start Plan/Management*/
        /*Diagnosis Examination*/
        $pDiagnostic = $soapInfo['diagnostic'];
        $pOthRemarks=strtoupper($soapInfo['diagnostic_oth_remarks']);
        if($pDiagnostic != NULL) {
            for ($i = 0; $i < count($pDiagnostic); $i++) {
                insertDiagnosticExamination($pDiagnostic[$i], $pOthRemarks, $pUserId, $pTransNo, $getUpdCnt);
            }
        }
        else{
            insertDiagnosticExamination("0", $pOthRemarks, $pUserId, $pTransNo, $getUpdCnt);
        }

        /*Management */
        $pManagement=$soapInfo['management'];
        $pOthMgmtRemarks=strtoupper($soapInfo['management_oth_remarks']);
        if($pManagement != NULL) {
            for ($i = 0; $i < count($pManagement); $i++) {
                insertManagement($pManagement[$i], $pUserId, $pTransNo, $pOthMgmtRemarks, $getUpdCnt);
            }
        }
        else{
            insertManagement("0", $pUserId, $pTransNo, $pOthMgmtRemarks, $getUpdCnt);
        }

        /*Advice */
        $pAdviceRemarks=strtoupper($soapInfo['advice_remarks']);
        insertAdvice($pAdviceRemarks,$pUserId, $pTransNo, $getUpdCnt);
        /*End Plan/Management*/

        /*Start Laboratory Results*/
        /*Results - Complete Blood Count (CBC)*/
        $pReferralFacilityCBC=strtoupper($soapInfo['diagnostic_1_accre_diag_fac']);
        if($soapInfo['diagnostic_1_lab_exam_date'] != NULL){
            $pLabDate = date('Y-m-d',strtotime($soapInfo['diagnostic_1_lab_exam_date']));
            $pIsApplicableCbc = "Y";
        } else{
            $pLabDate = NULL;
            $pIsApplicableCbc = "N";
        }
        $pLabFeeCBC = $soapInfo['diagnostic_1_lab_fee'];
        $pCoPayCBC = $soapInfo['diagnostic_1_copay'];
        $pHematocrit = $soapInfo['diagnostic_1_hematocrit'];
        $pHemoglobinG = $soapInfo['diagnostic_1_hemoglobin_gdL'];
        $pHemoglobinMmol = $soapInfo['diagnostic_1_hemoglobin_mmolL'];
        $pMhcPg = $soapInfo['diagnostic_1_mhc_pgcell'];
        $pMhcFmol = $soapInfo['diagnostic_1_mhc_fmolcell'];
        $pMchcGhb = $soapInfo['diagnostic_1_mchc_gHbdL'];
        $pMchcMmol = $soapInfo['diagnostic_1_mchc_mmolHbL'];
        $pMcvUm = $soapInfo['diagnostic_1_mcv_um'];
        $pMcvFl = $soapInfo['diagnostic_1_mcv_fL'];
        $pWbc1000 = $soapInfo['diagnostic_1_wbc_cellsmmuL'];
        $pWbc10 = $soapInfo['diagnostic_1_wbc_cellsL'];
        $pMyelocyte = $soapInfo['diagnostic_1_myelocyte'];
        $pNeutrophilsBnd = $soapInfo['diagnostic_1_neutrophils_bands'];
        $pNeurophilsSeg = $soapInfo['diagnostic_1_neutrophils_segmenters'];
        $pLymphocytes = $soapInfo['diagnostic_1_lymphocytes'];
        $pMonocytes = $soapInfo['diagnostic_1_monocytes'];
        $pEosinophils = $soapInfo['diagnostic_1_eosinophils'];
        $pBasophils = $soapInfo['diagnostic_1_basophils'];
        $pPlatelet = $soapInfo['diagnostic_1_platelet'];
        insertResultsCBC($pCaseNo,$pLabDate,$pLabFeeCBC,$pCoPayCBC, $pReferralFacilityCBC, $pHematocrit, $pHemoglobinG, $pHemoglobinMmol, $pMhcPg, $pMhcFmol, $pMchcGhb, $pMchcMmol, $pMcvUm, $pMcvFl, $pWbc1000, $pWbc10, $pMyelocyte,
            $pNeutrophilsBnd, $pNeurophilsSeg, $pLymphocytes, $pMonocytes, $pEosinophils, $pBasophils, $pPlatelet, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pIsApplicableCbc);

        /* Results - Urinalysis */
        $pReferralFacilityUrinalysis=strtoupper($soapInfo['diagnostic_2_accre_diag_fac']);
        if($soapInfo['diagnostic_2_lab_exam_date'] != NULL){
            $pLabDateUrinalysis = date('Y-m-d',strtotime($soapInfo['diagnostic_2_lab_exam_date']));
            $pIsApplicableUrine = "Y";
        } else{
            $pLabDateUrinalysis = NULL;
            $pIsApplicableUrine = "N";
        }
        $pLabFeeUrinalysis = $soapInfo['diagnostic_2_lab_fee'];
        $pCoPayUrinalysis = $soapInfo['diagnostic_2_copay'];
        $pGravity = $soapInfo['diagnostic_2_sg'];
        $pAppearance = $soapInfo['diagnostic_2_appearance'];
        $pColor = $soapInfo['diagnostic_2_color'];
        $pGlucose = $soapInfo['diagnostic_2_glucose'];
        $pProteins = $soapInfo['diagnostic_2_proteins'];
        $pKetones = $soapInfo['diagnostic_2_ketones'];
        $pPh = $soapInfo['diagnostic_2_pH'];
        $pRbCells = $soapInfo['diagnostic_2_rbc'];
        $pWbCells = $soapInfo['diagnostic_2_wbc'];
        $pBacteria = $soapInfo['diagnostic_2_bacteria'];
        $pCrystals = $soapInfo['diagnostic_2_crystals'];
        $pBladderCell = $soapInfo['diagnostic_2_bladder_cells'];
        $pSquamousCell = $soapInfo['diagnostic_2_squamous_cells'];
        $pTubularCell = $soapInfo['diagnostic_2_tubular_cells'];
        $pBroadCasts = $soapInfo['diagnostic_2_broad_casts'];
        $pEpithelialCast = $soapInfo['diagnostic_2_epithelial_cell_casts'];
        $pGranularCast = $soapInfo['diagnostic_2_granular_casts'];
        $pHyalineCast = $soapInfo['diagnostic_2_hyaline_casts'];
        $pRbcCast = $soapInfo['diagnostic_2_rbc_casts'];
        $pWaxyCast = $soapInfo['diagnostic_2_waxy_casts'];
        $pWcCast = $soapInfo['diagnostic_2_wc_casts'];
        $pAlbumin = $soapInfo['diagnostic_2_alb'];
        $pPusCells = $soapInfo['diagnostic_2_pus'];
        insertResultsUrinalysis($pCaseNo,$pLabDateUrinalysis,$pLabFeeUrinalysis, $pCoPayUrinalysis, $pReferralFacilityUrinalysis, $pGravity, $pAppearance, $pColor, $pGlucose, $pProteins, $pKetones, $pPh, $pRbCells, $pWbCells, $pBacteria, $pCrystals,
            $pBladderCell, $pSquamousCell, $pTubularCell, $pBroadCasts, $pEpithelialCast, $pGranularCast, $pHyalineCast, $pRbcCast, $pWaxyCast, $pWcCast, $pAlbumin, $pPusCells, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableUrine);

        /* Results - Fecalysis */
        $pReferralFacilityFecalysis=strtoupper($soapInfo['diagnostic_3_accre_diag_fac']);
        if($soapInfo['diagnostic_3_lab_exam_date'] != NULL){
            $pLabDateFecalysis = date('Y-m-d',strtotime($soapInfo['diagnostic_3_lab_exam_date']));
            $pIsApplicableFeca = "Y";
        } else{
            $pLabDateFecalysis = NULL;
            $pIsApplicableFeca = "N";
        }
        $pLabFeeFecalysis = $soapInfo['diagnostic_3_lab_fee'];
        $pCoPayFecalysis = $soapInfo['diagnostic_3_copay'];
        $pColorFecalysis = $soapInfo['diagnostic_3_color'];
        $pConsistency = $soapInfo['diagnostic_3_consistency'];
        $pRBC = $soapInfo['diagnostic_3_rbc'];
        $pWBC = $soapInfo['diagnostic_3_wbc'];
        $pOva = $soapInfo['diagnostic_3_ova'];
        $pParasite = $soapInfo['diagnostic_3_parasite'];
        $pBlood = $soapInfo['diagnostic_3_blood'];
        $pOccultBlood = $soapInfo['diagnostic_3_occult_blood'];
        $pPusCell = $soapInfo['diagnostic_3_pus'];
        insertResultsFecalysis($pCaseNo,$pLabDateFecalysis, $pLabFeeFecalysis, $pCoPayFecalysis, $pReferralFacilityFecalysis, $pColorFecalysis, $pConsistency, $pRBC, $pWBC, $pOva, $pParasite, $pBlood, $pOccultBlood, $pPusCell, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableFeca);

        /* Results - Chest X-Ray */
        $pReferralFacilityXray=strtoupper($soapInfo['diagnostic_4_accre_diag_fac']);
        if($soapInfo['diagnostic_4_lab_exam_date'] != NULL){
            $pLabDateXray = date('Y-m-d',strtotime($soapInfo['diagnostic_4_lab_exam_date']));
            $pIsApplicableXray = "Y";
        } else{
            $pLabDateXray = NULL;
            $pIsApplicableXray = "N";
        }
        $pLabFeeXray = $soapInfo['diagnostic_4_lab_fee'];
        $pCoPayXray = $soapInfo['diagnostic_4_copay'];
        $pFindingsXray = $soapInfo['diagnostic_4_chest_findings'];
        $pRemarkFindings = strtoupper($soapInfo['diagnostic_4_chest_findings_remarks']);
        $pObservation = $soapInfo['pObservation'];
        $pRemarkObservation = $soapInfo['pObservationRemarks'];
        insertResultsChestXray($pCaseNo,$pLabDateXray, $pLabFeeXray, $pCoPayXray, $pReferralFacilityXray, $pFindingsXray, $pRemarkFindings, $pObservation, $pRemarkObservation, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableXray);

        /* Results - Sputum */
        $pReferralFacilitySputum=strtoupper($soapInfo['diagnostic_5_accre_diag_fac']);
        if($soapInfo['diagnostic_5_lab_exam_date'] != NULL){
            $pLabDateSputum = date('Y-m-d',strtotime($soapInfo['diagnostic_5_lab_exam_date']));
            $pIsApplicableSputum = "Y";
            $pDataCollect = "1";
        } else{
            $pLabDateSputum = NULL;
            $pIsApplicableSputum = "N";
            $pDataCollect = "X";
        }
        $pLabFeeSputum = $soapInfo['diagnostic_5_lab_fee'];
        $pCoPaySputum = $soapInfo['diagnostic_5_copay'];
        $pFindingsSputum = $soapInfo['diagnostic_5_sputum'];
        $pRemarksSputum = $soapInfo['diagnostic_5_sputum_remarks'];
        $pNoPlusses = $soapInfo['diagnostic_5__plusses'];
        insertResultsSputum($pCaseNo,$pLabDateSputum, $pLabFeeSputum, $pCoPaySputum, $pReferralFacilitySputum, $pFindingsSputum, $pRemarksSputum, $pNoPlusses, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableSputum,$pDataCollect);

        /* Results - Lipid Profile */
        $pReferralFacilityLipid=strtoupper($soapInfo['diagnostic_6_accre_diag_fac']);
        if($soapInfo['diagnostic_6_lab_exam_date'] != NULL){
            $pLabDateLipid = date('Y-m-d',strtotime($soapInfo['diagnostic_6_lab_exam_date']));
            $pIsApplicableLipid = "Y";
        } else{
            $pLabDateLipid = NULL;
            $pIsApplicableLipid = "N";
        }
        $pLabFeeLipid = $soapInfo['diagnostic_6_lab_fee'];
        $pCoPayLipid = $soapInfo['diagnostic_6_copay'];
        $pLdl = $soapInfo['diagnostic_6_ldl'];
        $pHdl = $soapInfo['diagnostic_6_hdl'];
        $pTotal = $soapInfo['diagnostic_6_total'];
        $pCholesterol = $soapInfo['diagnostic_6_cholesterol'];
        $pTriglycerides = $soapInfo['diagnostic_6_triglycerides'];
        insertResultsLipidProfile($pCaseNo,$pLabDateLipid, $pLabFeeLipid, $pCoPayLipid, $pReferralFacilityLipid, $pLdl, $pHdl, $pTotal, $pCholesterol, $pTriglycerides, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableLipid);

        /* Results - Fasting Blood Sugar (FBS) */
        $pReferralFacilityFBS = strtoupper($soapInfo['diagnostic_7_accre_diag_fac']);
        if($soapInfo['diagnostic_7_lab_exam_date'] != NULL){
            $pLabDateFBS = date('Y-m-d',strtotime($soapInfo['diagnostic_7_lab_exam_date']));
            $pIsApplicableFbs = "Y";
        } else{
            $pLabDateFBS = NULL;
            $pIsApplicableFbs = "N";
        }
        $pLabFeeFBS = $soapInfo['diagnostic_7_lab_fee'];
        $pCoPayFBS = $soapInfo['diagnostic_7_copay'];
        $pGlucoseMg = $soapInfo['diagnostic_7_glucose_mgdL'];
        $pGlucosemmol = $soapInfo['diagnostic_7_glucose_mmolL'];
        insertResultsFBS($pCaseNo,$pLabDateFBS, $pLabFeeFBS, $pCoPayFBS, $pReferralFacilityFBS, $pGlucoseMg, $pGlucosemmol, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableFbs);

        /* Results - Electrocardiogram (ECG) */
        $pReferralFacilityECG = strtoupper($soapInfo['diagnostic_9_accre_diag_fac']);
        if($soapInfo['diagnostic_9_lab_exam_date'] != NULL){
            $pLabDateECG = date('Y-m-d',strtotime($soapInfo['diagnostic_9_lab_exam_date']));
            $pIsApplicableEcg = "Y";
        } else{
            $pLabDateECG = NULL;
            $pIsApplicableEcg = "N";
        }
        $pLabFeeECG = $soapInfo['diagnostic_9_lab_fee'];
        $pCoPayECG = $soapInfo['diagnostic_9_copay'];
        $pFindingsECG = $soapInfo['diagnostic_9_ecg'];
        $pRemarksECG = $soapInfo['diagnostic_9_ecg_remarks'];
        insertResultsECG($pCaseNo,$pLabDateECG, $pLabFeeECG, $pCoPayECG, $pReferralFacilityECG, $pFindingsECG, $pRemarksECG, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableEcg);

        /* Results - Paps Smear */
        $pReferralFacilityPaps = strtoupper($soapInfo['diagnostic_13_accre_diag_fac']);
        if($soapInfo['diagnostic_13_lab_exam_date'] != NULL){
            $pLabDatePapsSmear = date('Y-m-d',strtotime($soapInfo['diagnostic_13_lab_exam_date']));
            $pIsApplicablePaps = "Y";
        } else{
            $pLabDatePapsSmear = NULL;
            $pIsApplicablePaps = "N";
        }
        $pLabFeePapsSmear = $soapInfo['diagnostic_13_lab_fee'];
        $pCoPayPapsSmear = $soapInfo['diagnostic_13_copay'];
        $pFindingsPapsSmear = $soapInfo['diagnostic_13_papsSmearFindings'];
        $pImpressionPapsSmear = $soapInfo['diagnostic_13_papsSmearImpression'];
        insertResultsPapsSmear($pCaseNo,$pLabDatePapsSmear,$pLabFeePapsSmear,$pCoPayPapsSmear,$pReferralFacilityPaps, $pFindingsPapsSmear,$pImpressionPapsSmear,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicablePaps);

        /* Results - Oral Glucose Tolerance Test (OGTT) */
        $pReferralFacilityOGTT = strtoupper($soapInfo['diagnostic_13_accre_diag_fac']);
        if($soapInfo['diagnostic_14_lab_exam_date'] != NULL){
            $pLabDateOGTT = date('Y-m-d',strtotime($soapInfo['diagnostic_14_lab_exam_date']));
            $pIsApplicableOgtt = "Y";
        } else{
            $pLabDateOGTT = NULL;
            $pIsApplicableOgtt = "N";
        }
        $pLabFeeOGTT = $soapInfo['diagnostic_14_lab_fee'];
        $pCoPayOGTT = $soapInfo['diagnostic_14_copay'];
        $pFastingMg = $soapInfo['diagnostic_14_fasting_mg'];
        $pFastingMmol = $soapInfo['diagnostic_14_fasting_mmol'];
        $pOgttOneHrMg= $soapInfo['diagnostic_14_oneHr_mg'];
        $pOgttOneHrMmol = $soapInfo['diagnostic_14_oneHr_mmol'];
        $pOgttTwoHrsMg = $soapInfo['diagnostic_14_twoHr_mg'];
        $pOgttTwoHrsMmol = $soapInfo['diagnostic_14_twoHr_mmol'];
        insertResultsOGTT($pCaseNo, $pLabDateOGTT,$pLabFeeOGTT,$pCoPayOGTT,$pReferralFacilityOGTT,$pFastingMg,$pFastingMmol,$pOgttOneHrMg,$pOgttOneHrMmol,$pOgttTwoHrsMg,$pOgttTwoHrsMmol,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule, $pIsApplicableOgtt);
        /*End Laboratory Results*/

        /*Start Medicine*/
        /*Medicine*/
        $pDoctorName = $soapInfo['pPrescDoctor'];
        $pDrugCodeMeds = $soapInfo['pDrugCodeMeds'];
        $pGenCodeMeds = $soapInfo['pGenCodeMeds'];
        $pStrengthMeds = $soapInfo['pStrengthMeds'];
        $pFormMeds = $soapInfo['pFormMeds'];
        $pPackageMeds = $soapInfo['pPackageMeds'];
        $pQuantityMeds = $soapInfo['pQtyMeds'];
        $pUnitPriceMeds = $soapInfo['pUnitPriceMeds'];
        $pCopayMeds = $soapInfo['pCoPaymentMeds'];
        $pTotalAmtPriceMeds = $soapInfo['pTotalPriceMeds'];
        $pInsQtyMeds = $soapInfo['pQtyInsMeds'];
        $pInsStrengthMeds = $soapInfo['pStrengthMeds'];
        $pInsFreqMeds = strtoupper($soapInfo['pFrequencyMeds']);
        $pGenericName = $soapInfo['pGenericName'];

        if($pDrugCodeMeds != NULL) {
            $pApplicable = "Y";
            for ($i = 0; $i < count($pGenCodeMeds); $i++) {
                insertMedicine($pDrugCodeMeds[$i], $pGenCodeMeds[$i], $pStrengthMeds[$i], $pFormMeds[$i], $pPackageMeds[$i],
                    $pQuantityMeds[$i], $pUnitPriceMeds[$i], $pCopayMeds[$i], $pTotalAmtPriceMeds[$i], $pInsQtyMeds[$i], $pInsStrengthMeds[$i], $pInsFreqMeds[$i],
                    $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pDoctorName, $pApplicable,$pGenericName, "", "","");
            }
        }
        else{
            $pApplicable = "N";
            insertMedicine(NULL, NULL, NULL, NULL, NULL,
                NULL, NULL, NULL,NULL, NULL, NULL, NULL,
                $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pDoctorName, $pApplicable, NULL,NULL, NULL, NULL);
        }
        /*End Medicine*/

        $conn->commit();

        echo '<script>alert("Successfully saved!");</script>';
        //window.location="consultation_search.php";

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: saveSOAP - " . $e->getMessage();
        echo '<script>alert("Error: saveSOAP - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Update Consultation - Patient Information Sub-module*/
function updateConsultationPatientInfo($pCaseNo, $pTransNo, $pHciNo, $pPatientPin, $pPatientType, $pMemPin, $pSoapDate, $pUserId, $pEffYear, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE ".$ini['EPCB'].".TSEKAP_TBL_SOAP
                                    SET HCI_NO = :hciNo,
                                        PX_PIN = :pxPin,
                                        PX_TYPE = :pxType,
                                        MEM_PIN = :memPin,
                                        SOAP_DATE = :soapDate,
                                        SOAP_BY = :soapBy,
                                        DATE_ADDED = NOW(),
                                        EFF_YEAR = :effYear,
                                        UPD_CNT = :updCnt
                                    WHERE TRANS_NO = :transNo
                                      AND CASE_NO = :caseNo");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':hciNo', $pHciNo);
        $stmt->bindParam(':pxPin', $pPatientPin);
        $stmt->bindParam(':pxType', $pPatientType);
        $stmt->bindParam(':memPin', $pMemPin);
        $stmt->bindParam(':soapDate', $pSoapDate);
        $stmt->bindParam(':soapBy', $pUserId);
        $stmt->bindParam(':effYear', $pEffYear);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C01" . $e->getMessage();
        echo '<script>alert("Error: C01'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Consultation - Patient Information Sub-module*/
function insertConsultationPatientInfo($pCaseNo, $pTransNo, $pHciNo, $pPatientPin, $pPatientType, $pMemPin, $pSoapDate, $pUserId, $pEffYear, $pSoapOtp, $getUpdCnt, $pXPSmodule){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP(
                        CASE_NO, TRANS_NO, HCI_NO, PX_PIN, PX_TYPE, MEM_PIN, SOAP_DATE, SOAP_BY,DATE_ADDED,EFF_YEAR,SOAP_OTP,UPD_CNT,XPS_MODULE) 
                          VALUES(:caseNo, 
                                 :transNo, 
                                 :hciNo,
                                 :pxPin, 
                                 :pxType, 
                                 :memPin, 
                                 :soapDate, 
                                 :soapBy,
                                 NOW(), 
                                 :effYear,
                                 :soapOTP,
                                 :updCnt,
                                 :xpsMod)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':hciNo', $pHciNo);
        $stmt->bindParam(':pxPin', $pPatientPin);
        $stmt->bindParam(':pxType', $pPatientType);
        $stmt->bindParam(':memPin', $pMemPin);
        $stmt->bindParam(':soapDate', date('Y-m-d', strtotime($pSoapDate)));
        $stmt->bindParam(':soapBy', $pUserId);
        $stmt->bindParam(':effYear', $pEffYear);
        $stmt->bindParam(':soapOTP', $pSoapOtp);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsMod', $pXPSmodule);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C01" . $e->getMessage();
        echo '<script>alert("Error: C01'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Subjective/ History of Illness Sub-module*/
function insertSubjectiveHistory($pUserId, $pTransNo, $pChiefComplaint, $pIllnessHist, $pOtherComplaint, $getUpdCnt, $pSymptoms, $pPainSite){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_SUBJECTIVE(
                                DATE_ADDED, ADDED_BY, TRANS_NO, CHIEF_COMPLAINT, ILLNESS_HISTORY, OTHER_COMPLAINT, UPD_CNT, SIGNS_SYMPTOMS, PAIN_SITE) 
                                  VALUES(NOW(),
                                         :addedBy, 
                                         :transNo,
                                         :chiefComplaint, 
                                         :illnessHist,
                                         :othComplaint,
                                         :updCnt,
                                         :signsSymptoms,
                                         :painSite)");

        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':chiefComplaint', strtoupper($pChiefComplaint));
        $stmt->bindParam(':illnessHist',strtoupper($pIllnessHist));
        $stmt->bindParam(':othComplaint',strtoupper($pOtherComplaint));
        $stmt->bindParam(':updCnt',$getUpdCnt);
        $stmt->bindParam(':signsSymptoms',$pSymptoms);
        $stmt->bindParam(':painSite',strtoupper($pPainSite));
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C02" . $e->getMessage();
        echo '<script>alert("Error: C02'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Obligated Services*/
function insertObligatedServices($pUserId, $pTransNo, $pServiceID, $pReasonID, $pRemarks, $pServiceValue, $pBPType, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_OBLIGATED(
                        DATE_ADDED, ADDED_BY, TRANS_NO, SERVICE_ID, REASON_ID, REMARKS, SERVICE_VALUE, BP_TYPE, UPD_CNT) 
                          VALUES( NOW(), 
                                 :addedBy, 
                                 :transNo,
                                 :serviceId, 
                                 :reasonId, 
                                 :remarks, 
                                 :serviceValue, 
                                 :bpType,
                                 :updCnt)");

        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':serviceId', $pServiceID);
        $stmt->bindParam(':reasonId', $pReasonID);
        $stmt->bindParam(':remarks', $pRemarks);
        $stmt->bindParam(':serviceValue', $pServiceValue);
        $stmt->bindParam(':bpType', $pBPType);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C03" . $e->getMessage();
        echo '<script>alert("Error: C03'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Objective/Physical Examination Sub-module*/
/*Part 1*/
function insertObjectivePhysicalExam($pSystolic, $pDiastolic, $pHr, $pRr, $pHeight, $pWeight, $pTemperature, $pUserId, $pTransNo, $pVision, $pLength, $pHeadCirc, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_PEPERT(
                                SYSTOLIC, DIASTOLIC, HR, RR, HEIGHT, WEIGHT, TEMPERATURE, DATE_ADDED, ADDED_BY, TRANS_NO, VISION, LENGTH, HEAD_CIRC, UPD_CNT) 
                                  VALUES(:systolic, 
                                         :diastolic, 
                                         :hr, 
                                         :rr, 
                                         :height, 
                                         :weight, 
                                         :temp, 
                                         NOW(), 
                                         :addedBy, 
                                         :transNo, 
                                         :vision, 
                                         :length, 
                                         :headCirc,
                                         :updCnt)");

        $stmt->bindParam(':systolic', $pSystolic);
        $stmt->bindParam(':diastolic', $pDiastolic);
        $stmt->bindParam(':hr', $pHr);
        $stmt->bindParam(':rr', $pRr);
        $stmt->bindParam(':height', $pHeight);
        $stmt->bindParam(':weight', $pWeight);
        $stmt->bindParam(':temp',$pTemperature);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':vision', $pVision);
        $stmt->bindParam(':length', $pLength);
        $stmt->bindParam(':headCirc', $pHeadCirc);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C04" . $e->getMessage();
        echo '<script>alert("Error: C04'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Part 2*/
function insertPhysicalExamMisc($pSkin, $pHeent, $pChest, $pHeart, $pAbdomen, $pNeuro, $pGU, $pRectal, $pTransNo, $pUserId,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_PEMISC(
                        SKIN_ID, HEENT_ID, CHEST_ID, HEART_ID, ABDOMEN_ID, NEURO_ID, GU_ID, RECTAL_ID, TRANS_NO, DATE_ADDED, ADDED_BY, UPD_CNT) 
                          VALUES(:skinId, 
                                 :heentId, 
                                 :chestId, 
                                 :heartId, 
                                 :abdomenId, 
                                 :neuroId, 
                                 :guId,
                                 :rectalId,
                                 :transNo, 
                                 NOW(), 
                                 :addedBy,
                                 :updCnt)");

        $stmt->bindParam(':skinId', $pSkin);
        $stmt->bindParam(':heentId',$pHeent);
        $stmt->bindParam(':chestId', $pChest);
        $stmt->bindParam(':heartId', $pHeart);
        $stmt->bindParam(':abdomenId', $pAbdomen);
        $stmt->bindParam(':neuroId', $pNeuro);
        $stmt->bindParam(':guId', $pGU);
        $stmt->bindParam(':rectalId', $pRectal);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C05" . $e->getMessage();
        echo '<script>alert("Error: C05'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Part 3 Remarks*/
function insertPhysicalExamMiscRemarks($pHeentRemarks, $pChestRemarks, $pHeartRemarks, $pAbdomenRemarks, $pGenitoRemarks, $pRectalRemarks, $pSkinExtremitiesRemarks, $pNeuroRemarks, $pTransNo, $pUserId, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_PESPECIFIC(
                                SKIN_REM,HEENT_REM,CHEST_REM,HEART_REM,ABDOMEN_REM,NEURO_REM,GU_REM,RECTAL_REM,TRANS_NO,DATE_ADDED,ADDED_BY,UPD_CNT) 
                                  VALUES(:skinRem, 
                                         :heentRem, 
                                         :chestRem, 
                                         :heartRem, 
                                         :abdomenRem, 
                                         :neuroRem,
                                         :guRem,
                                         :rectalRem,
                                         :transNo,
                                         NOW(), 
                                         :addedBy,
                                         :updCnt)");

        $stmt->bindParam(':skinRem', $pSkinExtremitiesRemarks);
        $stmt->bindParam(':heentRem', $pHeentRemarks);
        $stmt->bindParam(':chestRem', $pChestRemarks);
        $stmt->bindParam(':heartRem', $pHeartRemarks);
        $stmt->bindParam(':abdomenRem', $pAbdomenRemarks);
        $stmt->bindParam(':neuroRem',$pNeuroRemarks);
        $stmt->bindParam(':guRem',$pGenitoRemarks);
        $stmt->bindParam(':rectalRem',$pRectalRemarks);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt',$getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C06" . $e->getMessage();
        echo '<script>alert("Error: C06'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Assessment/Diagnosis Sub-module*/
function insertAssessmentDiagnosis($pUserId, $pTransNo, $pDiagnosis, $pSeqNo, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_ICD(
                    TRANS_NO, ICD_CODE, DATE_ADDED, ADDED_BY, SEQ_NO, UPD_CNT) 
                      VALUES(:transNo, 
                             :icdCode, 
                             NOW(), 
                             :addedBy, 
                             :seqNo,
                             :updCnt)");

        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':icdCode', $pDiagnosis);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':seqNo', $pSeqNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C07" . $e->getMessage();
        echo '<script>alert("Error: C07'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Plan/Management Sub-module in Consultation*/
/*Plan/Management - Diagnosis Examination*/
function insertDiagnosticExamination($pDiagnostic, $pOthRemarks, $pUserId, $pTransNo, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC(
                                DIAGNOSTIC_ID, DATE_ADDED, ADDED_BY, TRANS_NO, OTH_REMARKS, UPD_CNT) 
                                  VALUES(:diagnosticId,
                                         NOW(),
                                         :addedBy,
                                         :transNo,
                                         :othRemarks,
                                         :updCnt)");

        $stmt->bindParam(':diagnosticId', $pDiagnostic);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':othRemarks', $pOthRemarks);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C08" . $e->getMessage();
        echo '<script>alert("Error: C08'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/* Plan/Management - Management */
function insertManagement($pManagement, $pUserId, $pTransNo, $pOthMgmtRemarks,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MANAGEMENT(
                   MANAGEMENT_ID, DATE_ADDED, ADDED_BY, TRANS_NO, OTH_REMARKS,UPD_CNT) 
                      VALUES(:managementId, 
                             NOW(), 
                             :addedBy, 
                             :transNo, 
                             :othRemarks,
                             :updCnt)");

        $stmt->bindParam(':managementId', $pManagement);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':othRemarks', $pOthMgmtRemarks);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C09" . $e->getMessage();
        echo '<script>alert("Error: C09'.$e->getMessage().'");</script>';
    }

    $conn = null;
}
/* Plan/Management - Management */
function insertAdvice($pAdviceRemarks, $pUserId, $pTransNo, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_SOAP_ADVICE(
                           REMARKS, DATE_ADDED, ADDED_BY, TRANS_NO, UPD_CNT) 
                              VALUES(:remarks, 
                                     NOW(), 
                                     :addedBy, 
                                     :transNo,
                                     :updCnt)");

        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':remarks', $pAdviceRemarks);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C10" . $e->getMessage();
        echo '<script>alert("Error: C10'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Medicine*/
function insertMedicine($pDrugCode, $pGenCodeMed, $pStrengthMed, $pFormMed, $pPackageMed,
                        $pQuantityMed, $pUnitPriceMed, $pCopayMed, $pTotalAmtPriceMed,$pInsQtyMed,$pInsStrengthMed,$pInsFreqMed,
                        $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pPrescDoc, $pIsApplicable, $pGenericName, $pSaltMed, $pUnitMed, $pRouteMed){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_MEDICINE(
                               CASE_NO, TRANS_NO, DRUG_CODE, GEN_CODE, STRENGTH_CODE, FORM_CODE, PACKAGE_CODE, INS_QUANTITY, INS_STRENGTH, INS_FREQUENCY,
                               QUANTITY, DRUG_ACTUAL_PRICE, CO_PAYMENT, AMT_PRICE, PRESC_PHYSICIAN, IS_APPLICABLE, XPS_MODULE, DATE_ADDED, ADDED_BY, UPD_CNT, GENERIC_NAME,
                               SALT_CODE, UNIT_CODE, ROUTE) 
                                  VALUES(:caseNo,
                                         :transNo,
                                         :drugCode,
                                         :genCode,
                                         :streCode, 
                                         :formCode,
                                         :packCode,
                                         :insQty,
                                         :insStre,
                                         :insFreq,
                                         :qty,
                                         :unitPrice,
                                         :coPay,
                                         :amtPrice,  
                                         :prescDoc,
                                         :isApplicable,                                       
                                         :xpsModule,
                                         NOW(),
                                         :addedBy,
                                         :updCnt,
                                         :genname,
                                         :saltCode,
                                         :unitCode,
                                         :route)");

        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':drugCode', $pDrugCode);
        $stmt->bindParam(':genCode', $pGenCodeMed);
        $stmt->bindParam(':streCode', $pStrengthMed);
        $stmt->bindParam(':formCode', $pFormMed);
        $stmt->bindParam(':packCode', $pPackageMed);
        $stmt->bindParam(':insQty', $pInsQtyMed);
        $stmt->bindParam(':insStre', strtoupper($pInsStrengthMed));
        $stmt->bindParam(':insFreq', strtoupper($pInsFreqMed));
        $stmt->bindParam(':qty', $pQuantityMed);
        $stmt->bindParam(':unitPrice', $pUnitPriceMed);
        $stmt->bindParam(':coPay', $pCopayMed);
        $stmt->bindParam(':amtPrice', $pTotalAmtPriceMed);
        $stmt->bindParam(':prescDoc', strtoupper($pPrescDoc));
        $stmt->bindParam(':isApplicable', strtoupper($pIsApplicable));
        $stmt->bindParam(':xpsModule', $pXPSmodule);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':genname', strtoupper($pGenericName));
        $stmt->bindParam(':saltCode', $pSaltMed);
        $stmt->bindParam(':unitCode', $pUnitMed);
        $stmt->bindParam(':route', strtoupper($pRouteMed));
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: Medicine" . $e->getMessage();
        echo '<script>alert("Error: Medicine - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Plan Management: Diagnostic Examination*/
/*Results - Complete Blood Count */
function insertResultsCBC($pCaseNo, $pLabDate, $pLabFee, $pCoPay, $pReferralFacility, $pHematocrit, $pHemoglobinG, $pHemoglobinMmol, $pMhcPg, $pMhcFmol, $pMchcGhb, $pMchcMmol, $pMcvUm, $pMcvFl, $pWbc1000, $pWbc10, $pMyelocyte,
                          $pNeutrophilsBnd, $pNeurophilsSeg, $pLymphocytes, $pMonocytes, $pEosinophils, $pBasophils, $pPlatelet, $pTransNo, $pUserId, $getUpdCnt, $pXpsModule, $pIsApplicableCbc){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CBC(
                               CASE_NO, TRANS_NO, REFERRAL_FACILITY, LAB_DATE, HEMATOCRIT, HEMOGLOBIN_G, HEMOGLOBIN_MMOL, MHC_PG, MHC_FMOL, MCHC_GHB, MCHC_MMOL, MCV_UM, MCV_FL, WBC_1000, WBC_10, MYELOCYTE,
                               NEUTROPHILS_BND, NEUTROPHILS_SEG, LYMPHOCYTES, MONOCYTES, EOSINOPHILS, BASOPHILS, PLATELET, DATE_ADDED, ADDED_BY, UPD_CNT,XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT, IS_APPLICABLE) 
                                  VALUES(:caseNo,
                                         :transNo,
                                         :referralFacility,
                                         :labDate, 
                                         :hematocrit,
                                         :hemoglobinG,
                                         :hemoglobinMmol,
                                         :mhcPg,
                                         :mhcFmol,
                                         :mchcGhb,
                                         :mchcMmol,
                                         :mcvUm,
                                         :mcvFl,
                                         :wbc1000,
                                         :wbc10,
                                         :myelocyte,
                                         :neutrophilsBnd,
                                         :neurophilsSeg,
                                         :lymphocytes,
                                         :monocytes,
                                         :eosinophils,
                                         :basophils,
                                         :platelet,
                                         NOW(),
                                         :addedBy,
                                         :updCnt,
                                         :xpsModule,
                                         :diagLabFee,
                                         :coPayment,
                                         :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':hematocrit', $pHematocrit);
        $stmt->bindParam(':hemoglobinG', $pHemoglobinG);
        $stmt->bindParam(':hemoglobinMmol', $pHemoglobinMmol);
        $stmt->bindParam(':mhcPg', $pMhcPg);
        $stmt->bindParam(':mhcFmol', $pMhcFmol);
        $stmt->bindParam(':mchcGhb', $pMchcGhb);
        $stmt->bindParam(':mchcMmol', $pMchcMmol);
        $stmt->bindParam(':mcvUm', $pMcvUm);
        $stmt->bindParam(':mcvFl', $pMcvFl);
        $stmt->bindParam(':wbc1000', $pWbc1000);
        $stmt->bindParam(':wbc10', $pWbc10);
        $stmt->bindParam(':myelocyte', $pMyelocyte);
        $stmt->bindParam(':neutrophilsBnd', $pNeutrophilsBnd);
        $stmt->bindParam(':neurophilsSeg', $pNeurophilsSeg);
        $stmt->bindParam(':lymphocytes', $pLymphocytes);
        $stmt->bindParam(':monocytes', $pMonocytes);
        $stmt->bindParam(':eosinophils', $pEosinophils);
        $stmt->bindParam(':basophils', $pBasophils);
        $stmt->bindParam(':platelet', $pPlatelet);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule', $pXpsModule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableCbc);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: D01" . $e->getMessage();
        echo '<script>alert("Error: D01'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/* Results - Urinalysis */
function insertResultsUrinalysis($pCaseNo, $pLabDate, $pLabFee, $pCoPay, $pReferralFacility, $pGravity, $pAppearance, $pColor, $pGlucose, $pProteins, $pKetones, $pPh, $pRbCells, $pWbCells, $pBacteria, $pCrystals,
                                 $pBladderCell, $pSquamousCell, $pTubularCell, $pBroadCasts, $pEpithelialCast, $pGranularCast, $pHyalineCast, $pRbcCast, $pWaxyCast, $pWcCast,
                                 $pAlbumin, $pPusCells, $pTransNo, $pUserId, $getUpdCnt,$pXpsModule,$pIsApplicableUrine){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_URINALYSIS(
                       CASE_NO, TRANS_NO, LAB_DATE, REFERRAL_FACILITY, GRAVITY, APPEARANCE, COLOR, GLUCOSE, PROTEINS, KETONES, PH, RB_CELLS, WB_CELLS, BACTERIA, CRYSTALS, BLADDER_CELL,
                       SQUAMOUS_CELL, TUBULAR_CELL, BROAD_CASTS, EPITHELIAL_CAST,GRANULAR_CAST, HYALINE_CAST, RBC_CAST, WAXY_CAST, WC_CAST, DATE_ADDED, ADDED_BY, UPD_CNT,
                       ALBUMIN, PUS_CELLS, XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT,IS_APPLICABLE) 
                          VALUES(:caseNo,
                                 :transNo,
                                 :labDate,
                                 :referralFacility,
                                 :gravity,
                                 :appearance,
                                 :color,
                                 :glucose,
                                 :proteins,
                                 :ketones,
                                 :ph,
                                 :rbCells,
                                 :wbCells,
                                 :bacteria,
                                 :crystals,
                                 :bladderCell,
                                 :squamousCell,
                                 :tubularCell,
                                 :broadCasts,
                                 :epithelialCast,
                                 :granularCast,
                                 :hyalineCast,
                                 :rbcCast,
                                 :waxyCast,
                                 :wcCast,
                                 NOW(),
                                 :addedBy,
                                 :updCnt,
                                 :albumin,
                                 :pusCells,
                                 :xpsModule,
                                 :diagLabFee,
                                 :coPayment,
                                 :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':gravity', $pGravity);
        $stmt->bindParam(':appearance', $pAppearance);
        $stmt->bindParam(':color',$pColor);
        $stmt->bindParam(':glucose',$pGlucose);
        $stmt->bindParam(':proteins', $pProteins);
        $stmt->bindParam(':ketones', $pKetones);
        $stmt->bindParam(':ph', $pPh);
        $stmt->bindParam(':rbCells', $pRbCells);
        $stmt->bindParam(':wbCells', $pWbCells);
        $stmt->bindParam(':bacteria', $pBacteria);
        $stmt->bindParam(':crystals', $pCrystals);
        $stmt->bindParam(':bladderCell', $pBladderCell);
        $stmt->bindParam(':squamousCell', $pSquamousCell);
        $stmt->bindParam(':tubularCell',$pTubularCell);
        $stmt->bindParam(':broadCasts', $pBroadCasts);
        $stmt->bindParam(':epithelialCast', $pEpithelialCast);
        $stmt->bindParam(':granularCast', $pGranularCast);
        $stmt->bindParam(':hyalineCast', $pHyalineCast);
        $stmt->bindParam(':rbcCast',$pRbcCast);
        $stmt->bindParam(':waxyCast', $pWaxyCast);
        $stmt->bindParam(':wcCast', $pWcCast);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':albumin', $pAlbumin);
        $stmt->bindParam(':pusCells', $pPusCells);
        $stmt->bindParam(':xpsModule', $pXpsModule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableUrine);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: D02" . $e->getMessage();
        echo '<script>alert("Error: D02'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/* Results - Fecalysis */
function  insertResultsFecalysis($pCaseNo, $pLabDate, $pLabFee, $pCoPay, $pReferralFacility, $pColorFecalysis, $pConsistency,$pRBC,$pWBC,$pOva,$pParasite,$pBlood,$pOccultBlood,$pPusCell,
                                 $pTransNo, $pUserId, $getUpdCnt,$pXpsModule,$pIsApplicableFecalysis){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FECALYSIS(
                               CASE_NO, TRANS_NO, LAB_DATE, REFERRAL_FACILITY, COLOR, CONSISTENCY, RBC, WBC, OVA, PARASITE,BLOOD, OCCULT_BLOOD,PUS_CELLS, DATE_ADDED, ADDED_BY, 
                               UPD_CNT,XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT,IS_APPLICABLE)
                                  VALUES(:caseNo,
                                         :transNo,
                                         :labDate,
                                         :referralFacility,
                                         :color,
                                         :consistency,
                                         :rbc,
                                         :wbc,
                                         :ova,
                                         :parasite,
                                         :blood,
                                         :occultBlood,
                                         :pusCell,
                                         NOW(),
                                         :addedBy,
                                         :updCnt,
                                         :xpsModule,
                                         :diagLabFee,
                                         :coPayment,
                                         :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':color', $pColorFecalysis);
        $stmt->bindParam(':consistency', $pConsistency);
        $stmt->bindParam(':rbc', $pRBC);
        $stmt->bindParam(':wbc', $pWBC);
        $stmt->bindParam(':ova', $pOva);
        $stmt->bindParam(':parasite', $pParasite);
        $stmt->bindParam(':blood', $pBlood);
        $stmt->bindParam(':occultBlood', $pOccultBlood);
        $stmt->bindParam(':pusCell', $pPusCell);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule',$pXpsModule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableFecalysis);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: D03" . $e->getMessage();
        echo '<script>alert("Error: D03'.$e->getMessage().'");</script>';
    }

    $conn = null;
}
/* Results - Chest X-Ray */
function  insertResultsChestXray($pCaseNo, $pLabDate, $pLabFee, $pCoPay, $pReferralFacility,$pFindingsXray,$pRemarkFindings,$pObservation,$pRemarkObservation,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicableXray){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CHESTXRAY(
                               CASE_NO, TRANS_NO, LAB_DATE, REFERRAL_FACILITY, FINDINGS, REMARKS_FINDINGS, OBSERVATION, REMARKS_OBSERVATION, DATE_ADDED, ADDED_BY, UPD_CNT,XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT,IS_APPLICABLE) 
                                  VALUES(:caseNo,
                                         :transNo,
                                         :labDate,
                                         :referralFacility,
                                         :findings,
                                         :remarkFindings,
                                         :observation,
                                         :remarkObservation,
                                         NOW(),
                                         :addedBy,
                                         :updCnt,
                                         :xpsModule,
                                         :diagLabFee,
                                         :coPayment,
                                         :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':findings',$pFindingsXray);
        $stmt->bindParam(':remarkFindings', $pRemarkFindings);
        $stmt->bindParam(':observation', $pObservation);
        $stmt->bindParam(':remarkObservation', $pRemarkObservation);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule', $pXPSmodule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableXray);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: D04" . $e->getMessage();
        echo '<script>alert("Error: D04'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/* Results - Sputum */
function  insertResultsSputum($pCaseNo, $pLabDate, $pLabFee, $pCoPay, $pReferralFacility,$pFindingsSputum,$pRemarksSputum,$pNoPlusses,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicableSputum,$pDataCollect){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_SPUTUM(
                               CASE_NO, TRANS_NO, LAB_DATE, REFERRAL_FACILITY, FINDINGS, REMARKS, NO_PLUSSES, DATE_ADDED, ADDED_BY, UPD_CNT,XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT,IS_APPLICABLE,DATA_COLLECTION) 
                                  VALUES(:caseNo,
                                         :transNo,
                                         :labDate,
                                         :referralFacility,
                                         :findings,
                                         :remarks,
                                         :noPlusses,
                                         NOW(),
                                         :addedBy,
                                         :updCnt,
                                         :xpsModule,
                                         :diagLabFee,
                                         :coPayment,
                                         :isApplicable,
                                         :dataCollect)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':findings', $pFindingsSputum);
        $stmt->bindParam(':remarks', $pRemarksSputum);
        $stmt->bindParam(':noPlusses', $pNoPlusses);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule', $pXPSmodule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableSputum);
        $stmt->bindParam(':dataCollect', $pDataCollect);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: D05" . $e->getMessage();
        echo '<script>alert("Error: D05'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/* Results - Lipid Profile */
function  insertResultsLipidProfile($pCaseNo, $pLabDate, $pLabFee, $pCoPay, $pReferralFacility,$pLdl,$pHdl,$pTotal,$pCholesterol,$pTriglycerides,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicableLipid){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_LIPIDPROF(
                                CASE_NO, TRANS_NO, REFERRAL_FACILITY, LAB_DATE, LDL, HDL, TOTAL, CHOLESTEROL, TRIGLYCERIDES, DATE_ADDED, ADDED_BY, UPD_CNT, XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT,IS_APPLICABLE) 
                                  VALUES(:caseNo,
                                         :transNo,
                                         :referralFacility,
                                         :labDate,
                                         :ldl,
                                         :hdl,
                                         :total,
                                         :cholesterol,
                                         :triglycerides,
                                         NOW(),
                                         :addedBy,
                                         :updCnt,
                                         :xpsModule,
                                         :diagLabFee,
                                         :coPayment,
                                         :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':ldl', $pLdl);
        $stmt->bindParam(':hdl', $pHdl);
        $stmt->bindParam(':total', $pTotal);
        $stmt->bindParam(':cholesterol', $pCholesterol);
        $stmt->bindParam(':triglycerides', $pTriglycerides);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule', $pXPSmodule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableLipid);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: D06" . $e->getMessage();
        echo '<script>alert("Error: D06'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/* Results - Fasting Blood Sugar */
function  insertResultsFBS($pCaseNo, $pLabDate, $pLabFee, $pCoPay,$pReferralFacility,$pGlucoseMg,$pGlucosemmol,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicableFbs){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FBS(
                               CASE_NO,TRANS_NO, LAB_DATE, REFERRAL_FACILITY, GLUCOSE_MG, GLUCOSE_MMOL, DATE_ADDED, ADDED_BY, UPD_CNT, XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT,IS_APPLICABLE) 
                                  VALUES(:caseNo,
                                         :transNo,
                                         :labDate,
                                         :referralFacility,
                                         :glucoseMg,
                                         :glucoseMmol,
                                         NOW(),
                                         :addedBy,
                                         :updCnt,
                                         :xpsModule,
                                         :diagLabFee,
                                         :coPayment,
                                         :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':glucoseMg', $pGlucoseMg);
        $stmt->bindParam(':glucoseMmol', $pGlucosemmol);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule', $pXPSmodule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableFbs);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: D07" . $e->getMessage();
        echo '<script>alert("Error: D07'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/* Results - ECG */
function  insertResultsECG($pCaseNo,$pLabDate, $pLabFee, $pCoPay,$pReferralFacility,$pFindingsECG,$pRemarksECG,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicableEcg){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_ECG(
                       CASE_NO, TRANS_NO, LAB_DATE, REFERRAL_FACILITY, FINDINGS, REMARKS, DATE_ADDED, ADDED_BY, UPD_CNT, XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT,IS_APPLICABLE) 
                          VALUES(:caseNo,
                                 :transNo,
                                 :labDate,
                                 :referralFacility,
                                 :findings,
                                 :remarks,
                                 NOW(),
                                 :addedBy,
                                 :updCnt,
                                 :xpsModule,
                                 :diagLabFee,
                                 :coPayment,
                                 :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':findings', $pFindingsECG);
        $stmt->bindParam(':remarks', $pRemarksECG);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule', $pXPSmodule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableEcg);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/* Results - Paps Smear */
function  insertResultsPapsSmear($pCaseNo,$pLabDate, $pLabFee, $pCoPay,$pReferralFacility,$pFindingsPaps,$pImpressionPaps,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicablePaps){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_PAPSSMEAR(
                       CASE_NO,TRANS_NO, LAB_DATE, REFERRAL_FACILITY, FINDINGS, IMPRESSION, DATE_ADDED, ADDED_BY, UPD_CNT, XPS_MODULE,DIAGNOSTIC_FEE,CO_PAYMENT,IS_APPLICABLE) 
                          VALUES(:caseNo,
                                 :transNo,
                                 :labDate,
                                 :referralFacility,
                                 :findings,
                                 :impression,
                                 NOW(),
                                 :addedBy,
                                 :updCnt,
                                 :xpsModule,
                                 :diagLabFee,
                                 :coPayment,
                                 :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':findings', $pFindingsPaps);
        $stmt->bindParam(':impression', $pImpressionPaps);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule', $pXPSmodule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicablePaps);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/* Results - Oral Glucose Tolerance Test (OGTT)*/
function  insertResultsOGTT($pCaseNo, $pLabDate, $pLabFee, $pCoPay,$pReferralFacility,$pFastingMg,$pFastingMmol,$pOgttOneHrMg,$pOgttOneHrMmol,$pOgttTwoHrsMg,$pOgttTwoHrsMmol,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicableOgtt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_DIAG_OGTT(
                       CASE_NO,TRANS_NO, LAB_DATE, REFERRAL_FACILITY, EXAM_FASTING_MG, EXAM_FASTING_MMOL, EXAM_OGTT_ONE_MG, EXAM_OGTT_ONE_MMOL, EXAM_OGTT_TWO_MG, EXAM_OGTT_TWO_MMOL, 
                       DATE_ADDED, ADDED_BY, UPD_CNT, XPS_MODULE, DIAGNOSTIC_FEE, CO_PAYMENT, IS_APPLICABLE) 
                          VALUES(:caseNo,
                                 :transNo,
                                 :labDate,
                                 :referralFacility,
                                 :fastingMg,
                                 :fastingMmol,
                                 :oneHrMg,
                                 :oneHrMmol,
                                 :twoHrsMg,
                                 :twoHrsMmol,
                                 NOW(),
                                 :addedBy,
                                 :updCnt,
                                 :xpsModule,
                                 :diagLabFee,
                                 :coPayment,
                                 :isApplicable)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':labDate', $pLabDate);
        $stmt->bindParam(':referralFacility', $pReferralFacility);
        $stmt->bindParam(':fastingMg', $pFastingMg);
        $stmt->bindParam(':fastingMmol', $pFastingMmol);
        $stmt->bindParam(':oneHrMg', $pOgttOneHrMg);
        $stmt->bindParam(':oneHrMmol', $pOgttOneHrMmol);
        $stmt->bindParam(':twoHrsMg', $pOgttTwoHrsMg);
        $stmt->bindParam(':twoHrsMmol', $pOgttTwoHrsMmol);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':xpsModule', $pXPSmodule);
        $stmt->bindParam(':diagLabFee', $pLabFee);
        $stmt->bindParam(':coPayment', $pCoPay);
        $stmt->bindParam(':isApplicable', $pIsApplicableOgtt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
/*Generation of Report - HCI Profile Information*/
function getHciProfileInfo($pAccreNo, $pUserId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_TBL_HCI_PROFILE
                                                WHERE ACCRE_NO = :accreNo
                                                AND USER_ID = :userId");

        $stmt->bindParam(':accreNo', $pAccreNo);
        $stmt->bindParam(':userId', $pUserId);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*Generation of Report - Enlistment/Registration*/
function getReportResultEnlistment($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                        WHERE TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate
                                          AND XPS_MODULE = 'EPCB'");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*Generation of Report - Profiling*/
function getReportResultProfiling($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, profile.TRANS_NO AS TRANS_NO, advice.REMARKS AS ADVICE_REM, profile.REMARKS AS PROFILE_REM
                                    FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENT DETAILS*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_OINFO AS oinfo ON profile.TRANS_NO = oinfo.TRANS_NO /*PATIENTS DETAILS OTHER INFO*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_SOCHIST AS sochist ON profile.TRANS_NO = sochist.TRANS_NO /*PERSONAL/SOCIAL HISTORY*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PREGHIST AS preghist ON profile.TRANS_NO = preghist.TRANS_NO /*OB-GYNE HISTORY - PREGNANCY*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MENSHIST AS menshist ON profile.TRANS_NO = menshist.TRANS_NO /*OB-GYNE HISTORY - MENSTRUAL*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEPERT AS pepert ON profile.TRANS_NO = pepert.TRANS_NO /*PERTINENT PHYSICAL EXAMINATION FINDINGS*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_BLOODTYPE AS bloodtype ON profile.TRANS_NO = bloodtype.TRANS_NO /*PERTINENT PHYSICAL EXAMINATION FINDINGS - BLOOD TYPE*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PESPECIFIC AS pespecific ON profile.TRANS_NO = pespecific.TRANS_NO /*PERTINENT PHYSICAL EXAMINATION FINDINGS - REMARKS*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_NCDQANS AS ncdqans ON profile.TRANS_NO = ncdqans.TRANS_NO /*NCD HIGH-RISK ASSESSMENT*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_ADVICE AS advice ON profile.TRANS_NO = advice.TRANS_NO /*PLAN/MANAGEMENT - ADVICE*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEGENSURVEY AS survey ON profile.TRANS_NO = survey.TRANS_NO /*PLAN/MANAGEMENT - ADVICE*/
                                            WHERE profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND oinfo.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_OINFO)
                                              AND sochist.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_SOCHIST)
                                              AND preghist.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_PREGHIST)
                                              AND menshist.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_MENSHIST)
                                              AND pepert.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_PEPERT)
                                              AND bloodtype.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_BLOODTYPE)
                                              AND pespecific.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_PESPECIFIC)
                                              AND ncdqans.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_NCDQANS)
                                              AND advice.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_ADVICE)
                                                ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - MEDICAL HISTORY*/
function getReportResultProfilingMedHist($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT medhist.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MEDHIST AS medhist ON profile.TRANS_NO = medhist.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND medhist.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_MEDHIST)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - MEDICAL HISTORY REMARKS*/
function getReportResultProfilingMHspecific($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT mhspecific.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MHSPECIFIC AS mhspecific ON profile.TRANS_NO = mhspecific.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND mhspecific.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_MHSPECIFIC)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - PERTINENT FINDINGS PER SYSTEM*/
function getReportResultProfilingPEmisc($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT pemisc.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEMISC AS pemisc ON profile.TRANS_NO = pemisc.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND pemisc.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_PEMISC)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - SURGICAL HISTORY*/
function getReportResultProfilingSurghist($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT surghist.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_SURGHIST AS surghist ON profile.TRANS_NO = surghist.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND surghist.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_SURGHIST)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - FAMILY HISTORY*/
function getReportResultProfilingFamhist($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT famhist.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_FAMHIST AS famhist ON profile.TRANS_NO = famhist.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND famhist.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_FAMHIST)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - FAMILY HISTORY REMARKS*/
function getReportResultProfilingFHspecific($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT fhspecific.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_FHSPECIFIC AS fhspecific ON profile.TRANS_NO = fhspecific.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND fhspecific.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_FHSPECIFIC)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - IMMUNIZATION*/
function getReportResultProfilingImmunization($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT immune.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_IMMUNIZATION AS immune ON profile.TRANS_NO = immune.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND immune.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_IMMUNIZATION)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - DIAGNOSTIC*/
function getReportResultProfilingDiagnostic($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT diagnostic.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_DIAGNOSTIC AS diagnostic ON profile.TRANS_NO = diagnostic.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND diagnostic.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_DIAGNOSTIC)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Profiling - MANAGEMENT*/
function getReportResultProfilingManagement($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT management.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.DATE_ADDED, profile.EFF_YEAR, profile.IS_FINALIZE
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MANAGEMENT AS management ON profile.TRANS_NO = management.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'HSA'
                                              AND profile.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND management.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND profile.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_PROF_MANAGEMENT)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Consultation*/
function getReportResultConsultation($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, soap.TRANS_NO 
                                      FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_ADVICE as advice ON soap.TRANS_NO = advice.TRANS_NO /*PLAN/MANAGEMENT - ADVICE*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_PEPERT as pepert ON soap.TRANS_NO = pepert.TRANS_NO /*PHYSICAL EXAMINATION PERTINENT*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_PESPECIFIC as pespecific ON soap.TRANS_NO = pespecific.TRANS_NO /*PERTINENT PHYSICAL FINDINGS PER SYSTEM REMARKS*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_SUBJECTIVE as subjective ON soap.TRANS_NO = subjective.TRANS_NO /*CHIEF COMPLAINT*/
                                        WHERE soap.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                          AND soap.XPS_MODULE = 'SOAP'
                                          AND advice.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND soap.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_SOAP_ADVICE)
                                          AND pepert.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND soap.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_SOAP_PEPERT)
                                          AND pespecific.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND soap.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_SOAP_PESPECIFIC)
                                          AND subjective.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND soap.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_SOAP_SUBJECTIVE)
                                          ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Consultation - DIAGNOSTIC*/
function getReportResultConsultationDiagnostic($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT diagnostic.*, soap.TRANS_NO, soap.CASE_NO, soap.DATE_ADDED, soap.UPD_CNT, soap.EFF_YEAR
                                      FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_DIAGNOSTIC as diagnostic ON soap.TRANS_NO = diagnostic.TRANS_NO 
                                            WHERE soap.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND soap.XPS_MODULE = 'SOAP'
                                              AND diagnostic.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND soap.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_SOAP_DIAGNOSTIC)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Consultation - ICD*/
function getReportResultConsultationIcd($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT icd.*, soap.TRANS_NO, soap.CASE_NO, soap.DATE_ADDED, soap.UPD_CNT, soap.EFF_YEAR
                                      FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_ICD as icd ON soap.TRANS_NO = icd.TRANS_NO 
                                            WHERE soap.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND soap.XPS_MODULE = 'SOAP'
                                              AND icd.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND soap.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_SOAP_ICD)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Consultation - Management*/
function getReportResultConsultationManagement($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT management.*, soap.TRANS_NO, soap.CASE_NO, soap.DATE_ADDED, soap.UPD_CNT, soap.EFF_YEAR
                                      FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_MANAGEMENT as management ON soap.TRANS_NO = management.TRANS_NO 
                                            WHERE soap.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate
                                              AND soap.XPS_MODULE = 'SOAP'
                                              AND management.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND soap.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_SOAP_MANAGEMENT)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Consultation - PERTINENT FINDINGS PER SYSTEM*/
function getReportResultConsultationPemisc($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT pemisc.*, soap.TRANS_NO, soap.CASE_NO, soap.DATE_ADDED, soap.UPD_CNT, soap.EFF_YEAR
                                      FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_PEMISC as pemisc ON soap.TRANS_NO = pemisc.TRANS_NO 
                                            WHERE soap.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate                                            
                                              AND soap.XPS_MODULE = 'SOAP'
                                              AND pemisc.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate AND soap.UPD_CNT = (SELECT MAX(UPD_CNT) FROM EPCB.TSEKAP_TBL_SOAP_PEMISC)
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Generation of Report - Medicine*/
function getReportResultMedicine($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                     FROM ".$ini['EPCB'].".TSEKAP_TBL_MEDICINE as meds
                                        WHERE meds.DATE_ADDED BETWEEN :pxStartDate AND :pxEndDate                                        
                                          AND meds.XPS_MODULE IN ('HSA','SOAP')
                                             ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLab($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap ON enlist.CASE_NO = soap.CASE_NO
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROFILE as profile ON enlist.CASE_NO = profile.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate 
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}


function getReportResultLabCbc($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO, cbc.CASE_NO
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CBC as cbc ON enlist.CASE_NO = cbc.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabUrine($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_URINALYSIS as urinalysis ON enlist.CASE_NO = urinalysis.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate      
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabFecalysis($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FECALYSIS as fecalysis ON enlist.CASE_NO = fecalysis.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate 
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabChestXray($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_CHESTXRAY as chestxray ON enlist.CASE_NO = chestxray.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabSputum($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO 
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_SPUTUM as sputum ON enlist.CASE_NO = sputum.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate  
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabLipidProf($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO 
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_LIPIDPROF as lipidprof ON enlist.CASE_NO = lipidprof.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate   
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabFbs($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_FBS as fbs ON enlist.CASE_NO = fbs.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate       
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabEcg($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_ECG as ecg ON enlist.CASE_NO = ecg.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabOgtt($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_OGTT as ogtt ON enlist.CASE_NO = ogtt.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate      
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultLabPapsSmear($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO
                                              FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist                                              
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap ON enlist.CASE_NO = soap.CASE_NO
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROFILE as profile ON enlist.CASE_NO = profile.CASE_NO
                                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_DIAG_PAPSSMEAR as paps ON enlist.CASE_NO = paps.CASE_NO
                                                WHERE enlist.XPS_MODULE = 'EPCB' AND enlist.TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate     
                                                  ");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

//Get List of Member Assignment
function getReportMemberAssignment(){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *,
                                            CASE 
                                                WHEN PACKAGE_TYPE = 'E' THEN 'EPCB'
                                                WHEN PACKAGE_TYPE = 'P' THEN 'PCB1'
                                                ELSE 'UNDEFINED'
                                            END AS PACKAGE_TYPE
                                            FROM ".$ini['EPCB'].".TSEKAP_TBL_ASSIGN");

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

//Get List of Consultation
function getEnlistedConsultationList($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT soap.TRANS_NO, soap.SOAP_DATE, enlist.PX_LNAME, enlist.PX_FNAME, enlist.PX_MNAME, enlist.PX_EXTNAME, enlist.PX_PIN, enlist.PX_DOB, enlist.PX_TYPE 
                                            FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap
                                              INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist ON soap.PX_PIN = enlist.PX_PIN
                                                WHERE soap.SOAP_DATE BETWEEN :pxStartDate AND :pxEndDate");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Get Enlistment/Registration Record*/
function getEnlistmentList($pStartDate, $pEndDate){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST 
                                        WHERE TRANS_DATE BETWEEN :pxStartDate AND :pxEndDate");

        $stmt->bindParam(':pxStartDate', $pStartDate);
        $stmt->bindParam(':pxEndDate', $pEndDate);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

/*Insert data for Profiling/Health Screening & Assessment Module (HSA)*/
function saveProfilingInfo($profiling){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        session_start();
        $pUserId = $_SESSION['pUserID'];
        $pHciNo = $_SESSION['pHciNum'];
        $pXPSmodule = "HSA"; /*HSA - Health Screening & Assessment (Profiling in PCB)*/

        /*Start Patient Details Sub-module*/
        $pCaseNo=$profiling['txtPerHistCaseNo'];
        $pPatientPin=$profiling['txtPerHistPxPIN'];
        $pPatientType=$profiling['txtPerHistPatType'];
        $pMemPin=$profiling['txtPerHistMemPIN'];
        $pEffYear=$profiling['txtPerHistEffYear'];
        $pOTP=$profiling['txtPerHistOTP'];
        $pFinalizedData=$profiling['pFinalize'];
        $pProfDate = date('Y-m-d', strtotime($profiling['txtPerHistProfDate']));

        /*FIRST HSA OF PATIENT*/
        if (isset($_POST['submitHSA']) || isset($_POST['saveFinalizeHSA'])) {
            $pTransNo = generateTransNo('PROF_NO'); //automatically generated
            $getUpdCnt = $profiling['pUpdCntProfile'];
            /*Start Patient Details Sub-module*/
            insertProfilingInfo($pCaseNo, $pTransNo, $pProfDate, $pHciNo, $pPatientPin, $pPatientType, $pMemPin, $pUserId, $pEffYear, $pOTP, $pFinalizedData, $pXPSmodule);
            /*End Patient Details Sub-module*/

        }

        /*UPDATING EXISTING HSA RECORD*/
        if (isset($_POST['updateHSA']) || isset($_POST['updateFinalizeHSA'])) {
            $pTransNo = $profiling['pHsaTransNum'];
            $getUpdCnt = $profiling['pUpdCntProfile'];
            /*Start Patient Details Sub-module*/
            updateProfilingInfo($pTransNo, $pPatientPin, $pPatientType, $pMemPin, $pUserId, $pEffYear, $getUpdCnt, $pFinalizedData);
            /*End Patient Details Sub-module*/

        }

        /*Patient Details Sub-module: Other Information */
        $pPxAge = strtoupper($profiling['txtPerHistPatAge']);
        $pPxOccupation = strtoupper($profiling['txtPerHistPatOccupation']);
        $pPxEducation = $profiling['radPerHistEducation'];
        $pPxPoB = $profiling['optPerHistPobProv'] . $profiling['optPerHistPobMun'];
        $pPxReligion = strtoupper($profiling['txtPerHistPatReligion']);
        $pMomMLastName = strtoupper($profiling['txtPerHistMomLname']);
        $pMomMMiddleName = strtoupper($profiling['txtPerHistMomMname']);
        $pMomFirstname = strtoupper($profiling['txtPerHistMomFname']);
        $pMomExtName = strtoupper($profiling['txtPerHistMomExtName']);
        if ($profiling['txtPerHistMomBirthday'] != NULL) {
            $pMomDob = date('Y-m-d', strtotime($profiling['txtPerHistMomBirthday']));
        } else {
            $pMomDob = NULL;
        }
        $pDadLastName = strtoupper($profiling['txtPerHistDadLname']);
        $pDadMiddleName = strtoupper($profiling['txtPerHistDadMname']);
        $pDadFirstname = strtoupper($profiling['txtPerHistDadFname']);
        $pDadExtName = strtoupper($profiling['txtPerHistDadExtName']);
        if ($profiling['txtPerHistDadBirthday'] != NULL) {
            $pDadDob = date('Y-m-d', strtotime($profiling['txtPerHistDadBirthday']));
        } else {
            $pDadDob = NULL;
        }

        insertProfilingOtherInfo($pPxAge, $pPxOccupation, $pPxEducation, $pUserId, $pTransNo, $pPxPoB, $pPxReligion, $pMomMLastName, $pMomMMiddleName, $pMomFirstname, $pMomExtName, $pMomDob, $pDadLastName, $pDadMiddleName, $pDadFirstname, $pDadExtName, $pDadDob, $getUpdCnt);
        /*End Patient Details Sub-module*/

        /*Start Medical & Surgical History Sub-module*/
        /*Past Medical History*/
        $pPastMedHistory = $profiling['chkMedHistDiseases'];

        for ($i = 0; $i < count($pPastMedHistory); $i++) {
            if ($pPastMedHistory[$i] != '') {
                insertPastMedicalHistory($pPastMedHistory[$i], $pUserId, $pTransNo, $getUpdCnt);

                /*Past Medical History - Specific Diseases*/
                if ($pPastMedHistory[$i] == '001'):
                    $pSpecificDesc = $profiling['txtMedHistAllergy'];
                elseif ($pPastMedHistory[$i] == '003'):
                    $pSpecificDesc = $profiling['txtMedHistCancer'];
                elseif ($pPastMedHistory[$i] == '009'):
                    $pSpecificDesc = $profiling['txtMedHistHepatitis'];
                elseif ($pPastMedHistory[$i] == '011'):
                    $pSpecificDesc = $profiling['txtMedHistBPSystolic'] . " / " . $profiling['txtMedHistBPDiastolic'] . " mmHg";
                elseif ($pPastMedHistory[$i] == '015'):
                    $pSpecificDesc = $profiling['txtMedHistPTB'];
                elseif ($pPastMedHistory[$i] == '016'):
                    $pSpecificDesc = $profiling['txtMedHistExPTB'];
                elseif ($pPastMedHistory[$i] == '998'):
                    $pSpecificDesc = $profiling['txaMedHistOthers'];
                else:
                    $pSpecificDesc = "";
                endif;
                insertPastMedicalHistorySpecific($pPastMedHistory[$i], strtoupper($pSpecificDesc), $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*Past Surgical History*/
        $pOperation = $profiling['operation'];
        $pOperationDate = $profiling['operationDate'];

        for ($i = 0; $i < count($pOperation); $i++) {
            if ($pOperation[$i] != '') {
                insertPastSurgicalHistory($pOperation[$i], $pOperationDate[$i], $pUserId, $pTransNo, $getUpdCnt);
            }
        }
        /*End Medical & Surgical History Sub-module*/

        /*Start Family & Personal History Sub-module*/
        /*Family History*/
        $pFamMedHistory = $profiling['chkFamHistDiseases'];

        for ($i = 0; $i < count($pFamMedHistory); $i++) {
            if ($pFamMedHistory[$i] != '') {
                insertFamilyMedicalHistory($pFamMedHistory[$i], $pUserId, $pTransNo, $getUpdCnt);

                /*Past Medical History - Specific Diseases*/
                if ($pFamMedHistory[$i] == '001'):
                    $pSpecificDesc = $profiling['txtFamHistAllergy'];
                elseif ($pFamMedHistory[$i] == '003'):
                    $pSpecificDesc = $profiling['txtFamHistCancer'];
                elseif ($pFamMedHistory[$i] == '009'):
                    $pSpecificDesc = $profiling['txtFamHistHepatitis'];
                elseif ($pFamMedHistory[$i] == '011'):
                    $pSpecificDesc = $profiling['txtFamHistBPSystolic'] . "/" . $profiling['txtFamHistBPDiastolic'] . " mmHg";
                elseif ($pFamMedHistory[$i] == '015'):
                    $pSpecificDesc = $profiling['txtFamHistPTB'];
                elseif ($pFamMedHistory[$i] == '016'):
                    $pSpecificDesc = $profiling['txtFamHistExPTB'];
                elseif ($pFamMedHistory[$i] == '998'):
                    $pSpecificDesc = $profiling['txaFamHistOthers'];
                else:
                    $pSpecificDesc = "";
                endif;
                insertFamilyMedicalHistorySpecific($pFamMedHistory[$i], strtoupper($pSpecificDesc), $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*Personal/Social History*/
        $pIsSmoker = $profiling['radFamHistSmoke'];
        $pNoCigPack = $profiling['txtFamHistCigPk'];
        $pIsAlcoholDrinker = $profiling['radFamHistAlcohol'];
        $pNoBottles = $profiling['txtFamHistBottles'];
        $pIllDrugUser = $profiling['radFamHistDrugs'];

        insertPersonalSocialHistory($pIsSmoker, $pNoCigPack, $pIsAlcoholDrinker, $pNoBottles, $pIllDrugUser, $pUserId, $pTransNo, $getUpdCnt);
        /*End Family & Personal History Sub-module*/

        /*Start Immunizations Sub-module*/
        $pForChildren = $profiling['chkImmChild'];
        $pForAdult = $profiling['chkImmAdult'];
        $pForPregWoman = $profiling['chkImmPregnant'];
        $pForElderly = $profiling['chkImmElderly'];
        $pOthersImm = $profiling['txaImm'];

        /*For Children*/
        for ($i = 0; $i < count($pForChildren); $i++) {
            if ($pForChildren[$i] != '') {
                insertImmunizations($pForChildren[$i], null, null, null, $pUserId, $pTransNo, null, $getUpdCnt);
            }
        }

        /*For Adult*/
        for ($i = 0; $i < count($pForAdult); $i++) {
            if ($pForAdult[$i] != '') {
                insertImmunizations(null, $pForAdult[$i], null, null, $pUserId, $pTransNo, null, $getUpdCnt);
            }
        }

        /*For Pregnant Woman*/
        for ($i = 0; $i < count($pForPregWoman); $i++) {
            if ($pForPregWoman[$i] != '') {
                insertImmunizations(null, null, $pForPregWoman[$i], null, $pUserId, $pTransNo, null, $getUpdCnt);
            }
        }

        /*For Elderly and Immunocompromised*/
        for ($i = 0; $i < count($pForElderly); $i++) {
            if ($pForElderly[$i] != '') {
                insertImmunizations(null, null, null, $pForElderly[$i], $pUserId, $pTransNo, null, $getUpdCnt);
            }
        }

        if (!empty($pOthersImm)) {
            insertImmunizations(null, null, null, null, $pUserId, $pTransNo, $pOthersImm, $getUpdCnt);
        }
        /*End Immunizations Sub-module*/

        /*Start OB-Gyne History Sub-module*/
        /*Menstrual History*/
        $pMenarche = $profiling['txtOBHistMenarche'];

        if($profiling['txtOBHistLastMens'] != NULL){
            $pLastMensPeriod = date('Y-m-d',strtotime($profiling['txtOBHistLastMens']));
        } else{
            $pLastMensPeriod = NULL;
        }

        $pPeriodDuration = $profiling['txtOBHistPeriodDuration'];
        $pMensInterval = $profiling['txtOBHistInterval'];
        $pPadsPerDay = $profiling['txtOBHistPadsPerDay'];
        $pOnsetSexIC = $profiling['txtOBHistOnsetSexInt'];
        $pBirthControlMethod = $profiling['txtOBHistBirthControl'];
        $pIsMenopause = $profiling['radOBHistMenopause'];
        $pMenopauseAge = $profiling['txtOBHistMenopauseAge'];
        insertMenstrualHistory($pMenarche, $pLastMensPeriod, $pPeriodDuration, $pMensInterval, $pPadsPerDay, $pOnsetSexIC, $pBirthControlMethod, $pIsMenopause, $pMenopauseAge, $pUserId, $pTransNo, $getUpdCnt,"");

        /*Pregnany History*/
        $pPregCnt = $profiling['txtOBHistGravity'];
        $pDeliveryCnt = $profiling['txtOBHistParity'];
        $pDeliveryType = $profiling['optOBHistDelivery'];
        $pFullTermCnt = $profiling['txtOBHistFullTerm'];
        $pPrematureCnt = $profiling['txtOBHistPremature'];
        $pAbortionCnt = $profiling['txtOBHistAbortion'];
        $pLivChildrenCnt = $profiling['txtOBHistLivingChildren'];
        $pWithPregIndHyp = $profiling['chkOBHistPreEclampsiaValue'];
        /*Family Planning*/
        $pWithFamPlan = $profiling['radOBHistWFamPlan'];
        insertPrenancyHistory($pPregCnt, $pDeliveryCnt, $pDeliveryType, $pFullTermCnt, $pPrematureCnt, $pAbortionCnt, $pLivChildrenCnt, $pWithPregIndHyp, $pUserId, $pTransNo, $pWithFamPlan, $getUpdCnt);
        /*End OB-Gyne History Sub-module*/

        /*Start Pertinent Physical Examination Findings Sub-module*/
        /*Physical Exam Findings: Adult and Pediatric Patient*/
        $pSystolic = $profiling['txtPhExSystolic'];
        $pDiastolic = $profiling['txtPhExBPDiastolic'];
        $pHr = $profiling['txtPhExHeartRate'];
        $pRr = $profiling['txtPhExRespiratoryRate'];
        $pHeight = $profiling['txtPhExHeightCm'];
        $pWeight = $profiling['txtPhExWeightKg'];
        $pVisionAquity = $profiling['txtPhExVisualAcuityL'].'/'.$profiling['txtPhExVisualAcuityR'];
        $pLength = $profiling['txtPhExLengthCm'];
        $pHeadCirc = $profiling['txtPhExHeadCircCm'];
        $pTemp = $profiling['txtPhExTemp'];
        insertPertinentPhysicalExam($pSystolic, $pDiastolic, $pHr, $pRr, $pHeight, $pWeight, $pVisionAquity, $pLength, $pHeadCirc, $pUserId, $pTransNo, $getUpdCnt, $pTemp);


        /*Blood Type and Blood Rhesus*/
        $pBloodType = $profiling['radPhExBloodType'];
        $pBloodRh = $profiling['radPhExBloodRH'];
        insertBloodType($pBloodType, $pBloodRh, $pUserId, $pTransNo, $getUpdCnt);

        /*General Survey*/
        $pGenSurveyId = $profiling['pGenSurvey'];
        $pGenSurveyRem = $profiling['pGenSurveyRemarks'];
        insertPeGeneralSurvey($pGenSurveyId, strtoupper($pGenSurveyRem), $pUserId, $pTransNo);

        /*Physical Exam Misc*/
        $pSkin = $profiling['skinExtremities'];
        $pGenito = $profiling['genitourinary'];
        $pRectal = $profiling['rectal'];
        $pHeent = $profiling['heent'];
        $pChest = $profiling['chest'];
        $pHeart = $profiling['heart'];
        $pAbdomen = $profiling['abdomen'];
        $pNeuro = $profiling['neuro'];

        /*A. Heent*/
        for ($i = 0; $i < count($pHeent); $i++) {
            if ($pHeent[$i] != '') {
                insertProfilePhysicalExamMisc(null, $pHeent[$i], null, null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*B. Chest/Lungs*/
        for ($i = 0; $i < count($pChest); $i++) {
            if ($pChest[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, $pChest[$i], null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*C. Heart*/
        for ($i = 0; $i < count($pHeart); $i++) {
            if ($pHeart[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, $pHeart[$i], null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*D. Abdomen*/
        for ($i = 0; $i < count($pAbdomen); $i++) {
            if ($pAbdomen[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, null, $pAbdomen[$i], null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*E. Genitourinary*/
        for ($i = 0; $i < count($pGenito); $i++) {
            if ($pGenito[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, null, null, null, $pGenito[$i], null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*F. Digital Rectal Examination*/
        for ($i = 0; $i < count($pRectal); $i++) {
            if ($pRectal[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, null, null, null, null, $pRectal[$i], $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*G. Skin/Extremities*/
        for ($i = 0; $i < count($pSkin); $i++) {
            if ($pSkin[$i] != '') {
                insertProfilePhysicalExamMisc($pSkin[$i], null, null, null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*H. Neurological*/
        for ($i = 0; $i < count($pNeuro); $i++) {
            if ($pNeuro[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, null, null, $pNeuro[$i], null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*Remarks*/
        $pHeentRemarks = strtoupper($profiling['heent_remarks']);
        $pChestRemarks = strtoupper($profiling['chest_lungs_remarks']);
        $pHeartRemarks = strtoupper($profiling['heart_remarks']);
        $pAbdomenRemarks = strtoupper($profiling['abdomen_remarks']);
        $pGenitoRemarks = strtoupper($profiling['gu_remarks']);
        $pRectalRemarks = strtoupper($profiling['rectal_remarks']);
        $pSkinExtremitiesRemarks = strtoupper($profiling['skinExtremities_remarks']);
        $pNeuroRemarks = strtoupper($profiling['neuro_remarks']);
        insertProfilePhysicalExamMiscRemarks($pHeentRemarks, $pChestRemarks, $pHeartRemarks, $pAbdomenRemarks, $pGenitoRemarks, $pRectalRemarks, $pSkinExtremitiesRemarks, $pNeuroRemarks, $pTransNo, $pUserId, $getUpdCnt);
        /*End Pertinent Physical Examination Findings Sub-module*/

        /*06-26-2018*/
        /*Start Laboratory Results*/
        /*1. Complete Blood Count (CBC)*/
        if($profiling['diagnostic_1_lab_exam_date'] != NULL){
            $pLabDateCBC = date('Y-m-d', strtotime($profiling['diagnostic_1_lab_exam_date']));
            $pIsApplicableCbc = "Y";
        } else{
            $pLabDateCBC = NULL;
            $pIsApplicableCbc = "N";
        }
        $pLabFeeCBC = $profiling['diagnostic_1_lab_fee'];
        $pCoPayCBC = $profiling['diagnostic_1_copay'];
        $pHematocrit = $profiling['diagnostic_1_hematocrit'];
        $pHemoglobinG = $profiling['diagnostic_1_hemoglobin_gdL'];
        $pHemoglobinMmol = $profiling['diagnostic_1_hemoglobin_mmolL'];
        $pMhcPg = $profiling['diagnostic_1_mhc_pgcell'];
        $pMhcFmol = $profiling['diagnostic_1_mhc_fmolcell'];
        $pMchcGhb = $profiling['diagnostic_1_mchc_gHbdL'];
        $pMchcMmol = $profiling['diagnostic_1_mchc_mmolHbL'];
        $pMcvUm = $profiling['diagnostic_1_mcv_um'];
        $pMcvFl = $profiling['diagnostic_1_mcv_fL'];
        $pWbc1000 = $profiling['diagnostic_1_wbc_cellsmmuL'];
        $pWbc10 = $profiling['diagnostic_1_wbc_cellsL'];
        $pMyelocyte = $profiling['diagnostic_1_myelocyte'];
        $pNeutrophilsBnd = $profiling['diagnostic_1_neutrophils_bands'];
        $pNeurophilsSeg = $profiling['diagnostic_1_neutrophils_segmenters'];
        $pLymphocytes = $profiling['diagnostic_1_lymphocytes'];
        $pMonocytes = $profiling['diagnostic_1_monocytes'];
        $pEosinophils = $profiling['diagnostic_1_eosinophils'];
        $pBasophils = $profiling['diagnostic_1_basophils'];
        $pPlatelet = $profiling['diagnostic_1_platelet'];
        insertResultsCBC($pCaseNo, $pLabDateCBC, $pLabFeeCBC,$pCoPayCBC,"", $pHematocrit, $pHemoglobinG, $pHemoglobinMmol, $pMhcPg, $pMhcFmol, $pMchcGhb, $pMchcMmol, $pMcvUm, $pMcvFl, $pWbc1000, $pWbc10, $pMyelocyte,
            $pNeutrophilsBnd, $pNeurophilsSeg, $pLymphocytes, $pMonocytes, $pEosinophils, $pBasophils, $pPlatelet, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pIsApplicableCbc);

        /*2. Urinalysis*/
        if($profiling['diagnostic_2_lab_exam_date'] != NULL){
            $pLabDateUrinalysis = date('Y-m-d', strtotime($profiling['diagnostic_2_lab_exam_date']));
            $pIsApplicableUrine = "Y";
        } else{
            $pLabDateUrinalysis = NULL;
            $pIsApplicableUrine = "N";
        }
        $pLabFeeUrinalysis = $profiling['diagnostic_2_lab_fee'];
        $pCoPayUrinalysis = $profiling['diagnostic_2_copay'];
        $pGravity = $profiling['diagnostic_2_sg'];
        $pAppearance = $profiling['diagnostic_2_appearance'];
        $pColor = $profiling['diagnostic_2_color'];
        $pGlucose = $profiling['diagnostic_2_glucose'];
        $pProteins = $profiling['diagnostic_2_proteins'];
        $pKetones = $profiling['diagnostic_2_ketones'];
        $pPh = $profiling['diagnostic_2_pH'];
        $pRbCells = $profiling['diagnostic_2_rbc'];
        $pWbCells = $profiling['diagnostic_2_wbc'];
        $pBacteria = $profiling['diagnostic_2_bacteria'];
        $pCrystals = $profiling['diagnostic_2_crystals'];
        $pBladderCell = $profiling['diagnostic_2_bladder_cells'];
        $pSquamousCell = $profiling['diagnostic_2_squamous_cells'];
        $pTubularCell = $profiling['diagnostic_2_tubular_cells'];
        $pBroadCasts = $profiling['diagnostic_2_broad_casts'];
        $pEpithelialCast = $profiling['diagnostic_2_epithelial_cell_casts'];
        $pGranularCast = $profiling['diagnostic_2_granular_casts'];
        $pHyalineCast = $profiling['diagnostic_2_hyaline_casts'];
        $pRbcCast = $profiling['diagnostic_2_rbc_casts'];
        $pWaxyCast = $profiling['diagnostic_2_waxy_casts'];
        $pWcCast = $profiling['diagnostic_2_wc_casts'];
        $pAlbumin = $profiling['diagnostic_2_alb'];
        $pPusCells = $profiling['diagnostic_2_pus'];
        insertResultsUrinalysis($pCaseNo, $pLabDateUrinalysis, $pLabFeeUrinalysis, $pCoPayUrinalysis,"", $pGravity, $pAppearance, $pColor, $pGlucose, $pProteins, $pKetones, $pPh, $pRbCells, $pWbCells, $pBacteria, $pCrystals,
            $pBladderCell, $pSquamousCell, $pTubularCell, $pBroadCasts, $pEpithelialCast, $pGranularCast, $pHyalineCast, $pRbcCast, $pWaxyCast, $pWcCast, $pAlbumin, $pPusCells, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableUrine);

        /*3. Fecalysis*/
        if($profiling['diagnostic_3_lab_exam_date'] != NULL){
            $pLabDateFecalysis = date('Y-m-d', strtotime($profiling['diagnostic_3_lab_exam_date']));
            $pIsApplicableFeca = "Y";
        } else{
            $pLabDateFecalysis = NULL;
            $pIsApplicableFeca = "N";
        }        
        $pLabFeeFecalysis = $profiling['diagnostic_3_lab_fee'];
        $pCoPayFecalysis = $profiling['diagnostic_3_copay'];
        $pColorFecalysis = $profiling['diagnostic_3_color'];
        $pConsistency = $profiling['diagnostic_3_consistency'];
        $pRBC = $profiling['diagnostic_3_rbc'];
        $pWBC = $profiling['diagnostic_3_wbc'];
        $pOva = $profiling['diagnostic_3_ova'];
        $pParasite = $profiling['diagnostic_3_parasite'];
        $pBlood = $profiling['diagnostic_3_blood'];
        $pOccultBlood = $profiling['diagnostic_3_occult_blood'];
        $pPusCell = $profiling['diagnostic_3_pus'];
        insertResultsFecalysis($pCaseNo, $pLabDateFecalysis, $pLabFeeFecalysis, $pCoPayFecalysis, "", $pColorFecalysis, $pConsistency, $pRBC, $pWBC, $pOva, $pParasite, $pBlood, $pOccultBlood, $pPusCell, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pIsApplicableFeca);

        /*4. Chest X-ray*/
        if($profiling['diagnostic_4_lab_exam_date'] != NULL){
            $pLabDateXray = date('Y-m-d', strtotime($profiling['diagnostic_4_lab_exam_date']));
            $pIsApplicableXray = "Y";
        } else{
            $pLabDateXray = NULL;
            $pIsApplicableXray = "N";
        }
        $pLabFeeXray = $profiling['diagnostic_4_lab_fee'];
        $pCoPayXray = $profiling['diagnostic_4_copay'];
        $pFindingsXray = $profiling['diagnostic_4_chest_findings'];
        $pRemarkFindings = strtoupper($profiling['diagnostic_4__chest_findings_remarks']);
        $pObservation = $profiling['pObservation'];
        $pRemarkObservation = $profiling['pObservationRemarks'];
        insertResultsChestXray($pCaseNo, $pLabDateXray, $pLabFeeXray, $pCoPayXray, "", $pFindingsXray, $pRemarkFindings, $pObservation, $pRemarkObservation, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableXray);

        /*5. Sputum Microscopy*/
        if($profiling['diagnostic_5_lab_exam_date'] != NULL){
            $pLabDateSputum = date('Y-m-d', strtotime($profiling['diagnostic_5_lab_exam_date']));
            $pIsApplicableSputum = "Y";
            $pDataCollect = "1";
        } else{
            $pLabDateSputum = NULL;
            $pIsApplicableSputum = "N";
            $pDataCollect = "X";
        }
        $pLabFeeSputum = $profiling['diagnostic_5_lab_fee'];
        $pCoPaySputum = $profiling['diagnostic_5_copay'];
        $pFindingsSputum = $profiling['diagnostic_5_sputum'];
        $pRemarksSputum = $profiling['diagnostic_5_sputum_remarks'];
        $pNoPlusses = $profiling['diagnostic_5__plusses'];

        insertResultsSputum($pCaseNo, $pLabDateSputum, $pLabFeeSputum, $pCoPaySputum, "", $pFindingsSputum, $pRemarksSputum, $pNoPlusses, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableSputum,$pDataCollect);

        /*6. Lipid Profile*/
        if($profiling['diagnostic_6_lab_exam_date'] != NULL){
            $pLabDateLipid = date('Y-m-d', strtotime($profiling['diagnostic_6_lab_exam_date']));
            $pIsApplicableLipid = "Y";
        } else{
            $pLabDateLipid = NULL;
            $pIsApplicableLipid = "N";
        }
        $pLabFeeLipid = $profiling['diagnostic_6_lab_fee'];
        $pCoPayLipid = $profiling['diagnostic_6_copay'];
        $pLdl = $profiling['diagnostic_6_ldl'];
        $pHdl = $profiling['diagnostic_6_hdl'];
        $pTotal = $profiling['diagnostic_6_total'];
        $pCholesterol = $profiling['diagnostic_6_cholesterol'];
        $pTriglycerides = $profiling['diagnostic_6_triglycerides'];
        insertResultsLipidProfile($pCaseNo, $pLabDateLipid, $pLabFeeLipid, $pCoPayLipid,"", $pLdl, $pHdl, $pTotal, $pCholesterol, $pTriglycerides, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableLipid);

        /*7. Eletrocardiogram (ECG)*/
        if($profiling['diagnostic_9_lab_exam_date'] != NULL){
            $pLabDateECG = date('Y-m-d', strtotime($profiling['diagnostic_9_lab_exam_date']));
            $pIsApplicableEcg = "Y";
        } else{
            $pLabDateECG = NULL;
            $pIsApplicableEcg = "N";
        }
        $pLabFeeECG = $profiling['diagnostic_9_lab_fee'];
        $pCoPayECG = $profiling['diagnostic_9_copay'];
        $pFindingsECG = $profiling['diagnostic_9_ecg'];
        $pRemarksECG = $profiling['diagnostic_9_ecg_remarks'];
        insertResultsECG($pCaseNo, $pLabDateECG, $pLabFeeECG, $pCoPayECG, "", $pFindingsECG, $pRemarksECG, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule,$pIsApplicableEcg);

        /*8. Fasting Blood Sugar (FBS)*/
        if($profiling['diagnostic_7_lab_exam_date'] != NULL){
            $pLabDateFBS = date('Y-m-d', strtotime($profiling['diagnostic_7_lab_exam_date']));
            $pIsApplicableFbs = "Y";
        } else{
            $pLabDateFBS = NULL;
            $pIsApplicableFbs = "N";
        }
        $pLabFeeFBS = $profiling['diagnostic_7_lab_fee'];
        $pCoPayFBS = $profiling['diagnostic_7_copay'];
        $pGlucoseMg = $profiling['diagnostic_7_glucose_mgdL'];
        $pGlucosemmol = $profiling['diagnostic_7_glucose_mmolL'];
        insertResultsFBS($pCaseNo, $pLabDateFBS, $pLabFeeFBS, $pCoPayFBS, "", $pGlucoseMg, $pGlucosemmol, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pIsApplicableFbs);

        /*9. Paps Smear*/
        if($profiling['diagnostic_13_lab_exam_date'] != NULL){
            $pLabDatePapsSmear = date('Y-m-d', strtotime($profiling['diagnostic_13_lab_exam_date']));
            $pIsApplicablePaps = "Y";
        } else{
            $pLabDatePapsSmear = NULL;
            if($profiling['papsDone'] == "X"){
                $pIsApplicablePaps = "W";
            } else{
                $pIsApplicablePaps = "N";
            }
        }
        $pLabFeePapsSmear = $profiling['diagnostic_13_lab_fee'];
        $pCoPayPapsSmear = $profiling['diagnostic_13_copay'];
        $pFindingsPapsSmear = strtoupper($profiling['diagnostic_13_papsSmearFindings']);
        $pImpressionPapsSmear =strtoupper($profiling['diagnostic_13_papsSmearImpression']);
        insertResultsPapsSmear($pCaseNo, $pLabDatePapsSmear,$pLabFeePapsSmear,$pCoPayPapsSmear,"", $pFindingsPapsSmear,$pImpressionPapsSmear,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule,$pIsApplicablePaps);

        /*10. Oral Glucose Tolerance Test (OGTT)*/
        if($profiling['diagnostic_14_lab_exam_date'] != NULL){
            $pLabDateOGTT = date('Y-m-d', strtotime($profiling['diagnostic_14_lab_exam_date']));
            $pIsApplicableOgtt = "Y";
        } else{
            $pLabDateOGTT = NULL;
            if($profiling['ogttDone'] == "X"){
                $pIsApplicableOgtt = "W";
            } else{
                $pIsApplicableOgtt = "N";
            }
        }
        $pLabFeeOGTT = $profiling['diagnostic_14_lab_fee'];
        $pCoPayOGTT = $profiling['diagnostic_14_copay'];
        $pFastingMg = $profiling['diagnostic_14_fasting_mg'];
        $pFastingMmol = $profiling['diagnostic_14_fasting_mmol'];
        $pOgttOneHrMg= $profiling['diagnostic_14_oneHr_mg'];
        $pOgttOneHrMmol = $profiling['diagnostic_14_oneHr_mmol'];
        $pOgttTwoHrsMg = $profiling['diagnostic_14_twoHr_mg'];
        $pOgttTwoHrsMmol = $profiling['diagnostic_14_twoHr_mmol'];
        insertResultsOGTT($pCaseNo, $pLabDateOGTT,$pLabFeeOGTT,$pCoPayOGTT,"",$pFastingMg,$pFastingMmol,$pOgttOneHrMg,$pOgttOneHrMmol,$pOgttTwoHrsMg,$pOgttTwoHrsMmol,$pTransNo, $pUserId, $getUpdCnt,$pXPSmodule, $pIsApplicableOgtt);
        /*End Laboratory Results*/

        /*Start Plan/Management*/
        /*Diagnosis Examination*/
        $pDiagnostic = $profiling['diagnostic'];
        $pOthRemarks = $profiling['diagnostic_oth_remarks'];
        if($pDiagnostic != NULL) {
            for ($i = 0; $i < count($pDiagnostic); $i++) {
                if ($pDiagnostic[$i] == "1") {
                    /*Results - Complete Blood Count */
                    $pFacility = $profiling['diagnostic_1_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_1_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "2") {
                    /* Results - Urinalysis */
                    $pFacility = $profiling['diagnostic_2_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_2_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "3") {
                    /* Results - Fecalysis */
                    $pFacility = $profiling['diagnostic_3_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_3_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "4") {
                    /* Results - Chest X-Ray */
                    $pFacility = $profiling['diagnostic_4_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_4_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "5") {
                    /* Results - Sputum */
                    $pFacility = $profiling['diagnostic_5_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_5_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "6") {
                    /* Results - Lipid Profile */
                    $pFacility = $profiling['diagnostic_6_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_6_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "7") {
                    /* Results - Fasting Blood Sugar */
                    $pFacility = $profiling['diagnostic_7_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_7_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "9") {
                    /* Results - Electrocardiogram */
                    $pFacility = $profiling['diagnostic_9_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_9_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "13") {
                    /* Results - Paps Smear */
                    $pFacility = $profiling['diagnostic_13_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_13_accre_diag_fac'];
                } else if ($pDiagnostic[$i] == "14") {
                    /* Results - Oral Glucose Tolerance (OGTT) */
                    $pFacility = $profiling['diagnostic_14_lab_exam'];
                    $pReferralFacility = $profiling['diagnostic_14_accre_diag_fac'];
                } else {
                    $pFacility = NULL;
                    $pReferralFacility = NULL;
                }
                insertProfilingDiagnosticExamination($pDiagnostic[$i], $pOthRemarks, $pFacility, $pReferralFacility, $pUserId, $pTransNo, $getUpdCnt);
            }
        }
        else{
            insertProfilingDiagnosticExamination("0", $pOthRemarks, NULL, NULL, $pUserId, $pTransNo, $getUpdCnt);
        }

        /*Management */
        $pManagement = $profiling['management'];
        $pOthMgmtRemarks = strtoupper($profiling['management_oth_remarks']);
        if($pManagement != NULL) {
            for ($i = 0; $i < count($pManagement); $i++) {
                insertProfilingManagement($pManagement[$i], $pUserId, $pTransNo, $pOthMgmtRemarks, $getUpdCnt);
            }
        }
        else{
            insertProfilingManagement("0", $pUserId, $pTransNo, $pOthMgmtRemarks, $getUpdCnt);
        }

        /*Advice */
        $pAdviceRemarks = $profiling['advice_remarks'];
        insertProfilingAdvice($pAdviceRemarks, $pUserId, $pTransNo, $getUpdCnt);
        /*End Plan/Management*/


        /*Start Medicine*/
        /*Medicine*/
        $pDoctorName = $profiling['pPrescDoctor'];
        $pDrugCodeMeds = $profiling['pDrugCodeMeds'];
        $pGenCodeMeds = $profiling['pGenCodeMeds'];
        $pSaltCodeMeds = $profiling['pSaltCodeMeds'];
        $pStrengthMeds = $profiling['pStrengthCodeMeds'];
        $pFormMeds = $profiling['pFormCodeMeds'];
        $pUnitMeds = $profiling['pUnitCodeMeds'];
        $pPackageMeds = $profiling['pPackageCodeMeds'];
        $pQuantityMeds = $profiling['pQtyMeds'];
        $pUnitPriceMeds = $profiling['pUnitPriceMeds'];
        $pCopayMeds = $profiling['pCoPaymentMeds'];
        $pTotalAmtPriceMeds = $profiling['pTotalPriceMeds'];
        $pInsQtyMeds = $profiling['pQtyInsMeds'];
        $pInsStrengthMeds = $profiling['pStrengthInsMeds'];
        $pInsFreqMeds = $profiling['pFrequencyInsMeds'];
        $pGenericName = $profiling['pGenericNameMeds'];

        if($pDrugCodeMeds != NULL){
            $pApplicable = "Y";
            for ($i = 0; $i < count($pGenCodeMeds); $i++) {
                insertMedicine($pDrugCodeMeds[$i], $pGenCodeMeds[$i], $pStrengthMeds[$i], $pFormMeds[$i], $pPackageMeds[$i],
                    $pQuantityMeds[$i], $pUnitPriceMeds[$i], $pCopayMeds[$i], $pTotalAmtPriceMeds[$i], $pInsQtyMeds[$i], $pInsStrengthMeds[$i], $pInsFreqMeds[$i],
                    $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pDoctorName, $pApplicable, $pGenericName, $pSaltCodeMeds[$i], "","");
            }
        } else{
            $pApplicable = "N";
            insertMedicine(NULL, NULL, NULL, NULL, NULL,
                NULL, NULL, NULL,NULL, NULL, NULL, NULL,
                $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pDoctorName, $pApplicable, NULL, NULL, NULL, NULL);
        }
        /*End Medicine*/

        /*Start NCD High-Risk Assessment Sub-module*/
        $pQ1 = $profiling['Q1'];
        $pQ2 = $profiling['Q2'];
        $pQ3 = $profiling['Q3'];
        $pQ4 = $profiling['Q4'];
        $pQ5 = $profiling['Q5'];
        $pQ511 = $profiling['Q5_1_1'];
        $pQ6 = $profiling['Q6'];
        $pQ7 = $profiling['Q7'];
        $pQ8 = $profiling['Q8'];
        $pQ67811 = $profiling['Q678_1_1'];
        $pQ67812 = $profiling['Q678_1_2'];
        $pQ67813 = $profiling['Q678_1_3'];
        if ($profiling['ncdRbgDate'] != null) {
            $pNcdRbgDate = date('Y-m-d', strtotime($profiling['ncdRbgDate']));
        } else {
            $pNcdRbgDate = null;
        }
        $pQ67821 = $profiling['Q678_2_1'];
        $pQ67822 = $profiling['Q678_2_2'];
        if ($profiling['ncdRblDate'] != null) {
            $pNcdRblDate = date('Y-m-d', strtotime($profiling['ncdRblDate']));
        } else {
            $pNcdRblDate = null;
        }
        $pQ67831 = $profiling['Q678_3_1'];
        $pQ67832 = $profiling['Q678_3_2'];
        if ($profiling['ncdUkDate'] != null) {
            $pNcdUkDate = date('Y-m-d', strtotime($profiling['ncdUkDate']));
        } else {
            $pNcdUkDate = null;
        }
        $pQ67841 = $profiling['Q678_4_1'];
        $pQ67842 = $profiling['Q678_4_2'];
        if ($profiling['ncdUpDate'] != null) {
            $pNcdUpDate = date('Y-m-d', strtotime($profiling['ncdUpDate']));
        } else {
            $pNcdUpDate = null;
        }
        $pQ23 = $profiling['Q23'];
        $pQ9 = $profiling['Q9'];
        $pQ10 = $profiling['Q10'];
        $pQ11 = $profiling['Q11'];
        $pQ12 = $profiling['Q12'];
        $pQ13 = $profiling['Q13'];
        $pQ14 = $profiling['Q14'];
        $pQ15 = $profiling['Q15'];
        $pQ24 = $profiling['Q24'];
        $pQ16 = $profiling['Q16'];
        $pQ17 = $profiling['Q17'];

        insertNcdHighRiskAssessment($pQ1, $pQ2, $pQ3, $pQ4, $pQ5, $pQ511, $pQ6, $pQ7, $pQ8, $pQ67811, $pQ67812, $pQ67813, $pNcdRbgDate, $pQ67821, $pQ67822, $pNcdRblDate,
            $pQ67831, $pQ67832, $pNcdUkDate, $pQ67841, $pQ67842, $pNcdUpDate, $pQ23, $pQ9, $pQ10, $pQ11, $pQ12, $pQ13, $pQ14, $pQ15, $pQ24, $pQ16, $pQ17, $pTransNo, $pUserId, $getUpdCnt);
        /*End NCD High-Risk Assessment Sub-module*/

        $conn->commit();

        echo '<script>alert("Successfully saved!");window.location="hsa_search.php";</script>';

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: Main Profiling " . $e->getMessage();
        echo '<script>alert("Error: Main Profiling '.$e->getMessage().'");</script>';
    }

    $conn = null;
}
/*Update Patient Information*/
function updateProfilingInfo($pTransNo,$pPatientPin,$pPatientType,$pMemPin,$pUserId,$pEffYear,$getUpdCnt,$pFinalizedData){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("UPDATE ".$ini['EPCB'].".TSEKAP_TBL_PROFILE
                                    SET PX_PIN = :pxPin, 
                                        PX_TYPE = :pxType,
                                        MEM_PIN = :memPin,
                                        PROF_DATE = NOW(),
                                        PROF_BY = :profBy,
                                        EFF_YEAR = :effYear,
                                        UPD_CNT = :updCnt,
                                        IS_FINALIZE = :finalize
                                    WHERE TRANS_NO = :transNo");

        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':pxPin', $pPatientPin);
        $stmt->bindParam(':pxType', $pPatientType);
        $stmt->bindParam(':memPin', $pMemPin);
        $stmt->bindParam(':profBy', $pUserId);
        $stmt->bindParam(':effYear', $pEffYear);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':finalize', $pFinalizedData);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertUpdateHSA01-01 - " . $e->getMessage();
        echo '<script>alert("Error: InsertUpdateHSA01-01 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Plan/Management Sub-module in HSA*/
/*Plan/Management - Diagnosis Examination*/
function insertProfilingDiagnosticExamination($pDiagnostic, $pOthRemarks, $pFacility, $pReferralFacility, $pUserId, $pTransNo, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_DIAGNOSTIC(
                                DIAGNOSTIC_ID, DATE_ADDED, ADDED_BY, TRANS_NO, OTH_REMARKS, FACILITY, REFERRAl_FACILITY, UPD_CNT) 
                                  VALUES(:diagnosticId, 
                                         NOW(), 
                                         :addedBy,
                                         :transNo,
                                         :othRemarks,
                                         :facility,
                                         :referralfacility,
                                         :updCnt)");

        $stmt->bindParam(':diagnosticId', $pDiagnostic);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':othRemarks', strtoupper($pOthRemarks));
        $stmt->bindParam(':facility', $pFacility);
        $stmt->bindParam(':referralfacility', strtoupper($pReferralFacility));
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C08" . $e->getMessage();
        echo '<script>alert("Error: C08'.$e->getMessage().'");</script>';
    }

    $conn = null;
}


/* Plan/Management - Management */
function insertProfilingManagement($pManagement, $pUserId, $pTransNo, $pOthMgmtRemarks,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_MANAGEMENT(
                   MANAGEMENT_ID, DATE_ADDED, ADDED_BY, TRANS_NO, OTH_REMARKS,UPD_CNT) 
                      VALUES(:managementId, 
                             NOW(), 
                             :addedBy, 
                             :transNo, 
                             :othRemarks,
                             :updCnt)");

        $stmt->bindParam(':managementId', $pManagement);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':othRemarks', $pOthMgmtRemarks);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C09" . $e->getMessage();
        echo '<script>alert("Error: C09'.$e->getMessage().'");</script>';
    }

    $conn = null;
}
/* Plan/Management - Management */
function insertProfilingAdvice($pAdviceRemarks, $pUserId, $pTransNo, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_ADVICE(
                           REMARKS, DATE_ADDED, ADDED_BY, TRANS_NO, UPD_CNT) 
                              VALUES(:remarks, 
                                     NOW(), 
                                     :addedBy, 
                                     :transNo,
                                     :updCnt)");

        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':remarks', strtoupper($pAdviceRemarks));
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: C10" . $e->getMessage();
        echo '<script>alert("Error: C10'.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Patient Information*/
function insertProfilingInfo($pCaseNo,$pTransNo,$pProfDate, $pHciNo,$pPatientPin,$pPatientType,$pMemPin,$pUserId,$pEffYear,$pOTP,$pFinalizedData, $pXPSmodule){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROFILE(
                        CASE_NO, TRANS_NO, HCI_NO, PX_PIN, PX_TYPE, MEM_PIN, PROF_DATE, PROF_BY, EFF_YEAR, DATE_ADDED, PROFILE_OTP, IS_FINALIZE, XPS_MODULE) 
                          VALUES(:caseNo, 
                                 :transNo, 
                                 :hciNo,
                                 :pxPin, 
                                 :pxType, 
                                 :memPin, 
                                 :profDate, 
                                 :profBy,
                                 :effYear,
                                 NOW(),
                                 :otp,
                                 :finalize,
                                 :xpsMod)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':profDate', $pProfDate);
        $stmt->bindParam(':hciNo', $pHciNo);
        $stmt->bindParam(':pxPin', $pPatientPin);
        $stmt->bindParam(':pxType', $pPatientType);
        $stmt->bindParam(':memPin', $pMemPin);
        $stmt->bindParam(':profBy', $pUserId);
        $stmt->bindParam(':effYear', $pEffYear);
        $stmt->bindParam(':otp', $pOTP);
        $stmt->bindParam(':finalize', $pFinalizedData);
        $stmt->bindParam(':xpsMod', $pXPSmodule);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA01-01 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA01-01 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Other Info in Patient Tab */
function insertProfilingOtherInfo($pPxAge,$pPxOccupation,$pPxEducation,$pUserId,$pTransNo,$pPxPoB,$pPxReligion,$pMomMLastName,$pMomMMiddleName,$pMomFirstname,$pMomExtName,$pMomDob,$pDadLastName,$pDadMiddleName,$pDadFirstname,$pDadExtName,$pDadDob,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_OINFO(
                        PX_AGE,PX_OCCUPATION,PX_EDUCATION,DATE_ADDED,ADDED_BY,TRANS_NO,PX_POB,PX_RELIGION,PX_MOTHER_MNLN,PX_MOTHER_MNMI,PX_MOTHER_FN,PX_MOTHER_EXTN,
                        PX_FATHER_LN,PX_FATHER_MI,PX_FATHER_FN,PX_FATHER_EXTN,PX_MOTHER_BDAY,PX_FATHER_BDAY, UPD_CNT) 
                          VALUES(:pxAge,
                                 :pxOccupation,
                                 :pxEducation,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :pxPob,
                                 :pxReligion,
                                 :pxMomLname,
                                 :pxMomMname,
                                 :pxMomFname,
                                 :pxMomExtName,
                                 :pxDadLname,
                                 :pxDadMname,
                                 :pxDadFname,
                                 :pxDadExtName,
                                 :pxMomBday,
                                 :pxDadBday,
                                 :updCnt)");

        $stmt->bindParam(':pxAge', $pPxAge);
        $stmt->bindParam(':pxOccupation', $pPxOccupation);
        $stmt->bindParam(':pxEducation', $pPxEducation);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':pxPob', $pPxPoB);
        $stmt->bindParam(':pxReligion', $pPxReligion);
        $stmt->bindParam(':pxMomLname', $pMomMLastName);
        $stmt->bindParam(':pxMomMname', $pMomMMiddleName);
        $stmt->bindParam(':pxMomFname', $pMomFirstname);
        $stmt->bindParam(':pxMomExtName', $pMomExtName);
        $stmt->bindParam(':pxDadLname', $pDadLastName);
        $stmt->bindParam(':pxDadMname', $pDadMiddleName);
        $stmt->bindParam(':pxDadFname', $pDadFirstname);
        $stmt->bindParam(':pxDadExtName', $pDadExtName);
        $stmt->bindParam(':pxMomBday', $pMomDob);
        $stmt->bindParam(':pxDadBday', $pDadDob);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA01-02 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA01-02 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Past Medical History*/
function insertPastMedicalHistory($pPastMedHistory,$pUserId,$pTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_MEDHIST(
                        MDISEASE_CODE,DATE_ADDED,ADDED_BY,TRANS_NO,UPD_CNT) 
                          VALUES(:mDiseaseCode,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :updCnt)");

        $stmt->bindParam(':mDiseaseCode', $pPastMedHistory);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA02-01 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA02-01 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Specific Past Medical History*/
function insertPastMedicalHistorySpecific($pPastMedHistory,$pSpecificDesc,$pTransNo,$pUserId,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_MHSPECIFIC(
                        MDISEASE_CODE,SPECIFIC_DESC,DATE_ADDED,ADDED_BY,TRANS_NO,UPD_CNT) 
                          VALUES(:mDiseaseCode,
                                 :specificDesc,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :updCnt)");

        $stmt->bindParam(':mDiseaseCode', $pPastMedHistory);
        $stmt->bindParam(':specificDesc', strtoupper($pSpecificDesc));
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA02-02 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA02-02 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Past Surgical History*/
function insertPastSurgicalHistory($pOperation,$pOperationDate,$pUserId,$pTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_SURGHIST(
                        SURG_DESC,SURG_DATE,DATE_ADDED,ADDED_BY,TRANS_NO,UPD_CNT) 
                          VALUES(:surgHist,
                                 :surgDate,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :updCnt)");

        $stmt->bindParam(':surgHist', strtoupper($pOperation));
        $stmt->bindParam(':surgDate', date('Y-m-d', strtotime($pOperationDate)));
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA02-03 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA02-03 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Family Medical History*/
function insertFamilyMedicalHistory($pFamMedHistory,$pUserId,$pTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_FAMHIST(
                        MDISEASE_CODE,DATE_ADDED,ADDED_BY,TRANS_NO,UPD_CNT) 
                          VALUES(:mDiseaseCode,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :updCnt)");

        $stmt->bindParam(':mDiseaseCode', $pFamMedHistory);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA03-01 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA03-01 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Specific Family Medical History*/
function insertFamilyMedicalHistorySpecific($pFamMedHistory,$pSpecificDesc,$pTransNo,$pUserId,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_FHSPECIFIC(
                        MDISEASE_CODE,SPECIFIC_DESC,DATE_ADDED,ADDED_BY,TRANS_NO,UPD_CNT) 
                          VALUES(:mDiseaseCode,
                                 :specificDesc,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :updCnt)");

        $stmt->bindParam(':mDiseaseCode', $pFamMedHistory);
        $stmt->bindParam(':specificDesc', $pSpecificDesc);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA03-02 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA03-02 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}
/*Insert Personal/ Social History*/
function insertPersonalSocialHistory($pIsSmoker,$pNoCigPack,$pIsAlcoholDrinker,$pNoBottles,$pIllDrugUser,$pUserId,$pTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_SOCHIST(
                        IS_SMOKER,NO_CIGPK,IS_ADRINKER,NO_BOTTLES,ILL_DRUG_USER,DATE_ADDED,ADDED_BY,TRANS_NO,UPD_CNT)
                          VALUES(:isSmoker,
                                 :noCigPack,
                                 :isAlDrinker,
                                 :noBottles,
                                 :illDrugUser,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :updCnt)");

        $stmt->bindParam(':isSmoker', $pIsSmoker);
        $stmt->bindParam(':noCigPack', $pNoCigPack);
        $stmt->bindParam(':isAlDrinker', $pIsAlcoholDrinker);
        $stmt->bindParam(':noBottles', $pNoBottles);
        $stmt->bindParam(':illDrugUser', $pIllDrugUser);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA03-03 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA03-03 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Immunizations*/
function insertImmunizations($pForChildren,$pForAdult,$pForPregWoman,$pForElderly,$pUserId,$pTransNo,$pOthersImm,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_IMMUNIZATION(
                        CHILD_IMMCODE,YOUNGW_IMMCODE,PREGW_IMMCODE,ELDERLY_IMMCODE,DATE_ADDED,ADDED_BY,TRANS_NO,OTHER_IMM,UPD_CNT)
                          VALUES(:childImmCode,
                                 :youngImmCode,
                                 :pregwImmCode,
                                 :elderlyImmCode,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :otherImmCode,
                                 :updCnt)");

        $stmt->bindParam(':childImmCode', $pForChildren);
        $stmt->bindParam(':youngImmCode', $pForAdult);
        $stmt->bindParam(':pregwImmCode', $pForPregWoman);
        $stmt->bindParam(':elderlyImmCode', $pForElderly);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':otherImmCode', strtoupper($pOthersImm));
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();


    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA04-01 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA04-01 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Menstrual History*/
function insertMenstrualHistory($pMenarche,$pLastMensPeriod,$pPeriodDuration,$pMensInterval,$pPadsPerDay,$pOnsetSexIC,$pBirthControlMethod,$pIsMenopause,$pMenopauseAge,$pUserId,$pTransNo,$getUpdCnt, $pIsApplicable){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_MENSHIST(
                        MENARCHE_PERIOD,LAST_MENS_PERIOD,PERIOD_DURATION,MENS_INTERVAL,PADS_PER_DAY,ONSET_SEX_IC,BIRTH_CTRL_METHOD,IS_MENOPAUSE,MENOPAUSE_AGE,DATE_ADDED,ADDED_BY,TRANS_NO,UPD_CNT,IS_APPLICABLE)
                          VALUES(:menarche,
                                 :lastMensPeriod,
                                 :periodDuration,
                                 :mensInterval,
                                 :padsPerDay,
                                 :onsetSexInt,
                                 :birthCtrlMethod,
                                 :isMenopause,
                                 :menopauseAge,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :updCnt,
                                 :isApplicable)");

        $stmt->bindParam(':menarche', $pMenarche);
        $stmt->bindParam(':lastMensPeriod', $pLastMensPeriod);
        $stmt->bindParam(':periodDuration', $pPeriodDuration);
        $stmt->bindParam(':mensInterval', $pMensInterval);
        $stmt->bindParam(':padsPerDay', $pPadsPerDay);
        $stmt->bindParam(':onsetSexInt', $pOnsetSexIC);
        $stmt->bindParam(':birthCtrlMethod', $pBirthControlMethod);
        $stmt->bindParam(':isMenopause', $pIsMenopause);
        $stmt->bindParam(':menopauseAge', $pMenopauseAge);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->bindParam(':isApplicable', $pIsApplicable);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA05-01 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA05-01 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Pregnancy History and Family Planning*/
function insertPrenancyHistory($pPregCnt,$pDeliveryCnt,$pDeliveryType,$pFullTermCnt,$pPrematureCnt,$pAbortionCnt,$pLivChildrenCnt,$pWithPregIndHyp,$pUserId,$pTransNo,$pWithFamPlan,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_PREGHIST(
                        PREG_CNT,DELIVERY_CNT,DELIVERY_TYP,FULL_TERM_CNT,PREMATURE_CNT,ABORTION_CNT,LIV_CHILDREN_CNT,W_PREG_INDHYP,DATE_ADDED,ADDED_BY,TRANS_NO,W_FAM_PLAN,UPD_CNT)
                          VALUES(:pregCnt,
                                 :deliveryCnt,
                                 :deliverytype,
                                 :fullTermCnt,
                                 :prematureCnt,
                                 :abortionCnt,
                                 :livChildrenCnt,
                                 :wPregIndHyp,
                                 NOW(),
                                 :addedBy,
                                 :transNo,
                                 :wFamPlan,
                                 :updCnt)");

        $stmt->bindParam(':pregCnt', $pPregCnt);
        $stmt->bindParam(':deliveryCnt', $pDeliveryCnt);
        $stmt->bindParam(':deliverytype', $pDeliveryType);
        $stmt->bindParam(':fullTermCnt', $pFullTermCnt);
        $stmt->bindParam(':prematureCnt', $pPrematureCnt);
        $stmt->bindParam(':abortionCnt', $pAbortionCnt);
        $stmt->bindParam(':livChildrenCnt', $pLivChildrenCnt);
        $stmt->bindParam(':wPregIndHyp', $pWithPregIndHyp);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':wFamPlan', $pWithFamPlan);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA05-02 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA05-02 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Pertinent Physical Examination Findings*/
function insertPertinentPhysicalExam($pSystolic,$pDiastolic,$pHr,$pRr,$pHeight,$pWeight,$pVisionAquity,$pLength,$pHeadCirc,$pUserId,$pTransNo,$getUpdCnt,$pTemperature){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEPERT(
                        SYSTOLIC,DIASTOLIC,HR,RR,HEIGHT,WEIGHT,TEMPERATURE,DATE_ADDED,ADDED_BY,TRANS_NO,VISION,LENGTH,HEAD_CIRC,UPD_CNT)
                          VALUES(:systolic, 
                                 :diastolic, 
                                 :hr, 
                                 :rr, 
                                 :height, 
                                 :weight, 
                                 :temp, 
                                 NOW(), 
                                 :addedBy, 
                                 :transNo, 
                                 :vision, 
                                 :length, 
                                 :headCirc,
                                 :updCnt)");

        $stmt->bindParam(':systolic', $pSystolic);
        $stmt->bindParam(':diastolic', $pDiastolic);
        $stmt->bindParam(':hr', $pHr);
        $stmt->bindParam(':rr', $pRr);
        $stmt->bindParam(':height', $pHeight);
        $stmt->bindParam(':weight', $pWeight);
        $stmt->bindParam(':temp',$pTemperature);
        $stmt->bindParam(':vision', $pVisionAquity);
        $stmt->bindParam(':length', $pLength);
        $stmt->bindParam(':headCirc', $pHeadCirc);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA06-01 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA06-01 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert General Survey*/
function insertPeGeneralSurvey($pGenSurveyId, $pGenSurveyRem, $pUserId, $pTransNo){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEGENSURVEY(
                        TRANS_NO,GENSURVEY_ID,GENSURVEY_REM,DATE_ADDED,ADDED_BY)
                          VALUES(:transNo, 
                                 :genSurvey, 
                                 :genSurveyRem, 
                                 NOW(),
                                 :addedBy)");

        $stmt->bindParam(':genSurvey', $pGenSurveyId);
        $stmt->bindParam(':genSurveyRem', $pGenSurveyRem);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSAGenSurvey - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSAGenSurvey - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert General Survey*/
function insertCourseInTheWard($pActionDate, $pDocActionOrder, $pUserId, $pTransNo, $pCaseNo){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_COURSE_WARD(
                        CASE_NO, TRANS_NO,ACTION_DATE,DOCTORS_ACTION,DATE_ADDED,ADDED_BY)
                          VALUES(:caseNo,
                                 :transNo, 
                                 :actDate, 
                                 :docOrder, 
                                 NOW(),
                                 :addedBy)");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->bindParam(':actDate', date('Y-m-d', strtotime($pActionDate)));
        $stmt->bindParam(':docOrder', strtoupper($pDocActionOrder));
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertCourseWard - " . $e->getMessage();
        echo '<script>alert("Error: InsertCourseWard - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}
/*Insert Profile Blood Type*/
function insertBloodType($pBloodType,$pBloodRh,$pUserId,$pTransNo,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_BLOODTYPE(
                        TRANS_NO,BLOOD_TYPE,BLOOD_RH,DATE_ADDED,ADDED_BY,UPD_CNT)
                          VALUES(:transNo, 
                                 :bloodType, 
                                 :bloodRh, 
                                 NOW(),
                                 :addedBy,
                                 :updCnt)");

        $stmt->bindParam(':bloodType', $pBloodType);
        $stmt->bindParam(':bloodRh', $pBloodRh);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA06-02 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA06-02 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Profile Physical Examination Miscellaneous */
function insertProfilePhysicalExamMisc($pSkin, $pHeent, $pChest, $pHeart, $pAbdomen, $pNeuro, $pGU, $pRectal, $pTransNo, $pUserId, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEMISC(
                        SKIN_ID, HEENT_ID, CHEST_ID, HEART_ID, ABDOMEN_ID, NEURO_ID, GU_ID, RECTAL_ID, TRANS_NO, DATE_ADDED, ADDED_BY, UPD_CNT) 
                          VALUES(:skinId, 
                                 :heentId, 
                                 :chestId, 
                                 :heartId, 
                                 :abdomenId, 
                                 :neuroId, 
                                 :guId,
                                 :rectalId,
                                 :transNo, 
                                 NOW(), 
                                 :addedBy,
                                 :updCnt)");

        $stmt->bindParam(':skinId', $pSkin);
        $stmt->bindParam(':heentId',$pHeent);
        $stmt->bindParam(':chestId', $pChest);
        $stmt->bindParam(':heartId', $pHeart);
        $stmt->bindParam(':abdomenId', $pAbdomen);
        $stmt->bindParam(':neuroId', $pNeuro);
        $stmt->bindParam(':guId', $pGU);
        $stmt->bindParam(':rectalId', $pRectal);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA06-03 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA06-03 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert Physical Examination Misc Remarks*/
function insertProfilePhysicalExamMiscRemarks($pHeentRemarks, $pChestRemarks, $pHeartRemarks, $pAbdomenRemarks, $pGenitoRemarks, $pRectalRemarks, $pSkinExtremitiesRemarks,$pNeuroRemarks, $pTransNo, $pUserId, $getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_PESPECIFIC(
                                SKIN_REM, HEENT_REM, CHEST_REM, HEART_REM, ABDOMEN_REM, TRANS_NO, DATE_ADDED, ADDED_BY, NEURO_REM, GU_REM, RECTAL_REM, UPD_CNT) 
                                  VALUES(:skinRem, 
                                         :heentRem, 
                                         :chestRem, 
                                         :heartRem, 
                                         :abdomenRem, 
                                         :transNo,
                                         NOW(), 
                                         :addedBy,
                                         :neuroRem,
                                         :guRem,
                                         :rectalRem,
                                         :updCnt)");

        $stmt->bindParam(':skinRem', $pSkinExtremitiesRemarks);
        $stmt->bindParam(':heentRem', $pHeentRemarks);
        $stmt->bindParam(':chestRem', $pChestRemarks);
        $stmt->bindParam(':heartRem', $pHeartRemarks);
        $stmt->bindParam(':abdomenRem', $pAbdomenRemarks);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':neuroRem',$pNeuroRemarks);
        $stmt->bindParam(':guRem',$pGenitoRemarks);
        $stmt->bindParam(':rectalRem',$pRectalRemarks);
        $stmt->bindParam(':updCnt',$getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA06-04 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA06-04 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert NCD High-risk Assessment*/
function insertNcdHighRiskAssessment($pQ1,$pQ2,$pQ3,$pQ4,$pQ5,$pQ511,$pQ6,$pQ7,$pQ8,$pQ67811,$pQ67812,$pQ67813,$pNcdRbgDate,$pQ67821,$pQ67822,$pNcdRblDate,
                                     $pQ67831,$pQ67832,$pNcdUkDate,$pQ67841,$pQ67842,$pNcdUpDate,$pQ23,$pQ9,$pQ10,$pQ11,$pQ12,$pQ13,$pQ14,$pQ15,$pQ24,$pQ16,$pQ17,$pTransNo, $pUserId,$getUpdCnt){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_PROF_NCDQANS(
                                QID1_YN,QID2_YN,QID3_YN,QID4_YN,QID5_YNX,QID6_YN,QID7_YN,QID8_YN,QID9_YN,QID10_YN,QID11_YN,QID12_YN,QID13_YN,QID14_YN,QID15_YN,QID16_YN,
                                QID17_ABCDE,QID18_YN,QID19_YN,QID19_FBSMG,QID19_FBSMMOL,QID19_FBSDATE,QID20_YN,QID20_CHOLEVAL,QID20_CHOLEDATE,QID21_YN,
                                QID21_KETONVAL,QID21_KETONDATE,QID22_YN,QID22_PROTEINVAL,QID22_PROTEINDATE,QID23_YN,QID24_YN,TRANS_NO,DATE_ADDED,ADDED_BY,UPD_CNT) 
                                  VALUES(:qId1_yn,
                                         :qId2_yn,
                                         :qId3_yn,
                                         :qId4_yn,
                                         :qId5_ynx,
                                         :qId6_yn,
                                         :qId7_yn,
                                         :qId8_yn,
                                         :qId9_yn,
                                         :qId10_yn,
                                         :qId11_yn,
                                         :qId12_yn,
                                         :qId13_yn,
                                         :qId14_yn,
                                         :qId15_yn,
                                         :qId16_yn,
                                         :qId17_abcde,
                                         :qId18_yn,
                                         :qId19_yn,
                                         :qId19_fbsMg,
                                         :qId19_fbsMmol,
                                         :qId19_fbsDate,
                                         :qId20_yn,
                                         :qId20_choleVal,
                                         :qId20_choleDate,
                                         :qId21_yn,
                                         :qId21_ketonVal,
                                         :qId21_ketonDate,
                                         :qId22_yn,
                                         :qId22_proteinVal,
                                         :qId22_proteinDate,
                                         :qId23_yn,
                                         :qId24_yn,                                         
                                         :transNo,
                                         NOW(), 
                                         :addedBy,
                                         :updCnt)");

        $stmt->bindParam(':qId1_yn', $pQ1);
        $stmt->bindParam(':qId2_yn', $pQ2);
        $stmt->bindParam(':qId3_yn', $pQ3);
        $stmt->bindParam(':qId4_yn', $pQ4);
        $stmt->bindParam(':qId5_ynx', $pQ5);
        $stmt->bindParam(':qId6_yn', $pQ6);
        $stmt->bindParam(':qId7_yn', $pQ7);
        $stmt->bindParam(':qId8_yn', $pQ8);
        $stmt->bindParam(':qId9_yn', $pQ9);
        $stmt->bindParam(':qId10_yn', $pQ10);
        $stmt->bindParam(':qId11_yn', $pQ11);
        $stmt->bindParam(':qId12_yn', $pQ12);
        $stmt->bindParam(':qId13_yn', $pQ13);
        $stmt->bindParam(':qId14_yn', $pQ14);
        $stmt->bindParam(':qId15_yn', $pQ15);
        $stmt->bindParam(':qId16_yn', $pQ16);
        $stmt->bindParam(':qId17_abcde', $pQ17);
        $stmt->bindParam(':qId19_yn', $pQ67811);
        $stmt->bindParam(':qId18_yn', $pQ511);
        $stmt->bindParam(':qId19_fbsMg', $pQ67812);
        $stmt->bindParam(':qId19_fbsMmol', $pQ67813);
        $stmt->bindParam(':qId19_fbsDate', $pNcdRbgDate);
        $stmt->bindParam(':qId20_yn', $pQ67821);
        $stmt->bindParam(':qId20_choleVal', $pQ67822);
        $stmt->bindParam(':qId20_choleDate', $pNcdRblDate);
        $stmt->bindParam(':qId21_yn', $pQ67831);
        $stmt->bindParam(':qId21_ketonVal', $pQ67832);
        $stmt->bindParam(':qId21_ketonDate', $pNcdUkDate);
        $stmt->bindParam(':qId22_yn', $pQ67841);
        $stmt->bindParam(':qId22_proteinVal', $pQ67842);
        $stmt->bindParam(':qId22_proteinDate', $pNcdUpDate);
        $stmt->bindParam(':qId23_yn', $pQ23);
        $stmt->bindParam(':qId24_yn', $pQ24);
        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->bindParam(':addedBy', $pUserId);
        $stmt->bindParam(':updCnt', $getUpdCnt);
        $stmt->execute();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: InsertHSA07-01 - " . $e->getMessage();
        echo '<script>alert("Error: InsertHSA07-01 - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Get Updated Count Value in Registration per Transaction*/
function getUpdCntRegistration($pCaseNo){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT MAX(UPD_CNT) AS UPD_CNT
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                WHERE CASE_NO = :caseNo");

        $stmt->bindParam(':caseNo', $pCaseNo);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;
}

/*Get Updated Count Value in Profiling per Transaction*/
function getUpdCntProfiling($pTransNo){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT MAX(UPD_CNT) AS UPD_CNT
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE
                                WHERE TRANS_NO = :transNo");

        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;
}

/*Get Updated Count Value in Consultation per Transaction*/
function getUpdCntConsultation($pTransNo){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT UPD_CNT AS UPD_CNT
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP
                                WHERE TRANS_NO = :transNo");

        $stmt->bindParam(':transNo', $pTransNo);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;
}

/*Get Updated Count Value in Consultation per Transaction*/
function getPackageType(){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_LIB_PACKAGE_TYPE 
                                WHERE LIB_STATUS = 1
                                  AND PACKAGE_ID IN ('E', 'P')
                                  ORDER BY LIB_SORT ASC");

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;
}

/*Insert XML Member Assignment*/
function uploadMemberAssignment($upload){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        /*Start Parsing XML data into table*/
        libxml_use_internal_errors(true);
        $xml=simplexml_load_string(utf8_encode($upload['uploadAssignment'])); //or simplexml_load_file

        foreach( libxml_get_errors() as $error ) {

            print_r($error);

        }

        $userName = (string)$xml['pUsername'];
        $userPassword = (string)$xml['pPassword'];
        $accreNo = $xml['pHciAccreNo'];
        $countAssignment = (string)$xml['pAssignmentTotalCnt'];
        $pmccNo = (string)$xml['pPmccNo'];
        $trasmittalNo = (string)$xml['pReportTransmittalNumber'];

        if($accreNo == $_SESSION['pAccreNum']) {
            /*Start Save File Uploaded*/
            $pUploadId = generateTransNo('UPLOAD_ID');
            $pUploadModule = "ASSIGNMENT";

            $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_UPLOAD(
                                              UPLOAD_ID, UPLOAD_XML, UPLOAD_MODULE, DATE_UPLOADED)
                                        VALUES(:uploadId,
                                               :uploadXml,
                                               :uploadModule,
                                               NOW())");

            $stmt->bindParam(':uploadId', $pUploadId);
            $stmt->bindParam(':uploadModule', $pUploadModule);
            $stmt->bindParam(':uploadXml', $upload['uploadAssignment']);
            $stmt->execute();
            /*End Save File Uploaded*/

            foreach ($xml->ASSIGNMENT as $assignment) {
                foreach ($assignment->ASSIGN as $assign) {
                    $stmt2 = $conn->prepare("INSERT INTO " . $ini['EPCB'] . ".TSEKAP_TBL_ASSIGN(
                                    MEM_PIN, ACCRE_NO, PMCC_NO, EFF_YEAR, ASSIGN_DATE, ASSIGN_BY, ASSIGN_STAT,
                                    MEM_CAT, MEM_NCAT, MEM_NCAT_DESC, MEM_LNAME, MEM_FNAME, MEM_MNAME, MEM_EXTNAME, MEM_DOB,
                                    NO_DEPENDENTS, PACKAGE_TYPE, DATE_INSERTED, REPORT_TRANS_NO)
                                                                        VALUES(:memPin,
                                                                               :accreNo,
                                                                               :pmccNo,
                                                                               :effYear,
                                                                               :assignDate,
                                                                               :assignBy,
                                                                               :assignStat,
                                                                               :memCat,
                                                                               :newMemCat,
                                                                               :newMemCatDesc,
                                                                               :memLname,
                                                                               :memFname,
                                                                               :memMname,
                                                                               :memEname,
                                                                               :memDob,
                                                                               :noOfDependents,
                                                                               :packageType,
                                                                               NOW(),
                                                                               :reportTransNo)
                                                                               ON DUPLICATE KEY UPDATE
                                                                                    MEM_PIN = :memPin,
                                                                                    ACCRE_NO = :accreNo,
                                                                                    PMCC_NO = :pmccNo,
                                                                                    EFF_YEAR = :effYear,
                                                                                    ASSIGN_DATE = :assignDate,
                                                                                    ASSIGN_BY = :assignBy,
                                                                                    ASSIGN_STAT = :assignStat,
                                                                                    MEM_CAT = :memCat,
                                                                                    MEM_NCAT = :newMemCat,
                                                                                    MEM_NCAT_DESC = :newMemCatDesc,
                                                                                    MEM_LNAME = :memLname,
                                                                                    MEM_MNAME = :memFname,
                                                                                    MEM_EXTNAME = :memMname,
                                                                                    MEM_DOB = :memEname,
                                                                                    NO_DEPENDENTS = :noOfDependents,
                                                                                    PACKAGE_TYPE = :packageType,
                                                                                    DATE_INSERTED = NOW(),
                                                                                    REPORT_TRANS_NO = :reportTransNo");

                    $stmt2->bindParam(':memPin', $assign['pMemPin']);
                    $stmt2->bindParam(':accreNo', $accreNo);
                    $stmt2->bindParam(':pmccNo', $pmccNo);
                    $stmt2->bindParam(':effYear', $assign['pEffYear']);
                    $stmt2->bindParam(':assignDate', $assign['pAssignDate']);
                    $stmt2->bindParam(':assignBy', $assign['pAssignBy']);
                    $stmt2->bindParam(':assignStat', $assign['pAssignStat']);
                    $stmt2->bindParam(':memCat', $assign['pMemCat']);
                    $stmt2->bindParam(':newMemCat', $assign['pMemNewCat']);
                    $stmt2->bindParam(':newMemCatDesc', $assign['pMemNewCatDesc']);
                    $stmt2->bindParam(':memLname', $assign['pMemLastName']);
                    $stmt2->bindParam(':memFname', $assign['pMemFirstName']);
                    $stmt2->bindParam(':memMname', $assign['pMemMiddleName']);
                    $stmt2->bindParam(':memEname', $assign['pMemExtName']);
                    $stmt2->bindParam(':memDob', date('Y-m-d', strtotime($assign['pMemDob'])));
                    $stmt2->bindParam(':noOfDependents', $assign['pNoOfDependents']);
                    $stmt2->bindParam(':packageType', $assign['pPackageType']);
                    $stmt2->bindParam(':reportTransNo', $trasmittalNo);
                    $stmt2->execute();
                }
            }
            echo '<script>alert("Successfully saved!");window.location="assignment_report.php"</script>';
        }
        else{
            echo '<script>alert("The file contains invalid Accreditation Number.");</script>';
        }
        /*End Parsing XML data into table*/

        $conn->commit();

    } catch (PDOException $e) {
        $conn->rollback();
        echo $e->getMessage();
        echo '<script>alert("Error: '.$e->getMessage().'");</script>';
    }

    $conn = null;
}


/*Insert XML Member Assignment*/
function uploadFeedbackReport($upload){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        /*Start Parsing XML data into table*/
        $xml = simplexml_load_string($upload['uploadFeedbackReport']);
        $userName = (string)$xml['pUsername'];
        $userPassword = (string)$xml['pPassword'];
        $accreNo = (string)$xml['pHciAccreNo'];
        $countAssignment = (string)$xml['pAssignmentTotalCnt'];
        $pmccNo = (string)$xml['pPmccNo'];
        $trasmittalNo = (string)$xml['pReportTransmittalNumber'];

        if($accreNo == $_SESSION['pAccreNum']) {
            /*Start Save File Uploaded*/
            $pUploadId = generateTransNo('UPLOAD_ID');
            $pUploadModule = "FEEDBACK";

            $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_UPLOAD(
                                              UPLOAD_ID, UPLOAD_XML, UPLOAD_MODULE, DATE_UPLOADED)
                                        VALUES(:uploadId, 
                                               :uploadXml,
                                               :uploadModule,
                                               NOW())");

            $stmt->bindParam(':uploadId', $pUploadId);
            $stmt->bindParam(':uploadModule', $pUploadModule);
            $stmt->bindParam(':uploadXml', $upload['uploadFeedbackReport']);
            $stmt->execute();
            /*End Save File Uploaded*/

            echo '<script>alert("Successfully saved!");window.location="upload_report_feedback.php"</script>';
        } else{
            echo '<script>alert("The file contains invalid Accreditation Number.");</script>';
        }
        /*End Parsing XML data into table*/
        $conn->commit();
    } catch (PDOException $e) {
        $conn->rollback();
        echo $e->getMessage();
        echo '<script>alert("Error: '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

/*Insert XML report*/
function insertGeneratedXMLreport($xmlReport, $reportTransNo, $dateRange){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_REPORTS(
                                REPORT_TRANS_NO, ACCRE_NO, DATE_RANGE, DATE_GENERATED, XML_CONTENT) 
                                  VALUES(:reportTransNo, 
                                         :accreNo, 
                                         :dateRange, 
                                         NOW(), 
                                         :xmlReport)");

        $stmt->bindParam(':reportTransNo', $reportTransNo);
        $stmt->bindParam(':accreNo', $_SESSION['pAccreNum']);
        $stmt->bindParam(':dateRange', $dateRange);
        $stmt->bindParam(':xmlReport', $xmlReport);
        $stmt->execute();

        $conn->commit();

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: Saving Generated XML Report - " . $e->getMessage();
        echo '<script>alert("Error: Saving Generated XML Report - '.$e->getMessage().'");</script>';
    }

    $conn = null;
}

function listMedicalDiseases(){

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_LIB_MDISEASES
                                WHERE LIB_STAT = '1'
                                ORDER BY MDISEASE_CODE ASC");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;

}



function generateTransNo($seq_name) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // CHECK IF SEQUENCE NAME EXIST
        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_SEQNO
                                WHERE SEQ_NAME = :SEQ_NAME");
        $stmt->bindParam(':SEQ_NAME', $seq_name);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($result) {
            $result = $result[0];
            $seq_format = strlen($result["SEQ_FORMAT"]);
            $seq_prefix = $result["SEQ_PREFIX"];
            $cycle_period_format = $result["CYCLE_PERIOD_FORMAT"];
        }
        else {
            throw new Exception("Sequence name ".$seq_name." not found.");
        }

        $seq_code = $seq_prefix.$_SESSION["pAccreNum"].date($cycle_period_format);

        // CHECK IF SEQUENCE EXIST IN LOGS
        $stmt = $conn->prepare("SELECT LAST_VALUE, DATE_FORMAT(LAST_GEN_DATE, '%m/%Y') as LAST_GEN_DATE, LAST_GEN_BY
                                FROM ".$ini['EPCB'].".TSEKAP_SEQNO_DET
                                WHERE SEQ_NAME = :SEQ_NAME
                                AND SEQ_CODE = :SEQ_CODE");
        $stmt->bindParam(':SEQ_NAME', $seq_name);
        $stmt->bindParam(':SEQ_CODE', $seq_code);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($result) {
            $result = $result[0];
            $last_value = $result["LAST_VALUE"];
            $last_gen_date = $result["LAST_GEN_DATE"];
            $current_date = date("m/Y");

            if($last_gen_date != $current_date) {
                $new_value = 1;
            }
            else {
                if($last_value != "99999") {
                    $new_value = $last_value+1;
                }
                else {
                    throw new Exception("Maximum sequence number reached for sequence name ".$seq_name." and code ".$_SESSION["pAccreNum"]);
                }
            }

            $query = "UPDATE ".$ini['EPCB'].".TSEKAP_SEQNO_DET 
                      SET LAST_VALUE = :LAST_VALUE, 
                          LAST_GEN_DATE = NOW(), 
                          LAST_GEN_BY = :LAST_GEN_BY
                      WHERE SEQ_NAME = :SEQ_NAME
                      AND SEQ_CODE = :SEQ_CODE";
        }
        else {
            $new_value = 1;
            $query = "INSERT INTO ".$ini['EPCB'].".TSEKAP_SEQNO_DET (SEQ_NAME, SEQ_CODE, LAST_VALUE, LAST_GEN_DATE, LAST_GEN_BY)
                      VALUES (:SEQ_NAME, :SEQ_CODE, :LAST_VALUE, NOW(), :LAST_GEN_BY)";
        }

        // INSERT SEQUENCE IN LOG IF NOT EXIST; INCREMENT IF EXIST;
        $conn->begintransaction();
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':SEQ_NAME', $seq_name);
        $stmt->bindParam(':SEQ_CODE', $seq_code);
        $stmt->bindParam(':LAST_VALUE', $new_value);
        $stmt->bindParam(':LAST_GEN_BY', $_SESSION["pUserID"]);
        $stmt->execute();
        $conn->commit();

        $sequence_no = str_pad($new_value, $seq_format, 0, STR_PAD_LEFT);
        $trans_no = $seq_code.$sequence_no;
    }
    catch(PDOException $e) {
        $message = htmlentities($e->getMessage(),ENT_QUOTES);
        $message = preg_replace('~[\r\n]+~', ' ', $message);
        echo "<script>alert('".$message."');</script>";
        $conn->rollBack();
    }
    catch (Exception $ex) {
        $err_msg = $ex->getMessage();
        $message = htmlentities($err_msg,ENT_NOQUOTES);
        $message = preg_replace('~[\r\n]+~', ' ', $message);
        echo "<script>alert('".$message."');</script>";
    }

    $conn = null;

    return $trans_no;

}

//Get Enlistment/Registration Data Module
function getEnlistData($case_no) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                WHERE CASE_NO = :CASE_NO");
        $stmt->bindParam(":CASE_NO", $case_no);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result[0];

}

/*GET PROFILING RECORD TO EDIT/UPDATE PATIENT INFORMATION*/
function getPatientHsaRecord($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.CASE_NO
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist /*ENLISTMENT RECORD*/
                                INNER JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile ON enlist.CASE_NO = profile.CASE_NO /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_OINFO AS oinfo ON profile.TRANS_NO = oinfo.TRANS_NO /*PATIENTS DETAILS OTHER INFO*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_SOCHIST AS sochist ON profile.TRANS_NO = sochist.TRANS_NO /*PERSONAL/SOCIAL HISTORY*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PREGHIST AS preghist ON profile.TRANS_NO = preghist.TRANS_NO /*OB-GYNE HISTORY - PREGNANCY*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MENSHIST AS menshist ON profile.TRANS_NO = menshist.TRANS_NO /*OB-GYNE HISTORY - MENSTRUAL*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEPERT AS pepert ON profile.TRANS_NO = pepert.TRANS_NO /*PERTINENT PHYSICAL EXAMINATION FINDINGS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_BLOODTYPE AS bloodtype ON profile.TRANS_NO = bloodtype.TRANS_NO /*PERTINENT PHYSICAL EXAMINATION FINDINGS - BLOOD TYPE*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PESPECIFIC AS pespecific ON profile.TRANS_NO = pespecific.TRANS_NO /*PERTINENT PHYSICAL EXAMINATION FINDINGS - REMARKS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_NCDQANS AS ncdqans ON profile.TRANS_NO = ncdqans.TRANS_NO /*NCD HIGH-RISK ASSESSMENT*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEGENSURVEY AS gensurvey ON profile.TRANS_NO = gensurvey.TRANS_NO /*NCD HIGH-RISK ASSESSMENT*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND oinfo.UPD_CNT = :updCnt
                                  AND sochist.UPD_CNT = :updCnt
                                  AND preghist.UPD_CNT = :updCnt
                                  AND menshist.UPD_CNT = :updCnt
                                  AND pepert.UPD_CNT = :updCnt
                                  AND bloodtype.UPD_CNT = :updCnt
                                  AND pespecific.UPD_CNT = :updCnt
                                  AND ncdqans.UPD_CNT = :updCnt");

        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result[0];

}

/*GET PATIENT PAST MEDICAL HISTORY*/
function getPatientHsaPastMedicalHistory($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MEDHIST AS medhist ON profile.TRANS_NO = medhist.TRANS_NO /*PAST MEDICAL HISTORY CHECKLIST*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND medhist.UPD_CNT = :updCnt");

        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*GET PATIENT PAST MEDICAL HISTORY*/
function getPatientHsaPastMedicalRemarks($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MHSPECIFIC AS mhspecific ON profile.TRANS_NO = mhspecific.TRANS_NO /*PAST MEDICAL HISTORY REMARKS*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND mhspecific.UPD_CNT = :updCnt");

        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}


/*GET PATIENT FAMILY HISTORY*/
function getPatientHsaFamilyHistory($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_FAMHIST AS famhist ON profile.TRANS_NO = famhist.TRANS_NO /*FAMILY HISTORY CHECKLIST*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_FHSPECIFIC AS fhspecific ON profile.TRANS_NO = fhspecific.TRANS_NO /*FAMILY HISTORY - SPECIFIC REMARKS*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND famhist.UPD_CNT = :updCnt
                                  AND fhspecific.UPD_CNT = :updCnt");

        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*GET PATIENT FAMILY HISTORY REMARKS*/
function getPatientHsaFamilyRemarks($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_FHSPECIFIC AS fhspecific ON profile.TRANS_NO = fhspecific.TRANS_NO /*FAMILY HISTORY - SPECIFIC REMARKS*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND fhspecific.UPD_CNT = :updCnt");


        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}
/*GET PATIENT IMMUNIZATIONS*/
function getPatientHsaImmunization($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_IMMUNIZATION AS immune ON profile.TRANS_NO = immune.TRANS_NO /*FAMILY HISTORY CHECKLIST*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND immune.UPD_CNT = :updCnt");

        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*GET PATIENT PERTINENT MISCELLANEOUS */
function getPatientHsaPertinentMisc($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEMISC AS pemisc ON profile.TRANS_NO = pemisc.TRANS_NO /*FAMILY HISTORY CHECKLIST*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND pemisc.UPD_CNT = :updCnt");

        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}


function getPatientHsaMedicine($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_MEDICINE AS meds ON profile.TRANS_NO = meds.TRANS_NO /*MEDICINE*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND meds.TRANS_NO = :transNo
                                  AND meds.UPD_CNT = :updCnt");

        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

/*GET PATIENT PERTINENT MISCELLANEOUS */
function getPatientHsaSurgicalHistory($hsa_transNo, $getUpdCnt) {

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_SURGHIST AS surghist ON profile.TRANS_NO = surghist.TRANS_NO /*FAMILY HISTORY CHECKLIST*/
                                WHERE profile.TRANS_NO = :transNo
                                  AND profile.UPD_CNT = :updCnt
                                  AND surghist.UPD_CNT = :updCnt");

        $stmt->bindParam(":transNo", $hsa_transNo);
        $stmt->bindParam(":updCnt", $getUpdCnt);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function listChildImmunizations(){

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_LIB_IMMCHILD
                                WHERE LIB_STAT = '1'
                                ORDER BY SORT_NO ASC");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;

}

function listAdultImmunizations(){

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_LIB_IMMYOUNGW
                                WHERE LIB_STAT = '1'
                                ORDER BY SORT_NO ASC");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;

}

function listPregnantImmunizations(){

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_LIB_IMMPREGW
                                WHERE LIB_STAT = '1'
                                ORDER BY SORT_NO ASC");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;

}

function listElderlyImmunizations(){

    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                FROM ".$ini['EPCB'].".TSEKAP_LIB_IMMELDERLY
                                WHERE LIB_STAT = '1'
                                ORDER BY SORT_NO ASC");
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

    return $result;

}


/*CF4*/
/*Get CF4 Record*/
function getListCF4records(){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST 
                                        WHERE XPS_MODULE = 'CF4'");

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function saveCF4record($cf4)
{
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=" . $ini["DBSERVER"] . ";dbname=" . $ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $conn->begintransaction();

        session_start();
        $pUserId = $_SESSION['pUserID'];
        $pHciNo = $_SESSION['pHciNum'];
        $pAccreNo = $_SESSION['pAccreNum'];
        $pXPSmodule = "CF4";
        $pCF4Date=date('Y-m-d');
        $pEffYear=date('Y');
        $getUpdCnt = 0;
        $pPackType = 'A'; /*ACR - for CF4 Claims*/
        $pTransNo = generateTransNo('CF4_NO'); //automatically generated
        $pCaseNo = $pTransNo; //automatically generated
        $pPxType = $cf4['txtPerPatType'];
        $pPxPin = $cf4['txtPerPatPIN'];

        /*Start Save Profile in Registration Module*/
        $stmt = $conn->prepare("INSERT INTO ".$ini['EPCB'].".TSEKAP_TBL_ENLIST (
                                      CASE_NO, TRANS_NO, TRANS_DATE, HCI_NO, ACCRE_NO, 
                                      PX_TYPE, PX_LNAME, PX_FNAME, PX_MNAME, PX_EXTNAME, 
                                      PX_PIN, PX_DOB, PX_SEX, 
                                      ENLIST_DATE, PACKAGE_TYPE, CREATED_BY, EFF_YEAR, XPS_MODULE, CLAIM_ID, CLAIM_TRANS_ID, DATE_ADDED,
                                      CIVIL_STATUS) 
                                        VALUES(:caseNo, :transNo, NOW(), :hciNo, :accreNo, :pxType, :pxLname, :pxFname, :pxMname, :pxExtname, :pxPin, :pxDob,:pxSex,
                                        NOW(), :enlistType, :createdBY, :effYear, :xpsMod, :claimId, :claimTransId, NOW(), :civilStatus)");

        $stmt->bindParam(':caseNo', $pTransNo);
        $stmt->bindParam(':transNo',$pTransNo);
        $stmt->bindParam(':hciNo', $pHciNo);
        $stmt->bindParam(':accreNo', $pAccreNo);
        $stmt->bindParam(':pxType', $cf4['txtPerPatType']);
        $stmt->bindParam(':pxLname', strtoupper($cf4['txtPerPatLname']));
        $stmt->bindParam(':pxFname', strtoupper($cf4['txtPerPatFname']));
        $stmt->bindParam(':pxMname', strtoupper($cf4['txtPerPatMname']));
        $stmt->bindParam(':pxExtname', strtoupper($cf4['txtPerPatExtName']));
        $stmt->bindParam(':pxPin', $cf4['txtPerPatPIN']);
        $stmt->bindParam(':pxDob', date('Y-m-d', strtotime($cf4['txtPerPatBirthday'])));
        $stmt->bindParam(':pxSex', $cf4['txtPerPatSex']);
        $stmt->bindParam(':enlistType',$pPackType);
        $stmt->bindParam(':createdBY', $pUserId);
        $stmt->bindParam(':effYear', date('Y'));
        $stmt->bindParam(':xpsMod', $pXPSmodule);
        $stmt->bindParam(':claimId', trim($cf4['txtPerClaimId']));
        $stmt->bindParam(':claimTransId', trim($cf4['txtPerTransmittalNo']));
        $stmt->bindParam(':civilStatus', $cf4['txtPerPatStatus']);
        $stmt->execute();
        /*End Save Profile in Registration Module*/

        /*Start Patient Data Sub-module*/
        insertProfilingInfo($pCaseNo, $pTransNo,$pCF4Date, $pHciNo, $pPxPin, $pPxType, NULL, $pUserId, $pEffYear, "CF4", "Y", $pXPSmodule);
        /*End Patient Data Sub-module*/

        /*Start History of Present Illness & Pertinent Signs & Symptoms on Admission*/
        /*Consultation/SOAP Tbl
        History of Present Illness*/
        /*Save Patient Info to Mother Tbl Consultation*/
        insertConsultationPatientInfo($pCaseNo, $pTransNo, $pHciNo, $pPxPin, $pPxType, NULL, $pCF4Date, $pUserId, $pEffYear, "CF4", $getUpdCnt, $pXPSmodule);

        $pSignsSymptoms=$cf4['pSignsSymptoms'];
        $pChiefComplaint=$cf4['pChiefComplaint'];
        $pHistPresentIllness=$cf4['pHistPresentIllness'];
        $pOtherComplaint=$cf4['pCf4OtherSymptoms'];
        $pPainSite=$cf4['pPainSite'];
        insertSubjectiveHistory($pUserId, $pTransNo, $pChiefComplaint, $pHistPresentIllness, $pOtherComplaint, $getUpdCnt, $pSignsSymptoms, $pPainSite);
        /*Pertinent Signs & Symptoms on Admission*/

        /*End History of Present Illness & Pertinent Signs & Symptoms on Admission*/

        /*Start Pertinent Past Medical History*/
        $pPastMedHistory = '998';
        $pSpecificDesc = $cf4['txaMedHistOthers'];
        insertPastMedicalHistorySpecific(NULL, $pSpecificDesc, $pTransNo, $pUserId, $getUpdCnt);

        /*End Pertinent Past Medical History*/

        /*Start Ob-gyne History*/
        /*Menstrual History*/
        $pMenarche = $cf4['txtOBHistMenarche'];
        if($cf4['mhDone'] == 'N'){
            $pLastMensPeriod = NULL;
        } else{
            $pLastMensPeriod = date('Y-m-d', strtotime($cf4['txtOBHistLastMens']));
        }
        $pPeriodDuration = $cf4['txtOBHistPeriodDuration'];
        $pIsApplicable = $cf4['mhDone'];
        insertMenstrualHistory(NULL, $pLastMensPeriod, NULL, NULL, NULL, NULL, NULL, NULL, NULL, $pUserId, $pTransNo, $getUpdCnt, $pIsApplicable);

        /*Pregnany History*/
        $pPregCnt = $cf4['txtOBHistGravity'];
        $pDeliveryCnt = $cf4['txtOBHistParity'];
        $pFullTermCnt = $cf4['txtOBHistFullTerm'];
        $pPrematureCnt = $cf4['txtOBHistPremature'];
        $pAbortionCnt = $cf4['txtOBHistAbortion'];
        $pLivingChildrenCnt = $cf4['txtOBHistLivingChildren'];
        insertPrenancyHistory($pPregCnt, $pDeliveryCnt, NULL, $pFullTermCnt, $pPrematureCnt, $pAbortionCnt, $pLivingChildrenCnt, NULL, $pUserId, $pTransNo, NULL, $getUpdCnt);
        /*End Ob-gyne History*/

        /*Start Physical Examination on Admission*/
        /*Physical Exam Findings*/
        $pSystolic = $cf4['txtPhExSystolic'];
        $pDiastolic = $cf4['txtPhExBPDiastolic'];
        $pHr = $cf4['txtPhExHeartRate'];
        $pRr = $cf4['txtPhExRespiratoryRate'];
        $pTemp = $cf4['txtPhExTemp'];
        insertPertinentPhysicalExam($pSystolic, $pDiastolic, $pHr, $pRr, NULL, NULL, NULL, NULL, NULL,  $pUserId, $pTransNo, $getUpdCnt, $pTemp);
        /*General Survey*/
        $pGenSurveyId = $cf4['pGenSurvey'];
        $pGenSurveyRem = strtoupper($cf4['pGenSurveyRemarks']);
        insertPeGeneralSurvey($pGenSurveyId, $pGenSurveyRem, $pUserId, $pTransNo);

        /*Pertinent Findings Per System
        Physical Exam Misc*/
        $pSkin = $cf4['skinExtremities'];
        $pGenito = $cf4['genitourinary'];
        $pRectal = $cf4['rectal'];
        $pHeent = $cf4['heent'];
        $pChest = $cf4['chest'];
        $pHeart = $cf4['heart'];
        $pAbdomen = $cf4['abdomen'];
        $pNeuro = $cf4['neuro'];

        /*A. Heent*/
        for ($i = 0; $i < count($pHeent); $i++) {
            if ($pHeent[$i] != '') {
                insertProfilePhysicalExamMisc(null, $pHeent[$i], null, null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*B. Chest/Lungs*/
        for ($i = 0; $i < count($pChest); $i++) {
            if ($pChest[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, $pChest[$i], null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*C. Heart*/
        for ($i = 0; $i < count($pHeart); $i++) {
            if ($pHeart[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, $pHeart[$i], null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*D. Abdomen*/
        for ($i = 0; $i < count($pAbdomen); $i++) {
            if ($pAbdomen[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, null, $pAbdomen[$i], null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*E. Genitourinary*/
        for ($i = 0; $i < count($pGenito); $i++) {
            if ($pGenito[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, null, null, null, $pGenito[$i], null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*F. Digital Rectal Examination*/
        for ($i = 0; $i < count($pRectal); $i++) {
            if ($pRectal[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, null, null, null, null, $pRectal[$i], $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*G. Skin/Extremities*/
        for ($i = 0; $i < count($pSkin); $i++) {
            if ($pSkin[$i] != '') {
                insertProfilePhysicalExamMisc($pSkin[$i], null, null, null, null, null, null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*H. Neurological*/
        for ($i = 0; $i < count($pNeuro); $i++) {
            if ($pNeuro[$i] != '') {
                insertProfilePhysicalExamMisc(null, null, null, null, null, $pNeuro[$i], null, null, $pTransNo, $pUserId, $getUpdCnt);
            }
        }

        /*Remarks*/
        $pHeentRemarks = strtoupper($cf4['heent_remarks']);
        $pChestRemarks = strtoupper($cf4['chest_lungs_remarks']);
        $pHeartRemarks = strtoupper($cf4['heart_remarks']);
        $pAbdomenRemarks = strtoupper($cf4['abdomen_remarks']);
        $pGenitoRemarks = strtoupper($cf4['gu_remarks']);
        $pRectalRemarks = strtoupper($cf4['rectal_remarks']);
        $pSkinExtremitiesRemarks = strtoupper($cf4['skinExtremities_remarks']);
        $pNeuroRemarks = strtoupper($cf4['neuro_remarks']);
        insertProfilePhysicalExamMiscRemarks($pHeentRemarks, $pChestRemarks, $pHeartRemarks, $pAbdomenRemarks, $pGenitoRemarks, $pRectalRemarks, $pSkinExtremitiesRemarks, $pNeuroRemarks, $pTransNo, $pUserId, $getUpdCnt);
        /*End Physical Examination on Admission*/

        /*Start Course in the ward*/
        $pActionDate =$cf4['pDateActionWard'];
        $pDocActionOrder = $cf4['pActionWard'];
        for ($i = 0; $i < count($pDocActionOrder); $i++) {
            insertCourseInTheWard($pActionDate[$i], $pDocActionOrder[$i], $pUserId, $pTransNo, $pCaseNo);
        }
        /*End Course in the ward*/

        /*Medicine*/
        $pDoctorName = "NA";
        $pDrugCodeMeds = $cf4['pDrugCodeMeds'];
        $pGenCodeMeds = $cf4['pGenCodeMeds'];
        $pSaltMeds = $cf4['pSaltCodeMeds'];
        $pStrengthMeds = $cf4['pStrengthCodeMeds'];
        $pFormMeds = $cf4['pFormCodeMeds'];
        $pUnitMeds = $cf4['pUnitCodeMeds'];
        $pPackageMeds = $cf4['pPackageCodeMeds'];
        $pRouteMeds = $cf4['pRouteMeds'];
        $pQuantityMeds = $cf4['pQtyMeds'];
        $pUnitPriceMeds = NULL;
        $pCopayMeds = NULL;
        $pTotalAmtPriceMeds = $cf4['pTotalPriceMeds'];
        $pInsQtyMeds = $cf4['pInsQtyMeds'];
        $pInsStrengthMeds = NULL;
        $pInsFreqMeds = $cf4['pFrequencyMeds'];
        $pGenericName = $cf4['pGenericNameMeds'];

        if($pGenCodeMeds != NULL) {
            $pApplicable = "Y";
            for ($i = 0; $i < count($pGenCodeMeds); $i++) {
                insertMedicine($pDrugCodeMeds[$i], $pGenCodeMeds[$i], $pStrengthMeds[$i], $pFormMeds[$i], $pPackageMeds[$i],
                    $pQuantityMeds[$i], $pUnitPriceMeds[$i], $pCopayMeds, $pTotalAmtPriceMeds[$i], $pInsQtyMeds, $pInsStrengthMeds, $pInsFreqMeds,
                    $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pDoctorName, $pApplicable,$pGenericName[$i],$pSaltMeds[$i],$pUnitMeds[$i],$pRouteMeds[$i]);
            }
        }
        else{
            $pApplicable = "N";
            insertMedicine(NULL, NULL, NULL, NULL, NULL,
                NULL, NULL, NULL, NULL, NULL, NULL, NULL,
                $pCaseNo, $pTransNo, $pUserId, $getUpdCnt, $pXPSmodule, $pDoctorName, $pApplicable,NULL,NULL,NULL,NULL);
        }
        /*End Medicine*/

        $conn->commit();

        echo '<script>alert("Successfully saved!");window.location="cf4_data_entry.php";</script>';

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: CF4 " . $e->getMessage();
        echo '<script>alert("Error: CF4 '.$e->getMessage().'");</script>';
    }

    $conn = null;

}
/*GET RESULTS OF CF4*/
function getReportResultCf4PatientRecord($claimId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST
                                        WHERE CLAIM_ID = :pxClaimId
                                          AND XPS_MODULE = 'CF4'
                                          AND TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)");


        $stmt->bindParam(':pxClaimId', $claimId);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;

}

function getReportResultProfilingCf4($claimId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, profile.TRANS_NO AS TRANS_NO
                                    FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENT DETAILS*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist ON profile.TRANS_NO = enlist.TRANS_NO
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PREGHIST AS preghist ON profile.TRANS_NO = preghist.TRANS_NO /*OB-GYNE HISTORY - PREGNANCY*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MENSHIST AS menshist ON profile.TRANS_NO = menshist.TRANS_NO /*OB-GYNE HISTORY - MENSTRUAL*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEPERT AS pepert ON profile.TRANS_NO = pepert.TRANS_NO /*PERTINENT PHYSICAL EXAMINATION FINDINGS*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PESPECIFIC AS pespecific ON profile.TRANS_NO = pespecific.TRANS_NO /*PERTINENT PHYSICAL EXAMINATION FINDINGS - REMARKS*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEGENSURVEY AS survey ON profile.TRANS_NO = survey.TRANS_NO /*PLAN/MANAGEMENT - ADVICE*/
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'CF4'
                                              AND enlist.CLAIM_ID = :pxClaimId
                                              AND enlist.TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)
                                                ");

        $stmt->bindParam(':pxClaimId', $claimId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;

    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultCourseWardCf4($claimId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *, enlist.TRANS_NO AS TRANS_NO
                                    FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist /*PATIENT DETAILS*/
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_COURSE_WARD AS ward ON enlist.TRANS_NO = ward.TRANS_NO
                                            WHERE enlist.XPS_MODULE = 'CF4'
                                              AND enlist.CLAIM_ID = :pxClaimId
                                              AND enlist.TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)
                                                ");

        $stmt->bindParam(':pxClaimId', $claimId);
        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;

    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultCf4MedHist($claimId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT medhist.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.PROF_DATE, profile.EFF_YEAR, profile.IS_FINALIZE, enlist.TRANS_NO, enlist.CLAIM_ID
                                           FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                              LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist ON profile.TRANS_NO = enlist.TRANS_NO
                                              LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MEDHIST AS medhist ON profile.TRANS_NO = medhist.TRANS_NO 
                                                WHERE profile.IS_FINALIZE = 'Y'
                                                  AND profile.XPS_MODULE = 'CF4'
                                                  AND enlist.CLAIM_ID = :pxClaimId
                                                  AND enlist.TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)
                                                 ");

        $stmt->bindParam(':pxClaimId', $claimId);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultCf4MHspecific($claimId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT mhspecific.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.PROF_DATE, profile.EFF_YEAR, profile.IS_FINALIZE, enlist.TRANS_NO, enlist.CLAIM_ID
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist ON profile.TRANS_NO = enlist.TRANS_NO
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_MHSPECIFIC AS mhspecific ON profile.TRANS_NO = mhspecific.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'CF4'
                                              AND enlist.CLAIM_ID = :pxClaimId
                                              AND enlist.TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)
                                             ");

        $stmt->bindParam(':pxClaimId', $claimId);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultCf4PEmisc($claimid){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT pemisc.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.PROF_DATE, profile.EFF_YEAR, profile.IS_FINALIZE, enlist.TRANS_NO, enlist.CLAIM_ID
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist ON profile.TRANS_NO = enlist.TRANS_NO
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_PEMISC AS pemisc ON profile.TRANS_NO = pemisc.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'CF4'
                                              AND enlist.CLAIM_ID = :pxClaimId
                                              AND enlist.TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)
                                             ");

        $stmt->bindParam(':pxClaimId', $claimid);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultCf4Surghist($claimId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT surghist.*, profile.TRANS_NO, profile.CASE_NO, profile.UPD_CNT, profile.PROF_DATE, profile.EFF_YEAR, profile.IS_FINALIZE, enlist.TRANS_NO, enlist.CLAIM_ID
                                       FROM ".$ini['EPCB'].".TSEKAP_TBL_PROFILE AS profile /*PATIENTS DETAILS*/
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist ON profile.TRANS_NO = enlist.TRANS_NO
                                          LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_PROF_SURGHIST AS surghist ON profile.TRANS_NO = surghist.TRANS_NO 
                                            WHERE profile.IS_FINALIZE = 'Y'
                                              AND profile.XPS_MODULE = 'CF4'
                                              AND enlist.CLAIM_ID = :pxClaimId
                                              AND enlist.TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)
                                             ");

        $stmt->bindParam(':pxClaimId', $claimId);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultCf4Soap($claimId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                      FROM ".$ini['EPCB'].".TSEKAP_TBL_SOAP as soap
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST AS enlist ON soap.TRANS_NO = enlist.TRANS_NO
                                        LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_SOAP_SUBJECTIVE as subjective ON soap.TRANS_NO = subjective.TRANS_NO 
                                        WHERE enlist.CLAIM_ID = :pxClaimId
                                          AND soap.XPS_MODULE = 'CF4'
                                          AND enlist.TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)
                                          ");

        $stmt->bindParam(':pxClaimId', $claimId);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}

function getReportResultCf4Medicine($claimId){
    $ini = parse_ini_file("config.ini");

    try {
        $conn = new PDO("mysql:host=".$ini["DBSERVER"].";dbname=".$ini["EPCB"], $ini['APPUSERNAME'], $ini['APPPASSWORD']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT *
                                     FROM ".$ini['EPCB'].".TSEKAP_TBL_MEDICINE as meds
                                     LEFT JOIN ".$ini['EPCB'].".TSEKAP_TBL_ENLIST as enlist ON meds.TRANS_NO = enlist.TRANS_NO
                                        WHERE enlist.CLAIM_ID = :pxClaimId                                        
                                          AND meds.XPS_MODULE IN ('CF4')
                                          AND enlist.TRANS_DATE = (SELECT MAX(TRANS_DATE) FROM ".$ini['EPCB'].".TSEKAP_TBL_ENLIST WHERE CLAIM_ID = :pxClaimId)
                                             ");

        $stmt->bindParam(':pxClaimId', $claimId);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }
    catch(PDOException $e)
    {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
}
?>