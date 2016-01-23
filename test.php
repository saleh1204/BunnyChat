<?php

        $_mysqli = mysql_connect("localhost", "root", "saleh");
	echo $_mysqli . '<br />';
        $db = mysql_select_db("chat", $_mysqli);
	echo $db . '<br />';
	$result = mysql_query("select * from login", $_mysqli);
	echo $result . '<br />';
	echo "MySQL error " . mysql_errno() . ": "
         . mysql_error() . "\n<br>When executing <br>\n$query\n<br>";
?>
