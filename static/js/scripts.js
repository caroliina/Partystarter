function installClickHandlers() {
    /* activate scrollspy menu */
    myHostedEventsCount = 0;
    $('body').scrollspy({
        target: '#navbar-collapsible',
        offset: 50
    });

    $('.menu li a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('#email, #password, #name, #password1, #password2, #createEventName, #createEventDate, #createEventLocation, #createEventInvitees, #createEventDescription, #createEventWishlist, #createNewEvent').click(function () {
        $('.input-group').removeClass('error_area');
        $('#createEventInvitees').siblings('.bootstrap-tagsinput').removeClass('error_area');
        $(this).removeClass('error_area');
        $('#errorDiv').hide();
        $('#event_error').hide();
        $('#createEventInvitees').siblings('.error_area').removeClass('error_area');
        $('#createEventWishlist').siblings('.error_area').removeClass('error_area');
    });

    $(".container-fluid").hide(0).fadeIn(1000);

    /* smooth scrolling sections */
    $('a[href*=#]:not([href=#])').click(function () {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: target.offset().top - 50
                }, 1000);
                return false;
            }
        }
    });

    $('#eventsTab').click(function () {
        $('#planNewEventTab').parents('li').removeClass('active')
        $('#eventsTab').parents('li').addClass('active');
        installTabHandlers();
    });

    $('#planNewEventTab').click(function () {
        deleteCreateEventInputs();
        deleteCreatedEventData();
        $('#eventsTab').parents('li').removeClass('active');
        $('#planNewEventTab').parents('li').addClass('active')
        installTabHandlers();
    });

    $('#createEvent').click(function (e) {
        var error_txt = checkInputForErrors();

        if (error_txt.length !== 0) {
            $('#event_error').text(error_txt).show();
            e.preventDefault();
            return false;
        } else {
            $('#createEventForm').submit();
            var createEventName = $('#createEventName').val();
            var createEventDate = $('#createEventDate').val();
            var createEventLocation = $('#createEventLocation').val();
            var createEventInvitees = $('#createEventInvitees').val();
            var createEventDescription = $('#createEventDescription').val();
            var createEventWishlist = $('#createEventWishlist').val();
            $('#createNewEvent').hide();
            $('#eventCreated').show();
            $('.eventCreatedTitle').text(createEventName);
            $('.eventCreatedDate').text(createEventDate);
            $('.createdEventLocation').text(createEventLocation);
            $('.eventCreatedInvitees').append(_getEventCreatedInvitees(createEventInvitees));
            $('.eventCreatedDescription').text(createEventDescription);
            $('.eventCreatedWishlist').append(_getEventCreatedWishlist(createEventWishlist));
            deleteCreateEventInputs();
            hideBothTabsContent();
            myHostedEventsCount++;
            $('.hostedEventTitle').text(createEventName);
            $('.hostedEventDate').text(createEventDate);
            $('.hostedEventDescription').text(createEventDescription);
        }
    });

    $('.btn-success').click(function () {
        $('.btn-success').parents('.iBoughtItem').html(_getItemBoughtHTML());
        $('.giftBoughtBy').text($('.eventCreatedHost').text());
        $('#editGiftBoughtData').hide();
        $('#contibuteGiftBoughtData').hide();
        installGiftBoughtByHandlers();
        installContirubuteGiftBoughtDataHandlers();
        installEditGiftBoughtDataHandlers();
    });

    $('.viewCreatedEvent').click(function () {
        hideBothTabsContent();
        $('#eventCreated').show();
        checkIfNeededToShowDemoEvent();
    });

    installKeyUpEvents();
    installTabHandlers();
    installEventCommentSubmitHandlers();
}

function viewCreatedEvent(str) {

    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                $('#eventCreatedBackButton').click(function () {
                    $('#planNewEventTab').parents('li').removeClass('active');
                    $('#eventsTab').parents('li').addClass('active');
                    installTabHandlers();
                });
            }
        }
        xmlhttp.open("GET", "getEventData.php?q=" + str, true);
        xmlhttp.send();
    }

    hideBothTabsContent();
    $('#eventCreated').show();
    checkIfNeededToShowDemoEvent();
}

