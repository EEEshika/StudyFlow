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


// Get User By ID
public function getUserById($id)
{
    $sql = "SELECT *
            FROM users
            WHERE id=?";

    $stmt = $this->conn->prepare($sql);

    if(!$stmt){
        die($this->conn->error);
    }

    $stmt->bind_param("i",$id);

    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}


// Update Profile
public function updateProfile($id,$full_name)
{
    $sql="UPDATE users
          SET full_name=?
          WHERE id=?";

    $stmt=$this->conn->prepare($sql);

    if(!$stmt){
        die($this->conn->error);
    }

    $stmt->bind_param("si",$full_name,$id);

    return $stmt->execute();
}


// Change Password
public function changePassword($id,$password)
{
    $password=password_hash($password,PASSWORD_DEFAULT);

    $sql="UPDATE users
          SET password=?
          WHERE id=?";

    $stmt=$this->conn->prepare($sql);

    if(!$stmt){
        die($this->conn->error);
    }

    $stmt->bind_param("si",$password,$id);

    return $stmt->execute();
}


// Verify Current Password
public function verifyPassword($id,$password)
{
    $sql="SELECT password
          FROM users
          WHERE id=?";

    $stmt=$this->conn->prepare($sql);

    if(!$stmt){
        die($this->conn->error);
    }

    $stmt->bind_param("i",$id);

    $stmt->execute();

    $user=$stmt->get_result()->fetch_assoc();

    if(!$user){
        return false;
    }

    return password_verify($password,$user['password']);
}

}