<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {
	/**
	 * Default list of behaviors to load for all models.
	 * passed to behaviors by using the behavior name as index.
	 *
	 * @var array
	 */
	public $actsAs = array(
		'Containable'
	);


	/**
	 * Handles custom method calls, like findBy<field> for DB models,
	 * and custom RPC calls for remote data sources.
	 *
	 * Added: Magic read/write/remove utility for model data.
	 * Example: $model->getUserId(), $model->setUserId(2), $model->unsetUserId()
	 *
	 * @param string $method Name of method to call.
	 * @param array $params Parameters for the method.
	 * @return mixed Whatever is returned by called method
	 */
	public function __call($method, $params) {
		$mapMethods = array(
			'/(get)(\w+)/',
			'/(set)(\w+)/',
			'/(unset)(\w+)/',
		);
		foreach ($mapMethods as $pattern) {
			if (preg_match($pattern . 'i', $method, $matches)) {
				$name = Inflector::underscore($matches[2]);
				switch ($matches[1]) {
					case 'get':
						return isset($this->data[$this->alias][$name])
							? $this->data[$this->alias][$name]
							: null;
						break;
					case 'set':
						return $this->set($name, array_shift($params));
						break;
					case 'unset':
						if (isset($this->data[$this->alias][$name])) {
							unset($this->data[$this->alias][$name]);
						}
						return true;
						break;
				}
			}
		}
		$result = $this->Behaviors->dispatchMethod($this, $method, $params);
		if ($result !== array('unhandled')) {
			return $result;
		}
		$return = $this->getDataSource()->query($method, $params, $this);
		return $return;
	}


	/**
	 * Provides a read accessor for $this->data. Implements code used by Hash::get()
	 * but uses model as default data source.
	 *
	 * @param string|array $path The path being searched for. Either a dot separated string, or an array of path segments.
	 * @return mixed The value being read or null
	 */
	public function data($path) {
		$data = $this->data;
		if (empty($data)) {
			return null;
		}
		if (is_string($path) || is_numeric($path)) {
			$parts = explode('.', $path);
		} else {
			$parts = $path;
		}
		foreach ($parts as $key) {
			if (is_array($data) && isset($data[$key])) {
				$data =& $data[$key];
			} else {
				return null;
			}
		}
		return $data;
	}


	/**
	 * Saves model data and then sets it back on the model
	 *
	 * @param mixed
	 * @return array
	 */
	public function save($data = null, $validate = true, $fieldList = array()) {
		$data = parent::save($data, $validate, $fieldList);
		if (is_array($data)) {
			$this->data = $data;
		}
		return $data;
	}

	/**
	 * Saves model field and restores previously set data.
	 *
	 * @return mixed
	 */
	public function saveField($name, $value, $validate = false) {
		$data = parent::saveField($name, $value, $validate);
		if (is_array($data)) {
			$this->data = $data;
		}
		return $data;
	}


	/**
	 * Returns array of validation errors in single-dimension array format
	 *
	 * @return array
	 */
	public function validationErrorList() {
		$errors = array();
		foreach ((array)$this->validationErrors as $field => $err) {
			if (array_key_exists($field, $this->validate)) {
				$errors[$field] = array_shift($err);
			}
		}
		return $errors;
	}



}
