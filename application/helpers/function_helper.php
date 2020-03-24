<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function get_app_config($key)
{
    $CI =& get_instance();
    return $CI->config->item($key);
}

function get_option($key)
{
    $CI =& get_instance();
    return $CI->option_model->get_value($key);
}

function is_assoc($array)
{
    return array_keys($array) !== range(0, count($array) - 1);
}

function array_insert(&$args, $position, $insert)
{
    if (!is_int($position)) {
        $position = array_search($position, array_keys($args)) + 1;
    }
    $args = array_merge(
        array_slice($args, 0, $position),
        $insert,
        array_slice($args, $position)
    );
}

function is_json($data)
{
	@json_decode($data);
	return (json_last_error() === JSON_ERROR_NONE);
}