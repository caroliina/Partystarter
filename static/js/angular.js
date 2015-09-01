var app = angular.module('partystarter', []);

app.controller('allEventsController', function ($scope) {
    $scope.upcoming = 'My upcoming events';
    $scope.hosted = 'My hosted events';

    $scope.upcomingEvents = [
        {
            "title": "Peter's birthday",
            "date": "05.06.2015",
            "host": "Tom Grass",
            "description": "Come and celebrate one awesome . . . !",


        },
];

    $scope.hostedEvents = [
        {
            "title": "Peter's birthday",
            "date": "05.06.2015",
            "host": "Mark Otto",
            "description": "Come and celebrate one awesome . . . !",


        }
];
});

app.controller('navbarController', function ($scope) {
    $scope.firstname = "Mark";
    $scope.lastname = "Otto";
});

app.controller('eventCreatedHost', function ($scope) {
    $scope.firstname = "Mark";
    $scope.lastname = "Otto";
});

app.controller('sidebarController', function ($scope) {
    $scope.tab1 = "Events";
    $scope.tab2 = "Plan new event";
    $scope.tab3 = "My settings";
    $scope.notifications = "2";
});

app.controller('viewEventController', function ($scope) {
    $scope.title = "Peter's birthday";
    $scope.host = "Thomas Grass";
    $scope.description = "Come and celebrate one awesome birthday party!";
    $scope.date = "05.03.2015"

    $scope.inviteesAccepted = [
        {
            "email": "maria@gmail.com",


        },
        {
            "email": "alex@gmail.com",


        },
        {
            "email": "regina@gmail.com"


        },
];
    $scope.inviteesPassive = [
        {
            "email": "tom@gmail.com",


        },
];

    $scope.finishedGifts = [
        {
            "title": "Magic Mouse",


        },
];

    $scope.boughtGifts = [
        {
            "title": "iPhone",


        },
];

    $scope.gifts = [
        {
            "title": "MacBook Air",


        },
        {
            "title": "iPad",

        },
        {
            "title": "iPod",


        },
        {
            "title": "iMac",


        },
        {
            "title": "iPod Nano",


        },
];
});