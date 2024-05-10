<?php

include_once "dbConnection.php";

header('Content-Type: application/json');

// Get All records
// Get the db connection
$myDbConn = dbconnect();
$myJsonResult = getAllUsers($myDbConn);

$myJSON = null;
$row = null;
$rowArray = null;


if ($myJsonResult) {
    // loop through each record and format the json (apply any needed business logic)
    while ($row = mysqli_fetch_array($myJsonResult)) {
        $rowArray[] = json_decode($row[0]);
    }

    // Format array as json
    $myJSON = json_encode($rowArray);
}

mysqli_close($myDbConn);

echo $myJSON; //return data

?>
