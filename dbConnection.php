<?php

//Const definitions for the db
DEFINE("SERVER", "localhost");
DEFINE("USERN", "root");
DEFINE("PASS", "Dr.Phid21@");
DEFINE("DBNAME", "webdb");

// Try connection with db
// DEFINE("SERVER", "localhost");
// DEFINE("USERN", "root");
// DEFINE("PASS", "Nu201251623");
// DEFINE("DBNAME", "teamcontent");

function dbconnect()
{
    $dbConn = mysqli_connect(SERVER, USERN, PASS, DBNAME);

    if(!$dbConn){
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

function getUserPageAdmin($dbConn, $info) {

    $query = "SELECT JSON_OBJECT ('username', username, 'pic', profilepic, 'about', aboutme)
            FROM webdb.userspage WHERE userId = '" . $info . "';";

    return mysqli_query($dbConn, $query);
}

function getAllUsers($dbConn) {

    $query = "SELECT JSON_OBJECT ( 'username', username, 'pic', profilepic, 'id', id)
                FROM webdb.userspage;";

    return mysqli_query($dbConn, $query);
}

function deleteUser($dbConn, $data) {

    $query = "DELETE FROM userspage WHERE userspage.id= '" . $data . "';";

    return mysqli_query($dbConn, $query);
}

function updatePic($dbConn, $data) {

    $infolist = (explode("///", $data));

    $query = "UPDATE userspage SET userspage.profilepic= '" . $infolist[2] ."' WHERE userspage.userId= '" . $infolist[0] ."';";

    return mysqli_query($dbConn, $query);
}

function updateAbout($dbConn, $data) {
    $infolist = (explode("///", $data));

    $query = "UPDATE userspage SET userspage.aboutme= '" . $infolist[2] . "' WHERE userspage.userId= '" . $infolist[0] . "';";

    return mysqli_query($dbConn, $query);
}

?>

