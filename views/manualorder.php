

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <div id="orderform">
        
    </div>
    <div id="notes">
        Notes:
        <textarea rows="5" cols="20" ></textarea>
    </div>
    
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
                ?>
    
    <script>
         <?php echo $productname; ?>Flag=0;
        var orderform = document.getElementById("orderform");
       
            var <?php echo $productname; ?>Btn =  document.getElementById('<?php echo $productname; ?>');
            <?php echo $productname; ?>Btn.onclick = function(){
                
                 if(<?php echo $productname; ?>Flag===0){
                
            var <?php echo $productname; ?>TextNode = document.createTextNode('<?php echo $productname; ?>');
            var <?php echo $productname; ?>Label = document.createElement('div');
            <?php echo $productname; ?>Label.appendChild(<?php echo $productname; ?>TextNode );
            orderform.appendChild(<?php echo $productname; ?>Label);
            var <?php echo $productname  ?>Quantity=document.createElement("input");
            <?php echo $productname ?>Quantity.setAttribute("id", "<?php echo $productname ?>Quantity");
            <?php echo $productname ?>Quantity.setAttribute("type","number");
            <?php echo $productname ?>Quantity.setAttribute("min",0);
            <?php echo $productname ?>Quantity.setAttribute("value",1);
             orderform.appendChild(<?php echo $productname; ?>Quantity);
             <?php echo $productname; ?>Flag=1;
                 
                 }else{
                 var quantityValue = document.getElementById("<?php echo $productname ?>Quantity").value;
//            var quantityValue =<?php echo $productname; ?>Quantity.data;
               document.getElementById("<?php echo $productname ?>Quantity").setAttribute("value",parseInt(quantityValue)+1);
            //document.getElementById(<?php echo $productname; ?>Quantity).value = parseInt(quantityValue)+1;
        }
                 
            };
        
        
        console.log(<?php echo $productname; ?>Btn);
    </script>
                <?php
            }
        }
        echo "<br /><br />";

    ?>

    
    
</body>
</html>

<?php
/*
 *                 echo "<script  type='text/javascript'> var $productname"."Btn = document.getElementById('$productname');"
                        . " $productname"."Btn.onclick = function(){"
                        . " var orderform =  document.getElementById('orderform');"
                        . " var $productname"."TextNode = document.createTextNode('$productname'); "
                        . " var $productname"."Label = document.createElement('div'); "
                        . " $productname"."Label.appendChild('".$productname."TextNode');"
                        . " orderform.appendChild('$productname"."Label');};</script>";
 * 
 * 
 *         <?php echo "<input id='".$productname."Quantity' type='number' value='1'/>";?>;
 */

?>