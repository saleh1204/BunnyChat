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


function Unadmin(user)
{
    $.ajax(
            "ActionHandler.php",
            {
                type: "GET",
                processedData: true,
                data: {
                    cmd: "Unadmin",
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
                //contentType: 'application/json',
                contentType: 'application/json',
                //        dataType: "json",
                success: function (json)
                {
                    updateUsers(json);
                    //alert(json);
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
    // alert("please refresh!");
    $('#tableList tbody').empty();
    //alert(users.user);
    var usersList = jQuery.parseJSON(users);
    //alert(usersList[0]);
    //$('#users').append("<tbody id=\"users\">");
    for (var user in usersList)
    {
        var admin;
        var adminFun;
        if (usersList[user].admin == 1)
        {
            admin = "TRUE";
            adminFun = "Unadmin";
        }
        else
        {
            admin = "FALSE";
            adminFun = "Admin";
        }
        //alert(usersList[user]);
        var row, username, email, gender, adminCell, buttonsCell, adminBtn, deleteBtn;
        row = "<tr>";
        username = "<td>" + usersList[user].username + "</td>";
        email = "<td>" + usersList[user].email + "</td>";
        gender = "<td>" + usersList[user].gender + "</td>";
        adminCell = "<td>" + admin + "</td>";
        buttonsCell = "<td class=\"form-group\">";
        adminBtn = "<button class='btn btn-default btn-s btn-block' onclick=\"" + adminFun + "('" + usersList[user].username + "')\";\">" + adminFun + "</button>";
        deleteBtn = "<button class='btn btn-default btn-s btn-block' onclick=\"Delete('" + usersList[user].username + "')\";\">Delete</button></td></tr>";


        var tmp = row + username + email + gender + adminCell + buttonsCell + adminBtn + deleteBtn;
        //                         echo "<td class=\"form-group\">"
        //                      . "<button class=\"btn btn-default btn-s btn-block\" onclick=\"".$admin."('$user->username');\">$admin</button>"
        //                        . "<button class=\"btn btn-default btn-s btn-block\" onclick=\"Delete('$user->username')\">Delete</button>"
        //                        . "</td>";
        $('#tableList tbody').append(tmp);
    }
    $('#tableList tbody').append('<tr><td colspan="5"><input  class="btn btn-danger btn-block" name="logout" type="button" value=" Logout " onclick="window.location = \'index.php\'"></td></tr>');
    // <tr><td colspan="5"><input  class="btn btn-danger btn-block" name="logout" type="button" value=" Logout " onclick="window.location = \'index.php\'"></td></tr>
    //$('#tableList tbody').append("</tbody>");
}

function myfunction(message)
{
    // alert("message");
    alert(message);
    //Delete(message);
}