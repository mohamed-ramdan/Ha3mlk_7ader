<?php

/* 
    The model for Order
 */
    class Category{
        private $id;
        private $name;
        
        function __construct($id, $name) {
        // User parameterized constructor
        // will be called from the database handler class to create objects after user retrieval
            $this->id = $id;
            $this->name = $name;
        }
        
        //Setter and Getter for each attribute
        function getId() {
            return $this->id;
        }

        function getName() {
            return $this->name;
        }

        function setId($id) {
            $this->id = $id;
        }

        function setName($name) {
            $this->name = $name;
        }


    }


?>
