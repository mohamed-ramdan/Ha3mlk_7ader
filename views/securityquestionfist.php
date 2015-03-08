<html>
    <head>
        <title>Password Recovery</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
    </head>
    <body>
        <br ><br >
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading"><h1>Password Recovery </h1></div>
                <div class="panel-body">
                    <form class="form-horizontal" method="get" action="../controllers/AuthenticationController.php?fn=getSecurityQuestion">
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <label class="control-label col-sm-2" for="mail">Email:</label>
                            <div class="col-sm-5"><input type="text" name="mail" class="form-control panel-success"  placeholder="Enter your Email" /></div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-5"></div>
                            <input type="submit" value="Next" class="btn btn-success" />
                            <input type="hidden" name="fn" value="getSecurityQuestion" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>



