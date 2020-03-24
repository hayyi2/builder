<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact_model extends Aplego_Model
{
	public $table_name 	= "contacts";
	public $primary_key = "contact_id";

	protected $created_at 	= true;
	protected $author		= true;

    public $fillable = array(
    	'name',
    	'email',
    	'address',
    );
    
	public $input_rules = array(
		array(
			'field' => 'name',
			'label' => 'Name',
			'rules' => 'trim|required'
		),
		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email'
		),
		array(
			'field' => 'address',
			'label' => 'Address',
			'rules' => 'trim'
		),
	);
}
