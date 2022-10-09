<?php

namespace Controllers;

class AdminController {

    // add admin
    public function addAdmin() {
        $model = new \Models\AdminModel();
        $model->addAdmin();
    }
    
    // update existing admin
    public function updateAdmin() {
        $model = new \Models\AdminModel();
        $model->updateAdmin();
    }
    
    // update password
    public function updatePassword() {
        $model = new \Models\AdminModel();
        $model->updatePassword();
    }
    
    // delete an existing admin
    public function deleteAdmin($id) {
        $model = new \Models\AdminModel();
        $model->deleteAdmin($id);
    }
    
    // get all admins to show for manage-admin view
    public function getAllAdmins() {
        $model = new \Models\AdminModel();
        $data = $model->getAllAdmins();
        $template = 'manage-admin.phtml';
        include_once 'views/layout.phtml';
    }
    
    // show update admin view with pre-filled info from id
    public function goUpdateAdmin($id) {
        $model = new \Models\AdminModel();
        $data = $model->getAdminById($id);
        $template = 'update-admin.phtml';
        include_once 'views/layout.phtml';
    }
    
    // show add admin view
    public function goAddAdmin() {
        $template = 'add-admin.phtml';
        include_once 'views/layout.phtml';
    }
    
    // show update passowrd view
    public function goUpdatePassword($id) {
        $model = new \Models\AdminModel();
        $template = 'update-password.phtml';
        include_once 'views/layout.phtml';
    }
    
    // get admin info from id
    public function getAdminById($id) : array {
        $model = new \Models\AdminModel();
        return $model->getAdminById($id);
    }
    
    // go to home view: needs the count of orders/collections/categories
    public function goHome() {
        $model = new \Models\AdminModel();
        list($ordCount, $catCount, $colCount) = $model->countDashboard();
        $template = 'home.phtml';
        include_once 'views/layout.phtml';
    }
    
    // login the admin
    public function login() {
        $model = new \Models\AdminModel();
        $model->login();
    }
    
    // go to login view
    public function goLogin() {
        include_once 'views/login.phtml';
    }
    
    // logout user
    public function logout() {
        $model = new \Models\AdminModel();
        $model->logout();
    }

   
}
