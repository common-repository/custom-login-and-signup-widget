<?php
if(function_exists ('home_url')) {
if(isset($_GET['editbn1']) && $_GET['editbn1']=="yes") {
edit_sender_email1();
}
else if(isset($_GET['editbn']) && $_GET['editbn']=="yes") {
edit_sender_email();
}
echo'
<h2>Sender'."'".'s Name</h2>
<form action="options-general.php?page=custom-login-and-signup-widget&editbn1=yes" method="post">
<textarea name="text">'; @include('content/sn.php'); echo $bwbn.'</textarea>
<input type="submit" name="submit" value="Submit" /></form>
';
echo'
<h2>Sender'."'".'s Email Address</h2>
<form action="options-general.php?page=custom-login-and-signup-widget&editbn=yes" method="post">
<textarea name="text">'; @include('content/sm.php'); echo $sender.'</textarea>
<input type="submit" name="submit" value="Submit" /></form>
';
}
else {
echo 'UNATHORIZED ACCESS... YOU BETTER GET YOUR ASS OUT OF HERE>>>>>> :) ok baby';
}
?>