<div class="content max-sm-container">
	<div class="content-header">
		<h2 class="content-title text-center">Master <?php echo ucwords($module_name); ?></h2>
		<?php echo $message; ?>
		<?php echo $errors; ?>
	</div>
	<div class="content-body">
		<form class="card" method="post">
			<div class="card-header">
				<h4 class="card-title">Data <?php echo ucwords($module_name); ?></h4>
			</div>
			<table class="table table-sm table-striped table-hover mb-0">
				<thead>
					<tr>
						<th width="5" class="text-nowrap">No</th>
						<th><?php echo ucwords($module_name); ?></th>
						<th class="text-nowrap" width="1"></th>
					</tr>
				</thead>
				<tbody multiform-list="easter" class="sortable-easter">
					<?php if (count($data) > 0): ?>
						<?php $no = 1; foreach ($data as $item): ?>
							<tr multiform-item="easter" edit-item="">
								<td class="align-middle text-nowrap"><a href="#" class="text-secondary sortable-cursor"><i class="fas fa-grip-vertical mr-1"></i></a><span auto-number=""><?php echo $no++; ?>.</span></td>
								<td class="align-middle" width="100%">
									<a edit-item-easter="" href="#" title="Edit Data"><?php echo $item; ?></a>
									<input name="data[]" value="<?php echo $item; ?>" class="form-control form-control-sm hide" type="text" placeholder="<?php echo ucwords($module_name); ?>" required="">
								</td>
								<td class="align-middle text-nowrap text-center">
									<a href="#" class="text-danger" multiform-remove=""><i class="fa fa-trash-alt fa-fw mr-1"></i></a>
								</td>
							</tr>
						<?php endforeach ?>
					<?php else: ?>
						<tr no-data="">
							<td colspan="3" class="text-muted text-center">
								No data available in table
							</td>
						</tr>
					<?php endif ?>
				</tbody>
			</table>
			<div class="card-footer text-right">
				<button class="btn btn-secondary" multiform-add="easter" type="button">Add New</button>
				<button class="btn btn-primary" type="submit" disabled="">Save Change</button>
			</div>
		</form>
		<!-- /.card -->
	</div>
</div>
<table class="hide">
	<tbody multiform-master="easter">
		<tr multiform-item="easter">
			<td class="align-middle text-nowrap"><a href="#" class="text-secondary sortable-cursor"><i class="fas fa-grip-vertical mr-1"></i></a><span auto-number=""></span></td>
			<td class="align-middle" width="100%">
				<input name="data[]" class="form-control form-control-sm" type="text" placeholder="<?php echo ucwords($module_name); ?>" required="">
			</td>
			<td class="align-middle text-nowrap text-center">
				<a href="#" class="text-danger" multiform-remove=""><i class="fa fa-trash-alt fa-fw mr-1"></i></a>
			</td>
		</tr>
	</tbody>
	<tfoot no-data-master="">
		<tr no-data="">
			<td colspan="3" class="text-muted text-center">
				No data available in table
			</td>
		</tr>
	</tfoot>
</table>
<script>
$(document).on('click', '[edit-item-easter]', function(event) {
	var el = $(this);
	el.parents('tr').children().find('input').first().removeClass('hide');
	el.addClass('hide');
	return false;
});

$(document).on('click', '[multiform-add]', function(event) {
	$('[multiform-list] [no-data]').remove();
	auto_number($('[auto-number]'));
});

$(document).on('click', '[multiform-remove]', function(event) {
	auto_number($('[auto-number]'));
	var i = 1;
	$('[multiform-list] [auto-number]').each(function(e) {
		$(this).text((i) + '.');
		i++;
	});
	if (i == 1) {
		var master = $('[no-data-master]');
		var string_item = master.html();
		$(string_item).appendTo('[multiform-list]');
	}
});

$(document).on('change keyup', 'input[type=text]', function(event) {
	if ($(this).val() != '') {
		$('button[type=submit]').removeAttr('disabled');
	}
});

$(document).on('click', '[edit-item] [multiform-remove]', function(event) {
	$('button[type=submit]').removeAttr('disabled');
});

$(document).on('click', '.sortable-easter', function(event) {
	event.preventDefault();
});

$(function() {
	$(".sortable-easter").sortable({
		handle: ".sortable-cursor",
		axis: 'y',
		placeholder: "py-2 bg-light",
		forcePlaceholderSize:true,
		update: function() {
			auto_number($('[auto-number]'));
			$('button[type=submit]').removeAttr('disabled');
		}
	});
});
</script>