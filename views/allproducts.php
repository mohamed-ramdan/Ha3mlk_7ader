<!DOCTYPE html>
<html>
<head>
<title>All Product</title>
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
    
    <br ><br > <br ><br >
<div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><h1>All Products</h1></div>
        <div class="panel-body">
        <li><a href="addproduct.php">addProduct</a></li>    
        <table class="table table-responsive table-striped">
	<tr>
	<th>Name</th>
	<th>Price</th>		
	<th>Picture</th>
        <th>Status</th>
        <th>Delete</th> 
	<th>Edit</th> 
	</tr>

       
<script>

//create an ajax XML Http Request 
        ajaxRequest = new XMLHttpRequest();
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
                               
                                //xmlHttp = ajaxRequest.responseText;
                                //alert(xmlHttp);
//document.getElementById("underinput").innerHTML = xmlHttp.getElementsByTagName("response")[0].childNodes[0].nodeValue;
                                //console.log( xmlHttp.getElementsByTagName("response")[0].childNodes[0].nodeValue);
                        
                        
                        comeResponse=(ajaxRequest.responseText).split('@');        
                        //alert(typeof(comeResponse[1]));
                        
                        
                        
                        response=parseInt(comeResponse[0]);
                        productstatus=document.getElementById(response).getAttribute("value");
                        //alert(comeResponse[0]);
                        //alert(comeResponse[1]); 
                        if(comeResponse[1].trim()=="changestate"){
                           alert(comeResponse[1]);
                        if(productstatus=='available')
                        {
                           // alert("response");
                            //alert(productstatus);
                            document.getElementById(response).setAttribute("value","unavailable");
                        }
                        else{
                            //alert("response");
                           // alert(productstatus);
                            document.getElementById(response).setAttribute("value","available");
                        }
                    }
                    
                       if(comeResponse[1].trim()=="delete"){
                           document.getElementById('row'+response).parentNode.removeChild(document.getElementById('row'+response));
                        
                    }
                    if(comeResponse[1].trim()=="edit"){
                           document.getElementById('row'+response).parentNode.removeChild(document.getElementById('row'+response));
                        
                    }
                    
                    
                }
        };
    
</script>


<?php 
include_once "../controllers/AdminController.php";
$adminObj=new AdminController;

$products=$adminObj->getProducts();
$i=0;
//echo "</br>";
$length=count($products);
while($length>=1){
if($products[$i]['visibilty']!=0){    
$id=$products[$i]['productID'];
echo "<tr id='row".$id."'>";
$productstatus=$products[$i]["productStatus"];
//echo "</br>";
echo "<td id='name.$id'>". $products[$i]['productName']." </td>";
echo "<td id='price.$id'> ".$products[$i]['price'] ."</td>";
echo "<td id='pic.$id'>  <img src=".trim($products[$i]['productPicture'])." height='50' width='50'> </td>";



echo "<td> <input type='button' class='btn btn-warning' id='$id'  onclick =\"ajax('id=$id&fn=changeState')\"";
echo "value=\"";
if($productstatus=='available')
{
    echo 'unavailable';
    
}
else{echo 'available';}
echo "\"";
echo ">";
echo "</input>";
echo "</td>";

echo "<td> <input type='button' class='btn btn-danger'  id='$id'  onclick =\"ajax('id=$id&fn=deleteProduct')\"";
echo "value=\"";
echo 'delete';
echo "\"";
echo ">";
echo "</input>";
echo "</td>";



//echo "<td><a href=http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/controllers/AdminController.php?id=$id&fn=deleteProduct>delete</a> </td>";
echo "<td><a class='btn btn-success' href=http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/views/productprofile.php?id=$id>edit</a></td>";
}
$length=$length-1;	
$i=$i+1;
}

?> 


</table>
            </div><!--panel body-->
        </div><!--panel-->
</div><!--container-->
    
    
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
</body>
</html>

