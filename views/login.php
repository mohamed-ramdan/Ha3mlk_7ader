<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../static/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body style="background-color:#2554C7;">
        <?php
        @session_start();
         if(isset($_SESSION['logged']))
            {    
                header("Location: ../views/makeOrder.php");

            }
   
        ?>
        
        
        <br /> <br /><br /><br /><br />
        
            <div class="container">
                <div class="container">
                    <div class="container">
                        <div class="panel panel-default">
                            <div class="panel-heading">
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
                                      <div class="col-sm-offset-2 col-sm-5">
                                        <div class="checkbox">
                                          <label>
                                            <input type="checkbox"> Remember me
                                          </label>
                                        </div>
                                          
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <div class="col-sm-offset-2 col-sm-5">
                                          
                                        <button type="submit" class="btn btn-primary" style="width: 445px;">Sign in</button>
                                      </div>
                                    <!--</div>-->
                                    <div class="form-group">
                                        <div class="col-sm-4"></div>
                                      <div class="col-sm-offset-2 col-sm-5">
                                          
                                          <a href="securityquestionfist.php"> Forgot Your Password?</a>
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