<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('aplego_controller');

class User extends Aplego_controller
{
	protected $protected_page = array(
		'profile'			=> 'admin',
		'change_profile'	=> 'admin',
	);
	
	public function login()
	{
		$capability = $this->user_model->current_user_session('capability');
		if ($capability !== false) {
			$this->layout->set_message('Anda sudah login.');
			$direct_url = $this->config->item('main_url');
			redirect($direct_url[$capability]);
		}

		$post = $this->input->post();
        if (empty($post) === false) {
            $this->layout->param['post'] = $post;
            $this->do_login($post);
        }

        $this->layout->title = 'Login';
		$this->layout->active_menu = 'login';
		$this->layout->param['go'] = $this->input->get('go');
		$this->layout->build('login');
	}

	protected function do_login($post)
	{
		$this->form_validation->set_rules($this->user_model->login_rules);

		if ($this->form_validation->run() === false) {
	        $this->layout->errors = $this->form_validation->error_array();
	        return;
		}

		$form_data = elements(array_keys($this->user_model->login_rules), $post);
		$login = $this->user_model->login($form_data, true, $this->user_group['admin']);
		if ($login['value'] === true) {
			$this->layout->set_message($login['message'], 'success');
			if (isset($post['go'])) {
				redirect(urldecode($post['go']));
			}

			$direct_url = $this->config->item('main_url');
			redirect($direct_url[$this->user_model->current_user_session('capability')]);
		}
        $this->layout->errors[] = $login['message'];
	}

	public function logout()
	{
		$this->user_model->logout();
		$this->layout->set_message('Success Logout.', 'success');
		$this->redirect('user/login');
	}

	public function profile()
	{
		$this->layout->title = 'Profile';
		$this->layout->active_menu = 'profile';
		$this->layout->param['data'] = $this->user_model->current_user_session();
		$this->layout->build('profile-view');
	}

	public function change_profile()
	{
		$data = $this->user_model->current_user_session();

		$post = $this->input->post();
		if (empty($post) === false) {
			$this->layout->param['post'] = array_merge($data, $post);
			$this->do_change_profile($post);
		}
		
		$this->layout->title = 'Change Profile';
		$this->layout->active_menu = 'change_profile';
		$this->layout->param['post'] = $data;
		$this->layout->build('profile-change');
	}

	protected function do_change_profile($post)
	{
    	$form_rules = array(
    		array(
    			'field' => 'name',
    			'label' => 'Nama',
    			'rules' => 'trim|required'
    		),
    		array(
    			'field' => 'email',
    			'label' => 'Email',
    			'rules' => 'trim|required|valid_email',
    		),
    	);
    	$key_fillable = array('name', 'email');

		if (isset($post['change_password'])) {
			$form_rules[] = array(
				'field' => 'last_password',
				'label' => 'Last Password',
				'rules' => 'required'
			);
			$form_rules[] = array(
				'field' => 'password',
				'label' => 'New Password',
				'rules' => 'required',
			);
			$form_rules[] = array(
				'field' => 'repeat_password',
				'label' => 'Repeat Password',
				'rules' => 'required|matches[password]',
			);
			$key_fillable = array_merge($key_fillable, array('last_password', 'password'));
		}

    	$this->form_validation->set_rules($form_rules);

		if ($this->form_validation->run() === false) {
            $this->layout->errors = $this->form_validation->error_array();
            return;
		}
		$form_data = elements($key_fillable, $post);
		$change_profile = $this->user_model->change_profile($form_data);
		if ($change_profile['value'] === true) {
			$this->layout->set_message('Data profile telah berhasil diubah.', 'success');
			$this->redirect('user/profile');
		}
		$this->layout->errors[] = $change_profile['message'];
	}
}
