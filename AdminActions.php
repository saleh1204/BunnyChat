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

class AdminActions {

    //put your code here

    public function Admin($request) {

        $dao = new ChatDAO();
        $username = $request->get("username");
        $query = "update login set Admin=1 where username='" . $username . "'";
        $dao->excuteQuery($query);
        $ulist = json_encode($dao->getUsers());
        echo $ulist;
    }

    public function Delete($request) {
        $dao = new ChatDAO();
        $username = $request->get("username");
        $query = "delete from login where username='" . $username . "'";
        $dao->excuteQuery($query);
        $ulist = json_encode($dao->getUsers());
        echo $ulist;
    }

    public function execute($request) {
        //$this->Admin($request);
        //Admin($request);
    }

}
