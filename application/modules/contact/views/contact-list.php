<div class="content max-xl-container">
	<div class="content-header">
		<h2 class="content-title text-center">Master <?php echo ucwords($module_name); ?></h2>
		<?php echo $message; ?>
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
			<?php echo $errors; ?>
			<table class="table table-sm table-striped table-hover datatables-noorder-last">
				<thead>
					<tr>
						<th width="5" class="text-nowrap">No</th>
						<th>Name</th>
						<th>Email</th>
						<th>Address</th>
						<th>Author</th>
						<th>Created</th>
						<th width="1" class="text-nowrap">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $no => $item): $id = current($item);?>
						<tr>
							<td class="text-nowrap"><?php echo ($no + 1); ?>.</td>
							<td><?php echo $item['name']; ?></td>
							<td><?php echo $item['email']; ?></td>
							<td><?php echo $item['address']; ?></td>
							<td><?php echo $item['author_name']; ?></td>
							<td>
								<span class="hide"><?php echo $item['created_at']; ?></span>
								<?php echo datetime_html($item['created_at']); ?>
							</td>
							<td class="text-nowrap">
								<a href="<?php echo $group, $module_main, '/duplicate/', $id; ?>" class="text-muted"><i class="far fa-copy fa-fw"></i></a>
								<a href="<?php echo $group, $module_main, '/edit/', $id; ?>"><i class="fas fa-pencil-alt fa-fw"></i></a>
								<?php if (protected_item($user_group['admin_master'])): ?>
									<a href="<?php echo $group, $module_main, '/delete/', $id; ?>" confirm="Apakah anda yakin akan menghapus data?" class="text-danger"><i class="fas fa-trash-alt fa-fw"></i></a>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
