<?php
require 'User.php';

/* 
    The model for Order
 */

class Order{
    private $id;
    private $date;
    private $status;
    private $amount;                // the total amount of money for the entire order
    private $destination;           // room Number
    private $orderMaker;            // a refernce to the user who made the order
    private $orderComponents;        // an array of reference to all the products in the order.          prev: products
    private $notes;
    
    function __construct($id, $date, $status, $amount, $destination, $orderMaker, $orderComponents, $notes) {
        // User parameterized constructor
        // will be called from the database handler class to create objects after user retrieval
        $this->id = $id;
        $this->date = $date;
        $this->status = $status;
        $this->amount = $amount;
        $this->destination = $destination;
        $this->orderMaker = &$orderMaker;
        $this->orderComponents = $orderComponents;
        $this->notes = $notes;
    }
    function getId() {
        return $this->id;
    }

    function getDate() {
        return $this->date;
    }

    function getStatus() {
        return $this->status;
    }

    function getAmount() {
        return $this->amount;
    }

    function getDestination() {
        return $this->destination;
    }

    function getOrderMaker() {
        return $this->orderMaker;
    }

    function getOrderComponents() {
        return $this->orderComponents;
    }

    function getNotes() {
        return $this->notes;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setDate($date) {
        $this->date = $date;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setAmount($amount) {
        $this->amount = $amount;
    }

    function setDestination($destination) {
        $this->destination = $destination;
    }

    function setOrderMaker($orderMaker) {
        $this->orderMaker = &$orderMaker;
    }

    function setOrderComponents($orderComponents) {
        $this->orderComponents = $orderComponents;
    }

    function setNotes($notes) {
        $this->notes = $notes;
    }

    // an array to get all the attributes of the object in the form of an associative array for the sake of the ORM insert method 
    function getArray(){
        $result = array("id"=>  $this->id,
                        "date"=> $this->date,
                        "status"=>  $this->status,
                        "amount" => $this->amount,
                        "destination"=> $this->destination,
                        "orderMaker" => $this->orderMaker,
                        "notes"=> $this->notes
                );
        return $result;
    }

}

/*  Example of the $orderComponent
    
$orderComponents= array(
        array("name"=>"tea","quantity"=>3),
        array("name"=>"coffee","quantity"=>1)
   
)
 */
/*
 * Testing Order class
$date = date_create('2001-01-01');
date_time_set($date, 14, 55);
echo  date_format($date, 'Y-m-d H:i:s') . "\n";

$usr1 =  new User(1, "mohamed", "mohamed@example.com", "123", 110, 4422, "/imgs/img2.jpg", 0);
$ord1 = new Order("1",$date,"Delivered",40.55,110,$usr1, array(array("name"=>"tea","quantity"=>3),array("name"=>"coffee","quantity"=>1))  ,"make it quick");

echo '<br/>';

var_dump($ord1);

echo '<br/>'.$ord1->getOrderMaker()->getName();

 */