/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function Admin(user)
{
    $.ajax(
            "ActionHandler.php",
            {
                type: "GET",
                processedData: true,
                data: {
                    cmd: "Admin",
                    username: user
                },
                contentType: 'application/json',
                success: function (json)
                {
                    updateUsers(json);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#result").append('<br>' + jqXHR.responseText);
                    $("#result").append('<br>' + textStatus);
                    $("#result").append('<br>' + errorThrown);
                }
            });
}


function Delete(user)
{
    $.ajax(
            "ActionHandler.php",
            {
                type: "GET",
                processedData: true,
                data: {
                    cmd: "Delete",
                    username: user
                },
                contentType: 'application/json',
                success: function (json)
                {
                    updateUsers(json);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#result").append('<br>' + jqXHR.responseText);
                    $("#result").append('<br>' + textStatus);
                    $("#result").append('<br>' + errorThrown);
                }
            });
}

function updateUsers(users)
{
    alert("please refresh!");
    $('#users').empty();
    for (var user in users)
    {
        var admin;
        if (users[user].admin == 1)
        {
            admin = "TRUE";
        }
        else
        {
            admin = "FALSE";
        }
        var tmp = "<tr><td>"+users[user].username+"</td><td>"+users[user].email+"</td><td>"+users[user].gender+"</td><td>"+admin+"</td></tr>";
        $('#users').append(tmp);
    }
}

function myfunction(message)
{
    // alert("message");
    alert(message);
    //Delete(message);
}