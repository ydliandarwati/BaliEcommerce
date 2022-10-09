<?php
session_start();

require ('../admin/config/config.php');
spl_autoload_register(function($class) {
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';
});

if(array_key_exists('road', $_GET)) :
    switch($_GET['road']) {
        
        // go to home
        case 'home':
            $controller = new Controllers\HomeController();
            $controller->goHome();
            break;
            
        // go to categories
        case 'categories':
            $controller = new Controllers\HomeController();
            $controller->displayCategories();
            break;
            
        // go to collections
        case 'collections':
            $controller = new Controllers\HomeController();
            $controller->displayCollections();
            break;
    
        // show search results (from home)
        case 'search':
            $controller = new Controllers\HomeController();
            $controller->showSearchResults();
            break;
        
        // go to shopping cart
        case 'cart':
            $controller = new Controllers\CartController();
            $controller->displayCart();
            break;
        
        // add selected item to cart
        case "addCart":
            $controller = new Controllers\CartController();
            $controller->addToCart();
	        break;
	       
        // remove selected item from cart
	    case "removeCart":
            $controller = new Controllers\CartController();
            $controller->removeFromCart();
        	break;
    	
    	// empty the shopping cart completely
        case "emptyCart":
            $controller = new Controllers\CartController();
            $controller->emptyCart();
            break;
            
        // add 1 to the quantity in the cart
        case "upQty":
            $controller = new Controllers\CartController();
            $controller->upQty();
        	break;
        	
        // remove one from quantity in the cart
        case "downQty":
            $controller = new Controllers\CartController();
            $controller->downQty();
        	break;
        
        // go to login/register page
        case 'auth':
            $controller = new Controllers\UserController();
            $controller->goAuth();
	        break;
	        
	    // show register page
        case 'goRegister':
            $controller = new Controllers\UserController();
            $controller->goRegister();
	        break;
	        
	    // show login page
        case 'goLogin':
            $controller = new Controllers\UserController();
            $controller->goLogin();
	        break;
	        
	   // register the user (from the from, after all the necessary information added)
	   case 'register':
	       $controller = new Controllers\UserController();
	       $controller->register();
	       break;
	       
	   // login the user and upload cart from history
	   case 'login':
	       $controller = new Controllers\UserController();
	       $controller->login();
	       break;
	       
	   // logout the user
	   case 'logout':
            $controller = new Controllers\UserController();
            $controller->logout();
            break;
        
        // final info before validating the order
        case 'getCommanderDetails' :
            $controller = new Controllers\CartController();
            $controller->getCommanderDetails();
            break;
        
        // validate order and update the order table
        case 'validateCart':
            $controller = new Controllers\CartController();
            $controller->validateCart();
            break;
        
        // show all colections associated with a category (when user click on a cateogry)
        case 'showCategoryItems':
            $controller = new Controllers\HomeController();
            $controller->showCategoryItems();
            break;
        
        // go to contact page    
        case 'goContact':
            $controller = new Controllers\HomeController();
            $controller->goContact();
            break;
            
            
        // ------- if case not found,  go back to home view ------- //
        default:
            header('location: index.php?road=home');
            exit;
    }
else :
    header('Location: index.php?road=home');
    exit;

endif;