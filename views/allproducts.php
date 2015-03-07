

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/bootstrap.css"> 
<link rel="stylesheet" href="css/bootstrap-theme.css"> 
</head>
<body>
<div class="container-fluid">
<table class="table table-striped" style="width:100%" >
	<tr>
	<td>name</td>
	<td>price</td>		
	<td>picture</td>
        <td>delete</td> 
	<td>edit</td> 
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
echo "</br>";
$length=count($products);
while($length>=1){
if($products[$i]['visibilty']!="hidden"){    
$id=$products[$i]['productID'];
echo "<tr id='row".$id."'>";
$productstatus=$products[$i]["productStatus"];
echo "</br>";
echo "<td id='name.$id'>". $products[$i]['productName']." </td>";
echo "<td id='price.$id'> ".$products[$i]['price'] ."</td>";
echo "<td id='pic.$id'>  <img src=".trim($products[$i]['productPicture'])." height='50' width='50'> </td>";



echo "<td> <input type='button'  id='$id'  onclick =\"ajax('id=$id&fn=changeState')\"";
echo "value=\"";
if($productstatus=='available')
{echo 'unavailable';}
else{echo 'available';}
echo "\"";
echo ">";
echo "</input>";
echo "</td>";

echo "<td> <input type='button'  id='$id'  onclick =\"ajax('id=$id&fn=deleteProduct')\"";
echo "value=\"";
echo 'delete';
echo "\"";
echo ">";
echo "</input>";
echo "</td>";



//echo "<td><a href=http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/controllers/AdminController.php?id=$id&fn=deleteProduct>delete</a> </td>";
echo "<td><a href=http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/views/productprofile.php?id=$id>edit</a></td>";
}
$length=$length-1;	
$i=$i+1;
}

?> 


</table>
</div>
</body>
</html>

