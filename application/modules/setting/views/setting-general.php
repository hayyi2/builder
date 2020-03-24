<div class="content max-sm-container">
	<div class="content-header">
		<h2 class="content-title text-center"><?php echo ucwords($setting_label); ?></h2>
		<?php echo $message; ?>
	</div>
	<div class="content-body">
		<form class="card" method="post" enctype="multipart/form-data">
			<div class="card-header">
				<h4 class="card-title"><?php echo ucwords($setting_label.' '.$module_name); ?></h4>
			</div>
			<?php echo $errors; ?>
			<div class="card-body">
				<div class="form-group row">
					<label for="app_name" class="col-sm-4 col-form-label">App Name</label>
					<div class="col-sm-8">
						<input name="app_name" value="<?php echo isset($post['app_name']) ? $post['app_name'] : '' ?>" type="text" id="app_name" class="form-control" placeholder="App Name" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="app_desc" class="col-sm-4 col-form-label">App Desciption</label>
					<div class="col-sm-8">
						<textarea name="app_desc" id="app_desc" class="form-control" placeholder="App Desciption"><?php echo isset($post['app_desc']) ? $post['app_desc'] : '' ?></textarea>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-primary" type="submit">Save Change</button>
			</div>
		</form>
	</div>
</div>
