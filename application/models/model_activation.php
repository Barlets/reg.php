<?php

	class Model_Activation extends Model
	{

		protected $code;

		public function get_data($data)
		{
			$this->code = $data[3];
			if (!empty ($this->code)) {
				$query = "SELECT id FROM `users` 
							 WHERE activation_code='$this->code' 
							 AND status = 0";
				$result = $this->connection->query($query);
				$result->fetch_all();

				if ($result) {
					$query = "UPDATE `users` SET status = 1, activation_code = NULL
						  WHERE activation_code='$this->code'";
					$this->connection->query($query);
					if ($this->connection->affected_rows) {
						return array('msg' => 'Вы успешно активировали аккаунт, <a href=\'/login\'>залогиньтесь</a>');
					} else {
						return array('msg' => 'Не верный код активации');
					}

				}
			}
		}


	}