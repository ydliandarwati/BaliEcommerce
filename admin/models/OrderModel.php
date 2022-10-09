<?php

namespace Models;

class OrderModel extends Database
{
    // to fetch all registered categories, using findAll method from databaseModel
    public function getAllOrders() : array {
        $sql = "SELECT * FROM tbl_order";
        return $this->findAll($sql);
    }
    
    // get one order by its id
    public function getOrderById($id) : array {
        $sql = "SELECT * FROM tbl_order WHERE id=$id";
        return $this->getOneById($sql);
    }
    
    // delete order from tbl_order
    public function deleteOrder($id): void {
        $cat = $this->getOrderById($id); // gather the info before deleting
        $sql = "DELETE FROM tbl_order WHERE id=$id";
        $query = $this->bdd->prepare($sql);
        $res = $query->execute();

        if($res==true)  {
            // query succesfull deleted
            header('Location: index.php?road=manageOrder');
        }
        else {
            header('Location: index.php?road=manageOrder');
        }
    }
    
    
    // update an existing order
    public function updateOrder()  {
        if(isset($_POST['submit'])) {
            $id = $_POST['id'];
            $quantity = $_POST ['quantity'];
            $price = $_POST['price'];
            $address = $_POST ['address'];
            $status = $_POST ['status'];

            
            // update the database
            $sql = "UPDATE tbl_order SET
                    quantity = '$quantity',
                    article_price = '$price',
                    customer_address = '$address',
                    status = '$status'
            WHERE id = $id
            ";
            
            $query = $this->bdd->prepare($sql);
            $res = $query->execute();
            $query->closeCursor(); 
            
            if($res == true) {
                // order updated
                $_SESSION['update'] = "Order updated successfully.";
                header('Location: index.php?road=manageOrder');
            }
            else {
                // order update failed
                $_SESSION['update'] = "Failed to update order.";
                header('Location: index.php?road=manageOrder');
            }
        }
    }
}