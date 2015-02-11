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
        $this->debug(true,true,true);
    }

    function debug($var = false, $showHtml = false, $showFrom = true) {
        if (Configure::read() > 0) {
            if ($showFrom) {
                $calledFrom = debug_backtrace();
                echo '<strong>' . substr(str_replace(ROOT, '', $calledFrom[0]['file']), 1) . '</strong>';
                echo ' (line <strong>' . $calledFrom[0]['line'] . '</strong>)';
            }
            echo "\n<pre class=\"cake-debug\">\n";

            $var = print_r($var, true);
            if ($showHtml) {
                $var = str_replace('<', '&lt;', str_replace('>', '&gt;', $var));
            }
            echo $var . "\n</pre>\n";
        }
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
