<?php

include("HeaderPage.php");
include("LoggedInMenu.php");

$id = $_GET["uId"];

//$myUserInfo = explode("///", $id);

?>

<h2 id="username"></h2>

<img id="profilepic"/>

<p id="about"></p>


<script>

    var request = new XMLHttpRequest();

    window.onload = function () {
        loadUser();
    }

    function loadUser() {
        var userInfo = "<?php echo $id?>"
        request.open('Get', 'UQueries.php?userPage=' + userInfo)
        request.onload = loadComplete;
        request.send();
    }

    function loadComplete(evt) {
        var MyResponse;
        MyResponse = request.responseText;
        myData = JSON.parse(MyResponse);

        document.getElementById("username").innerHTML = myData[0].username;
        document.getElementById("about").innerHTML = myData[0].about;
        document.getElementById("profilepic").src = myData[0].pic;
    }

</script>
