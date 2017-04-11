<?php

	class Controller_Logout extends Controller
	{

		public function action_index()
		{
			unset($_SESSION['logged_user']);
			setcookie('name', '');
			header('Location: /');
		}
	}
