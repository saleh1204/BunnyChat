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
    /*
     $('#friend1Messages').stop().animate({
     scrollTop: $("#friend1Messages")[0].scrollHeight
     }, 800);
     */
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
            //console.info(ui.newTab.context.innerHTML);
            var friendsName = ui.newTab.context.innerHTML;
            if (friendsName !== "Friends List")
            {
                adjustWindow();

                // here goes the code of scrolling down
                //$('.chatDiv').stop().animate({scrollTop: $(".chatDiv")[0].scrollHeight}, 800);
                //  $('.chatDiv').animate({scrollTop: $('.chatDiv').height()}, 800);
                //  console.info("scrolled");
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
        $('#msg').css("width", tabsWidth + "px");
        $('.sender').css("width", senderWidth + "px");
        $('.recieve').css("width", senderWidth + "px");
        //$("#info").html("<br />main width: " + (pageWidth / 1.1));
    }
    else
    {
        var mainWidth = (pageWidth / 2.5);
        var tabsWidth = (pageWidth / 2.4);
        var senderWidth = pageWidth / 6.8;
        $('#main').css("width", mainWidth + "px");
        $('#tabs').css("width", tabsWidth + "px");
        $('#msg').css("width", tabsWidth + "px");
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
    // console.info('Theme Applied!!');
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
        //alert("Add " + userField + " to " + friendVar);
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
                '<button class="chat" id="chat" onclick="chatFriend(\'' + friendName + '\', \'' + userField + '\');">Chat</button>&nbsp&nbsp&nbsp' +
                '<button class="remove" id="remove" onclick="removeFriend(\'' + friendName + '\', \'' + userField + '\');">Remove</button><br />' +
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
    //console.info('chat ' + userField + ' and ' + friend);
    var exist = false;
    var friendName;
    var tabsHeader = $("a:contains('" + friend + "')");
    //alert(tabsHeader.length);
    //console.info(tabsHeader.length);
    if (tabsHeader.length !== 0)
    {
        exist = true;
        //console.info(tabsHeader[0].innerHTML);
        //console.info($(tabsHeader[0]).text());
        friendName = $(tabsHeader[0]).text();
    }
    var friendMsgDiv;
    if (exist === false)
    {
        friendName = friend;
        $('#tabsHeader').append('<li><a href="#' + friend + '">' + friend + '</a><span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span></li>');
        //  <div id="tabs-2" class="tab">
        var div = '<div id="' + friend + '" class="tab"><p style="text-align: center"> <strong> ' + friend + '</strong> </p>';

        friendMsgDiv = '<div id="' + friend + 'Messages" class="chatDiv">';
        // AJAX call to get the messages
        /* 
         
         <p class="sender">
         s
         </p>
         <br />
         <p class="recieve">
         a
         </p>
         */

        friendMsgDiv += "<img alt='loading' src='img/ajax-loader.gif'/>";
        //friendMsgDiv
        // console.info("Adding : "+friendName);
        var textBtn = "<div class='input-group'>"
                + "<input  class='form-control' type='text' id='" + friendName + "msg' name='message' autocomplete='on' placeholder='Send Message' >"
                + "<div class='btn btn-default btn-s input-group-addon SendMsg' onclick='send_handler(" + friendName + ");'>Send</div>"
                + "</div>";
        friendMsgDiv = friendMsgDiv + '</div>' + textBtn + '</div>';
        $('#tabs').append(div + friendMsgDiv);
        $("#tabs").tabs("refresh");
        //$("#tabs").tabs("option", "active", id2Index("#tabs", "#" + friend));
        $("#" + friend + "msg").keypress(function (evt) {
            var tmp = evt;
            if (tmp.keyCode === undefined) {
                tmp = tmp.key;
            }
            else {
                tmp = tmp.keyCode;
            }
            if (tmp == 13)
            {
                console.log("Key Pressed " + evt.charCode + "on chat of " + friend);
                //$("#" + friend + "msg").trigger("onclick");
                sendMsg(friend);
            }

        });

        //   updateTabs();
    }
    $("#tabs").tabs("option", "active", id2Index("#tabs", "#" + friend));
    updateMessages(friendName, friendName + "Messages");
    setInterval(function () {
        if (document.getElementById(friendName + "Messages") !== null)
        {
            updateMessages(friendName, friendName + "Messages");
        }
    }, 3000);
    // <li><a href="#tabs-3">Friend2</a><span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span></li>
}


