<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('aplego_controller');

class App_controller extends Aplego_controller
{
	protected $module  		= false;
	protected $module_name  = false;
	protected $module_main 	= false; // module main url

	protected $model  		= null;
	protected $meta_model 	= null;

	// input dan edit
	protected $input_rules 	= array();
	protected $upload_rules = array();
	protected $input_direct = false;

	// change field
	protected $change_field = array(); // field => available value

	// protection
	protected $protected_default = array(
		'index' 	=> 'admin',
		'input' 	=> 'admin',
		'edit' 		=> 'admin',
		'duplicate' => 'admin',
		'delete' 	=> 'admin_master',
		'detail' 	=> 'denied',
		'field' 	=> 'denied',
	);

	// view
	protected $gets_view  	= false;
	protected $list_view 	= false;
	protected $filter_view 	= false;
	protected $detail_view 	= false;
	protected $input_view 	= false;

	public function __construct()
	{
		parent::__construct();

		$this->module_name = $this->module_name === false ? $this->module : $this->module_name;
		$this->module_main = $this->module_main === false ? $this->module : $this->module_main;

		$this->layout->active_menu = $this->module;
		$this->layout->param['module_name'] = $this->module_name;
		$this->layout->param['module_main'] = $this->module_main;

		$this->load_model();
	}

	protected function load_model()
	{
		$model_name = $this->module."_model";
		$this->load->model($model_name);
		$this->model =& $this->$model_name;
	}

	public function index()
	{
		$this->filter();

		if ($this->layout->title === false) {
			$this->layout->title = 'Data '.ucwords($this->module_name);
		}
		$this->layout->param['data'] = $this->model->gets($this->gets_view);
		$this->layout->build($this->list_view ? $this->list_view : $this->module.'-list');
	}

	protected function prepar_filter() {}

	protected function filter() 
	{
		if (empty($this->model->filter_field)) return;

		$get_data = $this->model->filter_data;
		$get = $this->input->get();
		if (empty($get) === false) {
			$get_data = array_merge($get_data, $get);
			$run_filter = true;
			// validation
			$filter_rules = $this->model->filter_rules;
			if (empty($filter_rules) === false) {
				$this->form_validation->set_data($get_data);
				$this->form_validation->set_rules($filter_rules);

				if ($this->form_validation->run() == false) {
					$this->layout->errors = $this->form_validation->error_array();
					$run_filter = false;
				}
			}
			if ($run_filter) {
				$this->model->filter($get_data);
			}
		}

		$this->layout->param['post'] = $get_data;
		$this->layout->param['filter_view'] = $this->filter_view ? $this->filter_view : $this->module.'-filter';
	}

	protected function prepar_detail(&$data) {
		if ($this->meta_model !== null) {
			$meta_data = $this->meta_model->get(array($this->model->primary_key => $data[$this->model->primary_key]));
			$data = array_merge($data, $meta_data);
		}
	}

	public function detail($id = false)
	{
		$data = $this->model->get($id);
		if (!$data) {
			$this->layout->set_message('Data '.$this->module_name.' tidak ditemukan.');
			$this->redirect($this->module_main);
		}

		$this->prepar_detail($data);

		if ($this->layout->title === false) {
			$this->layout->title = 'Detail '.ucwords($this->module_name);
		}
		$this->layout->param['data'] = $data;
		$this->layout->build($this->detail_view ? $this->detail_view : $this->module.'-detail');
	}

	public function field($key, $value, $id)
	{
		if (empty($this->change_field) === true) {
			$this->blank->show(404);
		}

		if (isset($this->change_field[$key]) && in_array($value, $this->change_field[$key])) {
			$this->model->update($id, array($key => $value), false);

			$this->layout->set_message('Data '.$this->module_main.' telah berhasil diubah.', 'success');
			$this->redirect($this->module_main);
		}

		$this->layout->set_message('Data '.$this->module_main.' gagal diubah.');
		$this->redirect($this->module_main);
	}

