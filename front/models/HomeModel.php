<?php
namespace Models;

class HomeModel extends Database {
    
    // get 3 featured categories to show in homepage    
    public function getSelectedCategories() : array {
        $sql = "SELECT * FROM tbl_category LIMIT 3";
        return $this->findAll($sql);
    }
    
    // get all categories
    public function getAllCategories() : array {
        $sql = "SELECT * FROM tbl_category";
        return $this->findAll($sql);
    }
    
    // get all items in collection
    public function getAllCollections() : array {
        $sql = "SELECT * FROM tbl_collection";
        return $this->findAll($sql);
    }
    
    // search among collection using keyword
    public function searchCollections($keyword) : array {
        $sql = "SELECT * FROM tbl_collection WHERE title LIKE '%$keyword%' OR description LIKE '%$keyword%'";
        return $this->findAll($sql);
    }
    
    // get all collection items belong to one category based on Id
    public function getCategoryItems($title) : array {
        $sql = "SELECT * FROM tbl_collection WHERE category_name='$title'";
        return $this->findAll($sql);
    }
    

    // search among categories using keyword
    public function searchCategories($keyword) : array {
        $sql = "SELECT * FROM tbl_category WHERE title LIKE '%$keyword%'";
        return $this->findAll($sql);
    }
    

}
