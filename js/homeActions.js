/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var userField;
var allData;

jQuery(document).ready(function () {
    predictFriendName();
    //jQuery('.tabs ' + jQuery('.tabs a').attr('href')).hide();
    jQuery('.tabs a').on('click', function (e) {
        var currentAttrValue = jQuery(this).attr('href');

        // Show/Hide Tabs
        //jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
        jQuery('.tabs ' + currentAttrValue).siblings().slideUp(400);
        jQuery('.tabs ' + currentAttrValue).delay(400).slideDown(400);
        
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');

        e.preventDefault();
    });
    adjustWindow();
    $(window).resize(function () {
        //resize just happened, pixels changed
        adjustWindow();
    });


}
);


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
        $('#main').css("width", (pageWidth / 1.25) + "px");
        //$("#info").html("<br />main width: " + (pageWidth / 1.1));
    }
    else
    {
        $('#main').css("width", (pageWidth / 5) + "px");
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

    var userField1 = cookies["userField"]; // value set with php.

    userField = userField1;
    console.info('userFiled1 = ' + userField1);
    allData = [];
    $.ajax({
        type: "GET",
        url: "ActionHandler.php",
        processedData: true,
        contentType: 'application/json',
        data: {
            grp: "Home",
            cmd: "predict",
            username: userField1
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

function addFriend(user)
{
    var friendVar = $("#friendName").val();
    userField = user;
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
                        username: user,
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
    $('#result').append('Works! <br />');
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


function removeFriend(friend, user)
{
    var friendVar = $("#friendName").val();
    userField = user;
    //  alert("Remove " + user + " to " + friendVar);
    $.ajax(
            "ActionHandler.php",
            {
                type: "GET",
                processedData: true,
                data: {
                    cmd: "Remove",
                    grp: "Home",
                    username: user,
                    friend: friend
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

    //   $('#result').append('Remove ' + user + ' from ' + friend + '<br />');
}


function chatFriend(friend, user)
{
    userField = user;
    console.info('chat ' + user + ' and ' + friend);
}