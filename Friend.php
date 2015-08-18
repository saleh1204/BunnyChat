<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Friend
 *
 * @author Saleh
 */
class Friend {

    //put your code here
    public $friendName;

    function __construct($username) {
        $this->friendName = $username;
    }

    function getUsername() {
        return $this->friendName;
    }

}
