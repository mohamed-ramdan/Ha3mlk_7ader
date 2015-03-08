<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
         
require_once '../controllers/AdminController.php';
        @session_start();
         if(!($_SESSION['logged']&&$_SESSION['isAdmin']))
            {    
                header("Location: ../views/login.php");

            }
        // creatomg an object of the Admin Controller class to execute the necessary code for manual order page
        $varAdmin = new AdminController();
        
        $varAdmin->saveManualOrder();
        