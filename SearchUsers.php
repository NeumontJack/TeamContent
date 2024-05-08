<?php
include("HeaderPage.php");
include("LoggedInMenu.php");

?>

<h2>Find People</h2>
<input id="search" placeholder="Username"/>
<button onclick="searchUsers()">Search</button>


<script>

    window.onload = function () {

    }

    function searchUsers() {
        var searchEntry = document.getElementById("search").value;
        load(searchEntry);
    }

    function load(search) {
        request.open('Get', 'UQueries.php?search=' + search)
        request.onload = loadDone;
        request.send();
    }

    function loadDone(evt) {
        var MyResponse;
    }

</script>
