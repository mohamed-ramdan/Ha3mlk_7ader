<!DOCTYPE html>
<html>
<head>
<title>All User</title>
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
    <br><br> <br><br>
<div class="container">
     <div class="panel panel-primary">
        <div class="panel-heading"><h1>All Users</h1></div>
        <div class="panel-body">
        <table class="table table-responsive table-striped">
	<tr>
	<th>Name</th>
	<th>Room</th>		
	<th>Picture</th>
        <th>Ext.</td>
        <th>Delete</th> 
	<th>Edit</th> 
	</tr>

        <?php
        
include_once "../controllers/AuthenticationController.php";
$authObj=new Authenticate;
$users=$authObj->getAllUsers();
$i=0;
echo "</br>";
$length=count($users);
while($length>=1){
echo '<tr>';
//echo $users[$i]['userPicture'];
//echo "</br>";
echo "<td>". $users[$i]['username']." </td>";
echo "<td> ".$users[$i]['roomNumber'] ."</td>";
echo "<td>  <img src=".trim($users[$i]['userPicture'])." height='50' width='50'> </td>";
echo "<td>". $users[$i]['ext']." </td>";
$id=$users[$i]['userID'];
echo "<td> <a class='btn btn-danger' href=http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/controllers/AuthenticationController.php?id=$id&fn=deleteUser>delete</a> </td>";
echo "<td> <a class='btn btn-success' href=http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/views/profile.php?id=$id>edit</a> </td>";
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