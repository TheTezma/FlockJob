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
require_once 'core/Utilities.php';
require_once 'core/Application.php';

//
//  Initiate Classes
//
Mustache_Autoloader::register();
$App = new Application;

//
//  Initiate Session
//
session_start();

// 
// 	Route Request To Correct Page
// 
$App->Route();
?>