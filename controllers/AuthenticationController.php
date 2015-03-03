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
            
            $obj = ORM::getInstance();
            $email=$_POST['email']; 
            $password=$_POST['password'];
            $obj->setTable('user');
            $opOfQuery=$obj->select(" email = '$email' and password = md5($password) ");
             

            if(count($opOfQuery)==1)
            {
                $_SESSION['logged']=1;
                $_SESSION['isAdmin']=$opOfQuery[0]['isAdmin'];
                $_SESSION['userName']=$opOfQuery[0]['name'];
                $_SESSION['picture']=$opOfQuery[0]['picture'];
            }  

        }
    
        function  logout(){
             //if($_SESSION['logged']&&$_SESSION['isAdmin'])
            //{
            
                $_SESSION[]=array();
                
             //}

        }
        
       function  register(){
          
            $obj = ORM::getInstance();
            //if($_SESSION['logged']&&$_SESSION['isAdmin'])
            //{
            
            if($_POST)
            {  
                
                //server side validation
                $rules = array(
			'name' => 'required',
			'email' => 'required|email|unique',
			'password' => 'required|matchvalues',
			'roomNumber' => 'required',
			'ext' => 'required',
                        'captcha' => 'required|match',
                        'passwordc'=>'required',
                        );
                //send the data in session to compare with in validation
                $_SESSION['passwd']=$_POST["passwordc"];
                $validation = new Validation();
                $result = $validation->validate($_POST,$rules);
                $imgresult = $validation->validateimg($_FILES,'picture');
		
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
                        $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
                        $upfile="$DOCUMENT_ROOT/Ha3mlk_7ader/Ha3mlk_7ader/static/img/{$_POST['email']}_{$_FILES['picture']['name']}";
			$imgname = "{$_POST['email']}_{$_FILES['picture']['name']}";
                        //save image
			$_POST["picture"]=$upfile;
                        //insert in database
                        $a=$obj->insert($_POST);
                        if (is_uploaded_file($_FILES['picture']['tmp_name']))
			{
                                //save image from tmp to thier place
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
                        $a=$obj->insert($_POST);
                            
             }
               //data it self isnot valid
               else{
                        //file isnot uploaded    
                        if( $_FILES['picture']['error'] ==4){
				array_pop($validation->errors);
			}
			echo '<ul>';
                        //get all errors
			foreach ($validation->errors as $error) {
				echo '<li>' . $error . '</li>';
			}

			echo '</ul>';
                        
			$nameVal=$_POST["name"];
			$emailVal=$_POST["email"];
			$roomVal=$_POST["roomNumber"];
                        $extVal=$_POST["ext"];
                        
		        
                        
                        
			$errors = implode("^",$validation->errors);
                        header("Location: ../views/adduser.php?nameVal={$nameVal}&emailVal={$emailVal}&extVal={$extVal}&roomVal={$roomVal}&errors={$errors}");    

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
        
       function getUserWithEmail($value,$fieldname){
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

