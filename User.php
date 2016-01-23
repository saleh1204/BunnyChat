<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Saleh
 */
class User {

    //put your code here
    public $username;
    public $email;
    public $gender;
    public $admin;

    function __construct($username, $email, $gender, $admin) {
        $this->username = $username;
        $this->email = $email;
        $this->gender = $gender;
        $this->admin = $admin;
    }

    function getUsername() {
        return $this->username;
    }

    function getEmail() {
        return $this->email;
    }

    function getGender() {
        return $this->gender;
    }

    function getAdmin() {
        return $this->admin;
    }

}
