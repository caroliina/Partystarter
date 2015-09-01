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
       $host        = "host=imbi.ld.ttu.ee";
       $port        = "port=5432";
       $dbname      = "dbname=Cat";
       $credentials = "user=t123661 password=vZeGVZJD";

       $db = pg_connect( "$host $port $dbname $credentials"  );
       if(!$db){
          echo "Error : Unable to open database\n";
       } else {
          echo "Opened database successfully\n";
       }
    ?>
    
    <!-- Navigation bar -->
    <nav class="navbar navbar-trans navbar-fixed-top" ng-controller="navbarController">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.html"><i class="glyphicon glyphicon-gift"></i> Partystarter</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <p class="navbar-text"><i class="glyphicon glyphicon-user"></i> Signed in as {{firstname}} {{lastname}}</p>
                <a href="login.html" class="navbar-text"><i class="glyphicon glyphicon-log-out"></i> Log out</a>
            </ul>
        </div>
    </nav>
    <!-- END Navigation bar -->

    <div class="container-fluid">
        <div class="row" role="tabpanel">
            <!-- Sidebar -->
            <div class="col-sm-3 col-md-2 sidebar" ng-controller="sidebarController">
                <ul class="nav nav-sidebar menu tablist">
                    <li role="presentation" class="active">
                        <a role="tab" data-toggle="tab" href="#upcoming" aria-controls="upcoming">{{tab1}} 
                                <span class="badge">{{notifications}}</span>
                            </a>
                    </li>
                    <li role="presentation">
                        <a role="tab" data-toggle="tab" href="#birthdays" aria-controls="birthdays">{{tab2}}
                            </a>
                    </li>
                    <li><a href="#">{{tab3}}</a>
                    </li>
                </ul>
            </div>
            <!-- END Sidebar -->

            <!-- Content -->
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="upcoming" ng-controller="allEventsController">
                    <header>
                        <h1>{{upcoming}}</h1>
                    </header>
                    <div ng-repeat="event in upcomingEvents">
                        <div class="well row">
                            <div class="col-md-9">
                                <div class="event-title row">
                                    <div>{{event.title}}
                                        <span class="subtext-1">({{event.date}})</span>
                                    </div>
                                </div>
                                <div class="event-owner row">
                                    <div>by {{event.host}}</div>
                                </div>
                                <div class="event-desc row">
                                    {{event.description}}
                                </div>
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
                                <div class="nav-footer">
                                    <button onclick="window.location = 'view-event.html';" class="btn btn-info right">View event</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <header>
                        <h1>{{hosted}}</h1>
                    </header>
                    <div ng-repeat="event in hostedEvents">
                        <div class="well row">
                            <div class="col-md-9">
                                <div class="event-title row">
                                    <div>{{event.title}}
                                        <span class="subtext-1">({{event.date}})</span>
                                    </div>
                                </div>
                                <div class="event-owner row">
                                    <div>by {{event.host}}</div>
                                </div>
                                <div class="event-desc row">
                                    {{event.description}}
                                </div>
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
                                <div class="nav-footer">
                                    <button class="btn btn-warning left">Edit event</button>
                                    <button onclick="window.location = 'view-event.html';" class="btn btn-info right">View event</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="birthdays">
                    <header>
                        <h1>Plan new event</h1>
                    </header>
                    <div class="well row">
                        <div class="row">
                            <div class="container col-md-8">
                                <form role="form">
                                    <div class="form-group">
                                        <label for="usr">Event name: </label>
                                        <input type="text" class="form-control" id="usr">
                                    </div>
                                    <div class="form-group">
                                        <label for="date">Event date: </label>
                                        <input type="date" class="form-control" id="date">
                                    </div>
                                    <div class="form-group">
                                        <label for="loc">Event location: </label>
                                        <input type="text" class="form-control" id="loc">
                                    </div>
                                    <div class="form-group">
                                        <label for="mail">E-mails of invitees:
                                        </label>
                                        <span title="Write an e-mail address and press enter" class="glyphicon glyphicon-question-sign"></span>
                                        <br>
                                        <input type="text" class="form-control" id="mail" data-role="tagsinput">
                                    </div>
                                    <div class="form-group">
                                        <label for="sum">Event summary:</label>
                                        <textarea class="form-control" rows="5" id="sum"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="gifts">Wishlist: </label>
                                        <span title="Write a gift name and press enter" class="glyphicon glyphicon-question-sign"></span>
                                        <br>
                                        <input type="text" class="form-control" id="gifts" data-role="tagsinput">
                                    </div>
                                </form>
                            </div>
                            <div class="container col-md-4 errors">
                                <div class="form-group error">
                                    <span id="event-name">Event name: </span>
                                </div>
                                <div class="form-group error">
                                    <span id="event-date">Event date: </span>
                                </div>
                                <div class="form-group error">
                                    <span id="event-location">Event location: </span>
                                </div>
                                <div class="form-group error">
                                    <span id="event-invitees">Event invitees: </span>
                                </div>
                                <div class="form-group error sum">
                                    <span id="event-summary">Event summary: </span>
                                </div>
                                <div class="form-group error">
                                    <span id="event-wishlist">Event wishlist: </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="nav-footer">
                                <button onclick="window.location = 'view-event.html';" class="btn btn-info right">Create event</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Content -->

        </div>
    </div>

    <!-- Script references -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
    <script src="static/js/ui-bootstrap-tpls-0.12.1.min.js"></script>
    <script src="static/js/bootstrap.min.js"></script>
    <script src="static/js/angular.js"></script>
    <script src="static/js/scripts.js"></script>
    <!-- END Script references -->
</body>

</html>