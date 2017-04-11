<?php

	class Db
	{

		public static function getConnection()
		{
			$paramsPath = 'application/config/db_parameters.php';
			$params = include($paramsPath);

			$connection = mysqli_connect($params['host'], $params['user'], $params['password'], $params['dbname']);

			if (mysqli_connect_errno()) {
				echo 'Failed to connect MySQL: ' . mysqli_connect_errno();
			}
			return $connection;
		}
	}