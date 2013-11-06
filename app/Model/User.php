<?php

App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');

class User extends AppModel {

	public $name = 'User';
	public $belongsTo = array(
		'Role' => array(
			'className' => 'UserRole',
			'foreignKey' => 'role_id',
			'fields' => array('id', 'name', 'access_level'),
		)
	);
	public $hasMany = array(
		'Thought' => array(
			'className' => 'Thought',
			'foreignKey' => 'user_id'
		),
		'ThoughtFlag' => array(
			'className' => 'ThoughtFlag',
			'foreignKey' => 'user_id'
		),
		'ThoughtVote' => array(
			'className' => 'ThoughtVote',
			'foreignKey' => 'user_id'
		)
	);
	public $validate = array(
		'first_name' => array(
			'notEmtpy' => array(
				'rule' => 'notEmpty',
				'message' => 'First name is required',
			),
			'alphaNumeric' => array(
				'rule'    => '/[a-z0-9 -]$/i',
				'required' => true,
				'message' => 'One or more characters used for First Name not allowed.'
			)
		),
		'last_name' => array(
			'notEmtpy' => array(
				'rule' => 'notEmpty',
				'message' => 'Last name is required',
			),
			'alphaNumeric' => array(
				'rule'    => '/[a-z0-9 -]$/i',
				'required' => true,
				'message' => 'One or more characters used for Last Name not allowed.'
			)
		),
		'email' => array(
			'email' => array(
				'rule' => 'email',
				'message' => 'Invalid email',
				'required' => 'create'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Email is already taken',
				'required' => 'create',
			)
		),
		'email_match' => array(
			'rule' => array('validateEmailMatch'),
			'message' => 'Emails do not match',
			'required' => 'create'
		),
		'pwd' => array(
			'minLength' => array(
				'rule' => array('minLength', '8'),
				'message' => 'Password must be at least 8 characters',
				'required' => 'create'
			),
		),
		'pwd_match' => array(
			'rule' => array('validatePasswordMatch'),
			'message' => 'Passwords do not match',
			'required' => 'create'
		),
		'pwd_current' => array(
			'rule'     => array('validateCurrentPwd'),
			'message'  => 'Password does not match our records',
		),
		'role_id' => array(
			'rule' => array('validateUserRole'),
			'message' => 'Invalid role id',
		)
	);

	/**
	 * Virtual Fields
	 *
	 * @var array
	 */
	public $virtualFields = array(
		'full_name' => "CONCAT(User.first_name, ' ' , User.last_name)",
	);

	/**
	 * Validates user role id
	 *
	 * @return boolean
	 */
	public function validateUserRole($check) {
		return $this->Role->findById($check['role_id']);
	}

	/**
	 * Validates password match
	 *
	 * @return boolean
	 */
	public function validatePasswordMatch($check) {
		return isset($this->data[$this->alias]['pwd']) && $this->data[$this->alias]['pwd'] === $check['pwd_match'];
	}

	/**
	 * Validates current password
	 *
	 * @return boolean
	 */
	public function validateCurrentPwd($check) {
		$cur = $this->getPassword();
		if (!$cur) {
			if (!$cur = $this->field('password', array('id' => $this->getId()))) {
				return false;
			}
		}
		return $cur == Security::hash($check['pwd_current'], 'blowfish', $cur);
	}

	public function validateEmailMatch($check) {
		return isset($this->data[$this->alias]['email']) && $this->data[$this->alias]['email'] === $check['email_match'];
	}

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			unset($this->data[$this->alias]['password']);
		}
		if (isset($this->data[$this->alias]['pwd'])) {
			$hash = Security::hash($this->data[$this->alias]['pwd'], 'blowfish');
			$this->data[$this->alias]['password'] = $hash;
		}
		if (!$this->getId() && empty($this->data[$this->alias]['role_id'])) {
			$this->set('role_id', $this->Role->getDefaultRoleId());
		}
	}

	public function afterSave($created) {
		if ($created) {
			$this->getEventManager()->dispatch(new CakeEvent('Model.User.afterCreate', $this, array(
				'user' => $this->data
			)));
		}
	}

	public function createFacebookUser($data, $options = array()) {
		if (is_object($data) && $data instanceof Model) {
			if (isset($data->data[$data->alias])) {
				$data = $data->data[$data->alias];
			}
		}
		if (!is_array($data)) {
			return false;
		}
		$data = array_filter($data);

		$fieldList = array();
		foreach ($data as $key => &$value) {
			$value = trim($value);
			if (array_key_exists($key, $this->validate)) {
				$fieldList[] = $key;
			}
		}

		$this->create($data);
		if (!$this->validates(array('fieldList' => $fieldList))) {
			return false;
		}

		$this->save(null, false);
		return $this->id;
	}

}