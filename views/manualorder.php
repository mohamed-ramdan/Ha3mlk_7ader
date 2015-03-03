

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

    
    <?php
        
        require_once '../controllers/AdminController.php';
        
        // creatomg an object of the Admin Controller class to execute the necessary code for manual order page
        $varAdmin = new AdminController();
        $result = $varAdmin->getManualOrderNeededData(); 
        // the return value is an array which consist of products,categories,users 
        //and rooms each of those consists of an array of associated arrays

        echo "<h2>Function getManualOrder</h2>";

        if($result!=false){
            //breaking up the $result into it's components
            $users = $result['users'];
            $products = $result['products'];
            $rooms = $result['rooms'];
            
            //creating the add to user select field
            echo "Add to User <select id='orderUser'>";
            foreach ($users as $user) {
                $username = $user['username'];
                echo "<option value='$username'> $username</option>";
            }
            echo "</select>";
            echo "<br /><br />";
            
            //creating the room select field
            echo "Room <select id='destinationRooms'>";
            foreach ($rooms as $room) {
                $roomNumber = $room['roomNumber'];
                echo "<option value='$roomNumber'> $roomNumber</option>";
            }
            echo "</select>";

            //creating the products' buttons
            echo "<br /><br /> Products";
            foreach ($products as $product) {
                $productname = $product['productName'];
                echo "<button type='button' id='$productname'> $productname </button>";
            }
        }
        echo "<br /><br />";

    ?>
    
    <div>
        
    </div>
    
    
    
</body>
</html>