<?php

App::uses('AppModel', 'Model');

class ThoughtVote extends AppModel {

	public $name = 'ThoughtVote';

	public $belongsTo = array(
		'Thought' => array(
			'className'  => 'Thought',
			'foreignKey' => 'thought_id'
		),
		'User' => array(
			'className'  => 'User',
			'foreignKey' => 'user_id'
		)
	);

	public $validate = array(
		'thought_id' => array(
			'rule'     => array('validateThoughtId'),
			'message'  => 'Invalid thought id',
			'required' => 'create'
		),
		'user_id' => array(
			array(
				'rule'     => array('validateUserId'),
				'message'  => 'Invalid user id',
				'required' => 'create'
			),
			array(
				'rule'     => array('validateExistingRecord'),
				'message'  => 'User has already rated this suggestion',
				'required' => 'create'
			)
		),
		'vote' => array(
			'rule'     => 'numeric',
			'message'  => 'Vote value must be either 0 or 1',
			'required' => 'create'
		)
	);

	public function validateThoughtId($check) {
		return $this->Thought->find('first', array('contain' => array(), 'conditions' => array('Thought.id' => $check['thought_id'])));
	}

	public function validateUserId($check) {
		return $this->User->find('first', array('contain' => array(), 'conditions' => array('User.id' => $check['user_id'])));
	}

	public function validateExistingRecord($check) {
		if (!isset($this->data[$this->alias]['thought_id'])) {
			return true;
		}
		return !$this->find('first', array('contain' => array(), 'conditions' => array('thought_id' => $this->data[$this->alias]['thought_id'], 'user_id' => $check['user_id'])));
	}



}
