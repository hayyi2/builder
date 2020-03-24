<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('app_controller');

class Data extends App_controller
{
	protected $module = 'user';
	protected $module_main = 'user/data';

	protected $protected_page = array(
		'index' 	=> 'admin_master',
		'input' 	=> 'admin_master',
		'duplicate' => 'admin_master',
		'edit' 		=> 'admin_master',
	);
	
	protected function load_model($value='')
	{
		$this->model =& $this->user_model;
		$this->model->set_crud_capability($this->user_group['admin']);
	}

	protected function prepar_input()
	{
		parent::prepar_input();
		$this->input_rules['username']['rules'][] = array('username_check', array($this->model, 'callback_username_check'));
		$this->form_validation->set_message('username_check', 'Username telah digunakan.');

		$this->layout->param['capability'] = $this->user_group['admin'];
		$this->layout->param['active'] = $this->config->item('active');
		
		$this->input_rules['capability']['rules'] .= '|in_list['.implode(',', $this->layout->param['capability']).']';
		$this->input_rules['active']['rules'] .= '|in_list['.implode(',', $this->layout->param['active']).']';
	}

	public function do_input($post)
	{
		$this->input_rules = array_merge($this->input_rules, $this->model->input_rules_password);
		parent::do_input($post);
	}

	public function do_edit($id, $data, $post)
	{
		$this->model->temp_user_id = $id;
		if ($this->input->post('password') != '') {
			$this->input_rules = array_merge($this->input_rules, $this->model->input_rules_password);
		}else{
			unset($this->model->fillable['password']);
		}
		parent::do_edit($id, $data, $post);
	}
	
	public function delete($id = false)
	{
		$first_data = $this->model->get();
		$id_data = current($first_data);
		$user_id = $this->model->current_user_session('user_id');
		if ($user_id === $id || $id_data === $id) {
			$this->layout->set_message('Data ' . $this->module_name . ' tidak dapat di hapus.');
			$this->redirect($this->module_main);
		}
		parent::delete($id);
	}
}
