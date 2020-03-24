<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// set array to get param url

function array_to_get_url($get = array(), $to_echo = true){
    $str_url = "";
    $no = 1;
    foreach ($get as $key => $value) {
        if ($value) {
            if ($no++ > 1) {
                $str_url .= '&';
            }
            $str_url .= $key . "=" . $value;
        }
    }
    if ($to_echo) {
        echo $str_url;
    }else{
        return ($str_url != "" ? '?'.$str_url : $str_url);
    }
}

// set array to input hidden 

function array_to_input($input, $to_echo = true){
    $str_input = "";
    foreach ($input as $key => $value) {
        if ($value) {
            $str_input .= '<input type="hidden" name="' . $key . '" value="' . $value . '">';
        }
    }
    if ($to_echo) {
        echo $str_input;
    }else{
        return $str_input;
    }
}

// formating text

function date_html($date){
	return date('d M Y', strtotime($date));
}

function time_html($time){
	return date('H:i', strtotime($time));
}

function datetime_html($datetime){
    return date('d M Y', strtotime($datetime)) . '<small class="text-muted"> (' . date('H:i', strtotime($datetime)) . ')</small>';
}

function rupiah($angka){
    return "Rp " . number_format($angka,0,',','.'). ',-';
}

function dollar($angka)
{
    return number_format($angka,2,",",".");
}

// change string to [a-z]+, [0-9]+, - to create slug_url
function get_slug($text)
{
    $text = trim($text);
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

// change string to [a-z|A-Z]+, [0-9]+ to create username
function uname($text)
{
    $text = trim($text);
    $text = preg_replace('~[^\pL\d]+~u', '', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '', $text);
    if (empty($text)) {
        return 'na';
    }
    return $text;
}

// module 

function show_module($module, $param = array())
{
    echo Modules::run($module, $param);
}

function get_module($module, $param = array())
{
    return Modules::run($module, $param);
}

// template component 

function show_active_menu($active_menu, $active_rules)
{
    if ((is_array($active_rules) === true && in_array($active_menu, $active_rules) === true) || $active_rules === $active_menu) {
        echo " active";
    }
}