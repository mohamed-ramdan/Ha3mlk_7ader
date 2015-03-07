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
            echo "<table border='1' id='mytable'>";
            echo "<tr id ='mainrow' >";
            echo '<td>Order ID</td>';
            echo '<td>Order Date</td>';
            echo '<td>Name</td>';
            echo '<td>Room</td>';
            echo '<td>Ext.</td>';
            echo '<td>Action</td>';
            echo '</tr>';
            $lastOrder = 0;
            foreach ($result as $order) {
                
                if($order['orderID']!=$lastOrder){
                    //echo "<tr id='a".$order['orderID']."'";
                    echo "<tr id='a".$order['orderID']."'>";
                    
                    echo '<td>'.$order['orderID'].'</td>'; 
                    echo '<td>'.$order['date'].'</td>'; 
                    echo '<td>'.$order['username'].'</td>'; 
                    echo '<td>'.$order['roomNumber'].'</td>'; 
                    echo '<td>'.$order['ext'].'</td>'; 
                    echo '<td>'."do something".'</td>';
                    echo '</tr>';
                    echo '<tr>';
                        echo '<td>'.$order['productName'].'</td>'; 
                }
                else{
                    echo '<td>'.$order['productName'].'</td>'; 

                }
                 $lastOrder = $order['orderID'];

                }
                echo '</table>';
                
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
	    console.log(obj);
            
            
            var table = document.getElementById("mytable");
            var row = table.insertRow(1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            var cell5 = row.insertCell(4);
            var cell6 = row.insertCell(5);
            var row2 = table.insertRow(2);
            var cell7 = row2.insertCell(0);    
            cell1.innerHTML = obj['id'];
            cell2.innerHTML = obj['orderDate'];
            cell3.innerHTML = obj['Name'];
            cell4.innerHTML = obj['Room'];
            cell5.innerHTML = obj['Ext'];
            cell6.innerHTML = "do Something";
            for(i=0;i< obj['Products'].length;i++){
                cell7.innerHTML +=  obj['Products'][i]['ProductName'];
            }
            
	    //resultdiv.innerHTML += e.data + "<br/>";
	}; 
        var order;
    </script>