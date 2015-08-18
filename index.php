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

    </head>
    <body>
        <?php
        // put your code here
        //phpinfo();
        //  echo 'Saleh<br />Ahmed';
        session_start(); // Starting Session
        session_destroy();
        unset($_COOKIE['userField']);
        ?>
        <input class="btn btn-primary" type="button" value="Login" onclick="window.location = 'Login.php';">
        <input class="btn btn-success" type="button" value="Register" onclick="window.location = 'Register.php';">

        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-8"></div>
                <div class="col-xs-6 col-md-4"></div>
            </div>
        </div>
    </body>
</html>
