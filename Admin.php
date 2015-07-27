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
        //phpinfo();
        //  echo 'Saleh<br />Ahmed';
        $msg = 'You are not Allowed to access this page!';
        session_start(); // Starting Session
        //echo $_SESSION['admin'].'<br>';
        if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
            $msg = 'Login Successful!';
        }
        ?>

        <div id="main" class="center-block">
            <div id="msg" class="text-center">
                <h3><?php echo $msg; ?></h3>
            </div>
            <div class="form-group">
                <input  class="btn btn-danger btn-block" name="logout" type="button" value=" Logout " onclick="window.location='index.php'">
            </div>
            <?php
            ?>
        </div>
    </body>
</html>