function viewGiftInfo(str) {

    if (str == "") {
        document.getElementById("giftView").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("giftView").innerHTML = xmlhttp.responseText;
                $('.userBought').on('click', function () {
                    var userID = $('.iBoughtItem').data('userid');
                    var email = $('.boughtGiftText').data('email');
                    $('.iBoughtItem').html(_getItemBoughtHTML());
                    installEditGiftBoughtDataHandlers();
                    installContirubuteGiftBoughtDataHandlers();
                    installGiftBoughtByHandlers(email);
                    $('#contibuteGiftBoughtData').hide();
                    installErrorRemoveHandlers();
                    $('.giftBoughtBy').text(email);
                    //$('.boughtGiftText').text('Bought by ' + email);
                    //$('.userBought').slideUp();
                });
                $('.sendComment').on('click', function () {
                    console.error("got click");
                });
            }
        }
        xmlhttp.open("GET", "getGiftInfo.php?q=" + str, true);
        xmlhttp.send();
    }

    hideBothTabsContent();
    $('#eventCreated').show();
    //checkIfNeededToShowDemoEvent();
}

function installEventCommentSubmitHandlers() {
    $('#eventCommentSubmit').click(function () {
        if ($('.eventComment').val().length !== 0) {
            $('.commentSection').append(generateEventCommentMessage());
            $('.eventComment').val('');
        }
    });
}

function generateEventCommentMessage() {
    var dateNow = new Date();
    var comment = $('.eventComment').val();
    return '<div class="block-label">' +
        $('.eventCreatedHost').text() + ' [' + dateNow.toLocaleString() + ']: ' +
        '<span class="content">' + comment + '</span>' +
        '</div>';
}

function checkIfNeededToShowDemoEvent() {
    if ($('.eventCreatedTitle').text().length === 0) {
        $('.eventCreatedTitle').text('Peter\'s birthday');
    }
    if ($('.eventCreatedDate').text().length === 0) {
        $('.eventCreatedDate').text('05/06/2015');
    }
    if ($('.createdEventLocation').text().length === 0) {
        $('.createdEventLocation').text('Peter\'s house');
    }
    if ($('.eventCreatedInvitees').text().length <= 10) {
        $('.eventCreatedInvitees').append(_getEventCreatedInvitees('tom@gmail.com,regina@gmail.com'));
    }
    if ($('.eventCreatedDescription').text().length === 0) {
        $('.eventCreatedDescription').text('Come and celebrate one awesome birthday party!');
    }
    if ($('.eventCreatedWishlist').text().length <= 10) {
        $('.eventCreatedWishlist').append(_getEventCreatedWishlist('Macbook air, Ipod nano, Iphone 5, Iphone 4'));
    }
}

function installEditGiftBoughtDataHandlers() {
    $('#editGiftBoughtData').click(function () {
        $('#editGiftBoughtData').hide();
        $('#contibuteGiftBoughtData').hide();
        $('#saveGiftBoughtData').show();
        $('.eventGiftBoughtLink').hide();
        $('.eventGiftBoughtPrice').hide();
        $('.eventGiftBoughtMoneyCollected').hide();
        $('.eventGiftBoughtLinkInput').show();
        $('.eventGiftBoughtPriceInput').show();
        $('.eventGiftBoughtMoneyCollectedInput').hide();
    });
}

function installContirubuteGiftBoughtDataHandlers() {
    $('#contibuteGiftBoughtData').click(function () {
        $('.eventGiftBoughtMoneyCollected').hide();
        $('.eventGiftBoughtMoneyCollectedInput').show();
        $('#saveGiftBoughtData').show();
        $('#editGiftBoughtData').hide();
        $('#contibuteGiftBoughtData').hide();
    });

}

