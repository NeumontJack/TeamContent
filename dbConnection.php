<?php

DEFINE("SERVER", "localhost");
DEFINE("USERN", "root");
DEFINE("PASS", "Nu201251623");
DEFINE("DBNAME", "teamcontent");

function dbconnect()
{
    $dbConn = mysqli_connect(SERVER, USERN, PASS, DBNAME);

    if(!$dbConn){
        die("Connection failed: " . mysqli_connect_error());
    }

    return $dbConn;
}

?>