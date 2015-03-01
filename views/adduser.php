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
                     <img alt="Brand" src="../static/img/2.jpeg"  style="width: 50px;height: 50px;float:right;margin-right: 15px;">
                 </a> 
                <a href="#" style="margin-right: 20px;">Admin</a>
                
            </div>
            <div class="container">
                <ul class="nav navbar-nav">
                    <li><a>Home</a></li>
                    <li><a>Products</a></li>
                    <li><a>Users</a></li>
                    <li><a>Manual Orders</a></li>
                    <li><a>Checks</a></li>
                    
                    
                    
                </ul>
            </div>
        </nav>
        
        
        
        <br /><br /><br /><br />
            <div class="container">
                <div class="container">
                    <div class="container">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h1>Add User</h1>
                            </div>
                            <div class="panel-body">
                                
                                <form class="form-horizontal">
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="name" class="col-sm-2 control-label">Name</label>
                                      <div class="col-sm-5">
                                          <input type="text" class="form-control" name="name" placeholder="Name">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="email" class="col-sm-2 control-label">Email</label>
                                      <div class="col-sm-5">
                                          <input type="email" class="form-control" name="email" placeholder="Email">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="password" class="col-sm-2 control-label">Password</label>
                                      <div class="col-sm-5">
                                          <input type="password" class="form-control" name="password" placeholder="Password">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="passwordc" class="col-sm-2 control-label">Confirm Password</label>
                                      <div class="col-sm-5">
                                          <input type="password" class="form-control" name="passwordc" placeholder="Password">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="room" class="col-sm-2 control-label">Room No.</label>
                                      <div class="col-sm-5">
                                          <input type="text" class="form-control" name="room" placeholder="Room Number">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="ext" class="col-sm-2 control-label">EXT.</label>
                                      <div class="col-sm-5">
                                          <input type="text" class="form-control" name="ext" placeholder="Tel Number">
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <label for="pic" class="col-sm-2 control-label">Profile Picture</label>
                                      <div class="col-sm-5">
                                          <input type="file" class="form-control" name="pic" >
                                      </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <div class="col-sm-2"></div>
                                      <div class="col-sm-offset-2 col-sm-5">
                                          <button type="submit" class="btn btn-success" style="width: 220px;">Save</button>
                                          
                                          <button type="reset" class="btn btn-danger" style="width: 220px;">Cancel</button>
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