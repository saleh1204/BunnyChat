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

        <link href="css/mystyle.css" rel="stylesheet">
        <script src="js/adminActions.js"></script>
    </head>
    <body>
        <?php
        // put your code here
        //phpinfo();
        //  echo 'Saleh<br />Ahmed';
        include 'ChatDAO.php';
        $msg = 'You are not Allowed to access this page!';
        session_start(); // Starting Session
        //echo $_SESSION['admin'].'<br>';
        if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
            $msg = 'Login Successful!';
        }
        ?>
        <div id="dummy"></div>
        <div id="main" class="center-block">
            <div id="msg" class="text-center">
                <h3><?php echo $msg; ?></h3>
            </div>
            <div id="users" class="text-center">
                <!--
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr> <th>Username</th> <th>Email</th> <th>Gender</th> <th>Gender</th> </tr>        
                                    </thead>
                                </table> -->
                <?php
                if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
                    echo '
                    <table class="table table-hover" id="tableList">
                        <thead class="text-center">
                            <tr> <th style="text-align:center">Username</th> <th style="text-align:center">Email</th> <th style="text-align:center">Gender</th> <th style="text-align:center">Admin</th> <th style="text-align:center">Actions</th> </tr>        
                        </thead>';
                    echo '<tbody id="users">';
                    $dao = new ChatDAO();
                    $users = $dao->getUsers();
                    foreach ($users as $user) {
                        echo '<tr>';
                        echo "<td>$user->username</td>";
                        echo "<td>$user->email</td>";
                        $srcImg = "";
                        if ($user->gender == "female") {
                            $srcImg = "img/femaleBunny2.jpg";
                        } else {
                            $srcImg = "img/maleBunny2.jpg";
                        }
                        // $user->gender
                        echo "<td><img src=$srcImg class='img-responsive img-rounded'></td>";
                        $admin = "Admin";
                        if ($user->admin == 1) {
                            echo "<td>TRUE</td>";
                            $admin = "Unadmin";
                        } else {
                            echo "<td>FALSE</td>";
                            $admin = "Admin";
                        }
                        echo "<td class=\"form-group\">"
                        . "<button class=\"btn btn-default btn-s btn-block\" onclick=\"" . $admin . "('$user->username');\">$admin</button><br>"
                        . "<button class=\"btn btn-default btn-s btn-block\" onclick=\"Delete('$user->username')\">Delete</button>"
                        . "</td>";
                        echo '</tr>';
                    }
                    echo '<tr><td colspan="5"><input  class="btn btn-danger btn-block" name="logout" type="button" value=" Logout " onclick="window.location = \'index.php\'"></td></tr>';
                    echo '</tbody>
                    </table>';
                }
                ?>

            </div>
            <!--<div class="form-group">
                <input  class="btn btn-danger btn-block" name="logout" type="button" value=" Logout " onclick="window.location = 'index.php'">
                <br>
                <div id="result">Error will show here</div>
            </div>-->
<?php ?>
        </div>
    </body>
</html>
