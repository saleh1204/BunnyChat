<?php

include 'User.php';
include 'Friend.php';

class ChatDAO {

    private $_mysqli;

    function __construct() {
        
    }

    function __destruct() {
        
    }

    private function getDBConnection() {
        if (!isset($_mysqli)) {
            //$_mysqli = new mysqli("localhost", "root", "saleh", "chat");
            $_mysqli = mysql_connect("localhost", "root", "saleh");
            $db = mysql_select_db("chat", $_mysqli);
        }
        return $_mysqli;
    }

    public function excuteQuery($query) {
        $con = $this->getDBConnection();
        $result = mysql_query($query, $con);
        if (mysql_errno()) {
            //echo "MySQL error " . mysql_errno() . ": "
            // . mysql_error() . "\n<br>When executing <br>\n$query\n<br>";
        }
        if (!$result) {
            //  die('Invalid query: ' . mysql_error());
            //$result = NULL;
        }
        return $result;
    }

    public function addUser($username, $password, $email, $gender) {
        //$con = $this->getDBConnection();
        // INSERT INTO `chat`.`login` (`username`, `password`, `admin`, `Email`, `Gender`) VALUES ('saleh', 'saleh', TRUE, 'saleh1204@hotmail.com', 'male');
        $query = 'INSERT INTO login (username, password,Email,Gender) VALUES (\'' . $username . '\', \'' . $password . '\', \'' . $email . '\', \'' . $gender . '\');';
        $this->excuteQuery($query);
    }

    public function isAdmin($username, $password) {
        $query = "select * from login where password='$password' AND username='$username'";
        $result = $this->excuteQuery($query);
        $admin = 0;
        if (mysql_num_rows($result) > 0) {
            $row = mysql_fetch_assoc($result);
            $admin = $row['admin'];
            return $row['admin'];
        }
        return $admin;
    }

    public function getUsers() {
        $list = array();
        $query = "select username, Email, Gender, admin from login order by username";
        $result = $this->excuteQuery($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $list[$i++] = new User($row['username'], $row['Email'], $row['Gender'], $row['admin']);
        }
        return $list;
    }

    public function getFriends($username) {
        $list = array();
        $query = "select friend from friend where username='$username'";
        $result = $this->excuteQuery($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $list[$i++] = new Friend($row['friend']);
        }
        return $list;
    }
    
    public function predictUsers($username){
        $list = array();
        $query = "select username from login where username !='$username'order by username";
        $result = $this->excuteQuery($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $list[$i++] = new User($row['username'],"","","");
        }
        return $list;
    }

    public function addFriend($username, $friend) {
        $query = 'INSERT INTO chat.friend (username, friend) VALUES (\''.$username.'\',\''.$friend.'\');';
        $this->excuteQuery($query);
        // INSERT INTO chat.friend (username, friend) 
	// VALUES ('saleh', 'sad')

    }

    public function removeFriend($username, $friend) {
        $query = "Delete from friend where username='$username' AND friend='$friend';";
        $this->excuteQuery($query);
    }

}

?>
