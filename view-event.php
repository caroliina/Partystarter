<?php session_start() ?>
<!DOCTYPE html>
<html lang="en" ng-app="partystarter">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Partystarter</title>
    <meta name="generator" content="Bootply" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- Stylesheets -->
    <link href="static/css/bootstrap.min.css" rel="stylesheet">
    <link href="static/css/styles.css" rel="stylesheet">
    <link href="static/css/my-styles.css" rel="stylesheet">
    <!-- END Stylesheets -->

</head>

<body>
    
    <?php
       $host        = "host=hektor4.ttu.ee";
       $port        = "port=5432";
       $dbname      = "dbname=Partystarter";
       $credentials = "user=t123661 password=KLRbAzIn ";

       $db = pg_connect( "$host $port $dbname $credentials"  );
       if(!$db){
          echo "Error : Unable to open database\n";
       }
    ?>
    
    <!-- Navigation bar -->
    <?php
    echo
    ('<nav class="navbar navbar-trans navbar-fixed-top" ng-controller="navbarController">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="view-event.php"><i class="glyphicon glyphicon-gift"></i> Partystarter</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <p class="navbar-text"><i class="glyphicon glyphicon-user"></i> Signed in as ' . $_SESSION["email"] . '</p>
                <a href="login.html" class="navbar-text"><i class="glyphicon glyphicon-log-out"></i> Log out</a>
            </ul>
        </div>
    </nav>');
    ?>
    <!-- END Navigation bar -->

    <div class="container-fluid">
        <div class="row" role="tabpanel">

            <!-- Sidebar -->
            <div class="col-sm-3 col-md-2 sidebar" ng-controller="sidebarController">
                <ul class="nav nav-sidebar menu tablist">
                    <li class="active">
                        <a id="eventsTab">{{tab1}} 
                                <span class="badge"></span>
                            </a>
                    </li>
                    <li role="presentation">
                        <a role="tab" data-toggle="tab" href="#birthdays" aria-controls="birthdays" id="planNewEventTab">{{tab2}}
                            </a>
                    </li>
                    </li>
                </ul>
            </div>
            <!-- END Sidebar -->
        
            <!-- Content -->
            <div id="eventTabContent" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="upcoming" ng-controller="allEventsController">
                    <header>
                        <h1>{{upcoming}}</h1>
                    </header>
                    
                    <?php
                        $sql1 = "SELECT invitee_event_id FROM invitees WHERE invitee_email = '". $_SESSION['email'] . "'";
                        $result1 = pg_query($db, $sql1);
                        $row1 = pg_fetch_assoc($result1);

                        $sql = "SELECT id, event_title, event_host, event_date, event_desc FROM events WHERE event_host != '". $_SESSION['email'] . "' AND id = '". $row1['invitee_event_id'] ."'";
                        $result = pg_query($db, $sql);

                        if (pg_num_rows($result) > 0) {
                            while($row = pg_fetch_assoc($result)) {
                    
                         echo ('<div class="well row">
                            <div class="col-md-9">
                                <div class="event-title row">
                                    <div>' . $row["event_title"] .
                                        '<span class="subtext-1">' . ' (' . $row["event_date"] . ')' .
                                        '</span>
                                    </div>
                                </div>
                                <div class="event-owner row">
                                    <div>by ' . $row["event_host"] .
                                    '</div>
                                </div>
                                <div class="event-desc row">' . $row["event_desc"] .
                                '</div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" readonly="readonly" class="form-control" value="http://www.partystarter.com/event1234" onClick="this.select();">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-send"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <div class="nav-footer">');
                                echo ('<button class="btn btn-info right" onclick="viewCreatedEvent('. '\'' .$row['id']. '\'' .')">View event</button></div></div></div>');
                        
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                    
                    

                    <br>
                    <header>
                        <h1>My hosted events</h1>
                    </header>
                     <div id="myHostedEvents">
                        <div class="hostedEvent" ng-repeat="event in hostedEvents">
                            
                            <?php
                        $sql = "SELECT id, event_title, event_host, event_date, event_desc FROM events WHERE event_host = '". $_SESSION['email'] ."'";
                        $result = pg_query($db, $sql);

                        if (pg_num_rows($result) > 0) {
                            while($row = pg_fetch_assoc($result)) {
                    
                         echo ('<div class="well row">
                            <div class="col-md-9">
                                <div class="event-title row">
                                    <div>' . $row["event_title"] .
                                        '<span class="subtext-1">' . ' (' . $row["event_date"] . ')' .
                                        '</span>
                                    </div>
                                </div>
                                <div class="event-owner row">
                                    <div>by ' . $row["event_host"] .
                                    '</div>
                                </div>
                                <div class="event-desc row">' . $row["event_desc"] .
                                '</div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <input type="text" readonly="readonly" class="form-control" value="http://www.partystarter.com/event1234" onClick="this.select();">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-send"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <div class="nav-footer">');
                                echo ('<button class="btn btn-info right" onclick="viewCreatedEvent('. '\'' .$row['id']. '\'' .')">View event</button></div></div></div>');
                        
                            }
                        } else {
                            echo "0 results";
                        }
                    ?>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Content -->
        
        <div id="txtHint"></div>
        
        <div id="eventTabContent" class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main tab-content">
            <div id="createNewEvent">
                <div role="tabpanel" class="tab-pane fade" id="birthdays">
                    <header>
                        <h1>Plan new event</h1>
                    </header>
                    <div class="well row">
                        <div class="row">
                            <div class="container col-md-12">
                                <form role="form" id="createEventForm" action="createEvent.php" method="post">
                                    <div class="form-group">
                                        <label for="usr">Event name: </label>
                                        <input id="createEventName" name="eventName" type="text" class="form-control" id="usr">
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Event date: </label>
                                <input id="createEventDate" type="date" name="eventDate" placeholder="yyyy-mm-dd" class="form-control" id="date">
                                    </div>
                                    <div class="form-group">
                                        <label for="loc">Event location: </label>
                                        <input id="createEventLocation" type="text" name="eventLocation" class="form-control" id="loc">
                                    </div>
                                    <div class="form-group">
                                        <label for="mail">E-mails of invitees:
                                        </label>
                                        <span title="Write an e-mail address and press enter" class="glyphicon glyphicon-question-sign"></span>
                                        <br>
                                        <input id="createEventInvitees" name="invitees" type="text" class="form-control mail" data-role="tagsinput">
                                    </div>
                                    <div class="form-group">
                                        <label for="sum">Event Description:</label>
                                        <textarea id="createEventDescription" name="description" class="form-control" rows="5"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="gifts">Wishlist: </label>
                                        <span title="Write a gift name and press enter" class="glyphicon glyphicon-question-sign"></span>
                                        <br>
                                        <input id="createEventWishlist" type="text" name="wishlist" class="form-control" id="gifts" data-role="tagsinput">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="nav-footer">
                                <div id='event_error' class='login_error plan_new_event_error'></div>
                                <button id="createEvent" class="btn btn-info right">Create event</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- END Content -->

        </div>
    </div>

    <!-- Modals -->
    <div class="modal fade" id="boughtGiftModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">iPhone</h4>
                </div>
                <div class="modal-body">
                    <div class="event-block row">
                        <div class="container">
                            <span class="glyphicon glyphicon-globe"> </span><a class="link" href="http://www.apple.com">www.apple.com</a>
                            <br>
                            <div class="block-label">Price: <span class="content">50 $</span>
                            </div>
                            <div class="block-label">Money collected: <span class="content">25 $</span>
                            </div>
                            <div class="block-label">Bought by: <span class="content">Tom Ford</span>
                            </div>
                        </div>
                        <br>
                        <heading>
                            <h4>There is still 50% left to be paid...</h4>
                        </heading>
                        <br>
                        <heading>
                            <h4>Comments</h4>
                        </heading>
                        <div class="container">
                            <div class="block-label">
                                Tom Ford [20.02.2015 14:00]: <span class="content">Found a new link and bought it</span>
                            </div>
                            <div class="block-label">
                                Maria Waters [20.02.2015 14:00]: <span class="content">Okay! :)</span>
                            </div>
                            <br>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="giftModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content notscrollable">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">MacBook Air</h4>
                </div>
                <div class="modal-body">
                    <div class="event-block row">
                        <div class='iBoughtItem'>
                            <heading>
                                <h4>Gift not bought yet...</h4>
                                <div class="container">
                                    <button class="btn btn-success">I bought it!</button>
                                </div>
                                <br>
                            </heading>
                        </div>
                        <br>
                        <heading>
                            <h4>Comments</h4>
                        </heading>
                        <div class="container">
                            <div class="commentSection">
                                <div class="block-label">
                                    Tom Ford [3/15/2015, 4:10:10 PM]: <span class="content">Found a new link and bought it</span>
                                </div>
                                <div class="block-label">
                                    Maria Waters [3/19/2015, 2:48:16 PM]: <span class="content">Okay! :)</span>
                                </div>
                            </div>
                                <br>
                                <div class="block-label">
                                    <form role="form">
                                        <div class="form-group">
                                            <label for="comment">Comment:</label>
                                            <textarea class="form-control eventComment" rows="3"></textarea>
                                        </div>
                                    </form>
                                    <button id="eventCommentSubmit" type="button" class="btn btn-primary">Send</button>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="finishedGiftModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Magic Mouse</h4>
                </div>
                <div class="modal-body">
                    <div class="event-block row">
                        <div class="container">
                            <span class="glyphicon glyphicon-globe"> </span><a class="link" href="http://www.apple.com">www.apple.com</a>
                            <br>
                            <div class="block-label">Price: <span class="content">30 $</span>
                            </div>
                            <div class="block-label">Money collected: <span class="content">30 $</span>
                            </div>
                            <div class="block-label">Bought by: <span class="content">Maria Waters</span>
                            </div>
                        </div>
                        <br>
                        <heading>
                            <h4>Everything is finished with this gift!</h4>
                        </heading>
                        <br>
                        <heading>
                            <h4>Comments</h4>
                        </heading>
                        <div class="container">
                            <div class="block-label">
                                Tom Ford [20.02.2015 14:00]: <span class="content">Found a new link and bought it</span>
                            </div>
                            <div class="block-label">
                                Maria Waters [20.02.2015 14:00]: <span class="content">Okay! :)</span>
                            </div>
                            <br>
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modals -->

    <!-- Script references -->
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="static/js/ui-bootstrap-tpls-0.12.1.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
    <script src="static/js/angular.js"></script>
    <script src="static/js/scripts.js"></script>
    <!-- END Script references -->
</body>

</html>