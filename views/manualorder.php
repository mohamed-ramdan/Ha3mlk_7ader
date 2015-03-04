

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <div id="orderform">
        
    </div>
    <div >
        Notes:
        <textarea rows="5" cols="20" id="notes" ></textarea>
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

    <input type="button" id="confirmBtn" value="Confirm" />
    
    <script>
        ajaxRequest = new XMLHttpRequest();
        function ajax(url){

                ajaxRequest.open("GET","../controllers/AdminController.php?" + url, true);
                
                ajaxRequest.send();
        }
        ajaxRequest.onreadystatechange = function(){    
                        if(ajaxRequest.readyState ===4 && ajaxRequest.status===200){
                                xmlHttp = ajaxRequest.responseText;
                                //document.getElementById("underinput").innerHTML = xmlHttp.getElementsByTagName("response")[0].childNodes[0].nodeValue;
                                //console.log( xmlHttp.getElementsByTagName("response")[0].childNodes[0].nodeValue);
                        }
        };
    
        document.getElementById("confirmBtn").onclick = function(){
        var notes = document.getElementById("notes").value;
        var orderUsername =  document.getElementById("orderUser").value;
        var destinationRooms = document.getElementById("destinationRooms").value;
        console.log(notes);
        console.log(orderUsername);
        console.log(destinationRooms);
        var url = "";
        url = "fn=saveManualOrder&notes="+notes+"&orderUsername="+orderUsername+"&destinationRooms="+destinationRooms;
        <?php 
            foreach ($products as $product) {
                    $productname = $product['productName'];
                    ?>
                    if(<?php echo $productname;?>Flag!=0){
                        var <?php echo $productname ?>Value = document.getElementById("<?php echo $productname ?>Quantity").value;
                    }
                    else{
                        var <?php echo $productname ?>Value = 0;
                    }
                    console.log(<?php echo $productname ?>Value);
                    url+="&<?php echo $productname ?>="+<?php echo $productname ?>Value;
                    <?php
                    
            }
                    
        ?>
            ajax(url);
        }
        
    </script>
    
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