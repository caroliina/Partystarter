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

$sql="SELECT * FROM events WHERE id = '".$q."'";
$result = pg_query($db, $sql);

while($row = pg_fetch_assoc($result)) {
    
        echo ('<div class="col-sm-9 col-sm-offset-3 col-md-6 col-md-offset-2 main tab-content">
            <div id="eventCreated" >
                <div role="tabpanel" class="tab-pane fade in active" id="event">
                    <header>
                        <h1>' . $row['event_title'] . '</h1>
                    </header>
                    <div class="well row">
                        <div class="col-md-7">
                            <div class="event-block row">
                                <span class="glyphicon glyphicon-star"></span> 
                                Hosted by <b><span class="eventCreatedHost">' . $row['event_host'] . '</span></b></br>
                            Description: ' . $row['event_desc'] . '
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" readonly="readonly" class="form-control" value="http://www.partystarter.com/event1234" onClick="this.select();">
                                <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-send"></span>
                                </span>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                        </div>

                        <div class="col-md-12">
                            <div class="event-block row">
                                <div class="block-label">Date:
                                ' . $row['event_date'] . '
                                </div>
                            </div>
                            <div class="event-block row"><div class="block-label eventCreatedInvitees">');
              
                                $sql1="SELECT * FROM invitees WHERE invitee_event_id = '".$q."'";
                                $result1 = pg_query($db,$sql1);
              
                                if (pg_num_rows($result1) > 0) {
                                    echo 'Invitees: ';
                                    while($row1 = pg_fetch_assoc($result1)) {
                                        echo '<span class="label label-primary">'. $row1['invitee_email'] .'</span>';
                                    }
                                } else {
                                    echo "0 results";
                                }
              
                                echo ('</div></div>
                                <div class="event-block row">
                                <div class="block-label">Location: ' . $row['event_loc'] . '</div>
                                <!--<div id="googleMap"></div>-->
                            </div>
                            <div class="event-block row">
                                <div class="block-label eventCreatedWishlist">'); 
    
                            $sql2="SELECT * FROM gifts WHERE gift_event_id = '".$q."'";
                                $result2 = pg_query($db,$sql2);
              
                                if (pg_num_rows($result2) > 0) {
                                    echo 'Wishlist: ';
                                    while($row2 = pg_fetch_assoc($result2)) {
                                        echo '<span onclick="viewGiftInfo('. '\'' .$row2['id']. '\'' .')" class="label label-warning">'. $row2['gift_name'] .'</span>';
                                    }
                                } else {
                                    echo "0 results";
                                }
    echo ('<div id="giftView"></div>');
    
                    echo ('</div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="nav-footer">');
    
                if($row['event_host'] == $_SESSION["email"]){echo('<button class="btn btn-info right">Edit Event</button>');}
    
    echo('
                                <button id="eventCreatedBackButton" class="btn btn-warning left">Go Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>');
    
        
                                    
}

    ?>