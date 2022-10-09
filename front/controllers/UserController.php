<?php

namespace Controllers;

class UserController{

    // to to auth page: login or register
    public function goAuth() {
        $template = 'auth.phtml';
        include_once 'views/layout.phtml';
    }
    
    // show registration form
    public function goRegister() {
        $template = 'register.phtml';
        include_once 'views/layout.phtml';
    }
    
    // show login from
    public function goLogin() {
        $template = 'login.phtml';
        include_once 'views/layout.phtml';
    }
    
    // register user using data in the form
    public function register() {
        $model = new \Models\UserModel();
        $model->register();
    }
    
    // login the user
    public function login() {
        $model = new \Models\UserModel();
        $model->login();
    }
    
    // logout the user
    public function logout() {
        $model = new \Models\UserModel();
        $model->logout();
    }
}
