<?php

App::uses('AdminAppController', 'Admin.Controller');

class UsersController extends AdminAppController {

	/**
	 * Models
 	 *
 	 * @var array
 	 */		
	public $uses = array(
		'User'
	);

	/**	
	 * Called before controller action.
	 *
	 * @return void
	 */	
    public function beforeFilter() {
    	parent::beforeFilter();	
    }
    
	/**
	 * List Users
	 *
	 * @return void
	 */
	public function index() {
		$this->Paginator->settings = array_merge($this->paginate, array(
			'contain'    => array('Role', 'Merchant', 'Charity', 'Marketer'),	
			'conditions' => array_merge(array(
				'User.deleted' => false,
				'Merchant.id'  => null,
				'Marketer.id'  => null,
				'Charity.id'   => null,
			), $this->Filter->parseConditions()),		
		));
		$this->set('users', $this->Paginator->paginate('User'));
		$this->set('roles', $this->User->Role->find('list'));	
	}
	
	/**
	 * Add User
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is('post')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('User successfully created.'), 'success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('Please fix the errors below to continue'), 'error');
			}
		}
		$this->set('roles', $this->User->Role->find('list'));
	}
	
	/**
	 * Edit User
	 *
	 * @param int $id
	 * @return void
	 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			$this->Session->setFlash(__('Invalid user reference.'), 'error');
			$this->redirect(array('action' => 'index'));
		}
		if ($this->request->is('post')) {
			$this->User->id = $id;
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('User successfully updated.'), 'success');
				$this->redirect(array('action' => 'index'));			
			} else {
				$this->Session->setFlash(__('Please fix the errors below to continue'), 'error');
			}
		} else {
			$this->request->data = $this->User->findById($id);
		}
		$this->set('roles', $this->User->Role->find('list'));
	}
	
	/**
	 * View User
	 *
	 * @param int $id
	 * @return void
	 */
	public function view($id = null) {
		$this->User->contain('Merchant', 'Charity', 'Marketer');
		if (!$id || (!$user = $this->User->findById($id))) {
			$this->Session->setFlash(__('Invalid user reference.'), 'error');
			$this->redirect(array('action' => 'index'));		
		}
		$this->set(compact('user'));
	}
	
	/**
	 * Delete User
	 *
	 * @param int $id
	 * @return void
	 */
	public function delete($id = null) {
	
		if (!$this->User->read(null, $id)) {
			$this->Session->setFlash(__('Invalid user reference.'), 'error');
			$this->redirect(array('action' => 'index'));		
		}
		
		$canDelete = true;
		if ($this->User->Order->find('count', array('conditions' => array('Order.user_id')))) {
			$canDelete = false;
		}
		
		if ($canDelete) {
			$this->User->delete();
		} else {
			$this->User->setDeleted(true);
			$this->User->setActive(false);
			$this->User->save(null, false);			
		}
		$this->Session->setFlash(__('User successfully deleted.'), 'success');
		$this->redirect(array('action' => 'index'));
	}

}
