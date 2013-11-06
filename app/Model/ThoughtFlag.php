<?php

App::uses('AppModel', 'Model');

class ThoughtFlag extends AppModel {

	public $name = 'ThoughtFlag';
	
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
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


	
	/** 
 	 * Handles the adding/removing/changing of votes
 	 * 
 	 * @return 
 	 */	    
    public function processFlag($thought_id, $user_id) {
    	
		if (!$user_id) {
			throw new CakeException('You must be logged in to perform this action');
		}			
		elseif (!is_numeric($thought_id)) {
			throw new CakeException('Invalid object id');
		}
		else {
			$prev = $this->find('first', array('contain' => array(), 'conditions' => array('ThoughtFlag.thought_id' => $thought_id, 'ThoughtFlag.user_id' => $user_id)));
				if ($prev) {
					$this->query(sprintf("DELETE FROM flags WHERE flags.object_type = %d AND flags.object_id = %d AND flags.user_id = %d", $thought_id, $user_id));
				} else {
				
					$result = $this->save(array(
						'object_id' => $thought_id,
						'user_id' => $user_id,			
					), false);
					if (!$result) {
						throw new CakeException('Unable to apply flag');
					}
				}
			}    	
    	return true;
    }	

	/**
	 * Called after each successful save operation.
	 *
	 * @param boolean $created True if this save created a new record
	 * @return void
	 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
	 */
	public function afterSave($created) {
		/*if ($created) {
			$this->getEventManager()->dispatch(new CakeEvent('Model.Flag.afterCreate', $this));
		}*/
	}	
			
}