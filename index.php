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
<button id="login" onclick="loginUser()">Login</button> 

<a href="CreateUser.php">New User</a>


<script>

    

</script>



<?php

include("FooterPage.php");
?>