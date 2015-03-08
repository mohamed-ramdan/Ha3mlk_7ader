<?php

// Include Needed Models 
include_once '../models/ORM.php';
require_once '../models/Validation.php';


class AdminController
{
 
    /**
     * @author Mohamed Ramadan
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
        $unFinishedOrders  = $orm->selectjoin(array('cafeOrder','user','orderComponent','product','room'),
                "cafeOrder.orderUserID=user.userID and cafeOrder.orderID = orderComponent.orderID and orderComponent.productID = product.productID and cafeOrder.destinationRoomNumber = room.id "
                . "order by cafeOrder.orderID DESC");
        // If there are any unfinished orders
        //print_r($unFinishedOrders);
        //exit;
        return $unFinishedOrders;
    }
    
    
    
    /**
     * @author Mohamed Ramadan
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
        $products = $orm->select("productStatus='available'");
        
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
     * @author Mohamed Ramadan
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
     * @author Mohamed Ramadan
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
    
    
    
    /**
     * getAllUsers is a function that return array of all users.
     * @author Mohamed Ramadan.
     * @param void 
     * @return array that contain all usersName
     */
    function getAllUsers()
    {
        //get instance from orm 
        $orm = ORM::getInstance();
        //set table for retieve
        $orm->setTable('h3mlk7aderdb.user');
        //select all users
        $users = $orm->select();      
        return $users;    
    }








