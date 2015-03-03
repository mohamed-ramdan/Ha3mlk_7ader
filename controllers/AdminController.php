<?php

// Include Needed Models 
include_once '../models/ORM.php';


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
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.cafeOrder');
        // Call function sekect from ORM instance
        //$unFinishedOrders = $orm->select("status!='done' and status!='canceled' ");
        $unFinishedOrders  = $orm->selectjoin(array('cafeOrder','user','orderComponent','product'),
                "cafeOrder.orderUserID=user.userID and cafeOrder.orderID = orderComponent.orderID and orderComponent.productID = product.productID");
        // If there are any unfinished orders
        
        return $unFinishedOrders;
    }
    
    
    /**
     * getManualOrderData is a function that get all needed data 
     * to be user for creating a manual order
     * @param void 
     * @return array of users , products, rooms, category
     */
    function getManualOrderNeededData()
    {
        // Get Intance from ORM model
        $orm = ORM::getInstance();  
        
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.user');
        // Retrieve all users
        $users = $orm->select();

        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.category');
        // Retrieve all categories
        $categories = $orm->select();
        
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.product');
        // Retrieve all products
        $products = $orm->select("");
        
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.room');
        // Retrieve all rooms
        $rooms = $orm->select();
        
        // If there are no problem
        
        if(!empty($users)&&!empty($categories)&&!empty($products)&&!empty($rooms))    
        {
            //putting users/categories/products/rooms in 1 array to return
            $data=array('users'=>$users,'categories'=>$categories,'products'=>$products, 'rooms'=>$rooms);
            
            return $data;
//            
//            // Show users
//            echo "<br /><p style='color:green';> users <p> ";
//            var_dump($users);
//            
//            // Show categories
//            echo "<br /><br /><p style='color:green';> categories <p> ";
//            var_dump($categories);
//            
//            // Show products
//            echo "<br /><br /><p style='color:green';> products <p> ";
//            var_dump($products);
//            
//            // Show rooms
//            echo "<br /><br /><p style='color:green';> rooms <p> ";
//            var_dump($rooms);    
        }
        else
        {  
            $data=false;
            return $data;
//            echo "<br /><p style='color:green';> cannot make a manual order <p> ";
        }
        
    }
    
    /**
     * getAllProducts is a function that retrieve all products
     * @param void 
     * @return array products 
     */
    function getAllProducts()
    {
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        
        // Set table retrieve
        $orm->setTable('h3mlk7aderdb.product');
        // Retrieve all products
        $products = $orm->select();
        
        // Set table retrieve
        $orm->setTable('h3mlk7aderdb.user');
        // Retrieve all users
        $users = $orm->select("userId=1");
        
        if(!empty($products)&&!empty($users))    
        {
            // Show products
            echo "<br /><br /><p style='color:#8a2be2';> All Products <p> ";
            var_dump($products);
            
            // Show users
            echo "<br /><p style='color:#8a2be2';> users <p> ";
            var_dump($users);
            
        }    
    }
    
    /**
     * getAddNewProductNeededData is a function that retrieve the requiested data needed for add new product
     * @param void 
     * @return array categories
     */
    function getAddNewProductNeededData()
    {
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        
        // Set table to retrieve
        $orm->setTable('h3mlk7aderdb.category');
        // Retrieve all categories
        $categories = $orm->select();
        
        // Set table to retrieve
        $orm->setTable('h3mlk7aderdb.user');
        // Retrieve all users
        $users = $orm->select("userId=1");
        
        if(!empty($categories)&&!empty($users))    
        {
            // Show categories
            echo "<br /><br /><p style='color:#ee1289';> Categories <p> ";
            var_dump($categories);
            
            // Show users
            echo "<br /><p style='color:#ee1289';> users <p> ";
            var_dump($users);
            
        } 
        
    }
            
    
    function __construct() {
     /*   
        echo '<h2>inside constructor</h2>'."<br />";
        echo "<h2>Function getUnFinishedOrders</h2>";
        $this->getUnFinishedOrders();
        echo "<hr />";
        echo "<h2>Function getManualOrderNeededData</h2>";
        $this->getManualOrderNeededData();
        echo "<hr />";
        echo "<h2>Function getAllProducts</h2>";
        $this->getAllProducts();
        echo "<hr />";
        echo "<h2>Function getAddNewProductNeededData</h2>";
        $this->getAddNewProductNeededData();
        echo "<hr />";
      
      */
    }
    
}
    
    // First must check if the user is authorized and he is an admin
    

//$varAdmin = new AdminController();
    
?>

