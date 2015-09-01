<?php session_start() ?>
<?php

$comment = $_POST["comment"];
$comments_event_id = $_SESSION["comments_event_id"];
$comments_gift_id = $_SESSION["comments_gift_id"];
$commenter_id = $_SESSION["commenter_id"];

$host        = "host=hektor4.ttu.ee";
$port        = "port=5432";
$dbname      = "dbname=Partystarter";
$credentials = "user=t123661 password=KLRbAzIn";

$db = pg_connect( "$host $port $dbname $credentials" );
if(!$db){
  echo "Error : Unable to open database\n";
}

echo ("INSERT INTO comments (comments_event_id, comments_gift_id, commenter_id, comment_txt) VALUES ('$comments_event_id', '$comments_gift_id', '$commenter_id', '$comment')");


$sql="INSERT INTO comments (comments_event_id, comments_gift_id, commenter_id, comment_txt) VALUES ('$comments_event_id', '$comments_gift_id', '$commenter_id', '$comment')";

$result = pg_query($db, $sql);

$url = '/view-event.php';
echo '<META HTTP-EQUIV=Refresh CONTENT="0; URL='.$url.'">';

?>