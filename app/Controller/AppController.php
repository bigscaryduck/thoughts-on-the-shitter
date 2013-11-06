<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	/**
	 * Default application components.
	 *
	 * @var array
	 */
	public $components = array(
		'Session',
		'Cookie',
		'Auth' => array(
			'authenticate' => array(
				'Blowfish' => array(
					'userModel' => 'User',
					'fields'    => array('username' => 'email', 'password' => 'password'),
					'contain'   => array('Role'),
					'scope'     => array('User.password !=' => null),
				)
			),
			'authorize' => 'Controller',
			'loginAction' => array(
				'plugin'     => false,
				'controller' => 'pages',
				'action'     => 'signup',
			),
			'loginRedirect' => array(
				'plugin'     => false,
				'controller' => 'pages',
				'action'     => 'home',
			)
		),
		'EmailResponder',
		//'DebugKit.Toolbar'
	);


	/**
	 * Default application helpers.
	 *
	 * @var mixed A single name as a string or a list of names as an array.
	 */
	public $helpers = array(
		'Session',
		'Form',
		'Html',
		'Text'
	);


	/**
	 * Declare custom view class
	 *
	 * @var string
	 */
	public $viewClass = 'Enhanced';


	/*
	 * Declare custom view class
	 *
	 * @var string
	 */
	//public $theme = 'Darelicious';


	/**
	 * Holds default configuration settings for pagination
	 *
	 * @var array
	 */
	public $paginate = array(
		'paramType' => 'querystring',
		'limit'     => 20
	);

/*	public function forceSSL() {
		$this->redirect('https://' . $_SERVER['SERVER_NAME'] . $this->here);
	}

	public function removeSSL() {
		$this->redirect('http://' . $_SERVER['SERVER_NAME'] . $this->here);
	}*/

	/**
	 * Called before the controller action.  Used for configuring and/or customizing components
	 * or performing logic that needs to happen before each controller action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		if ($user = $this->Auth->user()) {
			$publicFields = array('first_name', 'last_name', 'facebook_id', 'image');
			$this->set('_currentUser', array_intersect_key($user, array_flip($publicFields)));
		}
		/*if($this->secureActions){
			if (in_array($this->params['action'], $this->secureActions)    && !isset($_SERVER['HTTPS'])) {
				$this->forceSSL();
			}
		} elseif(isset($_SERVER['HTTPS'])) {
			$this->removeSSL();
		}*/

	}


	/**
	 * Authorization adapter for AuthComponent. Provides the ability to authorize using a controller callback.
	 *
	 * @param array $user The user to check the authorization for.
	 */
	public function isAuthorized($user)
	{
		return true;
	}


	/**
	 * Called after the controller action is run, but before the view is rendered.
	 *
	 * @return void
	 */
	public function beforeRender()
	{
		if ($this->name == 'CakeError') {

		}
	}
}
