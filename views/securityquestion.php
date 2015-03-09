<html>
    <head>
        <title>Security Qestion</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
    </head>
    <body style="background-image: url('../static/img/bbg.jpg'); background-repeat: repeat;">
         <?php @session_start();
    if(!($_SESSION['check']))
       {    
           header("Location: ../views/login.php");

       }    
      ?>
        
        
        
        
        <br ><br >
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading" style='background-color:rgba(81, 71, 25, 0.56)!important;'><h1>Answer The Security Qestion</h1></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="get" action="../controllers/AuthenticationController.php">
                        
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <label class="control-label col-sm-2" for="q">Your Question:</label>
                            <div class="col-sm-5"><input type="text" name="q" class="form-control " value="<?php if(isset($_GET['question'])){echo $_GET['question'];}?>" readonly='1' /></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <label class="control-label col-sm-2" for="ans">Your Answer:</label>
                            <div class="col-sm-5"><input type="text" name="ans" class="form-control" placeholder="Enter your Answer" /></div>
                        </div>
                        
                        
                        
                         <div class="form-group">
                              
                             <?php
                       
                            if(isset($_GET['error'])){
                                   
                            echo "<br/><font color='red'>".$_GET['error']."</font>";
                               
                            }
                            ?>  
                        
                        
                        <div class="form-group">
                            <div class="col-sm-5"></div>
                            
                            
                            
                            <input type="submit" value="Save" class="btn btn-success" />
                            <input type="reset" value="Cancel" class="btn btn-danger" />
                            <input type="hidden" value="securityQestionTest" name="fn" />
                             <input type="hidden" value="<?php echo $_GET['email'];?>" name="email" />
                        </div>
                    </form>
                    
                    
                </div>
            </div>
        </div>
        
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>

