<?php

class User{

    private $conn;

    public function __construct($db){

        $this->conn=$db;

    }


    public function emailExists($email){

    $sql = "SELECT id FROM users WHERE email=?";

    $stmt = $this->conn->prepare($sql);

    $stmt->bind_param("s",$email);

    $stmt->execute();

    $result = $stmt->get_result();

    return $result->num_rows > 0;

}


    public function register($fullname,$email,$password){

    $password=password_hash($password,PASSWORD_DEFAULT);

    $sql="INSERT INTO users(full_name,email,password)

    VALUES(?,?,?)";

    $stmt=$this->conn->prepare($sql);

    $stmt->bind_param("sss",$fullname,$email,$password);

    return $stmt->execute();

}


public function login($email){

    $sql="SELECT * FROM users WHERE email=?";

    $stmt=$this->conn->prepare($sql);

    $stmt->bind_param("s",$email);

    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();

}

}