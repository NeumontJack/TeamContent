<?php

include("HeaderPage.php");
include("LoggedInMenu.php");
session_start();
if (!isset($_SESSION['userInfo'])) {
    $_SESSION['userInfo'] = $_GET["uId"];
}


$id = $_SESSION['userInfo'];

//$myUserInfo = explode("///", $id);

?>

<h2 id="username" class="usersName"></h2>

<img id="profilepic" class="proPic"/>
<button>Update Profile Picture</button>

<h3 class="aboutMeTitle">About Me</h3>
<p id="about" class="aboutMe"></p>
<button>Update About Me</button>


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