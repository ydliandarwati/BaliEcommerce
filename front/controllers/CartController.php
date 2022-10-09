<?php

namespace Controllers;

class CartController{
    
    // get info using getCart method --> display cart
    public function displayCart() {
        $model = new \Models\CartModel();
        $data = $model->getCart();
        $template = 'cart.phtml';
        include_once 'views/layout.phtml';
    }
    
    // add selected item to cart using addToCart method
    // then saveCart to save info in tbl_order, and show cart using getCart
    public function addToCart() {
        $model = new \Models\CartModel();
        $model->addToCart();
        $model->saveCart();
        $data = $model->getCart();
        $template = 'cart.phtml';
        include_once 'views/layout.phtml';
    }
    
    // remove selected item from cart, then save and show cart
    public function removeFromCart() {
        $model = new \Models\CartModel();
        $model->removeFromCart();
        $model->saveCart();
        $data = $model->getCart();
        $template = 'cart.phtml';
        include_once 'views/layout.phtml';
    }
    
    
    // empty cart form all items, emptyCart method also modifies tbl_order
    public function emptyCart() {
        $model = new \Models\CartModel();
        $model->emptyCart();
        $data = $model->getCart();
        $template = 'cart.phtml';
        include_once 'views/layout.phtml';
    }
    
    // decrease quantity by one, then save and show cart
    public function downQty() {
        $model = new \Models\CartModel();
        $model->downQty();
        $model->saveCart();
        $data = $model->getCart();
        $template = 'cart.phtml';
        include_once 'views/layout.phtml';
    }
    
    // increase quantity by one, then save and show cart
    public function upQty() {
        $model = new \Models\CartModel();
        $model->upQty();
        $model->saveCart();
        $data = $model->getCart();
        $template = 'cart.phtml';
        include_once 'views/layout.phtml';
    }
    
    // get info to pre-fill final step before validating order
    public function getCommanderDetails() {
        $model = new \Models\CartModel();
        $data = $model->getCommanderData();
        $template = 'getCommanderDetails.phtml';
        include_once 'views/layout.phtml';
    }
    
    // validate order, which saves the order in tbl_order with status "validated"
    public function validateCart() {
        $model = new \Models\CartModel();
        $model->validateCart();
    }
}


