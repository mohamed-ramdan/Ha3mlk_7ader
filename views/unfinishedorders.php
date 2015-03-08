<html>
<head>
        <title>unfinished orders</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
    </head>
<body>

<?php
        @session_start();
         if(!($_SESSION['logged']&&$_SESSION['isAdmin']))
            {    
                header("Location: ../views/login.php");

            }
   
        ?>
<nav class="navbar navbar-inverse navbar-fixed-top " style="height: 70px;">
            
            <div class="navbar-header navbar-right" >
                
               
                 <a class="navbar-brand " href="#">
                    
                     <img alt="Brand" src="<?php echo trim($_SESSION['userPicture']);?>"  style="width: 50px;height: 50px;float:right;margin-right: 15px;">
                 </a> 
                <a href="http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/views/profile.php?id=<?php echo trim($_SESSION['userID']);?>" style="margin-right: 20px;"><?php echo trim($_SESSION['username']);?></a>
                
            </div>
            <div class="container">
                <ul class="nav navbar-nav">
                    <li><a href="unfinishedorders.php">Home</a></li>
                    <li><a href="allproducts.php">Products</a></li>
                    <li><a href="allusers.php">Users</a></li>
                    <li><a href="manualorder.php">Manual Orders</a></li>
                    <li><a href="checks.php">Checks</a></li>
                    <li><a href="../controllers/AuthenticationController.php?fn=logout">logout</a></li>
                    
                    
                    
                </ul>
            </div>
        </nav>
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
                                
                                //console.log(updatedOrder);
                                if(ajaxRequest.responseText.trim()!='false'){
                                    
                                    comeResponse=(ajaxRequest.responseText).split('@');
                                    updateOrderID = parseInt(comeResponse[0]);
                                    updateOrderStatus = comeResponse[1].trim();
                                    document.getElementById('textstatus'+ updateOrderID ).innerHTML= updateOrderStatus;
                                    
                                    
                                    var orderChanged = {
                                        "orderID": updateOrderID,
                                        "newStatus": updateOrderStatus,
                                        "type": "changeStatus"
                                    }
                                    conn.send(JSON.stringify(orderChanged));
                                   
                                }
                                
                        }
        };
    
            // call the ajax javascript function

    </script>
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
            //echo "<br /><p style='color:orange';> Unfinished orders <p><br/> ";
            echo "<div class='container'>";
            echo "<div class='panel panel-primary'>";
            echo "<div class='panel-heading'><h1>Unfinished Orders</h1></div>";
            echo "<div class='panel-body'>";
            //extracting each item from $result
            echo "<table  id='mytable' class='table table-responsive table-striped'>";
            echo "<tr id ='mainrow' >";
            echo '<th>Order ID</th>';
            echo '<th>Order Date</th>';
            echo '<th>Name</th>';
            echo '<th>Room</th>';
            echo '<th>Ext.</th>';
            echo '<th>Status</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            $lastOrder = 0;
            foreach ($result as $order) {
                $thisOrderID=$order['orderID'];
                if($order['orderID']!=$lastOrder){
                    //echo "<tr id='a".$order['orderID']."'";
                    echo "<tr id='a".$order['orderID']."'>";
                    
                    echo '<td>'.$order['orderID'].'</td>'; 
                    echo '<td>'.$order['date'].'</td>'; 
                    echo '<td>'.$order['username'].'</td>'; 
                    echo '<td>'.$order['roomNumber'].'</td>'; 
                    echo '<td>'.$order['ext'].'</td>'; 
                    echo "<td id='textstatus$thisOrderID'>".$order['status'].'</td>'; 
                    echo '<td>'."<select class='form-control' id='change$thisOrderID'".">"
                            . "<option value='preparing'> preparing </option>"
                            . "<option value='delivering'> delivering </option>"
                            . "<option value='done'> done </option>"
                            . "</select>".'</td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td>'."<img src='".$order['productPicture']."' width='50px' height='50px'>".'</td>';
                    ?>
                        <script>
                            if( document.getElementById('textstatus<?php echo $thisOrderID; ?>' ).innerHTML.trim()!='Canceled'){
                             //console.log(element.selectedIndex);
                                var element = document.getElementById('change<?php echo $thisOrderID; ?>');
                                //console.log(element);
                                element.value = '<?php echo $order['status']; ?>';
                                element.onchange= function(){
                                    newStatus =  this.options[ this.selectedIndex ].value 
                                    var url =  "fn=changeOrderStatus&newStatus="+newStatus+"&orderID="+"<?php echo $thisOrderID; ?>";
                                    console.log(url);
                                    ajax(url);
                                }
                                }else{
                                   document.getElementById('change<?php echo $thisOrderID; ?>').parentNode.removeChild(document.getElementById('change<?php echo $thisOrderID; ?>')); 
                                }    
                                    
                                
                                
                        </script>
                    <?php
                    
                }
                else{
                    //echo '<td>'.$order['productName'].'</td>'; 
                    echo '<td>'."<img src='".$order['productPicture']."' width='50px' height='50px'>".'</td>';

                }
                 $lastOrder = $order['orderID'];

                }
                echo '</table>';
                echo "</div></div></div>";
            }
        else
        {
            
            echo "<br /><p style='color:green';> All orders accomplished <p> ";
        }
    echo "<br />";

