<?php

	class Controller_Register extends Controller
	{
		public function __construct()
		{
			$this->model = new Model_Register();
			$this->view = new View();
		}

		public function action_index()
		{
			$error = $this->model->register_error_check($_POST);
			$data = $this->model->register_user($error);

			$this->view->generate('register_view.php', 'template_view.php', $data, $error);

		}
	}
