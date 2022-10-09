<?php

namespace Controllers;

class OrderController {
    
    // get all orders for manage-order view
    public function getAllOrders() {
        $model = new \Models\OrderModel();
        $data = $model->getAllOrders();
        $template = 'manage-order.phtml';
        include_once 'views/layout.phtml';
    }
    
    // delete an existing order
    public function deleteOrder($id) {
        $model = new \Models\OrderModel();
        $model->deleteOrder($id);
    }
    
    // show update order view pre-filled with id
    public function goUpdateOrder($id) {
        $model = new \Models\OrderModel();
        $data = $model->getOrderById($id);
        $template = 'update-order.phtml';
        include_once 'views/layout.phtml';
    }
    
    // update order in tbl_order
    public function updateOrder() {
        $model = new \Models\OrderModel();
        $model->updateOrder();
    }
    
}