    /**
     * saveNewProduct is a function that insert new product into the database
     * @author Mohamed Ramadan
     * @param void 
     * @return void
     */
    function  saveNewProduct()
    {
       
       $rules = array(
			'product' => 'required',
			'price' => 'required',
			'category' => 'required',
                        
                        );
       $data = array(
                        'product' => $_POST['productName'],
			'price' => $_POST['price'],
			'category' => $_POST["categoryName"],
                   );
          
       
       
       $validation = new Validation();
       $result = $validation->validate($data,$rules);
       $imgresult = $validation->validateimg($_FILES,'productPicture');
	
       
       $orm = ORM::getInstance(); 
       $orm->setTable('h3mlk7aderdb.category');
       $catName = $_POST["categoryName"];
       $categoryData= $orm->select("categoryName = '$catName'");
       $categoryId = $categoryData[0]['categoryID'];
       $orm->setTable('h3mlk7aderdb.product');
       if(count($validation->errors)==0 ){
          if(isset($_GET["edit"])){
            $id=$_GET["id"];
            $product=$orm->select("productID=$id");
            $orm->update( array ( 'productName'     => $_POST['productName'],'price'    => $_POST['price'],
                                      'categoryID' => $categoryId,)  ,"productID='$id'"  ); 
            }   
            else{   
            $id=$orm->insert(array('productName'     => $_POST['productName'],
            'price'    => $_POST['price'],'categoryID' => $categoryId,));       
            }
                $upfile="../static/img/{$id}_{$_FILES['productPicture']['name']}";
               
                $imgname = "{$id}_{$_FILES['productPicture']['name']}";

                $_POST["productPicture"]=$upfile;

                if (is_uploaded_file($_FILES['productPicture']['tmp_name']))
                {
                        //save image from tmp to thier place
                     if (!move_uploaded_file($_FILES['productPicture']['tmp_name'], $upfile))
                        {
                                echo 'Problem: Could not move file to destination directory';
                                exit; 
                        }
                        else{
                            $orm->update(array( 'productPicture'=>$upfile),"productID=$id"  );      
                            
                        
                        }        
                }
                else { 
                       echo 'Problem: Possible file upload attack. Filename: ';
                       echo $_FILES['productPicture']['name'];
                       }
                 header("Location: ../views/unfinishedorders.php");     
        }
        
        else if (count($validation->errors)==1 && $_FILES['productPicture']['error'] ==4 ){
               //get room id of selected room
           
            if(isset($_GET["edit"])){
               $id=$_GET["id"];
               $product=$orm->select("productID=$id");

               $orm->update( array ( 'productName'=> $_POST['productName'],'price'=> $_POST['price'],
               'categoryID' => $categoryId,) ,"productID='$id'"  ); 
              }  

            else{
               $orm->setTable('h3mlk7aderdb.product');
               echo $orm->insert
                   (
                        array
                            (
                                'productName'     => $_POST['productName'],
                                'price'    => $_POST['price'],
                                'categoryID' => $categoryId,

                             ) 
                   ); 
            }

       header("Location: ../views/unfinishedorders.php");            
    }
               //data it self isnot valid
               else{
                                      
                        //file isnot uploaded    
                        if( $_FILES['productPicture']['error'] ==4){
				array_pop($validation->errors);
			}
			echo '<ul>';
                        //get all errors
			foreach ($validation->errors as $error) {
				echo '<li>' . $error . '</li>';
			}

			echo '</ul>';
                        $id=$_GET['id'];
			$nameVal=$_POST["productName"];
			$priceVal=$_POST["price"];
                        $categoryVal=$_POST["categoryName"];
                        $errors = implode("^",$validation->errors);
                        if(isset($_GET["edit"])){
                            
                          header("Location: ../views/productprofile.php?id=$id&nameVal=$nameVal&priceVal=$priceVal&categoryVal=$categoryVal&errors={$errors}");    
  
                        }
                        else{
                        header("Location: ../views/addproduct.php?nameVal={$nameVal}&priceVal={$priceVal}&categoryVal={$categoryVal}&errors={$errors}");    
                        }
               }
       
       
      
       
       
    }
    /**
     * saveManualOrder is a function that handle insert new order from admin site manually.
     * @author Hesham Adel
     * @param void
     * @return int number of affected rows 
     */
    function saveManualOrder(){
        
        
        // get the current time 
        $currentTime =  time();
    
        // get an instance of the the class ORM to preform the database crud operations
        $orm = ORM::getInstance();
        
        // Set table retrieve
        $orm->setTable('h3mlk7aderdb.product');
        // Retrieve all products
        $products = $orm->select("productStatus='available' and visibilty = 1");
        
        // get the ajax get request data from the $_GET Array
        $notes = $_GET["notes"];
        $orderUsername = $_GET["orderUsername"];
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
        
        // set the working table to user
        $orm->setTable('h3mlk7aderdb.user');
        // Retrieve all users with this name .. to get the the userID
        $user=$orm->select("username='$orderUsername'");
        
        // set the working table to room
        $orm->setTable('h3mlk7aderdb.room');
        
        // Retrieve the room with this number .. to get the the roomID
        $room=$orm->select("roomNumber='$destinationRooms'");
        //var_dump($room);
        
        // set the working table to cafeOrder                
        $orm->setTable('h3mlk7aderdb.cafeOrder');
        
        $id=$user[0]['userID'];
        /*$currentCafeOrder=$orm->selectjoin(array('user','cafeOrder')," user.userID=cafeOrder.orderUserID and user.userID=$id and cafeOrder.status='preparing'");
        
        if(count($currentCafeOrder)>0){
              $thisOrderId=$currentCafeOrder[0]["orderID"];
              
          }
          else{*/
                // set the working table to cafeOrder                
                $orm->setTable('h3mlk7aderdb.cafeOrder');

                // insert the order into the cafeOrder Table
                // i will modify it to take the current time soon
                 $thisOrderId = $orm->insert(array('date' => date('Y-m-d H:i:s',$currentTime) , 'amount' => 200, 'status' => 'preparing', 'destinationRoomNumber' =>  $room[0]['id'], 'orderUserID' => $id, 'note' => $notes));
            //}
          
        
          
        // set the working table to orderComponent    
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

        //echo $thisOrderId;

    }        
    
    function __construct() {

    }
   
    
    /**
     * @author Mohamed Ramadan
     * getAllCategories is a function that get all product categories
     * Using ORM select method
     * @param void 
     * @return array Include all categories
     */
    function getAllCategories()
    {
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        // Set table orders to retrieve
        $orm->setTable('h3mlk7aderdb.category');
        // Call function select from ORM instance
        $categories  = $orm->select();
        // If there are any categories then retrieve
        if(!empty($categories))
        {
            return $categories;
        }
    }
    
    /**
     * @author Mohamed Ramadan
     * saveNewCategory is a function that save new categories
     * Using ORM insert method
     * @param void 
     * @return int number of affected rows
     */
    function saveNewCategory()
    {
            // Get Intance from ORM model
            //echo 'vcccc'.$_GET['category'];
        // Get Intance from ORM model
         
            $orm = ORM::getInstance();
            // Set table orders to retrieve
            $orm->setTable('h3mlk7aderdb.category');
            //insert data
            //$result = $orm->insert($_GET['category']);
            $categoryName = $_GET['category'];
            $result = $orm->insert(array('categoryName'=>$categoryName));
            // number of affected rows
            //return $result;
            //header("Location:views/addproduct.php");
            header("Location: ../views/addproduct.php");
    }
    