function installGiftBoughtByHandlers(email) {
    $('#saveGiftBoughtData').click(function () {
        var error_txt = '';
        var link = $('.eventGiftBoughtLinkInput').val();
        var price = $('.eventGiftBoughtPriceInput').val();
        var collected = $('.eventGiftBoughtMoneyCollectedInput').val();
        error_txt = validateGiftBought(link, price, collected);
        if (error_txt.length !== 0) {
            if (error_txt.indexOf("invalid") !== -1) {
                $('.eventGiftBoughtLinkInput').addClass('error_area');
            } else if (error_txt.indexOf("Price") !== -1) {
                $('.eventGiftBoughtPriceInput').addClass('error_area');
            } else if (error_txt.indexOf("Collected") !== -1) {
                $('.eventGiftBoughtMoneyCollectedInput').addClass('error_area');
            }
            $('#saveGiftBoughtData').css('background-color', 'red');
            return false;
        }
        $('.eventGiftBoughtLink').text($('.eventGiftBoughtLinkInput').val()).show();
        $('.eventGiftBoughtPrice').text($('.eventGiftBoughtPriceInput').val()).show();
        $('.eventGiftBoughtMoneyCollected').text($('.eventGiftBoughtMoneyCollectedInput').val() + ' / ' +
            $('.eventGiftBoughtPriceInput').val()).show();
        $('.eventGiftBoughtLinkInput').hide();
        $('.eventGiftBoughtPriceInput').hide();
        $('.eventGiftBoughtMoneyCollectedInput').hide();
        $('#saveGiftBoughtData').hide();
        $('#editGiftBoughtData').show();
        $('#contibuteGiftBoughtData').show();
    });
}

function installErrorRemoveHandlers() {
    $('.eventGiftBoughtLinkInput, .eventGiftBoughtPriceInput, .eventGiftBoughtMoneyCollectedInput').click(function () {
        $('#saveGiftBoughtData').css('background-color', '#47a447');
        $('.eventGiftBoughtLinkInput').removeClass('error_area');
        $('.eventGiftBoughtPriceInput').removeClass('error_area');
        $('.eventGiftBoughtMoneyCollectedInput').removeClass('error_area');
    });
}

function validateGiftBought(link, price, collected) {
    var error_txt = '';
    if (link.length === 0) {
        error_txt = 'Url is invalid';
    } else if (price.length === 0) {
        error_txt = 'Price must be number';
    } else if (collected.length === 0) {
        error_txt = 'Collected money must be number';
    }
    return error_txt;
}

function hideBothTabsContent() {
    $('#createNewEvent').hide();
    $('#eventTabContent').hide();
}

function installTabHandlers() {
    var isEventsTabOpen = $('#eventsTab').parents('li').hasClass('active');
    var isPlanNewEventTabOpen = $('#planNewEventTab').parents('li').hasClass('active')
    if (isEventsTabOpen) {
        showEventsTabContent();
    } else if (isPlanNewEventTabOpen) {
        showPlanNewEventTabContent();
    }
}

function showEventsTabContent() {
    $('#createNewEvent').hide();
    $('#eventTabContent').show();
    $('#eventCreated').hide();
    /*if(myHostedEventsCount === 0) {
        $('#hostedEventsText').text('No events hosted yet');
        $('#myHostedEvents').hide();
    } else if( myHostedEventsCount !== 0) {
        $('#hostedEventsText').text('My hosted events ('+myHostedEventsCount+')');
        $('#myHostedEvents').show();
    }*/
}

function showPlanNewEventTabContent() {
    $('#eventTabContent').hide();
    $('#eventCreated').hide();
    $('#createNewEvent').show();
}

function installKeyUpEvents() {
    $(document).keyup(function (e) {
        if (e.keyCode === 9) {
            var elem_id = document.activeElement.id;
            $('#' + elem_id + '').removeClass('error_area');
            $('.input-group').removeClass('error_area');
            $('#errorDiv').hide();
            $('#event_error').hide();
        }
    });
}

