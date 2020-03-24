<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('aplego_controller');

class Easter_Controller extends Aplego_controller
{
	protected $module  		= false;
	protected $module_name 	= false;

	protected $active_menu  = false;

	protected $protected_default = array(
		'index' 	=> 'admin_master',
	);

	public function index()
	{
		$this->init_easter();
	}

	protected function init_easter()
	{
		if ($this->module_name === false) $this->module_name = $this->module;
		if ($this->active_menu === false) $this->active_menu = $this->module;

		$post = $this->input->post();
		if (empty($post) === false) {
			if (isset($post['data']) && is_array($post['data'])) {
				$this->option_model->set_easter($this->module, array_unique($post['data']));
				$this->layout->set_message('Data '.$this->module_name.' telah berhasil ditambah.', 'success');
		        $this->refresh();
			}
		}
		
		$this->layout->title = 'Data '.ucwords($this->module_name);
		$this->layout->active_menu = $this->active_menu;
		$this->layout->param['module_name'] = $this->module_name;
		$this->layout->param['data'] = $this->option_model->get_easter($this->module);
		$this->layout->build('easter');
	}
}
