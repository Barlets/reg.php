<?php

	class Model_Register extends Model
	{
		protected $data;
		protected $activation;
		protected $login;
		protected $email;
		protected $password;
		protected $password_r;

		public function register_error_check($data)
		{
			$this->data = $data;
			if (isset($data['submit'])) {
				$this->login = trim(htmlspecialchars($data['login']));
				$this->email = trim($data['email']);
				$this->password = trim($data['password']);
				$this->password_r = trim($data['password_r']);
				$error = array();
				//Проверяем наличие и валидность логина
				if ($result = $this->login_check($this->login)) {
					$error['login'] = $result;
				} //Проверяем наличие и валидность email
				if ($result = $this->email_check($this->email)) {
					$error['email'] = $result;
				} //Проверяем наличие и валидность пароля
				if ($result = $this->password_check($this->password)) {
					$error['password'] = $result;
				} //Проверяем введенный повторно пароль
				if ($result = $this->password_r_check($this->password_r, $this->password)) {
					$error['password_r'] = $result;
				}
				return $error;
			}
		}

		public function register_user($data)
		{
			if (isset($_REQUEST['submit'])) {
				if (empty($data)) {
					//Проверяем наличие пользователя в БД
					$result = $this->get_data($this->login);
					if ($result) {
						return array('msg' => "Извините, введённый вами логин уже зарегистрирован.<a href='/register'> Введите другой логин</a>.");
						} else {
						//Выполняем SQL-запрос записывающий данные пользователя в таблицу.
						$register = $this->new_user();
						if ($register) {
							//Отправляем письмо для активации
							$this->activation_user();
							return array('msg' => "Вы успешно зарегистрировались! На почту было отправлено письмо для активации.");
						}
					}
				}
			}
		}

		public function get_data($login)
		{
			$query = "SELECT id FROM `users` 
						  WHERE `login`='$login'
						  AND `status` = 1";
			$result = $this->connection->query($query);
			return $num = $result->num_rows;
		}

		public function new_user()
		{
			$activation = $this->activation = md5($this->email . time());
			$options = [
				 'cost' => 10,
			];
			$password = password_hash($this->password, PASSWORD_DEFAULT, $options);

			$query = 'INSERT INTO `users` (`login`, `email`, `password`, `activation_code`) 
						  VALUES ("' . $this->login . '", "' . $this->email . '", "' . $password . '", "' . $activation . '")';
			return $result = $this->connection->query($query);
		}

		public function activation_user()
		{
			$query = 'SELECT * FROM `users` 
						  WHERE `email` = "' . $this->email . '" 
						  AND `status` = 0';
			$result = $this->connection->query($query);
			$num = $result->field_count;

			if ($num > 0) {
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=utf-8\r\n";
				$to = $this->email;
				$subject = "Проверка e-mail";
				$body = "
				<html>
					<head>
 						<title>Активируйте ваш аккаунт</title>
 					</head>
 					<body>
						<p>Для активации вашего аккаунта, перейдите по ссылке: <br><br>
						<a href=" . SERVER . '/activation/user/' . $this->activation . ">http://" . SERVER . "/activation/user/$this->activation</a>
						</p>
					</body>
				</html>";
				return $result = mail($to, $subject, $body, $headers);
			}
		}


	}