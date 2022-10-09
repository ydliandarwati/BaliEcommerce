<?php

namespace Controllers;

class CollectionController {

    // show all collections for manage-collection view
    public function getAllCollections() {
        $model = new \Models\CollectionModel();
        $data = $model->getAllCollections();
        $template = 'manage-collection.phtml';
        include_once 'views/layout.phtml';
    }
    
    // go to add collection view
    public function goAddCollection() {
        $model = new \Models\CollectionModel();
        $data = $model->getAllActiveCategories();
        $template = 'add-collection.phtml';
        include_once 'views/layout.phtml';
    }
    
    // add collection to database
    public function addCollection() {
        $model = new \Models\CollectionModel();
        $model->addCollection();
    }
    
    // delete an existing collection
    public function deleteCollection($id) {
        $model = new \Models\CollectionModel();
        $model->deleteCollection($id);
    }
    
    // show update collection view with pre-filled info from id
    public function goUpdateCollection($id) {
        $model = new \Models\CollectionModel();
        $data_all = $model->getAllActiveCategories();
        $data = $model->getCollectionById($id);
        $template = 'update-collection.phtml';
        include_once 'views/layout.phtml';
    }
    
    // update collection in database
    public function updateCollection() {
        $model = new \Models\CollectionModel();
        $model->updateCollection();
    }
    

   
}
