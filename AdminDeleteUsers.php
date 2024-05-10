<?php

include("HeaderPage.php");
include("AdminMenu.php");

?>


<div class="allusers" id="allUsers">
    

</div>

<script>

    var request = new XMLHttpRequest();

    window.onload = function () {
        loadUsers();
    }

    function loadUsers() {
        request.open('Get', 'apiJsonUserPages.php');
        request.onload = loadComplete;
        request.send();
    }

    function loadComplete(evt) {
        var MyResponse;
        var MyReturn;

        MyResponse = request.responseText;
        myData = JSON.parse(MyResponse);
        console.log(myData);
        for (index in myData) {
            MyReturn += "<div>" + myData[index].username + "</div> " +
                "<img id='profilepic' class='inlineProPic' src='" + myData[index].pic + "'/>" +
                "<div><button onclick=deleteUser(" + myData[index].id + ")>Delete</button></div>" +
                "<div><button onclick=viewUser(" + myData[index].id +")>Visit Page</button></div>";

        }
        document.getElementById("allUsers").innerHTML = MyReturn;

    }

    function deleteUser(id) {
        request.open('Get', 'UQueries.php?delId=' + id);
        request.onload = delDone;
        request.send();
    }

    function delDone(evt) {
        loadUsers();
    }

    function viewUser(id) {
        window.location.href = "AdminViewUsers.php?uId=" + id;
    }


</script>