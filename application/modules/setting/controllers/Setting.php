<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('Setting_controller');

class Setting extends Setting_controller
{
    protected $module = 'general';
    
    protected $option_key = array(
    	'app_name',
    	'app_desc',
    );

    protected $input_rules = array(
		array(
			'field' => 'app_name',
			'label' => 'App Name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'app_desc',
			'label' => 'App Desciption',
			'rules' => '',
		),
	);

    protected $protected_page = array(
        'index' => 'admin_master',
        'email' => 'admin_master',
    );

    public function email()
    {
    	$this->module = 'email';
    	$this->option_key = array(
    		'mail_sender_email', 
    		'mail_sender_name', 
    		'mail_smtp_host', 
    		'mail_smtp_port', 
    		'mail_smtp_user', 
    		'mail_smtp_pass', 
    	);
    	$this->input_field = array(
    		'mail_sender_name' 	=> array(
    			'label' 	=> 'Sender Name',
    			'required' 	=> true,
    		), 
    		'mail_sender_email' => array(
    			'label' 	=> 'Sender Email',
    			'type' 		=> 'email',
    			'required' 	=> true,
    		), 
    		'divider',
    		'mail_smtp_host' 	=> array(
    			'label' 	=> 'SMTP Host',
    			'required' 	=> true,
    		), 
    		'mail_smtp_port' 	=> array(
    			'label' 	=> 'SMTP Port',
    			'required' 	=> true,
    			'type' 		=> 'number',
    			'input_size' => 6,
    		), 
    		'mail_smtp_user' 	=> array(
    			'label' 	=> 'SMTP User',
    			'type' 		=> 'email',
    			'required' 	=> true,
    		), 
    		'mail_smtp_pass' 	=> array(
    			'label' 	=> 'SMTP Password',
    			'type' 		=> 'password',
    			'required' 	=> true,
    		), 
    	);
    	$this->input_rules = array(
    		'mail_sender_name' 	=> array(
				'field' => 'mail_sender_name',
				'label' => 'Sender Name',
				'rules' => 'trim|required',
    		), 
    		'mail_sender_email' => array(
				'field' => 'mail_sender_email',
				'label' => 'Sender Email',
				'rules' => 'trim|required|valid_email',
    		), 
    		'mail_smtp_host' 	=> array(
				'field' => 'mail_smtp_host',
				'label' => 'SMTP Host',
				'rules' => 'trim|required',
    		), 
    		'mail_smtp_port' 	=> array(
				'field' => 'mail_smtp_port',
				'label' => 'SMTP Port',
				'rules' => 'trim|required',
    		), 
    		'mail_smtp_user' 	=> array(
				'field' => 'mail_smtp_user',
				'label' => 'SMTP User',
				'rules' => 'trim|required|valid_email',
    		), 
    		'mail_smtp_pass' 	=> array(
				'field' => 'mail_smtp_pass',
				'label' => 'SMTP Password',
				'rules' => 'required',
    		), 
    	);
        $this->init_setting();
    }
}