function checkInputForErrors() {
    var error_txt = '';
    var createEventName = $('#createEventName').val();
    var createEventDate = $('#createEventDate').val();
    var createEventLocation = $('#createEventLocation').val();
    var createEventInvitees = $('#createEventInvitees').val();
    var createEventDescription = $('#createEventDescription').val();
    var createEventWishlist = $('#createEventWishlist').val();
    var createEventDateCheck = checkDateInput(createEventDate);
    var createEventInviteesCheck = checkEventInviteeEmails(createEventInvitees);
    if (createEventName.length < 1) {
        $('#createEventName').addClass('error_area');
        error_txt = 'Event name can\'t be empty';
    } else if (createEventDateCheck.length !== 0) {
        $('#createEventDate').addClass('error_area');
        error_txt = createEventDateCheck;
    } else if (createEventLocation.length < 1) {
        $('#createEventLocation').addClass('error_area');
        error_txt = 'Location field can\'t be empty';
    } else if (createEventInviteesCheck) {
        $('#createEventInvitees').siblings('.bootstrap-tagsinput').addClass('error_area');
        error_txt = 'Invalid email in invitees';
    } else if (createEventDescription.length < 1)  {
        $('#createEventDescription').addClass('error_area');
        error_txt = 'Event Description can\'t be empty';
    } else if (createEventWishlist.length < 1) {
        $('#createEventWishlist').siblings('.bootstrap-tagsinput').addClass('error_area');
        error_txt = 'Wishlist can\'t be empty';
    }
    return error_txt;
}

function checkEventInviteeEmails(createEventInvitees) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var createEventInviteesArray = createEventInvitees.split(',');
    var is_error = false;
    for (var i = 0; i < createEventInviteesArray.length; i++) {
        if (!mailformat.test(createEventInviteesArray[i])) {
            is_error = true;
        }
    }
    return is_error;
}

function checkDateInput(createEventDate)  {
    var error_txt = '';
    var createYear = createEventDate.substring(0, 4);
    var createMonth = createEventDate.substring(5, 7);
    var createDay = createEventDate.substring(8);
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = currentDate.getMonth() + 1;
    var currentDay = currentDate.getDate();
    if (currentDay < 10) {
        currentDay = '0' + currentDay;
    }
    if (currentMonth < 10) {
        currentMonth = '0' + currentMonth;
    }
    var createDate = createYear + '-' + createMonth + '-' + createDay,
        currentDate = currentYear + '-' + currentMonth + '-' + currentDay;
    if (createEventDate.length < 1) {
        error_txt = 'Event date not set';
    } else if (currentDate > createDate) {
        error_txt = 'Event can\'t occur in past';
    } else if (createDate > '2020-12-31') {
        error_txt = 'Event is too far in future';
    }
    return error_txt;
}

function deleteCreateEventInputs() {
    $('#createEventName').val('');
    $('#createEventDate').val('');
    $('#createEventLocation').val('');
    $('#createEventInvitees').siblings('.bootstrap-tagsinput').find('span').remove();
    $('#createEventDescription').val('');
    $('#createEventWishlist').siblings('.bootstrap-tagsinput').find('span').remove();
}

$(".login-container").submit(function (e) {
    var email = $("#email").val();
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var password = $("#password").val();
    var error_txt = '';
    if (email.length < 1)  {
        $('#email').parent('.input-group').addClass('error_area');
        error_txt = 'Email can\'t be empty';
    } else if (!mailformat.test(email)) {
        $('#email').parent('.input-group').addClass('error_area');
        error_txt = 'Invalid email';
    } else if (password.length < 1) {
        $('#password').parent('.input-group').addClass('error_area');
        error_txt = 'Password can\'t be empty';
    }
    /*else if (password !== 'mark1') {
            $('#password').parent('.input-group').addClass('error_area');
            error_txt = 'Wrong password';
        }
        if (email === "markotto@gmail.com" && password === "mark1") {
            e.preventDefault();
            window.location = "view-event.html";
        }*/
    if (error_txt.length !== 0)  {
        e.preventDefault();
        //this means its password error
        if (error_txt.toLowerCase().indexOf('password') !== -1) {
            $('#password').after($('#errorDiv'));
        } else {
            $('#email').after($('#errorDiv'));
        }
        $('#errorDiv').text(error_txt).show();
    }
});

