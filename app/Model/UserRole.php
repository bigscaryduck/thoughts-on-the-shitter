<?php

App::uses('AppModel', 'Model');

class UserRole extends AppModel {

	public $name = 'UserRole';

	public $validate = array(
		'access_level' => array(
			'rule'     => 'numeric',
			'message'  => 'Access level should be a number',
			'required' => 'create'
		),
		'name' => array(
			array(
				'rule'     => 'notEmpty',
				'message'  => 'Name is required',
				'required' => 'create'				
			),
			array(
				'rule'     => array('maxLength', 255),
				'message'  => 'Role name cannot exceed 255 characters',
				'required' => 'create'
			)	
		),
		'description' => array(
			'rule'     => 'notEmpty',
			'message'  => 'Description is required',
			'required' => 'create'
		),		
	);
	
	public function getDefaultRoleId() {
		return $defaultRoleId = 1;
	}	
		
		
		
}
