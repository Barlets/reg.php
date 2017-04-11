<?php

	//FRONT CONTROLLER

	//1. General settings
	ini_set('display_errors', 1);
	error_reporting(E_ALL);

	//2. Connection file system
	define('ROOT', dirname(__FILE__));
	define('SERVER', $_SERVER['SERVER_NAME']);
	require_once(ROOT . '/application/index.php');
	session_start();

	//4. Call router

	$router = new Router();
	$router->start();