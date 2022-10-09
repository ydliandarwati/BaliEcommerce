<?php
namespace Models;

class UserModel extends Database {

    // register the user
    public function register() : void {
        
        // grab all the info form the from
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = hash("sha256", $_POST['password']); // password encryption with sha256

        // connect to table and check if the user exists            
        $query = $this->bdd->prepare("SELECT * FROM tbl_user WHERE username=?");
        $query->execute([$username]); 
        $user = $query->fetch();
        if ($user) {
            // username already exists: give error
            header('Location: index.php?road=goRegister');
            $_SESSION['login'] = "<div class='error'> This username is already taken! Please choose another one. </div>";
        } 
        else {
            // username does not exist, add it to database
            // prepare SQL query to save the data into database
            $sql = "INSERT INTO tbl_user SET
                    firstname='$firstname',
                    lastname='$lastname',
                    username='$username',
                    email='$email',
                    password='$password'
                    ";
            $query = $this->bdd->prepare($sql);
            $res = $query->execute();
            $query->closeCursor(); 
    
                
            // check if data inserted or not and display the message
            if($res==TRUE) {
                $_SESSION['auth'] = true;
                $_SESSION['user'] = $username;
                $_SESSION['login'] = "<div class='success'> You are logged in successfully! </div>";
                //page redirection
                header('Location: index.php?road=home');
            }
            else {
                $_SESSION['login'] = "<div class='error'> Registration failed! Please try again. </div>";
                //page redirection
                header('Location: index.php?road=home');
            }
        }
    }

    // login the user
    public function login() {
        // get data from login form
        $username = $_POST['username'];
        $password = hash("sha256", $_POST['password']);
    
        // SQL to check if the user with usuername and password exists or not
        $sql = "SELECT * FROM tbl_user WHERE username=? AND password=?";
        $query = $this->bdd->prepare($sql);
        $res = $query->execute([$username, $password]);
        
        // count rows to check if the user exists or not
        $count = $query->rowCount();
        
        if ($count==1) {
            // user available and login success
            $_SESSION['auth'] = true;
            $_SESSION['login'] = "<div class='success'> You are logged in successfully! </div>";
            $_SESSION['user'] = $username;
            if(isset($_SESSION["cart"])) {
                unset($_SESSION["cart"]);
            }
            //redirect to homepage
            header('Location: index.php?road=home');
        }
        else {
            // user not available and login fail
            $_SESSION['login'] = "<div class='error'> Login Failed. Please try again! </div>";
            // redirect to homepage
            header('Location: index.php?road=goLogin');
        }
    }
    
    // logout the user and destroy the session
    public function logout() {
        session_destroy(); 
        header('Location: index.php?road=home'); // redirect to home 
    }

}
