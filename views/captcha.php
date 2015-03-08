<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


  // Adapted for The Art of Web: www.the-art-of-web.com
  // Please acknowledge use of this code by including this header.
  @session_start();
  if(!($_SESSION['logged']&&$_SESSION['isAdmin']))
            {    
                header("Location: ../views/login.php");

            }
  // initialise image with dimensions of 120 x 30 pixels
  $image = @imagecreatetruecolor(120, 30) or die("Cannot Initialize new GD image stream");

  // set background to white and allocate drawing colours
  $background = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
  imagefill($image, 0, 0, $background);
  $linecolor = imagecolorallocate($image, 0xCC, 0xCC, 0xCC);
  $textcolor = imagecolorallocate($image, 0x33, 0x33, 0x33);

  // draw random lines on canvas
  for($i=0; $i < 6; $i++) {
    imagesetthickness($image, rand(1,3));
    imageline($image, 0, rand(0,30), 120, rand(0,30), $linecolor);
  }



  // add random digits to canvas
  $mynums = range(0, 9);
  $myart = range('a', 'z');
  $resultarr = array_merge($mynums, $myart);
  shuffle($resultarr);
  $digit = array_slice($resultarr, 0, 5);
  $mycounter=0;
  for($x = 15; $x <= 95; $x += 20) {
    imagechar($image, rand(3, 5), $x, rand(2, 14), $digit[$mycounter], $textcolor);
    $mycounter++;
  }

  // record digits in session variable
  $_SESSION['digit'] = implode($digit);
  // display image and clean up
  header('Content-type: image/png');
  imagepng($image);
  imagedestroy($image);
?>