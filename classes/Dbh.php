<?php
//Connection to the database
class Dbh {
    //properties
    private $host;
    private $username;
    private $password;
    private $dbname;
    
//method
    protected function connect(){ 
        
            $this->host = "127.0.0.1";
            $this->username = "root";
            $this->password = "";
            $this->dbname = "zuriphp";
            $conn = mysqli_connect($this->host,$this->username,$this->password,$this->dbname);

            if(!$conn){
                echo "<script> alert('Error connecting to the database') </script>";
            }
            return $conn;
}
}  


