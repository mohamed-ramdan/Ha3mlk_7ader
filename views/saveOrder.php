<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once '../controllers/NormalUserController.php';
     @session_start();
         if(!($_SESSION['logged']))
            {    
                header("Location: ../views/login.php");

            }   
    // creatomg an object of the Admin Controller class to execute the necessary code for manual order page
    $varNormalUser = new NormalUserController();
    
