<?php

App::uses('AdminAppController', 'Admin.Controller');

class UserRolesController extends AdminAppController {

	/**
	 * Models
 	 *
 	 * @var array
 	 */		
	public $uses = array(
		'UserRole'
	);

	/**	
	 * Called before controller action.
	 *
	 * @return void
	 */	
    public function beforeFilter() {
    	parent::beforeFilter();	
		return true;
    }
    
	/**
	 * List User Roles
	 *
	 * @return void
	 */
	public function index() {
		
	}
	
	/**
	 * Add User Role
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
		
		}
	}
	
	/**
	 * Edit User Role
	 *
	 * @param int $id
	 * @return void
	 */
	public function edit($id = null) {
		if ($this->request->is('post')) {
		
		}
	}

	/**
	 * Delete User Role
	 *
	 * @param int $id
	 * @return void
	 */
	public function delete($id = null) {

	}

}
