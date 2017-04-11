<?php

	class Helper
	{
		public function login_check($login)
		{
			if (empty($login)) {
				return "Вы не заполнили поле логин";
			} elseif (!preg_match("/^[a-z0-9]{4,20}$/i", $login)) {
				return "Убедитесь что логин содержит от 4 до 20 символов, и состоит из латинских символов и цифр";
			}
		}

		public function password_check($password)
		{
			if (empty($password)) {
				return "Вы не заполнили поле пароль";
			} elseif (!preg_match("/^[a-z0-9]{3,10}$/i", $password)) {
				return "Убедитесь что пароль содержит от 3 до 10 символов, и состоит из латинских символов и цифр";
			}
		}

		public function password_r_check($password_r, $password)
		{
			if (empty($password_r)) {
				return "Вы не ввели пароль повторно";
			} elseif ($password != $password_r) {
				return "Поле пароль и его подтверждение не совпадают!";
			}
		}

		public function email_check($email)
		{
			if (empty($email)) {
				return "Вы не заполнили поле e-mail";
			} elseif (!preg_match("/^[-0-9a-z_\.]+@[-0-9a-z^\.]+\.[a-z]{2,4}$/i", $email)) {
				return "Не правильно заполнено поле E-Mail. E-mail должен иметь вид user@somehost.com";
			}
		}

		public function recaptha($recaptcha)
		{
			$url = "https://www.google.com/recaptcha/api/siteverify";
			$secret = "6LftqhIUAAAAAOfuGtIG_tutd1BPPt5skX6Bd7ZW";
			$ip = $_SERVER['REMOTE_ADDR'];
			$url_data = $url . '?secret=' . $secret . '&response=' . $recaptcha . '&remoteip=' . $ip;

			$curl = curl_init();
			$options = array(CURLOPT_URL            => $url_data,
			                 CURLOPT_SSL_VERIFYPEER => FALSE,
			                 CURLOPT_RETURNTRANSFER => 1,);
			curl_setopt_array($curl, $options);
			$result = curl_exec($curl);
			curl_close($curl);
			return $result = json_decode($result);
		}

		public function load_file_error_handler($errors)
		{
			//Проверяем на наличие ошибок
			if ($errors > 0) {
				try {
					switch ($errors) {
						case 1:
							throw new Exception("Размер файла больше допустимого " . ini_get('upload_max_filesize') . "в php.ini");
							break;
						case 2:
							throw new Exception("Размер файла больше допустимого");
							break;
						case 3:
							throw new Exception("Файл загружен не полностью");
							break;
						case 4:
							throw new Exception("Файл не был загружен");
							break;
						case 6:
							throw new Exception("Загрузка не возможна, не задан временный каталог");
							break;
						case 7:
							throw new Exception("Загрузка не выполнена, не возможна запись на диск");
					}
				} catch (Exception $ex) {
					return $ex->getMessage();
				}
			}

		}
	}