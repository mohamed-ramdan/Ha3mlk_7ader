<html>
    <head>
        <title>checks</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
        
        <link href="../static/css/bootstrap-combined.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" media="screen"
              href="../static/css/bootstrap-datetimepicker.min.css">
    </head>
    <body>
         <?php
        @session_start();
         if(!isset($_SESSION['logged']))
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

       <?php $dt = new DateTime(); echo $dt->format('Y-m-d h-i-sa'); ?>
        
        
        
        <br /> <br /><br /> <br />
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Checks</h1>
                </div><!--panel heading -->
                <div class="panel-body">
                    <div class="form-group">
<!--                        <div class="col-sm-5">Date From: <input class="form-control" type="date" value="<?php $dt = new DateTime(); echo $dt->format('Y-m-d'); ?>" name="datefrom" /></div>
                        <div class="col-sm-5">Date To: <input class="form-control" type="date" value="<?php $dt = new DateTime(); echo $dt->format('Y-m-d'); ?>" name="dateto" /></div>-->
                    <div id="datetimepicker" class="input-append date col-sm-3">
                        <label class="control-label "><strong>Date From:</strong></label> 
                        <input type="text" name="datefrom"  />
                        <span class="add-on">
                          <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                        </span>
                        </div>
                        
                        <div id="datetimepicker2" class="input-append date col-sm-3 ">
                            <label class="control-label"><strong>Date To: </strong></label>
                            <input type="text" name="dateto"  />
                        <span class="add-on">
                          <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
                        </span>
                        </div>
                    </div>
                    <div class="container"> <input type="button" class="btn btn-info" id="example" value="ex"/></div>
                    <br /><br /><br />
                    
                    
                    <div class="form-group">
                        <div class="col-sm-6" >
                            <label class="control-label"><strong>User: </strong></label>
                            <select class="form-control" id="selecteduser">
                                <?php
                                    include_once '../controllers/AdminController.php';
                                    $thisAdminVar = new AdminController();
                                    $users = $thisAdminVar->getAllUsers();
                                    foreach ($users as $usr) 
                                    {
                                        $userName = $usr['username'];
                                        $usrId = $usr['userID'];
                                        echo "<option id='$usrId'>".$userName."</option>";
                                    }
                                ?>
                            </select>                      
                        </div>
                    </div>
                    
                    
                    
                
                    
                    
                    <br /><br />
                    
                    
                    <div class="container col-sm-10" id="accParent">
                        <div class="panel panel-default" >
                        <div class="panel-body">
                  <!--  <table class="table table-responsive table-striped ">
                        <tr>
                             <th style="color: #1569C7;">
                                Setting
                            </th>
                            <th style="color: #1569C7;">
                                Name
                            </th>
                            <th style="color: #1569C7;">
                                Total Amount
                            </th>   
                            
                        </tr> -->
                        
                        <?php
                         include_once '../controllers/AdminController.php';
                                    $thisAdminVar = new AdminController();
                                    $retValue = $thisAdminVar->getChecksNeededData();
                                    $result = $retValue['result'];
                                    $amountPerUser = $retValue['amountPerUser'];
                                    //var_dump($amountPerUser);
                                    //print_r($result);
                                    echo "<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='false'>";
                                    
                                    $counter = $counterr = 0;
                                    $lastUserID = 0;
                                    $lastOrderID = 0;
                                    echo '<div id="checksHolder"></div>';
                                    foreach ($result as $record) 
                                    {
                                        $thisUserID = $record['userID'];
                                        $thisOrderID = $record['orderID'];
                                        if($thisUserID!=$lastUserID){
                                            ?>
                                                <script>
                                                    var myTable = document.createElement("table");
                                                    myTable.setAttribute("id",'userTable<?php echo $thisUserID; ?>');
                                                    //myTable.setAttribute("border",'1');
                                                    myTable.setAttribute("class",'table table-responsive table-striped');
                                                    var th1 = document.createElement('th');
                                                    th1.innerHTML='User Name';
                                                    var th2 = document.createElement('th');
                                                    th2.innerHTML="Total Amount";
                                                    var th3 = document.createElement('th');
                                                    th3.innerHTML='Order Products';
                                                    var th4 = document.createElement('th');
                                                    th4.innerHTML='Order Notes';
                                                    myTable.appendChild(th1);
                                                    myTable.appendChild(th2);
                                                    myTable.appendChild(th3);
                                                    myTable.appendChild(th4);
                                                        var row = myTable.insertRow(0);
                                                        
                                                        var cell1 = row.insertCell(0);
                                                        var cell2 = row.insertCell(1);
                                                        cell1.innerHTML =<?php echo '"'.$record['username'].'"'; ?> ;
                                                        cell2.innerHTML =<?php 
                                                                foreach ($amountPerUser as $userAmount) {
                                                                    if($userAmount["userID"] == $thisUserID ){
                                                                        echo $userAmount['sum(cafeOrder.amount)'];
                                                                    }
                                                                    
                                                                } 
                                                        ?> ;
                                                        document.getElementById("checksHolder").appendChild(myTable);
                                                </script>
                                            <?php

                                        }   
                                        
                                        $lastUserID = $thisUserID; 
                                        $lastOrderID = $thisOrderID; 
                                      
                                    }
                                    $lastUserID = 0;
                                    $lastOrderID = 0;
                                    foreach ($result as $record) 
                                    {
                                        $thisUserID = $record['userID'];
                                        $thisOrderID = $record['orderID'];
                                        if($thisOrderID!=$lastOrderID){
                                            ?>
                                                <script>
                                                    var myTable = document.getElementById('userTable<?php echo $thisUserID; ?>');
                                                        var row = myTable.insertRow(1);
                                                        row.setAttribute("id","orderRow<?php echo $thisOrderID; ?>")
                                                        var cell1 = row.insertCell(0);
                                                        cell1.innerHTML =<?php echo '"'.$record['note'].'"'; ?> ;
                                                        var cell2 = row.insertCell(0);
                                                        cell2.innerHTML =<?php echo '"'.$record['amount'].'"'; ?> ;
                                                       
                                                </script>
                                            <?php

                                        }   
                                        
                                        $lastUserID = $thisUserID; 
                                        $lastOrderID = $thisOrderID; 
                                      
                                    }
                                    foreach ($result as $record) 
                                    {
                                        $thisUserID = $record['userID'];
                                        $thisOrderID = $record['orderID'];
                                        
                                            ?>
                                                <script>
                                                    var myRow = document.getElementById('orderRow<?php echo $thisOrderID; ?>');
                                                        var cell1 = myRow.insertCell(0);
                                                        cell1.innerHTML =<?php echo '"'.$record['productName'].'"'; ?> ;
                                                </script>
                                            <?php

                                         
                                        
                                        $lastUserID = $thisUserID; 
                                        $lastOrderID = $thisOrderID; 
                                      
                                    }
                                    
                                    echo "</div>";
                        ?>
                  <!--  </table>-->
                        </div><!--panel body-->
                        </div><!--panel default-->
                    </div><!--inner container-->
                </div><!--panel body-->
        
                
                <div class="panel panel-default">
                <div id="orderproduct">
                    
                </div>
                </div>
                
