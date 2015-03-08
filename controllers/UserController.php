<?php
require_once '../models/ORM.php';
require_once '../models/Validation.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class UserController{
function getUserorders()
    {
        $userID="23";    
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.order');
        // Call function select from ORM instance
        //$orders  = $orm->selectjoin(array(user,cafeOrder,product,orderComponent),"username='$userName' and user.userID=cafeOrder.orderUserId and orderComponent.orderID=cafeOrder.orderID and orderComponent.productID=product.productID");
      $orders  = $orm->selectjoin(array('cafeOrder','product','orderComponent'),"cafeOrder.orderUserId = '$userID' and orderComponent.orderID=cafeOrder.orderID and orderComponent.productID=product.productID");
                
// If there are any categories then retrieve
        var_dump($orders);
        if(!empty($orderss))
        {
            return $orderss;
        }
    }
}   



    
