<!DOCTYPE html>
<html>
<head>
	<title>Manual Order</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" /> 
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
    <br ><br />
    <div class="container">
     <div class="panel panel-primary">
        <div class="panel-heading"><h1>Make New Order</h1></div>
        <div class="panel-body">
    
    <div id="orderform">
        <!--
            Here we dynamically put all our number inputs and labels to each product 
        -->
    </div>
    <div class="form-group">    
        <div class="col-sm-3"><label class="label label-default">Notes:</label><textarea class="form-control " placeholder=" Add extra notes for your order" rows="5" cols="20" id="notes" ></textarea></div>
    </div>
    
    <?php
        
        require_once '../controllers/AdminController.php';
        
        // create an object of the Admin Controller class to execute the necessary code for manual order page
        $varAdmin = new AdminController();
        $result = $varAdmin->getManualOrderNeededData(); 
        // the return value is an array which consist of products,categories,users 
        //and rooms each of those consists of an array of associated arrays

        //echo "<h2>Function getManualOrder</h2>";

        if($result!=false){
            //breaking up the $result into it's components
            $users = $result['users'];
            $products = $result['products'];
            $rooms = $result['rooms'];
            echo "<hr>";
            //creating the add to user select field
            echo "<div class='form-group'> ";
            echo "<div class='col-sm-10'></div>";
            echo "<div class='col-sm-3'><label class='labe'>Add to User</label> <select id='orderUser' class='form-control'>";
            foreach ($users as $user)  {
                $username = $user['username'];
                echo "<option value='$username'> $username</option>";
            }
            echo "</select>";
            echo "</div></div>";
            
            
            //creating the room select field
            echo "<div class='form-group'> ";
            echo "<div class='col-sm-10'></div>";
            echo "<div class='col-sm-3'> <label class='labe'> Room </label><select class='form-control' id='destinationRooms'>";
            foreach ($rooms as $room) {
                $roomNumber = $room['roomNumber'];
                echo "<option value='$roomNumber'> $roomNumber</option>";
            }
            echo "</select></div></div>";

            //creating the products' buttons
            echo "<label class='labe'> Choose Products </label> &nbsp;";
            foreach ($products as $product) {
                $productname = $product['productName'];
                echo "<button class='btn btn-primary' type='button' id='$productname'> $productname </button>";
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
                        <?php echo $productname; ?>Label.setAttribute('class','label label-danger');
                        // add the product text node to the product label 
                        <?php echo $productname; ?>Label.appendChild(<?php echo $productname; ?>TextNode );

                        // the product label to the orderform div. can be found at the top of this php file    
                        orderform.appendChild(<?php echo $productname; ?>Label);

                        // create the input number field for each product
                        var <?php echo $productname  ?>Quantity=document.createElement("input");
                        <?php echo $productname ?>Quantity.setAttribute("id", "<?php echo $productname ?>Quantity");
                        <?php echo $productname ?>Quantity.setAttribute("type","number");
                        <?php echo $productname ?>Quantity.setAttribute("style","width:70px !important;");    
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
        } // end of the check to see if result (the return of getManualOrderNeededData from Admin Controller ) is not null 
        //echo "<br /><br />";

    ?>
     
    <!--
        This button to send all the data to the backend through an ajax request
    -->
    <input type="button" class="btn btn-success" id="confirmBtn" value="Confirm" />
    
        
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
                ajaxRequest.open("GET","../controllers/AdminController.php?" + url, true);
                
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
                                thisOrderID = ajaxRequest.responseText;
                                //document.getElementById("underinput").innerHTML = xmlHttp.getElementsByTagName("response")[0].childNodes[0].nodeValue;
                                //console.log( xmlHttp.getElementsByTagName("response")[0].childNodes[0].nodeValue);
                                order['id'] = thisOrderID;
                                conn.send(JSON.stringify(order));
                        }
        };
    
        // get the confirm button and put an action listener on it
        document.getElementById("confirmBtn").onclick = function(){

            // get the value from the input fields     
            var notes = document.getElementById("notes").value;
            var orderUsername =  document.getElementById("orderUser").value;
            var destinationRooms = document.getElementById("destinationRooms").value;

            // making the url sent in the ajax get request ready
            var url = "";
            url = "fn=saveManualOrder&notes="+notes+"&orderUsername="+orderUsername+"&destinationRooms="+destinationRooms;

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
                        //console.log(<?php echo $productname ?>Value);

                        //append the the value to the url
                        url+="&<?php echo $productname ?>="+<?php echo $productname ?>Value;
                        <?php

                }

            ?>
            // call the ajax javascript function
            function pad2(number) {

                return (number < 10 ? '0' : '') + number;

            }
            ajax(url);
            
            xdate = new Date();
            thisMonth = parseInt(xdate.getMonth()) + 1;

            thisDay = parseInt(xdate.getDay()) + 1;
            
            xdate2= xdate.getFullYear() + '-' + pad2(thisMonth) + '-' + pad2(thisDay) + ' ' +pad2(xdate.getHours())+':'+ pad2(xdate.getMinutes())+':'+ pad2(xdate.getSeconds());  
            order = {
                "orderDate": xdate2,
                "Name": "Mark",
                "Room": destinationRooms,
                "Ext": "4444",
                "notes": notes,
                "Products":arr,
                "type": "newOrder"
            }
        }
        
    </script>
    
    
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>