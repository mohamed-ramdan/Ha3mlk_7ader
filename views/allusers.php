

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

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
	<td>room</td>		
	<td>picture</td>
        <td>ext.</td>
        <td>delete</td> 
	<td>edit</td> 
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
echo $users[$i]['userPicture'];
echo "</br>";
echo "<td>". $users[$i]['username']." </td>";
echo "<td> ".$users[$i]['roomNumber'] ."</td>";
echo "<td>  <img src=".trim($users[$i]['userPicture'])." height='50' width='50'> </td>";
echo "<td>". $users[$i]['ext']." </td>";
$id=$users[$i]['userID'];
echo "<td> <a href=http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/controllers/AuthenticationController.php?id=$id&fn=deleteUser>delete</a> </td>";
echo "<td> <a href=http://localhost/Ha3mlk_7ader/Ha3mlk_7ader/views/profile.php?id=$id>edit</a> </td>";
$length=$length-1;	
$i=$i+1;

}
?>  



</table>




</div>
</body>
</html>