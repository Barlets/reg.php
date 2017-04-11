<?php

	class Controller_Profile extends Controller
	{
		public $data;
		public $error;
		protected $login;
		protected $email;
		protected $password;
		protected $avatar;

		public function __construct()
		{
			$this->model = new Model_Profile();
			$this->view = new View();
			if (isset($_SESSION['logged_user'])) {
				$this->data = $this->model->get_data($_SESSION['logged_user']);
				$this->login = $this->data['login'];
				$this->email = $this->data['email'];
				$this->password = $this->data['password'];
				$this->avatar = $this->data['avatar'];
			} else {
				header('Location: /');
			}
		}

		public function action_index()
		{
			$this->error = $this->model->update_user_data($_POST, $this->password);
			$this->data = $this->model->get_data($_SESSION['logged_user']);

			$this->view->generate('profile_view.php', 'template_view.php', $this->data, $this->error);
		}

		public function action_avatar()
		{
			$this->error = $this->model->avatar_check($_FILES);
			$this->data = $this->model->get_data($_SESSION['logged_user']);


			$this->view->generate('avatar_view.php', 'popup_view.php', $this->data, $this->error);
		}

	}

