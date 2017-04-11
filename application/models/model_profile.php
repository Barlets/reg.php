<?php

	class Model_Profile extends Model
	{
		protected $login;

		public function get_data($data)
		{
			$this->login = $data;
			$query = "SELECT id, login, email, password, avatar FROM `users` 
						  WHERE `login` = '$this->login'";
			$result = $this->connection->query($query);
			return $result->fetch_assoc();
		}

		public function change_avatar($file_name)
		{
			$query = "UPDATE `users` SET avatar = '/images/$file_name'
							WHERE `login` = '$this->login'";
			return $this->connection->query($query);
		}

		public function change_login($new_login)
		{
			$query = "UPDATE `users` SET login = '$new_login'
							WHERE login = '$this->login'";
			return $this->connection->query($query);
		}

		public function change_email($new_email, $activation_code)
		{
			$query = "UPDATE `users` SET email = '$new_email', activation_code = '$activation_code'
							WHERE login = '$this->login'";
			return $this->connection->query($query);
		}

		public function change_password($new_password)
		{
			$query = "UPDATE `users` SET password = '$new_password'
							WHERE login = '$this->login'";
			return $this->connection->query($query);
		}

		public function update_user_data($data, $password)
		{
			//Проверяем, была ли нажата кнопка "сохранить"
			if (isset($data['submit_login'])) {
				$new_login = $data['new_login'];
				//Проверяем, был ли введен новый логин
				if (empty($new_login)) {
					return array('login_error' => 'Вы не ввели новый логин');
					//Проверяем валидность нового логина
				} elseif (!preg_match("/^[a-z0-9]{4,20}$/i", $new_login)) {
					return array('login_error' => 'Убедитесь что логин содержит от 4 до 20 символов, и состоит из латинских символов и цифр');
				} else {
					//Всё ок, меняем логин пользователя
					if ($this->change_login($new_login)) {
						$_SESSION['logged_user'] = $new_login;
						$_COOKIE['name'] = $new_login;
						return array('login_error' => 'Логин успешно изменен');
					} else {
						return array('login_error' => 'Произошла ошибка при изменении логина');
					}
				}
			}
			//Проверяем, была ли нажата кнопка "сохранить"
			if (isset($data['submit_email'])) {
				$new_email = $data['new_email'];
				//Проверяем, был ли введен новый email
				if (empty($new_email)) {
					return array('email_error' => 'Вы не ввели новый email');
					//Проверяем валидность нового email
				} elseif (!preg_match("/^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,4}$/i", $new_email)) {
					return array('email_error' => 'Не правильно заполнено поле E-Mail. E-mail должен иметь вид user@somehost.com');
				} else {
					$activation = md5($new_email . time());
					if ($this->change_email($new_email, $activation)) {
						$headers = "MIME-Version: 1.0\r\n";
						$headers .= "Content-type: text/html; charset=utf-8\r\n";
						$to = $new_email;
						$subject = "Проверка e-mail";
						$body = "
				<html>
					<head>
 						<title>Подтвердите смену email</title>
 					</head>
 					<body>
						<p>Для подтверждения нового email, перейдите по ссылке: <br><br>
						<a href=" . SERVER . '/activation/user/' . $activation . ">http://" . SERVER . "/activation/user/$activation</a>
						</p>
					</body>
				</html>";
						//Отправляем письмо для активации
						$result = mail($to, $subject, $body, $headers);
						if ($result) {
							return array('email_error' => 'Email изменен. На почту было отравлено письмо для подтверждения и активации');
						}
					} else {
						return array('email_error' => 'Произошла ошибка при изменении email');
					}
				}
			}
			//Проверяем, была ли нажата кнопка "сохранить"
			if (isset($data['submit_password'])) {
				if (empty($data['password'])) {
					return array('password_error' => 'Вы не ввели текущий пароль');
				}
				$new_password = $data['new_password'];
				if (empty($new_password)) {
					//Проверяем, был ли введен новый пароль
					return array('passwordr_error' => 'Вы не ввели новый пароль');
					//Проверяем валидность нового пароля
				} elseif (!preg_match("/^[a-z0-9]{3,10}$/i", $new_password)) {
					return array('passwordr_error' => 'Убедитесь что пароль содержит от 3 до 10 символов, и состоит из латинских символов и цифр');
				} else {
					//Проверяем правильность текущего пароля
					if (password_verify($data['password'], $password)) {
						$options = [
							 'cost' => 10];
						$password = password_hash($new_password, PASSWORD_DEFAULT, $options);
						if ($this->change_password($password)) {
							return array('passwordr_error' => 'Пароль успешно изменен');
						} else {
							return array('passwordr_error' => 'Пароли не совпадают');
						}
					} else {
						return array('password_error' => 'Текущий пароль введен не верно');
					}
				}
			}
			return true;
		}

		public function avatar_check($data)
		{
			if ($data) {
				$file_tmp_name = $data['userfile']['tmp_name'];
				//Проверяем, действительно ли файл был загружен по HTTP методом POST
				if (is_uploaded_file($file_tmp_name)) {
					$errors = $data['userfile']['error'];
					$file_type = $data['userfile']['type'];
					$file_size = $data['userfile']['size'];
					$ext = explode('/', $file_type);
					$file_name = time() . '.' . $ext[1];
					$max_file_size = 256 * 1000;
					$max_image_width = 200;
					$max_image_height = 200;
					$upload_dir = 'images/' . $file_name;
					$size = getimagesize($file_tmp_name);
					$error = $this->load_file_error_handler($errors);

					if (empty($error)) {
						//Проверяем тип загружаемого файла
						if ($file_type != 'image/jpeg' && $file_type != 'image/png') {
							return array('error' => "Данный файл не является изображением. Допустимые форматы jpg и png");
						} //Проверяем размер файла
						elseif ($file_size > $max_file_size) {
							return array('error' => "Превышен размер файла");
						} //Проверяем разрешение изображения
						elseif (($size) && ($size[0] > $max_image_width) && $size[1] > $max_image_height) {
							return array('error' => "Максимальное разрешение изображения $max_image_height x $max_image_width");
						} //Проверяем, был ли перемещён файл в папку
						elseif (!move_uploaded_file($file_tmp_name, $upload_dir)) {
							return array('error' => "Не возможно переместить файл в каталог назначения");
						} else {
							//Обновляем аватарку пользователя в БД
							$new_avatar = $this->change_avatar($file_name);
							if ($new_avatar) {
								return array('msg' => "Вы изменили аватарку, обновите страницу");
							}
						}
					} else {
						return $error;
					}
				} else {
					return array('msg' => "Возможно атака через загрузку файла");
				}

			} else {
				return array('msg' => "Выберите файл и нажмите загрузить.<br>Максимальный размер файла 256 Кб");
			}
		}

	}
