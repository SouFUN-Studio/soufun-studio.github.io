<?php
$servername = "host_name";
$dbname = "database_name";
$username = "username";
$password = "password";
$playername = $_POST["playernamePos"];
$score =$_POST["scorePos"];
$db = mysqli_connect($servername, $username,$password, $dbname);
$update = "UPDATE data SET score='$score' WHERE name='$playername'";
$result = mysqli_query($db,$update);

 ?>
