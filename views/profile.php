<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
         @session_start();
         if(!($_SESSION['logged']))
            {    
                header("Location: ../views/login.php");

            }
    include_once "../controllers/AuthenticationController.php";
    $authObj=new Authenticate();
    $id=$_GET['id'];
    $userInfo=$authObj->user($id);
    
    
       
   
       
    ?>
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
                    
                     <img alt="Brand" src="<?php echo trim($_SESSION['userPicture']);?>"  style="width: 50px;height: 50px;float:right;margin-right: 15px;">
                 </a> 
                <a href="profile.php?id=<?php echo trim($_SESSION['userID']);?>" style="margin-right: 20px;"><?php echo trim($_SESSION['username']);?></a>
                
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


        
        
        
        
        <br /><br /><br /><br />
            <div class="container">
                <div class="container">
                    <div class="container">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h1>profile</h1>
                                <h1>welcome: <?php echo $userInfo["username"]?> </h1>
                            </div>
                            <div class="panel-body">
                                
                                <form class="form-horizontal" method="post" action="../controllers/AuthenticationController.php?fn=register&edit=1&id=<?php echo $_GET['id'];?>" enctype="multipart/form-data" >
                                    
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="name" class="col-sm-2 control-label">profile picture</label>
                                      <div class="col-sm-10">
                                         <?php echo "<img class='col-sm-2 control-label' src=".trim($userInfo['userPicture'])." height='100' width='100'>";?> 
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="name" class="col-sm-2 control-label">Name</label>
                                      <div class="col-sm-5">
                                          <input type="text" class="form-control" name="username" required="1" placeholder="Name" value="<?php if( isset($userInfo['username']) ){echo $userInfo['username']; } if( isset($_GET['nameVal']) ){echo $_GET['nameVal'];}?>">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="email" class="col-sm-2 control-label">Email</label>
                                      <div class="col-sm-5">
                                          <input type="email" class="form-control" readonly="1" name="email" required="1" placeholder="Email"  value="<?php if( isset($userInfo['email']) ){echo $userInfo['email']; }if( isset($_GET['emailVal']) ){echo $_GET['emailVal']; }?>">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="password" class="col-sm-2 control-label">Password</label>
                                      <div class="col-sm-5">
                                          <input type="password" class="form-control" name="password" required="1" placeholder="Password">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="passwordc" class="col-sm-2 control-label">Confirm Password</label>
                                      <div class="col-sm-5">
                                          <input type="password" class="form-control" name="passwordc" required="1" placeholder="Password">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="ext" class="col-sm-2 control-label">EXT.</label>
                                      <div class="col-sm-5">
                                          <input type="text" class="form-control" name="ext" required="1" placeholder="Tel Number" value="<?php if( isset($userInfo['ext']) ){echo $userInfo['ext']; }if( isset($_GET['extVal']) ){echo $_GET['extVal']; }?>">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      
                                       <label for="room" class="col-sm-2 control-label">Room No.</label>
                                      <div class="col-sm-5">
                                          <select name="roomNumber">
                                                    <?php  
                                                       include_once "../controllers/AuthenticationController.php";
                                                       $authobj=new Authenticate;
                                                        $rooms=$authobj->getRooms();
                                                        
                                                        
                                                        $getroom=$userInfo['roomNumber'];
                                                        
                                                        for ($i = 0; $i < count($rooms); $i++){
                                                            echo "<option value=\"".$rooms[$i]['roomNumber']."\"";
                                                            if($getroom==$rooms[$i]['id'])
                                                            {echo 'selected';} 
                                                            echo ">";
                                                            echo    $rooms[$i]['roomNumber']."</option>";

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
                                          <input type="file"  name="userPicture" class="form-control" />
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <div class="col-sm-offset-2 col-sm-5">
                                          <p><img src="captcha.php" width="120" height="30" border="1" alt="CAPTCHA"></p>
                                          <p><input type="text" required="1" size="6" maxlength="5" name="captcha" value=""> <br/>
                                          <small>copy the digits from the image into this box</small></p>
                                          <button type="submit" class="btn btn-success" style="width: 220px;">Save</button>
                                          
                                          <button type="reset" class="btn btn-danger" style="width: 220px;">Cancel</button>
                                      </div>
                                    </div>
                                    <?php
                                        if(isset($_GET['errors'])){
                                                $errorarr = explode('^', $_GET['errors']);
                                                foreach ($errorarr as $error) {
                                                        echo "<br/><font color='red'>".$error."</font>";
                                                }
                                        }
	                              ?>
                                    
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