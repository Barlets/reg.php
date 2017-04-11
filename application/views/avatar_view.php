<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6">

				<img src="<?= (!empty($data['avatar']) ? $data['avatar'] : '') ?>">
				<p></p>
				<form action="" method="post" enctype='multipart/form-data'>
					<p><input type="file" name="userfile" accept="image/*,image/jpeg,image/png"></p>
					<p><?= (!empty($error['msg']) ? $error['msg'] : '') ?> <?= (!empty($error['error']) ? $error['error'] : '') ?> </p>
					<p><input class="btn btn-default" type="submit" value="Загрузить"></p>

				</form>

			</div>
		</div>
	</div>
</section>