function send_handler(friend)
{
    //console.info($(friend).attr("id"));
    sendMsg($(friend).attr("id"));
}

function sendMsg(friend)
{
    //console.info(friend);
    console.info('send ' + friend + ' a message from ' + userField);
    var theMessage = $('#' + friend + 'msg');
    console.info('message: ' + theMessage.val());
    // AJAX call to send Message
    $.ajax(
            "ActionHandler.php",
            {
                type: "GET",
                processedData: true,
                data: {
                    cmd: "sendMsg",
                    grp: "Home",
                    sender: userField,
                    receiver: friend,
                    message: theMessage.val()
                },
                //dataType: "json",
                contentType: 'application/json',
                success: function (json)
                {
                    loadMessageOntoDiv(json, friend);
                    //updateMessages(userField, friend+'Messages');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#info").append('<br>' + jqXHR.responseText);
                    $("#info").append('<br>' + textStatus);
                    $("#info").append('<br>' + errorThrown);
                }
            });
    theMessage.val("");
}

function loadMessageOntoDiv(data, friend)
{
    var allMessagesDiv = new Array();
    var msgDiv = "#" + friend + "Messages";
    var newData = jQuery.parseJSON(data);
    //var newData = json;
    //console.info('Sender: ' + newData[0].sender + " Receiver: " + newData[0].receiver + " Msg: " + newData[0].msg);
    for (var key in newData) {
        // newData[key].username
        if (newData[key].sender === userField)
        {
            var x = $('<p class="sender">' + newData[key].msg + '</p> <br /><br />');
            x.attr("msgID", newData[key].msgID);
            allMessagesDiv.push(x);
            //console.info("Sender");
        }
        else
        {
            var y = $('<p class="recieve">' + newData[key].msg + '</p> <br /><br />');
            y.attr("msgID", newData[key].msgID);
            allMessagesDiv.push(y);
            //console.info("Receiver");
        }
    }
    /*
     if ($(msgDiv + "[msgID=9" + "]"))
     {
     console.info("Great");
     }
     else
     {
     console.info("Not Much!!!");
     }
     */
    $(msgDiv).empty();
    $(msgDiv).append(allMessagesDiv);


    var element = document.getElementById(friend + "Messages");

    // element.scrollIntoView();
    //console.info("Outer Height: " + $(msgDiv).scrollTop() + " Height: " + element.scrollHeight);
    $(msgDiv).animate({scrollTop: element.scrollHeight}, 200);
    //$('.chatDiv').stop().animate({scrollTop: $(".chatDiv")[0].scrollHeight}, 800);
}


function updateMessages(friend, messagesDivID)
{
    var allMessagesDiv = new Array();
    var msgDiv = "#" + messagesDivID;
    $.ajax(
            "ActionHandler.php",
            {
                type: "GET",
                processedData: true,
                data: {
                    cmd: "getMesaages",
                    grp: "Home",
                    sender: userField,
                    receiver: friend
                },
                //dataType: "json",
                contentType: 'application/json',
                success: function (data)
                {
                    loadMessageOntoDiv(data, friend);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#info").append('<br>' + jqXHR.responseText);
                    $("#info").append('<br>' + textStatus);
                    $("#info").append('<br>' + errorThrown);
                }
            });
}

//tabsId Id of the div containing the tab code.
//srcId Id of the tab whose id you are looking for
function id2Index(tabsId, srcId)
{
    var index = -1;
    var i = 0, tbH = $(tabsId).find("li a");
    var lntb = tbH.length;
    if (lntb > 0) {
        for (i = 0; i < lntb; i++) {
            o = tbH[i];
            if (o.href.search(srcId) > 0) {
                index = i;
            }
        }
    }
    return index;
}