	// pasti di overide
	protected function prepar_input() 
	{
		// penambahan data untuk form
		$this->input_rules =& $this->model->input_rules;
		// penambahan role untuk meta data
	}

	protected function invalid_input(&$post)
	{
		// penambahan upload file validation
		
		$this->form_validation->set_data($post);
		$this->form_validation->set_rules($this->input_rules);
		$form_valid = $this->form_validation->run();
		$form_errors = $this->form_validation->error_array();

		$this->layout->errors = $form_errors;

		return !$form_valid;
	}

	public function input()
	{
		if (!isset($this->layout->param['post'])) {
			$this->layout->param['post'] = array();
		}
		
		$this->prepar_input();

		$post = $this->input->post();
		if (empty($post) === false) {
			$this->layout->param['post'] = array_merge($this->layout->param['post'], $post);
			$this->do_input($post);
		}

		$this->layout->title = 'Input '.ucwords($this->module_name);
		$this->layout->param['mode_add'] = true;
		$this->layout->build($this->input_view ? $this->input_view : $this->module.'-input');
	}

	protected function do_input($post)
	{
		if ($this->invalid_input($post)) return;

		$insert_id = $this->model->create($post);

		// meta data
		if ($this->meta_model !== null) {
			$post[$this->model->primary_key] = $insert_id;
			$this->meta_model->create($post);
		}

		$this->layout->set_message('Data '.$this->module_name.' telah berhasil ditambah.', 'success');
		$this->redirect($this->module_main.($this->input_direct ? '/'.$this->input_direct.'/'.$insert_id : ''));
	}

	public function edit($id = false)
	{
		$data = $this->model->get($id);
		if (!$data) {
			$this->layout->set_message('Data '.$this->module_name.' tidak ditemukan.');
			$this->redirect($this->module_main);
		}
		if ($this->meta_model !== null) {
			$meta_data = $this->meta_model->get(array($this->model->primary_key => $id));
			$data = array_merge($data, $meta_data);
		}

		$this->prepar_input();

		$post = $this->input->post();
		if (empty($post) === false) {
			$this->layout->param['post'] = array_merge($data, $post);
			$this->do_edit($id, $data, $post);
		}

		if (isset($this->layout->param['post']) === true) {
			array_insert($data, 1, $this->layout->param['post']);
		}
		$this->layout->param['post'] = $data;
		$this->layout->title = 'Edit '.ucwords($this->module_name);
		$this->layout->param['mode_add'] = false;
		$this->layout->build($this->input_view ? $this->input_view : $this->module.'-input');
	}
	
	protected function do_edit($id, $data, $post)
	{
		if ($this->invalid_input($post)) return;

		// penambahan hapus file upload dari data

		$this->model->update($id, $post);

		// meta data
		if ($this->meta_model !== null) {
			$post[$this->model->primary_key] = $id;
			$is_collection = isset($this->meta_model->data_model);
			$this->meta_model->update(($is_collection ? $post : $data[$this->meta_model->primary_key]), ($is_collection ? $data : $post));
		}

		$this->layout->set_message('Data '.$this->module_name.' telah berhasil diubah.', 'success');
		$this->redirect($this->module_main.($this->input_direct ? '/'.$this->input_direct.'/'.$id : ''));
	}

	public function duplicate($id = false)
	{
		$data = $this->model->get($id);
		if ($data === false) {
			$this->layout->set_message('Data '.$this->module_name.' tidak ditemukan.');
			$this->redirect($this->module_main);
		}

		if ($this->meta_model !== null) {
			$meta_data = $this->meta_model->get(array($this->model->primary_key => $id));
			$data = array_merge($data, $meta_data);
		}

		$this->layout->param['post'] = $data;
		$this->input();
	}

	public function delete($id = false)
	{
		if ($this->model->delete($id) !== 0) {
			$this->layout->set_message('Data '.$this->module_name.' telah berhasil dihapus.', 'success');
			$this->redirect($this->module_main);
		}
		$this->layout->set_message('Data '.$this->module_name.' tidak ditemukan.');
		$this->redirect($this->module_main);
	}
}
