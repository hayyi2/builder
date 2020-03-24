<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aplego_Controller extends MX_Controller
{
	protected $group 		= '';
	protected $user_group 	= array();
	
	// protection
	protected $protected_default = array();
	protected $protected_page = array();
	protected $security_separator = false;

	public function __construct()
	{
		parent::__construct();

		// group user
		$this->user_group = $this->config->item('user_group');

		$this->load->library('layout');
		$this->load->library('blank');

		$index_page = $this->config->item('index_page');

		$layout_param = array(
			'group' 		=> $index_page.$this->group,
			'user_group' 	=> $this->user_group,
		);
		$this->layout->param = $this->layout->param_header = $layout_param;

		$this->secure_the_page();

		$this->form_validation->set_message('in_list', 'The {field} field must be one of {field} data.');
	}

	// protection
	protected function secure_the_page()
	{
		$method = $this->router->fetch_method();
		$protected_page = array_merge($this->protected_default, $this->protected_page);
		if (isset($protected_page[$method]) === true) {
			$this->protected_page($protected_page[$method]);
		}
	}

	protected function protected_page($roles)
	{
		$capability = $this->user_model->current_user_session('capability');
		$rules = $this->user_group[$roles];

		$uri_string = uri_string().array_to_get_url($this->input->get(), false);
		$login_url = 'user/login'.('?go='.urlencode($uri_string));

		if (!in_array(false, $rules) && $capability === false) {
			$this->layout->set_message('Anda harus masuk terlebih dahulu.');
			$this->redirect($login_url);
		}
		if (in_array($capability, $rules) !== true) {
			if ($this->security_separator === true) {
				$this->blank->show(404);
			}
			$this->layout->set_message('Anda tidak memiliki akses.');
			$direct_url = $this->config->item('main_url');
			redirect($direct_url[$capability]);
		}
	}

    // Direct Function
   
	protected function refresh()
	{
		redirect($this->uri->uri_string());
	}

	protected function redirect($url)
	{
		redirect($this->group.$url);
	}
}