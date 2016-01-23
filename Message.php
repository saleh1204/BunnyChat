<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Message
 *
 * @author Saleh
 */
class Message {
    //put your code here
    public $sender;
    public $receiver;
    public $msg;
    public $msgID;

    function __construct($sender, $receiver, $message, $messageID) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->msg = $message;
        $this->msgID = $messageID;
        
    }

    function getSender() {
        return $this->sender;
    }

    function getReceiver() {
        return $this->receiver;
    }

    function getMessage() {
        return $this->msg;
    }

}
