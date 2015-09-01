<?php session_start() ?>
<?php

$link = $_POST["giftLink"];
$price = $_POST["giftPrice"];
$money = $_POST["moneyCollected"];
$buyer = $_SESSION["email"];
$event_id = $_SESSION["event_id"];
$gift_name = $_SESSION["gift_name"];
$buyer_id = $_SESSION["commenter_id"];
$comments_gift_id = $_SESSION["comments_gift_id"];

$host        = "host=hektor4.ttu.ee";
$port        = "port=5432";
$dbname      = "dbname=Partystarter";
$credentials = "user=t123661 password=KLRbAzIn";

$db = pg_connect( "$host $port $dbname $credentials"  );
       if(!$db){
          echo "Error : Unable to open database\n";
       }


$sql="UPDATE gifts SET gift_event_id = '$event_id', gift_name = '$gift_name', gift_link = '$link', gift_price = '$price', gift_money_coll = '$money', gift_buyer_id = '$buyer_id' WHERE id = '$comments_gift_id';";
$result = pg_query($db, $sql);
$url = '/view-event.php';
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';

?>