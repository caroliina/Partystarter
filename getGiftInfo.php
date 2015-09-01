<?php session_start() ?>
<?php
$q = intval($_GET['q']);

$host        = "host=hektor4.ttu.ee";
$port        = "port=5432";
$dbname      = "dbname=Partystarter";
$credentials = "user=t123661 password=KLRbAzIn";

$db = pg_connect( "$host $port $dbname $credentials"  );
if(!$db){
  echo "Error : Unable to open database\n";
}
$sql_1 = "SELECT id FROM users WHERE e_mail = '".$_SESSION["email"]."'";
$result1 = pg_query($db, $sql_1);
$row_user_id = pg_fetch_assoc($result1);
$sql="SELECT * FROM gifts WHERE id = '".$q."'";
$result = pg_query($db, $sql);

while($row = pg_fetch_assoc($result)) {
    
    $sql1="SELECT * FROM invitees WHERE id = '".$row['gift_buyer_id']."'";
    $result1 = pg_query($db, $sql1);
    
    if (pg_num_rows($result1) > 0) {
    $row1 = pg_fetch_assoc($result1);
    
        echo ('<div class="main tab-content">
            <div id="eventCreated" >
                <div role="tabpanel" class="tab-pane fade in active" id="event">
                    <header>
                        <h1>' . $row['gift_name'] . '</h1>
                    </header>
                    <div class="well row">
                    <div class="event-block row">
                        <div class="container">
                            <span class="glyphicon glyphicon-globe"> </span><a class="link" href="http://'. $row['gift_link'] .'">'. $row['gift_link'] .'</a>
                            <br>
                            <div class="block-label">Price: <span class="content">'. $row['gift_price'] .' $</span>
                            </div>
                            <div class="block-label">Money collected: <span class="content">'. $row['gift_money_coll'] .' $</span>
                            </div>
                            <div class="block-label">Bought by: <span class="content">'. $row1['invitee_name'] .'</span>
                            </div>
                        </div>
                        <br>
                        <heading>
                            <h4>There is still '); echo (($row['gift_price']) - ($row['gift_money_coll'])); echo (' $ left to be paid...</h4>
                        </heading>
                        <br>
                        <heading>
                            <h4>Comments</h4>
                        </heading>
                        <div class="container">');
                        
                        $sql2="SELECT * FROM comments WHERE comments_gift_id = '".$q."'";
                        $result2 = pg_query($db, $sql2);
                        while($row2 = pg_fetch_assoc($result2)){
                            $sql3="SELECT * FROM invitees WHERE id = '".$row2['commenter_id']."'";
                            $result3 = pg_query($db, $sql3);
                            $row3 = pg_fetch_assoc($result3);
                            echo ('<div class="block-label">'. $row3['invitee_name'] .'['. date('Y-m-d H:i:s', strtotime($row2['comment_time'])) .']:<span class="content">'. $row2['comment_txt'] .'</span></div>');
                        }
        
                        $sql4="SELECT id FROM invitees WHERE invitee_email = '".$_SESSION["email"]."'";
                        $result4 = pg_query($db, $sql4);
                        $row4 = pg_fetch_assoc($result4);
        
                        $_SESSION["comments_event_id"] = $row['gift_event_id'] ;
                        $_SESSION["comments_gift_id"] = $q;
                        $_SESSION["commenter_id"] = $row4['id']; 
        
        
                            echo ('<br>
                            <div class="block-label">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="comment">Comment:</label>
                                        <textarea class="form-control" rows="3" id="comment"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        </div>');
    } else {
        
        echo ('
        <div class="main tab-content">
            <div id="eventCreated">
                <div role="tabpanel" class="tab-pane fade in active" id="event">
                    <header>
                        <span class="rowName">'.$row['gift_name'].'</span>
                    </header>
                    <div class="well row">
                    <div class="event-block row">
                        <div class="itemNotBought">
                            <div class="iBoughtItem" data-userID='.$row_user_id['id'].'>
                                <heading>
                            <h4><span class="boughtGiftText" data-email='.$_SESSION["email"].' >Gift not bought yet...</span></h4>
                                    <div class="container">
                                        <button class="btn btn-success userBought">I bought it!</button>
                                    </div>
                                    <br>
                                </heading>
                            <br>
                        </div>
                        <heading>
                            <h4>Comments</h4>
                        </heading>
                        <div class="container">');
        
                        $_SESSION["gift_id"] = $q;
                        $_SESSION["event_id"] = $row['gift_event_id'];
                        $_SESSION["gift_name"] = $row['gift_name'];
    
                        $sql2="SELECT * FROM comments WHERE comments_gift_id = '".$q."'";
                        $result2 = pg_query($db, $sql2);
                        while($row2 = pg_fetch_assoc($result2)){
                            $sql3="SELECT * FROM invitees WHERE id = '".$row2['commenter_id']."'";
                            $result3 = pg_query($db, $sql3);
                            $row3 = pg_fetch_assoc($result3);
                            echo ('<div class="block-label">'. $row3['invitee_name'] .'['. date('Y-m-d H:i:s', strtotime($row2['comment_time'])) .']:<span class="content">'. $row2['comment_txt'] .'</span></div>');
                        }
        
                        
                        $sql4="SELECT id FROM invitees WHERE invitee_email = '".$_SESSION["email"]."'";
                        $result4 = pg_query($db, $sql4);
                        $row4 = pg_fetch_assoc($result4);
        
                        $_SESSION["comments_event_id"] = $row['gift_event_id'] ;
                        $_SESSION["comments_gift_id"] = $q;
                        $_SESSION["commenter_id"] = $row4['id'];                    
        
                            echo ('<br>
                            <div class="block-label">
                                <form action="sendComment.php" method="post" role="form">
                                    <div class="form-group">
                                        <label for="comment">Comment:</label>
                                        <textarea name="comment" class="form-control" rows="3" id="comment"></textarea>
                                        <input class="btn btn-success sendComment" type="submit" value="Send comment">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                        </div>');
        
    }
    
    
              
                                    
}

    ?>