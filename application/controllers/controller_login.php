<?php

	class Controller_Login extends Controller
	{


		public function __construct()
		{
			$this->model = new Model_Login();
			$this->view = new View();

		}

		public function action_index()
		{
			$error = $this->model->login_error_check($_POST);
			$data = $this->model->login_user($error);

			$this->view->generate('login_view.php', 'template_view.php', $data, $error);
		}
	}

