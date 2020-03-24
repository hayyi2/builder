<div class="content max-sm-container">
	<div class="content-header">
		<h2 class="content-title text-center">Profile</h2>
	</div>
	<div class="content-body">
		<?php echo $message; ?>
		<form class="card" method="post" enctype="multipart/form-data">
			<div class="card-header">
				<h4 class="card-title">Change Profile</h4>
			</div>
			<?php echo $errors; ?>
			<div class="card-body">
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="username">Username</label>
					<div class="col-sm-8">
						<input name="username" value="<?php if (isset($post['username'])) echo $post['username']; ?>" id="username" type="text" placeholder="Username" class="form-control" disabled="">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="name">Name</label>
					<div class="col-sm-8">
						<input name="name" value="<?php if (isset($post['name'])) echo $post['name']; ?>" id="name" type="text" class="form-control" placeholder="Name">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label" for="email">Email Address</label>
					<div class="col-sm-8">
						<input name="email" value="<?php if (isset($post['email'])) echo $post['email']; ?>" id="email" type="email" class="form-control" placeholder="Email Address">
					</div>
				</div>
				<hr>
				<div class="form-group row">
					<div class="col-sm-8 ml-auto">
						<div class="form-check">
							<label class="form-check-label">
								<input type="checkbox"<?php if (isset($post['change_password'])) echo ' checked=""'; ?> name="change_password" class="form-check-input" show-change="#change_password_box">
								Change Password
							</label>
						</div>
					</div>
				</div>
				<div id="change_password_box" class="<?php if(!isset($post['change_password'])) echo 'hide' ?>">
					<div class="form-group row">
						<label class="col-sm-4 col-form-label" for="last_password">Last Password</label>
						<div class="col-sm-8">
							<input name="last_password" id="last_password" type="password" class="form-control" placeholder="Last Password">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label" for="password">New Password</label>
						<div class="col-sm-8">
							<input name="password" id="password" type="password" class="form-control" placeholder="Password">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label" for="repeat_password">Repeat Password</label>
						<div class="col-sm-8">
							<input name="repeat_password" id="repeat_password" type="password" class="form-control" placeholder="Repeat Password">
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-primary" type="submit">Save Change</button>
			</div>
		</form>
	</div>
</div>