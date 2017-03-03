<?php
/*
|----------------------------------------------|
|  FlockJob - Find Tech Jobs Easier            |
|----------------------------------------------|
|                                              |
|  Author:  Chris Richards                     |
|  Started: Wednesday 22nd Febuary 2017 4:24PM |
|                                              |
|----------------------------------------------|
*/

//
//  Dependencies
//
require_once 'src/Mustache/Autoloader.php';
require_once 'connection.php';

//
//  Initiate Mustache
//
Mustache_Autoloader::register();

//
//  Initiate Session
//
session_start();

//
//  Handle Page Request
//
if (isset($_GET['controller']) && isset($_GET['action'])) {
  $controller = $_GET['controller'];
  $action     = $_GET['action'];
} else {
  $controller = 'pages';
  $action     = 'home';
}

//
//  Display Page Layout
//
require_once 'views/layout.php';
?>