<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function current_user_session($key = false, $value = false)
{
	$CI =& get_instance();
	return $CI->user_model->current_user_session($key, $value);
}

function protected_item($rules)
{
	$CI =& get_instance();
	return $CI->user_model->protected_item($rules);
}