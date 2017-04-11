<?php

	class Controller_Main extends Controller
	{

		function action_index()
		{
			$data = array();
			if (isset($_COOKIE['name']) && isset($_SESSION['logged_user'])) {
				$data[] = '<h3>Авторизован! Привет ' . $_SESSION['logged_user'] . '</h3>';
				$data[] = '<p><a href="/profile" class="btn btn-default">Личный кабинет</a></p>';
				$data[] = '<p><a href="/logout" class="btn btn-default">Выйти</a></p>';
			} else {
				$data[] = '<h3>Вы не авторизованы!</h3>';
				$data[] = '<p><a href="/login" class="btn btn-default">Войти</a></p>';
				$data[] = '<p><a href="/register" class="btn btn-default">Зарегистрироваться</a></p>';
			}
			$this->view->generate('main_view.php', 'template_view.php', $data);
		}

	}