<?php

namespace Models;

// Collection model: all methods for collection-related SQL rackets

class CollectionModel extends Database
{
    // to fetch all registered collections, using findAll method from databaseModel
    public function getAllCollections() : array {
        $sql = "SELECT * FROM tbl_collection";
        return $this->findAll($sql);
    }
    
    // to fetch all active categories
    public function getAllActiveCategories() : array {
        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
        return $this->findAll($sql);
    }
    
    
    // add category
    public function addCollection(): void {
        if(isset($_POST['submit'])) {
         
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
                    
            // check if radio button for featured and active are checked or not
            if(isset($_POST['featured'])) {
                        $featured = $_POST['featured'];
            }
            else {
                $featured ="No";
            }
                    
            if(isset($_POST['active'])) {
                $active = $_POST['active'];
            }
            else {
                $active ="No";
            }

            
            // upload the image: we need image name, source path and destination path
            if(isset($_FILES['image']['name'])) {

                $image_name = $_FILES["image"]["name"];
                $tmp = explode('.', $image_name);
                $ext = end($tmp);

                // rename the image: e.g. Jewelry_Category_123.jpg
                $image_name = "collection_".rand(000, 999).'.'.$ext; 
                  
                $source_path = $_FILES["image"]["tmp_name"];
                $destination_path = "../public/img/collection/".$image_name;
                  
                //finally upload the image
                $upload = move_uploaded_file($source_path, $destination_path);
                  
                // check if the image is uploaded or not
                // and if the image is not uploaded then we will stop the process and redirect with error message
                if($upload==false) {
                    $_SESSION['upload'] = "<div class='error'> Failed to upload image.</div>";
                    header('Location: index.php?road=manageCollection');
                    die(); //stop the process
                }
            }
            else {
                //don't upload image and set the image_name value as blank
                $image_name="";
            }
             
            // prepare SQL query to insert category into database
            $sql = "INSERT into tbl_collection SET
                  title='$title', 
                  description='$description',
                  price='$price',
                  image_name='$image_name',
                  category_name='$category',
                  featured='$featured',
                  active='$active'";
            $query = $this->bdd->prepare($sql);
            $res = $query->execute();
            $query->closeCursor(); 
    
            // check if the query executed od not and  data added or not
            if($res==TRUE) {
                // query executed and category added --> redirect to manageCollection view
                $S_SESSION['add'] = "<div class='success'> Category Added Successfully. </div>";
                header('Location: index.php?road=manageCollection');
            }
            else {
                // failed to add category --> redirect to addCollection view
                $_SESSION['add'] = "<div class='error'> Failed to Add Catgeory. </div>";
                header('Location: index.php?road=addCollection');
            }
              
        }
    }
    
    
    // get a collection by its id
    public function getCollectionById($id) : array {
        $sql = "SELECT * FROM tbl_collection WHERE id=$id";
        return $this->getOneById($sql);
    }
    
    // delete a collection from database, also remove its image
    public function deleteCollection($id): void {
        $data = $this->getCollectionById($id); // gather the info before deleting
        $image_name = $data['image_name'];
        $sql = "DELETE FROM tbl_collection WHERE id=$id";
        $query = $this->bdd->prepare($sql);
        $res = $query->execute();

        if($res==true)  {
            // query succesfull deleted --> remove image
            if($image_name !="") {
                $remove_path = "../public/img/collection/".$image_name;
                $remove = unlink($remove_path);

                // check if the image removed or not
                // if failed to remove display the message and stop the process
                if($remove==false) {
                    $_SESSION ['failed-remove'] = "Failed to remove image";
                    header('Location: index.php?road=manageCollection');
                    die(); //stop the process
                }
            }
            
            //create session variable to display message
            $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully!</div>";
            header('Location: index.php?road=manageCollection');
        }
        else {
            // failed deleted admin
            //create session variable to display message
            $_SESSION['delete'] = "<div class='error'>Failed to delete admin! Try again later!</div>";
            header('Location: index.php?road=manageCollection');
        }
    }
    
    
    // update an existing collection
    public function updateCollection()  {
        if(isset($_POST['submit'])) {
    
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $current_image = $_POST['current_image'];
            $featured = $_POST ['featured'];
            $active =  $_POST ['active'];
            
            // update a new image
            // check if image selected or not
            if(isset($_FILES['image']['name'])) {
                //get the image details
                $image_name = $_FILES["image"]["name"];     

                // check if image available or not, upload the new image, remove the old one
                if($image_name !="") {
                    $tmp = explode('.', $image_name);        
                    $ext = end($tmp);
                  
                    //rename the image
                    $image_name = "collection_".rand(000, 999).'.'.$ext; // e.g. Jewelry_Category_123.jpg
                    $source_path = $_FILES["image"]["tmp_name"];
                    $destination_path = "../public/img/collection/".$image_name;
                    $upload = move_uploaded_file($source_path, $destination_path);
                      
                    //check if the image is uploaded or not
                    //and if the image is not uploaded then we will stop the process and redirect with error message
                    if($upload==false) {
                        $_SESSION['upload'] = "<div class='error'> Failed to upload image.</div>";
                        header('Location: index.php?road=manageCollection');
                        die();
                    }
                    // remove current image
                    if($current_image!="") {
                        $remove_path = "../public/img/collection/".$current_image;
                        $remove = unlink($remove_path);

                        // check if the image removed or not
                        // if failed to remove display the message and stop the process
                        if($remove==false) {
                            $_SESSION ['failed-remove'] = "Failed to remove current_image";
                            header('Location: index.php?road=manageCollection');
                            die(); //stop the process
                        }
                    }
                }
                else {
                    $image_name = $current_image;
                }
            }
            else {
                $image_name = $current_image;
            }

            // Update the database
            $sql = "UPDATE tbl_collection SET
                    title='$title', 
                    description='$description',
                    price='$price',
                    image_name='$image_name',
                    category_name='$category',
                    featured='$featured',
                    active='$active'
                WHERE id = $id
                ";
            
            $query = $this->bdd->prepare($sql);
            $res = $query->execute();
            $query->closeCursor(); 
            
            if($res == true)
            {
                //category updated
                $_SESSION['update'] = "Category updated successfully";
                header('Location: index.php?road=manageCollection');
            }
            else
            {
                $_SESSION['update'] = "Failed to update";
                header('Location: index.php?road=manageCollection');
            }
        }
    }
    
}