<?php
// Include connection page
include_once 'Dbh.php';
session_start();


class UserAuth extends Dbh{
   
// Method for checking if Email exist in database
    public function checkEmailExist($email){
         $conn = $this->connect();
        //query
         $sql = " SELECT * FROM `students` WHERE `email` = '$email' ";
        $result = mysqli_query($conn, $sql);
        if($result-> num_rows > 0){
            // If email exist return true
            return true;
        } else {
            // If email does not exist return false
            return false;
        }
    }

// Method to check if the password match
    public function confirmPasswordMatch($password, $confirmPassword){
        //method to check if the password match
        if($password === $confirmPassword){
            // If password match return true
            return true;
        } else {
            //If password did not match return false
            return false;
        }
    }


//Method for registering 
    public function register($fullname, $email, $password, $confirmPassword, $country, $gender){
        //calling the connection method 
        $conn = $this->connect();
        // calling the checkeMailExist method
        if($this->checkEmailExist($email) == true){
            // If user exist
            echo '<script>alert("User already registered");
            window.location="forms/register.php";
            </script>';
        }else{
            //calling the confirmPasswordmatch method
            if($this->confirmPasswordMatch($password, $confirmPassword) == true){
                // If password match, submit data into the database
                $sql = "INSERT INTO `students` (`full_names`, `email`, `password`, `country`, `gender`) VALUES ('$fullname','$email', '$password', '$country', '$gender')";
                if($conn->query($sql)){
                    // If submitted
                    echo '<script>alert("User Successfully registered");
                    window.location="forms/login.php";
                    </script>';
                } else {
                    // If not submitted
                    echo '<script>alert("Technical Error, failed to register");
                    window.location="forms/register.php";
                    </script>';
                }
                // If password doesn't match 
            }elseif($this->confirmPasswordMatch($password, $confirmPassword) == false){
                echo '<script>alert("Password does not Match!!!");
                window.location="forms/register.php";
                </script>'; 
            }
        } 
    }


// Method for login
    public function login($email, $password){
        // Connection
        $conn = $this->connect();
        // select all from table name where the user email match the one in database
        $sql = "SELECT * FROM `students` WHERE `email`='$email' ";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            //fetch the row
            $row = mysqli_fetch_assoc($result);
       //Check if the email and password the user provided match the one in database
            if ($row['email'] == $email and $row['password'] == $password) {
                // if true extract fullname and email using a session
                $_SESSION['fullname'] = $row['full_names'];
                $_SESSION['email'] = $row['email'];
                // Welcome the user and redirect to dashborad page
                echo '<script>alert("Welcome ' . $_SESSION['fullname'] . ' ");
                        window.location="dashboard.php";
                        </script>';
                    }else {
                // If password or email does not match
                echo '<script>alert("Incorrect Email or Password");
                window.location="forms/login.php";
                </script>';
                        
            }
            // If user not found
            }else{
                echo '<script>alert("User not found, please register");
        window.location="forms/register.php";
        </script>';
            }   
    }


//Method to get all user 
    public function getAllUsers(){
        //connection
        $conn = $this->connect();
        //select all from database
        $sql = "SELECT * FROM students";
        $result = $conn->query($sql);
        echo"<html>
        <head>
        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' integrity='sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T' crossorigin='anonymous'>
        </head>
        <body>
        <center><h1><u> ZURI PHP STUDENTS </u> </h1> 
        <table class='table table-bordered' border='0.5' style='width: 80%; background-color: smoke; border-style: none'; >
        <tr style='height: 40px'>
            <thead class='thead-dark'> <th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th>
        </thead></tr>";
        if($result->num_rows > 0){
            // Show all data in the database using while loop
            while($data = mysqli_fetch_assoc($result)){
                $id = $data['id'];

                echo "<tr style='height: 20px'>".
                    "<td style='width: 50px; background: gray; text-align:center';'>" . $data['id'] . "</td>
                    <td style='width: 150px; text-align:center';'>" . $data['full_names'] .
                    "</td> <td style='width: 150px; text-align:center';'>" . $data['email'] .
                    "</td> <td style='width: 150px; text-align:center';'>" . $data['gender'] . 
                    "</td> <td style='width: 150px; text-align:center';'>" . $data['country'] . 
                    "</td>
                    <td style='width: 150px; text-align:center';'> 
                    <form action='action.php' method='POST'>
                    <input type='hidden' name='id'" .
                     "value=" . $data['id'] . ">".
                    "<button class='btn btn-danger' type='submit', name='delete'> <a href=action.php?deleteid='$data[id]' >Delete</a>  </button> </form> </td>".
                    "</tr>";
                
            }
            echo "</table></table></center></body></html>";
            echo "<button style='background-color:wheat;'> <a href='dashboard.php'>Back</a> </button>  ";
            
        }
    }

    // Method for deleting a user
    public function deleteUser($id){
        $conn = $this->connect();
        $sql = "DELETE FROM `students` WHERE `id` = $id";
        $result = $conn->query($sql);
        if($result){
            echo '<script>alert("User Successfully Deleted");
            window.location="dashboard.php";
            </script>';
        
        } else {
            echo '<script>alert("Fail to delete User");
            window.location="dashboard.php";
            </script>';
        }
    }

    //Method for reseting password
    public function resetPassword($email, $password){
        //connection
        $conn = $this->connect();
        //Calling the CheckemailExist method to check if the user is present
        if($this->checkEmailExist($email)== true){
            // If found, update the password of the user
            $sql = "UPDATE `students` SET password = '$password' WHERE `email` = '$email'";
            $result = $conn->query($sql);
        if($result){
            echo '<script>alert("Password Reset Successfully");
            window.location="forms/login.php";
            </script>';
        } else {
            echo '<script>alert("Technical Error, try again later");
            window.location="forms/login.php";
            </script>';
        }
           
        // If user not found
        }else{
            echo '<script>alert("User does not exist");
            window.location="forms/resetpassword.php";
            </script>';

        }


        
    }

// Method for logout
    public function logout(){
        session_unset();
        session_destroy();
        header('location:forms/login.php');
    }



}

