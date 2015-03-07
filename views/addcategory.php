<html>
    <head>
        <title>Add Product</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
    </head>
    <body>
        
        
        <br /> <br />
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Add Category</h1>
                </div><!--panel heading-->
                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="get" action="../controllers/AdminController.php?fn=saveNewCategory">
                        <div class="form-group">
                            
                            <label for="category" class="col-sm-2 control-label">Category:</label>
                            
                            <div class="col-sm-5">
                                <input class="form-control" id="category" type="text" placeholder="Insert Categoy Name" name="category" />
                            </div>
                        </div><!--form group-->
                        
                        
                         <div class="form-group">
                            
                            <div  class="col-sm-2 control-label"></div>
                            
                            <div class="col-sm-7">
                                <input class="btn btn-success " id="save" type="submit"  name="save" value="Save"/>
                                
                                <input class=" btn btn-danger" id="cancel" type="reset"  name="cancel" value="Cancel"/>
                            </div>
                        </div><!--form group-->
                        
                        
                        
                                 </form>
                </div><!--panel body-->
            </div><!--panel default-->
            
            
        </div><!--container-->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>