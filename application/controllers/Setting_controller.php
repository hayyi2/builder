<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('aplego_controller');

class Setting_Controller extends Aplego_controller
{
    protected $module       = false;
    protected $module_name  = false;
    
    protected $setting_label = 'setting';
    protected $option_key   = array();

    protected $input_rules  = array();
    protected $input_view   = false;

    protected $protected_default = array(
        'index'     => 'admin_master',
    );

	public function index()
	{
        $this->init_setting();
	}

    protected function init_setting()
    {
        if (empty($this->option_key) === true) {
            $this->show_404();
        }

        if ($this->module_name === false) $this->module_name = $this->module;

        $data = $this->option_model->gets_in($this->option_key);

        $post = $this->input->post();
        if (empty($post) === false) {
            $this->do_setting($post, $data);
            $this->layout->param['post'] = array_merge($data, $post);
        }

        if ($this->layout->title === false) {
            $this->layout->title = ucwords($this->setting_label.' '.$this->module_name);
        }
        if ($this->layout->active_menu === false) {
            $this->layout->active_menu = 'setting_'.$this->module;
        }
        $this->layout->param['module_name'] = $this->module_name;
        $this->layout->param['setting_label'] = $this->setting_label;
        $this->layout->param['post'] = $data;
        $this->layout->build($this->input_view === false ? 'setting-'.$this->module : $this->input_view);
    }

    protected function invalid_setting(&$post)
    {
        // penambahan upload file validation
        
        $this->form_validation->set_data($post);
        $this->form_validation->set_rules($this->input_rules);
        $form_valid = $this->form_validation->run();
        $form_errors = $this->form_validation->error_array();

        // penambahan penanganan upload file dan file yang di edit

        $this->layout->errors = $form_errors;

        return !$form_valid;
    }

    protected function do_setting($post, $data)
    {
        if ($this->invalid_setting($post)) return;

        $form_data = elements($this->option_key, $post);
        foreach ($form_data as $key => $value) {
            $method = isset($data[$key]) === true && $data[$key] !== false ? 'change' : 'set';
            $this->option_model->$method($key, $value);
        }

        $this->layout->set_message('Data '.$this->setting_label.' '.$this->module_name.' berhasil diubah.', 'success');
        $this->refresh();
    }
}
