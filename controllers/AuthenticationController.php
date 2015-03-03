<?php
require_once '../models/ORM.php';
require_once '../models/Validation.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 //session_start();
//session already opended in validation.
    class Authenticate{
    /*
       function __autoload($classname) {
          $filename = $classname . ".php";
          include_once("../models/$filename");
       }
  */
    
     
    
        function  login(){
            var_dump($_POST); var_dump($_GET);
            $obj = ORM::getInstance();
            $email=$_POST['email']; 
            $password=$_POST['password'];
            $obj->setTable('user');
            $opOfQuery=$obj->select(" email = '$email' and password = md5($password) ");
            echo"o/p"; var_dump($opOfQuery); 

            if(count($opOfQuery)==1)
            {
                $_SESSION['logged']=1;
                $_SESSION['isAdmin']=$opOfQuery[0]['isAdmin'];
                $_SESSION['userName']=$opOfQuery[0]['name'];
                $_SESSION['picture']=$opOfQuery[0]['picture'];
            }  

        }
    
       function  register(){
          
            $obj = ORM::getInstance();
            //if($_SESSION['logged']&&$_SESSION['isAdmin'])
            //{
            var_dump($_POST);
            if($_POST)
            {  
                $rules = array(
			'name' => 'required',
			'email' => 'required|email|unique',
			'password' => 'required|matchvalues',
			'roomNumber' => 'required',
			'ext' => 'required',
                        'captcha' => 'required|match',
                        'passwordc'=>'required',
                        );
               
                $_SESSION['passwd']=$_POST["passwordc"];
                $validation = new Validation();
                $result = $validation->validate($_POST,$rules);
                $imgresult = $validation->validateimg($_FILES,'picture');
		
                //no error at all file and data
                
                
                if(count($validation->errors)==0 ){
                        var_dump($_POST);
                        $obj->setTable('room');
                        $room=$_POST["roomNumber"];
                        $op=$obj->select("roomNumber= '$room' ");
                        $_POST["roomNumber"]=$op[0]['id'];
                        $_POST["isAdmin"]=0;
                        $obj->setTable('user');
                        unset($_POST["passwordc"]);
                        unset($_POST["captcha"]);
                        $a=$obj->insert($_POST);
                        $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
                        $upfile="$DOCUMENT_ROOT/Ha3mlk_7ader/Ha3mlk_7ader/static/img/{$_POST['email']}_{$_FILES['picture']['name']}";
			$imgname = "{$_POST['email']}_{$_FILES['picture']['name']}";
                        
			if (is_uploaded_file($_FILES['picture']['tmp_name']))
			{
				if (!move_uploaded_file($_FILES['picture']['tmp_name'], $upfile))
				{
					echo 'Problem: Could not move file to destination directory';
					exit; 
				}
                        }        
			else
				{
					echo 'Problem: Possible file upload attack. Filename: ';
					echo $_FILES['picture']['name'];
                                        exit;
                                }
              }
               
               //save data with out file no file sent
               
               else if (count($validation->errors)==1 && $_FILES['picture']['error'] ==4 ){
                        unset($_POST["passwordc"]);
                        unset($_POST["captcha"]);
                        unset($_POST["picture"]);
                        $_POST["isAdmin"]=0;
                        $obj->setTable('user');
                        $a=$obj->insert($_POST);
                        var_dump($a);    
             }
               //data it self isnot valid
               else{
                    
                        if( $_FILES['picture']['error'] ==4){
				array_pop($validation->errors);
			}
			echo '<ul>';
			foreach ($validation->errors as $error) {
				echo '<li>' . $error . '</li>';
			}

			echo '</ul>';
			$nameVal=$_POST["name"];
			$emailVal=$_POST["email"];
			$roomVal=$_POST["roomNumber"];
                        $extVal=$_POST["ext"];
                        $pictureVal=$_POST["picture"];
		        $capVal=$_POST["captcha"];
                        
			$errors = implode("^",$validation->errors);
                        header("Location: ../views/adduser.php?nameVal={$nameVal}&emailVal={$emailVal}&capVal={$capVal}&extVal={$extVal}&roomVal={$roomVal}&pictureVal={$pictureVal}&errors={$errors}");    

               }
               
                    
            }
           // }    
        } 
        
       function getRooms(){
           $obj = ORM::getInstance();
           $obj->setTable('room');
           $op=$obj->select();
           return $op;
       } 
        
       function getUserWithEmail(){
           $obj = ORM::getInstance();
           $obj->setTable('user');
           $op=$obj->select("$fieldname = '$value' ");
           return $op;
       } 
        
    }
   

    $userAuth=new Authenticate();
    
    switch ($_GET["fn"])
    {
      case "login":  
        $userAuth->login();
        break;
      case "register":  
        $userAuth->register();
        break;
    
    }

