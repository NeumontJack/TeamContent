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
<button id="probtn" onclick="unhidepro()">Update Profile Picture</button>
<input id="imgUrl" placeholder="newImageURL" hidden/>
<button id="newprobtn" onclick="upPic()" hidden>Update Pic</button>
<button id="cancelpro" onclick="cancelPro()" hidden>Cancel</button>

<h3 class="aboutMeTitle">About Me</h3>
<p id="about" class="aboutMe"></p>
<button id="aboutbtn" onclick="unhideabout()">Update About Me</button>
<textarea id="upAbout" placeholder="Update about Me" hidden></textarea>
<button id="upAboutbtn" onclick="upAbout()" hidden>Update About</button>
<button id="cancelAbout" onclick="cancelAbout()" hidden>Cancel</button>


<a href="UserLogout.php">LogOut</a>


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
        document.getElementById('probtn').hidden = false;
        document.getElementById('imgUrl').hidden = true;
        document.getElementById('newprobtn').hidden = true;
        document.getElementById('cancelpro').hidden = true;
        document.getElementById('aboutbtn').hidden = false;
        document.getElementById('upAbout').hidden = true;
        document.getElementById('upAboutbtn').hidden = true;
        document.getElementById('cancelAbout').hidden = true;
    }

    function loadComplete(evt) {
        var MyResponse;
        MyResponse = request.responseText;
        myData = JSON.parse(MyResponse);

        document.getElementById("username").innerHTML = myData[0].username;
        document.getElementById("about").innerHTML = myData[0].about;
        document.getElementById("profilepic").src = myData[0].pic;
    }

    function unhidepro() {
        document.getElementById('probtn').hidden = true;
        document.getElementById('imgUrl').hidden = false;
        document.getElementById('newprobtn').hidden = false;
        document.getElementById('cancelpro').hidden = false;
    }

    function cancelPro() {
        document.getElementById('probtn').hidden = false;
        document.getElementById('imgUrl').hidden = true;
        document.getElementById('newprobtn').hidden = true;
        document.getElementById('cancelpro').hidden = true;
    }

    function upPic() {
        var url = document.getElementById('imgUrl').value;
        var uInfo = "<?php echo $id ?>";
        uInfo = uInfo + "///" + url;
        request.open('Get', 'UQueries.php?upPic=' + uInfo)
        request.onload = loadPic;
        request.send();
    }

    function loadPic(evt) {
        loadUser();
    }

    function unhideabout() {
        var about = document.getElementById('about').innerHTML;
        document.getElementById('aboutbtn').hidden = true;
        document.getElementById('upAbout').hidden = false;
        document.getElementById('upAboutbtn').hidden = false;
        document.getElementById('cancelAbout').hidden = false;
        document.getElementById('upAbout').innerHTML = about;
        
    }

    function cancelAbout() {
        document.getElementById('aboutbtn').hidden = false;
        document.getElementById('upAbout').hidden = true;
        document.getElementById('upAboutbtn').hidden = true;
        document.getElementById('cancelAbout').hidden = true;
    }

    function upAbout() {
        var about = document.getElementById('upAbout').value;
        var uInfo = "<?php echo $id ?>";
        uInfo = uInfo + "///" + about;
        request.open('Get', 'UQueries.php?upAbout=' + uInfo)
        request.onload = loadAbout;
        request.send();
    }

    function loadAbout(evt) {
        loadUser();
    }

</script>
