<?php

App::uses('AppModel', 'Model');

class Thought extends AppModel {

	public $name = 'Thought';
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);
	public $hasMany = array(
		'ThoughtVote' => array(
			'className' => 'Thought',
			'foreignKey' => 'user_id'
		),
		'ThoughtFlag' => array(
			'className' => 'ThoughtFlag',
			'foreignKey' => 'user_id'
		)
	);
	public $validate = array(
		'thought' => array(
			'notEmtpy' => array(
				'rule' => 'notEmpty',
				'message' => 'Thought is required',
			)
		),
		'user_id' => array(
			'notEmpty' => array(
				'rule' => array('validateUserId'),
				'message' => 'User id is required',
				'required' => 'create'
			),
			'validField' => array(
				'rule' => array('validateUserId'),
				'message' => 'Invalid user id',
				'required' => 'create'
			)
		)
	);

	/**
	 * Validates User ID
	 *
	 * @param array $check
	 * @var array
	 */
	public function validateUserId($check) {
		return $this->User->find('first', array('contain' => array(), 'conditions' => array('User.id' => $check['user_id'])));
	}
}