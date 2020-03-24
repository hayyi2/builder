<div class="content max-xl-container">
	<div class="content-header">
		<h2 class="content-title text-center">Master <?php echo ucwords($module_name); ?></h2>
		<?php echo $message; ?>
		<?php echo $errors; ?>
	</div>
	<div class="content-body">
		<div class="card">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h4 class="card-title">Data <?php echo ucwords($module_name); ?></h4>
				<div class="header-action">
					<?php if (isset($filter_view)) $this->load->view($filter_view); ?>
					<a href="<?php echo $group, $module_main; ?>/input" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle fa-fw mr-1"></i>Add New</a>
				</div>
			</div>
			<table class="table table-sm table-striped table-hover datatables-noorder-last">
				<thead>
					<tr>
						<th width="5" class="text-nowrap">No</th>
						<th>Username</th>
						<th>Name</th>
						<th>Email</th>
						<th>Kapabilitas</th>
						<th>Last Login</th>
						<th class="text-nowrap" width="1">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $id => $item): ?>
						<tr>
							<td class="text-nowrap"><?php echo ($id + 1); ?>.</td>
							<td><?php echo $item['username']; ?></td>
							<td><?php echo $item['name']; ?></td>
							<td><?php echo $item['email']; ?></td>
							<td><?php echo ucwords($item['capability']); ?></td>
							<td>
								<span class="hide"><?php echo $item['last_login']; ?></span>
								<div class="badge badge-<?php echo $item['active'] === 'active' ? 'primary' : 'secondary' ?> mr-2"><?php echo $item['login_count']; ?></div>
								<?php echo datetime_html($item['last_login']); ?>
							</td>
							<td class="text-nowrap">
								<a href="<?php echo $group, $module_main, '/duplicate/', $item['user_id']; ?>" class="text-muted"><i class="far fa-copy fa-fw"></i></a>
								<a href="<?php echo $group, $module_main, '/edit/', $item['user_id']; ?>"><i class="fas fa-pencil-alt fa-fw"></i></a>
								<?php if ($id > 0 && $item['user_id'] !== current_user_session('user_id')): ?>
									<a href="<?php echo $group, $module_main, '/delete/', $item['user_id']; ?>" confirm="Apakah anda yakin akan menghapus data?" class="text-danger"><i class="fas fa-trash-alt fa-fw"></i></a>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>