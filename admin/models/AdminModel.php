<?php
namespace Models;


class AdminModel extends Database {

    // add admin
    public function addAdmin(): void {
        if(isset($_POST['submit'])) {
            // get the data from form
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
            $password = hash("sha256", $_POST['password']); // password encryption with sha256
    
            
            // check if username already exists
            $query = $this->bdd->prepare("SELECT * FROM tbl_admin WHERE username=?");
            $query->execute([$username]); 
            $user = $query->fetch();
            
            if ($user) {
                // username already exists: ask user to choose another username
                $_SESSION['addadmin'] = "<div class='error'>This username is already taken! Please choose another one.</div>";
                header('Location: index.php?road=goAddAdmin');
            } else {
                // username does not exist --> add user to database
                $sql = "INSERT INTO tbl_admin SET
                        fullname='$fullname',
                        username='$username',
                        password='$password'
                        ";
                $query = $this->bdd->prepare($sql);
                $res = $query->execute();
                $query->closeCursor(); 
    
                
                // check if data inserted or not and display the message
                if($res==TRUE) {
                    // admin added successfully: redirect to manage-admin view
                    $_SESSION['addadmin'] = "<div class='success'>Admin added successfully!</div>";
                    header('Location: index.php?road=manageAdmin');
                }
                else {
                    // failed to add: go back to add-admin view
                    $_SESSION['addadmin'] = "<div class='error'> Failed to add admin.</div>";
                    header('Location: index.php?road=addAdmin');
                }
            }
        }
    }
    
    // to update an existing admin
    // it receives the new data of an existing admin from a form in update-admin.phtml
    // then uses this information for update SQL query
    public function updateAdmin()  {
        if(isset($_POST['submit'])) {
    
            $id       = $_POST['id'];
            $fullname = $_POST['fullname'];
            $username = $_POST['username'];
    
            $sql = "UPDATE tbl_admin SET
                    fullname = '$fullname',
                    username = '$username' 
                    WHERE id='$id'
                    ";
            $query = $this->bdd->prepare($sql);
            $res = $query->execute();
        
            
            if($res==TRUE) {
                // admin update successfully --> go to manage-admin view
                $_SESSION['updateadmin'] = "<div class='success'>Admin updated successfully.</div>";
                header("location: index.php?road=manageAdmin");
            }
            else {
                // failed to update admin --> go back to manage-admin view
                $_SESSION['updateadmin'] = "<div class='error'>Failed to update admin.</div>";
                header("location: index.php?road=manageAdmin");
            }
        }
    }
    
    
    // to update password of an existing admin
    // TODO 1: check if the old password is the correct one, otherwise refuse and outputs error
    // TODO 2: check if the new passowrd is confirmed correctly, if not warns the user.
    public function updatePassword()  {
        if(isset($_POST['submit'])) {
    
            $id     = $_POST['id'];
            $oldPWD_ = hash("sha256", $_POST['old_pwd']);
            $newPWD = hash("sha256", $_POST['new_pwd']);
            $newPWD_ = hash("sha256", $_POST['new_pwd_confirm']);
            
            // get original old password
            $query = $this->bdd->prepare("SELECT password FROM tbl_admin");
            $res = $query->execute();
            $oldPWD = $query->fetch();

            // if old passowrd is not correct
            if($oldPWD != $oldPWD_) {
                $_SESSION['updatepwd'] = "<div class='error'> Old passoword is not correct!</div>";
                header("Location: index.php?road=goUpdatePassword&id=<?=$id?>");
            }
            else {
                // if the new password has been repeated correctly --> update passowrd in database
                if($newPWD == $newPWD_) {
                    $sql = "UPDATE tbl_admin SET
                            password = '$newPWD'
                            WHERE id='$id'
                            ";
                    $query = $this->bdd->prepare($sql);
                    $res = $query->execute();
                
                    if($res==TRUE) {
                        $_SESSION['updatepwd'] = "<div class='success'>Password updated successfully.</div>";
                        header("Location: index.php?road=manageAdmin");
                    }
                    else {
                        $_SESSION['updatepwd'] = "<div class='error'>Failed to update passoword.</div>";
                        header("Location: index.php?road=manageAdmin");
                    }
                }
                else {
                    $_SESSION['updatepwd'] = "<div class='error'> You have entered two different new passowrds!</div>";
                    header("Location: index.php?road=goUpdatePassword&id=<?=$id?>");
                }
            }
        }
    }

    
    // delete admin: it directly execute delete query using the id received from the mange-admin.phtml
    public function deleteAdmin($id): void {
        $sql = "DELETE FROM tbl_admin WHERE id=$id";
        $query = $this->bdd->prepare($sql);
        $res = $query->execute();
     
        if($res==true)  {
            // succesfull delete
            //create session variable to display message
            $_SESSION['deleteadmin'] = "<div class='success'>Admin Deleted Successfully!</div>";
            header('Location: index.php?road=manageAdmin');
        }
        else {
            // failed deleted admin
            //create session variable to display message
            $_SESSION['deleteadmin'] = "<div class='error'>Failed to delete admin! Try again later!</div>";
            header('Location: index.php?road=manageAdmin');
        }
    }


    // to fetch all registered admins, using findAll method from databaseModel
    public function getAllAdmins() : array {
        $sql = "SELECT * FROM tbl_admin";
        return $this->findAll($sql);
    }
    

    // to get one specific admin using its id, using getOneById method from databaseModel
    public function getAdminById($id) : array {
        $sql = "SELECT * FROM tbl_admin WHERE id=$id";
        return $this->getOneById($sql);
    }
    

    // admin login
    public function login() {
        if(isset($_POST['submit'])) {
            // get data from login form
            $username = $_POST['username'];
            $password = hash("sha256", $_POST['password']);
     
            // SQL to check if the user with usuername and password exists or not
            $sql = "SELECT * FROM tbl_admin WHERE username=? AND password=?";
            $query = $this->bdd->prepare($sql);
            $res = $query->execute([$username, $password]);

            // count rows to check if the user exists or not
            $count = $query->rowCount();

            if ($count==1) {
                // user available and login success
                $_SESSION['user'] = $username;
                $_SESSION['login'] = "You are logged in ".$username."!" ;
                //redirect to homepage
                header('Location: index.php?road=home');
            }
            else {
                // user not available
                $_SESSION['login'] = "<div class='error'> Login Failed. Please try again! </div>";
                //redirect to homepage
                header('Location: index.php?road=goLogin');
            }
        }
    }
    
    
    // logout the user
    public function logout() {
        session_destroy(); // destroy the session
        header('Location: index.php?road=goLogin'); // redirect to logih 
    }


    // to count how many order/collection/category
    public function countDashboard() {
        $ordCount = $this->countUniqueEntries('tbl_order', 'order_id');
        $catCount = $this->countEntries('tbl_category');
        $colCount = $this->countEntries('tbl_collection');
        return array($ordCount, $catCount, $colCount);
    }
}
