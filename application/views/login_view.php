<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6">

				<h2>Авторизация</h2>

				<form action="" method="post">
				<p>Логин:</p>
				<p><input type="text" name="login" id="login" placeholder="Введите логин"
							 value="<?= (!empty($_REQUEST['login']) ? $_REQUEST['login'] : '') ?>"</p>
				<p class="error"><?= (!empty($error['login']) ? $error['login'] : '') ?></p>
				<p>Пароль:</p>
				<p><input type="password" name="password" id="password" placeholder="Введите пароль"></p>
				<p class="error"><?= (!empty($error['password']) ? $error['password'] : '') ?></p>
				<div class="g-recaptcha" data-sitekey="6LftqhIUAAAAAPsHQ7tjjTlI8dgXn7nhx0_bX8HA"></div>
				<p class="error"><?= (!empty($error['capthca']) ? $error['capthca'] : '') ?></p>
				<p>
					<button class="btn btn-primary" name="submit" id="submit">Войти</button>
					<input type="checkbox" name="remember_me">
					<label for="remember_me">Запомнить меня</label>
				</p>

				<p><?= (!empty($data['msg']) ? $data['msg'] : '') ?></p>
				</form>

			</div>
		</div>
	</div>
</section>

