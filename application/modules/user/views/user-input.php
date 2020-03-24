<div class="content max-sm-container">
	<div class="content-header">
		<h2 class="content-title text-center">Master <?php echo ucwords($module_name); ?></h2>
		<?php echo $message; ?>
	</div>
	<div class="content-body">
		<form class="card" method="post" enctype="multipart/form-data">
			<div class="card-header">
				<h4 class="card-title">
					<a href="<?php echo $group.$module_main; ?>" class="text-muted"><i class="fa fa-angle-left mr-2"></i></a>
					<?php echo ($mode_add === true ? 'Input ' : 'Edit ') . ucwords($module_name); ?>
				</h4>
				<?php if ($mode_add === false): ?>
					<div class="header-button">
						<a href="<?php echo $group, $module_main, '/duplicate/', current($post); ?>" class="btn btn-sm btn-secondary"><i class="fas fa-copy fa-fw mr-1"></i>Duplicate</a>
						<a href="<?php echo $group, $module_main; ?>/input" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle fa-fw mr-1"></i>Add New</a>
					</div>
				<?php endif ?>
			</div>
			<?php echo $errors; ?>
			<div class="card-body">
				<div class="form-group row">
					<label for="name" class="col-sm-4 col-form-label">Name</label>
					<div class="col-sm-8">
						<input name="name" value="<?php echo isset($post['name']) ? $post['name'] : '' ?>" type="text" id="name" class="form-control" placeholder="Name" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="username" class="col-sm-4 col-form-label">Username</label>
					<div class="col-sm-8">
						<input name="username" value="<?php echo isset($post['username']) ? $post['username'] : '' ?>" type="text" id="username" class="form-control" placeholder="Username" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="email" class="col-sm-4 col-form-label">Email</label>
					<div class="col-sm-8">
						<input name="email" value="<?php echo isset($post['email']) ? $post['email'] : '' ?>" type="email" id="email" class="form-control" placeholder="Email" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="capability" class="col-sm-4 col-form-label">Capability</label>
					<div class="col-sm-8">
						<select name="capability" id="capability" class="form-control">
							<?php foreach ($capability as $key => $value): ?>
							<option value="<?php echo $value; ?>" <?php if (isset($post['capability']) && $post['capability'] === $value) echo ' selected=""'; ?>><?php echo ucfirst($value); ?></option>
							<?php endforeach ?>
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label for="active" class="col-sm-4 col-form-label">User Active</label>
					<div class="col-sm-6">
						<div class="row">
							<?php foreach ($active as $key => $value): ?>
							<div class="col">
								<div class="form-check mt-2">
									<input<?php if (isset($post['active']) && $post['active'] === $value) echo ' checked=""'; ?> name="active" value="<?php echo $value; ?>" id="<?php echo 'active'.$value; ?>" type="radio" class="form-check-input" required="required"/>
									<label class="form-check-label" for="<?php echo 'active'.$value; ?>">
										<?php echo ucfirst($value); ?>
									</label>
								</div>
							</div>
							<?php endforeach ?>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<label for="password" class="col-sm-4 col-form-label">Password</label>
					<div class="col-sm-8">
						<input name="password" value="" type="password" id="password" class="form-control" placeholder="Password"/>
						<?php if ($mode_add === false): ?>
							<small class="form-text text-muted">Konsongkan jika tidak di rubah.</small>
						<?php endif ?>
					</div>
				</div>
				<div class="form-group row">
					<label for="repeat_password" class="col-sm-4 col-form-label">Repeat Password</label>
					<div class="col-sm-8">
						<input name="repeat_password" value="" type="password" id="repeat_password" class="form-control" placeholder="Repeat Password"/>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-primary" type="submit"><?php echo ($mode_add === true ? 'Input ' : 'Edit ') . ucwords($module_name); ?></button>
			</div>
		</form>
	</div>
</div>
