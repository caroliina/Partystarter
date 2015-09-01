<?php session_start() ?>
<?php

$su_email = $_POST["signup_email"];
$su_password = $_POST["signup_password"];

$host        = "host=hektor4.ttu.ee";
$port        = "port=5432";
$dbname      = "dbname=Partystarter";
$credentials = "user=t123661 password=KLRbAzIn";

$db = pg_connect( "$host $port $dbname $credentials"  );
       if(!$db){
          echo "Error : Unable to open database\n";
       }


$sql="INSERT INTO users (e_mail, password) VALUES ('$su_email', '$su_password')";
$result = pg_query($db, $sql);
$url = '/login.html';
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';

?>