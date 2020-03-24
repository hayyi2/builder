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
					<label for="email" class="col-sm-4 col-form-label">Email</label>
					<div class="col-sm-8">
						<input name="email" value="<?php echo isset($post['email']) ? $post['email'] : '' ?>" type="email" id="email" class="form-control" placeholder="Email" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="address" class="col-sm-4 col-form-label">Address</label>
					<div class="col-sm-8">
						<textarea name="address" id="address" class="form-control" placeholder="Address"><?php echo isset($post['address']) ? $post['address'] : '' ?></textarea>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-primary" type="submit"><?php echo ($mode_add === true ? 'Input ' : 'Edit ') . ucwords($module_name); ?></button>
			</div>
		</form>
	</div>
</div>
