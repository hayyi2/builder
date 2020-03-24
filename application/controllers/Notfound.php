<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('aplego_controller');

class Notfound extends Aplego_controller
{
	public function index()
	{
		$this->blank->show(404);
	}

	public function errors()
	{
		$this->blank->show(500);
	}
}