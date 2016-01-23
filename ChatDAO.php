<?php

include 'User.php';
include 'Friend.php';
include 'Message.php';

class ChatDAO {

    private $_mysqli;

    function __construct() {
        
    }

    function __destruct() {
        
    }

    private function getDBConnection() {
        if (!isset($_mysqli)) {
            //$_mysqli = new mysqli("localhost", "root", "saleh", "chat");
            $_mysqli = new mysqli("localhost", "root", "saleh", "chat");
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
	echo 'Error!!!';
    exit();
}

            //$db = mysql_select_db("chat", $_mysqli);
        }
        return $_mysqli;
    }

    public function excuteQuery($query) {
        $con = $this->getDBConnection();
        $result = $con->query($query);
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

    public function predictUsers($username) {
        $list = array();
        $query = "select username from login where username !='$username'order by username";
        $result = $this->excuteQuery($query);
        $i = 0;
        while ($row = mysql_fetch_assoc($result)) {
            $list[$i++] = new User($row['username'], "", "", "");
        }
        return $list;
    }

    public function addFriend($username, $friend) {
        $query = 'INSERT INTO chat.friend (username, friend) VALUES (\'' . $username . '\',\'' . $friend . '\');';
        $this->excuteQuery($query);
        $query = 'INSERT INTO chat.friend (username, friend) VALUES (\'' . $friend . '\',\'' . $username . '\');';
        $this->excuteQuery($query);
    }

    public function removeFriend($username, $friend) {
        $query = "Delete from friend where username='$username' AND friend='$friend';";
        $this->excuteQuery($query);
        $query = "Delete from friend where username='$friend' AND friend='$username';";
        $this->excuteQuery($query);
    }

    public function sendMsg($sender, $receiver, $msg) {
        // INSERT INTO `chat`.`message` (`sender`, `receiver`, `MsgID`, `Message`) VALUES ('saleh', 'sas', '', 'hello there');
        $query = "INSERT INTO message (sender, receiver, Message) VALUES ('" . $sender . "', '" . $receiver . "', '" . $msg . "');";
        $this->excuteQuery($query);
    }

    public function getMessages($sender, $receiver) {
        $query = "SELECT * FROM message WHERE (sender = '" . $sender . "' AND receiver = '" . $receiver . "') OR (sender = '" . $receiver . "' AND receiver = '" . $sender . "') ORDER BY MsgID";
        $result = $this->excuteQuery($query);
        $i = 0;
        $msglist = array();
        while ($row = mysql_fetch_assoc($result)) {
            $msglist[$i++] = new Message($row['sender'], $row['receiver'], $row['Message'], $row['MsgID']);
        }
        return $msglist;
    }

}

?>
