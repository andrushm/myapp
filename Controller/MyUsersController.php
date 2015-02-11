<?php
App::uses('UsersController', 'Users.Controller');
/**
 * Created by PhpStorm.
 * User: Mikhail
 * Date: 27.01.2015
 * Time: 17:43
 */
class MyUsersController extends UsersController {

    public function index(){
        die('hi!');
    }

    public function login(){
        parent::login();

        $this->render('login','full');
    }

    public function logout(){
        $this->Auth->logoutRedirect = array('controller' => 'MyUsers', 'action' => 'login');
        parent::logout();
    }
}