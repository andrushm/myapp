<?php

App::uses('CroogoAppController', 'Croogo.Controller');


/**
 * Base Application Controller
 *
 * @package  Croogo
 * @link     http://www.croogo.org
 */
class AppController extends CroogoAppController {

    public $components = array(
        'Croogo',
        'Acl',
        'Auth',
        'Acl.AclFilter',
        'Session',
        'RequestHandler',
        'Cookie',
        'DebugKit.Toolbar'
    );

    /**
     *  Current user info
     *
     * @var array
     */
    var $curUser = null;

    public function beforeFilter(){
        $this->Auth->loginAction = array('controller' => 'MyUsers',
                                      'action' => 'login',
                                      'plugin' => null
     );
        $this->curUser = $this->Auth->user();
//        var_dump($this->curUser['id']);
        $this->set('loged_user', $this->curUser);
    }



//    public function __construct()
//    {
//
//        $this->Users->Auth->loginAction = array('controller' => 'MyUsers',
//            'action' => 'login',
//            'plugin' => null
//        );
//    }
}