    /**
     * @author Mohamed Ramadan
     * getChecksNeededData is a function that retrieve users orders with its components
     * Using ORM select_ join method
     * @param void 
     * @return array of orders, products, users related.
     */
    function getChecksNeededData()
    {
        $totalAmountPerUser=false;
        $orm = ORM::getInstance();
        if(isset($_GET['dateFrom']) && !empty($_GET['dateFrom']) ){
            $dateFrom = DateTime::createFromFormat('Y-m-d H:i:s', $_GET['dateFrom']);
            $fromTimeStamp = strtotime($_GET['dateFrom']);
            $x = $_GET['dateFrom'];
            
        }
        else{
            $dateFrom = DateTime::createFromFormat('Y-m-d H:i:s', "2010-03-18 06:45:34");
            $x = "2010-03-01 15:19:15";
            //$dateFromR = $dateFrom.format('Y-m-d H:i:s'); 
        }
        if(isset($_GET['dateTo']) && !empty($_GET['dateTo']) ){
            
            $dateTo = date('Y-m-d H:i:s', strtotime($_GET['dateTo']));
            $toTimeStamp = strtotime($_GET['dateTo']);
            $x2 = $_GET['dateTo'];
            
        }
        else{
            $dateTo = DateTime::createFromFormat('Y-m-d H:i:s', "2022-03-18 06:45:34");
            $x2 = "2030-03-01 15:19:15";
            //$dateToR = $dateTo.format('Y-m-d H:i:s');
        }
            
        if(isset($_GET['userid'])){
            
            $thisUserID = $_GET['userid'];
            $result = $orm-> selectjoin(array('cafeOrder','user','orderComponent','product'),
                "cafeOrder.orderUserID=user.userID and cafeOrder.orderID = orderComponent.orderID and orderComponent.productID = product.productID and user.userID= $thisUserID "
                    . ' AND (cafeOrder.date BETWEEN "'.$x.'" AND "'.$x2.'") '
                     . "order by user.username, cafeOrder.orderID, product.productID DESC");
            
            $totalAmountPerUser = $orm->custom("select sum(cafeOrder.amount), user.userID from user,cafeOrder,orderComponent "
                    . "where user.userID =  cafeOrder.orderUserID AND "
                    . "orderComponent.orderID = cafeOrder.orderID "
                    . ' AND (cafeOrder.date BETWEEN "'.$x.'" AND "'.$x2.'") '
                    . 'GROUP BY(user.userID)'
                    ) ;
            //var_dump($result);
            //var_dump($totalAmountPerUser);
            
        }
        else{
            $result = $orm-> selectjoin(array('cafeOrder','user','orderComponent','product'),
                "cafeOrder.orderUserID=user.userID and cafeOrder.orderID = orderComponent.orderID and orderComponent.productID = product.productID "
                    . "order by user.username, cafeOrder.orderID, product.productID DESC");
            $totalAmountPerUser = $orm->custom("select sum(cafeOrder.amount), user.userID from user,cafeOrder,orderComponent "
                    . "where user.userID =  cafeOrder.orderUserID AND "
                    . "orderComponent.orderID = cafeOrder.orderID "
                    . 'GROUP BY(user.userID)'
                    ) ;
            
        }
        
        $retValue['result'] = $result;
        $retValue['amountPerUser'] = $totalAmountPerUser;
        
        if(!empty($result))
        {
           // echo 'ccc';
           return $retValue;
            
        }
            
        
        // Get Intance from ORM model
        
        
        
        
        
    }
    
    
   function getProducts(){
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        
        // Set table retrieve
        $orm->setTable('h3mlk7aderdb.product');
        // Retrieve all products
        $products = $orm->select();
        return $products;
        
    }
    
    
    function product($id){
        // Get Intance from ORM model
        $orm = ORM::getInstance();
        
        // Set table retrieve
        $orm->setTable('h3mlk7aderdb.product');
        // Retrieve all products
        //$id=$_GET["productID"];
        $products = $orm->select("productID=$id");
        return $products[0];
        
    }
    
