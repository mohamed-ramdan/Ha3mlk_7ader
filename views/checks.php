<html>
    <head>
        <title>checks</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../static/css/bootstrap.min.css" />
    </head>
    <body>
        <?php $dt = new DateTime(); echo $dt->format('Y-m-d h-i-sa'); ?>
        
        
        
        <br /> <br />
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h1>Checks</h1>
                </div><!--panel heading-->
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-5">Date From: <input class="form-control" type="date" value="<?php $dt = new DateTime(); echo $dt->format('Y-m-d'); ?>" name="datefrom" /></div>
                        <div class="col-sm-5">Date To: <input class="form-control" type="date" value="<?php $dt = new DateTime(); echo $dt->format('Y-m-d'); ?>" name="dateto" /></div>
                    </div>
                    
                    <br /><br /><br />
                    
                    
                    <div class="form-group">
                        <div class="col-sm-10">
                            <select class="form-control">
                                <?php
                                    include_once '../controllers/AdminController.php';
                                    $thisAdminVar = new AdminController();
                                    $users = $thisAdminVar->getAllUsers();
                                    foreach ($users as $usr) 
                                    {
                                        $userName = $usr['username'];
                                        echo "<option>".$userName."</option>";
                                    }
                                ?>
                            </select>                      
                        </div>
                    </div>
                
                    
                    
                    <br /><br />
                    
                    
                    <div class="container col-sm-10">
                        <div class="panel panel-default">
                        <div class="panel-body">
                    <table class="table table-responsive table-striped ">
                        <tr>
                             <th style="color: #1569C7;">
                                Setting
                            </th>
                            <th style="color: #1569C7;">
                                Name
                            </th>
                            <th style="color: #1569C7;">
                                Total Amount
                            </th>   
                            
                        </tr>
                        <?php
                         include_once '../controllers/AdminController.php';
                                    $thisAdminVar = new AdminController();
                                    $users = $thisAdminVar->getAllUsers();
                                    foreach ($users as $usr) 
                                    {
                                        echo "<tr>";
                                        echo "<td><button class='btn btn-success' id='expand'>+</button>&nbsp;<button id='minimize' class='btn btn-danger'>-</button></td>";
                                        
                                        $userName = $usr['username'];
                                        
                                        echo "<td>".$userName."</td>";
                                        echo "<td>"."100"."</td>";
                                        echo "</tr>";
                                    }
                            
                        ?>
                    </table>
                        </div><!--panel body-->
                        </div><!--panel default-->
                    </div><!--inner container-->
                </div><!--panel body-->
        
                
                <div class="panel panel-default">
                <div id="orderproduct">
                    
                </div>
                </div>
                
                <script>
                    var expandBtn = document.getElementById('expand');
                    var minimizeBtn = document.getElementById('minimize');
                    var orderProductDiv = document.getElementById('orderproduct');
                    var miniBtn = document.getElementById('minimize');
                    // add action listener to expand button
                    expandBtn.onclick=function()
                    {
                        //orderProductDiv.setAttribute('hidden','false');
                        var tbl = document.createElement('table');
                        orderProductDiv.setAttribute('class','panel-body');
                        tbl.setAttribute('class','table table-responsive table-striped');
                        var tbdy = document.createElement('tbody');
                        for(i=0;i<5;i++)
                        {
                            var tr = document.createElement('tr');
                             for(var j=0;j<2;j++)
                             {
                                 
                                
                                    var td=document.createElement('td');
                                    td.appendChild(document.createTextNode('test test'))
                                    
                                    tr.appendChild(td)
                                
                             }
                             tbdy.appendChild(tr);
                          }
                          tbl.appendChild(tbdy);
                          orderProductDiv.appendChild(tbl);
                        
                    };
                    
                    miniBtn.onclick=function()
                    {
                        orderProductDiv.setAttribute('hidden','true');
                    };
                
                </script>
        
        
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>