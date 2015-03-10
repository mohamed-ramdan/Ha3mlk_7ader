<?php

    // Include Needed Models 
    include_once '../models/ORM.php';


    class NormalUserController
    {
        function getMakeOrderNeededData(){
            //SELECT * FROM `cafeOrder` WHERE date > DATE_SUB(now(), INTERVAL 5 MINUTE)

        // Get Intance from ORM model
        $orm = ORM::getInstance();  
        

        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.category');
        // Retrieve all categories
        $categories = $orm->select();
        
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.product');
        // Retrieve all products
        $products = $orm->select("productStatus='available' and visibilty ='1'  ");
        
        // Set table orders to retrieved 
        $orm->setTable('h3mlk7aderdb.room');
        // Retrieve all rooms
        $rooms = $orm->select();
        
        // If there are no problem
        
        if(!empty($categories)&&!empty($products)&&!empty($rooms))    
        {
           $thisUser = 3;
            $orm->setTable('h3mlk7aderdb.cafeOrder');
            $latestOrder = $orm->selectjoin(array("product", "category", "cafeOrder", "user", "orderComponent"),"orderComponent.orderID = cafeOrder.orderID"
                    . "orderComponent.productID = product.productID"
                    . "cafeOrder.orderUserID = user.userID"
                    . "product.categoryID=category.categoryID"
                    . "userID= $thisUser"
                    . "date > DATE_SUB(now(), INTERVAL 5 MINUTE");
            if(!$latestOrder){
                $latestOrder=false;
            }
            //putting users/categories/products/rooms in 1 array to return
            $data=array('categories'=>$categories,'products'=>$products, 'rooms'=>$rooms,'latestOrder'=>$latestOrder);
            return $data; 
        }
        else
        {  
            $data=false;
            return $data;
        }
            
        }
        
        function saveOrder(){
        
        // get the current time 
        $currentTime =  time();
        
        // get an instance of the the class ORM to preform the database crud operations
        $orm = ORM::getInstance();
        
        // Set table retrieve
        $orm->setTable('h3mlk7aderdb.product');
        // Retrieve all products
        $products = $orm->select("productStatus='available'");
        
        // get the ajax get request data from the $_GET Array
        $notes = $_GET["notes"];
        //$orderUsername = $_GET["orderUsername"];
        $destinationRooms = $_GET["destinationRooms"];
        
        // an arrays to hold the the quantity of each product associated with the product name
        $productsNums= array();
        
        // an arrays to hold the the id of each product associated with the product name
        $productsIDs = array();
        
        // go over all the products and get the quantities and the ids .. using the names from the database
        foreach ($products as $product) {
             $productsNums[$product['productName']] = $_GET[$product['productName']];
             $productsIDs[$product['productName']] =$product['productID'];
        }
        
        
        // set the working table to room
        $orm->setTable('h3mlk7aderdb.room');
        
        // Retrieve the room with this number .. to get the the roomID
        $room=$orm->select("roomNumber='$destinationRooms'");
        
        
        
        // set the working table to cafeOrder                
        $orm->setTable('h3mlk7aderdb.cafeOrder');
        
        // insert the order into the cafeOrder Table
        // i will modify it to take the current time soon
        
        $id=$_SESSION['userID'];
        
        
        
        $thisOrderId = $orm->insert(array('date' => date('Y-m-d H:i:s',$currentTime) , 'amount' => 200, 'status' => 'preparing', 'destinationRoomNumber' =>  $room[0]['id'], 'orderUserID' => $id, 'note' => $notes));

        
  /*      $currentCafeOrder=$orm->selectjoin(array('user','cafeOrder')," user.userID=cafeOrder.orderUserID and user.userID=$id and cafeOrder.status='preparing'");
        
        if(count($currentCafeOrder)>0){
              $thisOrderId=$currentCafeOrder[0]["orderID"];

              
          }
          else{*/
                // set the working table to cafeOrder                
       //         $orm->setTable('h3mlk7aderdb.cafeOrder');

                // insert the order into the cafeOrder Table
                // i will modify it to take the current time soon
         //        $thisOrderId = $orm->insert(array('date' => date('Y-m-d H:i:s',$currentTime) , 'amount' => 200, 'status' => 'preparing', 'destinationRoomNumber' =>  $room[0]['id'], 'orderUserID' => 6, 'note' => $notes));
           // }
          
        $orm->setTable('h3mlk7aderdb.orderComponent');
        $orderAmount=0;

        foreach ($products as $product) {
            // go over all products and if user requested the ihis product (it's value more than 0)
            // the quantity and the productID and orderID insereted into the db
            if($productsNums[$product['productName']]!=0){
                $orm->insert(array('orderID' => $thisOrderId, 'productID' => $productsIDs[$product['productName']]  ,'quantity' => $productsNums[$product['productName']]));             
                foreach ($products as $productX) {
                        if($productX['productID'] == $productsIDs[$product['productName']]  ){
                            
                            $orderAmount+= ($productsNums[$product['productName']]) *  ($productX['price']);
                        }
                   }
            }
            }
        $orm->setTable('h3mlk7aderdb.cafeOrder');

        $orm->update(array('amount'=>$orderAmount),"orderID= '$thisOrderId'");

        echo $thisOrderId;         
    }
    
    function getUserorders()
    {
        @session_start();  
        $userID=$_SESSION['userID'];    
        
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.cafeOrder');
        // Call function select from ORM instance
        //$orders  = $orm->selectjoin(array(user,cafeOrder,product,orderComponent),"username='$userName' and user.userID=cafeOrder.orderUserId and orderComponent.orderID=cafeOrder.orderID and orderComponent.productID=product.productID");
        //$orders  = $orm->selectjoin(array('cafeOrder','product','orderComponent'),"cafeOrder.orderUserId = '$userID' and orderComponent.orderID=cafeOrder.orderID and orderComponent.productID=product.productID");
        $orders  = $orm->selectjoin(array('cafeOrder','product','orderComponent'),"cafeOrder.orderUserID='$userID' and cafeOrder.orderID = orderComponent.orderID and orderComponent.productID = product.productID "
                . "order by cafeOrder.orderID DESC");
               
        // If there are any categories then retrieve
        //var_dump($orders);
        if(!empty($orders))
        {
            //print_r($orders);
            return $orders;
        }
        else{
            echo false;
            return false;
        }
        
        
    }
    function cancelOrder(){
        $thisOrderID = $_GET['orderID'];
        
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.cafeOrder');
        
        $result =$orm->update(array('status' => 'Canceled'),"orderID=$thisOrderID");
        
        echo $thisOrderID;
    }
    
 }
    @session_start();  
    if($_SESSION['logged'])
        {
    if(isset($_GET["fn"])){
       
        $varNormalUser = new NormalUserController();
        switch ($_GET["fn"])
        {       
          case "saveOrder":
            echo $varNormalUser->saveOrder();
            break;
              
          case "getUserorders":  
            $varNormalUser->getUserorders();
            break;
          case "cancelOrder":
            
            $varNormalUser->cancelOrder();
            break;
            
        }
        }
        
        }
        else{
            
            header("Location: ../views/login.php");
        }
        
        
    

?>
