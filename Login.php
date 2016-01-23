<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bunny Chat | Login</title>
        <link rel="shortcut icon" href="img/favicon.gif" type="image/x-icon" />

        <script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>


        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-theme.min.css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
        <link href="css/mystyle.css" rel="stylesheet">

        <!-- Latest compiled and minified CSS -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Optional theme -->
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>-->
    </head>
    <body>

        <?php
        require 'ChatDAO.php';
	//echo 'Loaded Successfully<br />';
	//echo file_get_contents("ChatDAO.php");
        session_start(); // Starting Session
        $error = ''; // Variable To Store Error Message
        if (isset($_POST['submit'])) {
	//echo 'Username : ' . $_POST['username'] .  empty($_POST['username']) . '<br />';
	//echo 'Password : ' . $_POST['password'] . empty($_POST['password'])  . '<br />';
            if (empty($_POST['username']) || empty($_POST['password'])) {
                $error = "Username or Password is invalid";
            } else {
                // Define $username and $password
                $username = $_POST['username'];
                $password = $_POST['password'];
                // Establishing Connection with Server by passing server_name, user_id and password as a parameter
                // $connection = mysql_connect("localhost", "root", "");
                // To protect MySQL injection for Security purpose
                $username = stripslashes($username);
                $password = stripslashes($password);
                $username = mysql_real_escape_string($username);
                $password = mysql_real_escape_string($password);


                $dao = new ChatDAO();
                $que = "select * from login where password='$password' AND username='$username'";
		//$rows = 0;
		//echo 'ROWS : ' . $rows . '<br />';
		
		$result = $dao->excuteQuery($que);
		$rows = $result->num_rows;
//                $rows = mysql_numrows($dao->excuteQuery($que));
		//echo 'Rows: ' . $rows . '<br />';
                //$rows =1;
                if ($rows == 1) {
                    $_SESSION['login_user'] = $username; // Initializing Session
                    $_SESSION['login'] = "TRUE";
                    unset($_SESSION['register']);

                    // echo 'Admin '. $dao->isAdmin($username, $password);
                    $_SESSION['admin'] = $dao->isAdmin($username, $password);
                    header("location: home.php"); // Redirecting To Other Page
                } else {
                    $error = "Username or Password is invalid";
                }
		    /* free result set */
		    $result->close();
                // mysql_close($connection); // Closing Connection
            }
        }
        ?>
        <div id="main" class="center-block">
            <h1 class="text-center">Welcome to BunnyChat</h1>
            <div id="login">
                <h2 class="text-center">Login Page</h2>
                <div id="error" class="text-center">
                    <h3><?php echo $error; ?></h3>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Username &nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <br/>
                        <br/>
                        <div class="col-sm-10">      
                            <input class="form-control" id="username" name="username" placeholder="username" type="text">
                            <br />
                        </div>

                    </div>
                        <br/>
                        <br/>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Password &nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <br/>
                        <br/>
                        <div class="col-sm-10">                    
                            <input class="form-control" id="password" name="password" placeholder="**********" type="password">
                            <br />
                        </div>

                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input  class="btn btn-primary btn-block" name="submit" type="submit" value=" Login ">
                            <input  class="btn btn-success btn-block" type="button" value="Register" onclick="window.location = 'Register.php';">
                        </div>
                    </div>
                </form>
            </div>
            <div id="image" class="form-group">

                <div class="col-sm-offset-4 col-sm-10">
                    <br />
                    <br />
                    <img class="img-responsive" src="img/bunny.gif">
                </div>
            </div>
        </div>
    </body>
</html>