$('.signup-container').submit(function (e)  {
    var email = $("#email").val();
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    var name = $('#name').val();
    var password1 = $("#password1").val();
    var password2 = $("#password2").val();
    var error_txt = '';
    if (email.length < 1)  {
        $('#email').after($('#errorDiv')).parent('.input-group').addClass('error_area');
        error_txt = 'Email can\'t be empty';
    } else if (!mailformat.test(email)) {
        $('#email').after($('#errorDiv')).parent('.input-group').addClass('error_area');
        error_txt = 'Invalid email';
    } else if (name.length < 1)  {
        $('#name').after($('#errorDiv')).parent('.input-group').addClass('error_area');
        error_txt = 'Name can\'t be empty';
    } else if (password1.length < 1 || password2.length < 1) {
        $('#password1').after($('#errorDiv')).parent('.input-group').addClass('error_area');
        error_txt = 'Password can\'t be empty';
    } else if (password2.length < 1) {
        $('#password2').after($('#errorDiv')).parent('.input-group').addClass('error_area');
        error_txt = 'Password can\'t be empty';
    } else if (password1 !== password2) {
        $('#password1').after($('#errorDiv')).parent('.input-group').addClass('error_area');
        error_txt = 'Passwords must match';
    }
    if (error_txt.length !== 0)  {
        e.preventDefault();
        $('#errorDiv').text(error_txt).show();
    } else {
        //e.preventDefault();
        //window.location = "login.html";
    }
});

function _getItemBoughtHTML() {
    var return_str =
        '<form class="itemBought container" action="boughtit.php" method="post">' +
        '<span class="glyphicon glyphicon-globe"> </span>' +
        '<a class="link eventGiftBoughtLink"></a>' +
        '<input type="text" name="giftLink" class="form-control giftbought eventGiftBoughtLinkInput extramargin">' +
        '<br>' +
        '<div class="block-label">Price: <span class="content eventGiftBoughtPrice"></span>' +
        '<input type="text" name="giftPrice" class="form-control giftbought eventGiftBoughtPriceInput">' +
        '</div>' +
        '<div class="block-label">Money collected: <span class="content eventGiftBoughtMoneyCollected"></span>' +
        '<input type="text" name="moneyCollected" class="form-control giftbought eventGiftBoughtMoneyCollectedInput">' +
        '</div>' +
        '<div class="block-label">Bought by: <span class="content giftBoughtBy"></span>' +
        '</div>' +
        '<button type="submit" class="btn btn-success">Save</button>' +
        '<button id="editGiftBoughtData" type="button" class="btn btn-info">Edit</button>' +
        '<button id="contibuteGiftBoughtData" type="button" class="btn btn-success extramargin">Contibute</button>' +
        '</form>';
    return return_str;
}

function _getEventCreatedInvitees(createEventInvitees) {
    var createEventInviteesArray = createEventInvitees.split(',');
    var return_str = 'Invitees: ';
    for (var i = 0; i < createEventInviteesArray.length; i++) {
        return_str += '<span class="label label-info">' + createEventInviteesArray[i] + '</span>';
    }
    return return_str;
}

function _getEventCreatedWishlist(createEventWishlist) {
    var createEventWishlistArray = createEventWishlist.split(',');
    var return_str = 'Wishlist: ';
    for (var i = 0; i < createEventWishlistArray.length; i++) {
        return_str += '<span data-toggle="modal" data-target="#giftModal" class="label label-default">' + createEventWishlistArray[i] + '</span>'
    }
    return return_str;
}

function deleteCreatedEventData() {
    $('.eventCreatedTitle').text('');
    $('.eventCreatedDate').text('');
    $('.createdEventLocation').text('');
    $('.eventCreatedInvitees').html('');
    $('.eventCreatedDescription').text('');
    $('.eventCreatedWishlist').html('');
}

function initialize() {
    var mapProp = {
        center: new google.maps.LatLng(51.508742, -0.120850),
        zoom: 5,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
}

function installLoginErrorHandlers() {
    if(document.URL.indexOf("error_code=1") !== -1){
        var error_txt = 'Invalid email or password';
        $('#email').addClass('error_area');
        $('#email').after($('#errorDiv'));
        $('#errorDiv').text(error_txt).show();
    }
}

$(document).ready(function () {
    installLoginErrorHandlers();
    installClickHandlers();
    google.maps.event.addDomListener(window, 'load', initialize);
    $.getScript('http://timschlechter.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.js', function () {});

});