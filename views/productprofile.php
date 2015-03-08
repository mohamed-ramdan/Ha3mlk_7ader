<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    @session_start();
    if(!($_SESSION['logged']&&$_SESSION['isAdmin']))
       {    
           header("Location: ../views/login.php");

       }

    include_once "../controllers/AdminController.php";
    $adminObj=new AdminController();
    $id=$_GET['id'];
    $productInfo=$adminObj->product($id);
    var_dump($productInfo);
    
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
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../static/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        
        <nav class="navbar navbar-inverse navbar-fixed-top " style="height: 70px;">
            
            <div class="navbar-header navbar-right" >
                
               
                 <a class="navbar-brand " href="#">
                     <img alt="Brand" src="../static/img/2.jpeg"  style="width: 50px;height: 50px;float:right;margin-right: 15px;">
                 </a> 
                <a href="#" style="margin-right: 20px;">Admin</a>
                
            </div>
            <div class="container">
                <ul class="nav navbar-nav">
                    <li><a>Home</a></li>
                    <li><a>Products</a></li>
                    <li><a>Users</a></li>
                    <li><a>Manual Orders</a></li>
                    <li><a>Checks</a></li>
                    
                    
                    
                </ul>
            </div>
        </nav>
        
        
        
        <br /><br /><br /><br />
            <div class="container">
                <div class="container">
                    <div class="container">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h1>profile</h1>
                                <h1> <?php echo $productInfo["productName"]?> </h1>
                            </div>
                            <div class="panel-body">
                                
                                <form class="form-horizontal" method="post" action="../controllers/AdminController.php?fn=editProduct&id=<?php echo $_GET['id'];?>" enctype="multipart/form-data" >
                                    
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="name" class="col-sm-2 control-label">profile picture</label>
                                      <div class="col-sm-10">
                                         <?php echo "<img class='col-sm-2 control-label' src=".trim($productInfo['productPicture'])." height='100' width='100'>";?> 
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="name" class="col-sm-2 control-label">Name</label>
                                      <div class="col-sm-5">
                                          <input type="text" class="form-control" readonly="1"  name="productName" required="1" placeholder="Name" value="<?php if( isset($productInfo['productName']) ){echo $productInfo['productName']; } ?>">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="price" class="col-sm-2 control-label">Price</label>
                                      <div class="col-sm-5">
                                          <input type="price" class="form-control" name="price" required="1" placeholder="price"  value="<?php if( isset($productInfo['price']) ){echo $productInfo['price']; }?>">
                                      </div>
                                    </div>
                                    
                                    
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      
                                       <label for="room" class="col-sm-2 control-label">category No.</label>
                                      <div class="col-sm-5">
                                          <select name="categoryName">
                                                    <?php  
                                                       include_once "../controllers/AdminController.php";
                                                       $authobj=new AdminController();
                                                        $categories=$authobj->getAllCategories();
                                                        var_dump($productInfo); 
                                                        var_dump($categories);
                                                        $getcat=$productInfo['categoryID'];
                                                        for ($i = 0; $i < count($categories); $i++){
                                                            echo "<option value=\"".$categories[$i]['categoryName']."\""."<?php if(".$getcat."===".$categories[$i]['categoryName']."){echo 'selected';} ?>" 
. $categories[$i]['categoryName']."</option>";

echo "<br/>";


                                                    }
                                                    ?>
                                          </select> 
                                      
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="pic" class="col-sm-2 control-label">Profile Picture</label>
                                      <div class="col-sm-5">
                                          <input type="file"  name="productPicture" class="form-control" />
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <div class="col-sm-offset-2 col-sm-5">
                                           <button type="submit" class="btn btn-success" style="width: 220px;">Save</button>
                                          
                                          <button type="reset" class="btn btn-danger" style="width: 220px;">Cancel</button>
                                      </div>
                                    </div>
                                    
                                    
                                 </form>
                                
                            </div>
                            </div>
                    </div>
                </div>
            </div>
     
    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js"></script>
    </body>
</html>