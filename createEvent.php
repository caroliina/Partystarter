<?php session_start() ?>
<?php

$event_name = $_POST["eventName"];
$event_date = $_POST["eventDate"];
$event_loc = $_POST["eventLocation"];
$event_desc = $_POST["description"];
$event_inviteesCSV = $_POST["invitees"];
$event_wishlistCSV = $_POST["wishlist"];
$event_invitees = explode(',', $event_inviteesCSV);
$event_wishlist = explode(',', $event_wishlistCSV);
$signed_in = $_SESSION["email"];

$host        = "host=hektor4.ttu.ee";
$port        = "port=5432";
$dbname      = "dbname=Partystarter";
$credentials = "user=t123661 password=KLRbAzIn";

$db = pg_connect( "$host $port $dbname $credentials" );
if(!$db){
  echo "Error : Unable to open database\n";
}

$sql="INSERT INTO events (event_title, event_host, event_date, event_desc, event_loc) VALUES ('$event_name', '$signed_in', '$event_date', '$event_desc', '$event_loc')";
$result = pg_query($db, $sql);

$sql1="SELECT id FROM events WHERE event_title = '$event_name'";
$result1 = pg_query($db, $sql1);
$row1 = pg_fetch_assoc($result1);
$eventID = $row1['id'];

$inviteeslen = count($event_invitees);
for($x = 0; $x < $inviteeslen; $x++) {
    echo ($event_invitees[$x]);
    $sql2="INSERT INTO invitees (invitee_event_id, invitee_email, invitee_name) VALUES ('$eventID', '$event_invitees[$x]', '$event_invitees[$x]')";
    $result2 = pg_query($db, $sql2);
}


$wishlistlen = count($event_wishlist);
for($x = 0; $x < $wishlistlen; $x++) {
    echo ($event_wishlist[$x]);
    $sql3="INSERT INTO gifts (gift_event_id, gift_name) VALUES ('$eventID', '$event_wishlist[$x]')";
    $result3 = pg_query($db, $sql3);
}

$url = '/view-event.php';
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';

?>
