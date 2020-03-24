<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends MX_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->library('unit_test');
		$this->unit->use_strict(TRUE);
	}

	public function index()
	{
		$test = null;
		$expected_result = null;

		$class = new ReflectionClass($this);
		$methods = $class->getMethods(ReflectionMethod::IS_PRIVATE);

		foreach ($methods as $item) {
			$method = $item->name;
			$this->$method($test, $expected_result);
			$this->unit->run($test, $expected_result, ucwords(str_replace('_', ' ', $method)));
		}

		// var_dump($this->unit->result());
		echo $this->unit->report();
	}

	private function add_one_plus_one(&$test, &$expected_result)
	{
		$test = 1 + 0;
		$expected_result = 2;
	}

	private function add_one_plus_two(&$test, &$expected_result)
	{
		$test = 1 + 2;
		$expected_result = 3;
	}
}
