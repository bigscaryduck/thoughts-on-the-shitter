<?php

App::uses('AppController', 'Controller');

class AdminAppController extends AppController {

	/**
     * Components
     *
     * @var array
     */
	public $components = array(
		'Session' => array('className' => 'AppSession'),
		'Paginator',
		'Filter',
	);
	
	/**
	 * Helpers
 	 *
 	 * @var array
 	 */		
	public $helpers = array(
		'Html' => array('className' => 'AppHtml'),
		'Time' => array('className' => 'AppTime'),
		'Form' => array('className' => 'BootstrapForm'),
		'Paginator' => array('className' => 'BootstrapPaginator'),
	);	

	/**
     * Pagination Settings
     *
     * @var array
     */		
	public $paginate = array(
	    'limit'     => 20,
	    'maxLimit'  => 200,
	    'paramType' => 'querystring'
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
	 * Checks if provided user is authorized for request.
	 *
	 * @param array $user The user to check the authorization of. If empty the user in the session will be used.
	 * @param CakeRequest $request The request to authenticate for. If empty, the current request will be used.
	 * @return boolean
	 */    
	public function isAuthorized($user = null, CakeRequest $request = null) {
		if (!parent::isAuthorized($user, $request)) {
			return false;
		}
		return true;
	}
	
	/**
	 * Called after controller action.
	 *
	 * @return void
	 */	
    public function beforeRender() {
    	parent::beforeRender();
	    return true;
    }
   
}









