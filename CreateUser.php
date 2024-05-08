<?php

include("HeaderPage.php");
include("Menu.php");

$PageTitle = "Create New Account";

?>

<h1 class="pageTitle"><?php echo $WebTitle . "- " . $PageTitle ?></h1>


<input id="uName" type="text" placeholder="Username" />
<input id="fname" type="text" placeholder="First Name" />
<input id="lname" type="text" placeholder="Last Name" />
<input id="email" type="text" placeholder="Email" />
<input id="pass" type="text" placeholder="Password" />
<button id="credSubmit" onclick="createUser()">Create Account</button>
<p id="errorMsg"></p>

<script>

    var request = new XMLHttpRequest();
    var uLog;
    window.onload = function () {
        alert("On Create Page");
    }

    function createUser() {
        var userN = document.getElementById("uName").value;
        var fName = document.getElementById("fname").value;
        var lname = document.getElementById("lname").value;
        var email = document.getElementById("email").value;
        var pass = document.getElementById("pass").value;
        var uInfo = fName + "///" + lname + "///" + pass + "///" + email + "///" + userN;
        uLog = userN + "///" + pass;
        load(uInfo);

    }

    function load(uInfo) {
        request.open('Get', 'UQueries.php?cUser=' + uInfo)
        request.onload = loadDone;
        request.send();
    }

    function createUserPage(userInfo) {
        request.open('Get', 'UQueries.php?cInfo=' + userInfo);
        request.send();
    }

    function loadL(loginInfo) {
        console.log(loginInfo)
        request.open('Get', 'UQueries.php?loginI=' + loginInfo)
        request.onload = loadComplete
        request.send()
    }

    function loadDone(evt) {
        loadL(uLog);
    }

    function loadComplete(evt) {
        var MyResponse;

        MyResponse = request.responseText;
        var arrayThing = MyResponse.split("{")
        console.log(MyResponse)
        console.log(arrayThing)
       /* console.log(isJSON(MyResponse))*/
        myData = JSON.parse(MyResponse);

        var id = myData[0].userid;
        var username = myData[0].username;
        console.log(id)
        userInfo = id + "///" + username;

        if (arrayThing.length < 2) {
            document.getElementById("errorMsg").innerHTML = "Incorrect Username or Password"
        } else {
            createUserPage(userInfo);
            window.location.href = "UserPage.php?uId=" + userInfo;
        }
    }


</script>



<?php

include("FooterPage.php");

?>