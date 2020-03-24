<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Collection meta model
 *
 * @author      Hayyi
 * @version 	1.0
 */
Class Meta_Model extends CI_Model
{
	public $data_model = array();
	protected $index_key = 0;

	public function add_model(&$model, $key, $type='oo', $alias='')
	{
		$this->data_model[$this->index_key] = array(
			'model' =>& $model,
			'key'	=> $key,
			'type'	=> $type,
			'alias'	=> $alias,
		);
		return $this->index_key++;
	}

	public function get($where)
	{
		$data = $where;
		foreach ($this->data_model as &$item) {
			$method = 'get_'.$item['type'];
			$this->$method($item, $data);
		}
		return $data;
	}

	public function create($post)
	{
		foreach ($this->data_model as &$item) {
			$method = 'create_'.$item['type'];
			$this->$method($item, $post);
		}
	}

	public function update($post, $data)
	{
		foreach ($this->data_model as &$item) {
			$method = 'update_'.$item['type'];
			$this->$method($item, $post, $data);
		}
	}

	// one to one
	private function get_oo(&$meta_model, &$data)
	{
		$data = array_merge($data, $meta_model['model']->where($meta_model['key'], $data[$meta_model['key']])->get());
	}
	private function create_oo(&$meta_model, &$post)
	{
		$insert_id = $meta_model['model']->create($post);
		$post[$meta_model['model']->primary_key] = $insert_id;
	}
	private function update_oo(&$meta_model, &$post, &$data)
	{
		$meta_model['model']->update($data[$meta_model['model']->primary_key], $post);
		$post[$meta_model['model']->primary_key] = $data[$meta_model['model']->primary_key];
	}

	// one to many
	private function get_on(&$meta_model, &$data)
	{
		$temp = $meta_model['model']->where($meta_model['key'], $data[$meta_model['key']])->gets();
		$data[$meta_model['alias']] = array_column($temp, null, $meta_model['model']->primary_key);
	}
	private function create_on(&$meta_model, &$post)
	{
		if (empty($post[$meta_model['alias']]) === false) {
			foreach ($post[$meta_model['alias']] as &$value) {
				$value[$meta_model['key']] = $post[$meta_model['key']];
			}
			$meta_model['model']->create_bulk($post[$meta_model['alias']]);
		}
	}
	private function update_on(&$meta_model, &$post, &$data)
	{
		$last_data_id = array_keys($data[$meta_model['alias']]);
		$new_data = array();
		foreach ($post[$meta_model['alias']] as $key => $value) {
			if (in_array($key, $last_data_id)) {
				$meta_model['model']->update($key, $value);
			}else{
				$new_data[] = array(
					$meta_model['key'] => $post[$meta_model['key']],
				) + $value;
			}
		}
		if (empty($new_data) === false) {
			$meta_model['model']->create_bulk($new_data);
		}
	}

	// many to many
	private function get_nn(&$meta_model, &$data)
	{
		$temp = $meta_model['model']->where($meta_model['key'][0], $data[$meta_model['key']][0])->gets();
		$data[$meta_model['alias']] = array_column($temp, $meta_model['key'][1], $meta_model['model']->primary_key);
	}
	private function create_nn(&$meta_model, &$post)
	{
		$new_data = array();
		foreach ($post[$meta_model['alias']] as $value) {
			$new_data[] = array(
				$meta_model['key'][0] => $post[$meta_model['key'][0]],
				$meta_model['key'][1] => $value,
			);
		}
		if (empty($new_data) === false) {
			$meta_model['model']->create_bulk($new_data);
		}
	}
	private function update_nn(&$meta_model, &$post, &$data)
	{
		$last_data_id = array_keys($data[$meta_model['alias']]);
		$new_data = array();
		foreach ($post[$meta_model['alias']] as $key => $value) {
			if (in_array($key, $last_data_id)) {
				$meta_model['model']->update($key, array(
					$meta_model['key'][1] => $value,
				));
			}else{
				$new_data[] = array(
					$meta_model['key'][0] => $post[$meta_model['key'][0]],
					$meta_model['key'][1] => $value,
				);
			}
		}
		if (empty($new_data) === false) {
			$meta_model['model']->create_bulk($new_data);
		}
	}

	// subject predicat object
	private function get_spo(&$meta_model, &$data)
	{
		$temp = $meta_model['model']->where_in($meta_model['key'], $data[$meta_model['key']])->where_in('meta_key', $meta_model['alias'])->gets();
		$data = array_marge($data, array_column($temp, 'meta_value', 'meta_key'));
	}
	private function create_spo(&$meta_model, &$post)
	{
		$new_data = array();
		foreach ($meta_model['alias'] as $meta_key) {
			if (isset($post[$meta_key])) {
				$new_data[] = array(
					$meta_model['key'] 	=> $post[$meta_model['key']],
					'meta_key' 		=> $meta_key,
					'meta_value' 	=> $post[$meta_key],
				);
			}
		}
		if (empty($new_data) === false) {
			$meta_model['model']->create_bulk($new_data);
		}
	}
	private function update_spo(&$meta_model, &$post)
	{
		foreach ($meta_model['alias'] as $meta_key) {
			if (isset($post[$meta_key])) {
				$meta_model['model']->update(array(
					$meta_model['key'] 	=> $post[$meta_model['key']],
					'meta_key' 		=> $meta_key,
				), array(
					'meta_value' 	=> $post[$meta_key],
				));
			}
		}
	}
}