<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('aplego_controller');

class Dashboard extends Aplego_Controller {

	public function __construct()
	{
		parent::__construct();

		// var_dump($this->config->item('app_vertion'));
		if ($this->user_model->protected_item($this->user_group['admin']) === false) {
			$this->redirect('user/login');
		}
	}

	public function index()
	{
		$this->layout->title = "Dashboard";
		$this->layout->active_menu = "dashboard";
		// $this->blank->show('under_construction');

		$this->layout->param['count_entry'] = 3;
		$this->layout->param['count_master'] = 3;
		$this->layout->param['data_master'] = array();

		$this->layout->build('dashboard');
	}
}
