<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'Request.php';
include 'AdminActions.php';
$request = new Request();
$cmd = $request->getCommand();
$action = new AdminActions();
$action->$cmd($request);
?>