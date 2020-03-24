<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('app_controller');

class Contact extends App_controller
{
	protected $module = 'contact';

	public function index()
	{
		$this->model->join_author();
		parent::index();
	}
}
