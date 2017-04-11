<?php

	class Controller_Activation extends Controller
	{
		public function __construct()
		{
			$this->model = new Model_Activation();
			$this->view = new View();
		}

		public function action_user()
		{
			$data = explode('/', $_SERVER['REQUEST_URI']);
			$error = $this->model->get_data($data);

			$this->view->generate('activation_view.php', 'template_view.php', $error);
		}
	}