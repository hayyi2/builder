<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Option_model extends Aplego_Model
{
	public $table_name 		= 'options';
	public $primary_key 	= 'option_id';

	private $option_value 	= array();

	public function gets_in($key)
	{
		$data = $this->where_in('option_key', $key)->gets();
		$temp_data = array();
		foreach ($data as $item) {
			$this->option_value[$item['option_key']] = $temp_data[$item['option_key']] = $item['option_value'];
		}
		foreach ($key as $item) {
			if (isset($temp_data[$item]) === false) {
				$this->option_value[$item] = $temp_data[$item] = false;
			}
		}
		return $temp_data;
	}

	public function get_value($key)
	{
		if (isset($this->option_value[$key]) === true) {
			return $this->option_value[$key];
		}
		$data = $this->where('option_key', $key)->get();
		return $this->option_value[$key] = $data !== false ? $data['option_value'] : false;
	}

	public function get_easter($easter_type)
	{
		if (isset($this->option_value[$easter_type]) === true) {
			return $this->option_value[$easter_type];
		}
		$data = $this->where('option_key', $easter_type)->get();
		return $this->option_value[$easter_type] = $data !== false ? json_decode($data['option_value']) : array();
	}

	public function set_easter($easter_type, $data)
	{
		$data_easter = $this->where('option_key', $easter_type)->get();
		$method = $data_easter !== false ? 'change' : 'set';
		$this->$method($easter_type, json_encode($data));
	}

	function set($option_key, $option_value)
	{
		$data = array(
			'option_key'	=> $option_key,
			'option_value'	=> $option_value,
		);
		return $this->create($data);
	}

	function change($id, $option_value)
	{
		$data = array('option_value' => $option_value);
		return $this->update(is_int($id) ? $id : array('option_key' => $id), $data);
	}

	function remove($id)
	{
		return $this->delete(is_int($id) ? $id : array('option_key' => $id));
	}
}
