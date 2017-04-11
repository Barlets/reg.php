<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3>Личные данные:</h3>

				<div class="col-md-3 col-sm-5 col-xs-6">
					<div class="hovereffect">
						<img class="img-responsive" src="<?= (!empty($data['avatar']) ? $data['avatar'] : '') ?>">
						<div class="overlay">
							<a class="info various" href="/profile/avatar" data-fancybox-type="iframe">Изменить</a>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-7 col-xs-6">

					<p>Логин: <?= (!empty($data['login']) ? $data['login'] : '') ?></p>
					<form action="" method="post">
						<p>Новый логин:
							<input type="text" name="new_login" placeholder="Введите новый логин">
						<p class="error"><?= (!empty($error['login_error']) ? $error['login_error'] : '') ?></p>
						</p>

						<p>
							<button name="submit_login" class="btn btn-default">Сохранить</button>
						</p>
					</form>

					<p>E-mail: <?= (!empty($data['email']) ? $data['email'] : '') ?></p>
					<form action="" method="post">
						<p>Новый email:
							<input type="text" name="new_email" placeholder="Введите новый email">
						<p class="error"><?= (!empty($error['email_error']) ? $error['email_error'] : '') ?></p>
						</p>

						<p>
							<button name="submit_email" class="btn btn-default">Сохранить</button>
						</p>
					</form>

					<p>Пароль:</p>
					<form action="" method="post">
						<p>Текущий пароль:
							<input type="password" name="password" placeholder="Введите текущий пароль">
						<p class="error"><?= (!empty($error['password_error']) ? $error['password_error'] : '') ?></p>
						</p>
						<p>Новый пароль:
							<input type="password" name="new_password" placeholder="Введите новый пароль">
						<p class="error"><?= (!empty($error['passwordr_error']) ? $error['passwordr_error'] : '') ?></p>
						</p>
						<p>
							<button name="submit_password" class="btn btn-default">Сохранить</button>
						</p>
					</form>

				</div>

			</div>
		</div>
	</div>
	</div>
</section>