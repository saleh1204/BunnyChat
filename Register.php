<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bunny Chat | Register</title>
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
        // put your code here
        // echo 'Register';
        include 'ChatDAO.php';
        session_start(); // Starting Session
        $error = ''; // Variable To Store Error Message
        if (isset($_POST['submit'])) {
            if (empty($_POST['username'])) {
                $error = "Username field must be filled!";
            } else if (empty($_POST['password1']) || empty($_POST['password2'])) {
                $error = "Password fields must be filled!";
            } else if ($_POST['password1'] != $_POST['password2']) {
                $error = "Password fields must match!";
            } else if (empty($_POST['email'])) {
                $error = "Email field must be filled!";
            } else {
                $error = "";
                $username = $_POST['username'];
                $password = $_POST['password1'];
                $email = $_POST['email'];
                $gender = $_POST['gender'];



                $username = stripslashes($username);
                $password = stripslashes($password);
                $email = stripslashes($email);

                $username = mysql_real_escape_string($username);
                $password = mysql_real_escape_string($password);
                $email = mysql_real_escape_string($email);

                $dao = new ChatDAO();
                $result = $dao->addUser($username, $password, $email, $gender);
                if (!$result) {
                    //die('Invalid query: ' . mysql_error());
                   // $error = "MySQL error " . mysql_errno() . ": " . mysql_error() . "\n<br>When executing <br>\n$query\n<br>";
                    $error = 'Username/Email already exists';
                } else {
                    $_SESSION['login_user'] = $username; // Initializing Session
                    $_SESSION['register'] = "TRUE";
                    unset($_SESSION['login']);
                    header("location: home.php"); // Redirecting To Other Page
                }
            }
        }
        ?>
        <div id="dummy"></div>
        <div id="main" class="center-block">
            <h1 class="text-center">Welcome to BunnyChat</h1>
            <div id="login">
                <h2 class="text-center">Register Page</h2>
                <div id="error" class="text-center">
                    <h3><?php echo $error; ?></h3>
                </div>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10">      
                            <input class="form-control" id="username" name="username" placeholder="username" type="text">
                            <br />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">                    
                            <input class="form-control" id="password" name="password1" placeholder="**********" type="password">
                            <br />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>
                        <div class="col-sm-10">                    
                            <input class="form-control" id="password2" name="password2" placeholder="**********" type="password">
                            <br />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">      
                            <input class="form-control" id="email" name="email" placeholder="example@example.com" type="email">
                            <br />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Gender</label>
                        <div class="col-sm-10">      
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="inlineRadio1" value="male">Male<img src="img/maleBunny1.jpg">
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="gender" id="inlineRadio2" value="female">Female<img src="img/femaleBunny1.jpg">
                            </label>
                            <br />
                            <br />
                            <br />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input  class="btn btn-success btn-block" name="submit" type="submit" value=" Register ">
                            <input  class="btn btn-primary btn-block" type="button" value="Login" onclick="window.location = 'Login.php';">
                        </div>
                    </div>

                </form>
            </div>
            <div id="image" class="form-group">

                <div class="col-sm-offset-4 col-sm-10">
                    <br />
                    <br />
                </div>
            </div>
        </div>


    </body>
</html>

