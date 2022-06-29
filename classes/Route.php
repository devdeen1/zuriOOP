<?php
// Class for registration process
class FormController extends UserAuth{

private $fullname;
private $email;
private $country;
private $gender;
public $password;
private $confirmPassword;


public function __construct($fullname,$email,$country,$gender,$password,$confirmPassword){
   $this->fullname= $fullname; 
   $this->email= $email; 
   $this->country= $country; 
   $this->gender= $gender; 
   $this->password= $password; 
   $this->confirmPassword= $confirmPassword;
}



public function handleForm(){

    switch(true) {
        case isset($_POST['register']):
            //unpack all data for registering
            $this->fullname = $_POST['fullnames'];
            $this->email = $_POST['email'];
            $this->password = $_POST['password'];
            $this->confirmPassword = $_POST['confirmPassword'];
            $this->gender = $_POST['gender'];
            $this->country = $_POST['country'];
            $this->register($this->fullname, $this->email, $this->password, $this->confirmPassword, $this->country, $this->gender);
            break;
       
        case isset($_POST['all']):
            //unpack all data for getting all users
            $this->getAllUsers();
            break;
        default:
            echo 'No form was submitted';
            break;
    }
}


}


//Class for login
class LoginController extends UserAuth{

    private $email;
    public $password;
    
    public function __construct($email,$password){
       $this->email= $email; 
       $this->password= $password; 
    }
    
    public function handleLogin(){
    
        
            if(isset($_POST['login'])){
                 //unpack all data for login
                 $this->email = $_POST['email'];
                 $this->password = $_POST['password'];
                 $this->login($this->email, $this->password);

            }
        }

    }

    // Class for logout
    class LogoutController extends UserAuth{

        public function handleLogout(){
            $this->logout();

        }
    }

    //Class for getting all the registred user in the  database
    class getAllController extends UserAuth{

        public function handleGetAll(){
            $this->getAllUsers();

        }
    }

    //Class for deleting user
    class deleteController extends UserAuth{
        private $id;

        public function handleDelete(){
            $this->id = $_SESSION['id'];
            $this->deleteUser($this->id);

        }
    }
//Reseting password class
    class ResetPasswordController extends UserAuth{
        private $email;
        public $password;

        public function handleResetPassword(){
            $this->email = $_POST['email'];
            $this->password = $_POST['password'];
            $this->resetPassword($this->email, $this->password);

        }
    }
    