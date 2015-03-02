<?php

/*
      ***---((---((  __PLEASE READ__  ))---))---***
 * ====================================================
 * In views unfinishedorders.php file needs to be start from
 * by this link    http://localhost/Ha3mlk_7ader/views/unfinishedorders.php
 * then submit to redirect to adminController where the constrcutor calls unFinishedOrders function
 * that call ORM select function where order status = undone then var_dumb the result considering creating
 * an object from the class directly under the constructor 
 * 
 * Note: database tables has a valid data inserted for test
 * Note: mysql connection parameters had been set ('localhost','root','admin','ha3mlk7aderdb'); in ORM
 * 
 * The Expected result: on press submit key go to admin controller and see the array printed or even NULL value
 * The Real result: Blank page wit NO error defined
 *  */


// Include Needed Models 
include_once '../models/ORM.php';
//.'../models/Order.php'.'../models/User.php'.'../models/Category.php'.'../models/Product.php';


class AdminController
{
 
    /**
     * getUnFinishedOrders is a function that get all unfinished orders
     * Using ORM select method
     * @param void 
     * @return array Include unfinished orders
     */
    function getUnFinishedOrders()
    {
        echo 'hi there, inside my function';
        $orm = ORM::getInstance();
        $orm->setTable('h3mlk7aderdb.cafeOrder');
        echo "<br /> table set ";
        $unFinishedOrders=array();
        $unFinishedOrders = $orm->select("where status = 'undone'");
        if(!empty($unFinishedOrders))
        {
            var_dump($unFinishedOrders);
        }
        else
        {
            
            echo "<br /> empty ";
        }
        header("Location:../views/unfinishedorders.php?orders=$unFinishedOrders");
        
    }
    
    function __construct() {
        
        echo 'inside constructor';
        $this->getUnFinishedOrders();
        
    }
    
}
$varAdmin = new AdminController();

?>

