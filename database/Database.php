<?php

class Database{
    
    private $host = "localhost";
    private $port = 3307;
    private $username= "root";
    private $password = "";
    private $database = "libsystem";
    private $conn;

    public function __construct(){
        $this->conn = mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->database,
            $this->port
        );

        if(!$this->conn){
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function setConnection($conn){
        $this->conn = $conn;
    }

    public function getConnection(){
        return $this->conn;
    }

    public function __destruct(){
        mysqli_close($this->conn);
    }
}