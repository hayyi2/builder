<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

$config['app_name'] = 'Builder App';
$config['app_vertion'] = '1.0';


// module
$config['main_module'] 	= '';

// subsystem
$config['subsystem'] = array(
);

// auth
$config['auth_session_name'] = 'builder_rh34i_session';

$config['capability'] = array(
	'author' 	=> 'Author',
	'admin' 	=> 'Admin',
);

$config['main_url'] = array(
	'author' 		=> 'dashboard',
	'admin' 		=> 'dashboard',
);

$config['user_group'] = array(
	'guest' 		=> array(false), 
	'all_user' 		=> array(false, 'author', 'admin'), 
	'admin' 		=> array('author', 'admin'), 
	'author' 		=> array('author'), 
	'admin_master' 	=> array('admin'), 
	'denied' 		=> array('denied'), 
);

// template
$config['main_menu'] = array(
	'dashboard' => array(
		'label'         => 'Dashboard',
		'icon'			=> 'fas fa-tachometer-alt',
		'capability'    => $config['user_group']['admin'],
		'url'           => 'dashboard',
	),
	$config['user_group']['admin'],
	'contact' => array(
		'label'         => 'Contact',
		'icon'			=> 'fas fa-book',
		'capability'    => $config['user_group']['admin'],
		'url'           => 'contact',
	),
	'menu' => array(
		'label'         => 'Menu',
		'icon'			=> 'fas fa-qrcode',
		'capability'    => $config['user_group']['admin'],
		'url'           => 'menu',
	),
	'submenu' => array(
		'label'         => 'Submenu',
		'icon'			=> 'fas fa-sitemap',
		'capability'    => $config['user_group']['admin'],
		'submenu'       => array(
			'submenu_satu' => array(
				'label'	=> 'Submenu Satu',
				'icon'	=> 'fas fa-angle-right',
				'url' 	=> 'submenu/satu',
			),
			'submenu_dua' => array(
				'label'	=> 'Submenu Dua',
				'icon'	=> 'fas fa-angle-right',
				'url' 	=> 'submenu/dua',
			),
			1 => 'divider',
			'submenu_tiga' => array(
				'label'	=> 'Submenu Tiga',
				'icon'	=> 'fas fa-angle-right',
				'url' 	=> 'submenu/tiga',
			),
		),
	),
	$config['user_group']['admin'],
	'report' => array(
		'label'         => 'Report',
		'icon'			=> 'fas fa-chart-line',
		'capability'    => $config['user_group']['admin'],
		'url'           => 'report',
	),
);

$config['secondary_menu'] = array(
	'manages' => array(
		'label'         => 'Manages',
		'icon'			=> 'fas fa-th-large',
		'capability'    => $config['user_group']['admin_master'],
		'submenu'       => array(
			'easter' => array(
				'label'	=> 'Test Easter',
				'icon'	=> 'fas fa-database',
				'url' 	=> 'easter',
			),
			1 => 'divider',
			'user' => array(
				'label'	=> 'User & Access',
				'icon'	=> 'fas fa-users',
				'url' 	=> 'user/data',
			),
			'setting_general' => array(
				'label'	=> 'Test Setting',
				'icon'	=> 'fas fa-cog',
				'url' 	=> 'setting',
			),
			'setting_email' => array(
				'label'	=> 'Setting Email',
				'icon'	=> 'fas fa-envelope',
				'url' 	=> 'setting/email',
			),
		),
	),
	'login' => array(
		'label'         => 'Login',
		'icon'			=> 'fas fa-sign-in-alt',
		'capability'    => $config['user_group']['guest'],
		'url'           => 'user/login',
	),
);

// data config
$config['active'] 	= array('active', 'inactive');
$config['publish'] 	= array('publish', 'draft');