<script> 
                    var selectedUser =document.getElementById('selecteduser');
                    var row = document.getElementById('accordion');
                   ajaxRequest = new XMLHttpRequest();
                        function ajax(url)
                        {
                            // create ajax request and send it 
                            ajaxRequest.open("GET","../controllers/AdminController.php?"+url, true);
                            ajaxRequest.send();
                        }


                        // when the request is recieved get the response & draw new elements that contain response data
                        ajaxRequest.onreadystatechange = function()
                        {

                            if(ajaxRequest.readyState ===4 && ajaxRequest.status===200)
                            {
                                // the actual response text
                                ajaxResult = ajaxRequest.responseText;
                                //console.log(result)
                                if(document.getElementById("checksHolder")){
                                    while (document.getElementById("checksHolder").hasChildNodes()) {
                                        document.getElementById("checksHolder").removeChild(document.getElementById("checksHolder").lastChild);
                                    }
                                }
                                
                               var objRet = JSON.parse(ajaxResult);
                               console.log(objRet);
                               var result = objRet['result'];
                               var amountPerUser = objRet['amountPerUser'];
                               var lastUserID = 0;
                               var lastOrderID = 0;
                               for(var i = 0 ; i<result.length ; i++  ){
                                   var thisUserID = result[i]['userID'];
                                   var thisOrderID = result[i]['orderID'];
                                   var xamount=100;
                                   if(thisUserID!=lastUserID){
                                       var myTable = document.createElement("table");
                                       myTable.setAttribute("id",'userTable'+thisUserID);
                                       myTable.setAttribute("border",'1');
                                           var row = myTable.insertRow(0);

                                           var cell1 = row.insertCell(0);
                                           var cell2 = row.insertCell(1);
                                           cell1.innerHTML = result[i]['username'];
                                           for(var j=0; j<amountPerUser.length; j++){
                                               if(amountPerUser[j]['userID']== thisUserID){
                                                   xamount = amountPerUser[j]['sum(cafeOrder.amount)'];
                                               }
                                           }
                                           document.getElementById("checksHolder").appendChild(myTable);
                                           cell2.innerHTML = xamount;
                                   }
                                   lastUserID = thisUserID;
                                   lastOrderID = thisOrderID;
                               }
                               
                               
                               
                               
                               var lastUserID = 0;
                               var lastOrderID = 0;
                               for(var i = 0 ; i<result.length ; i++  ){
                                   var thisUserID = result[i]['userID'];
                                   var thisOrderID = result[i]['orderID'];
                                   var xamount=100;
                                   if(thisOrderID!=lastOrderID){
                                           
                                           var myTable = document.getElementById('userTable'+thisUserID);
                                           myTable.setAttribute('class','table table-responsive table-striped');
                                           var row = myTable.insertRow(1);
                                           row.setAttribute("id","orderRow"+thisOrderID);
                                           var cell1 = row.insertCell(0);
                                           cell1.innerHTML = result[i]['note'];
                                           var cell2 = row.insertCell(0);
                                           cell2.innerHTML = result[i]['amount'];
                                   }
                                   
                                   lastUserID = thisUserID;
                                   lastOrderID = thisOrderID;
                               }
                               var lastUserID = 0;
                               var lastOrderID = 0;
                               for(var i = 0 ; i<result.length ; i++  ){
                                   var thisUserID = result[i]['userID'];
                                   var thisOrderID = result[i]['orderID'];
                                   var xamount=100;
                                   
                                   var myRow = document.getElementById('orderRow'+thisOrderID);
                                   var cell1 = myRow.insertCell(0);
                                   cell1.innerHTML =result[i]['productName'];
                                   
                                   lastUserID = thisUserID;
                                   lastOrderID = thisOrderID;
                                   
                               }
                               
                            }
                    };    

                    selectedUser.onchange=function()
                    {
                        // remove the exist data
                        //document.getElementById('accParent').parentNode.removeChild(document.getElementById('accParent'));

                        //retrieve selected user data through ajax
                        
                         var url = "fn=getChecksNeededData";
                         ajax(url);   
                    };
                
                </script>
        
        
                <!--<div class="container"> <input type="button" class="btn btn-info" id="example" value="ex"/></div>-->



        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
        <script type="text/javascript"
                src="../static/js/bootstrap-datetimepicker.min.js">
        </script>
        <script type="text/javascript"
                src="../static/js/bootstrap-datetimepicker.pt-BR.js">
        </script>
        <script type="text/javascript">
         $('#datetimepicker').datetimepicker({
           format: 'yyyy-MM-dd hh:mm:ss',
           
         });
         $('#datetimepicker2').datetimepicker({
           format: 'yyyy-MM-dd hh:mm:ss',
          
         });
         document.getElementById("example").onclick = function(){
            var datefrompicker = document.getElementsByName("datefrom")[0];
            var datetopicker = document.getElementsByName("dateto")[0];

            //var localDate = picker.getLocalDate();       
            
            console.log(datefrompicker.value);
            console.log(datetopicker.value);
            
                var url = "fn=getChecksNeededData&dateFrom="+datefrompicker.value+"&dateTo="+datetopicker.value+"&userid="+selecteduser.options[selecteduser.options.selectedIndex].id;
            console.log(url);
            ajax(url);  
         }

        </script>
            </div></div>
    </body>
</html>