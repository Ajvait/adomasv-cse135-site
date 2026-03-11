<?php

session_start();

function requireLogin(){

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

}

function requireRole($role){

    if(!isset($_SESSION['user'])){
        header("Location: login.php");
        exit();
    }

    if($_SESSION['role'] != $role && $_SESSION['role'] != "super_admin"){
        echo "Access denied.";
        exit();
    }

}

?>