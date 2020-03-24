<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends Aplego_Model
{
	public $table_name 		= 'users';
	public $primary_key 	= 'user_id';
	
	protected $timestamp 	= true;

	// crud data
	public $fillable = array(
		'username', 
		'name', 
		'email', 
		'capability', 
		'active', 
		'password' => 'password',
	);

	public $input_rules = array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required'
		),
		'username' => array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => array(
				'trim',
				'required',
			)
		),
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email'
		),
		'capability' => array(
			'field' => 'capability',
			'label' => 'Capability',
			'rules' => 'trim|required'
		),
		'active' => array(
			'field' => 'active',
			'label' => 'User Active',
			'rules' => 'trim|required'
		),
	);
	public $input_rules_password = array(
		array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required'
		),
		array(
			'field' => 'repeat_password',
			'label' => 'Repeat Password',
			'rules' => 'required|matches[password]'
		),
	);

	public $crud_capability 	= false;
	public $temp_user_id 		= 0;

	// auth user 
	private $auth_session_name 	= null; // set from config
	private $allowed_session 	= array('user_id', 'username', 'name', 'email', 'capability', 'created_at');
	private $session_data 		= array();

	public $login_rules = array(
		'username' => array(
			'field' => 'username',
			'label' => 'Username',
			'rules' => 'trim|required'
		),
		'password' => array(
			'field' => 'password',
			'label' => 'Password',
			'rules' => 'required',
		),
	);

	public function __construct()
	{
		parent::__construct();

		// auth user
		$this->auth_session_name = $this->config->item('auth_session_name');

		if ($session = $this->session->userdata($this->auth_session_name)) {
			$this->session_data = $session;
		}
	}

	// auth data
	
	public function login($data, $secure = true, $capability = false)
	{
		$key_login_rules 	= array_keys($this->login_rules);
		$key_uname_login 	= $key_login_rules[0];
		$label_uname_login 	= $this->login_rules[$key_login_rules[0]]['label'];
		
		$this->where($key_uname_login, $data[$key_uname_login]);
		if ($user_data = $this->get()) {
			$this->load->library('PasswordHash');
			$pass_check = $this->passwordhash->CheckPassword($data['password'], $user_data['password']);

			if ($pass_check === true) {
				if ($user_data['active'] === 'inactive') {
					return array(
						'value' 	=> false,
						'message' 	=> 'Maaf akun anda tidak aktif.',
					);
				}

				if (is_array($capability) === true && !in_array($user_data['capability'], $capability)) {
					return array(
						'value' 	=> false,
						'message' 	=> 'Maaf akun anda tidak memiliki akses.'
					);
				}

				$this->set_user_session($user_data);

				$data_update = array(
					'last_login' => date('Y-m-d H:i:s'),
					'login_count' => $user_data['login_count'] + 1,
				);
				$this->update($user_data['user_id'], $data_update, false);

				return array(
					'value' 	=> true,
					'message' 	=> "Success Login, Selamat datang {$user_data['name']}."
				);
			}else{
				$message = 'Password anda salah.';
			}
		}else{
			$message = $label_uname_login.' anda tidak ditemukan.';
		}

		if ($secure) {
			$message = $label_uname_login.' atau password anda salah.';
		}

		return array(
			'value' 	=> false,
			'message' 	=> $message,
		);
	}

	public function logout()
	{
		$this->session_data = array();
		$this->session->unset_userdata($this->auth_session_name);
	}

	public function change_profile($data, $meta_data = false)
	{
		if (isset($data['last_password'])) {
			$user_data = $this->get($this->session_data['user_id']);

			$this->load->library('PasswordHash');
			$pass_check = $this->passwordhash->CheckPassword($data['last_password'], $user_data['password']);
			if (!$pass_check) {
				return array(
					'value' 	=> false,
					'message' 	=> "Password lama salah."
				);
			}else{
				unset($data['last_password']);
				$data['password'] = $this->passwordhash->HashPassword($data['password']);
			}
		}

		parent::update($this->session_data['user_id'], $data, false);
		$this->set_user_session((int)$this->session_data['user_id']);

		return array(
			'value' 	=> true,
		);
	}

	protected function set_user_session($user_data)
	{
		if (is_int($user_data)) {
			$user_data = $this->get($user_data);
		}
		$sess_array = elements($this->allowed_session, $user_data);
		$data_meta = $this->user_meta_model->where('user_id', $user_data['user_id'])->gets();
		foreach ($data_meta as $item) {
			$sess_array[$item->meta_key] = $item->meta_value;
		}
		$this->session_data = $sess_array;
		$this->session->set_userdata($this->auth_session_name, $sess_array);
	}

	public function current_user_session($key = false)
	{
		if($key) {
			if(isset($this->session_data[$key])){
				return $this->session_data[$key];
			}
			return false;
		}
		else return $this->session_data;
	}

	// protect
	public function protected_item($rules)
	{
		$capability = isset($this->session_data['capability']) ? $this->session_data['capability'] : false;
		return in_array($capability, $rules);
	}

	/*
	
	CRUD User Data

	*/

	public function set_crud_capability($capability)
	{
		$this->crud_capability = $capability;
	}
	
	public function callback_username_check($username)
	{
		return $this->where($this->primary_key . ' <>', $this->temp_user_id)->check_isset('username', $username) !== true;
	}

	public function gets($view_name = false)
	{
		if ($this->crud_capability !== false) {
			$method = is_string($this->crud_capability) === true ? 'where' : 'where_in';
			$this->db->$method('capability', $this->crud_capability);
		}
		return parent::gets($view_name);
	}

	public function create($data, $filter_fillable = true)
	{
		$this->load->library('PasswordHash');
		$data['password'] = $this->passwordhash->HashPassword($data['password']);
		if ($this->crud_capability !== false && is_string($this->crud_capability) === true) {
			$data['capability'] = $this->crud_capability;
		}
		return parent::create($data, $filter_fillable);
	}

	public function update($id, $data, $filter_fillable = true)
	{
		if (isset($data['password'])) {
			$this->load->library('PasswordHash');
			$data['password'] = $this->passwordhash->HashPassword($data['password']);
		}
		return parent::update($id, $data, $filter_fillable);
	}
}
