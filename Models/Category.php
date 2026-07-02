<?php

class Category{

    private $conn;

    public function __construct($db){

        $this->conn = $db;

    }

    public function getAllCategories(){

        $sql = "SELECT * FROM categories ORDER BY category_name ASC";

        $result = $this->conn->query($sql);

        return $result;

    }

}