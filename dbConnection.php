<?php

//Const definitions for the db
DEFINE("SERVER", "localhost");
DEFINE("USERN", "root");
DEFINE("PASS", "Dr.Phid21@");
DEFINE("DBNAME", "webdb");

// Try connection with db
function dbconnect()
{
    $dbConn = mysqli_connect(SERVER, USERN, PASS, DBNAME);

    if (!$dbConn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    return $dbConn;
}

function searchUser($dbConn, $info) {

    $infoList = (explode("///", $info));

    $query = "SELECT JSON_OBJECT ( 'userid', id )
            FROM webdb.users WHERE username = '". $infoList[0]. "' and password = '". $infoList[1] . "';";

    return mysqli_query($dbConn, $query);
}

?>