?>
    
    <script>
        // script for defining the websocket
        var conn = new WebSocket('ws://localhost:8080');
	
        conn.onopen = function(e) {
	    console.log("Connection established!");
	};

	conn.onmessage = function(e) {
            var obj= JSON.parse(e.data)
            if(obj.type=='newOrder'){
	    console.log(obj);
                      
            var table = document.getElementById("mytable");
            var row = table.insertRow(1);
            row.id = obj['id'];
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var cell7= row.insertCell(6);
            var row2 = table.insertRow(2);
                
            cell1.innerHTML = obj['id'];
            cell2.innerHTML = obj['orderDate'];
            cell3.innerHTML = obj['Name'];
            cell4.innerHTML = obj['Room'];
            cell5.innerHTML = obj['Ext'];
            cell6.innerHTML = "preparing";
            
            var changeStatusSelect = document.createElement("select");
            changeStatusSelect.setAttribute("id","change"+obj['id']);
            
            changeStatusSelect.setAttribute("class","form-control");
            var prepOption = document.createElement("option");
            prepOption.setAttribute("value","preparing");
            prepOption.innerHTML = "preparing";
            var delvOption = document.createElement("option");
            delvOption.setAttribute("value","delivering");
            delvOption.innerHTML = "delivering";
            var doneOption = document.createElement("option");
            doneOption.setAttribute("value","done");
            doneOption.innerHTML = "done";
            changeStatusSelect.appendChild(prepOption);
            changeStatusSelect.appendChild(delvOption);
            changeStatusSelect.appendChild(doneOption);
            
            changeStatusSelect.onchange= function(){
                newStatus =  changeStatusSelect.options[ changeStatusSelect.selectedIndex ].value 
                var url =  "fn=changeOrderStatus&newStatus="+newStatus+"&orderID="+obj['id'];
                console.log(url);
                ajax(url);
            }
            
            cell7.appendChild(changeStatusSelect);
            
            
            for(i=0;i< obj['Products'].length;i++){
                var cell8 = row2.insertCell(0);
                cell8.innerHTML +=  obj['Products'][i]['ProductName'];
                //cell8.innerHTML +=  obj['Products'][i]['productPicture'];
            }
        }
        else if(obj.type=='cancelOrderStatus') {
            document.getElementById('textstatus'+ parseInt(obj.orderID) ).innerHTML= obj.newStatus;
            document.getElementById('change'+parseInt(obj.orderID)).parentNode.removeChild(document.getElementById('change'+parseInt(obj.orderID)));
        }
            
	    //resultdiv.innerHTML += e.data + "<br/>";
	}; 
        var order;
    </script>
    
    
    
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../static/js/bootstrap.min.js" type="text/javascript"></scrip
</body>
</html>>
