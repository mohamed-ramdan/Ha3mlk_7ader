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
                                <input class="btn btn-success " id="save" type="button"  name="save" value="Save"/>
                                
                                <input class=" btn btn-danger" id="cancel" type="reset"  name="cancel" value="Cancel"/>
                            </div>
                        </div><!--form group-->
                        
                        
                        <input type="hidden" id="fn" name="fn"  value="saveNewCategory"/>
                                 </form>
                </div><!--panel body-->
            </div><!--panel default-->
            
            
        </div><!--container-->
        <script>
        // Script to provide the logic of the ajax request and the listener for the confirm button 
        
        //create an ajax XML Http Request 
        ajaxRequest = new XMLHttpRequest();
        
    
        // the function that will open and send the ajax requst to the intended backend page
        // params:      url: the whole data from the input fields put together and ready to append to the  url of the request
        // this function will be called by the confirmBtn listener
        function ajax(url){
                // the first parameter is whether the request method is POST OR Ger
                // the second parameter is the the actual url
                // the third parameter is the type of ajax request , Asyncrounous or        usually always true
                ajaxRequest.open("GET","../controllers/AdminController.php?" + url, true);
                
                // send the request.. remember we sent the data in the url
                ajaxRequest.send();
        }
        
        // onlick action listener for the ajax request
        // it's useful because through it we can control what to do when the request come back to the client with a response 
        ajaxRequest.onreadystatechange = function(){    
                        // readyState = 4  means the request is done and came back to the client
                        // 200 means the server and file were successufly found
                        if(ajaxRequest.readyState ===4 && ajaxRequest.status===200){
                                // the actual response text
                                id = ajaxRequest.responseText;
                                console.log(ajaxRequest.responseText);
                              
                        }
        };
    
        // get the confirm button and put an action listener on it
        document.getElementById("save").onclick = function(){

            // get the value from the input fields     
            var category = document.getElementById("category").value;
            
           

            // making the url sent in the ajax get request ready
            var url = "fn=saveNewCategory&";
            url += "category="+category;

            //openinh php tags to append the quantitiy of each product to the url
            var arr = [];
            // call the ajax javascript function
            ajax(url);
            
            
            /// HERE Starts the websocket
                //conn.send(JSON.stringify(order));
            
            //// Here ENds the web socket
            
        }
        
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>