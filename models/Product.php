<?php
/* 
    The model for Product
 */

require_once 'Category.php';

class Product{
    private $id;
    private $name;
    private $price;
    private $picture;
    private $category;          //refernece of the category object
    private $status;
    
    function __construct($id, $name, $price, $picture, $category, $status){
        // User parameterized constructor
        // will be called from the database handler class to create objects after user retrieval
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->picture = $picture;
        $this->category = &$category;
        $this->status = $status;
    }
    
    //Setter and Getter for each attribute
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getPrice() {
        return $this->price;
    }

    function getPicture() {
        return $this->picture;
    }

    function getCategory() {
        return $this->category;
    }

    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPrice($price) {
        $this->price = $price;
    }

    function setPicture($picture) {
        $this->picture = $picture;
    }

    function setCategory($category) {
        $this->category = &$category;
    }

    function setStatus($status) {
        $this->status = $status;
    }
    function getArray(){
        $result = array("id"=>  $this->id,
                        "name"=> $this->name,
                        "price"=>  $this->price,
                        "picture"=>  $this->picture,
                        "category"=> $this->category,
                        "status"=> $this->status
                );
        return $result;        
    }
    


}

/*
 * Testing Product and Category Classes
$ctr1 = new Category(4, "Hot Drinks");

$prd1 = new Product(9, "Tea", 3, "/img/img1.jpg", $ctr1, "Available");

var_dump($prd1);

*/
?>