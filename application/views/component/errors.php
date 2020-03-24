<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">
		<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
	</button>
	<?php foreach ($errors as $error): ?>
		<p class="mb-0 message"><?php echo $error; ?></p>
	<?php endforeach ?>
</div>