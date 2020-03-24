<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Super Class Model/Master Class Model
 *
 * @author      Hayyi
 * @version 	1.1.0
 */
Class Aplego_model extends CI_Model
{
	public $table_name 		= '';
	public $primary_key 	= '';
	public $table_view_name = '';
	
	protected $timestamp 	= false;
	protected $created_at 	= false;
	protected $author		= false;

	protected $slug_column	= '';
	protected $slug_ref		= '';

    public $fillable 		= array();
    public $input_rules 	= array();

	protected $result_array	= true;

	public $filter_field	= array();
	public $filter_rules 	= array();
	public $filter_data 	= array();

	public function __construct()
	{
		parent::__construct();

		if ($this->author === true) {
			$this->author = 'user_id';
		}
	}

	public function __call($method, $param)
	{
		if (method_exists($this->db, $method) === true) {
			call_user_func_array(array($this->db, $method), $param);
			return $this;
		}
		log_message('error', "Method failed to run: {$method}");
		show_error("Method failed to run: {$method}");
	}

	protected function prepar_create(&$data, $filter_fillable)
	{
		if (!isset($this->time_now)) {
			$this->time_now = date('Y-m-d H:i:s');
		}
		if ($filter_fillable === true) {
			$this->fillable_data($data);
		}
		if($this->timestamp === true || $this->created_at === true){
			$data['created_at'] = $this->time_now;
		}
		if ($this->timestamp === true) {
			$data['updated_at'] = $this->time_now;
		}
		if ($this->author !== false) {
			$data[$this->author] = $this->user_model->current_user_session($this->user_model->primary_key);
		}
		if ($this->slug_column !== '') {
			$data[$this->slug_column] = $this->get_slug($data[$this->slug_ref]);
		}
	}

	protected function fillable_data(&$data)
	{
		if (empty($this->fillable) === false) {
			$data = elements($this->fillable, $data);
		}
	}

	public function create($data, $filter_fillable = true)
	{
		$this->prepar_create($data, $filter_fillable);

		$this->db->insert($this->table_name, $data);
		return $this->db->insert_id();
	}

	public function create_bulk($data, $filter_fillable = true)
	{
		foreach ($data as &$item) {
			$this->prepar_create($item, $filter_fillable);
		}

		return $this->db->insert_batch($this->table_name, $data);
	}

    protected function get_table($view_name = false)
    {
    	if ($view_name === false) {
    		$view_name = $this->table_name;
    	} else if ($view_name === true) {
    		$view_name = $this->table_view_name;
    	}
    	return $view_name;
    }

	public function gets($view_name = false)
	{
		$this->db->from($this->get_table($view_name));
		$query = $this->db->get();
		return $this->result_array === true ? $query->result_array() : $query->result();
	}

	protected function where_id($id)
	{
		$this->db->where(is_numeric($id) === true ? array($this->primary_key => $id) : $id);
	}

	public function get($id = false, $view_name = false)
	{
		$this->db->from($this->get_table($view_name));
		if ($id !== false) {
			$this->where_id($id);
		}
		$query = $this->db->get();
		$row = $query->row();
		if ($row) {
			return $this->result_array === true ? (array)$row : $row;
		}
		return false;
	}

	public function update($id, $data, $filter_fillable = true)
	{
		$this->where_id($id);
		if ($filter_fillable === true) {
			$this->fillable_data($data);
		}
		if($this->timestamp){
			$data['updated_at'] = date('Y-m-d H:i:s');
		}
		if ($this->slug_column !== '') {
			$data[$this->slug_column] = $this->get_slug($data[$this->slug_ref]);
		}
		$this->db->update($this->table_name, $data);
		return $this->db->affected_rows();
	}

	public function delete($id){
		$this->where_id($id);
		$this->db->delete($this->table_name);
		return $this->db->affected_rows();
	}

	protected function get_slug($text, $no = false)
	{
		$temp_slug = trim($temp_slug);
		$temp_slug = preg_replace('~[^\pL\d]+~u', '-', $temp_slug);
		$temp_slug = iconv('utf-8', 'us-ascii//TRANSLIT', $temp_slug);
		$temp_slug = preg_replace('~[^-\w]+~', '', $temp_slug);
		$temp_slug = trim($temp_slug, '-');
		$temp_slug = preg_replace('~-+~', '-', $temp_slug);
		$temp_slug = strtolower($temp_slug);
		if (empty($temp_slug)) {
			$temp_slug = 'n-a';
		}
		$temp_slug = $temp_slug.($no !== false ? '-'.$no : '');
		if ($this->check_isset($this->slug_column, $temp_slug) === false) {
			return $temp_slug;
		}
		return $this->get_slug($text, $no === false ? 2 : $no + 1);
	}

	public function check_isset($field, $value = false)
	{
		$this->db->where($value !== false ? array($field => $value) : $field);
		return ($this->get_count() > 0 ? true : false);
	}

	public function get_count_all($view_name = false)
	{
		return $this->db->count_all($this->get_table($view_name));
	}

	public function get_count($view_name = false)
	{
		return $this->db->count_all_results($this->get_table($view_name));
	}

    public function where_mine()
    {
    	return $this->db->where($this->author, $this->user_model->current_user_session($this->user_model->primary_key));
    }

    public function join_author($view_name = false, $author = 'author')
    {
        $this->db->select($this->get_table($view_name).'.*, users.username as '.$author.'_username, users.name as '.$author.'_name');
        $this->db->join('users', 'users.' . $this->user_model->primary_key . '=' . $this->get_table($view_name) . '.' . $this->author);
        return $this;
    }

    public function filter($data)
    {
    	$filter = elements(array_keys($this->filter_field), array_keys($data));
    	foreach ($filter as $item) {
        	$this->db->where($this->filter_field[$item], $data[$item]);
    	}
        return $this;
    }
}