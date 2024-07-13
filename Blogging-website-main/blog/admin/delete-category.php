<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    
    //for later
    // update category_id of posts that belong to this category to id of uncategorizwed category;
    $update_query = "update posts set category_id=4 where category_id=$id";
    $update_result = mysqli_query($connection, $update_query);



if (!mysqli_errno($connection)){
    //delete category
    $query = "DELETE FROM categories WHERE id=$id LIMIT 1";
    $result = mysqli_query($connection,$query);
    $_SESSION['delete-category-success'] = "Category deleted successfullly";
}
}
header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();

