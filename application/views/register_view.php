<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h2>Регистрация</h2>
				<form action="" method="post">
					<p>Логин:</p>
					<p><input type="text" name="login" value="<?= (!empty($_REQUEST['login']) ? $_REQUEST['login'] : '') ?>"
								 placeholder="Введите логин"></p>
					<p class="error"><?= (!empty($error['login']) ? $error['login'] : '') ?></p>
					<p>E-mail:</p>
					<p><input type="email" name="email" value="<?= (!empty($_REQUEST['email']) ? $_REQUEST['email'] : '') ?>"
								 placeholder="Введите e-mail"></p>
					<p class="error"><?= (!empty($error['email']) ? $error['email'] : '') ?></p>
					<p>Пароль:</p>
					<p><input type="password" name="password" placeholder="Введите пароль"></p>
					<p class="error"><?= (!empty($error['password']) ? $error['password'] : '') ?></p>
					<p><input type="password" name="password_r" placeholder="Введите пароль ещё раз"></p>
					<p class="error"><?= (!empty($error['password_r']) ? $error['password_r'] : '') ?></p>
					<p>
						<button name="submit" class="btn btn-primary">Зарегистрироваться</button>
					</p>
					<p><?= (!empty($data['msg']) ? $data['msg'] : '') ?></p>
				</form>
			</div>
		</div>
	</div>
</section>



