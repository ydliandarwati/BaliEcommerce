<?php

namespace Controllers;

class HomeController{

    // go to home
    public function goHome() {
        $model = new \Models\HomeModel();
        $cat = $model->getSelectedCategories();
        $col = $model->getAllCollections();
        $template = 'home.phtml';
        include_once 'views/layout.phtml';
    }
    
    // show all categories
    public function displayCategories() {
        $model = new \Models\HomeModel();
        $cat = $model->getAllCategories();
        $template = 'categories.phtml';
        include_once 'views/layout.phtml';
    }
    
    // show all collections in a category using title
    public function showCategoryItems() {
        $model = new \Models\HomeModel();
        $title = $_GET['title'];
        $col = $model->getCategoryItems($title);
        $template = 'collections.phtml';
        include_once 'views/layout.phtml';
    }
    
    // show all collections from all categories
    public function displayCollections() {
        $model = new \Models\HomeModel();
        $col = $model->getAllCollections();
        $template = 'collections.phtml';
        include_once 'views/layout.phtml';
    }
    
    
    // show search results
    public function showSearchResults() {
        $model = new \Models\HomeModel();
        $search = $_POST['search'];
        $col = $model->searchCollections($search);
        $cat = $model->searchCategories($search);
        $template = 'search.phtml';
        include_once 'views/layout.phtml';
    }
    
    // go to contact page
    public function goContact() {
        $template = 'contact.html';
        include_once 'views/layout.phtml';
    }
}
