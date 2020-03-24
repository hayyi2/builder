<div class="content max-sm-container">
	<div class="content-header">
		<h2 class="content-title text-center">Profile</h2>
	</div>
	<div class="content-body">
		<?php echo $message; ?>
		<div class="card">
			<div class="card-header">
				<h4 class="card-title">Data Profile</h4>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Username</label>
					<div class="col-sm-8">
						<span class="form-control"><?php echo $data['username']; ?></span>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Name</label>
					<div class="col-sm-8">
						<span class="form-control"><?php echo $data['name']; ?></span>
					</div>
				</div>
				<div class="form-group row">
					<label for="staticEmail" class="col-sm-4 col-form-label">Email Address</label>
					<div class="col-sm-8">
						<span class="form-control"><?php echo $data['email']; ?></span>
					</div>
				</div>
				<hr>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Joined</label>
					<div class="col-sm-8">
						<span class="form-control"><?php echo date_html($data['created_at']); ?></span>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<a href="<?php echo $group; ?>user/change_profile" class="btn btn-primary">Change Profile</a>
			</div>
		</div>
	</div>
</div>