/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var userField;
var allData;

jQuery(document).ready(function () {
    predictFriendName();
    //$( "#tabs" ).tabs();
    updateTabs();
    adjustWindow();
    $(window).resize(function () {
//resize just happened, pixels changed
        adjustWindow();
    });

    $('#friend1Messages').stop().animate({
        scrollTop: $("#friend1Messages")[0].scrollHeight
    }, 800);
}
);

function updateTabs()
{
    var tabs = $("#tabs").tabs({
        hide: {
            effect: "fold", duration: 500
        },
        show: {
            effect: "slide", duration: 300
        },
        activate: function (event, ui) {
            console.info(ui.newTab.context.innerHTML);
            var friendsName = ui.newTab.context.innerHTML;
            if (friendsName !== "Friends List")
            {
                adjustWindow();

                // here goes the code of retrieving the data from the server
                $('.chatDiv').stop().animate({scrollTop: $(".chatDiv")[0].scrollHeight}, 800);

                console.info("scrolled");
            }

        }

    });
    /*
     * effect options
     * blind
     * bounce
     * clip
     * drop
     * explode
     * fade
     * fold
     * highlight
     * puff
     * pulsate
     * scale
     * shake
     * size
     * slide
     * transfer
     * 
     */
    tabs.find(".ui-tabs-nav").sortable({
        axis: "x",
        stop: function () {
            tabs.tabs("refresh");
        }});
    tabs.delegate("span.ui-icon-close", "click", function () {
        var panelId = $(this).closest("li").remove().attr("aria-controls");
        $("#" + panelId).remove();
        tabs.tabs("refresh");
    });
}
function adjustWindow() {
    // var pageHeight = document.getElementById('page').offsetHeight || 5;
    // var pageWidth = document.getElementById('page').offsetWidth;

    var pageWidth = $(window).width();
    var pageHeight = $(window).height();
    //alert(pageHeight);
    //alert(pageWidth);
    //console.info('Height: ' + pageHeight);
    //console.info('Width: ' + pageWidth);
    //console.info('main Width: ' + pageWidth / 5.5);

    var is_mobile = false;
    if ($('#dummy').css('display') == 'none') {
        is_mobile = true;
    }
    if (is_mobile)
    {
        var mainWidth = (pageWidth / 1.25);
        var tabsWidth = (pageWidth / 1.1);
        var senderWidth = pageWidth / 1.6;
        $('#main').css("width", mainWidth + "px");
        $('#tabs').css("width", tabsWidth + "px");
        $('.sender').css("width", senderWidth + "px");
        $('.recieve').css("width", senderWidth + "px");
        //$("#info").html("<br />main width: " + (pageWidth / 1.1));
    }
    else
    {
        var mainWidth = (pageWidth / 5);
        var tabsWidth = (pageWidth / 4.9);
        var senderWidth = pageWidth / 6.8;
        $('#main').css("width", mainWidth + "px");
        $('#tabs').css("width", tabsWidth + "px");
        $('.sender').css("width", senderWidth + "px");
        $('.recieve').css("width", senderWidth + "px");
        //$("#info").html("<br />main width: " + (pageWidth / 5));
    }
}



function applyTheme()
{
    $('.remove').button({
        icons: {
            primary: "ui-icon-trash"
        },
        text: false
    });
    $('.chat').button({
        icons: {
            primary: "ui-icon-comment"
        },
        text: false
    });
    //  $('#result').append('Theme Applied!! <br />');
    console.info('Theme Applied!!');
    //document.write('Theme Applied!! <br />');
}

function predictFriendName()
{
    applyTheme();
    var cookies = document.cookie.split(";").
            map(function (el) {
                return el.split("=");
            }).
            reduce(function (prev, cur) {
                prev[cur[0]] = cur[1];
                return prev;
            }, {});
 //   var userField1 = cookies["userField"]; // value set with php.

    userField = $("#username").html().trim();
    console.info('userFiled = ' + userField);
    allData = [];
    $.ajax({
        type: "GET",
        url: "ActionHandler.php",
        processedData: true,
        contentType: 'application/json',
        data: {
            grp: "Home",
            cmd: "predict",
            username: userField
        },
        success: function (data) {
            var newData = jQuery.parseJSON(data);
            for (var key in newData) {
                allData.push(newData[key].username);
            }
        }
    });
    $("#friendName").autocomplete({
        source: allData
    });
}


function isValidFriend(friend)
{

    for (var key in allData)
    {
        if (friend == allData[key])
        {
            return true;
        }
    }
    return false;
}

function addFriend()
{
    var friendVar = $("#friendName").val();
    if (isValidFriend(friendVar) && friendVar != userField)
    {
        alert("Add " + user + " to " + friendVar);
        $.ajax(
                "ActionHandler.php",
                {
                    type: "GET",
                    processedData: true,
                    data: {
                        cmd: "Add",
                        grp: "Home",
                        username: userField,
                        friend: friendVar
                    },
                    //dataType: "json",
                    contentType: 'application/json',
                    success: function (json)
                    {
                        updateFriends(json);
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $("#msg").append('<br>' + jqXHR.responseText);
                        $("#msg").append('<br>' + textStatus);
                        $("#msg").append('<br>' + errorThrown);
                    }
                });
    }
    else
    {
        $("#info").html("<br />Cannot Add this friend!!!");
        $("#info").css("color", "red");
    }
    $("#friendName").val("");
}

function updateFriends(friendList)
{
    $('#tableList tbody').empty();
    var friends = jQuery.parseJSON(friendList);
    //var friendLst = $.parseJSON(friendList);
    for (var friend in friends)
    {
        var friendName = friends[friend].friendName;
        var row = '<tr>';
        var friendCell = '<td>' + friendName + '</td>';
        var buttonsCell = '<td class="form-group">' +
                '<button class="remove" id="remove" onclick="removeFriend(\'' + friendName + '\', \'' + userField + '\');">Remove</button>&nbsp&nbsp&nbsp' +
                '<button class="chat" id="chat" onclick="chatFriend(\'' + friendName + '\', \'' + userField + '\');">Chat</button><br>' +
                '</td></tr>';
        $('#tableList tbody').append(row + friendCell + buttonsCell);
        //alert(friends[friend]);
        //$('#result').append(friends[friend] + '<br />');
    }
    applyTheme();
}


function removeFriend(friend)
{
    var friendVar = $("#friendName").val();
    //  alert("Remove " + user + " to " + friendVar);
    $.ajax(
            "ActionHandler.php",
            {
                type: "GET",
                processedData: true,
                data: {
                    cmd: "Remove",
                    grp: "Home",
                    username: userField,
                    friend: friend
                },
                //dataType: "json",
                contentType: 'application/json',
                success: function (json)
                {
                    updateFriends(json);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#info").append('<br>' + jqXHR.responseText);
                    $("#info").append('<br>' + textStatus);
                    $("#info").append('<br>' + errorThrown);
                }
            });
    //   $('#result').append('Remove ' + user + ' from ' + friend + '<br />');
}


function chatFriend(friend)
{
    console.info('chat ' + userField + ' and ' + friend);
}