<?php

	class Model extends Helper
	{
		protected $connection;


		function __construct()
		{
			$this->connection = Db::getConnection();
		}

		public function get_data($data)
		{

		}

	}