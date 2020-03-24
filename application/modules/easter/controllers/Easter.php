<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Modules::load('easter_controller');

class Easter extends Easter_controller {
	protected $module  		= 'status';
	protected $active_menu  = 'easter';
}
