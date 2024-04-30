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

<script>



</script>



<?php

include("FooterPage.php");

?>