<html>
    <head>
        <title>Security Qestion</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
    </head>
    <body>
        <br ><br >
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading"><h1>Answer The Security Qestion</h1></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="get" action="../controllers/AuthenticationController.php">
                        
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <label class="control-label col-sm-2" for="q">Your Question:</label>
                            <div class="col-sm-5"><input type="text" name="q" class="form-control " value="<?php if(isset($_GET['question'])){echo $_GET['question'];}?>" disabled /></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <label class="control-label col-sm-2" for="ans">Your Answer:</label>
                            <div class="col-sm-5"><input type="text" name="ans" class="form-control" placeholder="Enter your Answer" value="<?php $_GET['quest']?>"/></div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-5"></div>
                            <input type="submit" value="Save" class="btn btn-success" />
                            <input type="reset" value="Cancel" class="btn btn-danger" />
                            <input type="hidden" value="securityQuestion" name="fn" />
                        </div>
                    </form>
                    
                    <span <?php 
                    if(isset($_GET['tstrslt']))
                    {
                        if($_GET['tstrslt']=='invalid answer !!')
                        {
                            echo "style='color:red;'";
                        }
                        else 
                        {
                            echo "style='color:green;'";
                        }
                    }
                    
                    ?> > <?php
                    if(isset($_GET['tstrslt']))
                    {
                            if($_GET['tstrslt']=='invalid answer !!')
                        {
                            echo "invalid answer";
                        }
                        else
                        {
                            header('location: makeOrder.php');
                            //echo "valid answer";
                        }
                    }
                    ?></span>
                </div>
            </div>
        </div>
        
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>

