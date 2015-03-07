<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
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
                              
                        }
        };
    
            
        
        
        </script>
    <?php
        require_once '../controllers/NormalUserController.php';
        $varNormalUser = new NormalUserController();
        $result = $varNormalUser->getUserorders();
        
        //print_r($result);
        echo 'My Orders';
        echo '<table>';
        echo '<tr>' 
            . '<td> Order ID</td>'
            . '<td> Order Date</td>'
            . '<td> Status</td>'
            . '<td> Amount</td>'
            . '<td> Action</td>'
            . '</tr>';
        $lastOrder = 0; 
        foreach ($result as $key => $order) {
            $thisOrderID =  $order['orderID'];
            if($lastOrder !=$thisOrderID){
            
                echo "<tr>"
                    . '<td>'. $order['orderID'] .'</td>'
                    . '<td>'. $order['date'] .'</td>'
                    . "<td id = 'status".$thisOrderID."'>" .$order['status'] .'</td>'
                    . '<td>'. '100' .'</td>'
                    . '<td>'. "<input type='button' value='Cancel' id='cancel".$thisOrderID."'" .'</td>';
                ?>
                <script>
                    var cancelBtn =  document.getElementById("<?php echo 'cancel'.$thisOrderID ?>");
                    cancelBtn.onclick = function(){
                        var myStatusCol = document.getElementById('status<?PHP echo $thisOrderID; ?>');
                        console.log(myStatusCol);
                        myStatusCol.innerHTML = 'Canceled';
                        console.log(<?PHP echo $thisOrderID; ?>);
                        url = "fn=cancelOrder&orderID="+"<?PHP echo $thisOrderID; ?>";
                        
                        ajax(url);

                    }
                </script>
                <?php
                
            }   
            $lastOrder = $thisOrderID;
        }
        echo '</table>';
    ?>

</body>
</html>