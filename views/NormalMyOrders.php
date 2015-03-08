<!DOCTYPE html>
<html>
<head>
	<title>Normal Order</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
</head>
<body>
    
    <?php @session_start();
    if(!($_SESSION['logged']))
       {    
           header("Location: ../views/login.php");

       }    
      ?>
    
    <nav class="navbar navbar-inverse navbar-fixed-top " style="height: 70px;">
            
            <div class="navbar-header navbar-right" >
                
               
                 <a class="navbar-brand " href="#">
                    
                     <img alt="Brand" src="<?php echo trim($_SESSION['userPicture']);?>"  style="width: 50px;height: 50px;float:right;margin-right: 15px;">
                 </a> 
                <a href="http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/views/profileuser.php?id=<?php echo trim($_SESSION['userID']);?>" style="margin-right: 20px;"><?php echo trim($_SESSION['username']);?></a>
                
            </div>
            <div class="container">
                <ul class="nav navbar-nav">
                    <li><a href="makeOrder.php">Home</a></li>
                    <li><a href="NormalMyOrders.php">MyOrders</a></li>
                    <li><a href="../controllers/AuthenticationController.php?fn=logout">logout</a></li>
                    
                    
                    
                </ul>
            </div>
        </nav>
    <script>
        ajaxRequest = new XMLHttpRequest();
        
    
        // the function that will open and send the ajax requst to the intended backend page
        // params:      url: the whole data from the input fields put together and ready to append to the  url of the request
        // this function will be called by the confirmBtn listener
        function ajax(url){
                // the first parameter is whether the request method is POST OR Ger
                // the second parameter is the the actual url
                // the third parameter is the type of ajax request , Asyncrounous or        usually always true
                ajaxRequest.open("GET","../controllers/NormalUserController.php?" + url, true);
                console.log("../controllers/NormalUserController.php?" + url);
                
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
                                console.log(ajaxRequest.responseText);
                                var orderChanged = {
                                        "orderID": id,
                                        "newStatus": "canceled",
                                        "type": "cancelOrderStatus"
                                    }
                                conn.send(JSON.stringify(orderChanged));
                        }
        };
    
            
        
        
        </script>
        <br > <br>
        <div class="container">
            <div class='panel panel-primary'>
    <?php
        require_once '../controllers/NormalUserController.php';
        $varNormalUser = new NormalUserController();
        $result = $varNormalUser->getUserorders();
        
        //print_r($result);
        echo "<div class='panel-heading'><h1>My Orders</h1></div>";
        echo "<div class='panel-body'>";
        echo "<table class='table table-responsice table-striped' >";
        echo '<tr>' 
            . '<th> Order ID</td>'
            . '<th> Order Date</th>'
            . '<th> Status</th>'
            . '<th> Amount</th>'
            . '<th> Action</th>'
            . '</tr>';
        $lastOrder = 0; 
        if(isset($result)&&!empty($result)){
        foreach ($result as $key => $order) {
            $thisOrderID =  $order['orderID'];
            if($lastOrder !=$thisOrderID){
            
                echo "<tr>"
                    . '<td>'. $order['orderID'] .'</td>'
                    . '<td>'. $order['date'] .'</td>'
                    . "<td id = 'status".$thisOrderID."'>" .$order['status'] .'</td>'
                    . '<td>'. '100' .'</td>'
                    . '<td>'. "<input type='button' class='btn btn-danger' value='Cancel' id='cancel".$thisOrderID."'" .'</td>';
                ?>
                <script>
                    var cancelBtn =  document.getElementById("<?php echo 'cancel'.$thisOrderID ?>");
                    cancelBtn.onclick = function(){
                        var myStatusCol = document.getElementById('status<?PHP echo $thisOrderID; ?>');
                        //console.log(myStatusCol);
                        myStatusCol.innerHTML = 'Canceled';
                        //console.log(<?PHP echo $thisOrderID; ?>);
                        url = "fn=cancelOrder&orderID="+"<?PHP echo $thisOrderID; ?>";
                        
                        ajax(url);

                    }
                </script>
                <?php
                
            }   
            $lastOrder = $thisOrderID;
        }
        }
        echo '</table>';
        echo "</div><!-- panelbody -->"; //panel body div close
    ?>
                
                
                
                
                
                    </div><!--panel primary-->
                </div><!--container-->
        <script>
                // script for defining the websocket
                var conn = new WebSocket('ws://localhost:8080');

                conn.onopen = function(e) {
                    console.log("Connection established!");
                };

                conn.onmessage = function(e) {
                    var obj= JSON.parse(e.data)
                    if(obj.type=='changeStatus'){
                        var myStatusCol = document.getElementById('status<?PHP echo $thisOrderID; ?>');
                        console.log(myStatusCol);
                        myStatusCol.innerHTML = obj.newStatus;   
                    }


                    //resultdiv.innerHTML += e.data + "<br/>";
                }; 
                var order;
            </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>