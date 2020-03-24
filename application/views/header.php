<?php 
$vendor_dir = get_cfg_var('libs_resoure_url');
if ($vendor_dir === false) $vendor_dir = 'assets/vendor/';
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<base href="<?php echo base_url(); ?>">

	<title><?php echo $title; ?></title>

	<!-- Bootstrap -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">

	<!-- vendor -->
	<!-- fontawesome -->
	<link href="<?php echo $vendor_dir; ?>fontawesome/css/all.min.css" rel="stylesheet">
	<!-- dataTables -->
	<link href="<?php echo $vendor_dir; ?>dataTables/dataTables.bootstrap4.min.css" rel="stylesheet">

	<!-- custom style -->
	<link href="assets/css/style.min.css" rel="stylesheet">

	<!-- vendor -->
	<!-- jQuery -->
	<script src="<?php echo $vendor_dir; ?>jquery/jquery-3.2.1.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?php echo $vendor_dir; ?>popper.min.js"></script>
	<script src="<?php echo $vendor_dir; ?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo $vendor_dir; ?>jquery-ui/jquery-ui.js"></script>
	<!-- dataTables -->
	<script src="<?php echo $vendor_dir; ?>dataTables/jquery.dataTables.min.js"></script>
	<script src="<?php echo $vendor_dir; ?>dataTables/dataTables.bootstrap4.min.js"></script>

	<!-- custom script -->
	<script src="assets/js/script.js"></script>
</head>
<body class="skin-blue">
	<header>
		<nav class="navbar navbar-dark fixed-top navbar-expand-xl">
			<?php if (($menu = $this->config->item('main_menu')) !== null): ?>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainnav">
					<i class="fas fa-bars"></i>
				</button>
			<?php endif; ?>
			<a class="navbar-brand" href=""><?php echo $this->config->item('app_name'); ?></a>

			<div class="collapsed navbar-collapse" id="mainnav">
				<?php if ($menu !== null): ?>
					<ul class="navbar-nav mainnav">
	                    <?php foreach ($menu as $id => $item): ?>
	                        <?php if (is_assoc($item) && protected_item($item['capability'])): ?>
	                            <?php if (isset($item['submenu'])):?>
	                                <li class="nav-item dropdown<?php show_active_menu($active_menu, array_keys($item['submenu'])); ?>">
	                                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
	                                        <i class="<?php echo $item['icon']; ?>"></i><?php echo $item['label']; ?>
	                                    </a>
	                                    <div class="dropdown-menu">
	                                        <?php foreach ($item['submenu'] as $subid => $subitem): ?>
												<?php if (is_int($subid) === false): ?>
		                                            <a class="dropdown-item<?php show_active_menu($active_menu, $subid); ?>" href="<?php echo $group.$subitem['url']; ?>">
														<?php if (isset($subitem['icon'])): ?>
															<i class="fa-fw <?php echo $subitem['icon']; ?> mr-2"></i>
														<?php endif ?>
		                                            	<?php echo $subitem['label']; ?>
		                                            </a>
												<?php else: ?>
													<div class="dropdown-divider"></div>
												<?php endif ?>
	                                        <?php endforeach ?>
	                                    </div>
	                                </li>
	                            <?php else: ?>
	                                <li class="nav-item<?php show_active_menu($active_menu, $id); ?>">
	                                    <a class="nav-link" href="<?php echo $group.$item['url']; ?>">
	                                    	<?php if (isset($item['icon']) === true): ?>
	                                        	<i class="fa-fw <?php echo $item['icon']; ?>"></i>
	                                    	<?php endif ?>
	                                        <?php echo $item['label']; ?>
	                                    </a>
	                                </li>
	                            <?php endif; ?>
	                        <?php elseif(protected_item($item)): ?>
	                            <li class="divider"></li>
	                        <?php endif; ?>
	                    <?php endforeach; ?>
					</ul>
				<?php endif ?>
				<ul class="navbar-nav ml-auto">
					<?php if (($menu = $this->config->item('secondary_menu')) !== null): ?>
						<?php foreach ($menu as $id => $item): ?>
							<?php if (is_int($id) === false && protected_item($item['capability'])): ?>
								<?php if (isset($item['submenu'])):?>
									<li class="nav-item dropdown<?php show_active_menu($active_menu, array_keys($item['submenu'])); ?>">
										<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
											<span class="show-sm"><?php echo $item['label']; ?></span>
											<i class="fa-fw <?php echo $item['icon']; if($item['label'] !== '') echo ' ml-0 ml-sm-1' ?>"></i> 
										</a>
										<div class="dropdown-menu dropdown-menu-right">
											<?php foreach ($item['submenu'] as $subid => $subitem): ?>
												<?php if (is_int($subid) === false): ?>
													<a class="dropdown-item<?php show_active_menu($active_menu, $subid); ?>" href="<?php echo $group.$subitem['url']; ?>">
														<?php if (isset($subitem['icon'])): ?>
															<i class="fa-fw <?php echo $subitem['icon']; ?> mr-2"></i>
														<?php endif ?>
														<?php echo $subitem['label']; ?>
													</a>
												<?php else: ?>
													<div class="dropdown-divider"></div>
												<?php endif ?>
											<?php endforeach ?>
										</div>
									</li>
								<?php else: ?>
									<li class="nav-item<?php show_active_menu($active_menu, $id); ?>">
										<a class="nav-link" href="<?php echo $group.$item['url']; ?>">
											<span class="show-sm"><?php echo $item['label']; ?> </span>
	                                    	<?php if (isset($item['icon']) === true): ?>
												<i class="fa-fw <?php echo $item['icon']; ?>"></i>
	                                    	<?php endif ?>
										</a>
									</li>
								<?php endif; ?>
							<?php elseif(protected_item($item)): ?>
								<li class="divider"></li>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif ?>
					<?php if (empty($user_data = current_user_session()) === false): ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<div class="avatar ml-0 ml-sm-2"><?php echo substr($user_data['name'], 0, 1); ?></div>
								<span class="show-sm"><?php echo $user_data['name']; ?></span>
							</a>
							<div class="dropdown-menu dropdown-menu-right">
								<a href="<?php echo $group; ?>user/profile" class="dropdown-item<?php show_active_menu($active_menu, 'profile'); ?>"><i class="fa mr-2 fa-fw fa-user"></i>Profile</a>
								<a href="<?php echo $group; ?>user/change_profile" class="dropdown-item<?php show_active_menu($active_menu, 'change_profile'); ?>"><i class="fa mr-2 fa-fw fa-user-cog"></i>Change Profile</a>
								<div class="dropdown-divider"></div>
								<a href="<?php echo $group; ?>user/logout" class="dropdown-item"><i class="fa mr-2 fa-fw fa-sign-out-alt"></i>Logout</a>
							</div>
						</li>
					<?php endif ?>
				</ul>
			</div>
		</nav>
	</header>
	<div class="body">
		<div class="auto-height">