<?php session_start() ?>
<?php

$email = $_POST["email"];
$password = $_POST["password"];
$_SESSION["email"] = $email;
$_SESSION["password"] = $password;

$host        = "host=hektor4.ttu.ee";
$port        = "port=5432";
$dbname      = "dbname=Partystarter";
$credentials = "user=t123661 password=KLRbAzIn";

$db = pg_connect( "$host $port $dbname $credentials"  );
       if(!$db){
          echo "Error : Unable to open database\n";
       }

$sql = "SELECT password FROM users WHERE e_mail = '".$email."'";
$result = pg_query($db, $sql);

if (pg_num_rows($result) > 0) {
            $url = '/view-event.php';
            echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';
} else {
   $url = '/login.html?error_code=1';
   header('Location: ' . $url);
   exit(0);
}

?>