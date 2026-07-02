<?php

require_once __DIR__ . "/../Config/database.php";
require_once __DIR__ . "/../Models/Category.php";

$category = new Category($conn);

$categories = $category->getAllCategories();