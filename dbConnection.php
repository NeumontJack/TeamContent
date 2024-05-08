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

    $query = "SELECT JSON_OBJECT ( 'userid', id, 'username', username)
            FROM webdb.users WHERE username = '". $infoList[0]. "' and password = '". $infoList[1] . "';";

    return mysqli_query($dbConn, $query);
}

function adduser($dbConn, $info) {

    $infoList = (explode("///", $info));

    $query = "INSERT INTO webdb.users ( fname, lname, password, email, role, username) 
                VALUES ( '".$infoList[0] ."', '". $infoList[1]."', '" . $infoList[2]. "', '". $infoList[3]."', 'USER' , '" . $infoList[4] . "');";

    return mysqli_query($dbConn, $query);

}

function createUserPage($dbConn, $info){

    $infoList = (explode("///", $info));

    $query = "INSERT INTO webdb.userspage ( userid, username ) 
                VALUES ( '" . $infoList[0] . "', '" . $infoList[1] . "');";

    return mysqli_query($dbConn, $query);
}

function getUserPage($dbConn, $info) {

    $infoList = (explode("///", $info));

    $query = "SELECT JSON_OBJECT ('username', username, 'pic', profilepic, 'about', aboutme)
            FROM webdb.userspage WHERE userId = '". $infoList[0]. "' and username = '". $infoList[1] . "';";

    return mysqli_query($dbConn, $query);
}

?>

