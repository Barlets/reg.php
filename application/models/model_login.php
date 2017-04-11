<?php

	class Model_Login extends Model
	{
		private $data;
		private $login;
		private $password;

		public function get_data($login)
		{
			$query = "SELECT * FROM `users` 
						  WHERE login = '$login'
						  AND `status` = 1";
			$result = $this->connection->query($query);
			$count = $result->num_rows;

			if ($count < 1) {
				return false;
			} else {
				$user = $result->fetch_assoc();
				return $user['password'];
			}
		}

		public function login_error_check($data)
		{
			$this->data = $data;
			if (isset($this->data['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
				$this->login = trim(htmlspecialchars($this->data['login']));
				$this->password = trim($this->data['password']);
				$error = array();
				//Проверяем наличие и валидность логина
				if ($result = $this->login_check($this->login)) {
					$error['login'] = $result;
				}
				//Проверяем наличие и валидность пароля
				if ($result = $this->password_check($this->password)) {
					$error['password'] = $result;
				}
				//Проверяем капчу
				$captcha = $this->recaptha($this->data['g-recaptcha-response']);
				if (!$captcha->success) {
					$error['capthca'] = 'Вы не прошли проверку reCAPTCHA ';
				}
				return $error;
			}
		}

		public function login_user($data)
		{
			define('TRY_COUNT', 4);
			$counter = 1;
			if (empty($data) && isset($_POST['submit'])) {
				//Проверяем количество попыток входа и наличие блокировки пользователя
				if (!isset($_COOKIE['login_try']) || $_COOKIE['login_try'] < TRY_COUNT) {
					//Ищем пользователя в БД и возвращаем хэш его пароля
					$hash = $this->get_data($this->login);
					if (!$hash) {
						return array('msg' => "Пользователь не найден");
					} else {
						//Проверяем пароль
						if ($password = password_verify($this->password, $hash)) {
							//Проверка на существование чекбокса
							if (isset($this->data['remember_me'])) {
								setcookie('name', $this->login, time() + 60 * 60 * 24, '/');
								$_SESSION['logged_user'] = $this->login;
								header('Location: /');
							} else {
								setcookie('name', $this->login, time() + 60 * 30, '/');
								$_SESSION['logged_user'] = $this->login;
								header('Location: /');
							}
						} else {
							return array('msg' => "Пароль не совпадает с пользователем");
						}
					}
				} else {
					return array('msg' => "У вас не осталось попыток, попробуйте снова через 5 минут");
				}
			} else {
				//Проверяем количество попыток входа
				if (isset($_COOKIE['login_try'])) {
					while ($counter < TRY_COUNT) {
						$counter = $_COOKIE['login_try'];
						$counter++;
						$result = TRY_COUNT - $counter;
						setcookie('login_try', $counter, time() + 60 * 5);
						if ($result > 0) {
							return array('msg' => 'У вас осталось ' . $result . ' попыток входа');
						} else {
							return array('msg' => "У вас не осталось попыток, попробуйте снова через 5 минут");
						}
					}
				} else {
					setcookie('login_try', $counter, time() + 60 * 5);
				}
			}
		}

	}

