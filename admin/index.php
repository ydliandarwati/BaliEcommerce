<?php

session_start();

require ('config/config.php');
spl_autoload_register(function($class) {
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';
});

if(array_key_exists('road', $_GET)) :
    switch($_GET['road']) {
    
            
        // home view
        case 'home':
            $controller = new Controllers\AdminController();
            $controller->goHome();
            break;
        
        // manage admin: to see all admins
        case 'manageAdmin':
            $controller = new Controllers\AdminController();
            $controller->getAllAdmins();
            break;
            
        // add admin in tbl_admin
        case 'addAdmin':
            $controller = new Controllers\AdminController();
            $controller->addAdmin();
            break;    
            
        
        // update admin from the from in DB
        case 'updateAdmin':
            $controller = new Controllers\AdminController();
            $controller->updateAdmin();
            break;
            
        // update passowrd in database
        case 'updatePassword':
            $controller = new Controllers\AdminController();
            $controller->updatePassword();
            break;
            
        
        // delete existing admin from database
        case 'deleteAdmin':
            $controller = new Controllers\AdminController();
            $controller->deleteAdmin($_GET['id']);
            break;   

        // show add admin view form
        case 'goAddAdmin':
            $controller = new Controllers\AdminController();
            $controller->goAddAdmin();
            break;             
            
        // show update admin view form
        case 'goUpdateAdmin':
            $controller = new Controllers\AdminController();
            $controller->goUpdateAdmin($_GET['id']);
            break; 
            
        // show update passsowrd view    
        case 'goUpdatePassword':
            $controller = new Controllers\AdminController();
            $controller->goUpdatePassword($_GET['id']);
            break; 
        
        // login the user
        case 'login':
            $controller = new Controllers\AdminController();
            $controller->login();
            break;
            
        // go to login view
        case 'goLogin':
            $controller = new Controllers\AdminController();
            $controller->goLogin();
            break;    
            
        // logout the user    
        case 'logout':
            $controller = new Controllers\AdminController();
            $controller->logout();
            break;
        
        
        // show manage category view
        case 'manageCategory':
            $contoller = new \Controllers\CategoryController();
            $contoller->getAllCategories();
            break;
            
        // show add category view form
        case 'goAddCategory':
            $controller = new Controllers\CategoryController();
            $controller->goAddCategory();
            break;  
            
        // add category in database
        case 'addCategory':
            $controller = new Controllers\CategoryController();
            $controller->addCategory();
            break;   
        
        // delete category from database
        case 'deleteCategory':
            $controller = new Controllers\CategoryController();
            $controller->deleteCategory($_GET['id']);
            break;   
            
            
        // show update cateogry view form
        case 'goUpdateCategory':
            $controller = new Controllers\CategoryController();
            $controller->goUpdateCategory($_GET['id']);
            break; 
            
        // update category from the from in DB
        case 'updateCategory':
            $controller = new Controllers\CategoryController();
            $controller->updateCategory();
            break;
            
        // show manage collection view
        case 'manageCollection':
            $contoller = new \Controllers\CollectionController();
            $contoller->getAllCollections();
            break;
            
        // show add collection view form
        case 'goAddCollection':
            $controller = new Controllers\CollectionController();
            $controller->goAddCollection();
            break;  


        // add collection via the from in DB
        case 'addCollection':
            $controller = new Controllers\CollectionController();
            $controller->addCollection();
            break;  
        
        // show update collection view form
        case 'goUpdateCollection':
            $controller = new Controllers\CollectionController();
            $controller->goUpdateCollection($_GET['id']);
            break; 
            
        // update collection from the from in DB
        case 'updateCollection':
            $controller = new Controllers\CollectionController();
            $controller->updateCollection();
            break;
            
        // delete collection in database
        case 'deleteCollection':
            $controller = new Controllers\CollectionController();
            $controller->deleteCollection($_GET['id']);
            break; 
        
        // go to manage-order view
        case 'manageOrder':
            $controller = new Controllers\OrderController();
            $controller->getAllOrders();
            break; 
            
            
        // delete order in tbl_order    
        case 'deleteOrder':
            $controller = new Controllers\OrderController();
            $controller->deleteOrder($_GET['id']);
            break; 
        
        // go to update-order view using id
        case 'goUpdateOrder':
            $controller = new Controllers\OrderController();
            $controller->goUpdateOrder($_GET['id']);
            break; 

        // update order in database
        case 'updateOrder':
            $controller = new Controllers\OrderController();
            $controller->updateOrder();
            break;
            
            
        // ------- if case not found,  go back to home view ------- //
        default:
            header('location: index.php?road=goLogin');
            exit;
    }

else :
    header('Location: index.php?road=goLogin');
    exit;

endif;