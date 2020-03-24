<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

// requered library layout

class Blank
{
	protected $data_content = array(
		404 => array(
			'title' 		=> 'Page Not Found',
			'page_title' 	=> '404 - Page Not Found',
			'page_icon' 	=> 'far fa-frown',
			'page_content' 	=> 'The page you request could not found.',
		),
		'under_construction' => array(
			'title' 		=> 'Under Construction',
			'page_title' 	=> 'Under Construction',
			'page_icon' 	=> 'fas fa-laptop-code',
			'page_content' 	=> 'The Future is Under Construction.',
		),
		500 => array(
			'title' 		=> 'An Error Was Encountered',
			'page_title' 	=> 'An Error Was Encountered',
			'page_icon' 	=> 'far fa-frown',
			'page_content' 	=> 'Please contact the developer',
		),
	);

	function __construct()
	{
		$this->app =& get_instance();
		$this->layout =& $this->app->layout;
	}

	public function show($code = 404)
	{
		ob_get_clean();
		if($this->layout->title === ''){
			$this->layout->title = $this->data_content[$code]['title'];
		}
		$this->layout->param['page_title'] = $this->data_content[$code]['page_title'];
		$this->layout->param['page_icon'] = $this->data_content[$code]['page_icon'];
		$this->layout->param['page_content'] = $this->data_content[$code]['page_content'];
		$this->layout->build('blank');

		if (is_numeric($code) === true) {
			$this->app->output->set_status_header($code);
		}
		$this->app->output->_display();
		exit;
	}
}