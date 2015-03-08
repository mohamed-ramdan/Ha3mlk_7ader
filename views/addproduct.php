<html>
    <head>
        <title>Add Product</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
    </head>
    <body>
      <?php
        @session_start();
         if(!($_SESSION['logged']&&$_SESSION['isAdmin']))
            {    
                header("Location: ../views/login.php");

            }
   
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
                            
                            <div class="col-sm-5s">
                                <input class="" id="price" type="number" min="0" value="0" style="width: 100px;" name="price"  />EGP
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