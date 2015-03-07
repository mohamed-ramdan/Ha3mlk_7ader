<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <script>
        // script for defining the websocket
        var conn = new WebSocket('ws://localhost:8080');
	
        conn.onopen = function(e) {
	    console.log("Connection established!");
	};

	conn.onmessage = function(e) {
            var obj= JSON.parse(e.data)
	    console.log(obj);
	    //resultdiv.innerHTML += e.data + "<br/>";
	}; 
        var order;
    </script>
    
    
    <div id="orderform">
        <!--
            Here we dynamically put all our number inputs and labels to each product 
        -->
    </div>
    <div>
        Notes:
        <textarea rows="5" cols="20" id="notes" ></textarea>
    </div>
    
    <?php
        require_once '../controllers/NormalUserController.php';
        
        // create an object of the Admin Controller class to execute the necessary code for manual order page
        $varNormalUser = new NormalUserController();
        $result = $varNormalUser->getMakeOrderNeededData(); 
        // the return value is an array which consist of products,categories,users 
        //and rooms each of those consists of an array of associated arrays
        
        if($result!=false){
            $products = $result['products'];
            $rooms = $result['rooms'];
            $latestOrder = $result['latestOrder'];
            $categories = $result['categories'];
            
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
                    // this script is added after each button 
                    // it contains the onclick event of each button


                    // flag for each product (if it was added to the div or not
                    // if added before then just increase it's value by 1
                    // we set it at first = 0
                     <?php echo $productname; ?>Flag=0;

                    // get the element order form: the one we put our dynamically created input fields into     
                    var orderform = document.getElementById("orderform");

                   // get the productbutton of each product : remember we are in a php foreach
                    var <?php echo $productname; ?>Btn =  document.getElementById('<?php echo $productname; ?>');

                    //onclick action listener of the the productBtn
                    <?php echo $productname; ?>Btn.onclick = function(){

                    // check the value of the product flag
                    if(<?php echo $productname; ?>Flag===0){

                        // create a text node that holds the label of the product and a div that will contains this textNode
                        var <?php echo $productname; ?>TextNode = document.createTextNode('<?php echo $productname; ?>');
                        var <?php echo $productname; ?>Label = document.createElement('div');

                        // add the product text node to the product label 
                        <?php echo $productname; ?>Label.appendChild(<?php echo $productname; ?>TextNode );

                        // the product label to the orderform div. can be found at the top of this php file    
                        orderform.appendChild(<?php echo $productname; ?>Label);

                        // create the input number field for each product
                        var <?php echo $productname  ?>Quantity=document.createElement("input");
                        <?php echo $productname ?>Quantity.setAttribute("id", "<?php echo $productname ?>Quantity");
                        <?php echo $productname ?>Quantity.setAttribute("type","number");
                        <?php echo $productname ?>Quantity.setAttribute("min",0);
                        <?php echo $productname ?>Quantity.setAttribute("value",1);

                        // add the product number input to the orderform div    
                        orderform.appendChild(<?php echo $productname; ?>Quantity);


                        // set the flag of this product to 1 so we won't create the same label and number input again
                        // but will just increase it instead
                         <?php echo $productname; ?>Flag=1;
                             
                             
                        var <?php echo $productname  ?>Delete=document.createElement("input");
                        <?php echo $productname ?>Delete.setAttribute("id", "<?php echo $productname ?>Delete");
                        <?php echo $productname ?>Delete.setAttribute("type","button");
                        <?php echo $productname ?>Delete.setAttribute("value","x");
                        orderform.appendChild(<?php echo $productname; ?>Delete);
                        <?php echo $productname; ?>Delete.onclick = function(){
                            orderform.removeChild(<?php echo $productname; ?>Label);
                            orderform.removeChild(<?php echo $productname; ?>Quantity);
                            orderform.removeChild(<?php echo $productname; ?>Delete);
                           <?php echo $productname; ?>Flag=0;
                        }
                             
                             
                             

                    }else{
                        // the case where the flag = 1
                        // get the product number input to increase it by 1 
                        var quantityValue = document.getElementById("<?php echo $productname ?>Quantity").value;
            //            var quantityValue =<?php echo $productname; ?>Quantity.data;

                        // parse the value of the number input to integer first and then increase it by 1
                        document.getElementById("<?php echo $productname ?>Quantity").setAttribute("value",parseInt(quantityValue)+1);
                        //document.getElementById(<?php echo $productname; ?>Quantity).value = parseInt(quantityValue)+1;
                    }

                        };
                </script>
                
                <?php
            } //end of the for each loop
            
            
        }
    ?>
    <!--
        This button to send all the data to the backend through an ajax request
    -->
    <input type="button" id="confirmBtn" value="Confirm" />
    
    <script>
        // Script to provide the logic of the ajax request and the listener for the confirm button 
        
        //create an ajax XML Http Request 
        ajaxRequest = new XMLHttpRequest();
        
    
        // the function that will open and send the ajax requst to the intended backend page
        // params:      url: the whole data from the input fields put together and ready to append to the  url of the request
        // this function will be called by the confirmBtn listener
        function ajax(url){
                // the first parameter is whether the request method is POST OR Ger
                // the second parameter is the the actual url
                // the third parameter is the type of ajax request , Asyncrounous or        usually always true
                ajaxRequest.open("GET","../controllers/NormalUserController.php?" + url, true);
                
                // send the request.. remember we sent the data in the url
                ajaxRequest.send();
        }
        
        // onlick action listener for the ajax request
        // it's useful because through it we can control what to do when the request come back to the client with a response 
        ajaxRequest.onreadystatechange = function(){    
                        // readyState = 4  means the request is done and came back to the client
                        // 200 means the server and file were successufly found
                        if(ajaxRequest.readyState ===4 && ajaxRequest.status===200){
                                // the actual response text
                                id = ajaxRequest.responseText;
                                order['id'] = id;
                                conn.send(JSON.stringify(order));
                        }
        };
    
        // get the confirm button and put an action listener on it
        document.getElementById("confirmBtn").onclick = function(){

            // get the value from the input fields     
            var notes = document.getElementById("notes").value;
            
            var destinationRooms = document.getElementById("destinationRooms").value;

            // making the url sent in the ajax get request ready
            var url = "";
            url = "fn=saveOrder&notes="+notes+"&destinationRooms="+destinationRooms;

            //openinh php tags to append the quantitiy of each product to the url
            var arr = [];
            <?php 
                // go over all the available products
                
                foreach ($products as $product) {
                        // extract the the name of each product
                        $productname = $product['productName'];
                        ?>

                        // if the product flag wasn't 0 which means the input number field of the product
                        // exist in the orderform and the user choose at least one
                        if(<?php echo $productname;?>Flag!=0){
                            var <?php echo $productname ?>Value = document.getElementById("<?php echo $productname ?>Quantity").value;
                            pname = <?php echo $productname  ?>.getAttribute("id");
                            arr.push({
                                "ProductName": pname,
                                "Quantity": <?php echo $productname ?>Value
                            });
                        }
                        else{
                            // if the flag was zero then put the value =0
                            var <?php echo $productname ?>Value = 0;
                        }
                        
                        //append the the value to the url
                        url+="&<?php echo $productname ?>="+<?php echo $productname ?>Value;
                        <?php

                }

            ?>
            // call the ajax javascript function
            ajax(url);
            xdate = new Date();
            xdate2= xdate.getFullYear() + '-' + xdate.getMonth() + '-' + xdate.getDay() + ' ' +xdate.getHours()+':'+ xdate.getMinutes()+':'+ xdate.getSeconds();  
            order = {
                "orderDate": xdate2,
                "Name": "Mark",
                "Room": destinationRooms,
                "Ext": "4444",
                "notes": notes,
                "Products":arr
            }
            
            /// HERE Starts the websocket
                //conn.send(JSON.stringify(order));
            
            //// Here ENds the web socket
            console.log(order);
            
        }
        
    </script>
</body>
</html>