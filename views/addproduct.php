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
                    <h1>Add Product</h1>
                </div><!--panel heading-->
                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="post" action="../controllers/AdminController.php?fn=saveNewProduct">
                        <div class="form-group">
                            
                            <label for="product" class="col-sm-2 control-label">Product:</label>
                            
                            <div class="col-sm-5">
                                <input class="form-control" id="product" type="text" placeholder="Insert Product Name" name="product" />
                            </div>
                        </div><!--form group-->
                        
                        
                        <div class="form-group">
                            
                            <label for="price" class="col-sm-2 control-label">Price:</label>
                            
                            <div class="col-sm-5">
                                <input class="form-control" id="price" type="number" style="width: 100px;" name="price" />
                            </div>
                        </div><!--form group-->
                        
                        
                        
                        <div class="form-group">
                            
                            <label for="category" class="col-sm-2 control-label">Category:</label>
                            
                            <div class="col-sm-5">
                                <?php
                                    require_once '../controllers/AdminController.php';
                                    $adminVar = new AdminController();
                                    $result = $adminVar->getAllCategories();
                                    if(!empty($result))
                                    {                                       
                                        echo "<select class='form-control' type='number' id='category' name='category'>";
                                        echo "<option> -- choose category -- </option>";
                                            foreach ($result as $cat)
                                            {
                                                $categoryName = $cat['categoryName'];
                                                echo "<option>".$categoryName."</option>";
                                            }
                                        
                                        echo "</select>";
                                    }                                
                                ?>  
                            </div>
                            <a href="addcategory.php">Add Category</a>
                        </div><!--form group-->
                        
                        
                        
                        
                        <div class="form-group">
                            
                            <label for="pic" class="col-sm-2 control-label">Product Picture:</label>
                            
                            <div class="col-sm-5">
                                
                                <input type="file"  name="pic" class="form-control" />
                                     
                            </div>
                        </div><!--form group-->
                        
                        
                        <div class="form-group">
                            
                            <div class="col-sm-3"></div>
                            <input type="submit" value="Save" id="save" class="btn btn-success " />  
                            
                                &nbsp; &nbsp; &nbsp;
                            <input type="reset" value="Cancel" class="btn btn-danger" /> 
                            
                        </div><!--form group-->
                        
                       <?php
                                        if(isset($_GET['errors'])){
                                                $errorarr = explode('^', $_GET['errors']);
                                                foreach ($errorarr as $error) {
                                                        echo "<br/><font color='red'>".$error."</font>";
                                                }
                                        }
	                ?> 
                        
                        
                    </form>
                </div><!--panel body-->
            </div><!--panel default-->
            
            
        </div><!--container-->
        
        
        
        <script>
            ajaxRequest = new XMLHttpRequest();
            function ajax(url)
            {
                ajaxRequest.open("GET","../controllers/AdminController.php?" + url, true);
                ajaxRequest.send();
            }
            
            ajaxRequest.onreadystatechange = function()
                {
                    if(ajaxRequest.readyState ===4 && ajaxRequest.status===200)
                    {
                        xmlHttp = ajaxRequest.responseText;
                    }
                };
                
            document.getElementById('save').onclick()
            {
                var productName = document.getElementById('product').value;
                var productPrice =  document.getElementById("price").value;
                var productCategory =  document.getElementById("category").value;
                var productPic =  document.getElementById("pic").value;
                
                var url = "";
                url = "fn=saveNewProduct&productName="+productName+"&productPrice="+productPrice+"&productCategory="+productCategory+"&productPic"+productPic;

           
                ajax(url);
                
            }
        
        </script>
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>