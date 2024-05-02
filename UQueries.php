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

echo $myGet;

?>
