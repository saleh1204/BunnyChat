<?php
require_once __DIR__ . '/User.php';
require_once __DIR__ . '/Friend.php';
require_once __DIR__ . '/Message.php';
class ChatDAO {

    private $_mysqli;
    private $_host = "localhost";
    private $_user = "root";
    private $_pass = "saleh";
    private $_db = "chat";

    function __construct() {

    }

    function __destruct() {

    }
    function query(/* $sql [, ... ] */) {
        // SQL statement
        $sql = func_get_arg(0);
        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);
        // try to connect to database
        static $handle;
        if (!isset($handle)) {
            try {
                // connect to database
                $handle = new PDO("mysql:dbname=" . $this->_db . ";host=" . $this->_host, $this->_user, $this->_pass);
                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            } catch (Exception $e) {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }
        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false) {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }
        // execute SQL statement
        $results = $statement->execute($parameters);
        // return result set's rows, if any
        if ($results !== false) {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return false;
        }
    }


    public function addUser($username, $password, $email, $gender) {
          $query = 'INSERT INTO login (username, password,Email,Gender) VALUES (?, ?, ?, ?)';
          return $this->query($query, $username, $password, $email, $gender);
    }


    public function getUsers() {
        $list = array();
        $query = "select username, Email, Gender, admin from login order by username";
        $result = $this->query($query);
        $i = 0;
        foreach ($result as $row) {
            $list[$i++] = new User($row['username'], $row['Email'], $row['Gender'], $row['admin']);
        }
        return $list;
    }

    public function getFriends($username) {
        $list = array();
        $query = "select friend from friend where username=?";
        $result = $this->query($query, $username);
        $i = 0;
        foreach ($result as $row) {
            $list[$i++] = new Friend($row['friend']);
        }
        return $list;
    }

    public function predictUsers($username) {
        $list = array();
        $query = "select username from login where username !=? order by username";
        $result = $this->query($query, $username);
        $i = 0;
        foreach ($result as $row) {
            $list[$i++] = new User($row['username'], "", "", "");
        }
        return $list;
    }

    public function addFriend($username, $friend) {
        $query = 'INSERT INTO chat.friend (username, friend) VALUES (? , ?);';
        $this->query($query, $username, $friend);
        $this->query($query, $friend, $username);
    }

    public function removeFriend($username, $friend) {
        $query = "Delete from friend where username=? AND friend=?;";
        $this->query($query, $username, $friend);
        $this->query($query, $friend, $username);
    }

    public function sendMsg($sender, $receiver, $msg) {
        // INSERT INTO `chat`.`message` (`sender`, `receiver`, `MsgID`, `Message`) VALUES ('saleh', 'sas', '', 'hello there');
        $query = "INSERT INTO message (sender, receiver, Message) VALUES ( ? , ? , ? );";
        $this->query($query, $sender, $receiver, $msg);
    }

    public function getMessages($sender, $receiver) {
        $query = "SELECT * FROM message WHERE (sender = ? AND receiver = ? ) OR (sender = ? AND receiver = ?) ORDER BY MsgID";
        $result = $this->query($query, $sender, $receiver, $receiver, $sender);
        $i = 0;
        $msglist = array();
        foreach ($result as $row) {
            $msglist[$i++] = new Message($row['sender'], $row['receiver'], $row['Message'], $row['MsgID']);
        }
        return $msglist;
    }

}

?>
