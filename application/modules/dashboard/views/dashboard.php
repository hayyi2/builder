<div class="content max-xl-container">
	<div class="content-header">
		<h2 class="content-title text-center">Dashboard</h2>
		<?php echo $message; ?>
	</div>
	<div class="content-body">
		<div class="row">
			<div class="col-sm-9">
				<div class="row">
					<div class="col-md-6">
						<div class="card card-count card-primary">
							<div class="card-header">
								<div>
									<h4 class="h1 card-title"><?php echo $count_entry; ?></h4>
									<span>Data Entries</span>
								</div>
								<i class="fas fa-fw fa-file-alt fa-5x"></i>
							</div>
							<div class="card-footer">
								<a href="<?php echo($group.'master') ?>" class="btn-block">
									Read More
									<i class="float-right mt-1 fa fa-fw fa-arrow-alt-circle-right"></i>
								</a>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="card card-count card-success">
							<div class="card-header">
								<div>
									<h4 class="h1 card-title"><?php echo $count_master; ?></h4>
									<span>Data Master</span>
								</div>
								<i class="fas fa-fw fa-database fa-5x"></i>
							</div>
							<div class="card-footer">
								<a href="<?php echo($group.'master') ?>" class="btn-block">
									Read More
									<i class="float-right mt-1 fa fa-fw fa-arrow-alt-circle-right"></i>
								</a>
							</div>
						</div>
						<!-- /.card -->
					</div>
				</div>
				<!-- /.card -->
				<?php if (isset($data_form)): ?>
					<div class="card mb-3">
						<div class="card-header d-flex justify-content-between align-items-center">
							<h4 class="card-title">Data <?php echo $data_form['form_title']; ?></h4>
							<div>
								<a href="master/data/list/<?php echo $data_form['form_id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-eye"></i> View Data</a>
								<a href="master/data/add/<?php echo $data_form['form_id']; ?>" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-plus-circle"></i> Add New</a>
							</div>
						</div>
						<table class="table table-sm table-striped table-hover mb-0 datatables">
							<thead>
								<tr>
									<th width="5" class="text-nowrap">
										No
									</th>
									<?php foreach ($list_field as $key => $item): ?>
										<th class="text-nowrap"><?php echo $item; ?></th>
									<?php endforeach ?>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($data as $no => $item): $id = current($item); ?>
									<tr>
										<td class="text-nowrap">
											<?php echo ($no + 1) ?>. 
										</td>
										<?php foreach ($list_field as $key => $value): ?>
											<td><?php echo $item[$key]; ?></td>
										<?php endforeach ?>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				<?php else: ?>
					<div class="alert alert-warning" role="alert">
						Empty data.
					</div>
				<?php endif ?>
				<!-- /.card -->
			</div>
			<div class="col-sm-3">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">Jumlah Data Entry</h4>
					</div>
					<div class="card-body">
						<div class="canvas-wrapper">
							<canvas class="chart" id="doughnut-chart" height="300"></canvas>
						</div>
					</div>
					<?php 
						$data_color = array(
							'info' 		=> '#17a2b8',
							'danger' 	=> '#dc3545',
							'warning' 	=> '#ffc107',
							'success' 	=> '#28a745',
							'primary' 	=> '#007bff',
						);
						$key_color = array_keys($data_color);
						$value_color = array_values($data_color);
					?>
					<?php foreach ($data_master as $no => $item): ?>
						<div class="card-footer">
							<a href="<?php echo($group.'master/data/list/'.$item['form_id']) ?>" class="btn-block">
								<i class="fa fa-fw fa-arrow-alt-circle-right mr-1"></i><?php echo $item['form_title']; ?> 
								<span class="float-right mt-1 badge badge-<?php echo($key_color[$no%5]) ?>"><?php echo $item['count_entry']; ?></span>
							</a>
						</div>
					<?php endforeach ?>
				</div>
				<!-- /Doughnut Chart  -->
				<script>
					var custom_data = [
						<?php foreach ($data_master as $no => $item): ?>
							{
								value: <?php echo $item['count_entry']; ?>,
								color:"<?php echo($value_color[$no%5]) ?>",
								label: "<?php echo $item['form_title']; ?>"
							},
						<?php endforeach ?>
					];
					var chart3 = document.getElementById("doughnut-chart").getContext("2d");
					window.myDoughnut = new Chart(chart3).Doughnut(custom_data, {
						responsive: true,
						segmentShowStroke: false
					});
				</script>
			</div>
		</div>
		<!-- /.row -->
	</div>
</div>