<?php

/* 
    The model for User
 */

class User{
    private $id;
    private $name;
    private $email;
    private $password;
    private $roomNumber;
    private $ext;
    private $picture;
    private $isAdmin;
    
    function __construct($id,$name,$email,$password,$roomNumber,$ext,$picture,$isAdmin) {
        // User parameterized constructor
        // will be called from the database handler class to create objects after user retrieval
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->roomNumber = $roomNumber;
        $this->ext = $ext;
        $this->picture = $picture;
        $this->isAdmin = $isAdmin;
    }
    
    
    // Setters and getters for each attribute
    
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getEmail() {
        return $this->email;
    }

    function getPassword() {
        return $this->password;
    }

    function getRoomNumber() {
        return $this->roomNumber;
    }

    function getExt() {
        return $this->ext;
    }

    function getPicture() {
        return $this->picture;
    }

    function getIsAdmin() {
        return $this->isAdmin;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setRoomNumber($roomNumber) {
        $this->roomNumber = $roomNumber;
    }

    function setExt($ext) {
        $this->ext = $ext;
    }

    function setPicture($picture) {
        $this->picture = $picture;
    }

    function setIsAdmin($isAdmin) {
        $this->isAdmin = $isAdmin;
    }
    
    // an array to get all the attributes of the object in the form of an associative array for the sake of the ORM insert method 
    function getArray(){
        $result = array("id"=>  $this->id,
                        "name"=> $this->name,
                        "email"=>  $this->email,
                        "password" => $this->password,
                        "roomNumber"=> $this->roomNumber,
                        "ext" => $this->ext,
                        "picture"=>  $this->picture,
                        "isAdmin"=> $this->isAdmin
                );
        return $result;
    }
    
}
    

// testing User class
/*
$u1 = new User(1,"hesham","heshamadel@example.com","123456","110","4411","/img/img.jpg",0);
var_dump($u1);
echo '<br/>';
echo $u1->getName()."<br/>";
var_dump($u1->getArray());
  */  
?>