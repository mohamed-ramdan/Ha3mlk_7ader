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
                        <div class="col-sm-10" >
                            <select class="form-control" id="selecteduser">
                                <?php
                                    include_once '../controllers/AdminController.php';
                                    $thisAdminVar = new AdminController();
                                    $users = $thisAdminVar->getAllUsers();
                                    foreach ($users as $usr) 
                                    {
                                        $userName = $usr['username'];
                                        $usrId = $usr['userID'];
                                        echo "<option id='$usrId'>".$userName."</option>";
                                    }
                                ?>
                            </select>                      
                        </div>
                    </div>
                
                    
                    
                    <br /><br />
                    
                    
                    <div class="container col-sm-10" id="accParent">
                        <div class="panel panel-default" >
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
                                    echo "<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='false'>";
                                    $counter = $counterr = 0;
                                    foreach ($users as $usr) 
                                    {
                                        $counter = $counterr +=1;
                                        echo "<tr id='row$usrId'>";
                                        echo "<td>"
                                                . "<div class='panel panel-primary'>"
                                                . "<div class='panel-heading' role='tab' id='headingOne'>"
                                                . "<h4 class='panel-title'>"
                                                . "<a data-toggle='collapse' data-parent='#accordion' href='#a$counter' aria-expanded='false' aria-controls='a$counter'>See Orders</a></h4></div>"
                                                . "<div id='a$counter' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='headingOne'><div class='panel-body'>"
                                                . "<div class='panel panel-default'>"
                                                . "<div class='panel-heading' role='tab' id='headingTwo'>"
                                                . "<h4 class='panel-title'>"
                                                . "<a data-toggle='collapse' data-parent='' href='#b$counterr' aria-expanded='false' aria-controls='b$counterr'>See Order`s Products</a></h4></div>"
                                                . "<div id='b$counterr' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='headingTwo'><div class='panel-body'>"
                                                . "see more"
                                                . "</div></div></div>"
                                                . "</div></div></div>"
                                                . "</td>";
                                        
                                        $userName = $usr['username'];
                                        
                                        echo "<td>".$userName."</td>";
                                        echo "<td>"."100"."</td>";
                                        echo "</tr>";
                                    }
                                    echo "</div>";
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
                    var selectedUser =document.getElementById('selecteduser');
                    var row = document.getElementById('accordion');
                   
                    selectedUser.onchange=function()
                    {
                        // remove the exist data
                        document.getElementById('accParent').parentNode.removeChild(document.getElementById('accParent'));

                        //retrieve selected user data through ajax
                        ajaxRequest = new XMLHttpRequest();
                        function ajax(url)
                        {
                            // create ajax request and send it 
                            ajaxRequest.open("GET","../controllers/AdminController.php?"+url, true);
                            ajaxRequest.send();
                        }


                        // when the request is recieved get the response & draw new elements that contain response data
                        ajaxRequest.onreadystatechange = function()
                        {

                            if(ajaxRequest.readyState ===4 && ajaxRequest.status===200)
                            {
                                // the actual response text
                                result = ajaxRequest.responseText;


                                // create element collapse with ajax data     
                                var mainContainerDiv = document.createElement('div');
                                mainContainerDiv.setAttribute('class','container col-sm-10');
                                mainContainerDiv.setAttribute('id','accParent');

                                var panelDefaultDiv = document.createElement('div');
                                panelDefaultDiv.setAttribute('class','panel panel-default');

                                var panelBodyDiv = document.createElement('div');
                                panelBodyDiv.setAttribute('class','panel-body');

                                var table = document.createElement('table');
                                table.setAttribute('class','table table-responsive table-striped');

                                var tableRow = document.createElement('tr');

                                var tableHeadOne =document.createElement('th');
                                tableHeadOne.setAttribute('style','color:#1569C7');
                                tableHeadOne.innerHTML='Setting';

                                var tableHeadTwo =document.createElement('th');
                                tableHeadTwo.setAttribute('style','color:#1569C7');
                                tableHeadTwo.innerHTML='Name';

                                var tableHeadThree =document.createElement('th');
                                tableHeadThree.setAttribute('style','color:#1569C7');
                                tableHeadThree.innerHTML='Total Amount';        

                                //append table rows and table heading to table element
                                tableRow.appendChild(tableHeadOne);
                                tableRow.appendChild(tableHeadTwo);
                                table.appendChild(tableRow);

                                // the inner container div (the removed div on change event fire)
                                var container = document.createElement('div');
                                container.setAttribute('class','panel-group');
                                container.setAttribute('id','accordion');
                                container.setAttribute('role','tablist');
                                container.setAttribute('aria-multiselectable','false');

                                //append that div to the main div container
                                mainContainerDiv.appendChild(container);

                                //append every thing to body
                                document.body.appendChild(mainContainerDiv);

                                /* hena hankmlk rasm men awel line 73 ya 7lawa */











                            }
                    };    

                         var url = "userid=1&fn=getChecksNeededData";
                         ajax(url);   











                    };
                
                </script>
        
        
        
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../static/js/bootstrap.min.js" type="text/javascript"></script>
    </body>
</html>