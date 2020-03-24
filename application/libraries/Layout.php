<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Layout
{
	protected $app = null;

	// params component 
	public $base_view_dir 	= '';
	public $content_view_dir = '';

	public $base_title 		= '';
	public $title 			= false;
	public $title_separator = ' &middot; ';
	public $active_menu 	= false;

	public $param 			= array();
	public $param_header 	= array();
	public $param_footer 	= array();

	// view component
	public $errors 			= array();

	function __construct()
	{
		$this->app =& get_instance();
		$this->base_title = $this->app->config->item('app_name');
	}

    // Template
	public function set_message($content, $type = 'danger', $level = 'body')
	{
		$data = array(
			'type' 		=> $type,
			'level' 	=> $level, 
			'content' 	=> $content, 
		);
		$this->app->session->set_flashdata('message', $data);
	}

	protected function get_message()
	{
		$html_message = '';
		$message = $this->app->session->flashdata('message');
		if (isset($message) === true){
			$this->param['massage_level'] = $message['level'];
			$html_message = $this->get_view('component/messages', $message);
		}
		return $html_message;
	}

	protected function get_errors()
	{
		$html_errors = empty($this->errors) === true ? '' : $this->get_view('component/errors', array('errors' => $this->errors));
		$this->errors = array();
		return $html_errors;
	}

	protected function set_param()
	{
		// set param header
		$this->param_header['title'] = ($this->title ? $this->title . $this->title_separator : '') . $this->base_title;
		$this->param_header['active_menu'] = $this->active_menu;

		// set param body
		$this->param['errors'] = $this->get_errors();
		$this->param['message'] = $this->get_message();
	}

	public function show_view($view, $param = false)
	{
		$this->app->load->view($view, ($param !== false ? $param : $this->param));
	}

	public function get_view($view, $param = false)
	{
		return $this->app->load->view($view, ($param !== false ? $param : $this->param), true);
	}

	public function build($view)
	{
		$this->set_param();
		$this->app->load->view($this->base_view_dir.'header', $this->param_header);
		$this->app->load->view($this->content_view_dir.$view, $this->param);
		$this->app->load->view($this->base_view_dir.'footer', $this->param_footer);
	}

	public function custom_build($view, $type = 'simple')
	{
		$this->set_param();
		$this->app->load->view($this->base_view_dir.$type.'-header', $this->param_header);
		$this->app->load->view($this->content_view_dir.$view, $this->param);
		$this->app->load->view($this->base_view_dir.$type.'-footer', $this->param_footer);
	}
}