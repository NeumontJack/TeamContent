<?php

include("HeaderPage.php");
include("Menu.php");

$PageTitle = "Home Page";

echo 'Hello World!';

echo 'Jack';

?>

<h1 class="pageTitle"><?php echo $WebTitle . "- " . $PageTitle?></h1>

<h3 >Login</h3>


<input id="uName" type="text" placeholder="Username" />
<input id="pass" type="text" placeholder="Password" />
<p id="errorMsg"></p>
<button id="login" onclick="loginUser()">Login</button> 


<a href="CreateUser.php">New User</a>


<script>
    var request = new XMLHttpRequest();

    window.onload = function () {
        alert("On Login");
    }

    function loginUser() {
        var username = document.getElementById("uName").value;
        var password = document.getElementById("pass").value;
        console.log(username + ":" + password)
        var loginInfo = username + "///" + password;
        load(loginInfo)
    }

    function load(loginInfo) {
        console.log(loginInfo)
        request.open('Get', 'UQueries.php?loginI=' + loginInfo)
        request.onload = loadComplete
        request.send()
    }

    function isJSON(text) {
        //if (typeof text !== "string") {
        //    return false;
        //}
        //try {
        //    JSON.parse(text);
        //    return true;
        //} catch (error) {
        //    return false;
        //}
        //try {
        //    JSON.stringify(JSON.parse(str));
        //    return true;
        //} catch (e) {
        //    return false;
        //}
    }

    function loadComplete(evt) {
        var MyResponse;

        MyResponse = request.responseText;
        var arrayThing = MyResponse.split("{")
        console.log(MyResponse)
        console.log(arrayThing)
       /* console.log(isJSON(MyResponse))*/

        if (arrayThing.length < 2) {
            document.getElementById("errorMsg").innerHTML = "Incorrect Username or Password"
        } else {
            window.open("AboutPage.php")
        }

    }

    //function loadComplete(evt) {

    //    document.getElementById("eventAdd").innerHTML = "Added Record";
    //    loadTable();
    //    var MyResponse;

    //    MyResponse = request.responseText;

</script>



<?php

include("FooterPage.php");
?>