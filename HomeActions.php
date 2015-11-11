<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminActions
 *
 * @author Saleh
 */
include 'ChatDAO.php';

class HomeActions {

    //put your code here

    public function Add($request) {

        $dao = new ChatDAO();
        $friend = $request->get("friend");
        $username = $request->get("username");
        $dao->addFriend($username, $friend);
        $list = $dao->getFriends($username);
        $ulist = json_encode($list);
        //print $ulist;
        echo $ulist;
    }

    public function Remove($request) {

        $dao = new ChatDAO();
        $friend = $request->get("friend");
        $username = $request->get("username");
        $dao->removeFriend($username, $friend);
        $list = $dao->getFriends($username);
        $ulist = json_encode($list);
        echo $ulist;
    }

    public function predict($request) {
        $dao = new ChatDAO();
        $username = $request->get("username");
        $list = $dao->predictUsers($username);
        $ulist = json_encode($list);
        echo $ulist;
    }

    public function sendMsg($request) {
        $dao = new ChatDAO();
        $sender = $request->get("sender");
        $receiver = $request->get("receiver");
        $msg = $request->get("message");
        $dao->sendMsg($sender, $receiver, $msg);
        $messages = $dao->getMessages($sender, $receiver);
        $ulist = json_encode($messages);
        echo $ulist;
    }

    public function getMesaages($request) {
        $dao = new ChatDAO();
        $sender = $request->get("sender");
        $receiver = $request->get("receiver");
        $messages = $dao->getMessages($sender, $receiver);
        $ulist = json_encode($messages);
        echo $ulist;
    }

}
