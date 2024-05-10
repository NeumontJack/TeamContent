<?php

include("dbConnection.php");

header('Content-Type: application/json');


$myJSON = "";
$row = null;
$myGet = null;
$rowArray = null;
$data = null;

if (array_key_exists("loginI", $_GET) == TRUE) {

    $dbconn = dbconnect();
    $data = $_GET["loginI"];
    //echo $data;

    $feed = searchUser($dbconn, $data);
    if ($feed) {
        // loop through each record and format the json (apply any needed business logic)
        while ($row = mysqli_fetch_array($feed)) {
            $rowArray[] = json_decode($row[0]);
        }

        // Format array as json
        $myGet = json_encode($rowArray);

    }

    mysqli_close($dbconn);
}

if (array_key_exists("cUser", $_GET) == TRUE) {

    $dbconn = dbconnect();
    $data = $_GET["cUser"];

    adduser($dbconn, $data);
    $feed = searchUser($dbconn, $data);

    if ($feed) {
        // loop through each record and format the json (apply any needed business logic)
        while ($row = mysqli_fetch_array($feed)) {
            $rowArray[] = json_decode($row[0]);
        }

        // Format array as json
        $myGet = json_encode($rowArray);
    }
    mysqli_close($dbconn);
}

if (array_key_exists('cInfo', $_GET) == TRUE) {
    
    $dbconn = dbconnect();
    $data = $_GET["cInfo"];

    createUserPage($dbconn, $data);

    mysqli_close($dbconn);
}

if (array_key_exists('userPage', $_GET) == TRUE) {

    $dbconn = dbconnect();
    $data = $_GET['userPage'];

    $feed = getUserPage($dbconn, $data);

    if ($feed) {
        // loop through each record and format the json (apply any needed business logic)
        while ($row = mysqli_fetch_array($feed)) {
            $rowArray[] = json_decode($row[0]);
        }

        // Format array as json
        $myGet = json_encode($rowArray);
    }
    mysqli_close($dbconn);

}

if (array_key_exists('delId', $_GET) == TRUE) {

    $dbconn = dbconnect();
    $data = $_GET['delId'];

    deleteUser($dbconn, $data);

    mysqli_close($dbconn);
}

if (array_key_exists('upPic', $_GET) == TRUE) {

    $dbconn = dbconnect();
    $data = $_GET['upPic'];

    updatePic($dbconn, $data);

    mysqli_close($dbconn);
}

if (array_key_exists('upAbout', $_GET) == TRUE) {

    $dbconn = dbconnect();
    $data = $_GET['upAbout'];

    updateAbout($dbconn, $data);

    mysqli_close($dbconn);
}

if (array_key_exists('userPageAdmin', $_GET) == TRUE) {

    $dbconn = dbconnect();
    $data = $_GET['userPageAdmin'];

    $feed = getUserPageAdmin($dbconn, $data);

    if ($feed) {
        // loop through each record and format the json (apply any needed business logic)
        while ($row = mysqli_fetch_array($feed)) {
            $rowArray[] = json_decode($row[0]);
        }

        // Format array as json
        $myGet = json_encode($rowArray);
    }
    mysqli_close($dbconn);

}



echo $myGet;

?>
