<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bunny Chat</title>
        <link rel="shortcut icon" href="img/favicon.gif" type="image/x-icon" />

        <script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>

        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-theme.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
        

        <script src="js/jquery-ui.min.js" type="text/javascript"></script>
        
        <link href="css/jquery-ui.min.css" rel="stylesheet">
        <link href="css/jquery-ui.structure.min.css" rel="stylesheet">
        <link href="css/jquery-ui.theme.min.css" rel="stylesheet">
        

        <link href="css/mystyle.css" rel="stylesheet">
        <script src="js/homeActions.js"></script>
        <!-- Latest compiled and minified CSS -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Optional theme -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
    </head>
    <body>
        <?php
        include 'ChatDAO.php';
        $msg = '';
        session_start(); // Starting Session
        if (isset($_SESSION['login'])) {
            $msg = 'Logged As: ';
        } else if (isset($_SESSION['register'])) {
            $msg = 'Logged As: ';
        } else {
            header("Location: index.php");
        }
        ?>
        <div id="dummy"></div>
        <div id="msg" class="text-center center-block">
            <h1>Welcome to BunnyChat</h1>
            <h3><?php echo $msg; ?>
                <div id="username">
                    <?php echo $_SESSION['login_user']; ?>
                </div>
            </h3>

            <div id="info">

            </div>
        </div>

        <div id="tabs" class="center-block">
            <ul id="tabsHeader">
                <li><a href="#main">Friends List</a></li>
                <li><a href="#tabs-2">Friend1</a><span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span></li>
                <li><a href="#tabs-3">Friend2</a><span class="ui-icon ui-icon-close" role="presentation">Remove Tab</span></li>
            </ul>
            <div id="main" class="tab active center-block">

                <div class="form-group">
                    <div class="input-group">
                        <input  class="form-control" type="text" id="friendName" name="friendName" autocomplete="on" placeholder="Write Your friend name here!">
                        <?php
                        setcookie("userField", $_SESSION['login_user']);
                        echo '<div class="btn btn-default btn-s input-group-addon" id="addBtn" onclick="addFriend(\'' . $_SESSION['login_user'] . '\')">Add</div>';
                        //   printf('var userFiled1 = %s;', json_encode($_SESSION['login_user']));
                        ?>
                    </div>

                </div>
                <div >
                    <table class="table table-hover" id="tableList">
                        <thead class="text-center">
                            <tr><th>Friend</th><th>Actions</th></tr>
                        </thead>
                        <tbody id="friends">
                            <?php
                            $dao = new ChatDAO();
                            $user = $_SESSION['login_user'];
                            $friends = $dao->getFriends($_SESSION['login_user']);
                            foreach ($friends as $friend) {
                                echo '<tr>';
                                echo "<td>$friend->friendName</td>";
                                echo "<td class=\"form-group\">"
                                . "<button class=\"remove\" id=\"remove\" onclick=\"removeFriend('$friend->friendName');\">Remove</button>&nbsp&nbsp&nbsp"
                                . "<button class=\"chat\" id=\"chat\" onclick=\"chatFriend('$friend->friendName');\">Chat</button><br>"
                                . "</td>";
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="result" class="form-group ">

                </div>
                <div class="form-group">
                    <input  class="btn btn-danger btn-block" name="logout" type="button" value=" Logout " onclick="window.location = 'index.php'">
                </div>
            </div>
            <div id="tabs-2" class="tab">
                <p>Crazy</p>
                <div id="friend1Messages" class="chatDiv">
                    <p class="sender">
                        shfksdhfjdfhkhsdlkhf
                        fdsfkjhsdkfhsdk;fh
                        dhfjkzshdfjhs;dfdkh;fh
                    </p>
                    <br />
                    <p class="recieve">
                        adfnlndf/ndmnfsdnfjlkndjkflkdsj
                        dskjfnhsdl;jf'skdjksjdlfjsldkjf
                        dsflkshjdfl;lkdjf'jksd;lkjflsddjlkfjsdljfkldsjfklsdjkflkdsjklsdjlkjsdflkjsdljfskldjlksdjlksjfslkj
                    </p>
                    <br />
                    <p class="sender">
                        s
                    </p>
                    <br />
                    <br />
                    <br />
                    <p class="recieve">
                        a
                    </p>
                    <br />
                    <p class="sender">
                        s
                    </p>
                    <br />
                    <p class="recieve">
                        a
                    </p>
                    <br />
                    <p class="sender">
                        s
                    </p>
                    <br />
                    <p class="recieve">
                        a
                    </p>
                    <br />
                    <p class="sender">
                        s
                    </p>
                    <br />
                    <p class="recieve">
                        a
                    </p>
                    <br />
                </div>
                <br />
                <div class="input-group">

                    <input  class="form-control" type="text" id="message" name="message" autocomplete="on" placeholder="Send Message" >

                    <div class="btn btn-default btn-s input-group-addon" id="SendMsg" onclick="">Send</div>
                </div>
            </div>
            <div id="tabs-3">
                <p>Crazy 2</p>
            </div>
        </div>
    </div>
</body>
</html>
