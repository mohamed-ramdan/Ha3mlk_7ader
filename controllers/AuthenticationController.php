<?php
require_once '../models/ORM.php';
require_once '../models/Validation.php';



//session already opended in validation.
    class Authenticate{
    /*
       function __autoload($classname) {
          $filename = $classname . ".php";
          include_once("../models/$filename");
       }
  */
    
     
        function clean($string) {
            $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

            return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        }
        function  login(){
            
            $obj = ORM::getInstance();
            $email=$_POST['email']; 
            $password=$_POST['password'];
            $obj->setTable('user');
            $opOfQuery=$obj->select(" email = '$email' and password = md5('$password') ");
             

            if(count($opOfQuery)==1)
            {
                
                $_SESSION['logged']=1;
                $_SESSION['isAdmin']=$opOfQuery[0]['isAdmin'];
                $_SESSION['userID']=$opOfQuery[0]['userID'];
                $_SESSION['username']=$opOfQuery[0]['username'];
                $_SESSION['userPicture']=$opOfQuery[0]['userPicture'];

                $_SESSION['Ext']=$opOfQuery[0]['ext'];

                $_SESSION['ext']=$opOfQuery[0]['ext'];
                if($opOfQuery[0]['isAdmin']==0)
                {    
                 header("Location: ../views/makeOrder.php");
                }
                elseif($opOfQuery[0]['isAdmin']==1)
                {    
                 header("Location: ../views/unfinishedorders.php");
                }
            }
            else{
               header("Location: ../views/login.php?error='in valid email or password'"); 
                
            }
            
        }
    
        function  logout(){
            
             $_SESSION=array();
             header("Location: ../views/login.php"); 
        }
        
       function  register(){
          
            $obj = ORM::getInstance();
            
      
            if($_POST)
            {  
                
                //server side validation
                $rules = array(
			'username' => 'required',
			'email' => 'required|email|unique',
			'password' => 'required|matchvalues',
			'roomNumber' => 'required',
			'ext' => 'required',
                        'secretQuestion'=>'required',   
                        'secretAnswer'=>'required', 
                        'captcha' => 'required|match',
                        'passwordc'=>'required',
                        );
                //send the data in session to compare with in validation
                
                $_SESSION['passwd']=$_POST["passwordc"];
                $validation = new Validation();
                if($_GET["edit"]){
                    $rules['email']='required|email';
                }
               
                $result = $validation->validate($_POST,$rules);
                $imgresult = $validation->validateimg($_FILES,'userPicture');
		//no error at all file and data
                if(count($validation->errors)==0 ){
                        
                        //get room id of selected room
                        $obj->setTable('room');
                        $room=$_POST["roomNumber"];
                        $op=$obj->select("roomNumber= '$room' ");
                        $_POST["roomNumber"]=$op[0]['id'];
                        //set is admin to zero
                        $_POST["isAdmin"]=0;
                        $obj->setTable('user');
                        //remove from $_post
                        unset($_POST["passwordc"]);
                        unset($_POST["captcha"]);
                        $_POST["password"]=  md5($_POST["password"]);
                        $imgname = $this->clean("{$_POST['email']}_{$_FILES['userPicture']['name']}");
                        $upfile="../static/img/$imgname";
			
                        //save image
			$_POST["userPicture"]=$upfile;
                        //insert in database
                        
                        if(isset($_GET["edit"])){
                                $id=$_GET["id"];
                                $user=$obj->select("userID=$id");
                                $userEdited=$obj->update($_POST,"userID='$id'");
                                
                                if(isset($_FILES['userPicture'])){
                                    if($user[0]["userPicture"]!="../static/img/defaultuser.jpg"){
                                        unlink(trim($user[0]["userPicture"]));    
                                    }
                                    
                                    if (is_uploaded_file($_FILES['userPicture']['tmp_name']))
                                    {
                                            //save image from tmp to thier place
                                            if (!move_uploaded_file($_FILES['userPicture']['tmp_name'], $upfile))
                                            {
                                                    echo 'Problem: Could not move file to destination directory';
                                                    exit; 
                                            }
                                    } 


                                    else
                                        {
                                                echo 'Problem: Possible file upload attack. Filename: ';
                                                echo $_FILES['userPicture']['name'];
                                                exit;
                                        }
                                }
                                
                                
                               
                        }
                        else{
                                $a=$obj->insert($_POST);
                               
                                if (is_uploaded_file($_FILES['userPicture']['tmp_name']))
                                {
                                        //save image from tmp to thier place
                                        if (!move_uploaded_file($_FILES['userPicture']['tmp_name'], $upfile))
                                        {
                                                echo 'Problem: Could not move file to destination directory';
                                                exit; 
                                        }
                                } 


                                else
                                    {
                                            echo 'Problem: Possible file upload attack. Filename: ';
                                            echo $_FILES['userPicture']['name'];
                                            exit;
                                    }
                        }
                if($_SESSION['userID']==$_GET["id"]){
                    $id=$_GET["id"];
                    $opOfQuery=$obj->select(" userID= $id");
                    $_SESSION['userID']=$opOfQuery[0]['userID'];
                    $_SESSION['username']=$opOfQuery[0]['username'];
                    $_SESSION['userPicture']=$opOfQuery[0]['userPicture']; 

                }        
                        
                        
                if($_SESSION['isAdmin']==1)
                {    
                  header("Location: ../views/unfinishedorders.php");                  
                }
                else{
                  header("Location: ../views/makeOrder.php");   
                }
                
              }
              
               
               //save data with out file no file sent
               
               else if (count($validation->errors)==1 && $_FILES['userPicture']['error'] ==4 ){
                        
                        //get room id of selected room
                        $obj->setTable('room');
                        $room=$_POST["roomNumber"];
                        $op=$obj->select("roomNumber= '$room' ");
                        //get room id remove capcha and confirmpasswd make isadminto 0
                        $_POST["roomNumber"]=$op[0]['id'];
                        unset($_POST["passwordc"]);
                        unset($_POST["captcha"]);
                        $_POST["password"]=  md5($_POST["password"]);
                        $_POST["isAdmin"]=0;
                        $obj->setTable('user');
                        if (isset($_GET["edit"])){
                            if(!isset($_FILES['userPicture'])){
                                        rename($oldfile,$upfile);
                                    }
                            $id=$_GET["id"];
                            $user=$obj->select("userID=$id");
                            $oldfile=$user[0]["userPicture"];
                            $userEdited=$obj->update($_POST,"userID=$id");
                                        
                        }
                        else{
                        $a=$obj->insert($_POST);
                        }
               if($_SESSION['userID']==$_GET["id"]){
                    $id=$_GET["id"];
                    $opOfQuery=$obj->select(" userID= $id");
                    
                    $_SESSION['userID']=$opOfQuery[0]['userID'];
                    $_SESSION['username']=$opOfQuery[0]['username'];
                    $_SESSION['userPicture']=$opOfQuery[0]['userPicture']; 

                }          
                        
                        
               if($_SESSION['isAdmin']==1)
                {    
                  header("Location: ../views/unfinishedorders.php");                  
                }
                else{
                    
                    
                  header("Location: ../views/makeOrder.php");   
                }         
             }
               //data it self isnot valid
               else{
                        //file isnot uploaded    
                        if( $_FILES['userPicture']['error'] ==4){
				array_pop($validation->errors);
			}
			echo '<ul>';
                        //get all errors
			foreach ($validation->errors as $error) {
				echo '<li>' . $error . '</li>';
			}

			echo '</ul>';
                        
			$nameVal=$_POST["username"];
			$emailVal=$_POST["email"];
			$roomVal=$_POST["roomNumber"];
                        $extVal=$_POST["ext"];
                        $secretQuestionVal=$_POST["secretQuestion"];
                        $secretAnswerVal=$_POST["secretAnswer"];
                        $errors = implode("^",$validation->errors);
                        if(isset($_GET["edit"])){
                            $id=$_GET['id'];
                          if($_SESSION['isAdmin']==1)
                            {    
                               header("Location: ../views/profile.php?id=$id&edit=1&nameVal={$nameVal}&emailVal={$emailVal}&extVal={$extVal}&roomVal={$roomVal}&secretQuestionVal={$secretQuestionVal}&secretAnswerVal={$secretAnswerVal}&errors={$errors}");    

                            }
                            else{


                              header("Location: ../views/profileuser.php?id=$id&edit=1&nameVal={$nameVal}&emailVal={$emailVal}&extVal={$extVal}&roomVal={$roomVal}&secretQuestionVal={$secretQuestionVal}&secretAnswerVal={$secretAnswerVal}&errors={$errors}");    

                            }
                            
                       }
                        else{
                            header("Location: ../views/adduser.php?nameVal={$nameVal}&emailVal={$emailVal}&extVal={$extVal}&secretQuestionVal={$secretQuestionVal}&secretAnswerVal={$secretAnswerVal}&roomVal={$roomVal}&errors={$errors}");    
                        
                        }
               }
               
                    
            }
        
        } 
        
       function getRooms(){
           $obj = ORM::getInstance();
           $obj->setTable('room');
           $op=$obj->select();
           
           
          return $op;
     
       } 
       
       function getAllUsers(){
        
            $orm = ORM::getInstance();  
            $orm->setTable('user');
              // Retrieve all users
            $users = $orm->selectjoin(array('user','room')," user.roomNumber=room.id ");  
            return $users;  

       }
       
       
       function getUserWithEmail($value,$fieldname){
           $obj = ORM::getInstance();
           $obj->setTable('user');
           $op=$obj->select("$fieldname = '$value' ");
           return $op;
       } 
       function editUser(){
            $orm = ORM::getInstance();  
            $orm->setTable('user');
              // Retrieve all users
            $id=$_GET['id'];
            $user = $orm->select("userId='$id'");
        }
        function user($id){
            $orm = ORM::getInstance();  
            $orm->setTable('user');
            // Retrieve all users
            $user = $orm->select("userId='$id'");
           return $user[0];
        }
        
        
        
        function deleteUser(){
        
                $orm = ORM::getInstance();  
                $orm->setTable('user');
                  // Retrieve all users
                $id=$_GET['id'];
                $user = $orm->select("userId='$id'");
                if($user[0]["userPicture"]!="../static/img/defaultuser.jpg"){
                    unlink(trim($user[0]["userPicture"]));    
                }
                $user = $orm->delete("userId='$id'");  
                echo "$id" ;

                //header("Location: ../views/allusers.php");    

    }
      
    
    /**
     * securityQestionTest is a function that assure from security question 
     * in forgetting password cases. 
     * @author Mohamed Ramadan
     * @param  void 
     * @return int one if the answer was correct and zero if not.
     */
    function securityQestionTest()
    {
        // Get instance from ORM model
        $orm = ORM::getInstance(); 
        // Set table user for retrieve question answers
        
        $orm->setTable('user');
        $ans = $_GET['ans'];
        $mail= $_GET['email'];
        $q= $_GET['q'];
        
        $opOfQuery = $orm-> select("email='$mail' and secretAnswer= '$ans' ");
        
        if (count($opOfQuery))
            
        { 
                $_SESSION['logged']=1;
                $_SESSION['isAdmin']=$opOfQuery[0]['isAdmin'];
                $_SESSION['userID']=$opOfQuery[0]['userID'];
                $_SESSION['username']=$opOfQuery[0]['username'];
                $_SESSION['userPicture']=$opOfQuery[0]['userPicture'];
                $_SESSION['ext']=$opOfQuery[0]['ext'];
                if($opOfQuery[0]['isAdmin']==0)
                {    
                 header("Location: ../views/makeOrder.php");
                }
                elseif($opOfQuery[0]['isAdmin']==1)
                {    
                 header("Location: ../views/unfinishedorders.php");
                }
               
        }
            
      else{
            header("Location: ../views/securityquestion.php?email=$mail&error='not mattch'&question=$q");
       }
       
        
    }
    
    
    
    /**
     * getSecurityQuestion is a function that get the stored secret question 
     * for specific user
     * @author Mohamed Ramadan
     * @param void 
     * @return void the question as string to $_GET global array
     */
    function getSecurityQuestion()
    {
        
        // Get instance from ORM model
        $orm = ORM::getInstance(); 
        // Set table user for retrieve question answers
        $orm->setTable('user');
        $mail = $_GET['mail'];
        $_SESSION['check']=1;
        $result = $orm-> select("email='$mail'");
        //echo $result[0]['secretQuestion'];
        if(!empty($result))
        {
            $question = $result[0]['secretQuestion'];
            //return $question;
            header("location: ../views/securityquestion.php?question=$question&email=$mail");
        }
        
    }
       
        
    }
   

    $userAuth=new Authenticate();
    @session_start();
    if(isset($_GET["fn"])){
    switch ($_GET["fn"])
    {
      case "login":
         
        if(isset($_SESSION['logged'])){  
          
          header("Location: ../views/makeOrder.php");
        }
        else{
           
          $userAuth->login();  
        }
        
        break;
      
      case "logout": 
        if(isset($_SESSION['logged'])){ 
          $userAuth->logout();
          
        }
        else{
        header("Location: ../views/login.php");  
        }
        break;  
        
      case "register":
        if($_SESSION['logged']&&$_SESSION['isAdmin']||$_SESSION['logged']&&($_GET["id"]==$_SESSION["userID"]))
        {  
            $userAuth->register();
        }
        else{
            header("Location: ../views/login.php");
            
        }
            break;
      case "deleteUser": 
        if($_SESSION['logged']&&$_SESSION['isAdmin'])
        {
             $userAuth->deleteUser();
        } 
        else{
            header("Location: ../views/login.php");
        }
        break;
      
      case "securityQestionTest":
           if($_SESSION['check'])
             { $userAuth->securityQestionTest();}
           else{
               header("Location: ../views/login.php");
           }
          break;
       
      case "getSecurityQuestion":
          
          $userAuth->getSecurityQuestion();
          break;
    
    }

    }