    function changeState(){
      
       $orm = ORM::getInstance();
        //header("Location: ../views/allproducts.php");
        // Set table retrieve
        $orm->setTable('h3mlk7aderdb.product');
        // Retrieve all products
        $id=$_GET['id'];
        $product = $orm->select("$id=productID");   
        $productStatus=$product[0]["productStatus"];
        
        if($productStatus=="available"){
            $orm->update(array("productStatus"=>"unavailable"),"productID=$id");
        }
        else{
            $orm->update(array("productStatus"=>"available"),"productID=$id");    
        }
        
        //header("Location: ../views/allproducts.php");
        //return $http_response_header;
        //return ("hihi");
        //header('Content-Type: application/json');
        //return json_encode(array('id' => $id));
        echo "$id"."@changestate" ;
    }
    
    
    function deleteProduct(){
        
                $orm = ORM::getInstance();  
                $orm->setTable('product');
                  // Retrieve all users
                $id=$_GET['id'];
                //$product = $orm->select("productID='$id'");
                //if($product[0]["userPicture"]!="upload/image/user/default.png"){
                //    unlink(trim($product[0]["productPicture"]));    
                //}
                //$product = $orm->delete("productID='$id'");  
                $product = $orm->update(array("visibilty"=>0),"productID='$id'");
                //header("Location: ../views/allproducts.php");    
echo "$id"."@delete" ;
    }
    
    function editProduct(){
        
        
       $orm = ORM::getInstance(); 
       $orm->setTable('h3mlk7aderdb.category');
       $catName = $_POST["categoryName"];
       $categoryData= $orm->select("categoryName = '$catName'");
       var_dump($categoryData);
       $categoryId = $categoryData[0]['categoryID'];
       $orm->setTable('h3mlk7aderdb.product');
       $id=$_GET["id"];
       $product=$orm->select("productID=$id");
                               
       echo $orm->update
               (
                    array
                        (
                            'productName'     => $_POST['productName'],
                            'price'           => $_POST['price'],
                            'categoryID' => $categoryId,
                            
                         )
               ,"productID=$id"
               );
       
        if(isset($_FILES['productPicture'])){
        if($product[0]["productPicture"]!="upload/image/user/default.png"){
            unlink(trim($product[0]["productsPicture"]));    
        }

        if (is_uploaded_file($_FILES['productPicture']['tmp_name']))
        {
                //save image from tmp to thier place
                if (!move_uploaded_file($_FILES['productPicture']['tmp_name'], $upfile))
                {
                        echo 'Problem: Could not move file to destination directory';
                        exit; 
                }
        } 


        else
            {
                    echo 'Problem: Possible file upload attack. Filename: ';
                    echo $_FILES['productPicture']['name'];
                    exit;
            }
            echo $orm->update
               (
                    array
                        (
                            
                            'productPicture'  => $_POST['productPicture']
                         )
               ,"productID=$id"
               );
       
    }
  header("Location: ../views/unfinishedorders.php"); 
    }
    
    
    function changeOrderStatus(){
        $newStatus = $_GET["newStatus"];
        $thisOrderID = $_GET["orderID"];
        $orm = ORM::getInstance(); 
        $orm->setTable('h3mlk7aderdb.cafeOrder');
        if($newStatus == 'preparing'){
            $orm->update
               (
                    array
                        (  
                            'status'  => 'preparing'
                        )
               ,"orderID=$thisOrderID"
               );
            echo $thisOrderID."@preparing";
        }
        else if ($newStatus == 'delivering'){
               $orm->update
               (
                    array
                        (  
                            'status'  => 'delivering'
                        )
               ,"orderID=$thisOrderID"
               );
               echo $thisOrderID."@delivering";
        }
        else if($newStatus == 'done'){
               $orm->update
               (
                    array
                        (  
                            'status'  => 'done'
                        )
               ,"orderID=$thisOrderID"
               );
               echo $thisOrderID."@done";
        }
        else{
            echo false;
        }
    }
    
    
}






    
    // First must check if the user is authorized and he is an admin
//    @session_start();

    if(isset($_GET["fn"])){
        if($_SESSION['logged']&&$_SESSION['isAdmin'])
        {
        $varAdmin = new AdminController();
        
        switch ($_GET["fn"])
        {       
            case "saveManualOrder":
                $varAdmin->saveManualOrder();
                break;
            case "saveNewProduct":
                $varAdmin->saveNewProduct();
                break;
            case "saveNewCategory":
                $varAdmin->saveNewCategory();
                break;
            case "getChecksNeededData":
                echo json_encode($varAdmin->getChecksNeededData());
                break;
            case "changeState":
                $varAdmin->changeState();
                break;
            case "deleteProduct":
                $varAdmin->deleteProduct();
                break;
            case "editProduct":
                $varAdmin->editProduct();
                break;
            case "changeOrderStatus":
                $varAdmin->changeOrderStatus();
                break;
            
        }
        } 
        else{
            header("Location: ../views/login.php");
        }
    }


?>

