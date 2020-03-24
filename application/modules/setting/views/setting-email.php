<div class="content max-sm-container">
	<div class="content-header">
		<h2 class="content-title text-center">Setting</h2>
		<?php echo $message; ?>
	</div>
	<div class="content-body">
		<form class="card" method="post" enctype="multipart/form-data">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h4 class="card-title">
					Setting <?php echo ucwords($module_name); ?>
				</h4>
			</div>
			<?php echo $errors; ?>
			<div class="card-body">
				<div class="form-group row">
					<label for="mail_sender_name" class="col-sm-4 col-form-label">Sender Name</label>
					<div class="col-sm-8">
						<input name="mail_sender_name" value="<?php echo isset($post['mail_sender_name']) ? $post['mail_sender_name'] : '' ?>" type="text" id="mail_sender_name" class="form-control" placeholder="Sender Name" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="mail_sender_email" class="col-sm-4 col-form-label">Sender Email</label>
					<div class="col-sm-8">
						<input name="mail_sender_email" value="<?php echo isset($post['mail_sender_email']) ? $post['mail_sender_email'] : '' ?>" type="email" id="mail_sender_email" class="form-control" placeholder="Sender Email" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="mail_smtp_host" class="col-sm-4 col-form-label">SMTP Host</label>
					<div class="col-sm-8">
						<input name="mail_smtp_host" value="<?php echo isset($post['mail_smtp_host']) ? $post['mail_smtp_host'] : '' ?>" type="text" id="mail_smtp_host" class="form-control" placeholder="SMTP Host" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="mail_smtp_port" class="col-sm-4 col-form-label">SMTP Port</label>
					<div class="col-sm-8">
						<input name="mail_smtp_port" value="<?php echo isset($post['mail_smtp_port']) ? $post['mail_smtp_port'] : '' ?>" type="number" id="mail_smtp_port" class="form-control" placeholder="SMTP Port" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="mail_smtp_user" class="col-sm-4 col-form-label">SMTP User</label>
					<div class="col-sm-8">
						<input name="mail_smtp_user" value="<?php echo isset($post['mail_smtp_user']) ? $post['mail_smtp_user'] : '' ?>" type="email" id="mail_smtp_user" class="form-control" placeholder="SMTP User" required="required"/>
					</div>
				</div>
				<div class="form-group row">
					<label for="mail_smtp_pass" class="col-sm-4 col-form-label">SMTP Password</label>
					<div class="col-sm-8">
						<input name="mail_smtp_pass" value="<?php echo isset($post['mail_smtp_pass']) ? $post['mail_smtp_pass'] : '' ?>" type="password" id="mail_smtp_pass" class="form-control" placeholder="SMTP Password" required="required"/>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-primary" type="submit">Save Change</button>
			</div>
		</form>
		<form class="card" method="post" enctype="multipart/form-data">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h4 class="card-title">
					Email Test
				</h4>
			</div>
			<div class="alert alert-success hide">
				<button type="button" class="close">
					<span aria-hidden="true">×</span><span class="sr-only">Close</span>
				</button>
				<p class="mb-0 message">Data setting berhasil diubah.</p>
			</div>
			<div class="card-body">
				<div class="form-group row">
					<label for="email_test" class="col-sm-4 col-form-label">Email Test</label>
					<div class="col-sm-8">
						<input name="email_test" value="<?php echo isset($post['email_test']) ? $post['email_test'] : '' ?>" type="email" id="email_test" class="form-control" placeholder="Email Test" required="required"/>
					</div>
				</div>
			</div>
			<div class="card-footer text-right">
				<button class="btn btn-primary" type="submit">Send Test EMail</button>
			</div>
		</form>
	</div>
</div>