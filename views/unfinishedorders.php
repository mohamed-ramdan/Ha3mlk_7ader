<?php
    require_once '../controllers/AdminController.php';
    
    // creatomg an object of the Admin Controller class to execute the necessary code for manual order page

    $varAdmin = new AdminController();
    $result = $varAdmin->getUnFinishedOrders();
    // the return value is an array, each record is a result of SQL join command
    // between user,cafeOrder,orderComponent and product tables
    echo "<h2>Function getUnFinishedOrders</h2>";
    if(!empty($result))            
        {
           
            // Show these orders
            echo "<br />";
            echo "<br /><p style='color:orange';> Unfinished orders <p><br/> ";
            //extracting each item from $result
            foreach ($result as $order) {
                foreach ($order as $key => $value) {
                    echo $key.":".  $value."<br/>";
                }
                echo "------<br/>";
                
            }
        }
        else
        {
            
            echo "<br /><p style='color:green';> All orders accomplished <p> ";
        }
    echo "<br />";

?>

