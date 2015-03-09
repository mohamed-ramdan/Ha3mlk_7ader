<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../static/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body style="background-image: url('../static/img/loginbg.jpg');">
        <?php
        @session_start();
         if(isset($_SESSION['logged'])&&$_SESSION['isAdmin'])
            {    
                header("Location: ../views/unfinishedorders.php");

            }
          elseif(isset($_SESSION['logged'])){
              
              header("Location: ../views/makeOrder.php");
          }  
   
        ?>
        
        
        <br /> <br /><br /><br /><br />
        
            <div class="container">
                <div class="container">
                    <div class="container">
                        <div class="panel panel-default" style="background-color: rgba(165, 134, 69, 0.53);">
                            <div class="panel-heading" style="background-color:#493D26 !important; color:#fff !important; ">
                                <h1>Login</h1>
                            </div>
                            <div class="panel-body">
                                
                                <form class="form-horizontal" method="post" action="../controllers/AuthenticationController.php?fn=login">
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                      <div class="col-sm-5">
                                        <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" required="1">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                                      <div class="col-sm-5">
                                        <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password" required="1">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <div class="col-sm-offset-2 col-sm-5">
                                          
                                        <button type="submit" class="btn btn-warning" style="width: 445px;">Sign in</button>
                                      </div>
                                    <!--</div>-->
                                    <div class="form-group">
                                        <div class="col-sm-4"></div>
                                      <div class="col-sm-offset-2 col-sm-5">
                                          
                                          <a href="securityquestionfist.php"> Forgot Your Password?</a>
                                      </div>
                                    </div>
                                  
                                     <?php
                       
                            if(isset($_GET['error'])){
                                   
                            echo "<br/><font color='red'>".$_GET['error']."</font>";
                               
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